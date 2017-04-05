<?php
/**
Handles Forum Posting.
PHP 5
@author Sabrina Markon
@copyright 2017 Sabrina Markon, PHPSiteScripts.com
@license LICENSE.md
 **/
class Talk
{
    private $username;
    private $subject;
    private $message;

    function addPost($username,$neworreply) {

        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $parent_id = 0;

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "insert into talk (parent_id, username, subject, message, dateadded) values (?, ?, ?, ?, NOW())";
        $q = $pdo->prepare($sql);
        $q->execute(array($parent_id, $username, $subject, $message));

        if ($parent_id === 0) {
            $show = 'Topic';
        } else {
            $show = 'Reply';
        }

        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your " . $show . " Was Added!</strong></div>";

    }




}