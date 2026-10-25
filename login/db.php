<?php
$host = "ep-solitary-forest-b51hlce9-pooler.c-7.us-east-2.aws.neon.tech";
$port = "5432";
$dbname = "library_db";
$user = "library_db_owner";

// Read the complete Neon password from an environment variable
$password = getenv("DB_PASSWORD");

if ($password === false || $password === "") {
    error_log("DB_PASSWORD environment variable is missing.");
    die("Database connection configuration is missing.");
}

try {
    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Database connection failed. Check connection settings.");
}
?>

