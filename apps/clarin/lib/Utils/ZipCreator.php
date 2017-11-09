<?php
namespace OCA\Clarin\Utils;

class ZipCreator{

	public function addFilesFromStream($files, $zipPath){
		$dir = $files[0]["path"];
		$files = array_map(function ($it){
			return $it['name'];
		}, $files);
		$zipFile = fopen($zipPath, 'w');
		$this->addFiles($dir, $files, null, true, $zipFile);
		fclose($zipFile);
		return;
	}

	public static function addFiles($dir, $files, $params = null, $tozip = false, $file) {
		$view = \OC\Files\Filesystem::getView();
		$filename = $dir;
		try {

			$getType = \OC_Files::ZIP_FILES;
			$basename = basename($dir);
			if ($basename) {
				$name = $basename;
			}
			$filename = $dir . '/' . $name;

			$streamer = new \OC\Streamer($file);

			\OC_Files::lockFiles($view, $dir, $files);

			$executionTime = intval(\OC::$server->getIniWrapper()->getNumeric('max_execution_time'));
			set_time_limit(0);
			if ($getType === \OC_Files::ZIP_FILES) {
				foreach ($files as $file) {
					$file = $dir . '/' . $file;
					if (\OC\Files\Filesystem::is_file($file)) {
						$fileSize = \OC\Files\Filesystem::filesize($file);
						$fileTime = \OC\Files\Filesystem::filemtime($file);
						$fh = \OC\Files\Filesystem::fopen($file, 'r');
						$streamer->addFileFromStream($fh, basename($file), $fileSize, $fileTime);
						fclose($fh);
					} elseif (\OC\Files\Filesystem::is_dir($file)) {
						$streamer->addDirRecursive($file);
					}
				}
			} elseif ($getType === \OC_Files::ZIP_DIR) {
				$file = $dir . '/' . $files;
				$streamer->addDirRecursive($file);
			}
			$streamer->finalize();
			set_time_limit($executionTime);
			\OC_Files::unlockAllTheFiles($dir, $files, $getType, $view, $filename);
		} catch (\OCP\Lock\LockedException $ex) {
			\OC_Files::unlockAllTheFiles($dir, $files, $getType, $view, $filename);
			\OC::$server->getLogger()->logException($ex);
			$l = \OC::$server->getL10N('core');
			$hint = method_exists($ex, 'getHint') ? $ex->getHint() : '';
			\OC_Template::printErrorPage($l->t('File is currently busy, please try again later'), $hint);
		} catch (\OCP\Files\ForbiddenException $ex) {
			\OC_Files::unlockAllTheFiles($dir, $files, $getType, $view, $filename);
			\OC::$server->getLogger()->logException($ex);
			$l = \OC::$server->getL10N('core');
			\OC_Template::printErrorPage($l->t('Can\'t read file'), $ex->getMessage());
		} catch (\Exception $ex) {
			\OC_Files::unlockAllTheFiles($dir, $files, $getType, $view, $filename);
			\OC::$server->getLogger()->logException($ex);
			$l = \OC::$server->getL10N('core');
			$hint = method_exists($ex, 'getHint') ? $ex->getHint() : '';
			\OC_Template::printErrorPage($l->t('Can\'t read file'), $hint);
		}
	}
}