<?php
namespace OCA\Clarin\Utils;


class ZipCreator extends \ZipArchive{
	private $srcDirAbsPath = null;

	public function __construct($srcDirPath) {
		$this->srcDirAbsPath = \OC::$server->getSystemConfig()->getValue("datadirectory").$srcDirPath;
	}

	public function addFiles($files){
		if (!$this->srcDirAbsPath)
			throw new \Exception('User absolute dir path not specified with initUserDir(...)');

		foreach ($files as $file) {
			$filename = $file['name'];
			$filePath = $file['path'] .'/'. $file['name'];
			if (\OC\Files\Filesystem::is_file($filePath)) {
				$this->addFile($this->srcDirAbsPath.$filePath, $filename);

			} elseif (\OC\Files\Filesystem::is_dir($filePath)) {
				$this->addDirRecursive($filePath);
			}
		}
	}

	private function addDirRecursive($dir, $internalDir=''){
		$dirname = basename($dir);
		$rootDir = $internalDir . $dirname;
		if (!empty($rootDir)) {
			$this->addEmptyDir($rootDir);
		}
		$internalDir .= $dirname . '/';
		// prevent absolute dirs
		$internalDir = ltrim($internalDir, '/');

		$files= \OC\Files\Filesystem::getDirectoryContent($dir);
		foreach($files as $file) {
			$filename = $file['name'];
			$filePath = $internalDir.$file['name'];// .'/'. $file['name'];
			if (\OC\Files\Filesystem::is_file($filePath)) {
				$this->addFile($this->srcDirAbsPath.'/'.$filePath, $internalDir.$filename);

			} elseif (\OC\Files\Filesystem::is_dir($filePath)) {
				$this->addDirRecursive($filePath, $internalDir);
			}
		}
	}
}