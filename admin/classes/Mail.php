<?php
/**
 *Methods to support Admin mailing to membership.
 *PHP 5
 *@author Sabrina Markon
 *@copyright 2017 Sabrina Markon, PHPSiteScripts.com
 *@license README-LICENSE.txt
 **/
class Mail
{
    private $email;
    private $url;
    private $subject;
    private $message;
    private $headers;
    private $pdo;

    public function getAllSavedMails() {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from mail where save=1 order by id desc";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $savedmails = $q->fetchAll();
        $savedmailarray = array();
        foreach ($savedmails as $savedmail) {
            array_push($savedmailarray, $savedmail);
        }
        Database::disconnect();
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

    public function saveMail($id) {

        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $url = $_POST['url'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "update mail set subject=?, message=?, url=?, save=1 where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($subject, $message, $url, $id));
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Mail was Saved!</strong></div>";

    }

    public function addMail() {

        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $url = $_POST['url'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "insert into mail set subject=?, message=?, url=?, save=1";
        $q = $pdo->prepare($sql);
        $q->execute(array($subject, $message, $url));
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Mail was Added!</strong></div>";

    }

    public function sendMail($id) {

        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $url = $_POST['url'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        if ($id !== '') {
            $sql = "update mail set subject=?, message=?, url=?, needtosend=1 where id=?";
            $q = $pdo->prepare($sql);
            $q->execute(array($subject, $message, $url, $id));
        } else {
            $sql = "insert into mail set subject=?, message=?, url=?, needtosend=1";
            $q = $pdo->prepare($sql);
            $q->execute(array($subject, $message, $url));
        }
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Mail was Sent!</strong></div>";

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



}