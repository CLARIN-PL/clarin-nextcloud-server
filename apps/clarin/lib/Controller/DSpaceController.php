<?php
namespace OCA\Clarin\Controller;


use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCA\Clarin\Utils\ZipCreator;


class DSpaceController extends Controller {
	private $userId;
	private $dSpaceUserId = "dSpace";

	public function __construct($AppName, IRequest $request, $UserId){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
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

	private function zipFiles($files, $zipName, $node){
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
		return $urlGenerator->getAbsoluteURL("index.php/s/" . $share->getToken()."/download");
	}

	/**
	 * 	handle post request
	 *	zip files provided in files filed => put them in dSpace user catalog
	 *  => share those files with user
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function	zipDSpace(){
		$data = $this->request->getParam('data');
		$files = json_decode($data['files'], true);
		$formFields = $data['formFields'];
		$zipName = $data['name'] . ".zip";

		// make sure filename is unique
		$dSpaceHome = \OC::$server->getUserFolder($this->dSpaceUserId);
		$node = $dSpaceHome->newFolder('exported_by_users');
		$cnt = 1;
		while($node->nodeExists($zipName)){
			$zipName= $data['name'].'_'.$cnt. ".zip";
			$cnt++;
		}

		$urlZip = $this->zipFiles($files, $zipName, $node);

		$response = [
			"item" => [
				"token" => $this->getUserClarinToken(),
				"filename" => $zipName,
				"link" =>  $urlZip,
				"metadata" => $formFields,
			]
		];

		return new JSONResponse($response);
	}

	private function getUserClarinToken(){
		return $this->request->getCookie("clarin-pl-token");
	}

	private static function addFilesToZip($zipPath, $userHomePath, $files){
		$zip = new ZipCreator();
		$zip->addFilesFromStream($files, $zipPath);
	}



}