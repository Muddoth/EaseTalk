<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "../css/animations.css">  
    <link rel = "stylesheet" href = "../css/main.css">  
    <link rel = "stylesheet" href = "../css/admin.css">
    <title>Dashboard</title>
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>  
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION["user"])){
            if(($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'a'){
                header("location: ../login.php");
            }
        }else{
            header("location: ../login.php");
        }
        include("../connection.php");
    ?>
    <div class = "container">
        <div class = "menu">
            <table class = "menu-container" border = "0">
                <tr>
                    <td style = "padding:10px" colspan = "2">
                        <table border = "0" class = "profile-container">
                            <tr>
                                <td width = "30%" style = "padding-left:20px" >
                                <img src="../img/nad.jpg" alt="Profile Picture" width="100%" style="border-radius: 50%; display: block; aspect-ratio: 1/1; object-fit: cover;">
                                </td>
                                <td style = "padding:0px;margin:0px;">
                                    <p class = "profile-title">Administrator</p>
                                    <p class = "profile-subtitle">admin@edoc.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan = "2">
                                    <a href = "../logout.php" ><input type = "button" value = "Log out" class = "logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class = "menu-row" >
                    <td class = "menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active" >
                        <a href = "index.php" class = "non-style-link-menu non-style-link-menu-active"><div><p class = "menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class = "menu-row">
                    <td class = "menu-btn menu-icon-doctor ">
                        <a href = "doctors.php" class = "non-style-link-menu "><div><p class = "menu-text">Therapist</p></a></div>
                    </td>
                </tr>
                <tr class = "menu-row" >
                    <td class = "menu-btn menu-icon-schedule">
                        <a href = "schedule.php" class = "non-style-link-menu"><div><p class = "menu-text">Session</p></div></a>
                    </td>
                </tr>
                <tr class = "menu-row" >
                    <td class = "menu-btn menu-icon-patient">
                        <a href = "patient.php" class = "non-style-link-menu"><div><p class = "menu-text">Patients</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class = "dash-body" style = "margin-top: 15px">
            <table border = "0" width = "100%" style = " border-spacing: 0;margin:0;padding:0;" >
                        <tr >
                            <td colspan = "2" class = "nav-bar" >
                                <form action = "doctors.php" method = "post" class = "header-search">
                                   <input type = "search" name = "search" class = "input-text header-searchbar" placeholder = "Search Therapist name or Email" list = "doctors">&nbsp;&nbsp; 
                                    <?php
                                        echo '<datalist id="doctors">';
                                        $list11 = $database->query("select  docname,docemail from  doctor;");
                                        for ($y = 0; $y < $list11->num_rows; $y++){
                                            $row00 = $list11->fetch_assoc();
                                            $d = $row00["docname"];
                                            $c = $row00["docemail"];
                                            echo "<option value='$d'><br/>";
                                            echo "<option value='$c'><br/>";
                                        };
                                        echo ' </datalist>';
                                    ?>
                                    <input type = "Submit" value = "Search" class = "login-btn btn-primary-soft btn" style = "padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                                </form>  
                            </td>
                            <td width = "15%">
                                <p style = "font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                                    Today's Date
                                </p>
                                <p class = "heading-sub12" style = "padding: 0;margin: 0;">
                                    <?php 
                                    date_default_timezone_set('Asia/Kolkata');
                                    $today = date('Y-m-d');
                                    echo $today;
                                    $patientrow = $database->query("select  * from  patient;");
                                    $doctorrow = $database->query("select  * from  doctor;");
                                    $appointmentrow = $database->query("select  * from  appointment where appodate>='$today';");
                                    $schedulerow = $database->query("select  * from  schedule where scheduledate='$today';");
                                    ?>
                                </p>
                            </td>
                            <td width = "10%">
                                <button  class = "btn-label"  style = "display: flex;justify-content: center;align-items: center;"><img src = "../img/calendar.svg" width = "100%"></button>
                            </td>
                        </tr>
                <tr>
                    <td colspan = "4">
                        <center>
                        <table class = "filter-container" style = "border: none;" border = "0">
                            <tr>
                                <td colspan = "4">
                                    <p style = "font-size: 20px;font-weight:600;padding-left: 12px;">Quick Look</p>
                                </td>
                            </tr>
                            <tr>
                                <td style = "width: 25%;">
                                    <div  class = "dashboard-items"  style = "padding:20px;margin:auto;width:95%;display: flex">
                                        <div>
                                                <div class = "h1-dashboard">
                                                    <?php    echo $doctorrow->num_rows  ?>
                                                </div><br>
                                                <div class = "h3-dashboard">
                                                    Therapists &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                        </div>
                                                <div class = "btn-icon-back dashboard-icons" style = "background-image: url('../img/icons/doctors-hover.svg');"></div>
                                    </div>
                                </td>
                                <td style = "width: 25%;">
                                    <div  class = "dashboard-items"  style = "padding:20px;margin:auto;width:95%;display: flex;">
                                        <div>
                                                <div class = "h1-dashboard">
                                                    <?php    echo $patientrow->num_rows  ?>
                                                </div><br>
                                                <div class = "h3-dashboard">
                                                    Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                        </div>
                                                <div class = "btn-icon-back dashboard-icons" style = "background-image: url('../img/icons/patients-hover.svg');"></div>
                                    </div>
                                </td>
                                <td style = "width: 25%;">
                                    <div  class = "dashboard-items"  style = "padding:20px;margin:auto;width:95%;display: flex;padding-top:26px;padding-bottom:26px;">
                                        <div>
                                                <div class = "h1-dashboard">
                                                    <?php    echo $schedulerow ->num_rows  ?>
                                                </div><br>
                                                <div class = "h3-dashboard" style = "font-size: 15px">
                                                    Today Sessions
                                                </div>
                                        </div>
                                                <div class = "btn-icon-back dashboard-icons" style = "background-image: url('../img/icons/session-iceblue.svg');"></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </center>
                    </td>
                </tr>
                <tr>
                    <td colspan = "4">
                        <table width = "100%" border = "0" class = "dashbord-tables">
                           
                                    <p style = "text-align:left;padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                        Upcoming Sessions  until Next <?php  
                                        echo date("l",strtotime("+1 week"));
                                        ?>
                                    </p>
                                    <p style = "padding-bottom:19px;text-align:left;padding-left:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
                                        Quick access to upcoming doctor sessions for the upcoming week<br>     
                                    </p>
                                </td>
                            </tr>
                            <tr>
                               
                                <td width = "50%" style = "padding: 0;">
                                    <center>
                                        <div class = "abc scroll" style = "height: 200px;padding: 0;margin: 0;">
                                        <table width = "85%" class = "sub-table scrolldown" border = "0" >
                                        <thead>
                                        <tr>
                                                <th class = "table-headin">
                                                Session Title
                                                </th>
                                                <th class = "table-headin">
                                                    Therapist
                                                </th>
                                                <th class = "table-headin"> 
                                                    Scheduled Date & Time  
                                                </th>   
                                                </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $nextweek = date("Y-m-d",strtotime("+1 week"));
                                                $sqlmain =  "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  where schedule.scheduledate>='$today' and schedule.scheduledate<='$nextweek' order by schedule.scheduledate desc"; 
                                                    $result = $database->query($sqlmain);
                                                    if($result->num_rows == 0){
                                                        echo '<tr>
                                                        <td colspan="4">
                                                        <br><br><br><br>
                                                        <center>
                                                        <img src="../img/notfound.svg" width="25%">
                                                        <br>
                                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No Sessions made</p>
                                                        <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Sessions &nbsp;</font></button>
                                                        </a>
                                                        </center>
                                                        <br><br><br><br>
                                                        </td>
                                                        </tr>'; 
                                                    }
                                                    else{
                                                    for ( $x = 0; $x < $result->num_rows; $x++){
                                                        $row = $result->fetch_assoc();
                                                        $scheduleid = $row["scheduleid"];
                                                        $title = $row["title"];
                                                        $docname = $row["docname"];
                                                        $scheduledate = $row["scheduledate"];
                                                        $scheduletime  = $row["scheduletime"];
                                                        $nop = $row["nop"];
                                                        echo '<tr>
                                                            <td style="padding:20px;"> &nbsp;'.
                                                            substr($title,0,30)
                                                            .'</td>
                                                            <td>
                                                            '.substr($docname,0,20).'
                                                            </td>
                                                            <td style="text-align:center;">
                                                                '.substr($scheduledate,0,10).' '.substr($scheduletime,0,5).'
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
                            <tr>
                                <td>
                                    <center>
                                        <a href = "schedule.php" class = "non-style-link"><button class = "btn-primary btn" style = "width:85%">Show all Sessions</button></a>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </table>
                </center>
                </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>