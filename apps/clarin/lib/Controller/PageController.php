<?php
namespace OCA\Clarin\Controller;


use OCA\Clarin\Utils\Process;
use OCP\AppFramework\Http\IOutput;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCA\Clarin\Utils\ZipCreator;
use OCA\Clarin\Utils\Ws;
use OCA\Clarin\Utils\ThreadWaiter;
use Sabre\VObject\Parser\Json;

class PageController extends Controller {
	private $userId;
	private $dSpaceUserId = "dSpace";

	public function __construct($AppName, IRequest $request, $UserId){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
	}

	/**
	 * start observing what is going on in a separate thread
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function watchfile(){
		$taskId = $this->request->getParam('taskId');
		$resultFileName = $this->request->getParam('resultFileName');
		$destFolder = $this->request->getParam('destFolder');
		$userId = $this->request->getParam('userId');

		$finalFileName = Ws::stubWait($taskId, $resultFileName, $destFolder, $userId);
		return new JSONResponse(['taskId' => $taskId, 'fileName' => $finalFileName, 'destFolder' => $destFolder]);
	}

	/**
	 * convert user files to CCL format
	* @NoAdminRequired
	* @NoCSRFRequired
	*/
	public function ccl() {
		$files = json_decode($this->request->getParam('files'), true);
		$destFolder = json_decode($this->request->getParam('destFolder'), true);
		$resultFileName = json_decode($this->request->getParam('resultName'), true);

		// upload files to ws
		$wsFiles = Ws::uploadFilesToWs($files);

		// start ws task
		$taskId = Ws::startTaskCCLConvert($wsFiles, $this->userId);
//		$taskId = 'bdba65cc-5744-4187-b21d-0d627749e6c9'; // for debug
		$statusUrl = Ws::$url . Ws::$statusPath . $taskId;

		return new JSONResponse(['statusUrl' => $statusUrl,
			'watchParams' => [
				'taskId' => $taskId,
				'resultFileName' => $resultFileName,
				'destFolder' => $destFolder,
				'userId' => $this->userId
			],]);
	}

	/**
	* 	handle post request from files application
	*	allowing non admins to access the page
	*
	* @NoAdminRequired
	* @NoCSRFRequired
	*/
	public function exportToDspace(){
//		phpinfo();
//		die();
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

//		$fields = array_map()

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
			"link" =>  $urlZip,
			"form" => $formFields,
		];

		return new JSONResponse($response);
	}

	private static function addFilesToZip($zipPath, $userHomePath, $files){
		$zip = new ZipCreator();
		$zip->addFilesFromStream($files, $zipPath);
	}



}