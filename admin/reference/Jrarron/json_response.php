<?php
$servername = "localhost";
$username = "nadaa93i_gaurav";
$password = "root@123";
$dbname = "nadaa93i_Jrarron";
try 
{
        $conn = new mysqli($servername, $username, $password,$dbname);
        if(isset($_REQUEST["register"]))
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $name = $obj['name'];
            $email = $obj['email'];
            $contact_no= $obj['contact_no'];
            $password = $obj['password'];
            $CheckSQL = "select * from register_user where email='$email'";
            $check = mysqli_fetch_array(mysqli_query($conn,$CheckSQL));
            if(isset($check)){
                $response = "Email  already exist.";
                echo json_encode($response); 
            }
            else{
                $Sql_Query = "INSERT INTO `register_user`(`name`,`email`,`contact_no`,`password`) VALUES 
                            ('$name','$email','$contact_no','$password')";
                if(mysqli_query($conn,$Sql_Query)){
                    $response = "User successfully created.";
                    echo json_encode($response);
               }
               else{
                   $response= "Oops! An error occurred.";
                   echo json_encode($response);
               }
           }
           mysqli_close($conn);
        }
        if(isset($_REQUEST["forget_password"]))
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $name = $obj['name'];
            $email = $obj['email'];
            $password = $obj['password'];
            $contact_no= $obj['contact_no'];
            $CheckSQL = "select * from register_user where name='$name' and email='$email' and contact_no='$contact_no' ";
            $check = mysqli_fetch_array(mysqli_query($conn,$CheckSQL));
            if(isset($check)){
                $Sql_Query = "UPDATE `register_user` SET `password`='$password'  WHERE name='$name' and email='$email' and contact_no='$contact_no'";
                if(mysqli_query($conn,$Sql_Query)){
                    $response = "Password Successfully Changed.";
                    echo json_encode($response);
                }
                else{
                    $response= "Oops! An error occurred.";
                    echo json_encode($response);
                }
            }
            else{
                $response= "Incorrect details provided.";
                echo json_encode($response);
            }
            mysqli_close($conn);
        }
        if(isset($_REQUEST["login"]))
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $email = $obj['email'];
            $password = $obj['password'];
            $Sql_Query = "select * from register_user where email='$email' and password='$password' ";
            $check = mysqli_fetch_array(mysqli_query($conn,$Sql_Query));
            if(isset($check)){
                $SuccessLoginMsg = 'Successfully Logged In';
                echo json_encode($SuccessLoginMsg); 
            }
            else{
                $InvalidMSG = 'Invalid Email or Password Please Try Again' ;
                echo json_encode($InvalidMSG);
            }
            mysqli_close($conn);
        }
        if(isset($_REQUEST["feedback"]))
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json,true);
            $email = $obj['email'];
            if($obj['category']=='DRIVING')
            {$category = 'Driving';}
            if($obj['category']=='WALKING')
            {$category = 'Walking';}
            if($obj['category']=='BICYCLING')
            {$category = 'Bike';}
            if($obj['category']=='TRANSIT')
            {$category = 'Scooter';}
            $place = $obj['place'];
            $feedback = $obj['feedback'];
            $rating = $obj['rating'];
            $Sql_Query = "INSERT INTO `feedback`(`user_name`, `email`, `category`, `place`, `feedback`, `rating`)
                                        VALUES ('$email','$email','$category','$place','$feedback','$rating')";
            if(mysqli_query($conn,$Sql_Query)){
                $response = "Feedback successfully submited.";
                echo json_encode($response);
            }
            else{
                $response= "Oops! An error occurred.";
                echo json_encode($response);
            }
            mysqli_close($conn);
        }
        if(isset($_REQUEST["feedback_fetch"]))
        {
            $response["results"] = array();
            $sql= "select * from admin ";
            $result = mysqli_query($conn,$sql) or die(mysql_error());
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $rate=0;
                    $i=0;
                    $sqls= "select rating from feedback where category='$row[2]' and place='$row[0]' ";
                    $results = mysqli_query($conn,$sqls) or die(mysql_error());
                    if (mysqli_num_rows($results) > 0) {
                        while ($rows = mysqli_fetch_array($results)) {
                           $rate=$rate+$rows[0];
                           $i++;
                        }
                        $product=array();
                        $product['category']=$row[2];
                        $product['place']=$row[0];
                        $product['rating']=$rate/$i;
                        array_push($response["results"], $product);
                        echo json_encode($response);
                    }
                    else{
                        echo json_encode($response);
                    }
                }
            }
            else{
                echo json_encode($response);
            }
            mysqli_close($conn);
        }
        if(isset($_REQUEST["user_fetch"]))
        {
            $email = $_GET['email'];
            $response["results"] = array();
            $sql= "select * from register_user where `email`='$email'";
            $result = mysqli_query($conn,$sql) or die(mysql_error());
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $product=array();
                    $product['name']=$row[0];
                    $product['email']=$row[1];
                    $product['contact_no']=$row[2];
                    array_push($response["results"], $product);
                }echo json_encode($response);
            }
            else{
                echo json_encode($response);
            }
            mysqli_close($conn);
        }
        if(isset($_REQUEST["driving"])){
            $off=$_GET["offset"];
	        $x=0;
            $y=$off*10;
            $z=$y+9;
            $o=0;
            $response["results"]=array();
            $sql="SELECT * FROM `admin` where category='Driving'";
            $result = mysqli_query($conn,$sql) or die(mysql_error());
            
            if(mysqli_num_rows($result) > 0)
            {
                while($row=mysqli_fetch_row($result)){
                    $product=array();
                    $product["post_id"]=$row[8];
                    $product["place"]=$row[0];
                    $product["img_url"]=$row[4];
                    $product["about_route"]=$row[5];
                    $address = urlencode($row[9]);
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                    $data = @file_get_contents($url);
                    $jsondata = json_decode($data,true);
                    if ($jsondata["status"] == "OK") { 
                        $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $product["sourceLat"]= $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $product["sourceLng"] = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $LatLng = array(
                            'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                            'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                            'latitudeDelta'=> 0.0922,
                            'longitudeDelta'=> 0.0421,
                    );}
                    $product["source"]=$LatLng;
                    $address = urlencode($row[10]);
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                    $data = @file_get_contents($url);
                    $jsondata = json_decode($data,true);
                    if ($jsondata["status"] == "OK") { 
                        $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $product["destinationLat"]= $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $product["destinationLng"] = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $LatLng = array(
                            'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                            'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                            'latitudeDelta'=> 0.0922,
                            'longitudeDelta'=> 0.0421,
                    );}
                    $product["destination"]=$LatLng;
                    $sqls= "select rating from feedback where category='Driving' and place='$row[0]' ";
                    $results = mysqli_query($conn,$sqls) or die(mysql_error());
                    if (mysqli_num_rows($results) > 0) {
                        while ($rows = mysqli_fetch_array($results)) {
                           $rate=$rate+$rows[0];
                           $i++;
                        }
                        $product['rating']=$rate/$i;
                    }
                    else{
                        $product["rating"]=$row[1];
                    }
                    $poi=$row[6];
                    $poiEx=explode('|', $poi);
                    $poiDescc=explode('|', $row[13]);
                    $poiAudioo=explode('|', $row[7]);
                    $arr["poi"]=array();
                    $arr["poiName"]=array();
                    $arr["poiDesc"]=array();
                    $arr["poiAudio"]=array();
                    for ($num = 0; $num <= $row[12]; $num ++) { 
                        if($poiEx[$num]!=""){
                            $address = urlencode($poiEx[$num]);
                            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                            $data = @file_get_contents($url);
                            $jsondata = json_decode($data,true);
                            if ($jsondata["status"] == "OK") { 
                                $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                                $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                                $LatLng = array(
                                    'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                                    'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                                    'latitudeDelta'=> 0.0922,
                                    'longitudeDelta'=> 0.0421,
                                );
                                array_push($arr["poi"], $LatLng);
                                array_push($arr["poiName"], $poiEx[$num]);
                                array_push($arr["poiDesc"], $poiDescc[$num]);
                                array_push($arr["poiAudio"], $poiAudioo[$num]);
                            }
                        }
                    }
                    $product["poiName"]=$arr["poiName"];
                    $product["poiDesc"]=$arr["poiDesc"];
                    $product["poiAudio"]=$arr["poiAudio"];
                    $product["poi"]=$arr["poi"];
                    $product["poiSize"]=sizeof($arr["poi"]);
                    if($x>=$y && $x<=$z){
                        array_push($response["results"], $product);
                    }
                    $x++;
                }echo json_encode($response);
            }
            else
            {
                echo json_encode($response);
            }
            mysqli_close($con);
        }
        if(isset($_REQUEST["bike"])){
            $off=$_GET["offset"];
	        $x=0;
            $y=$off*10;
            $z=$y+9;
            $o=0;
            $response["results"]=array();
            $sql="SELECT * FROM `admin` where category='Bike'";
            $result = mysqli_query($conn,$sql) or die(mysql_error());
            
            if(mysqli_num_rows($result) > 0)
            {
                while($row=mysqli_fetch_row($result)){
                    $product=array();
                    $product["post_id"]=$row[8];
                    $product["place"]=$row[0];
                    $product["img_url"]=$row[4];
                    $product["about_route"]=$row[5];
                    $address = urlencode($row[9]);
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                    $data = @file_get_contents($url);
                    $jsondata = json_decode($data,true);
                    if ($jsondata["status"] == "OK") { 
                        $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $LatLng = array(
                            'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                            'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                            'latitudeDelta'=> 0.0922,
                            'longitudeDelta'=> 0.0421,
                    );}
                    $product["source"]=$LatLng;
                    $address = urlencode($row[10]);
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                    $data = @file_get_contents($url);
                    $jsondata = json_decode($data,true);
                    if ($jsondata["status"] == "OK") { 
                        $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $product["destinationLat"]= $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $product["destinationLng"] = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $LatLng = array(
                            'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                            'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                            'latitudeDelta'=> 0.0922,
                            'longitudeDelta'=> 0.0421,
                    );}
                    $product["destination"]=$LatLng;
                    $sqls= "select rating from feedback where category='Bike' and place='$row[0]' ";
                    $results = mysqli_query($conn,$sqls) or die(mysql_error());
                    if (mysqli_num_rows($results) > 0) {
                        while ($rows = mysqli_fetch_array($results)) {
                           $rate=$rate+$rows[0];
                           $i++;
                        }
                        $product['rating']=$rate/$i;
                    }
                    else{
                        $product["rating"]=$row[1];
                    }
                    $poi=$row[6];
                    $poiEx=explode('|', $poi);
                    $poiDescc=explode('|', $row[13]);
                    $poiAudioo=explode('|', $row[7]);
                    $arr["poi"]=array();
                    $arr["poiName"]=array();
                    $arr["poiDesc"]=array();
                    $arr["poiAudio"]=array();
                    for ($num = 0; $num <= $row[12]; $num ++) { 
                        if($poiEx[$num]!=""){
                            $address = urlencode($poiEx[$num]);
                            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                            $data = @file_get_contents($url);
                            $jsondata = json_decode($data,true);
                            if ($jsondata["status"] == "OK") { 
                                $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                                $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                                $LatLng = array(
                                    'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                                    'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                                    'latitudeDelta'=> 0.0922,
                                    'longitudeDelta'=> 0.0421,
                                );
                                array_push($arr["poi"], $LatLng);
                                array_push($arr["poiName"], $poiEx[$num]);
                                array_push($arr["poiDesc"], $poiDescc[$num]);
                                array_push($arr["poiAudio"], $poiAudioo[$num]);
                            }
                        }
                    }
                    $product["poiName"]=$arr["poiName"];
                    $product["poiDesc"]=$arr["poiDesc"];
                    $product["poiAudio"]=$arr["poiAudio"];
                    $product["poi"]=$arr["poi"];
                    if($x>=$y && $x<=$z){
                        array_push($response["results"], $product);
                    }
                    $x++;
                }echo json_encode($response);
            }
            else
            {
                echo json_encode($response);
            }
            mysqli_close($con);
        }
        if(isset($_REQUEST["walking"])){
            $off=$_GET["offset"];
	        $x=0;
            $y=$off*10;
            $z=$y+9;
            $o=0;
            $response["results"]=array();
            $sql="SELECT * FROM `admin` where category='Walking'";
            $result = mysqli_query($conn,$sql) or die(mysql_error());
            
            if(mysqli_num_rows($result) > 0)
            {
                while($row=mysqli_fetch_row($result)){
                    $product=array();
                    $product["post_id"]=$row[8];
                    $product["place"]=$row[0];
                    $product["img_url"]=$row[4];
                    $product["about_route"]=$row[5];
                    $address = urlencode($row[9]);
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                    $data = @file_get_contents($url);
                    $jsondata = json_decode($data,true);
                    if ($jsondata["status"] == "OK") { 
                        $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $LatLng = array(
                            'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                            'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                            'latitudeDelta'=> 0.0922,
                            'longitudeDelta'=> 0.0421,
                    );}
                    $product["source"]=$LatLng;
                    $address = urlencode($row[10]);
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                    $data = @file_get_contents($url);
                    $jsondata = json_decode($data,true);
                    if ($jsondata["status"] == "OK") { 
                        $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $product["destinationLat"]= $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $product["destinationLng"] = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $LatLng = array(
                            'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                            'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                            'latitudeDelta'=> 0.0922,
                            'longitudeDelta'=> 0.0421,
                    );}
                    $product["destination"]=$LatLng;
                    $sqls= "select rating from feedback where category='Walking' and place='$row[0]' ";
                    $results = mysqli_query($conn,$sqls) or die(mysql_error());
                    if (mysqli_num_rows($results) > 0) {
                        while ($rows = mysqli_fetch_array($results)) {
                           $rate=$rate+$rows[0];
                           $i++;
                        }
                        $product['rating']=$rate/$i;
                    }
                    else{
                        $product["rating"]=$row[1];
                    }
                    $poi=$row[6];
                    $poiEx=explode('|', $poi);
                    $poiDescc=explode('|', $row[13]);
                    $poiAudioo=explode('|', $row[7]);
                    $arr["poi"]=array();
                    $arr["poiName"]=array();
                    $arr["poiDesc"]=array();
                    $arr["poiAudio"]=array();
                    for ($num = 0; $num <= $row[12]; $num ++) { 
                        if($poiEx[$num]!=""){
                            $address = urlencode($poiEx[$num]);
                            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                            $data = @file_get_contents($url);
                            $jsondata = json_decode($data,true);
                            if ($jsondata["status"] == "OK") { 
                                $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                                $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                                $LatLng = array(
                                    'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                                    'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                                    'latitudeDelta'=> 0.0922,
                                    'longitudeDelta'=> 0.0421,
                                );
                                array_push($arr["poi"], $LatLng);
                                array_push($arr["poiName"], $poiEx[$num]);
                                array_push($arr["poiDesc"], $poiDescc[$num]);
                                array_push($arr["poiAudio"], $poiAudioo[$num]);
                            }
                        }
                    }
                    $product["poiName"]=$arr["poiName"];
                    $product["poiDesc"]=$arr["poiDesc"];
                    $product["poiAudio"]=$arr["poiAudio"];
                    $product["poi"]=$arr["poi"];
                    if($x>=$y && $x<=$z){
                        array_push($response["results"], $product);
                    }
                    $x++;
                }echo json_encode($response);
            }
            else
            {
                echo json_encode($response);
            }
            mysqli_close($con);
        }
        if(isset($_REQUEST["scooter"])){
            $off=$_GET["offset"];
	        $x=0;
            $y=$off*10;
            $z=$y+9;
            $o=0;
            $response["results"]=array();
            $sql="SELECT * FROM `admin` where category='Scooter'";
            $result = mysqli_query($conn,$sql) or die(mysql_error());
            
            if(mysqli_num_rows($result) > 0)
            {
                while($row=mysqli_fetch_row($result)){
                    $product=array();
                    $product["post_id"]=$row[8];
                    $product["place"]=$row[0];
                    $product["img_url"]=$row[4];
                    $product["about_route"]=$row[5];
                    $address = urlencode($row[9]);
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                    $data = @file_get_contents($url);
                    $jsondata = json_decode($data,true);
                    if ($jsondata["status"] == "OK") { 
                        $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $LatLng = array(
                            'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                            'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                            'latitudeDelta'=> 0.0922,
                            'longitudeDelta'=> 0.0421,
                    );}
                    $product["source"]=$LatLng;
                    $address = urlencode($row[10]);
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                    $data = @file_get_contents($url);
                    $jsondata = json_decode($data,true);
                    if ($jsondata["status"] == "OK") { 
                        $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $product["destinationLat"]= $jsondata["results"][0]["geometry"]["location"]["lat"];
                        $product["destinationLng"] = $jsondata["results"][0]["geometry"]["location"]["lng"];
                        $LatLng = array(
                            'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                            'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                            'latitudeDelta'=> 0.0922,
                            'longitudeDelta'=> 0.0421,
                    );}
                    $product["destination"]=$LatLng;
                    $sqls= "select rating from feedback where category='Scooter' and place='$row[0]' ";
                    $results = mysqli_query($conn,$sqls) or die(mysql_error());
                    if (mysqli_num_rows($results) > 0) {
                        while ($rows = mysqli_fetch_array($results)) {
                           $rate=$rate+$rows[0];
                           $i++;
                        }
                        $product['rating']=$rate/$i;
                    }
                    else{
                        $product["rating"]=$row[1];
                    }
                    $poi=$row[6];
                    $poiEx=explode('|', $poi);
                    $poiDescc=explode('|', $row[13]);
                    $poiAudioo=explode('|', $row[7]);
                    $arr["poi"]=array();
                    $arr["poiName"]=array();
                    $arr["poiDesc"]=array();
                    $arr["poiAudio"]=array();
                    for ($num = 0; $num <= $row[12]; $num ++) { 
                        if($poiEx[$num]!=""){
                            $address = urlencode($poiEx[$num]);
                            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC9K_dOXfhycnbgRMhFN3SfVmOcFFoImJ8";
                            $data = @file_get_contents($url);
                            $jsondata = json_decode($data,true);
                            if ($jsondata["status"] == "OK") { 
                                $lat = $jsondata["results"][0]["geometry"]["location"]["lat"];
                                $lng = $jsondata["results"][0]["geometry"]["location"]["lng"];
                                $LatLng = array(
                                    'latitude' => $jsondata["results"][0]["geometry"]["location"]["lat"],
                                    'longitude' => $jsondata["results"][0]["geometry"]["location"]["lng"],
                                    'latitudeDelta'=> 0.0922,
                                    'longitudeDelta'=> 0.0421,
                                );
                                array_push($arr["poi"], $LatLng);
                                array_push($arr["poiName"], $poiEx[$num]);
                                array_push($arr["poiDesc"], $poiDescc[$num]);
                                array_push($arr["poiAudio"], $poiAudioo[$num]);
                            }
                        }
                    }
                    $product["poiName"]=$arr["poiName"];
                    $product["poiDesc"]=$arr["poiDesc"];
                    $product["poiAudio"]=$arr["poiAudio"];
                    $product["poi"]=$arr["poi"];
                    if($x>=$y && $x<=$z){
                        array_push($response["results"], $product);
                    }
                    $x++;
                }echo json_encode($response);
            }
            else
            {
                echo json_encode($response);
            }
            mysqli_close($con);
        }
}
catch(PDOException $e)
{
}
?>