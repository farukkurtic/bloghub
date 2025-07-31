<?php

define('DB_HOST', 'localhost'); 
define('DB_USER', 'faruk21');
define('DB_PASSWORD', 'farukkurtic');
define('DB_NAME', 'blogapp'); 

$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if($connection->connect_error) {
    die("Database connection could not be established. Error: " . $connection->connect_error);
};
