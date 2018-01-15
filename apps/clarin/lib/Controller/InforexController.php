<?php
namespace OCA\Clarin\Controller;

use OCA\Clarin\Utils\DbUtil;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\AppFramework\Controller;


class InforexController extends Controller {
	private $userId;
	private $pathToShareMount = "/public-dspace/nextcloud/";
	private $inforexUrl = "http://inforex-dev.clarin-pl.eu/inforex_svn/index.php";

	public function __construct($AppName, IRequest $request, $UserId) {
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
	}

	/**
	 * export selected zip file to inforex
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function export(){
		$fileData = $this->request->getParam('file');
		$corpName = $this->request->getParam('corpusName');
		$corpDesc = $this->request->getParam('corpusDesc');

		$fileOwnerId = $this->userId;
		if($fileData['shareOwner'] != ""){
			$fileOwnerId = $fileData['shareOwner'];
		}
		$userManager = \OC::$server->getUserManager();
		$fileOwner = $userManager->get($fileOwnerId);
		$fileOwnerPath = $fileOwner->getHome();

		$filePath = DbUtil::getFilePath($fileData['id']);

		// checking if file exists
		$destFileName = $fileData['id'].'_'.$fileData['name'];
		$i=1;
		while (file_exists($this->pathToShareMount.$destFileName)){
			$destFileName = $fileData['id'].'('.$i.')_'.$fileData['name'];
			$i++;
		}

		$success = \copy($fileOwnerPath.'/'.$filePath, $this->pathToShareMount.$destFileName);
		if(!$success)
			return new DataResponse("error while copying file", 406);

		$retVal = json_decode($this->informInforex($destFileName, $corpName, $corpDesc, $this->userId));
		$error = property_exists($retVal, "error");
		if($error){
			return new JSONResponse(["error" => $retVal->error], 406);
		}

		return new JSONResponse(["url" => $retVal->redirect, "filename"=> $fileData['name']]);
	}

	public function informInforex($filename, $corpName, $corpDesc, $userId){
		$ch = curl_init();

		$tempRootSharedDir = '/public-dspace/';

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_URL => $this->inforexUrl,
			CURLOPT_POSTFIELDS=> array(
				'ajax' => 'nextcloud_import',
				'email' => $userId,
				'name' => $corpName,
				'path' => $tempRootSharedDir.'nextcloud/'.$filename,
				'description' => $corpDesc
			)
		));

		$output = curl_exec ($ch);
		curl_close ($ch);
		return $output;
	}
}