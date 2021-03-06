<?php
/**
 *Handles admin changing site settings.
 *PHP 5
 *@author Sabrina Markon
 *@copyright 2017 Sabrina Markon, PHPSiteScripts.com
 *@license LICENSE.md
 **/
class Setting
{

    public function saveSettings() {

        $adminuser = $_POST['adminuser'];
        $adminpass = $_POST['adminpass'];
        $adminemail = $_POST['adminemail'];
        $sitename = $_POST['sitename'];
        $domain = $_POST['domain'];
        $adminpaypal = $_POST['adminpaypal'];

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update adminsettings set adminuser=?, adminpass=?, adminemail=?, sitename=?, domain=?, adminpaypal=?";
        $q = $pdo->prepare($sql);
        $q-> execute(array($adminuser, $adminpass, $adminemail, $sitename, $domain, $adminpaypal));
        Database::disconnect();

        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Your Site Settings Were Saved!</strong></div>";

    }

}