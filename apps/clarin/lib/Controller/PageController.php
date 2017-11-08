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
	private $dSpaceUserId = "dSpace";

	public function __construct($AppName, IRequest $request, $UserId){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
//	public function index() {
//		return new TemplateResponse('clarin', 'index');  // templates/index.php
//	}

	public function ccl() {
		return new DataResponse('Test');
	}

	/**
	* 	handle post request from files application
	*	allowing non admins to access the page
	*
	* @NoAdminRequired
	* @NoCSRFRequired
	*/
	public function exportToDspace(){
		$filesJson = $this->request->getParam('files');
		$files = json_decode($this->request->getParam('files'), true);

		return new TemplateResponse('clarin', 'exportDSpace', ['files' => $files, 'filesJson'=>$filesJson]);
	}

	/**
	 * 	handle post request
	 *	zip files provided in files filed => put them in dSpace user catalog
	 *  => share those files with user
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function zip(){
		$data = $this->request->getParam('data');
		$files = json_decode($data['files'], true);
		$zipName = $data['name'] . ".zip";

		$dSpaceHome = \OC::$server->getUserFolder($this->dSpaceUserId);
		$node = $dSpaceHome->newFolder('exported_by_users');

		// make sure filename is unique
		$cnt = 1;
		while($node->nodeExists($zipName)){
			$zipName= $data['name'].'_'.$cnt. ".zip";
			$cnt++;
		}
		// create new file in dSpace_user_dir/exported_by_users
		$file = $node->newFile($zipName);
		$absoluteZipFilePath = \OC::$server->getSystemConfig()->getValue("datadirectory").$file->getPath();

		// todo -- lock files
		$this->addFilesToZip($absoluteZipFilePath, \OC::$server->getUserFolder($this->userId)->getPath(), $files);

		// share folder with user
		$shareManager = \OC::$server->getShareManager();
		$share = $shareManager->newShare();
		$share->setNode($file)
			->setShareType(\OCP\Share::SHARE_TYPE_USER)
			->setSharedWith($this->userId)
			->setSharedBy($this->dSpaceUserId)
			->setPermissions(\OCP\Constants::PERMISSION_READ | \OCP\Constants::PERMISSION_SHARE);
		$shareManager->createShare($share);

		// create share link
		$share = $shareManager->newShare();
		$share->setNode($file)
			->setShareType(\OCP\Share::SHARE_TYPE_LINK)
			->setSharedBy($this->dSpaceUserId)
			->setPermissions(\OCP\Constants::PERMISSION_READ);
		$shareManager->createShare($share);

		// add comment to created file
		$commentManager = \OC::$server->getCommentsManager();
		$comment = $commentManager->create("dSpace service", $this->dSpaceUserId, "files", ''.$file->getId());
		$comment->setMessage("Link to file automatically created for dSpace service, you can safely delete it you don't need it. For help please contact Clarin-PL staff.");
		$comment->setVerb("comment");
		$commentManager->save($comment);

		$urlGenerator = \OC::$server->getURLGenerator();
		$response = [
			"success" => true,
			"link_zip" =>  $urlGenerator->getAbsoluteURL("index.php/s/" . $share->getToken()."/download")
		];
		return new JSONResponse($response);
	}

	private static function addFilesToZip($zipPath, $userHomePath, $files){

		$zip = new ZipCreator($userHomePath);

		if ($zip->open($zipPath,\ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE) != TRUE) {
			die ("Could not open archive");
		}
		$zip->addFiles($files);
		$zip->setArchiveComment('test comment');
		$zip->close();
	}



}
