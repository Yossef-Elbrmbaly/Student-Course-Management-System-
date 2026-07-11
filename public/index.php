<?php

require_once '../config/Database.php';
use Config\Database;

$dbClass = new Database();
$connection = $dbClass->connect();

if ($connection) {
    echo "Database connection successful!";
}