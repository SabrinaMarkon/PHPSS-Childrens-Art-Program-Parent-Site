<?php
class Mail
{
    private $email;
    private $subject;
    private $message;
    private $headers;

    public function sendContact($settings) {

        $subject = $_POST['subject'];
        $message = $_POST['message'];

        if (isset($username))
        {
            $message .= "\n\nSent by Admin\n\n";
        }

        $sendadminemail = new Email();
        $send = $sendadminemail->sendEmail($settings['adminemail'], $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['domain'], $settings['adminemail']);

        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Message was Sent!</strong></div>";

    }
}