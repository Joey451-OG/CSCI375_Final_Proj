<?php
    require_once("session.php");
    require_once("included_functions.php");
    require_once("database.php");

    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    new_header("All Feminine German Words");

    $mysqli = Database::DBConnect();
    $mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (($output = message()) !== null) {
        echo $output;
    }

    $stmt = $mysqli -> prepare("SELECT g.translation AS GermanWord FROM German g INNER JOIN WordID w ON g.WordID_wordID = w.wordID WHERE w.Swadesh_SwID IN (SELECT w2.Swadesh_SwID FROM WordID w2 INNER JOIN German g2 ON w2.wordID = g2.WordID_wordID WHERE g2.gender = 'f') ORDER BY g.translation");
    $stmt -> execute();

    if ($stmt) {
        echo "<div class='row'>";
        echo "<center>";
        echo "<h2> All Feminine German Words </h2>";
        echo "<table>";
        echo "<thead>";

        echo "<tr><td>German Word</td></tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
            
            echo "<tr>";
            echo "<td>{$row["GermanWord"]}</td>";
        }

        echo "</tbody>";
        echo "</table>";

        echo "<a href='FinalProjRead.php'> Go Back To Home </a>";


        echo "</center>";
        echo "</div>";
    }

    new_footer();
    Database::DBDisconnect();
?>