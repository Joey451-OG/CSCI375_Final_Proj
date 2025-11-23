<?php
    require_once("session.php");
    require_once("included_functions.php");
    require_once("database.php");

    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    new_header("Custom Swadesh List");

    $mysqli = Database::DBConnect();
    $mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (($output = message()) !== null) {
        echo $output;
    }

    // It's probably easier to do multiple SQL queries here instead of one monsterous one.

    $english_stmt = $mysqli->prepare("SELECT Swadesh.SwID, WordID.wordID, English.translation from Swadesh natural join WordID natural join English where Swadesh.SwID = WordID.Swadesh_SwID and WordID.wordID = English.WordID_wordID");
    $german_stmt = $mysqli->prepare("SELECT Swadesh.SwID, WordID.wordID, German.translation FROM Swadesh NATURAL JOIN WordID NATURAL JOIN German WHERE Swadesh.SwID = WordID.Swadesh_SwID AND WordID.wordID = German.WordID_wordID");
    $italian_stmt = $mysqli->prepare("SELECT Swadesh.SwID, WordID.wordID, Italian.translation FROM Swadesh NATURAL JOIN WordID NATURAL JOIN Italian WHERE Swadesh.SwID = WordID.Swadesh_SwID AND WordID.wordID = Italian.WordID_wordID");
    $pos_stmt = $mysqli->prepare("SELECT Swadesh.SwID, Part_Of_Speech.POS FROM Swadesh NATURAL JOIN Part_Of_Speech WHERE Swadesh.SwID = Part_Of_Speech.Swadesh_SwID");

    $english_stmt -> execute();
    $german_stmt -> execute();
    $italian_stmt -> execute();
    $pos_stmt -> execute();

    if ($english_stmt && $german_stmt && $italian_stmt && $pos_stmt) {
        echo "<div class='row'>";
        echo "<center>";
        echo "<h2> Custom Swadesh List </h2>";
        echo "<table>";
        echo "<thead>";

        echo "<tr><td></td><td>Swadesh ID</td><td>English</td><td>Italian</td><td>German</td><td>Part Of Speech</td></tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($english_row = $english_stmt -> fetch(PDO::FETCH_ASSOC)) {
            $german_row = $german_stmt -> fetch(PDO::FETCH_ASSOC);
            $italian_row = $italian_stmt -> fetch(PDO::FETCH_ASSOC);
            $pos_row = $pos_stmt -> fetch(PDO::FETCH_ASSOC);
            
            echo "<tr>";

            // Delete Button
            echo "<td><a href='FinalProjDelete.php?id=".urldecode($english_row["SwID"])."'
            onclick='return confirm(\"Are you sure?\");'>
            <img src='red_x_icon.jpg' width='15px' height='15px'></a></td>";

            echo "<td>{$english_row["SwID"]}</td>";
            echo "<td>{$english_row["translation"]}</td>";
            echo "<td>{$italian_row["translation"]}</td>";
            echo "<td>{$german_row["translation"]}</td>";
            echo "<td>{$pos_row["POS"]}</td>";
        }

        echo "</tbody>";
        echo "</table>";

        echo "</center>";
        echo "</div>";
    }

    new_footer();
    Database::DBDisconnect();
?>