<?php
session_start();
//Sanatize the inputs
$type = filter_input(INPUT_GET, "type", FILTER_SANITIZE_SPECIAL_CHARS); 
?>
<!DOCTYPE html>
<!--
This PHP File displays all kinds of functions used for manipulation of data 
Author: Smitkumar Patel
Student Number: 000737859
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Table Manipulation</title>
        <style type="text/css">
            body{
                font-family: sans-serif;
                text-align: center;
                background-color: lightslategray;
            }
            form, section{
                margin: 40px 0;
                display: inline-block;
                border: medium solid lightpink;
                background-color: lightsalmon;
                color: black;
            }
            section{
                margin: 50px auto;
                width: 400px;
            }
            fieldset{
                margin: 20px 20px;
                border: none;
            }
            input{
                display: block;
            }
            label{
                text-align: left;
                float: left;
                clear: left;
                width: 150px;
            }
            input, textarea{
                width: 200px;
            }
            textarea{
                height: 50px;
            }
            input[type="submit"]{
                margin: 20px 0 0 0;
                width: 100px;
            }
            a{
                text-decoration: none;
                margin: 0px 10px 0px 10px;
            }
            a:hover{
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <!--Displays error message if there is no log in session-->
        <?php if (empty($_SESSION["username"]) || empty($_SESSION["password"])) { ?>
            <section>
                <h1>Error, no username and password exist</h1>
            </section>
        <!--Display a form which is used to search a specific record-->
        <?php } else if ($type == "search") { ?>
            <h1>Search Record</h1>
            <form action='searchrecord.php' method='GET'>
                <fieldset>
                    <label>Hero ID</label>
                    <input type='number' name='heroID' required="required">
                    <input type='submit'>
                    <a href='home.php'>Back</a>
                </fieldset>
            </form>
        <!--Display a form which is used to insert a new record-->
        <?php } else if ($type == "insert") { ?>
            <h1>Insert Record</h1>
            <form action='addrecord.php' method='POST'>
                <fieldset>
                    <label>Hero ID</label>
                    <input type='number' name='heroID'>
                    <label>Character Name</label>
                    <input type='text' name='characterName' required="required">
                    <label>Real Name</label>
                    <input type='text' name='realName' required="required">
                    <label>Skill</label>
                    <input type='text' name='skill' required="required">
                    <label>Energy Level</label>
                    <input type="number" name='energyLevel' required="required">
                    <label>Birth Date</label>
                    <input type='date' name='birthDate' required="required">
                    <label>Description</label>
                    <textarea name="description"></textarea>
                    <input type='submit'> 
                    <a href='home.php'>Back</a>
                </fieldset>
            </form>
        <!--Display a form used to update the data-->
        <?php } else if ($type == "update" && !empty($_GET["heroID"])) { ?>
            <?php
            // php script used for getting data 
            try {
                $dbh = new PDO("mysql:host=localhost;dbname=000737859", "000737859", "19990413");
            } catch (Exception $ex) {
                die("ERROR: Couldn't connect. {$e->getMessage()}");
            }

            //hero ID santatize
            $heroID = filter_input(INPUT_GET, "heroID", FILTER_SANITIZE_SPECIAL_CHARS);

            //FOR AVOIDING SQL ATTACKS
            $parameter = array($heroID);

            //SQL command used to get data from marvel table
            $command = "SELECT characterName, realName, skill, energyLevel, birthDate, description FROM marvel WHERE heroID = ?";

            $stmt = $dbh->prepare($command);
            $search = $stmt->execute($parameter);
            $row = $stmt->fetch();
            ?>
            <h1>Update Record</h1>
            <form action="updaterecord.php" method='POST'>
                <fieldset>
                    <input type="hidden" name="heroID" value="<?= $heroID ?>">
                    <label>Character Name</label>
                    <input type='text' name='characterName' value="<?= $row["characterName"] ?>"> 
                    <label>Real Name</label>
                    <input type='text' name='realName' value="<?= $row["realName"] ?>">
                    <label>Skills</label>
                    <input type='text' name='skill' value="<?= $row["skill"] ?>">
                    <label>Energy Level</label>
                    <input type="number" name='energyLevel' value="<?= $row["energyLevel"] ?>">
                    <label>Birth Date</label>
                    <input type='date' name='birthDate' value="<?= $row["birthDate"] ?>">
                    <label>Description</label>
                    <textarea name="description"><?= $row["description"] ?></textarea>
                    <input type='submit'>
                    <a href='home.php'>Back</a>
                </fieldset>
            </form>
        <?php } else { ?>
            <section>
                <h1>Error, no parameter</h1>
                <a href='home.php'>Back</a>
            </section>
        <?php } ?>
    </body>
</html>