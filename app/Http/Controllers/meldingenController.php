<?php
require_once '../../../config/conn.php';
session_start();
if(!isset($_SESSION['user_id'])){
 $msg = "Je moet eerst inloggen!";
 header("Location: ../../../login.php?msg=$msg");
 exit; 
}
// Haal de actie op
$action = $_POST['action'];
$errors = []; // toevoegen


if($action == "create") {

    //Variabelen vullen
    $attractie = $_POST['attractie'];
    if(empty($attractie))
    {
        $errors[] = "Vul de attractie-naam in.";
    }
    $type = $_POST['type'];
    if(empty($type))
    {
        $errors[] = "Vul de type in.";
    }
    $capaciteit = $_POST['capaciteit'];
    if(!is_numeric($capaciteit))
    {
        $errors[] = "Vul voor capaciteit een geldig getal in.";
    }
    if (isset($_POST['prioriteit'])) {
        $prioriteit = 1; // aangevinkt
    } else {
        $prioriteit = 0; // niet aangevinkt
    }
    $melder = $_POST['melder'];
    if(empty($melder))
    {
        $errors[] = "Vul de naam van de melder in.";
    }
    $overig = $_POST['overig'];

    echo $attractie . " / " . $type . " / " . $capaciteit . " / " . $prioriteit . " / " . $melder . " / " . $overig ;

    //2. Query
    $query = "INSERT INTO meldingen (attractie, type, capaciteit, prioriteit, melder, overige_info)
    VALUES(:attractie, :type, :capaciteit, :prioriteit, :melder, :overige_info)";

    //3. Prepare
    $statement = $conn->prepare($query);

    //4. Execute
    $statement->execute( [
        ":attractie" => $attractie,
        ":type" => $type,
        ":capaciteit" => $capaciteit,
        ":prioriteit" => $prioriteit,
        ":melder" => $melder,
        ":overige_info" => $overig,
    ]);

    header("Location: ../../../resources/views/meldingen/index.php?msg=Melding opgeslagen"); 
}

if($action == "update") {
    $id = $_POST['id'];
    $capaciteit = $_POST['capaciteit'];
    if(!is_numeric($capaciteit)) {
        $errors[] = "Vul voor capaciteit een geldig getal in.";
    }

    $prioriteit = isset($_POST['prioriteit']) ? 1 : 0;
    $melder = $_POST['melder'];
    if(empty($melder)) {
        $errors[] = "Vul de naam van de melder in.";
    }
    $overig = $_POST['overig'];

    if(empty($errors)) {
        $query = "UPDATE meldingen 
                  SET capaciteit = :capaciteit, 
                      prioriteit = :prioriteit, 
                      melder = :melder, 
                      overige_info = :overige_info
                  WHERE id = :id";
        $statement = $conn->prepare($query);
        $statement->execute([
            ":capaciteit" => $capaciteit,
            ":prioriteit" => $prioriteit,
            ":melder" => $melder,
            ":overige_info" => $overig,
            ":id" => $id
        ]);
        header("Location: ../../../resources/views/meldingen/index.php?msg=Melding opgeslagen"); 
        exit;
    } else {
        print_r($errors);
    }
}

if($action == "delete") {
    $id = $_POST['id'];
    $query = "DELETE FROM meldingen WHERE id = :id";
    $statement = $conn->prepare($query);
    $statement->execute([":id" => $id]);
    header("Location: ../../../resources/views/meldingen/index.php?msg=Melding verwijderd"); 
    exit;
}
?>
