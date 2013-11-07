<?php

/**
 * Utility class that works with deleting files and directories.
 */
class FSUtils {

   /**
    * Delete all files and directories within the root directory.
    *
    * @param String $path The absolute path to the root directory.
    */
   public static function rmdir_fr($path) {      
      foreach(self::serialize_dir($path) as $item) {
         $absolute_path = $path . DIRECTORY_SEPARATOR . $item;

         if(is_dir($absolute_path)) {
            self::rm_dir($absolute_path);
            rmdir($absolute_path);
         } else {
            unlink($absolute_path);
         }
      }
   }
   
   /**
    * Checks to see if a directory is empty.
    *
    * @param String $dir The absolute path to a directory.
    *
    * @return boolean Returns true or false if the directory is empty or not
    */
   public static function is_empty($dir) {
      return count(self::serialize_dir($dir)) === 0; 
   }
   
   /**
    * Removes . and .. from the array returned from scandir.
    *
    * @param String $dir The absolute path to a directory.
    *
    * @return mixed[] Array with . and .. remove from scandir.
    *
    * @throws RuntimeException if scandir returns false.
    */
   public static function serialize_dir($dir) {
      if(scandir($dir) === false) {
         throw new \RuntimeException('scandir($dir) returned false, either $dir was not a directory or an I/O error occurred.');
      }
      
      return array_diff(scandir($dir), array('.', '..'));
   }
}
?>