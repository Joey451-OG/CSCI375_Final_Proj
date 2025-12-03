<?php 
require_once("session.php"); 
require_once("included_functions.php");
require_once("database.php");

ini_set("display_errors", 1); 
error_reporting(E_ALL);

new_header("Add an Entry"); 
$mysqli = Database::DBConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
    echo $output;
}

echo "<div class='row'>";
echo "<label for='left-label' class='left inline'>";
echo "<h3>Add an Entry</h3>";

if (isset($_POST["submit"])) {
    if (!isset($_POST["Eng"]) || trim($_POST["Eng"]) === "") {
        $_SESSION["message"] = "English form is required.";
        redirect("createEntry.php");
    }

    $stmtSw = $mysqli->prepare("INSERT INTO Swadesh () VALUES ()");
    $stmtSw->execute();
    $swID = $mysqli->lastInsertId();


    function insertWord($mysqli, $swID, $langCode, $translation) {
        if (trim($translation) === "") return;

        $stmt = $mysqli->prepare("SELECT IFNULL(MAX(wordID), 0) + 1 AS newID FROM WordID");
        $stmt->execute();
        $maxID = $stmt->fetch(PDO::FETCH_ASSOC)["newID"];

        $stmtW = $mysqli->prepare("INSERT INTO WordID (Swadesh_SwID, wordID, Lang) VALUES (?, ?, ?)");
        $stmtW->execute([$swID, $maxID, $langCode]);

        $tableMap = [
            "eng" => "English",
            "deu" => "German",
            "ita" => "Italian"
        ];
        $table = $tableMap[$langCode];

        $stmtL = $mysqli->prepare("INSERT INTO $table (WordID_wordID, translation) VALUES (?, ?)");
        $stmtL->execute([$maxID, $translation]);
    }

    insertWord($mysqli, $swID, "eng", $_POST["Eng"]);  
    insertWord($mysqli, $swID, "deu", $_POST["Ger"]);
    insertWord($mysqli, $swID, "ita", $_POST["Ita"]);

    $stmtP = $mysqli->prepare("INSERT INTO Part_Of_Speech (Swadesh_SwID, POS) VALUES (?, ?)");
    $stmtP->execute([$swID, $_POST['POS']]);

    $_SESSION["message"] = $_POST["Eng"] . " has been added.";
    redirect("FinalProjRead.php");
}
else {

    $query4 = "SELECT DISTINCT POS FROM Part_Of_Speech ORDER BY POS";
    $stmt4 = $mysqli->prepare($query4);
    $stmt4->execute();

    echo '<form method="POST" action="createEntry.php">';
    echo '<p>English form: <input type="text" name="Eng" required></p>';
    echo '<p>German form: <input type="text" name="Ger"></p>';
    echo '<p>Italian form: <input type="text" name="Ita"></p>';

    echo '<p>Part of speech: <select name="POS">';
    while ($g = $stmt4->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="'.$g["POS"].'">'.$g["POS"].'</option>';
    }
    echo '</select></p>';

    echo '<p><input type="submit" name="submit" class="tiny round button" value="Add Word"></p>';
    echo '</form>';
}


echo "<br /><br /><a href='FinalProjRead.php'>Back to Main Page</a>";
echo "</label>";
echo "</div>";

new_footer(); 
Database::DBDisconnect();
?>
