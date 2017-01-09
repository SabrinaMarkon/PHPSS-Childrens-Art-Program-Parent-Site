<?php
class Money
{

    public function getAllTransactions() {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from transactions order by id";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $transactions = $q->fetchAll();
        $transarray = array();
        foreach ($transactions as $transaction) {
            array_push($transarray, $transaction);
        }
//        print_r($transarray);
//        exit;
        return $transarray;

    }

    public function saveTransaction($id) {

    }

    public function deleteTransaction($id) {

    }

}