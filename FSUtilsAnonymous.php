<?php

/**
 * Removes . and .. from the array returned from scandir.
 *
 * @param String $dir The absolute path to a directory.
 *
 * @return mixed[] Array with . and .. remove from scandir.
 *
 * @throws RuntimeException if scandir returns false.
 */
$serialize_dir = function($dir) {
   if(scandir($dir) === false) {
      throw new \RuntimeException('scandir($dir) returned false, either $dir was not a directory or an I/O error occurred.');
   }
   
   return array_diff(scandir($dir), array('.', '..')); 
};

/**
 * Checks to see if a directory is empty.
 *
 * @param String $dir The absolute path to a directory.
 *
 * @return boolean Returns true or false if the directory is empty or not
 */
$is_empty = function($dir) use ($serialize_dir) {
   return count($serialize_dir($dir)) === 0;
};

/**
 * Delete all files and directories within the root directory.
 *
 * @param String $path The absolute path to the root directory.
 */
$rmdir_fr = function($path) use ($serialize_dir, &$rmdir_fr) {
   foreach($serialize_dir($path) as $item) {
      $absolute_path = $path . DIRECTORY_SEPARATOR . $item;

      if(is_dir($absolute_path)) {
         $rmdir_fr($absolute_path);
         rmdir($absolute_path);
      } else {
         unlink($absolute_path);
      }
   }
};

?>