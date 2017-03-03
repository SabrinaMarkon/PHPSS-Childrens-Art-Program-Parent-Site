<?php
/**
 * Handles admin access to the admin area of the application.
 * PHP 5
 * @author Sabrina Markon
 * @copyright 2017 Sabrina Markon, PHPSiteScripts.com
 * @license LICENSE.md
 **/
class Admin
{

    public function adminLogin($username,$password) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from adminsettings where adminuser=? and adminpass=? limit 1";
        $q = $pdo->prepare($sql);
        $q->execute(array($username,$password));
        $valid = $q->rowCount();
        if($valid > 0)
        {
            # successful login.
            $q->setFetchMode(PDO::FETCH_ASSOC);
            $admindetails = $q->fetch();
            return $admindetails;
        }
        else
        {
            # incorrect login.
            return false;
        }
        Database::disconnect();

    }

    public function adminLogout() {

        session_unset();

    }

}