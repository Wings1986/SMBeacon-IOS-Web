<?php
class AppController
{	
	public function featured_list($dataArr)
	{	
		$featuredList    = array();

		$packages = trim($dataArr['packages']);
		$packages = substr($packages, 1, -1);

		$packageList = explode(",", $packages); 

		for ($i=0;$i<count($packageList);$i++){
			$secPackage = trim($packageList[$i]);
			
			if (Database::single_row("featured", "*", "package='".$secPackage."'"))
				$featuredList[] = $secPackage;
		}
		
		return '{"featured": '.json_encode($featuredList).'}';
	}

	public function bookmark_list($dataArr)
	{	
		$bookmarkList    = array();

		$getBookmarks = Database::sel_rec("bookmark", "*");
		while ($b = mysql_fetch_array($getBookmarks)){
			$bookmarkList[] = $b['url'];
		}
	
		return '{"bookmarks": '.json_encode($bookmarkList).'}';
	}
	
	public function getOffer( $beacon ) {

	    $data = array();
	    $data3 = array();
	    
	    $row = Database::single_row("beacon", "*", "uuid='".$beacon."'");


	    if ( $row ) {
	        $row2 = Database::single_row("offer", "*", "id='".$row['offer_id']."'");

	        if ( $row2 ) {
	            $data['offerID'] = $row2['id'];
	            $data['offerTitle'] = $row2['title'];
	            $data['offerDescription'] = $row2['description'];
	            $data['offerPicture'] = SURL.$row2['picture'];
	            $data['offerOriginalPrice'] = $row2['original_price'];
	            $data['offerOfferPrice'] = $row2['offer_price'];
	            $data['offerTimeLimit'] = $row2['time_limit'];
	            $data['offerExpireDate'] = $row2['expire_date'];
	            $data['offerCode'] = $row2['code'];
	            $data['merchantID'] = $row2['merchant_id'];

	            $row3 = Database::single_row("merchant", "*", "id='".$data['merchantID']."'");

	            if ( $row3 ) {
	                $data3['merchantID'] = $row3['id'];
	                $data3['merchantName'] = $row3['business_name'];
	                $data3['merchantAddress'] = $row3['address'];
	                $data3['merchantAddress2'] = $row3['address2'];
	                $data3['merchantCity'] = $row3['city'];
	                $data3['merchantState'] = $row3['state'];
	                $data3['merchantZip'] = $row3['zip'];
	                $data3['merchantEmail'] = $row3['email'];
	                $data3['merchantPhone'] = $row3['phone'];
	                $data3['merchantLogo'] = SURL.$row3['logo'];
// 	                $data3['merchantCreated'] = $row3['created'];
// 	                $data3['merchantUpdated'] = $row3['updated'];
	            }
	        }
	    }
	    
	    $jd = array ( 'offer' => $data, 'merchant' => $data3 );
	    return json_encode( $jd );
	}
 }
 
 
 