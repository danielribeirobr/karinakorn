<?
/**
 * LocalFS
 * Class to manage files on local machine
 * @author Daniel Ribeiro <daniel@danielribeiro.com>
 * @since 2006-07-17
 *
 * Obs.: This class code was recoded AT ALL after I lost everything..
 * Now, i'm a very strong user of SVN (subversion yeah!!!)
 */

class LocalFS{

	/**
	 * Copy a file (or directory) to a destination path
	 *
	 * @param string $source
	 * @param string $destination
	 * @param bool $overwrite
	 * @return bool
	 */
	public function copy($source, $destination, $overwrite = true){

		// test if the path is a dir
		if(self::isDir($source)){

			// parse dirs
			$source = self::parseDirName($source);
			$destination = self::parseDirName($destination);

			if($handle = opendir($source)){        // if the folder exploration is sucsessful, continue
				while(false !== ($file = @readdir($handle))){ // as long as storing the next file to $file is successful, continue
					if($file != '.' && $file != '..'){
						$path = $source . '/' . $file;
						if(self::isFile($path)){
							if(!self::copyFile($path, $destination . '/' . $file)){
								return false;
							}
						} elseif(self::isDir($path)){
							if(!self::isDir($destination . '/' . $file)){
								self::mkdir($destination . '/' . $file); // make subdirectory before subdirectory is copied
							}
							self::copy($path, $destination . '/' . $file, $overwrite); //recurse!
						}
					}
				}
				closedir($handle);
				return true;
			}
			return false;
		}

		// is a file
		else{
			return self::copyFile($source, $destination, $overwrite);
		}
	}

	/**
	 * Move a file or directory to a destination path
	 *
	 * @param string $source
	 * @param string $destination
	 * @param string $overwrite
	 * @return bool
	 */
	public function move($source, $destination, $overwrite = true){
		if(self::copy($source, $destination, $overwrite)){
			return self::delete($source);
		}
		return false;
	}

	/**
	 * Delete a file or directory
	 *
	 * @param $path
	 * @return bool
	 */
	public function delete($path){
		if (!self::fileExists($path)) return false;

      	if(self::isDir($path)){
			$path = self::parseDirName($path);
			if ($rm_dir = opendir($path)) {
				while (($file = readdir($rm_dir)) !== false) {
					if (self::isDir($path . $file)) {
							if ($file == '.' || $file == '..') continue;
							else self::delete($path . $file);
					}
					elseif (self::isFile($path . $file)) self::deleteFile($path . $file);
				}
				closedir($rm_dir);
				rmdir($path);
				return true;
			}
      	}
      	else{
      		return self::deleteFile($path);
      	}
		return false;
	}

	/**
	 * Create a directory tree
	 *
	 * @param string $path
	 * @return bool
	 */
	public function mkdir($path, $mode=0755){
		if (self::isDir($path) || @mkdir($path, $mode)) return true;
		if (!self::mkdir(dirname($path), $mode)) return false;
		return @mkdir($path, $mode);
	}

	/**
	 * save a content to a file
	 *
	 * @param string $path
	 * @param string $contents
	 * @param bool $overwrite
	 * @return bool
	 */
	public function save($path, $contents, $overwrite = true){
		if(!$overwrite and self::fileExists($path)){
			return false;
		}

		//check if directory exists to create
		if(!self::fileExists(dirname($path)))
			if(!self::mkdir(dirname($path))) return false;

		$fp = @fopen($path, 'w');
		if(!$fp) return false;
		if(!fwrite($fp, $contents)) return false;
		return true;
	}

	/**
	 * Moves an uploaded file to a new location
	 *
	 * @param string $filename
	 * @param string $destination
	 * @return bool
	 */
	public function move_uploaded_file($filename, $destination, $overwrite = true){
		return self::copyFile($filename, $destination, $overwrite);
	}

	/**
	 * Get a contents of a file
	 *
	 * @param string $path
	 * @return string
	 */
	public function getContents($path){
		if(self::isFile($path))
			return @file_get_contents($path);
	}

	/**
	 * Get a array with the directories of the path
	 *
	 * @param string $path
	 * @return array
	 */
	public function getListDirs($path){
		$path = self::parseDirName($path);
		if ($handle = @opendir($path)) {
			while (false !== ($file = readdir($handle))){
				if($file!='.' and $file!='..'){
					if(self::isDir($path . $file))
						$arrDirs[] = $file;
				}
			}
		}
		return $arrDirs;
	}

	/**
	 * Get a array with the files of the path
	 *
	 * @param string $path
	 * @return array
	 */
	public function getListFiles($path){
		$path = self::parseDirName($path);
		if ($handle = @opendir($path)) {
			while (false !== ($file = readdir($handle))){
				if($file!='.' and $file!='..'){
					if(self::isFile($path . $file))
						$arrFiles[] = $file;
				}
			}
		}
		return $arrFiles;
	}

	/**
	 * Get a array of the files and directories of the path
	 *
	 * @param string $path
	 * @return array
	 */
	public function getListAll($path){
		$path = self::parseDirName($path);
		if ($handle = @opendir($path)) {
			while (false !== ($file = readdir($handle))){
				if($file!='.' and $file!='..')
						$arrFiles[] = $file;
			}
		}
		return $arrFiles;
	}

	/**
	 * Return if the path is a directory
	 *
	 * @param string $path
	 * @return bool
	 */
	public function isDir($path){
		return @is_dir($path);
	}

	/**
	 * Return if the path is a file
	 *
	 * @param string $path
	 * @return bool
	 */
	public function isFile($path){
		return @is_file($path);
	}

	/**
	 * Return if is the file (or directory) exists
	 *
	 * @param string $path
	 * @return bool
	 */
	public function fileExists($path){
		return file_exists($path);
	}

	/**
	 * Get the size of the file (or entire directory) - in bytes
	 *
	 * @param string $path
	 * @return int
	 */
	public function getSize($path){
		$int = 0;
		if(self::isDir($path)){
			$path = self::parseDirName($path);
			if ($srcDir = @opendir($path)) {
				while (($strFile = @readdir($srcDir)) !== false) {
					if ($strFile == '.' || $strFile == '..') continue;
					if (self::isDir($path .'/'. $strFile)) $int += self::getSize($path .'/'. $strFile);
					elseif (self::isFile($path .'/'. $strFile)) $int += self::getFileSize($path .'/'. $strFile);
				}
				@closedir($srcDir);
				return $int;
			}
			return false;
		}
		else{
			return self::getFileSize($path);
		}
	}

	/**
	 * Get the last modification of the file
	 *
	 * @param string $path
	 * @return int (timestamp)
	 */
	public function fileMTime($path){
		return filemtime($path);
	}

	/**
	 * Show file contents in browser
	 *
	 * @param string $path
	 * @param bool $download
	 * @param string $type
	 */
	public function showFile($path, $download = true, $type = 'application/force-download', $filename = null){

		// clear cache
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: public');
		header('Content-Description: File Transfer');
		header('Content-Type: '. $type);

		// force download
		if($download) header('Content-Disposition: attachment; filename="'. basename($filename ? $filename : $path) .'";');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '. self::getSize($path));
		@readfile($path);
		exit;

	}

	/**
	 * Add '/' to a dir name
	 *
	 * @param string $path
	 * @return string
	 */
	private function parseDirName($path){
		if(substr($path, -1, 1) != '/')
			return $path . '/';
		else return $path;
	}

	/**
	 * Delete a file
	 *
	 * @param string $path
	 * @return bool
	 */
	private function deleteFile($path){
		return @unlink($path);
	}

	/**
	 * Copy file to a destination
	 *
	 * @param string $source
	 * @param string $destination
	 * @return bool
	 */
	private function copyFile($source, $destination, $overwrite = true){
		if(!$overwrite and self::fileExists($destination)) return false;
		if(!self::fileExists(dirname($destination))) self::mkdir(dirname($destination));
		return @copy($source, $destination);
	}

	/**
	 * Return file size
	 *
	 * @param string $path
	 * @return int
	 */
	private function getFileSize($path){
		if(self::fileExists($path))
			return @filesize($path);
		else return 0;
	}

}

?>