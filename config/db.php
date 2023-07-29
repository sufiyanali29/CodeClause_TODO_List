<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'Muzz');
    define('DB_PASS', 'Muzzzzzz1');
    define('DB_NAME', 'notes_app');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($conn->connect_error){
    die('Connection failed' . $conn->connect_error);
}

// echo 'CONNECTED!';

?>