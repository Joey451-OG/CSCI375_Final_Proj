<?php
    require_once("session.php");
    require_once("included_functions.php");
    require_once("database.php");

    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    new_header("Concrete vs. Non-Concrete Nouns");

    $mysqli = Database::DBConnect();
    $mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (($output = message()) !== null) {
        echo $output;
    }

    $stmt = $mysqli -> prepare("SELECT CASE WHEN p.isConcrete = 1 THEN 'Concrete Nouns' ELSE 'Non-Concrete Nouns' END AS NounType, COUNT(s.SwID) AS TotalCount FROM Part_Of_Speech p INNER JOIN Swadesh s ON p.Swadesh_SwID = s.SwID WHERE p.POS = 'noun' GROUP BY p.isConcrete ORDER BY TotalCount DESC");
    $stmt -> execute();

    if ($stmt) {
        echo "<div class='row'>";
        echo "<center>";
        echo "<h2> Concrete vs. Non-Concrete Nouns </h2>";
        echo "<table>";
        echo "<thead>";

        echo "<tr><td>Noun Type</td><td>Total Count</td></tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
            
            echo "<tr>";
            echo "<td>{$row["NounType"]}</td>";
            echo "<td>{$row["TotalCount"]}</td>";
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