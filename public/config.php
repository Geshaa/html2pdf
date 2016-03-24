<?php
$dsn = 'mysql:dbname=html2pdf;host=localhost';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
    $db->exec('set names utf8');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>