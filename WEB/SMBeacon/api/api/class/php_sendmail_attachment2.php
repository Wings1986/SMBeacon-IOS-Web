<html>
<head>
<title>ShotDev.Com Tutorial</title>
</head>
<body>
<?
	$strTo = "Mr.Member ShotDev.Com<wangdasan@hotmail.com>";
	$strSubject = "Test sending mail.";
	$strMessage = "My Body & <b>My Description</b>";

	//*** Uniqid Session ***//
	$strSid = md5(uniqid(time()));

	$strHeader = "";
	$strHeader .= "From: Mr.Weerachai Nukitram<webmaster@shotdev.com>\nReply-To: webmaster@shotdev.com\n";
	$strHeader .= "Cc: Mr.Surachai Sirisart<surachai@shotdev.com>\n";
	$strHeader .= "Bcc: webmaster@shotdev.com";

	$strHeader .= "MIME-Version: 1.0\n";
	$strHeader .= "Content-Type: multipart/mixed; boundary=\"".$strSid."\"\n\n";
	$MSG = "This is a multi-part message in MIME format.\n";

	$MSG .= "--".$strSid."\n";
	$MSG .= "Content-type: text/html; charset=windows-874\n"; // or UTF-8 //
	$MSG .= "Content-Transfer-Encoding: 7bit\n\n";
	$MSG .= $strMessage."\n\n";
	
	//*** Attachment Files ***//
	$arrFiles[] = "my1.txt";
	$arrFiles[] = "my2.txt";
	$arrFiles[] = "my3.txt";
	$arrFiles[] = "my4.txt";
	$arrFiles[] = "my5.txt";

	for($i=0;$i<count($arrFiles);$i++)
	{
		if(trim($arrFiles[$i]) != "")
		{
			$strFilesName = $arrFiles[$i];
			$strContent = chunk_split(base64_encode(file_get_contents($strFilesName))); 

			$MSG .= "--".$strSid."\n";
			$MSG .= "Content-Type: application/octet-stream; name=\"".$strFilesName."\"\n"; 
			$MSG .= "Content-Transfer-Encoding: base64\n";
			$MSG .= "Content-Disposition: attachment; filename=\"".$strFilesName."\"\n\n";
			$MSG .= $strContent."\n\n";
		}
	}
		
	$flgSend = @mail($strTo,$strSubject,$MSG,$strHeader);  // @ = No show error //
	if($flgSend)
	{
		echo "Mail send completed.";
	}
	else
	{
		echo "Cannot send mail.";
	}
?>
</body>
</html>
<!--- This file download from www.shotdev.com -->