<?php
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

ini_set("display_errors", 1);
error_reporting(E_ALL);

new_header("Update an Entry");
$mysqli = Database::DBConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "<div class='row'>";
echo "<label for='left-label' class='left inline'>";
echo "<h3>Update an Entry</h3>";

if (isset($_POST['submit'])) {

    $stmtE = $mysqli->prepare("UPDATE English SET translation = ? WHERE WordID_wordID = ?");
    $stmtE->execute([$_POST['Eng'], $_POST['EngID']]);

    $stmtG = $mysqli->prepare("UPDATE German SET translation = ? WHERE WordID_wordID = ?");
    $stmtG->execute([$_POST['Ger'], $_POST['GerID']]);

    $stmtI = $mysqli->prepare("UPDATE Italian SET translation = ? WHERE WordID_wordID = ?");
    $stmtI->execute([$_POST['Ita'], $_POST['ItaID']]);

    $stmtP = $mysqli->prepare("UPDATE Part_Of_Speech SET POS = ? WHERE Swadesh_SwID = ?");
    $stmtP->execute([$_POST['POS'], $_POST['SwID']]);

    $_SESSION['message'] = "Entry updated.";
    redirect("FinalProjRead.php");

} else {

    if (isset($_GET['id']) && $_GET['id'] !== "") {

        $swID = $_GET['id']; 

        $query = "
            SELECT 
                e.translation AS Eng,
                g.translation AS Ger,
                i.translation AS Ita,
                p.POS,
                wEng.wordID AS EngID,
                wGer.wordID AS GerID,
                wIta.wordID AS ItaID
            FROM Swadesh s
            LEFT JOIN WordID wEng ON wEng.Swadesh_SwID = s.SwID AND wEng.Lang='eng'
            LEFT JOIN English e ON e.WordID_wordID = wEng.wordID
            LEFT JOIN WordID wGer ON wGer.Swadesh_SwID = s.SwID AND wGer.Lang='deu'
            LEFT JOIN German g ON g.WordID_wordID = wGer.wordID
            LEFT JOIN WordID wIta ON wIta.Swadesh_SwID = s.SwID AND wIta.Lang='ita'
            LEFT JOIN Italian i ON i.WordID_wordID = wIta.wordID
            LEFT JOIN Part_Of_Speech p ON p.Swadesh_SwID = s.SwID
            WHERE s.SwID = ?
        ";

        $stmt = $mysqli->prepare($query);
        $stmt->execute([$swID]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {

            $posOptions = ['noun', 'verb', 'adjective', 'adverb', 'pronoun', 'preposition', 'conjunction', 'interjection'];

            echo '<form method="POST" action="updateEntry.php">';
            echo '<p>English:<input type="text" name="Eng" value="'.htmlspecialchars($row['Eng'] ?? '').'"></p>';
            echo '<p>German:<input type="text" name="Ger" value="'.htmlspecialchars($row['Ger'] ?? '').'"></p>';
            echo '<p>Italian:<input type="text" name="Ita" value="'.htmlspecialchars($row['Ita'] ?? '').'"></p>';

            echo '<p>Part of Speech: <select name="POS">';
            foreach ($posOptions as $option) {
                $selected = ($row['POS'] === $option) ? 'selected' : '';
                echo "<option value='$option' $selected>$option</option>";
            }
            echo '</select></p>';

            echo '<input type="hidden" name="SwID" value="'.$swID.'">';
            echo '<input type="hidden" name="EngID" value="'.$row['EngID'].'">';
            echo '<input type="hidden" name="GerID" value="'.$row['GerID'].'">';
            echo '<input type="hidden" name="ItaID" value="'.$row['ItaID'].'">';

            echo '<p><input type="submit" name="submit" value="Edit Entry" class="button tiny round"></p>';
            echo '</form>';

        } else {
            $_SESSION['message'] = "That word could not be found!";
            redirect("FinalProjRead.php");
        }

    } else {
        $_SESSION['message'] = "No ID specified.";
        redirect("FinalProjRead.php");
    }

}

echo "</label>";
echo "</div>";

new_footer();
Database::DBDisconnect();
?>

