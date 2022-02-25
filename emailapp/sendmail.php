<?php 
     
	 if(isset($_POST['to'])){
		 //Get the email class
		 require_once('email_func.php');
		 $test=new PrivateMail();
		 
		 $to=$_POST['to'];
		 $subject =$_POST['subject']; 
		 $message=$_POST['message'];
		 $from = $test->email_select('Default','betkingagent.com');
		 $senderName = 'Betking Agent';
		  

		//  echo $to."<br />";
		//  echo $from."<br />";
		//  echo $subject."<br />";
		//  echo $message."<br />";

		
		//email body content
		$htmlContent =$test->email_format($message, $senderName, "Plain");
		
		
		//email sending status
		$test->sendPlainMail($to,$from,$senderName,$subject,$htmlContent);
		
		echo json_encode(["message"=>"Email Sent"]);
	}else{
		echo json_encode(["message"=>"Email Failed"]);
	}
	
?>

