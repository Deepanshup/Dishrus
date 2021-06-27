<!DOCTYPE html>
<html lang="en">
<head>
    <title>22Ggroup</title>
    <link rel="icon" sizes="72x72" href="../public/images/favicon-96x96.png">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <style>
        
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .title {
            font-weight: bold;
        }
        .navigate {
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #D4AF37;
            font-family: Roboto;
            position:fixed;
            z-index:1;
            border:solid;
            border-width:0 0 10px 0;
            border-color:#fff;
            width:100%;
        }
        #navigate-container {
            padding-bottom: 12px;
            padding: 10px 10px 10px 10px;
        }
        label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }
        #pac-input {
            background-color: #D4AF37;
            font-family: Roboto;
            font-size: 20px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width:40%;
        }
        #pac-input:focus {
            border-color: #4d90fe;
            width:40%;
        }
        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }
        #header {
            color: #000000;
            font-size: 20px;
            padding: 6px 12px;
            border:solid;
            border-width:0 0 0 2px;
            border-color:#696969;
        }
        #logout {
            color: #000000;
            font-size: 20px;
            padding: 6px 12px 6px 12px;
            border:solid;
            border-width:0 2px 0 2px;
            border-color:#696969;
        }
        a#logout{
            padding-left: 40%;
        }
        a#username{
            color: #000000;
            font-size: 20px;
            padding: 6px 12px 6px 12px;
            border:solid;
            border-width:0 0 0 2px;
            border-color:#696969;
        }
        #logo-img{
            max-width: 190px;
            max-height: 170px; 
        }
        #Logo{
            background-color: black;
            height: 170px;
        }
        #about-us{
            font-size: 40px;
            color: #000000;
        }
        #about-content{
            font-size: 15px;
            padding: 0 20% 0 20%;
            text-align: center;
        }
   
    </style>
  </head>
  <body>
    <?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database1";
    try 
    {   $message="";
        $conn = new mysqli($servername, $username, $password,$dbname);
        $end=$_SESSION["end"];
        if($end!="true"){
            echo '<script>
                    window.location="../../admin/";
                </script>';
        }
        if(isset($_POST["done"])){
            $manager_no=$_POST["manager"];

        }
    }
    catch(PDOException $e)
    {
        $message="Error in Network";
        $_SESSION["end"]="false";
    }
    ?>
    <div class="navigate" id="navigate">
        <div id="navigate-container">
            <a id="header" style="text-decoration:none" href="../register">Register</a>
            <a id="header" style="text-decoration:none" href="../manage_users">Manage User</a>
            <a id="header" style="text-decoration:none" href="../change_logo">Change Logo</a>
            <a id="header" style="text-decoration:none" href="../edit_content">Edit Content</a>
            <a id="logout" style="text-decoration:none" href="../../admin/">Logout</a>

           
        </div>
    </div>
    <div id="Logo"><div><img id="logo-img" src="https://dishrus.com/wp-content/uploads/2018/01/Directv-logo-2.jpg"></div>
    
    <!-- <div id="side-logo"><img src="./direct-tv-for-business-logo.jpg"></div> -->
    </div>
    <div id="about"><h3 id="about-us" style="text-align: center;">About  Us</h3>
<div> <p id="about-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p></div>
    </div>
    
  </body>
</html>