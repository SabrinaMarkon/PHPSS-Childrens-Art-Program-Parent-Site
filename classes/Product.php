<?php
class Product
{
    private $pdo;

    public function getAllProducts() {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from products order by id";
        $q = $pdo->prepare($sql);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $products = $q->fetchAll();
        $productarray = array();
        foreach ($products as $product) {
            array_push($productarray, $product);
        }
        return $productarray;

    }
}