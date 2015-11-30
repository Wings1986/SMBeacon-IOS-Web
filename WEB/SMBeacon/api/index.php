<?php
require_once 'config.php';
require_once __PATH_TO_MEDIA. 'media.php';
require_once __PATH_TO_COMMON. 'functions.php';
require_once __PATH_TO_API. 'class/AppController.php';

$appObj	=	new AppController();

$action = $_REQUEST['action'];
header('content-type: application/json; charset=utf-8');
if (!isset($action) || empty($action)){
	
	echo '{"msg": "Invalid Request!","success": -1}';
}
else{	
	switch ($action){		
		case 'featured':
			echo $appObj->featured_list($_REQUEST);
			break;
		case 'bookmark':
			echo $appObj->bookmark_list($_REQUEST);
			break;
		case 'getoffer':
		    echo $appObj->getOffer($_REQUEST['beacon']);
		    break;
		default:
			echo '{"msg": "Invalid Request!","result": -1}';
			break;
	}
}

?>