<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != 'a') {
    header("location: ../login.php");
    exit();
}

include("../connection.php");

// Check if the form was submitted with an ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Sanitize the input to prevent SQL injection (assuming it's an integer)
    $id = (int)$id;  // This ensures $id is an integer

    // Perform your deletion query
    $sql = "DELETE FROM patient WHERE pid = $id";

    // Execute the query and check for success
    if ($database->query($sql)) {
        // Redirect back to the patient list page after deletion
        header("Location: patient.php");
        exit();
    } else {
        // If there's an error, show the error message
        echo "Error deleting patient: " . $database->error;
    }
} else {
    // If no ID is provided in the POST request, show an error
    echo "No patient ID provided!";
}
?>
