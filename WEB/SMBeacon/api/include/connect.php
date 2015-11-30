<?php 
@session_start();
ob_start();
include("config.inc.php");
include("db_function.php");
include("function.php");
include("sendmail.php");
include("tablename.php");
include("message.php");
include_once('imageTransform.php');	
//................Paging file..............
include("newpaging.php");
$prs_pageing = new get_pageing_new();

include("newpaging_front.php");
$prs_pageing1 = new get_pageing_new1();

include("cmspaging.php");
$cms_pageing = new get_pageing_cms();

include("ajaxpaging.php");
$ajax_pageing = new get_pageing_ajax();

$session_id = session_id();
$adminsetting=array();
$adminmail = get_single_value (ADMIN,'email','1=1');
//$admintwitter=get_single_value (ADMIN,'twitter_acc','1=1');
//$adminfacebook=get_single_value (ADMIN,'facebook_acc','1=1');
//$adminsetting=single_row(ADMIN_SETTING,'*','1=1');
//$blog_url=get_single_value(ADMIN_SETTING,'blog_url','1=1');
//$paypal_acc=get_single_value (ADMIN,'paypal_acc','1=1');
//$def_currency = get_single_value (CURRENCY,'symbol','def = 1');
$cur_page_arr = split("/",$_SERVER['PHP_SELF']);
$cur_page = $cur_page_arr[count($cur_page_arr)-1];
if($cur_page=="login.php" || $cur_page=="signup.php")
{
}
else
{
	$_SESSION["page"]=$cur_page;
}
//............search for the menu number [start].............
if (count ($menu) > 0)
{
	foreach ($menu as $k=>$v)
	{
		if (is_array($v[2]) && count ($v[2]) > 0)
		{
			foreach ($v[2] as $k1=>$v1)
			{
				if ($v1[1]==$cur_page)
				{
					$menunum = $v[3];
					$leftmenu = $v1[2];
					break;
				}
			}
		}
	}
}
?>
