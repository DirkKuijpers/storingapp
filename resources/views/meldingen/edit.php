<!doctype html>
<html lang="nl">

<head>
    <title>StoringApp / Meldingen / Aanpassen</title>
    <?php require_once '../components/head.php'; ?>
</head>

<body>
<?php 
if(!isset($_GET['id'])){
    echo "Geef in je aanpaslink op de index.php het id van betreffende item mee.";
    exit;
}
require_once '../components/header.php'; 
?>

<div class="container">
    <h1>Melding aanpassen</h1>

    <?php
    // Haal het id uit de URL
    $id = $_GET['id'];

    // 1. Verbinding
    require_once '../../../config/conn.php';

    // 2. Query: haal alleen de melding met dit id
    $query = "SELECT * FROM meldingen WHERE id = :id";

    // 3. Prepare
    $statement = $conn->prepare($query);

    // 4. Execute met placeholder
    $statement->execute([':id' => $id]);

    // 5. Ophalen gegevens
    $melding = $statement->fetch(PDO::FETCH_ASSOC);

    if(!$melding){
        echo "Geen melding gevonden met id $id";
        exit;
    }
    // print_r($melding); // kun je tijdelijk gebruiken voor testen
    ?>

    <!-- Formulier -->
    <form action="<?php echo $base_url; ?>/app/Http/Controllers/meldingenController.php" method="POST">
        <input type="hidden" name="action" value="update"> <!-- toegevoegd -->
        <input type="hidden" name="id" value="<?php echo $melding['id']; ?>"> <!-- toegevoegd -->

        <div class="form-group">
            <label>Naam attractie:</label>
            <p style="margin:0;"><?php echo $melding['attractie']; ?></p>
        </div>

        <div class="form-group">
            <label>Type:</label>
            <p style="margin:0;"><?php echo $melding['type']; ?></p>
        </div>

        <!-- Daarna de andere velden -->
        <div class="form-group">
            <label for="capaciteit">Capaciteit p/uur:</label>
            <input type="number" min="0" name="capaciteit" id="capaciteit" class="form-input"
                value="<?php echo $melding['capaciteit']; ?>">
        </div>

        <div class="form-group">
            <label for="prioriteit">Prio:</label>
            <input type="checkbox" name="prioriteit" id="prioriteit"
                <?php echo ($melding['prioriteit'] == 1) ? "checked" : ""; ?>>
            <label for="prioriteit">Melding met prioriteit</label>
        </div>

        <div class="form-group"> 
            <label for="melder">Naam melder:</label>
            <input type="text" name="melder" id="melder" class="form-input" 
                value="<?php echo $melding['melder']; ?>">
        </div>

        <div class="form-group">
            <label for="overig">Overige info:</label>
            <textarea name="overig" id="overig" class="form-input" rows="4"><?php echo $melding['overige_info']; ?></textarea>
        </div>

        <input type="submit" value="Melding opslaan">
    </form>
    <hr>
    <form action="<?php echo $base_url; ?>/app/Http/Controllers/meldingenController.php" method="POST">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="submit" value="Verwijderen">
    </form>

</div>  

</body>
</html>