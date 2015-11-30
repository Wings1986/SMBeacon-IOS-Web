<?php
	//...........Local Settings.................	
	define ("DB_HOST","localhost");
	define ("DB_USER","root");
	define ("DB_PASS","password");
	define ("DB_NAME","tvslauncher_db");
	
	//..........database connection............
	mysql_connect (DB_HOST,DB_USER,DB_PASS) or die ("Couldn't connect with database!");
	mysql_select_db(DB_NAME) or die ("Database not found!");
	
	//...........define site name & important variables.............
	$SITE_NAME = "DrawTime!";
	$SITE_URL = "http://".$_SERVER['SERVER_NAME']."/api/";	
	$SITE_ROOT=$_SERVER['DOCUMENT_ROOT']."/api/";
	$SITE_TITLE="Welcome to SMBeacon";
	$SITE_ADDR=$_SERVER['SERVER_NAME'];	
	$ADMIN_URL=$SITE_URL."cms/";
	$ADMIN_TITLE=" | DrawTime Management";
	$ADMIN_CAPTION = "DrawTime Management";

	define ("SALT_VAR","likesound");
	
	//...............set server level settings.....................
	ini_set('memory_limit', '40M');
	ini_set('post_max_size', '40M');
   	ini_set('upload_max_filesize', '40M');
	$today=$date=date("Y-m-d");
	$datetime=date("Y-m-d H:i:s");
	 
?>