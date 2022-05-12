<?php
$pdo = new PDO('mysql:host = localhost;port = 3306;dbname = products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$statment = $pdo ->prepare('SELECT * FROM products ORDER BY create_date DEC ');
//$statment->execute();
//$products = $statment ->fetchAll(PDO::FETCH_ASSOC);
//var_dump($products);
?>