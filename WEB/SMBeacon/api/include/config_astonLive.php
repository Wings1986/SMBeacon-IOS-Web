<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('__PATH_TO_API','api/');
define('__PATH_TO_COMMON','common/');
define('__PATH_TO_AUDIO','sounds/');
define('SITE_URL',"http://".$_SERVER['SERVER_NAME']."/soundslike/");
define('SITE_NAME',"SoundsLike!");

define ("DB_HOST","localhost");
define ("DB_USER","milan_soundslike");
define ("DB_PASS","q1w2e3r4");
define ("DB_NAME","milan_soundslike");
define ("FROM","hitesh@techintegrity.in");

mysql_connect (DB_HOST,DB_USER,DB_PASS) or die ("Couldn't connect with database!");
mysql_select_db(DB_NAME) or die ("Database not found!");

require_once __PATH_TO_COMMON. 'functions.php';
class Config
{
	public function verify_iphone_sign($sign="",$salt="")
	{
		if($sign!='' and $salt!='')
		{
			$key="likesound";	
			$md5_salt=md5($key.$salt);
			if($sign==$md5_salt)
			{
				return true;
			}
		}
		return false;
	}
	
	public function dbconn()
	{
		mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("Couldn't connect with database!");
		mysql_select_db(DB_NAME) or die ("Database not found!");
	}
	public function dbclose()
	{
		mysql_close();
	}
}
