<?php
session_start();
?>
<!DOCTYPE html>
<!--
This PHP File that updates the attributes of a specific record
Author: Smitkumar Patel
Student Number: 000737859
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Update Record</title>
        <style type="text/css">
            body{
                font-family: sans-serif;
                text-align: center;
                background-color: lightslategrey;
                color: black;
            }
            section{
                margin: 50px auto;
                text-align: center;
                background-color: lightsalmon;
                width: 400px;
                border: medium solid lightpink;
            }
            a{
                display: inline-block;
                margin-bottom: 25px;
                text-decoration: none;
            }
            a:hover{
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <section>
            <?php
            $heroID = filter_input(INPUT_POST, "heroID", FILTER_SANITIZE_SPECIAL_CHARS); //Hero ID of the marvel sanitized 
            $characterName = filter_input(INPUT_POST, "characterName", FILTER_SANITIZE_SPECIAL_CHARS);     //Character Name of the marvel sanitized 
            $realName = filter_input(INPUT_POST, "realName", FILTER_SANITIZE_SPECIAL_CHARS);       //Real Name of the marvel sanitized 
            $skill = filter_input(INPUT_POST, "skill", FILTER_SANITIZE_SPECIAL_CHARS);             //Skill of the marvel sanitized 
            $energyLevel = filter_input(INPUT_POST, "energyLevel", FILTER_SANITIZE_SPECIAL_CHARS);   //Energy level of the marvel sanitized 
            $birthDate = filter_input(INPUT_POST, "birthDate", FILTER_SANITIZE_SPECIAL_CHARS); //Birth Date of the marvel sanitized 
            $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS); //Description of the marvel sanitized 
            
            //To determine if all inputs exist
            $attributes = !($heroID === null || $characterName === null || $realName === null || $skill === null || $energyLevel === null || $birthDate === null || $description === null);

            //Connecting to database and updates the specific record
            if (!empty($_SESSION["username"]) && !empty($_SESSION["password"]) && $attributes) {
                try {
                    $dbh = new PDO("mysql:host=localhost;dbname=000737859", "000737859", "19990413");
                } catch (Exception $ex) {
                    die("ERROR: Couldn't connect. {$e->getMessage()}");
                }

                //AVOIDING SQL ATTACKS
                $parameter = array($characterName, $realName, $skill, $energyLevel, $birthDate, $description, $heroID);

                //The SQL command for updating a record
                $command = "UPDATE marvel SET characterName = ?, realName = ?, skill = ?, energyLevel = ?, birthDate = ?, description = ? WHERE heroID = ?";

                $stmt = $dbh->prepare($command);
                $success = $stmt->execute($parameter);

                if ($success) {
                    //Display this message if updating a record is successful 
                    echo "<h1>Updating Record Success</h1>";
                    echo "<p>{$stmt->rowCount()} rows were affected by your query.</p>";
                } else {
                    //Display error message if updating a record is not successful
                    echo "<h1>Updating Record Fail</h1>";
                }
                echo "<a href='home.php'>Home</a>";
            } else if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
                //Displaying error message if there is no log in session
                echo "<h1>Error, no username and password exist</h1>";
            } else {
                //Display error message if the inputs are not complete
                echo "<h1>Error, no parameter</h1>";
                echo "<a href='home.php'>Home</a>";
            }
            ?>
        </section>
    </body>
</html>
