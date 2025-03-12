<?php
include 'database.php';
$pdo;

try {
    $dsn = "mysql:host=$db_host;dbname=library_system;";

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Read the SQL script
    $sqlScript = file_get_contents('../script.sql');
    
    // Execute the SQL script
    $pdo->exec($sqlScript);
    
} catch(PDOException $e){
    http_response_code(500);
    echo "Server Error";
    exit;
}

?>