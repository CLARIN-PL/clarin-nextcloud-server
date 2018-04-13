<?php
/**
 * Created by PhpStorm.
 * User: wrauk
 * Date: 15.11.17
 * Time: 14:10
 */

namespace OCA\Clarin\Utils;


use OC\Files\Filesystem;

class Ws {
	static $url = 'http://ws.clarin-pl.eu/nlprest2/base/';
	static $uploadPath = 'upload/';
	static $startTaskPath = 'startTask/';
	static $downloadPath = 'download';
	static $statusPath = 'getStatus/';

	// https://github.com/CLARIN-PL/clarin-pl-dspace/blob/federation.key/dspace-rest/src/main/java/org/dspace/rest/ProcessItems.java
	static private $lpmnConvertToCCL = "|any2txt|wcrft2({\"morfeusz2\":false})|liner2({\"model\":\"all\"})|wsd|dir|shimext({\"ext\":\".ccl\"})|makezip";

	public static function uploadFilesToWs($files){
		// create curl multi
		$mh = curl_multi_init();

		// create curl resources
		$curlResources = [];
		foreach($files as $file ){
			$ch = curl_init();
			$fh = \OC\Files\Filesystem::fopen($file['path'].'/'.$file['name'], 'r');
			$fileContent = stream_get_contents($fh);

			curl_setopt_array($ch, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_POST => 1,
				CURLOPT_URL => self::$url . self::$uploadPath,
				CURLOPT_HTTPHEADER => array("Content-Type: binary/octet-stream"),
				CURLOPT_POSTFIELDS=> $fileContent
			));
			$curlResources[] = ['name' => $file['name'], 'resource' => $ch];
			curl_multi_add_handle($mh,$ch);
		}

		$running = null;
		do {
			curl_multi_exec($mh, $running);
		} while ($running);

		$result = [];
		//close the handles
		foreach($curlResources as $curlRes){
			curl_multi_remove_handle($mh, $curlRes['resource']);
			$result[] = ['name' => $curlRes['name'], 'id' => curl_multi_getcontent($curlRes['resource'])];
		}
		curl_multi_close($mh);

		return $result;
	}

	public static function startTaskCCLConvert($files, $userId){
		$ch = curl_init();

		$filesLpmn = 'files('.json_encode($files).')';

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_URL => self::$url.self::$startTaskPath,
			CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
			CURLOPT_POSTFIELDS=> json_encode(array(
				'application' => 'nextcloud',
				'lpmn' => $filesLpmn . self::$lpmnConvertToCCL,
				'user' => $userId
			))
		));

		$output = curl_exec ($ch);
		curl_close ($ch);
		return $output;
	}

	public static function getTaskStatus($taskId){
		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => self::$url.self::$statusPath.$taskId,
		));

		$output = curl_exec ($ch);
		curl_close ($ch);
		return json_decode($output, true);
//		return json_decode('{"value":0.5,"status":"PROCESSING"}', true);
	}

	private static function getFileContent($fileId){
		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => self::$url.self::$downloadPath.$fileId,
		));

		$output = curl_exec ($ch);
		curl_close ($ch);
		return $output;
	}

	public static function downloadFile($retValue, $fileName, $filePath, $userName){
		$destFolder = \OC::$server->getUserFolder($userName)->get($filePath);
		$cnt = 1;
		$systemFileName = $fileName.'.zip';
		while($destFolder->nodeExists($systemFileName)){
			$systemFileName= $fileName.'('.$cnt.  ').zip';
			$cnt++;
		}
		$newFile = $destFolder->newFile($systemFileName);

		$fileContent = self::getFileContent($retValue['value'][0]['fileID']);
		// check what is inside file content
		$newFile->putContent($fileContent);

		return $systemFileName;
	}

	public static function stubWait($taskId, $fileName, $filePath, $userName){
		while(true){
			$status = Ws::getTaskStatus($taskId);
			if($status['status'] == 'PROCESSING'){
				sleep(2);
			}
			else if($status['status'] == 'ERROR'){
				break;
			}
			else if($status['status'] == 'DONE'){
				return Ws::downloadFile($status, $fileName, $filePath, $userName);
				break;
			}
		}
	}
}