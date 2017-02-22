<?php
/**
 *Handles admin adding, updating, or deleting products for sale on the website (such as classes).
 *PHP 5
 *@author Sabrina Markon
 *@copyright 2017 Sabrina Markon, PHPSiteScripts.com
 *@license README-LICENSE.txt
 **/
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

    public function editProduct($id) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "select * from products where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $editproduct = $q->fetch();
        $found = $q->rowCount();
        Database::disconnect();
        if ($found > 0) {
            return $editproduct;
        }
    }

    public function addProduct() {

        $name = $_POST['name'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $commission = $_POST['commission'];

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "insert into `products` set name=?, description=?, quantity=?, price=?, commission=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($name, $description, $quantity, $price, $commission));
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>New Product " . $name . " was Added!</strong></div>";

    }

    public function saveProduct($id) {

        $name = $_POST['name'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $commission = $_POST['commission'];

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "update products set name=?, description=?, quantity=?, price=?, commission=? where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($name, $description, $quantity, $price, $commission, $id));
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Product " . $name . " was Saved!</strong></div>";

    }

    public function deleteProduct($id, $name) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "delete from products where id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        return "<center><div class=\"alert alert-success\" style=\"width:75%;\"><strong>Product " . $name . " was Deleted</strong></div>";

    }

}