<?php
class Referid
{
    public $referid;
    public $referidselectlist;

    function showReferids($referid) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from mmbers order by username";
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