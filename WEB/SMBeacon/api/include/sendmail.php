<?php

	function HtmlMailSend($to,$subject,$mailcontent,$from)
	{
		include_once('class.phpmailer.php');
		$mail = new PHPMailer;
		return $mail->HtmlMailSend($to,$subject,$mailcontent,$from);
	}
	
	function SimpleMailSend($to,$subject,$mailcontent1,$from)
	{
		include_once('class.phpmailer.php');
		$mail = new PHPMailer;
		return $mail->SimpleMailSend($to,$subject,$mailcontent1,$from);
	}	
	
	function SendMail($to,$subject,$mailcontent,$from)
	{
		$array = split("@",$from,2);
		$SERVER_NAME = $array[1];
		$username =$array[0];
		$fromnew = "From: $username@$SERVER_NAME\nReply-To:$username@$SERVER_NAME\nX-Mailer: PHP";
		$res=@mail($to,$subject,$mailcontent,$fromnew);
		return $res;
	}
    function SendHTMLMail($to,$subject,$mailcontent,$from1,$cc="")
	{
			
			$limite = "_parties_".md5 (uniqid (rand()));
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			if ($cc != "")
			{
				$headers .= "Cc: $cc\r\n";
			}
			$headers .= "From: $from1\r\n";
			@mail($to,$subject,$mailcontent,$headers);
	}
?>