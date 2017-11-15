<?php
/**
 * Created by PhpStorm.
 * User: wrauk
 * Date: 15.11.17
 * Time: 14:10
 */

namespace OCA\Clarin\Utils;


class Ws {
	static $url = "http://ws.clarin-pl.eu/nlprest2/base";
	static $uploadPath = '/upload/';
	static $downloadPath = '/download/';

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
				CURLOPT_URL => self::$url . '/upload/',
				CURLOPT_HTTPHEADER => array("Content-Type: binary/octet-stream"),
				CURLOPT_POSTFIELDS=> $fileContent
			));
			$curlResources[] = $ch;
			curl_multi_add_handle($mh,$ch);
		}

		$running = null;
		do {
			curl_multi_exec($mh, $running);
		} while ($running);

		$result = [];
		//close the handles
		foreach($curlResources as $curlRes){
			curl_multi_remove_handle($mh, $curlRes);
			$result[] = curl_multi_getcontent($curlRes);
		}
		curl_multi_close($mh);

		return $result;
	}
}