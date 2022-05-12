<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$pdoDB = new PDO("mysql:host=$hostname;dbname=product_crud", $username, $password);
$pdoDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'] ?? null;
if (!$id) {
    header('location:crud.php');
    exit();
}
$statement = $pdoDB->prepare('DELETE FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
header('location:crud.php');
