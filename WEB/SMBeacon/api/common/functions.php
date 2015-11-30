<?php
class Database
{
    public function ins_rec($tab,$array,$disp=false)	
	{	
		$array = Database::add_slashes($array);
				
		$qry = "insert into $tab set ";
		if (count($array) > 0)
		{
			foreach ($array as $k=>$v)
			{
				if($v != "")
				{
					$qry .= "`$k`='".$v."',";
				}
			}
		}		
		$qry=trim($qry,",");		
		if ($disp)
			echo $qry;		
		$err = mysql_query($qry);		
		if (!$err)
		{
			echo mysql_error()." - <b>".$qry."</b>";
			return false;
		}
		else
		{
			return mysql_insert_id();
		}
	}

    public function upd_rec($tab,$array,$where="1=1",$disp=false)	
	{	
		$array = Database::add_slashes($array);
		$qry = "update $tab set ";
		if (count($array) > 0)
		{
			foreach ($array as $k=>$v)
			{				
					$qry .= "$k='".$v."',";
			
			}
		}
			
		$qry=trim($qry,",")." where ".$where;
		if ($disp)
			echo $qry;
		
		$err = mysql_query($qry);		
		
		if (!$err)
		{
			echo mysql_error()." - <b>".$qry."</b>";
			return false;
		}
		else
			return true;
	}
	public function add_slashes($var)
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
	
	public function strip_slashes($var)
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
	public function is_dup_add($table,$field,$value,$disp=false)
	{
		$q = "select ".$field." from ".$table." where ".$field." = '".$value."'"; 
		if ($disp)
			echo ($q);
		$r = mysql_query($q);
		if(mysql_num_rows($r) > 0)
			return true;
		else
			return false;
	}
	//...............................check for duplication row in a table while adding new row [end]................
	
	//...............................check for duplication row in a table while updating any row [start]................
	public function is_dup_edit($table,$field,$value,$tableid,$id,$disp=false)
	{
		$q = "select ".$field." from ".$table." where ".$field." = '".$value."' and ".$tableid."!= '".$id."'"; 
		if ($disp)
			echo($q);
		$r = mysql_query($q);
		if(!$r)
			echo mysql_error();
		if(mysql_num_rows($r) > 0)
			return true;
		else
			return false;
	}	
	public function upload_image($files, $dir, $oldfile ,$prefix)
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
		//$filename = $files[name];		
		if (is_file($dir.$filename))
			$filename = $prefix."".rand(0,999999999999)."-".rand(0,999999999999)."-".$files[name];
		if (@move_uploaded_file($files[tmp_name],$dir.$filename))
			return $filename;
		else
			return false;
	}
	public function sel_rec($tab,$fields="*",$where="1=1",$orderby="1",$order="desc",$limit="",$disp=false) 
	{	
		$qry="select $fields from $tab where $where order by $orderby $order $limit"; 		
		if($disp)
			echo $qry;		
		$res=mysql_query($qry);		
		if(!$res)	
			echo mysql_error()."-<b>".$qry."</b>";		
		if(mysql_num_rows($res)>0)
			return $res;
		else
			return false;		
	}
	public function get_single_value($tab,$fields,$where="1=1",$orderby="1",$order="desc",$limit="",$disp=false)
	{
		$res = Database::sel_rec($tab,$fields,$where,$orderby,$order,$limit,$disp);
		if ($res)
		{
			$val = mysql_fetch_array($res);
			return Database::strip_slashes($val[$fields]);
		}
		else
			return false;
	}
	public function time_ago( $datefrom , $dateto=-1 )
	{
	   if($datefrom<=0) { return "A long time"; }
	   if($dateto==-1) { $dateto = time(); }
	   
	   $difference = $dateto - $datefrom;
	   
	   // Seconds
	   if($difference < 60)
	   {
		  $time_ago   = $difference . ' second' . ( $difference > 1 ? 's' : '' ).'';
	   }
	   
	   // Minutes
	   else if( $difference < 60*60 )
	   {
			 $ago_seconds   = $difference % 60;
			$ago_seconds   = ( ( $ago_seconds AND $ago_seconds > 1 ) ? ' and '.$ago_seconds.' seconds' : ( $ago_seconds == 1 ? ' and '.$ago_seconds.' second' : '' ) );
			$ago_minutes   = floor( $difference / 60 );
			$ago_minutes   = $ago_minutes . ' minute' . ( $ago_minutes > 1 ? 's' : '' ).'';
			$time_ago      = $ago_minutes.'';
	   }
	   
	   // Hours
	   else if ( $difference < 60*60*24 )
	   {
			 $ago_minutes   = round( $difference / 60 ) % 60 ;
		   $ago_minutes   = ( ( $ago_minutes AND $ago_minutes > 1 ) ? ' and ' . $ago_minutes . ' minutes' : ( $ago_minutes == 1 ? ' and ' . $ago_minutes .' minute' : '' ));
		   $ago_hours      = floor( $difference / ( 60 * 60 ) );
		   $ago_hours      = $ago_hours . ' hour'. ( $ago_hours > 1 ? 's' : '' );
		   $time_ago      = $ago_hours.'';
	   }
	   
	   // Days
	   else if ( $difference < 60*60*24*7 )
	   {
		  $ago_hours      = round( $difference / 3600 ) % 24 ;
		  $ago_hours      = ( ( $ago_hours AND $ago_hours > 1 ) ? ' and ' . $ago_hours . ' hours' : ( $ago_hours == 1 ? ' and ' . $ago_hours . ' hour' : '' ));
		  $ago_days      = floor( $difference / ( 3600 * 24 ) );
		  $ago_days      = $ago_days . ' day' . ($ago_days > 1 ? 's' : '' );
		  $time_ago      = $ago_days.'';
	   }
	   
	   // Weeks
	   else if ( $difference < 60*60*24*30 )
	   {
		  $ago_days      = round( $difference / ( 3600 * 24 ) ) % 7;
		  $ago_days      = ( ( $ago_days AND $ago_days > 1 ) ? ' and '.$ago_days.' days' : ( $ago_days == 1 ? ' and '.$ago_days.' day' : '' ));
		  $ago_weeks      = floor( $difference / ( 3600 * 24 * 7) );
		  $ago_weeks      = $ago_weeks . ' week'. ($ago_weeks > 1 ? 's' : '' );
		  $time_ago      = $ago_weeks.'';
	   }   
	   // Months
	   else if ( $difference < 60*60*24*365 )
	   {
		  $days_diff   = round( $difference / ( 60 * 60 * 24 ) );
		  $ago_days   = $days_diff %  30 ;
		  $ago_weeks   = round( $ago_days / 7 ) ;
		  $ago_weeks   = ( ( $ago_weeks AND $ago_weeks > 1 ) ? ' and '.$ago_weeks.' weeks' : ( $ago_weeks == 1 ? ' and '.$ago_weeks.' week' : '' ) );
		  $ago_months   = floor( $days_diff / 30 );
		  $ago_months   = $ago_months .' month'. ( $ago_months > 1 ? 's' : '' );
		  $time_ago   = $ago_months.'';
	   }   
	   // Years
	   else if ( $difference >= 60*60*24*365 )
	   {
		  $ago_months   = round( $difference / ( 60 * 60 * 24 * 30.5 ) ) % 12;
		  $ago_months   = ( ( $ago_months AND $ago_months > 1 ) ? ' and ' . $ago_months . ' months' : ( $ago_months == 1 ? ' and '.$ago_months.' month' : '' ) );
		  $ago_years   = floor( $difference / ( 60 * 60 * 24 * 365 ) );#30 * 12
		  $ago_years   = $ago_years . ' year'. ($ago_years > 1 ? 's' : '' ) ;
		  $time_ago   = $ago_years.'';
	   }   
	   return $time_ago;
	}
	public function single_row($tab,$fields="*",$where="1=1",$orderby="1",$order="desc",$limit="",$disp=false)
	{
		$res_single = Database::sel_rec($tab,$fields,$where,$orderby,$order,$limit,$disp);
		//echo mysql_num_rows($res_single); exit;
		if ($res_single != false && mysql_num_rows($res_single) > 0)
		{
			//echo "test"; exit;
			return Database::strip_slashes(mysql_fetch_array($res_single));
		}
		else
			return false;
	}
	public function SendHTMLMail($to,$subject,$mailcontent,$from1,$cc="",$bcc="")
	{
			$limite = "_parties_".md5 (uniqid (rand()));
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type:text/plain;charset=iso-8859-1\r\n";
			if ($cc != "")
			{
				$headers .= "Cc: $cc\r\n";
			}
			if ($bcc != "")
			{
				$headers .= "Bcc: $bcc\r\n";
			}
			$headers .= "From: $from1\r\n";
			
			$res=@mail($to,$subject,$mailcontent,$headers);
			return $res;
	}
	public function SendHTMLMail1($to,$subject,$mailcontent,$from1,$cc="")
	{
			$limite = "_parties_".md5 (uniqid (rand()));
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			if ($cc != "")
			{
				$headers .= "Cc: $cc\r\n";
			}
			$headers .= 'From: '.$from1."\r\n";
			$res=@mail($to,$subject,$mailcontent,$headers);
			return $res;
	}
	public function generate_password($len)
	{
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		for($i=0; $i<$len; $i++) $r_str .= substr($chars,rand(0,strlen($chars)),1);
		return $r_str;
	}
	public function del_rec($tab,$where="1=1",$disp=false)
	 {
		$qry="delete from $tab where $where";
		if($disp)
			echo $qry;			
		$err=mysql_query($qry);
		if(!$err)
		{
			echo mysql_error()." - <b>".$qry."</b>";
			return false;
		}
		else
			return true;
	 }
	public function del_file($path)
	 {
	 	if(is_file($path))
	 	{
			unlink($path);
			return true;
		}
		else
			return false;
	 }
}
