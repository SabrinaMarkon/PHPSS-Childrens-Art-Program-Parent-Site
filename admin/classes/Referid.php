<?php
/**
 *Populates a select dropdown box with all usernames.
 *Primary purpose is to allow admin to select a sponsor username to apply to a member account.
 *PHP 5
 *@author Sabrina Markon
 *@copyright 2017 Sabrina Markon, PHPSiteScripts.com
 *@license README-LICENSE.txt
 **/
class Referid
{
    private $referid;
    private $referidselectlist;

    function showReferids($referid) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from members where username != '$referid' order by username";
        $q = $pdo->prepare($sql);
        $q->execute(array($referid));
        $referidselectlist = "";
        foreach($pdo->query($sql) as $row)
        {
            $selected = "";
            if ($referid === $row["username"])
            {
                $selected = " selected";
            }
            $referidselectlist .= "<option value=\"" . $row["username"] . "\"" . $selected . ">" . $row["username"] . "</option>";
        }
        Database::disconnect();
        return $referidselectlist;
    }

}