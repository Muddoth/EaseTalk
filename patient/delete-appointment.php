<?php

session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_GET) {
    // Import database
    include("../connection.php");
    $id = $_GET["id"];

    // Retrieve scheduleid associated with the appointment
    $result = $database->query("SELECT scheduleid FROM appointment WHERE appoid = '$id'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $scheduleId = $row["scheduleid"];

        // Decrement currpatient in the schedule table
        $database->query("UPDATE schedule SET currpatients = GREATEST(currpatients - 1, 0) WHERE scheduleid = '$scheduleId'");
    }

    // Delete the appointment
    $sql = $database->query("DELETE FROM appointment WHERE appoid = '$id'");
    
    header("location: appointment.php");
}
?>
