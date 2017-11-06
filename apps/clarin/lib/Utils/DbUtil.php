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
}