<?php
    require_once("session.php");
    require_once("included_functions.php");
    require_once("database.php");

    ini_set("display_errors", 1);
    error_reporting(E_ALL);

    new_header("Delete a Word");

    $mysqli = Database::DBConnect();
    $mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (($output = message())) {
        echo $output;
    }

    if (isset($_GET["id"]) && $_GET["id"] !== "") {
        $query = "DELETE FROM Swadesh WHERE SwID = ?";

        $stmt = $mysqli->prepare($query);
        $stmt->execute([$_GET["id"]]);


        if ($stmt) {
            $_SESSION["message"] = "Concept successfully deleted!";
        } else {
            $_SESSION["message"] = "Concept could not be deleted!";
        }
    } else {
        $_SESSION["message"] = "Concept could not be found!";
    }

    redirect("FinalProjRead.php");

    new_footer();
    Database::DBDisconnect();

?>