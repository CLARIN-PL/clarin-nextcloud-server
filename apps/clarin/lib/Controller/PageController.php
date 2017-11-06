<?php
namespace OCA\Clarin\Controller;

use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCA\Clarin\Utils\ZipCreator;
use OCA\Clarin\Utils\DbUtil;


class PageController extends Controller {
	private $userId;

	public function __construct($AppName, IRequest $request, $UserId){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		return new TemplateResponse('clarin', 'index');  // templates/index.php
	}

	public function ccl() {
		return new DataResponse('Test');
	}

	/**
	* 	handle post request from files application
	*allowing non admins to access the page
	*
	* @NoAdminRequired
	* @NoCSRFRequired
	*/
	public function files(){
		$filesJson = $this->request->getParam('files');
		$files = json_decode($this->request->getParam('files'), true);

		return new TemplateResponse('clarin', 'files', ['files' => $files, 'filesJson'=>$filesJson]);
	}

	/**
	 * 	handle post request from files application
	 *allowing non admins to access the page
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function zip(){
		$data = $this->request->getParam('data');
		$files = json_decode($data['files'], true);
		$zipName = $data['name'] . ".zip";

		$userId = $this->userId;
		$userHome = \OC::$server->getUserFolder($userId);
		$node = $userHome->newFolder('exported to dSpace');

		// make sure filename is unique
		$cnt = 1;
		while($node->nodeExists($zipName)){
			$zipName= $data['name'].'_'.$cnt. ".zip";
			$cnt++;
		}
		$file = $node->newFile($zipName);

		$absoluteZipFilePath = \OC::$server->getSystemConfig()->getValue("datadirectory").$file->getPath();

		// todo -- lock files
		$this->addFilesToZip($absoluteZipFilePath, $userHome->getPath(), $files);



		$shareManager = \OC::$server->getShareManager();
		$share = $shareManager->newShare();
		$share->setNode($file)
			->setShareType(\OCP\Share::SHARE_TYPE_USER)
			->setSharedWith('admin')
			->setSharedBy($userId)
			->setPermissions(\OCP\Constants::PERMISSION_READ);
		$shareManager->createShare($share);

		DbUtil::setFilePermissions($file->getId(), \OCP\Constants::PERMISSION_READ | \OCP\Constants::PERMISSION_SHARE);
		return new JSONResponse('{"success": true}');
	}

	private static function addFilesToZip($zipPath, $userHomePath, $files){

		$zip = new ZipCreator($userHomePath);
		// detete first
		if ($zip->open($zipPath,\ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE) != TRUE) {
			die ("Could not open archive");
		}
		$zip->addFiles($files);
		$zip->setArchiveComment('test comment');
		$zip->close();
	}



}
