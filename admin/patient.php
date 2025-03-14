<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Patients</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["user"])) {
        if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'a') {
            header("location: ../login.php");
        }
    } else {
        header("location: ../login.php");
    }
    include("../connection.php");
    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/nad.jpg" alt="Profile Picture" width="100%" style="border-radius: 50%; display: block; aspect-ratio: 1/1; object-fit: cover;">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">Administrator</p>
                                    <p class="profile-subtitle">admin@edoc.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Dashboard</p>
                        </a>
        </div></a>
        </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor ">
                <a href="doctors.php" class="non-style-link-menu ">
                    <div>
                        <p class="menu-text">Therapist</p>
                </a>
    </div>
    </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-schedule">
            <a href="schedule.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Session</p>
                </div>
            </a>
        </td>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-patient  menu-active menu-icon-patient-active">
            <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active">
                <div>
                    <p class="menu-text">Patients</p>
            </a></div>
        </td>
    </tr>
    </table>
    </div>
    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="patient.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <form action="" method="post" class="header-search">
                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Patient name or Email" list="patient">&nbsp;&nbsp;
                        <?php
                        echo '<datalist id="patient">';
                        $list11 = $database->query("select  pname,pemail from patient;");
                        for ($y = 0; $y < $list11->num_rows; $y++) {
                            $row00 = $list11->fetch_assoc();
                            $d = $row00["pname"];
                            $c = $row00["pemail"];
                            echo "<option value='$d'><br/>";
                            echo "<option value='$c'><br/>";
                        };
                        echo ' </datalist>';
                        ?>
                        <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                    </form>
                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Today's Date
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php
                        date_default_timezone_set('Asia/Kolkata');
                        $date = date('Y-m-d');
                        echo $date;
                        ?>
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top:10px;">
                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Patients (<?php echo $list11->num_rows; ?>)</p>
                </td>
            </tr>

            <?php
            if ($_POST) {
                $keyword = $_POST["search"];
                $sqlmain = "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
            } else {
                $sqlmain = "select * from patient order by pid desc";
            }
            ?>
            <tr>
                <td colspan="7">
                    <center>
                        <div class="abc scroll">
                            <table width="100%" class="sub-table scrolldown" style="border-spacing:10;">
                                <thead>
                                    <tr>
                                        <th class="table-headin">
                                            Name
                                        </th>
                                        <th class="table-headin">
                                            NIC
                                        </th>
                                        <th class="table-headin">
                                            Telephone
                                        </th>
                                        <th class="table-headin">
                                            Email
                                        </th>
                                        <th class="table-headin">
                                            Date of Birth
                                        </th>
                                        <th class="table-headin">
                                            Patient Diagnosis
                                        </th>
                                        <th class="table-headin">
                                            Actions
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $database->query($sqlmain);
                                    if ($result->num_rows == 0) {
                                        echo '<tr>
            <td colspan="6">
                <br><br><br><br>
                <center>
                <img src="../img/notfound.svg" width="25%">
                <br>
                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldn’t find anything related to your keywords!</p>
                <a class="non-style-link" href="patient.php"><button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Patients &nbsp;</button></a>
                </center>
                <br><br><br><br>
            </td>
            </tr>';
                                    } else {
                                        for ($x = 0; $x < $result->num_rows; $x++) {
                                            $row = $result->fetch_assoc();
                                            $pid = $row["pid"];
                                            $name = $row["pname"];
                                            $email = $row["pemail"];
                                            $nic = $row["pnic"];
                                            $dob = $row["pdob"];
                                            $tel = $row["ptel"];
                                            $diagnosis = $row["pdiagnosis"];

                                            echo '<tr>
                    <td>&nbsp;' . substr($name, 0, 35) . '</td>
                    <td>' . substr($nic, 0, 12) . '</td>
                    <td>' . substr($tel, 0, 10) . '</td>
                    <td>' . substr($email, 0, 20) . '</td>
                    <td>' . substr($dob, 0, 10) . '</td>
                    <td>' . substr($diagnosis, 0, 50) . '</td>
                    <td>
                        <div style="display:flex;justify-content: center;gap:10px;">
                            <a href="?action=view&id=' . $pid . '" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-view" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                            <a href="?action=edit&id=' . $pid . '&error=0" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-edit" style="padding-left: 40px; padding-top: 12px; padding-bottom: 12px; margin-top: 10px;"><font class="tn-in-text">Edit</font></button></a>
                            <a href="?action=drop&id=' . $pid . '" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-delete" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;" onclick="return confirm(\'Are you sure you want to delete this record?\')"><font class="tn-in-text">Delete</font></button></a>
                        </div>
                    </td>
                     
                </tr>';
                                        }
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </center>
                </td>
            </tr>
        </table>
    </div>
    </div>

    <?php
    if ($_POST) {
        $keyword = $_POST["search"];
        $sqlmain = "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%'";
    } else {
        $sqlmain = "select * from patient order by pid desc";
    }
    ?>

    </table>
    </div>
    </div>
    <?php
    if ($_GET) {
        $id = $_GET["id"];
        $action = $_GET["action"];

        if ($action == 'view') {
            // View Patient Details
            echo '
                <div id="popup1" class="overlay">
                    <div class="popup">
                        <center>
                        <div class="abc scroll">
                                        <table width="110%" class="sub-table scrolldown" border="0">
                            <a class="close" href="patient.php">&times;</a>
                            <div class="content"></div>
                            <div style="display: flex;justify-content: center;">
                                <table width="80%"  border="0">
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details</p><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-container2">
                                                <table width="100%" border="0" class="add-doc-form">
                                                    <tr><td><font class="form-title">Name</font></td><td><font class="input-text">' . $name . '</font></td></tr>
                                                    <tr><td><font class="form-title">NIC</font></td><td><font class="input-text">' . $nic . '</font></td></tr>
                                                    <tr><td><font class="form-title">Telephone</font></td><td><font class="input-text">' . $tel . '</font></td></tr>
                                                    <tr><td><font class="form-title">Email</font></td><td><font class="input-text">' . $email . '</font></td></tr>
                                                    <tr><td><font class="form-title">Date of Birth</font></td><td><font class="input-text">' . $dob . '</font></td></tr>
                                                    <tr><td><font class="form-title">Diagnosis</font></td><td><font class="input-text">' . $diagnosis . '</font></td></tr> 
                                                    <tr><td><br><br></tr></td>

                                    <tr>
                                    <td colspan="4">
                                        <center>
                                        <div class="abc scroll">
                                        <table width="110%" class="sub-table scrolldown" border="0">
                                        <thead>
                                        <tr>   
                                                <th class="table-headin">
                                                    Appointment Id
                                                </th>
                                                <th class="table-headin">
                                                    Therapist Name
                                                </th>
                                                <th class="table-headin">
                                                    Session Id
                                                </th>
                                                <th class="table-headin">
                                                    
                                                    Session Title
                                                    
                                                </th>
                                                
                                                
                                                <th class="table-headin">
                                                    Date & Time
                                                </th>
                                                
                                        </thead>
                                        <tbody>';



            $sqlmain12 = "
                                        SELECT 
                                            appointment.appoid AS appointment_id,
                                            doctor.docname AS doctor_name,
                                            schedule.scheduleid AS session_id,
                                            schedule.title AS session_title,
                                            CONCAT(schedule.scheduledate, ' ', schedule.scheduletime) AS datetime
                                        FROM 
                                            appointment
                                        INNER JOIN schedule ON appointment.scheduleid = schedule.scheduleid
                                        INNER JOIN doctor ON schedule.docid = doctor.docid
                                        WHERE 
                                            appointment.pid = $pid
                                        ORDER BY 
                                            schedule.scheduledate DESC, schedule.scheduletime DESC;
                                        ";

            $result = $database->query($sqlmain12);
            if ($result->num_rows == 0) {
                echo '<tr>
                                            <td colspan="7">
                                            <br><br><br><br>
                                            <center>
                                            <img src="../img/notfound.svg" width="25%">
                                            
                                            <br>
                                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                            <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                            </a>
                                            </center>
                                            <br><br><br><br>
                                            </td>
                                            </tr>';
            } else {
                for ($x = 0; $x < $result->num_rows; $x++) {
                    $row = $result->fetch_assoc();
                    $appointment_id = $row["appointment_id"];
                    $doctor_name = $row["doctor_name"];
                    $session_id = $row["session_id"];
                    $session_title = $row["session_title"];
                    $datetime = $row["datetime"];

                    echo '<tr style="text-align:center;">
                                                <td>
                                                ' . substr($appointment_id, 0, 15) . '
                                                </td>

                                                <td >' .
                        substr($doctor_name, 0, 25)
                        . '</td >
                                                
                                                <td>
                                                ' . substr($session_id, 0, 25) . '
                                                </td>

                                                <td>
                                                ' . substr($session_title, 0, 25) . '
                                                </td>
                                                
                                                <td>
                                                ' . substr($datetime, 0, 25) . '
                                                </td>

                                                
                                                
                
                                                
                                            </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </center>
                    </div>
                </div>
                ';
                }
            }
        } elseif ($action == 'edit') {
            // Fetch patient details
            $sqlmain = "SELECT * FROM patient WHERE pid='$id'";
            $result = $database->query($sqlmain);
            $row = $result->fetch_assoc();
            $name = $row["pname"];
            $email = $row["pemail"];
            $nic = $row["pnic"];
            $dob = $row["pdob"];
            $tel = $row["ptel"];
            $diagnosis = $row["pdiagnosis"];
            $error_1 = $_GET["error"];
            $errorlist = array(
                '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
                '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Please Reconfirm Password</label>',
                '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                '4' => "",
                '0' => '',
            );
            if ($error_1 != '4') {
                echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                                <a class="close" href="patient.php">&times;</a> 
                                <div style="display: flex;justify-content: center;">
                                <div class="abc">
                                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                        <td class="label-td" colspan="2">' .
                    $errorlist[$error_1]
                    . '</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Patient Details.</p>
                                        Patient ID : ' . $id . '<br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <form action="edit-patient.php" method="POST" class="add-new-form">
                                            <label for="Email" class="form-label">Email address: </label>
                                            <input type="hidden" value="' . $id . '" name="id00">
                                            <input type="hidden" name="oldemail" value="' . $email . '" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="name" class="form-label">Name: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="name" class="input-text" placeholder="Name" value="' . $name . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                        <input type="email" name="email" class="input-text" placeholder="Email Address" value="' . $email . '" required><br>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="nic" class="form-label">NIC: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="text" name="nic" class="input-text" placeholder="NIC Number" value="' . $nic . '" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <label for="Tele" class="form-label">Telephone: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-td" colspan="2">
                                            <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="' . $tele . '" required><br>
                                        </td>
                                    </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="dob" class="form-label">DOB: </label>
                                                <input type="date" name="dob" class="input-text" value="' . $dob . '" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="diagnosis" class="form-label">Diagnosis: </label>
                                                <input type="text" name="diagnosis" class="input-text" placeholder="Diagnosis" value="' . $diagnosis . '" required><br>
                                            </td>
                                        </tr>
                                    
                                    <tr>
                                        <td colspan="2">
                                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="submit" value="Save" class="login-btn btn-primary btn">
                                        </td>
                                    </tr>
                                    </form>
                                    </tr>
                                </table>
                                </div>
                                </div>
                            </center>
                            <br><br>
                    </div>
                    </div>
                    ';
            } else {
                echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                            <br><br><br><br>
                                <h2>Edited Patient Data Successfully!</h2>
                                <a class="close" href="patient.php">&times;</a>
                                <div class="content">   
                                </div>
                                <div style="display: flex;justify-content: center;">
                                <a href="patient.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                                </div>
                                <br><br>
                            </center>
                    </div>
                    </div>
                ';
            }
        } elseif ($action == 'drop') {
            $nameget = $_GET["name"];
            echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                            <h2>Are you sure?</h2>
                            <a class="close" href="patient.php">&times;</a>
                            <div class="content">
                                You want to delete this record<br>(' . substr($nameget, 0, 40) . ').  
                            </div>
                            <div style="display: flex;justify-content: center;">
                            <a href="delete-patient.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                            <a href="patient.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                            </div>
                        </center>
                </div>
                </div>
                ';
        };
    };
    ?>
    </div>
</body>

</html>