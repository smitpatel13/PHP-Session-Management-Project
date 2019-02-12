<?php
session_start();
?>
<!DOCTYPE html>
<!--
This PHp file is used to search specific data by using ID
Author: Smitkumar Patel
Student Number: 000737859
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Search Record</title>
        <style type="text/css">
            body{
                font-family: sans-serif;
                background-color: greenyellow;
                color: black;
                text-align: center;
                margin-top: 20px;
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
                width: 170px;
                height: 50px;
                background-color: darkmagenta;
            }
            td{
                text-align: center;
                height: 40px;
                background-color: hotpink;
            }
            a{
                margin: 25px 0px 25px 0px;
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
            
            $search = false;
            $heroID = filter_input(INPUT_GET, "heroID", FILTER_SANITIZE_SPECIAL_CHARS);

            //Connects to the database and finds the specific record
            if (!empty($_SESSION["username"]) && !empty($_SESSION["password"]) && !($heroID === null)) {
                try {
                    $dbh = new PDO("mysql:host=localhost;dbname=000737859", "000737859", "19990413");
                } catch (Exception $ex) {
                    die("ERROR: Couldn't connect. {$e->getMessage()}");
                }
                //AVOIDING SQL ATTACKS
                $parameter = array($heroID);

                //SQL Command to search the records
                $command = "SELECT heroID, characterName, realName, skill, energyLevel, birthDate, description FROM marvel WHERE heroID = ?";

                $stmt = $dbh->prepare($command);
                $search = $stmt->execute($parameter);

                if ($search) {
                    if ($row = $stmt->fetch()) {
                        //Recieving data
                        $heroID = $row["heroID"];
                        $characterName = $row["characterName"];
                        $realName = $row["realName"];
                        $skill = $row["skill"];
                        $energyLevel = $row["energyLevel"];
                        $birthDate = $row["birthDate"];
                        $description = $row["description"];
                    } else {
                        //Display error message if record in not present in database
                        $search = false;
                        echo "<h1>No Record Found</h1>";
                        echo "<a href='home.php'>Home</a>";
                    }
                } else {
                    //Display error message if search record is fail
                    echo "<h1>Searching Record Fail</h1>";
                    echo "<a href='home.php'>Home</a>";
                }
            } else if (empty($_SESSION["username"]) || empty($_SESSION["password"])) {
                //Display message if there is no log in session
                echo "<h1>Error, no username and password exist</h1>";
            } else {
                //Display error message
                echo "<h1>Error, no parameter</h1>";
                echo "<a href='home.php'>Home</a>";
            }
            ?>

            
            <?php if ($search) { ?>
                <a href="home.php">Home</a>
                <table>
                    <tr>
                        <th>Hero ID</th>
                        <th>character Name</th>
                        <th>Real Name</th>
                        <th>Skill</th>
                        <th>Energy Level</th>
                        <th>Birth Date</th>
                        <th>Description</th>
                        <th colspan="2">Delete or Edit</th>
                    </tr>
                    <tr>
                        <td><?= $heroID ?></td>
                        <td><?= $characterName ?></td>
                        <td><?= $realName ?></td>
                        <td><?= $skill ?></td>
                        <td><?= $energyLevel ?></td>
                        <td><?= $birthDate ?></td>
                        <td><?= $description ?></td>
                        <td><a href="deleterecord.php?heroID=<?= $heroID ?>">DELETE</a></td>
                        <td><a href="tablemanipulate.php?type=update&heroID=<?= $heroID ?>">EDIT</a></td>
                    </tr>
                </table>
            <?php } ?>
        </section>
    </body>
</html>