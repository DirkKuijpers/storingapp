<!doctype html>
<html lang="nl">

<head>
    <title>StoringApp</title>
    <?php require_once 'resources/views/components/head.php'; ?>
</head>

<body>

    <?php require_once 'resources/views/components/header.php'; ?>
    <?php
    if(isset($_GET['msg']))
    {
    echo "<div class='msg'>" . $_GET['msg'] . "</div>";
    }
    ?>
    <div class="container home">
        <form action="app/Http/Controllers/loginController.php" method="POST">
            <div class="form-group">
                <label for="username">Gebruikersnaam:</label>
                <input type="text" name="username" id="username">
            </div>
            <label>
            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" name="password" id="password">
            </div>
            <input type="submit" value="Login">
        </form>


    </div>

</body>

</html>
