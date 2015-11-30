<?php
	//.............Required Functions..............


	//..................Admin Login Check..................
	function check_admin_login($login_arr)
	{
		$login_arr = add_slashes($login_arr);
		$username = $login_arr[username]; 
	   	$password = sha1(SALT_VAR.$login_arr[password]);
		$roleid=$login_arr[roleid];
		
	//	$qry = "select * from admin where username='".$username."' and password='".$password."'";
	//	$row = mysql_query($qry);
		
		$row = single_row(ADMIN,"*","roleid='".$roleid."' and`username`='".$username."' and `password`='".$password."'","id","desc","",false);
		if ($row!=false)
		{
			session_register($_SESSION[Adm_UserId]);
			session_register($_SESSION[Adm_RoleId]);
			session_register($_SESSION[Adm_Email]);
			session_register($_SESSION[Adm_UserNm]);
			session_register($_SESSION[Adm_Fname]);
			session_register($_SESSION[Adm_Lname]);
			
			$_SESSION[Adm_UserId] = $row[id];
			$_SESSION[Adm_RoleId] = $row[roleid];
			$_SESSION[Adm_Email] = $row[email];
			$_SESSION[Adm_UserNm] = $row[username];	
			$_SESSION[Adm_Fname] = $row[fname];	
			$_SESSION[Adm_Lname] = $row[lname];	
			return true;
		}
		else
		{
			return false;			
		}
	}
    function user_statistics()
	{
		$sel_chart = sel_rec (ADMIN_CHART,"*","ip_address = '".$_SERVER['REMOTE_ADDR']."' and ses_id = '".session_id()."'","1","desc","");
		if($sel_chart != false)
		{
			$count_rows = mysql_fetch_array($sel_chart);
			if($count_rows[ses_id] != session_id())
			{
				$chart_arr[ip_address] 	= $_SERVER['REMOTE_ADDR'];
				$chart_arr[ses_id] 		= session_id(); 
				$chart_arr[count_timer] = $count_rows[count_timer] + "1";
				$chart_arr[dateupdated] = date("Y-m-d h:m:s");
				$inc_chart = upd_rec(ADMIN_CHART,$chart_arr,"ip_address = '".$_SERVER['REMOTE_ADDR']."' and ses_id = '".session_id()."'");
			}
		}
		else
		{
			$chart_arr[ip_address] 	= $_SERVER['REMOTE_ADDR'];
			$chart_arr[ses_id] 		= session_id(); 
			$chart_arr[count_timer] = "1";
			$inc_chart = ins_rec(ADMIN_CHART,$chart_arr);
		}
	}
	function logout()
	{
		unset($_SESSION[Adm_UserId]);
		session_unregister($_SESSION[Adm_UserId]);
		
		unset($_SESSION[Adm_RoleId]);
		session_unregister($_SESSION[Adm_RoleId]);
		
		unset($_SESSION[Adm_Email]);
		session_unregister($_SESSION[Adm_Email]);
		
		unset($_SESSION[Adm_UserNm]);
		session_unregister($_SESSION[Adm_UserNm]);

		unset($_SESSION[Adm_Fname]);
		session_unregister($_SESSION[Adm_Fname]);

		unset($_SESSION[Adm_Lname]);
		session_unregister($_SESSION[Adm_Lname]);

	}
	function admin_login_check() // check in login page......
	{
		if (isset ($_SESSION[Adm_UserId]))
		{
			print '<script language="javascript">window.location.href="dashboard.php"</script>';
		}
	}
	
	
	//..........Login Check.............
	function is_admin_login()
	{
		if (!isset ($_SESSION[Adm_UserId]))
		{
			print '<script language="javascript">window.location.href="index.php"</script>';
		}
		//check for user role priviledges.............
		
		
	}
	
	
	function is_user_login($page,$flag=true)
	{
		if (!isset ($_SESSION[USERID]))
		{
			print '<script language="javascript">window.location.href="'.$page.'"</script>';
		}
	}
	function is_siteuser_login_check()
	{
		if (!isset ($_SESSION[userid]))
		{
			print '<script language="javascript">window.location.href="index.php"</script>';
		}
	}
	
	function highlightWords($string, $words)
	{
		$words1 = explode(" ",$words);
		foreach ( $words1 as $word )
		{
			$string = str_ireplace($word, '<span class="highlight_word">'.$word.'</span>', $string);
		}
		/*** return the highlighted string ***/
		return $string;
	}
	
	function sub_string($str='',$max)
	{
		if (strlen($str) > $max)
			return substr($str,0,$max)."...";
		else
			return $str;
	}
	
	function get_pagetitle($str)
	{
		return str_replace("_"," ",strtoupper(substr($str,0,1)).substr($str,1));
	}
	
	function get_pagename()
	{
		$arr=split("/",$_SERVER['PHP_SELF']);
		return $arr[count($arr)-1];
	}
	
	//................ get random password start...........
	function generate_password($len)
	{
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		for($i=0; $i<$len; $i++) $r_str .= substr($chars,rand(0,strlen($chars)),1);
		return $r_str;
	}
	//................ get random password end...........
	
	
	//................ get random password start...........
	function generate_string($len)
	{
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		for($i=0; $i<$len; $i++) $r_str .= substr($chars,rand(0,strlen($chars)),1);
		return $r_str;
	}
	//................ get random password end...........
	
	
	//................ get random password start...........
	function generate_randomnumber($len)
	{
		$chars = "0123456789";
		for($i=0; $i<$len; $i++) 
			$r_str .= substr($chars,rand(0,strlen($chars)),1);
		return $r_str;
	}
	//................ get random password end...........

	function upload_image($files, $dir, $oldfile ,$prefix)
	{
		if(!is_dir ($dir))
		{
			mkdir($dir,0777);
			chmod($dir,0777);	
		}	
		if($oldfile != "" && is_file($dir.$oldfile))
		{
			unlink($dir.$oldfile);
		}		
		$filename = $prefix."".rand(0,999999999999)."-".$files[name];		
		if (is_file($dir.$filename))
			$filename = $prefix."".rand(0,999999999999)."-".rand(0,999999999999)."-".$files[name];
		if (@move_uploaded_file($files[tmp_name],$dir.$filename))
			return $filename;
		else
			return false;
	}
	function getModifiedUrlNamechange($catnm)
	{
		$catnm1=ereg_replace("[^A-Za-z0-9]","-",$catnm);
		return $catnm1;
	}
	
	function getVideoName($catnm)
	{
		$catnm1=ereg_replace("[^A-Za-z0-9.]","-",$catnm);
		return $catnm1;
	}

	function getmetadate($table,$where,$disp=false)
	{
		$metaarray = array();
		$sel = "select title,meta_title,meta_keyword,meta_description,seo_detail from $table where ".$where;
		if ($disp==true)
			echo $sel;
		$sel_qur = mysql_query($sel);
		$totrows = mysql_num_rows($sel_qur);
		if($totrows > 0)
		{
			$sel_obj = mysql_fetch_array($sel_qur);
			array_push($metaarray,$sel_obj['title']); 
			array_push($metaarray,$sel_obj['meta_title']); 		
			array_push($metaarray,$sel_obj['meta_keyword']); 
			array_push($metaarray,$sel_obj['meta_description']); 		
			array_push($metaarray,$sel_obj['seo_detail']); 		
		}
		return $metaarray;
	}
	function getglobalmetadata($table,$where='1=1')
	{
		$metaarray = array();
		$sel = "select title,meta_title,meta_keyword,meta_description,seo_detail from global_meta_tag where ".$where;
		$sel_qur = mysql_query($sel);
		$totrows = mysql_num_rows($sel_qur);
		if($totrows > 0)
		{
			$sel_obj = mysql_fetch_array($sel_qur);
			array_push($metaarray,$sel_obj['title']); 
			array_push($metaarray,$sel_obj['meta_title']); 		
			array_push($metaarray,$sel_obj['meta_keyword']); 
			array_push($metaarray,$sel_obj['meta_description']); 		
			array_push($metaarray,$sel_obj['seo_detail']); 		
		}
		return $metaarray;
	}


	function getCreditCard($card="")
	{
		$card_arr = array(	"AmEx"	=>	"American Express",
							"MasterCard"=>	"MasterCard",
							"Visa" 	=> 	"Visa",
							"Dino" 	=> 	"Discover",						
							);
		$cardopt="";					
		foreach($card_arr as $key1=>$valu){
			if($key1==$card)
				$cardopt .= "<option value=".$key1." selected>$valu</option>";
			else
				$cardopt .= "<option value=".$key1.">$valu</option>";
		}
		return $cardopt;
	}

	function getMonth($id="")
	{	
			
		$cur_mn = date("m");
	
		$mon=array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		
		$tMonth=$mon;
		$actMonth=$tMonth;
		$motmOption="";
		for($m=1; $m < count($actMonth); $m++)
		{
			if($m == $id)
				$motmOption .="<option value='$m' selected=selected>$actMonth[$m]</option>";
			else
				$motmOption .="<option value='$m'>$actMonth[$m]</option>";						
		}
		
		return $motmOption;
	}
	
	function exporttocsv($tab,$fields='*',$where='1=1',$orderby='1',$order='desc',$filename='export.csv')
	{
		$csv_terminated = "\n";
		$csv_separator = ",";
		$csv_enclosed = '"';
		$csv_escaped = "\\";
		$sql_query = "select $fields from $tab where $where order by $orderby $order";
	 
		// Gets the data from the database
		$result = mysql_query($sql_query);
		$fields_cnt = mysql_num_fields($result);
	 
		$schema_insert = '';
		for ($i = 0; $i < $fields_cnt; $i++)
		{
			$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
				stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
			$schema_insert .= $l;
			$schema_insert .= $csv_separator;
		} // end for
	 
		$out = trim(substr($schema_insert, 0, -1));
		$out .= $csv_terminated;

		// Format the data
		while ($row = mysql_fetch_array($result))
		{
			$schema_insert = '';
			for ($j = 0; $j < $fields_cnt; $j++)
			{
				if ($row[$j] == '0' || $row[$j] != '')
				{
					if ($csv_enclosed == '')
					{
						$schema_insert .= $row[$j];
					} else
					{
						$schema_insert .= $csv_enclosed .
						str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
					}
				} else
				{
					$schema_insert .= '';
				}
	 
				if ($j < $fields_cnt - 1)
				{
					$schema_insert .= $csv_separator;
				}
			} // end for
	 
			$out .= $schema_insert;
			$out .= $csv_terminated;
		} // end while
	 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Length: " . strlen($out));
		// Output to browser with appropriate mime type, you choose ;)
		header("Content-type: text/x-csv");
		//header("Content-type: text/csv");
		//header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=$filename");
		echo $out;
		exit;
	}
	
	function add_slashes($var)
	{
		if (is_array($var))
		{
			if (count($var) > 0)
			{
				foreach ($var as $k=>$v)	
				{
					$var[$k] = addslashes($v);
				}
			}
			return $var;
		}
		else
			return addslashes($var);
	}
	
	function strip_slashes($var)
	{
		if (is_array($var))
		{
			if (count($var) > 0)
			{
				foreach ($var as $k=>$v)	
				{
					$var[$k] = stripslashes($v);
				}
			}
			return $var;
		}
		else
			return stripslashes($var);
	}
	
	
	

function getdayofweek($no)
{
	switch ($no)
	{
		
		case 0:
			$day="Monday"; break;
		case 1:
			$day="Tuesday"; break;
		case 2:
			$day="Wednesday"; break;
		case 3:
			$day="Thursday"; break;
		case 4:
			$day="Friday"; break;
		case 5:
			$day="Saturday"; break;	
		case 6:
			$day="Sunday"; break;					
	}
	return $day;
}

function sub_words($bsdesc,$length=100)
{
	$bphrase = $bsdesc; 
	$babody = str_word_count($bphrase,2);
	if(count($babody) > $bthreshold_length)
	{ 
		$btbody = array_keys($babody);
		$bpro_sdesc= substr($bphrase,0,$btbody[$bthreshold_length]) . "...";	 		  
	} 
	else
	{ 
		$bpro_sdesc=$bsdesc;
	}	
	return $bpro_sdesc;
}

function smartCopy($source, $dest, $folderPermission=0755,$filePermission=0644){
# source=file & dest=dir => copy file from source-dir to dest-dir
# source=file & dest=file / not there yet => copy file from source-dir to dest and overwrite a file there, if present

# source=dir & dest=dir => copy all content from source to dir
# source=dir & dest not there yet => copy all content from source to a, yet to be created, dest-dir
    $result=false;
   
    if (is_file($source)) { # $source is file
        if(is_dir($dest)) { # $dest is folder
            if ($dest[strlen($dest)-1]!='/') # add '/' if necessary
                $__dest=$dest."/";
            $__dest .= basename($source);
            }
        else { # $dest is (new) filename
            $__dest=$dest;
            }
        $result=copy($source, $__dest);
        chmod($__dest,$filePermission);
        }
    elseif(is_dir($source)) { # $source is dir
        if(!is_dir($dest)) { # dest-dir not there yet, create it
            @mkdir($dest,$folderPermission);
            chmod($dest,$folderPermission);
            }
        if ($source[strlen($source)-1]!='/') # add '/' if necessary
            $source=$source."/";
        if ($dest[strlen($dest)-1]!='/') # add '/' if necessary
            $dest=$dest."/";

        # find all elements in $source
        $result = true; # in case this dir is empty it would otherwise return false
        $dirHandle=opendir($source);
        while($file=readdir($dirHandle)) { # note that $file can also be a folder
            if($file!="." && $file!="..") { # filter starting elements and pass the rest to this function again
#                echo "$source$file ||| $dest$file<br />\n";
                $result=smartCopy($source.$file, $dest.$file, $folderPermission, $filePermission);
                }
            }
        closedir($dirHandle);
        }
    else {
        $result=false;
        }
    return $result;
    }
function makedir($dirpath,$permission="0777")
{
	if(!is_dir($dirpath))
	{
		mkdir($dirpath);
		chmod($dirpath,$permission);		
	}	
}
function unzip($zipfile,$foldernm)
{
    $zip = zip_open($zipfile);
    while ($zip_entry = zip_read($zip))    {
        zip_entry_open($zip, $zip_entry);
        if (substr(zip_entry_name($zip_entry), -1) == '/') {
            $zdir = substr(zip_entry_name($zip_entry), 0, -1);
            if (file_exists($foldernm."/".$zdir)) {
               // trigger_error('Directory "<b>' . $zdir . '</b>" exists', E_USER_ERROR);
                return false;
            }
            mkdir($foldernm."/".$zdir);
        }
        else {
            $name = zip_entry_name($zip_entry);
            if (file_exists($name)) {
               // trigger_error('File "<b>' . $name . '</b>" exists', E_USER_ERROR);
               // return false;
            }
            $fopen = fopen($foldernm."/".$name, "w");
            fwrite($fopen, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)), zip_entry_filesize($zip_entry));
        }
        zip_entry_close($zip_entry);
    }
    zip_close($zip);
    return true;
}

function delTree($dir) {
    $files = glob( $dir . '*', GLOB_MARK );
    foreach( $files as $file ){
        if( is_dir( $file ) )
            delTree( $file );
        else
            unlink( $file );
    }
  
    if (is_dir($dir)) rmdir( $dir );
  
}

function del_file($path)
{
	if (is_file($path))
	{
		unlink($path);
		return true;
	}
	else
		return false;
}

function dateDiff($date1, $date2) {
    $date1 = strtotime($date1);
    $date2 = strtotime($date2);
     $secs = $date1 - $date2;
     if ($secs < 60) 
	 {
	 	$second=$secs." seconds";
	 }
     $minutes = round($secs / 60);
   	 if ($minutes < 60) 
	 {
	 	$minute=$minutes." min.";		
	 }
     $hours = round($minutes / 60);
     if ($hours < 60) 
	 {
	 	if($hours==1)
			$hour=$hours." hour";
		else
			$hour=$hours." hours";
	 }
    	$days = round($hours / 24);
    if ($days > 0) 
	{
	 	if($days==1)
			$cont=$days." day";
		else
			$cont=$days." days";		  
	}
	elseif($hours > 0)
		$cont=$hour;
	elseif($minutes > 0)
		$cont=$minute;
	//elseif($secs > 0)
		//$cont=$second;
	else
		$cont="closed";
	return $cont;
		
	 
}

function create_combo($name,$id,$table,$where="1=1",$value="",$dispval="",$default="",$class="")
{
	$combo = '<select name="'.$name.'" id="'.$id.'" class="'.$class.'">
				<option value="">Select </option>';
	
	$sel = "select $value,$dispval from $table where $where";
	$res = mysql_query($sel);
	
	if (mysql_num_rows($res))
	{
		while ($val = mysql_fetch_array($res))
		{
			$combo .= '<option value="'.$val[$value].'"';
			if ($default==$val[$value])
				$combo .= ' selected="selected" ';
			$combo .='>'.stripslashes(utf8_decode($val[$dispval])).'</option>';					
		}
	}
	
	
	$combo .='</select>';
	return $combo; 
}
function word_wrap($desc,$length="30")
{
	$phrase = $desc; 
	$abody = str_word_count($phrase,2);
	if(count($abody) > $length)
	{ 
		$tbody = array_keys($abody);
		$short_desc1= substr($phrase,0,$tbody[$length]) . "...";	 		
	}
	else
	{ 
		$short_desc1=$desc;
	}		
	return $short_desc1; 
}	

function generate_rand_num($len)
	{
		//$chars = "23456";
		for($i=2; $i<6; $i++) $r_str=(rand($i));
		return $r_str;
	}
	
//................................database backup function......................
function backup_tables($host,$user,$pass,$name,$tables = '*') 
{ 
  	$link = mysql_connect ($host,$user,$pass) or die ("Couldn't connect with database!");
	mysql_select_db($name,$link) or die ("Database not found!");
  	//get all of the tables 
  	if($tables == '*') 
  	{ 
    	$tables = array();
    	$result = mysql_query('SHOW TABLES');
    	while($row = mysql_fetch_row($result)) 
    	{ 
      		$tables[] = $row[0];
    	} 
  	} 
  	else 
  	{ 
    	$tables = is_array($tables) ? $tables : explode(',',$tables);
  	} 
  	foreach($tables as $table) 
  	{ 
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		for ($i = 0; $i < $num_fields; $i++) 
    	{ 
      		while($row = mysql_fetch_row($result)) 
      		{ 
        		$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{ 
				  $row[$j] = addslashes($row[$j]);
				  $row[$j] = ereg_replace("\n","\\n",$row[$j]);
				  if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; } 
				  if ($j<($num_fields-1)) { $return.= ','; } 
				} 
        		$return.= ");\n";
      		} 
    	} 
    $return.="\n\n\n";
  	} 
  	//save file 
	$filename = 'whataflix-'.date("d-M-Y").'.sql';
  	$handle = fopen($filename,'w+');
	fwrite($handle,$return);
	fclose($handle);
	return $filename;
}

function verify_iphone_sign($sign="",$salt="")
{
	if($sign!='' and $salt!='')
	{
		$key="iPhoneapps";	
		$md5_salt=md5($key.$salt);
		if($sign==$md5_salt)
		{
			return true;
		}
	}
	return false;
}

function checkemail($email,$tablename)
{	
	$chk_email=sel_rec($tablename,"id","email='$email'","1","desc","",false);
	if($chk_email)
	{
		if(mysql_num_rows($chk_email)>0)
		{
			return false;
		}
	}
	return true;
}
function forgot_pass_req($uuid='',$tablename)
{
	if($uuid>0)
	{
		$after_10sec=date("Y-m-d H:i:s",mktime(date("H"),date("i"),date("s")-10,date("d"),date("m"),date("Y")));
		$pass_request=sel_rec($tablename,"id","req_datetime>='$after_10sec' AND uuid='$uuid'","1","desc","",false);
		if($pass_request!=false)
		{ return false; }		
	}
	return true;
}
function zen_rand($min = null, $max = null) {
    static $seeded;

    if (!isset($seeded)) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }
function zen_encrypt_password($plain) 
{
     $password=''; 
     for($i=0; $i<10; $i++) 
	 {
       $password .= zen_rand();
     }

     $salt = substr(md5($password), 0, 2);
     $password = md5($salt . $plain) . ':' . $salt;
     return $password;
}
function zen_validate_password($plain, $encrypted) 
{
  if(zen_not_null($plain) && zen_not_null($encrypted)) 
	 {
	  // split apart the hash / salt
       $stack = explode(':', $encrypted);
       if(sizeof($stack) != 2) 
	   		return false; 
       if(md5($stack[1].$plain)==$stack[0]) 
	   {
         return true;
       }
     }

     return false;
}
function zen_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } elseif( is_a( $value, 'queryFactoryResult' ) ) {
      if (sizeof($value->result) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
}
function change_catapp_positon($position,$tab,$cat_id)
{
	$chk_app_position=get_single_value($tab,"id","cat_id=$cat_id AND position=$position","position","desc","",false);
	if($chk_app_position>0)
	{
		$updt_pos="UPDATE $tab SET position=position+1 WHERE cat_id=$cat_id AND position>=$position ORDER BY position desc";
		mysql_query($updt_pos);
	}
}
function get_view_count($tab,$start_dt,$end_dt,$app_id)
{
	if($start_dt=='')
		$start_dt=date("Y-m-d H:i:s");
	if($end_dt=='')
		$end_dt=date("Y-m-d H:i:s");	
	$app_views=get_single_value($tab,"sum(views)","DATE_FORMAT(dateupdated,'%Y-%m-%d')>='$start_dt' AND 
	DATE_FORMAT(dateupdated,'%Y-%m-%d')<='$end_dt' AND app_id=$app_id");
	if($app_views=='')
		$app_views=0;
	return $app_views;
}
	function sendcmsmail($email,$password)
	{
		global $SITE_URL;
		$content='<table style="background-color:#0a3640;border:1px solid #CFCFCF;padding:10px;font-family:Verdana;font-size:12px;" width="100%">
		<tr><td><img src="'.$SITE_URL.'logo.png" /></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
		<table style="padding:10px;font-size:12px;background-color:#fff;border:1px solid #CFCFCF;" cellpadding="5">	
		<tr><td colspan="4">&nbsp;</td></tr>	
		<tr><td colspan="4" style="font-family:Verdana, Geneva, sans-serif;font-size:12px;text-align:left;">Welcome to the '.SITE_NAME.'.&nbsp;You\'re now ready to start creating audio and guessing hilarious audio with your friends!</td></tr>
		<tr><td colspan="4" style="font-family:Verdana, Geneva, sans-serif;font-size:12px;">
			Login credentils are as below<b></td></tr>
		<tr>
		<td colspan="4">
			<table height="30" style="font-family:Verdana, Geneva, sans-serif;font-size:12px;width:600px;border-collapse:collapse;">
				<tr>					
					<th style="border: 1px solid #808080 !important;font-size:1.1em;text-align:left;padding-top:5px;padding-left:10px;padding-bottom:5px;
					background-color:#cdcdcd !important;color:#000000 !important;" width="20%">Email</th>
					<th style="border: 1px solid #808080 !important;font-size:1.1em;text-align:left;padding-top:5px;padding-left:10px;padding-bottom:5px;
					background-color:#cdcdcd !important;color:#000000 !important;" width="35%">'.$email.'</th></tr>
				<tr><th style="border: 1px solid #808080 !important;font-size:1.1em;text-align:left;padding-top:5px;padding-left:10px;padding-bottom:5px;
					background-color:#cdcdcd !important;color:#000000 !important;" width="16%">Password</th>
					<th style="border: 1px solid #808080 !important;font-size:1.1em;text-align:left;padding-top:5px;padding-left:10px;padding-bottom:5px;
					background-color:#cdcdcd !important;color:#000000 !important;" width="35%">'.$password.'</th></tr>
				</table></td></tr>				
				<tr><td style="font-family:Verdana, Geneva, sans-serif;font-size:12px;text-align:left;" colspan="4">Keep it in a safe place! You\'ll need it if you ever sign out of the app<br> or get a new device!</td></tr>
				<tr><td style="font-family:Verdana, Geneva, sans-serif;font-size:12px;text-align:left;" colspan="4">P.S.  You can also change your password from the Account page inside the game!</td></tr>
				<tr><td style="font-family:Verdana, Geneva, sans-serif;font-size:12px;text-align:left;" colspan="4">Thank You,</td></tr>
				<tr><td style="font-family:Verdana, Geneva, sans-serif;font-size:12px;text-align:left;" colspan="4">
				'.SITE_NAME.' Team</td></tr>';				
	$content.='</table>
		</td>
	</tr>
	</table>';
	return $content;
	}
?>