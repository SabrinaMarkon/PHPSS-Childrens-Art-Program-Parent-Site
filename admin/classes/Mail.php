<?php
class Mail
{
    private $email;
    private $subject;
    private $message;
    private $headers;
    private $pdo;

    public function getAllSavedMails() {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from mail where save='1' order by id desc";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $savedmails = $q->fetchAll();
        $savedmailarray = array();
        foreach ($savedmails as $savedmail) {
            array_push($savedmailarray, $savedmail);
        }
        return $savedmailarray;

    }

    public function editMail($id) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from mail where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $editmail = $q->fetch();
        $found = $q->rowCount();
        Database::disconnect();
        if ($found > 0) {
            return $editmail;
        }
    }

    public function sendMail($id) {

        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $url = $_POST['url'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        if ($id !== '') {
            $sql = "update mail set subject=?, message=?, url=? where id=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($subject, $message, $url, $id));
        } else {
            $sql = "insert into mail set subject=?, message=?, url=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($subject, $message, $url));
        }
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Mail was Sent!</strong></div>";

    }

    public function addMail() {

        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $url = $_POST['url'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "insert into mail set subject=?, message=?, url=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($subject, $message, $url));
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Mail was Added!</strong><br>New URL: <a href=" . $domain . "/" . $slug . ">" . $domain . "/" . $slug . "</a></div>";

    }

    public function saveMail($id) {

        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $url = $_POST['url'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "update mail set subject=?, message=?, url=? where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($subject, $message, $url, $id));
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Mail was Saved!</strong></div>";

    }

    public function deleteMail($id) {

        $name = $_POST['name'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "delete from mail where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Saved Mail Was Deleted</strong></div>";

    }





//    public function sendMail($settings) {
//
//        $subject = $_POST['subject'];
//        $message = $_POST['message'];
//
//        if (isset($username))
//        {
//            $message .= "\n\nSent by Admin\n\n";
//        }
//
//        $sendadminemail = new Mail();
//        $send = $sendadminemail->sendEmail($settings['adminemail'], $settings['adminemail'], $subject, $message, $settings['sitename'], $settings['domain'], $settings['adminemail']);
//
//        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Message was Sent!</strong></div>";
//
//    }
}