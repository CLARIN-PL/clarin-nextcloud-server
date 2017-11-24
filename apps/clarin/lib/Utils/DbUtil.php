<?php
/**
 * Created by PhpStorm.
 * User: wrauk
 * Date: 06.11.17
 * Time: 14:10
 */

namespace OCA\Clarin\Utils;


class DbUtil {
	public static function setFilePermissions($fileId, $permissions){
		$query = \OC::$server->getDatabaseConnection()->getQueryBuilder();
		$query->update("filecache")
			->set("permissions", $query->createNamedParameter($permissions))
			->where($query->expr()->eq('fileid', $query->createNamedParameter($fileId)));
		$query->execute();
	}

	public static function getFilePath($fileId){
		$query = \OC::$server->getDatabaseConnection()->getQueryBuilder();
		$query->select("path")
			->from("filecache")
			->where($query->expr()->eq('fileid', $query->createNamedParameter($fileId)));
		$query->execute();
		$result = $query->execute()->fetch();

		return $result["path"];
	}
}