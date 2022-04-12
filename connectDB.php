<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$pdoDB = new PDO("mysql:host=$hostname;dbname=product_crud", $username, $password);
$pdoDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//this if i use the first way at identifing $pdoDB
//return $pdoDB;