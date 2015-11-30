<?php
ini_set('display_errors',0);
// error_reporting( E_ALL & ~E_NOTICE );
mysql_connect('localhost','root','');
mysql_select_db('themepa9_smbeacon');

ini_set('upload_max_filesize', '70M');
ini_set('post_max_size', '40M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);

define('SURL', "http://".$_SERVER['SERVER_NAME']."/SMBeacon/"); 
define('MYSURL',"http://".$_SERVER['SERVER_NAME']."/SMBeacon/");
define('DOC_ROOT',$_SERVER['DOCUMENT_ROOT']."/SMBeacon/");
define('TITLE', "SMBeacon");


define('IMAGE_THUMB_W', 100);
define('IMAGE_THUMB_H', 100);

include 'functions.php';

$db = new Database();

function ReDirect($URL){
	@header("Location: $URL");
	echo'	<script type="text/javascript">
			window.location = "'.$URL.'"
		</script>';
}
												
?>