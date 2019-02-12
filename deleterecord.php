<?php
session_start();
?>
<!DOCTYPE html>
<!--
This PHP file that deletes a specific record in the Marvel table
Author: Smitkumar Patel
Student Number: 000737859
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete Record</title>
        <style type="text/css">
            body{
                font-family: sans-serif;
                text-align: center;
                background-color: lightslategray;
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
            
            $heroID = filter_input(INPUT_GET, "heroID", FILTER_SANITIZE_SPECIAL_CHARS);

            //Connects to the database and deletes the record
            if (!empty($_SESSION["username"]) && !empty($_SESSION["password"]) && !($heroID === null)) {
                try {
                    $dbh = new PDO("mysql:host=localhost;dbname=000737859", "000737859", "19990413");
                } catch (Exception $ex) {
                    die("ERROR: Couldn't connect. {$e->getMessage()}");
                }

                //AVOIDING SQL ATTACKS
                $parameter = array($heroID);

                //The SQL command for deleting a record
                $command = "DELETE FROM marvel WHERE heroID = ?";

                $stmt = $dbh->prepare($command);
                $search = $stmt->execute($parameter);

                if ($search) {
                    //Display message if deleting record is successful 
                    echo "<h1>Deleting Record Success</h1>";
                    echo "<p>{$stmt->rowCount()} rows were affected by your query.</p>";
                } else {
                    //Display error message if deleting record is not successful
                    echo "<h1>Deleting Record Fail</h1>";
                }
                echo "<a href='home.php'>Home</a>";
            } else if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
                //Display error message if there is no log in session
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