<?php
#========================================================#
#============ WEBMAIL OPERATIONS  ===========#
#========================================================#

class PrivateMail {
	//define variables here
	
	/*Select the custom Email to send from 
	($domain e.g. betkingagent.com; $sendfrom e.g. Admin, Sales)*/
	public function email_select($sendfrom,$domain){
	   //Select email
	   if($sendfrom=="Admin"){
		  $email="admin@".$domain; 
	   }elseif($sendfrom=="Customer Care"){
		  $email="customercare@".$domain; 
	   }elseif($sendfrom=="Support"){
		  $email="support@".$domain; 
	   }elseif($sendfrom=="Careers"){
		  $email="careers@".$domain; 
	   }elseif($sendfrom=="Sales"){
		  $email="sales@".$domain; 
	   }elseif($sendfrom=="Non-reply"){
		  $email="non-reply@".$domain; 
	   }elseif($sendfrom=="News"){
		  $email="news@".$domain; 
	   }elseif($sendfrom=="Default"){
		$email="info@".$domain; 
	   }else{
		   $email="info@".$domain;
	   }
	   
	   return $email;
	}
	

    public function email_format($message, $senderName, $mail_type){
	   if($mail_type=="Plain"){
		  $mail_body='
		            '.$message.'
					<br />
					Kind Regards<br /><br />
					Management<br />
					'.$senderName.'
					<br /><br />
		            <a href="https://betkingagent.com/" target="_blank">
					  <img src="https://betkingagent.com/assets/images/logo.png" width="150" height="80" border="0" alt="Our Logo" />
					</a><br />
					<p><strong style="color:#000;">Website:</strong>&nbsp;<span style="color:#333;"><a href="https://betkingagent.com/" target="_blank">www.betkingagent.com</a></span></p>
					<p><strong style="color:#000;">Email:</strong>&nbsp;<span style="color:#333;">info@betkingagent.com</span></p>
					<p><strong style="color:#000;">Mobile:</strong>&nbsp;<span style="color:#333;">+234 (803) 795 1316</span></p>';
					
	   }
	   
	   return $mail_body;
	}
  
     
	/*Get mail attachment-($file_dir is the location of uploaded file)*/
	public function get_attachment($file_source,$file_dir,$email_id,$create_time,$uniq_name){
	     
		$attach_name="Attachment_".$email_id."_".$create_time."_".$uniq_name;
		$tmp_file = $_FILES[$file_source]['tmp_name'];
		
		//Upload attachment
		move_uploaded_file($tmp_file,$file_dir."".$attach_name);
		$attachment =$file_dir."".$attach_name;
	   
	    return $attachment;
	}

		//Email function with attachment ($senderName e.g. FredyTech Admin)
		public function sendAttachMail($to,$from,$senderName,$subject,$htmlContent,$attachment){
			//header for sender info
			$headers = "From: $senderName"." <".$from.">";
	
			//boundary 
			$semi_rand = md5(time()); 
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
	
			//headers for attachment 
			$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
			// Cc email
			$headers .= "\nCc: info@betkingagent.com";
	
			// Bcc email
			$headers .= "\nBcc: info@betkingagent.com";
	
			//multipart boundary 
			$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
			"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
	
			//preparing attachment
			if(!empty($attachment) > 0){
				if(is_file($attachment)){
					$message .= "--{$mime_boundary}\n";
					$fp =    @fopen($attachment,"rb");
					$data =  @fread($fp,filesize($attachment));
	
					@fclose($fp);
					$data = chunk_split(base64_encode($data));
					$message .= "Content-Type: application/octet-stream; name=\"".basename($attachment)."\"\n" . 
					"Content-Description: ".basename($attachment)."\n" .
					"Content-Disposition: attachment;\n" . " filename=\"".basename($attachment)."\"; size=".filesize($attachment).";\n" . 
					"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
				}
			}
			
			$message .= "--{$mime_boundary}--";
			$returnpath = "-f" . $from;
	
			//send email
			$mail = @mail($to, $subject, $message, $headers, $returnpath);
		}
		
		
		//Email function with attachment ($senderName e.g. FredyTech Admin)
		public function sendMultiAttachMail($to,$from,$senderName,$subject,$htmlContent,$attachArray){
			//header for sender info
			$headers = "From: $senderName"." <".$from.">";
	
			//boundary 
			$semi_rand = md5(time()); 
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
	
			//headers for attachment 
			$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
			// Cc email
			$headers .= "\nCc: info@betkingagent.com";
	
			// Bcc email
			$headers .= "\nBcc: info@betkingagent.com";
	
			//multipart boundary 
			$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
			"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
	
			//preparing attachment
			if(!empty($attachArray) > 0){
				foreach($attachArray as $attachment){
					if(is_file($attachment)){
						$message .= "--{$mime_boundary}\n";
						$fp =    @fopen($attachment,"rb");
						$data =  @fread($fp,filesize($attachment));
	
						@fclose($fp);
						$data = chunk_split(base64_encode($data));
						$message .= "Content-Type: application/octet-stream; name=\"".basename($attachment)."\"\n" . 
						"Content-Description: ".basename($attachment)."\n" .
						"Content-Disposition: attachment;\n" . " filename=\"".basename($attachment)."\"; size=".filesize($attachment).";\n" . 
						"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
					}
				}
			}
			
			$message .= "--{$mime_boundary}--";
			$returnpath = "-f" . $from;
	
			//send email
			$mail = @mail($to, $subject, $message, $headers, $returnpath);
		}
		
		
		//Email function with attachment ($senderName e.g. FredyTech Admin)
		public function sendPlainMail($to,$from,$senderName,$subject,$htmlContent){
			//header for sender info
			$headers = "From: $senderName"." <".$from.">";
	
			//boundary 
			$semi_rand = md5(time()); 
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
	
			//headers for attachment 
			$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
			
			// Cc email
			$headers .= "\nCc: info@betkingagent.com";
	
			// Bcc email
			$headers .= "\nBcc: info@betkingagent.com";
	
			//multipart boundary 
			$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
			"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
	
			$message .= "--{$mime_boundary}--";
			$returnpath = "-f" . $from;

			//Set init configuration
			ini_set("sendmail_from", "info@betkingagent.com");
			ini_set("sendmail_from", "info@betkingagent.com");
	
			//send email
			$mail = @mail($to, $subject, $message, $headers, $returnpath);
		}

	
}

?>