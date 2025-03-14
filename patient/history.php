<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>History</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
<?php
session_start();
include("../connection.php");

// Check if the user is logged in
if (!isset($_SESSION["user"]) || $_SESSION["usertype"] != 'p') {
    header("location: ../login.php");
    exit();
}

$useremail = $_SESSION["user"];

// Fetch patient details
$userrow = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];

// Fetch appointment history with progress updates
$sql = "SELECT appointment.appoid, appointment.appodate, appointment.apponum,appointment.progress, 
       doctor.docname, schedule.title 
        FROM appointment
        JOIN schedule ON appointment.scheduleid = schedule.scheduleid
        JOIN doctor ON schedule.docid = doctor.docid
        WHERE appointment.pid = $userid 
        ORDER BY appointment.appodate DESC;
        ";
$result = $database->query($sql);
?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Therapist</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                        <a href="history.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My History</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
 <?php       

$selecttype="My";
$current="My history Only";
if($_POST){

    if(isset($_POST["search"])){
        $keyword=$_POST["search12"];
        
        $sqlmain= "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
        $selecttype="my";
    }
    
    if(isset($_POST["filter"])){
        if($_POST["show only"]=='all'){
            $sqlmain= "select * from patient";
            $selecttype="All";
            $current="All ";
        }else{
            $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid group by patient.pid;";
            $selecttype="My";
            $current="My history Only";
        }
    }
}else{
    $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=$userid group by patient.pid;";
    $selecttype="My";
}



?>
<div class="dash-body">
<table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
<tr >
<td width="13%">

<a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Home</font></button></a>
    
</td>
<td>
    
    <form action="" method="post" class="header-search">

        <input type="search" name="search12" class="input-text header-searchbar" placeholder="Search  name or Email" list="patient">&nbsp;&nbsp;
        
        <?php
            echo '<datalist id="patient">';
            $list11 = $database->query($sqlmain);
            $list12= $database->query("select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.docid=1;");

            for ($y=0;$y<$list11->num_rows;$y++){
                $row00=$list11->fetch_assoc();
                $d=$row00["pname"];
                $c=$row00["pemail"];
                echo "<option value='$d'><br/>";
                echo "<option value='$c'><br/>";
            };

        echo ' </datalist>';
?>
        
   
        <input type="Submit" value="Search" name="search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
    
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
    <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
</td>


</tr>


<tr>
<td colspan="4" style="padding-top:10px;">
    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $selecttype." History (".$list11->num_rows.")"; ?></p>
</td>

</tr>
<tr>
<td colspan="4" style="padding-top:0px;width: 100%;" >
    <center>
    <table class="filter-container" border="0" >

    <form action="" method="post">
    
    <td  style="text-align: right;">
    Show Details About : &nbsp;
    </td>
    <td width="30%">
    <select name="showonly" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                <option value="" disabled selected hidden><?php echo $current   ?></option><br/>
                <option value="my">My history </option><br/>

            </select>
        </td>
        <td width="12%">
            <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
            </form>
        </td>

        </tr>
        </table>

    </center>
</td>

</tr>

<tr>
<td colspan="4">
   <center>
    <div class="abc scroll">
    <table width="95%" class="sub-table scrolldown"  style="border-spacing:3;">
    <thead>
    <tr>
        <td colspan="4">
            <center>
             <div class="abc scroll">
             <table width="100%" class="sub-table scrolldown" border="1">
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
                         
                         Progress Report
                         
                     </th>
                    
                     <th class="table-headin">
                         Date & Time
                     </th>
                     
             </thead>
             <tbody>
             <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['appoid']}</td>
                                    <td>{$row['docname']}</td>
                                    <td>{$row['apponum']}</td>
                                    <td>{$row['title']}</td>
                                    <td>{$row['progress']}</td>
                                    <td>{$row['appodate']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No history found.</td></tr>";
                    }
                    ?>
</div>

</body>
</html>