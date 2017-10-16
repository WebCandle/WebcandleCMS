<?php
  //error_reporting( 0 ) ; //Please uncomment me when finish
  date_default_timezone_set( 'Africa/Cairo' ) ;

$conn = mysql_connect( 'localhost' , 'root' , '' ) or die('cannot connect to DB!') ;
if(!mysql_select_db( '[dbname]' , $conn ) ) die( 'cannot select db!');
define( 'BASE_PATH' , '/' ) ;
define( 'DOMAIN' , 'http://localhost' ) ;

  mysql_set_charset( 'utf8' , $conn ) ;
  
  define('PERMITTED_IMAGE_EXTENSIONS' , 'jpg jepg gif png' ) ;
  define('PERMITTED_FILE_EXTENSIONS' , 'jpg jepg gif png doc docx xls xlsx txt zip rar' ) ;
  define('PERMITTED_VIDEO_EXTENSIONS' , 'flv swf mp4' ) ;
  define( 'DATE_FORMAT' , 'Y-m-d' ) ;
  //define( 'DATE_FORMAT' , 'D d M Y' ) ;
  /////////////// Private ////////////////
  define( 'TEMPLATE', 'template' ) ;
  define( 'VIDEO_WIDTH' , 800 ) ;
  define( 'VIDEO_HEIGHT' , 450 ) ;

?>