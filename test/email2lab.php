<?php
//collect post data and send email

//if success send ajax response
$mailTo = $_POST['emailid'];
$orderId = $_POST['id'];
$fileName = $_POST['filename'];
$temp_dir = $_SERVER['DOCUMENT_ROOT']."/labPdf";
$from = "help@mail.digbyduke.com";
//$from ="dalena.vikas@digbyduke.com";
$subject = "Attn: New Order".$orderId ." from digbyduke" ;

$body ="hi, please find attached a new order (Order No:" . $orderId . ") from digbyduke" ;

$attachmentName = $orderId .'_digbyduke.pdf';

//$pdf_file_path =  $temp_dir . DIRECTORY_SEPARATOR .  $filename;


$pdf_file_path = 'labPdf/'.$fileName ;

//$pdf_file_path = 'labPdf/492920705.pdf'
//$attachment = array($pdf_file_path, "hello post");

$attachment = array($pdf_file_path, $attachmentName);

//Send_Email("indyavik@gmail.com","dalena@digbyduke.com","Testing Email","hello testing",$attachment);

Send_Email($mailTo,$from,$subject,$body,$attachment,$orderId);

/*
if (file_exists($pdf_file_path)) {

		//$attachment = array($pdf_file_path, $filename);

		$attachment = array($pdf_file_path, "fileAsRequested");

	Send_Email($mailTo,$from,$subject,$body,$attachment);
}
*/
function Send_Email($MailTo,$MailFrom,$Subject,$BodyContent, $attachment = array(),$orderName)// $attachment params, 0 = file path, attachment file name
	{
		//global $TemplateHTMLTags;
		//global $TemplateBodyContent;

		// carriage return type (we use a PHP end of line constant)
		$eol = PHP_EOL;

		$headers  = "MIME-Version: 1.0" . $eol;
		$headers .= "Content-type:text/html;charset=iso-8859-1" . $eol;
		$headers .= "From: $MailFrom";

		/*
		echo "Template Body Content: ". $TemplateBodyContent;
		echo "<hr>";
		echo "Body Content: ". $BodyContent;
		echo "<hr>";
		echo "Template HTML Tags". $TemplateHTMLTags;
		exit();
		*/

		//$RealContent = str_replace($TemplateBodyContent,$BodyContent,$TemplateHTMLTags);
		$RealContent = $BodyContent;


		// attachment

		if(is_array($attachment) && count($attachment) && $attachment[0] && file_exists($attachment[0])) {

			$attachment_file_name = $attachment[0];

			// attachment name
			$filename = isset($attachment[1])?$attachment[1]:basename($attachment[0]);

			// a random hash will be necessary to send mixed content
			$separator = md5(time());

			// encode data (puts attachment in proper format)
			$pdfdoc = file_get_contents($attachment_file_name);
			$attachment_file_content = chunk_split(base64_encode($pdfdoc));


			// main header (multipart mandatory)
			$headers  = "From: ".$MailFrom .$eol;
			$headers .= "MIME-Version: 1.0".$eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;

			//$headers .= "Content-Transfer-Encoding: 7 bit".$eol;

			$headers .= "This is a MIME encoded message.".$eol.$eol;

			// message
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
			$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$headers .= $RealContent .$eol.$eol;

			// attachment
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
			$headers .= "Content-Transfer-Encoding: base64".$eol;
			$headers .= "Content-Disposition: attachment".$eol.$eol;
			$headers .= $attachment_file_content .$eol.$eol;
			$headers .= "--".$separator."--";


		}


		if(@mail($MailTo,$Subject,$RealContent,$headers))
		{
			##update the database
			require 'mongoConn.php';
			//$orderName = $orderId;
			$query = array('$set' => array("lab_attributes.orderStatus" => "email_sent_to_lab"));
			$coll->update(array('name' =>$orderName),$query); //$coll->update(array('name' =>"1104"),$query);
			//$query = $coll->findOne(array('id'=>806188225));

			return true;
		}
		else
		{
			return false;
		}
	}

?>
