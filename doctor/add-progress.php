<?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_POST) {
    // Import database
    include("../connection.php");

    // Capture data from the form
    $appointment_id = $_POST['appointment_id'];
    $progress_details = $_POST['progress_details'];


    // Update the progress in the appointment table
    $update_query = "UPDATE appointment SET progress = ? WHERE appoid = ?";
    $stmt = $database->prepare($update_query);

    if ($stmt) {
        $stmt->bind_param("si", $progress_details, $appointment_id);

        if ($stmt->execute()) {
            header("location: patient.php");
        } else {
            echo "<script>alert('Error updating progress.'); window.location.href = 'patient.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.'); window.location.href = 'patient.php';</script>";
    }

    $database->close();
}
?>
