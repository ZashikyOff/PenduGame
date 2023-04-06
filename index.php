<?php

session_name('pendu');
session_start();

if (isset($_POST["new-word"]) && $_POST["new-word"] == 1) {
    if (isset($_POST["categorie"])) {
        require "./core/config.php";

        var_dump($_POST["categorie"]);

        //Valeurs du formaulaire
        $categorie = htmlspecialchars($_POST["categorie"]);

        $sql = "SELECT * FROM $categorie";
        $query = $lienDB->prepare($sql);

        // Liaison des paramètres de la requête préparée
        // $query->bindValue(":categorie", $categorie,PDO::PARAM_STR);

        try {
            if ($query->execute()) {
                $result = $query->fetchAll();

                // Longueur max
                $wordselect = rand(0, count($result) - 1);
                echo $wordselect;

                // Label mot select
                $_SESSION["word"] = $result[$wordselect]["label"];
            }
        }
        //catch exception
        catch (PDOException $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
}
if (isset($_POST["key"])) {
    $_SESSION["word"] = $_SESSION["word"];

    $x = 0;
    while ($x < (strlen($_SESSION["word"]))) { 
        ?><p><?= substr($_SESSION["word"], $x, 1); ?></p><?php
        echo $_POST["key"];
        if(strtoupper($_POST["key"]) == substr($_SESSION["word"], $x, 1) || $_POST["key"] == substr($_SESSION["word"], $x, 1)){
            echo "test";
            ?>
            <script type="text/javascript" defer>
                var x = <?= $x ?>;
                console.log(x);
                var TrueLetter = document.querySelector('#letter-<?=$x ?>');
                console.log(TrueLetter);
            </script>
            <?php
        }
                $x++;
            }
        }
                ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <title>Pendu</title>
</head>

<body>
    <form action="" method="post">
        <input type="hidden" name="new-word" value="1">
        <select name="categorie" id="">
            <option value="">--- Categorie ---</option>
            <option value="nourriture">Nourriture</option>
            <option value="animaux">Animaux</option>
            <option value="corphumain">Corps Humain</option>
        </select>
        <button type="submit">New Word</button>
    </form>
    <main class="pendu">
        <div id="search">
            <?php
            if (isset($_SESSION["word"])) {
                $x = 0;
                while ($x < (strlen($_SESSION["word"]))) { ?>
                    <p id="letter-<?= $x ?>">_</p><?php
                            $x++;
                        }
                    }
                            ?>
        </div>
        <div class="keyboard">
            <?php
            $i = 1;
            for ($x = "a"; $i <= 26; $x++) {
            ?><form action="" method="post">
                    <input type="hidden" name="key" value="<?= $x ?>">
                    <button type="submit"><?= $x ?></button>
                </form><?php
                        $i++;
                    }
                        ?>
        </div>
    </main>
</body>

</html>