<?php
    require_once("session.php");
    require_once("included_functions.php");
    require_once("database.php");

    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    new_header("POS Occurrences");

    $mysqli = Database::DBConnect();
    $mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (($output = message()) !== null) {
        echo $output;
    }

    $stmt = $mysqli -> prepare("SELECT p.POS AS PartOfSpeech, COUNT(s.SwID) AS TotalWords FROM Part_Of_Speech p INNER JOIN Swadesh s ON p.Swadesh_SwID = s.SwID GROUP BY p.POS ORDER BY TotalWords DESC");
    $stmt -> execute();

    if ($stmt) {
        echo "<div class='row'>";
        echo "<center>";
        echo "<h2> POS Occurrences </h2>";
        echo "<table>";
        echo "<thead>";

        echo "<tr><td>Part Of Speech</td><td>Total Words</td></tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
            
            echo "<tr>";
            echo "<td>{$row["PartOfSpeech"]}</td>";
            echo "<td>{$row["TotalWords"]}</td>";
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