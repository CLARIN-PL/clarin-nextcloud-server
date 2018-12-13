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
	 *
	 * @return JSONResponse
	 */
	public function watchfile(){
		$taskId = $this->request->getParam('taskId');
		$resultFileName = $this->request->getParam('resultFileName');
		$destFolder = $this->request->getParam('destFolder');
		$userId = $this->request->getParam('userId');
		$downloadedFileExtension = $this->request->getParam('outputFileExtension');

		$finalFileName = Ws::stubWait($taskId, $resultFileName, $destFolder, $userId, $downloadedFileExtension);
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
				'userId' => $this->userId,
				'outputFileExtension' => 'zip'
			],]);
	}

	public function exportWsTask(){
		$file = json_decode($this->request->getParam('file'), true);
		$wsToolName = json_decode($this->request->getParam('toolName'), true);

//		$wsToolName = 'summarize';
		$file = 'http%3A%2F%2Fws1-clarind.esc.rzg.mpg.de%2Fdrop-off%2Fstorage%2F1515072187261.txt';
		$wsLink = 'http://ws.clarin-pl.eu/'.$wsToolName.'.shtml?weblicht-file='.$file;

		return new JSONResponse([
			'link' => $wsLink
		]);
	}

	/**
	 * perform speech recognition for user audio files mp3 or wav
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function speechRecognition(){
		$file = json_decode($this->request->getParam('file'), true);
		$destFolder = json_decode($this->request->getParam('destFolder'), true);
		$resultFileName = json_decode($this->request->getParam('resultName'), true);
		$mimeType = json_decode($this->request->getParam('inputFileMimeType'), true);

		// upload files to ws
		$wsFiles = Ws::uploadFilesToWs($file);

		// start ws task
//		$taskId = Ws::startTaskCCLConvert($wsFiles, $this->userId);
		$taskId = Ws::startTaskSpeechRecognition($wsFiles[0], $this->userId, $mimeType);
//		$taskId = 'bdba65cc-5744-4187-b21d-0d627749e6c9'; // for debug
		$statusUrl = Ws::$url . Ws::$statusPath . $taskId;

		return new JSONResponse(['statusUrl' => $statusUrl,
			'watchParams' => [
				'taskId' => $taskId,
				'resultFileName' => $resultFileName,
				'destFolder' => $destFolder,
				'userId' => $this->userId,
				'outputFileExtension' => 'txt'
			],]);
	}
}