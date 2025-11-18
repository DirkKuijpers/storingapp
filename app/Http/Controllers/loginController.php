<?php
session_start(); 

// Ingevoerde values
$username = $_POST['username'];
$password = $_POST['password'];

require_once '../../../config/conn.php';

// Query om user op te halen
$query = "SELECT * FROM users WHERE username = :username";
$statement = $conn->prepare($query);
$statement->execute(['username' => $username]);

$user = $statement->fetch(PDO::FETCH_ASSOC);

// Check of account bestaat
if(!$user){
    die("Error: account bestaat niet");
}

// Check wachtwoord
if(!password_verify($password, $user['password'])){
    die("Error: wachtwoord niet     juist!");
}

// Alles ok → inloggen
$_SESSION['user_id'] = $user['id'];

header("Location: ./../../../resources/views/meldingen/index.php?msg=Succesvol ingelogd");
exit;
?>
