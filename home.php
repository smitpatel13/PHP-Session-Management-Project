<?php
session_start();
?>
<!DOCTYPE html>
<!--
This PHP file access to user to manipulation of data by updating or deleting etc.
Author: Smitkumar Patel
HOME.PHP
Student Number: 000737859
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <style type="text/css">
            body{
                text-align: center;
                font-family: sans-serif;
                background-color: lime;
                margin: 0;
            }
            h1{
                margin-bottom: 40px;
            }
            table{
                border-collapse: collapse;  
                border: medium solid black;
                margin: 30px auto 30px auto;
            }
            table, th, td{
                border: 2px solid black;
            }
            th{
                width: 160px;
                height: 50px;
                background-color: crimson;
            }
            td{
                text-align: center;
                height: 40px;
                background-color: slateblue;
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
        <?php
        //boolean value if login page is true or false
        $loginPage = false;

        //Validates the log in inputs
        if (empty($_SESSION["username"]) && empty($_SESSION["password"]) && !(empty($_POST["username"]) || empty($_POST["password"]))) {

            //Filter Sanatize the input
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            
            //Filter Sanatize the input
            $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);

            //username and password validation and allows user to access page
            if ($username == "000737859" && $password == "19990413") {
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                $loginPage = true;
            }
        } else if (!empty($_SESSION["username"]) && !empty($_SESSION["password"])) {
            //if username and password is not empty
            $loginPage = true;
        } else {
            //if there is no inputs in sign in page then restrict username from access
            $loginPage = false;
        }
        ?>

        <section>
            <?php if($loginPage) { ?>
                <h1>Welcome <?= $_SESSION["username"] ?></h1>
                <a href="tablemanipulate.php?type=search">Search Record</a>
                <a href="tablemanipulate.php?type=insert">Insert Record</a>

                <?php
                //Connects to database 
                try {
                    $dbh = new PDO("mysql:host=localhost;dbname=000737859", "000737859", "19990413");
                } catch (Exception $ex) {
                    die("ERROR: Couldn't connect. {$e->getMessage()}");
                }

                //SQL command to get all the record from the marvel table
                $command = "SELECT * FROM marvel";

                $stmt = $dbh->prepare($command);
                $stmt->execute();

                $heroID = []; // hero id in marvel table
                $characterName = [];   //Character name in marvel table
                $realName = [];    //Real name in marvel table
                $skill = [];       //Skill in marvel table
                $energyLevel = [];  //Energy Name id in marvel table
                $birthDate = []; //Birth Date in marvel table
                $description = []; //Description in marvel table
                
                //Retrieving all data in specific array or column
                while ($row = $stmt->fetch()) {
                    array_push($heroID, $row["heroID"]);
                    array_push($characterName, $row["characterName"]);
                    array_push($realName, $row["realName"]);
                    array_push($skill, $row["skill"]);
                    array_push($energyLevel, $row["energyLevel"]);
                    array_push($birthDate, $row["birthDate"]);
                    array_push($description, $row["description"]);
                }
                ?>

                
                <table>
                    <tr>
                        <th>Hero ID</th>
                        <th>Character Name</th>
                        <th>Real Name</th>
                        <th>Skill</th>
                        <th>Energy Level</th>
                        <th>Date of Birth</th>
                        <th>Description</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                    <?php for ($index = 0; $index < count($heroID); $index++) { ?>
                        <tr>
                            <td><?= $heroID[$index] ?></td>
                            <td><?= $characterName[$index] ?></td>
                            <td><?= $realName[$index] ?></td>
                            <td><?= $skill[$index] ?></td>
                            <td><?= $energyLevel[$index] ?></td>
                            <td><?= $birthDate[$index] ?></td>
                            <td><?= $description[$index] ?></td>
                            <td><a href="deleterecord.php?heroID=<?= $heroID[$index] ?>">DELETE</a></td>
                            <td><a href="tablemanipulate.php?type=update&heroID=<?= $heroID[$index] ?>">EDIT</a></td>
                        </tr>
                    <?php } ?>
                </table>

            <?php } else { ?>
                <!--Display error message if not restricted to display home page-->
                <h1>Error, no username and password exist </h1>
            <?php } ?>

        </section>
    </body>
</html>

