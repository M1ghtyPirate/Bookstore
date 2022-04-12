<?php

$host='localhost';
$login='admin_bookstore';
$password='yJjikGbhHyepcAyG';
$dbname='bookstore';
$link = mysqli_connect($host, $login, $password, $dbname);
mysqli_query($link, 'set names utf8');
mysqli_query($link, "SET CHARACTER SET 'utf8'");
mysqli_query($link, "SET SESSION collation_connection = 'utf8_general_ci';");

?>