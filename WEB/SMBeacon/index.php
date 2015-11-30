<?php
session_start();
include ('common/connection.php');
include ('api/media/media.php');
if ($_SESSION['AdminUser'] == "") {
    $URL = "login.php";
    ReDirect($URL);
    exit();
}

$TemplateFile = "template.php";
$page = $_REQUEST['page'];

if (isset($_SESSION['UserID'])) {
    switch ($page) {
        case "settings":
        {
            $Title = "User Profile";
            $user = $db->single_row("administrator", "*", "idx='" . $_SESSION['UserID'] . "'");
            
            if (isset($_POST['UpdateSettings'])) {
                $uid = $_SESSION['UserID'];
                
                $user = array(
                    'username' => $_REQUEST['users_name'],
                    'email' => $_REQUEST['users_email'],
                    'password' => $_REQUEST['users_password']
                )
                // 'telephone' => $_REQUEST['users_cellphone']
                ;
                
                $db->upd_rec("administrator", $user, "idx='$uid'");
                ReDirect('index.php?page=settings&msg=2');
                exit();
            $MiddleContents["page"] = "views/setting.php";
            }
            include ($TemplateFile);
            break;
        }
        /*
         * case "importFeatured":
         *
         * $dir = "pic/phonedp";
         * $dh = opendir($dir);
         * while (false !== ($filename = readdir($dh))) {
         * $files[] = $filename;
         *
         * $basename = pathinfo($filename, PATHINFO_FILENAME); ;
         * $featured	=	array(
         * 'package'		=>	$basename,
         * 'small_icon'	=>	"pic/phonedp/".$filename,
         * 'large_icon'	=>	"pic/sw720dp/".$filename,
         * 'created'		=> date('Y-m-d H:i:s'),
         * );
         * $rid = $db->ins_rec("featured", $featured);
         * print_r($featured);
         * }
         *
         * break;
         */
        case "merchants":
        {
            $Title = "Merchants";
            $mID = $_REQUEST['mID'];
            $merchant = $db->single_row("merchant", "*", "id='$mID'");
            
            if ($_REQUEST['act'] == 'del' && $mID != '') {
                $db->del_rec("merchant", "id='$mID'");
                $db->del_file($merchant['logo']);
                
                ReDirect('index.php?page=merchants&msg=3');
                exit();
            }

            $merchant = $db->sel_rec("merchant", "*");
            $MiddleContents["page"] = "views/merchants.php";
            include ($TemplateFile);
            break;
        }
        case "addmerchant":
        {
            $Title = "Add Merchant";
            if (! empty($_POST['AddMerchant'])) {
                $merchant = array(
                    'business_name' => $_POST['business_name'],
                    'address' => $_POST['address'],
                    'address2' => $_POST['address2'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'zip' => $_POST['zip'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'created'       => date('Y-m-d H:i:s'),
                    'updated'       => date('Y-m-d H:i:s')
                );

                $logo = $_FILES['logo']['tmp_name'];
                if (file_exists($logo) && $logo != "") {
                    $logoPath = "pic/merchantlogo/" . uniqid() . ".png";
                    if ($db->upload_image($_FILES['logo'], $logoPath)) {
                        $merchant['logo'] = $logoPath;
                    }
                }

                $fid = $db->ins_rec("merchant", $merchant);
                ReDirect('index.php?page=merchants&msg=1');
                exit();
            }

            include ($TemplateFile);
            break;
        }
        case "editmerchant":
        {
            $Title = "Edit Merchant";
            $merchant = $db->single_row("merchant", "*", "id='" . $_REQUEST['mID'] . "'");

            if (! empty($_POST['UpdateMerchant'])) {
                $merchant = array(
                    'business_name' => $_POST['business_name'],
                    'address' => $_POST['address'],
                    'address2' => $_POST['address2'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'zip' => $_POST['zip'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'updated' => date('Y-m-d H:i:s')
                );

                $logo = $_FILES['logo']['tmp_name'];
                if (file_exists($logo) && $logo != "") {
                    $logoPath = "pic/merchantlogo/" . uniqid() . ".png";
                    if ($db->upload_image($_FILES['logo'], $logoPath)) {
                        $db->del_file($merchant['logo']);
                        $merchant['logo'] = $logoPath;
                    }
                }

                $db->upd_rec("merchant", $merchant, "id='" . $_POST['mID'] . "'");
                ReDirect('index.php?page=merchants&msg=1');
                exit();
            }
            $MiddleContents["page"] = "views/edit_merchant.php";
            include ($TemplateFile);
            break;
        }

        case "beacon":
        {
            $Title = "Beacons";
            $beacon = $db->sel_rec("beacon", "*", "merchant_id='" . $_REQUEST['mID'] . "'");
            
            if ($_REQUEST['act'] == 'del' && $_REQUEST['bID'] != '') {
                $db->del_rec("beacon", "id='{$_REQUEST['bID']}'");

                ReDirect('index.php?page=beacon&mID=' . $_REQUEST['mID'] . '&msg=3');
                exit();
            }

            $MiddleContents["page"] = "views/beacon.php";
            include ($TemplateFile);
            break;
        }

        case "editbeacon":
        {
            $Title = "Edit Beacon";
            $beacon = $db->single_row("beacon", "*", "id='" . $_REQUEST['bID'] . "'");
    
            if (! empty($_POST['UpdateBeacon'])) {
                $beacon = array(
                    'uuid'          => $_POST['uuid'],
                    'offer_id'      => $_REQUEST['offer_id'],
                    'updated'       => date('Y-m-d H:i:s')
                );

                $db->upd_rec("beacon", $beacon, "id='" . $_REQUEST['bID'] . "'");
                ReDirect('index.php?page=beacon&mID=' . $_REQUEST['mID'] . '&msg=1');
                exit();
            }
            $MiddleContents["page"] = "views/edit_beacon.php";
            include ($TemplateFile);
            break;
        }

        case "addbeacon":
        {
            $Title = "Add Beacon";
            if (! empty($_POST['AddBeacon'])) {
                $beacon = array(
                    'merchant_id'   => $_REQUEST['mID'],
                    'uuid'          => $_POST['uuid'],
                    'created'       => date('Y-m-d H:i:s'),
                    'updated'       => date('Y-m-d H:i:s'),
                    'offer_id'      => $_REQUEST['offer_id'],
                );

                $fid = $db->ins_rec("beacon", $beacon);
                ReDirect('index.php?page=beacon&mID=' . $_REQUEST['mID'] . '&msg=1');
                exit();
            }
            include ($TemplateFile);
            break;
        }

        case "offer":
        {
            $Title = "Offers";
            $offer = $db->sel_rec("offer", "*", "merchant_id='" . $_REQUEST['mID'] . "'");

            if ($_REQUEST['act'] == 'del' && $_REQUEST['oID'] != '') {
                $db->del_file($offer['picture']);
                $db->del_rec("offer", "id='{$_REQUEST['oID']}'");

                ReDirect('index.php?page=offer&mID=' . $_REQUEST['mID'] . '&msg=3');
                exit();
            }

            $MiddleContents["page"] = "views/offer.php";
            include ($TemplateFile);
            break;
        }

        case "editoffer":
        {
            $Title = "Edit Offer";
            $offer = $db->single_row("offer", "*", "id='" . $_REQUEST['oID'] . "'");

            if (! empty($_POST['UpdateOffer'])) {
                $offer = array(
                    'merchant_id'   => $_REQUEST['mID'],
                    'code'          => $_REQUEST['code'],
                    'title'         => $_REQUEST['title'],
                    'description'   => $_REQUEST['description'],
                    'original_price'=> $_REQUEST['original_price'],
                    'offer_price'   => $_REQUEST['offer_price'],
                    'time_limit'    => $_REQUEST['time_limit'],
                    'expire_date'    => $_REQUEST['expire_date'],
                    'updated'       => date('Y-m-d H:i:s')
                );

                $picture = $_FILES['picture']['tmp_name'];
                if (file_exists($picture) && $picture != "") {
                    $picturePath = "pic/offerpicture/" . uniqid() . ".png";
                    if ($db->upload_image($_FILES['picture'], $picturePath)) {
                        $db->del_file($offer['picture']);
                        $offer['picture'] = $picturePath;
                    }
                }

                $db->upd_rec("offer", $offer, "id='" . $_REQUEST['oID'] . "'");
                ReDirect('index.php?page=offer&mID=' . $_REQUEST['mID'] . '&msg=1');
                exit();
            }
            $MiddleContents["page"] = "views/edit_offer.php";
            include ($TemplateFile);
            break;
        }
        
        case "addoffer":
        {
            $Title = "Add Offer";
            if (! empty($_POST['AddOffer'])) {
                $offer = array(
                    'merchant_id'   => $_REQUEST['mID'],
                    'code'          => $_REQUEST['code'],
                    'title'         => $_REQUEST['title'],
                    'description'   => $_REQUEST['description'],
                    'original_price'=> $_REQUEST['original_price'],
                    'offer_price'   => $_REQUEST['offer_price'],
                    'time_limit'    => $_REQUEST['time_limit'],
                    'expire_date'    => $_REQUEST['expire_date'],
                    'created'       => date('Y-m-d H:i:s'),
                    'updated'       => date('Y-m-d H:i:s'),
                );
                
                $picture = $_FILES['picture']['tmp_name'];
                if (file_exists($picture) && $picture != "") {
                    $picturePath = "pic/offerpicture/" . uniqid() . ".png";
                    if ($db->upload_image($_FILES['picture'], $picturePath)) {
                        $offer['picture'] = $picturePath;
                    }
                }

                $fid = $db->ins_rec("offer", $offer);
                ReDirect('index.php?page=offer&mID=' . $_REQUEST['mID'] . '&msg=1');
                exit();
            }
            include ($TemplateFile);
            break;
        }

        /*case "featured":
        {
            $Title = "Featured Apps";
            $fID = $_REQUEST['fID'];
            
            $featured = $db->single_row("featured", "*", "id='$fID'");
            
            if ($_REQUEST['act'] == 'del' && $fID != '') {
                $db->del_rec("featured", "id='$fID'");
                $db->del_file($featured['small_icon']);
                $db->del_file($featured['large_icon']);
                
                ReDirect('index.php?page=featured&msg=3');
                exit();
            }
            $featuredapps = $db->sel_rec("featured", "*");
            $MiddleContents["page"] = "views/featured.php";
            include ($TemplateFile);
            break;
        }
        case "addfeatured":
        {
            $Title = "Add Featured App";
            if (! empty($_POST['AddFeatured'])) {
                
                $featured = array(
                    'package' => $_POST['package'],
                    'created' => date('Y-m-d H:i:s')
                );
                
                $smallIcon = $_FILES['small_icon']['tmp_name'];
                if (file_exists($smallIcon) && $smallIcon != "") {
                    $smallIconPath = "pic/phonedp/" . $_POST['package'] . ".png";
                    if ($db->upload_image($_FILES['small_icon'], $smallIconPath))
                        $featured['small_icon'] = $smallIconPath;
                }
                
                $largeIcon = $_FILES['large_icon']['tmp_name'];
                if (file_exists($largeIcon) && $largeIcon != "") {
                    $largeIconPath = "pic/sw720dp/" . $_POST['package'] . ".png";
                    if ($db->upload_image($_FILES['large_icon'], $largeIconPath))
                        $featured['large_icon'] = $largeIconPath;
                }
                
                $fid = $db->ins_rec("featured", $featured);
                ReDirect('index.php?page=featured&msg=1');
                exit();
            }
            
            include ($TemplateFile);
            break;
        }
        case "editfeatured":
        {
            $Title = "Edit Featured App";
            
            $featured = $db->single_row("featured", "*", "id='" . $_REQUEST['fID'] . "'");
            
            if (! empty($_POST['UpdateFeatured'])) {
                
                $featured = array(
                    'package' => $_POST['package'],
                    'updated' => date('Y-m-d H:i:s')
                );
                
                $smallIcon = $_FILES['small_icon']['tmp_name'];
                if (file_exists($smallIcon) && $smallIcon != "") {
                    $smallIconPath = "pic/phonedp/" . $_POST['package'] . ".png";
                    if ($db->upload_image($_FILES['small_icon'], $smallIconPath))
                        $featured['small_icon'] = $smallIconPath;
                }
                
                $largeIcon = $_FILES['large_icon']['tmp_name'];
                if (file_exists($largeIcon) && $largeIcon != "") {
                    $largeIconPath = "pic/sw720dp/" . $_POST['package'] . ".png";
                    if ($db->upload_image($_FILES['large_icon'], $largeIconPath))
                        $featured['large_icon'] = $largeIconPath;
                }
                
                $db->upd_rec("featured", $featured, "id='" . $_POST['fID'] . "'");
                ReDirect('index.php?page=featured&msg=1');
                exit();
            }
            $MiddleContents["page"] = "views/edit_featured.php";
            include ($TemplateFile);
            break;
        }
        case "bookmark":
        {
            $Title = "Bookmarks";
            $bID = $_REQUEST['bID'];
            
            $bookmark = $db->single_row("bookmark", "*", "id='$bID'");
            
            if ($_REQUEST['act'] == 'del' && $bID != '') {
                $db->del_rec("bookmark", "id='$bID'");
                $db->del_file($bookmark['small_icon']);
                $db->del_file($bookmark['large_icon']);
                
                ReDirect('index.php?page=bookmark&msg=3');
                exit();
            }
            $bookmarks = $db->sel_rec("bookmark", "*");
            $MiddleContents["page"] = "views/bookmark.php";
            include ($TemplateFile);
            break;
        }
        case "addbookmark":
        {
            $Title = "Add Bookmark";
            
            if (! empty($_POST['AddBookmark'])) {
                
                $bookmark = array(
                    'url' => $_POST['url'],
                    'created' => date('Y-m-d H:i:s')
                );
                
                $smallIcon = $_FILES['small_icon']['tmp_name'];
                if (file_exists($smallIcon) && $smallIcon != "") {
                    $smallIconPath = "pic/phonedp/" . $_POST['url'] . ".png";
                    if ($db->upload_image($_FILES['small_icon'], $smallIconPath))
                        $bookmark['small_icon'] = $smallIconPath;
                }
                
                $largeIcon = $_FILES['large_icon']['tmp_name'];
                if (file_exists($largeIcon) && $largeIcon != "") {
                    $largeIconPath = "pic/sw720dp/" . $_POST['url'] . ".png";
                    if ($db->upload_image($_FILES['large_icon'], $largeIconPath))
                        $bookmark['large_icon'] = $largeIconPath;
                }
                
                $bid = $db->ins_rec("bookmark", $bookmark);
                ReDirect('index.php?page=bookmark&msg=1');
                exit();
            }
            
            include ($TemplateFile);
            break;
        }
        case "editbookmark":
        {
            $Title = "Edit Bookmark";
            $bookmark = $db->single_row("bookmark", "*", "id='" . $_REQUEST['bID'] . "'");
            
            if (! empty($_POST['UpdateBookmark'])) {
                
                $bookmark = array(
                    'url' => $_POST['url'],
                    'updated' => date('Y-m-d H:i:s')
                );
                
                $smallIcon = $_FILES['small_icon']['tmp_name'];
                if (file_exists($smallIcon) && $smallIcon != "") {
                    $smallIconPath = "pic/phonedp/" . $_POST['url'] . ".png";
                    if ($db->upload_image($_FILES['small_icon'], $smallIconPath))
                        $bookmark['small_icon'] = $smallIconPath;
                }
                
                $largeIcon = $_FILES['large_icon']['tmp_name'];
                if (file_exists($largeIcon) && $largeIcon != "") {
                    $largeIconPath = "pic/sw720dp/" . $_POST['url'] . ".png";
                    if ($db->upload_image($_FILES['large_icon'], $largeIconPath))
                        $bookmark['large_icon'] = $largeIconPath;
                }
                
                $db->upd_rec("bookmark", $bookmark, "id='" . $_POST['bID'] . "'");
                ReDirect('index.php?page=bookmark&msg=1');
                exit();
            }
            $MiddleContents["page"] = "views/edit_bookmark.php";
            include ($TemplateFile);
            break;
        } */
        case "logout":
        {
            session_destroy();
            $URL = "login.php?Msg=Successfully Logout";
            ReDirect($URL);
            break;
        }
        default:
        {
            $Title = "Admin: Dashboard";
            $MiddleContents["page"] = "views/home.php";
            include ($TemplateFile);
        }
    }
} else {
    session_destroy();
    $URL = "login.php?Msg=Successfully Logout";
    ReDirect($URL);
    break;
}

?>