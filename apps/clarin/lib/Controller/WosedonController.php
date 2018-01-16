<?php
/**
 * Created by PhpStorm.
 * User: wrauk
 * Date: 15.01.18
 * Time: 13:37
 */
namespace OCA\Clarin\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCA\Clarin\Utils\DbUtil;


class WosedonController extends Controller{
	private $userId;
	private $pathToShareMount = "/public-dspace/nextcloud/wosedon/";
	private $wosedonActionPostUrl= "http://wosedon.clarin-pl.eu/make_freq_list";

	public function __construct($AppName, IRequest $request, $UserId) {
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
	}

	/**
	 * export selected zip file to wosedon
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function export(){
		$fileData = $this->request->getParam('file');

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

		return new JSONResponse(["form" => ["action" => $this->wosedonActionPostUrl, "token" => $this->pathToShareMount.$destFileName]]);
	}
}