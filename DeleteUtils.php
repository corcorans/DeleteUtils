<?php

/**
 * Utility class that works with deleting files and directories.
 */
class DeleteUtils {

   /**
    * Delete all files and directories within the root directory.
    *
    * @param   String   The absolute path to the root directory.
    */
   public static function rm_dir($path) {      
      foreach(self::serialize_dir($path) as $item) {
         $absolute_path = $path . DIRECTORY_SEPARATOR . $item;

         if(is_dir($absolute_path) && !self::is_empty($absolute_path)) {
            self::rm_dir($absolute_path);
            rmdir($absolute_path);
         } else if(is_dir($absolute_path)) {
            rmdir($absolute_path);
         } else {
            unlink($absolute_path);
         }
      }
   }
   
   /**
    * Checks to see if a directory is empty
    *
    * @param   String   The absolute path to a directory.
    *
    * @return true or false if the directory is empty or not
    */
   public static function is_empty($dir) {
      return count(self::serialize_dir($dir)) === 0; 
   }
   
   /**
    * Removes . and .. from the array returned from scandir.
    *
    * @param  String  The absolute path to a directory.
    *
    * @return an array from scandir without . and ..
    *
    * @exception throws a runtime exception when scandir returns false
    */
   public static function serialize_dir($dir) {
      if(scandir($dir) === false) {
         throw new \RuntimeException("Scandir returned false, either $dir was not a directory or an I/O error occurred.");
      }
      
      return array_diff(scandir($dir), array('.', '..'));
   }
}

DeleteUtils::rm_dir('C:\\temp');
?>