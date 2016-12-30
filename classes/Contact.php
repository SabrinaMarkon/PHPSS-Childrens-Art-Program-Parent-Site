<?php
class Contact
{
	private $username;
	private $email;
	private $subject;
	private $message;
	private $headers;

	public function sendContact($sitename,$domain,$adminemail) {

	$username = $_POST['username'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];

	if (isset($username))
		{
		$message .= "\n\nSent by Username: " . $username . "\n\n";
		}
	
	$sendsiteemail = new Email();
	$send = $sendsiteemail->sendEmail($adminemail,$email,$subject,$message,$sitename,$domain,$adminemail);

	return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Message was Sent!</strong></div>";
	
	}
}