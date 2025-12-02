<?php 
	require_once("session.php"); 
	require_once("included_functions.php");
	require_once("database.php");

	ini_set("display_errors", 1); 
	error_reporting(E_ALL);

	new_header("Add an Entry"); 
	$mysqli = Database::DBConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}


	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";
	echo "<h3>Add an Entry</h3>";

	if (isset($_POST["submit"])) {

		if (isset($_POST["Eng"], $_POST["Ger"], $_POST["Ita"], $_POST["POS"]) &&
			$_POST["Eng"] !== "" && $_POST["Ger"] !== "" && $_POST["Ita"] !== "") {

			$stmtSw = $mysqli->prepare("INSERT INTO Swadesh (SwID) VALUES (NULL)");
			$stmtSw->execute();
			$swID = $mysqli->lastInsertId();

			$stmt = $mysqli->prepare("SELECT MAX(wordID) as maxID FROM WordID");
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$maxID = $row["maxID"] + 1;

			
			// shit shit shit shit shit shit shit shit shit shit shit shit shit shit

			$stmtW = $mysqli->prepare("INSERT INTO WordID (Swadesh_SwID, wordID, Lang) VALUES (?, ?, 'eng')");
			$stmtW->execute([$swID, $maxID]);

			$stmtWGer = $mysqli -> prepare("INSERT INTO WordID (Swadesh_SwID, wordID, Lang) Values (?, ?, 'deu')");
			$stmtWGer -> execute([$swID, ($maxID + 100)]);

			$stmtWIta = $mysqli -> prepare("INSERT INTO WordID (Swadesh_SwID, wordID, Lang) VALUES (?, ?, 'ita')");
			$stmtWIta -> execute([$swID, ($maxID + 200)]);

			$stmt2 = $mysqli->prepare("INSERT INTO English (WordID_wordID, translation) VALUES (?, ?)");
			$stmt2->execute([$maxID, $_POST["Eng"]]);

			$stmtG = $mysqli->prepare("INSERT INTO German (WordID_wordID, translation) VALUES (?, ?)");
			$stmtG->execute([$maxID, $_POST["Ger"]]);

			$stmtI = $mysqli->prepare("INSERT INTO Italian (WordID_wordID, translation) VALUES (?, ?)");
			$stmtI->execute([$maxID, $_POST["Ita"]]);

			// 5) Insert POS using Swadesh ID (CORRECT)
			$stmt3 = $mysqli->prepare("INSERT INTO Part_Of_Speech (Swadesh_SwID, POS) VALUES (?, ?)");
			$stmt3->execute([$swID, $_POST["POS"]]);

			$_SESSION["message"] = $_POST["Eng"] . " has been added.";
			
			// might just be my opinion here but I think
			// this should redirect to the main page
			// - Joey
			redirect("FinalProjRead.php");
		}

		else {
			
            $_SESSION["message"] = "Unable to add word. Fill in all information!";

			// might just be my opinion here but I think
			// this should redirect to the main page
			// - Joey
			redirect("FinalProjRead.php");
		}
	}
	else {




			$query4 = "SELECT DISTINCT POS FROM Part_Of_Speech ORDER BY POS";
			$stmt4 = $mysqli->prepare($query4);
			$stmt4->execute();

			echo '<form method="POST" action="createEntry.php">';

			echo '<p>English form: <input type="text" name="Eng"></p>';
			echo '<p>German form: <input type="text" name="Ger"></p>';
			echo '<p>Italian form: <input type="text" name="Ita"></p>';
			echo '<p>Part of speech: <select name="POS">';
			
			/** Old while loop error
			 *  --------------------
			 * 	The old loop would cause 
			 * 	unexpected behavior if you were
			 * 	to delete all instances of a 
			 *  particular part of speech.
			 * 
			 * Fixed by copying your solution from updateEntry.php 
			*/
			
			
			$posOptions = ['noun', 'verb', 'adjective', 'adverb', 'pronoun', 'preposition', 'conjunction', 'interjection'];

			foreach ($posOptions as $pos) {
				echo "<option value='{$pos}'>{$pos}</option>";
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