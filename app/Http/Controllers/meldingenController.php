<?php
require_once '../../../config/conn.php';

// Haal de actie op
$action = $_POST['action'];

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

    if(isset($_POST['prioriteit'])) {
        $prioriteit = 1; // aangevinkt
    } else {
        $prioriteit = 0; // niet aangevinkt
    }

    $melder = $_POST['melder'];
    if(empty($melder)) {
        $errors[] = "Vul de naam van de melder in.";
    }

    $overig = $_POST['overig'];

    // Als er geen errors zijn, update uitvoeren
    if(empty($errors)) {
        require_once '../../../config/conn.php';
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

        // Terugsturen naar index.php
        header("Location: ../../../resources/views/meldingen/index.php?msg=Melding opgeslagen"); 
        exit;
    } else {
        // Hier kun je eventueel errors tonen of terugsturen naar het formulier
        print_r($errors);
    }
}
