<?php
namespace OCA\Clarin\Controller;

use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\AppFramework\Controller;
use OCA\Clarin\Utils\Ws;


class WsController extends Controller {
	private $userId;

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
}