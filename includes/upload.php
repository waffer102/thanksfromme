<?php
require_once("database.php");

class File_Upload {
 
   public static function upload_pic($file, $name) {
      // Configuration - Your Options
      $allowed_filetypes = array('image/gif','image/bmp','image/png','image/jpeg'); // These will be the types of file that will pass the validation.
      $max_filesize = 1048576; // Maximum filesize in BYTES (currently 1.0MB).
      $upload_path = SITE_ROOT .DS. 'public' .DS. 'pictures' .DS;
      $target_path = SITE_ROOT .DS. 'public' .DS. 'pictures' .DS. $name;
      $temp_path  = $file['tmp_name'];
      $ext = $file['type']; // Get the extension from the filename.
    
      // Check if the filetype is allowed, if not DIE and inform the user.
      if(!in_array($ext,$allowed_filetypes)) {
         return " However, the photo was not saved, filetype not supported.";
      }
    
      // Now check the filesize, if it is too large then DIE and inform the user.
      if($file['size'] > $max_filesize) {
         return " However, the photo was not saved, filesize greater than 1mb.";
      }
     
      // Upload the file to your specified path.
      if(move_uploaded_file($temp_path, $target_path)) {
            return true;
      } else {
            return "Error" ;
      }
   }
   
   public static function upload_bu_pic($file, $name) {
      // Configuration - Your Options
      $allowed_filetypes = array('image/gif','image/bmp','image/png','image/jpeg'); // These will be the types of file that will pass the validation.
      $max_filesize = 1048576; // Maximum filesize in BYTES (currently 1.0MB).
      $upload_path = SITE_ROOT .DS. 'public' .DS. 'bus_unit_picture' .DS;
      $target_path = SITE_ROOT .DS. 'public' .DS. 'bus_unit_picture' .DS. $name;
      $temp_path  = $file['tmp_name'];
      $ext = $file['type']; // Get the extension from the filename.
    
      // Check if the filetype is allowed, if not DIE and inform the user.
      if(!in_array($ext,$allowed_filetypes)) {
         return " However, the photo was not saved, filetype not supported.";
      }
    
      // Now check the filesize, if it is too large then DIE and inform the user.
      if($file['size'] > $max_filesize) {
         return " However, the photo was not saved, filesize greater than 1mb.";
      }
    
      // Upload the file to your specified path.
      if(move_uploaded_file($temp_path, $target_path)) {
            return true;
      } else {
            return "Error" ;
      }
   }
   
   public static function upload_user_list($file) {
      // Configuration - Your Options
      $allowed_filetypes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv','application/csv','text/comma-separated-values','text/anytext','application/octet-stream'); // These will be the types of file that will pass the validation.
      $max_filesize = 2097152; // Maximum filesize in BYTES (currently 2.0MB).
      //$upload_path = SITE_ROOT .DS. 'public' .DS. 'pictures' .DS;
      //$target_path = SITE_ROOT .DS. 'public' .DS. 'pictures' .DS. $name;
      //$temp_path  = $file['tmp_name'];
      $ext = $file['type']; // Get the extension from the filename.
    
      //check for upload error
      if ($file['error'] == 4) {
         return false;
      }
      
      // Check if the filetype is allowed, if not DIE and inform the user.
      if(!in_array($ext,$allowed_filetypes)) {
         return false;
      }
    
      // Now check the filesize, if it is too large then DIE and inform the user.
      if(filesize($file['userfile']['tmp_name']) > $max_filesize) {
         return false;
      }
      
      return true;
    
      // Upload the file to your specified path. We are not saving this file
      //if(move_uploaded_file($temp_path, $target_path)) {
      //      return "";
      //} else {
      //      return "Error" ;
      //}
   }
   
   public static function get_file_extention($file) {
      $path_parts = pathinfo($file["name"]);
      $extension = $path_parts['extension'];
      return $extension;
   }
   
   public static function check_upload_error($file) {
      if ($file['error'] == 4) {
         return true;
      } else {
         return false;
      }
   }

}