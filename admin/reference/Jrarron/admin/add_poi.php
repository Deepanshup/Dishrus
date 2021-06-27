<!DOCTYPE html>
<html lang="en" class="no-js"> 
    <head>
        <meta charset="UTF-8" />
        <title>Jrarron | Add Point Of Interest</title>
        <link rel="icon" sizes="72x72" href="./images/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style3.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdFvXTNcn2V80lPvfSMEl1FuLegxJJNos&libraries=places" type="text/javascript"></script>
    </head>
    <body>
    <?php
    session_start();
    $servername = "localhost";
    $username = "nadaa93i_gaurav";
    $password = "root@123";
    $dbname = "nadaa93i_Jrarron";
    try 
    {   $message="";
        $conn = new mysqli($servername, $username, $password,$dbname);
        $end=$_SESSION["end"];
        if($end!="true"){
            echo '<script>
                    window.location="adminLogin.php";
                </script>';
        }
        $route_id=$_GET["route_id"];
        if(isset($_POST["register"])){
            //$category=$_POST["category"];
            //$route_name=$_POST["passwordsignup"];
            //$source=$_POST["source"]; 
            $i=0;
            //$destination=$_POST["destination"];
            //$about_route=$_POST["passwordsignup_confirm"];
            if($_POST["poi"]!=""){
                $poi=$_POST["poi"];
                
                    $stripped = str_replace(' ', '', $_POST["poi"]);
                    $target_dirPOI = "poi/";
                    $target_filePOI = $target_dirPOI.$route_id.$stripped.basename($_FILES["poiAudio"]["name"]);
                    if (move_uploaded_file($_FILES["poiAudio"]["tmp_name"], $target_filePOI)) {
                        $imagesPOI=$route_id.$stripped.basename( $_FILES["poiAudio"]["name"],".jpg"); 
                        $actualpathPOI = "https://bazar4you.online/gaurav/Jrarron/admin/poi/$imagesPOI";
                    } 
                    else {
                        $message="Sorry, there was an error uploading your file.";
                    }
                
                
                
                
                $i++;
            }
            for ($num = 1; $num <= 9; $num ++) { 
                $temp='poi'.$num;
                if($_POST[$temp]!=""){
                    $poi=$poi.'|'.$_POST[$temp];
                    
                    
                    $stripped = str_replace(' ', '', $_POST[$temp]);
                    $target_dirPOI = "poi/";
                    $target_filePOI = $target_dirPOI.$route_id.$stripped.basename($_FILES["poiAudio".$num]["name"]);
                    if (move_uploaded_file($_FILES["poiAudio".$num]["tmp_name"], $target_filePOI)) {
                        $imagesPOI=$route_id.$stripped.basename( $_FILES["poiAudio".$num]["name"],".jpg"); 
                        $actualpathPOI = $actualpathPOI.'|'."https://bazar4you.online/gaurav/Jrarron/admin/poi/$imagesPOI";
                    } 
                    else {
                        $message="Sorry, there was an error uploading your file.";
                    }
                    
                    
                    
                    
                    
                    
                    $i++;
                }
            }
            $poiDesc=$_POST["poiDesc"];
            for ($num = 1; $num <= 9; $num ++) { 
                $temp='poiDesc'.$num;
                if($_POST[$temp]!=""){
                    $poiDesc=$poiDesc.'|'.$_POST[$temp];
                }
            }
    //aaj         $target_dirPOI = "poi/";
    //aaj         $target_filePOI = $target_dirPOI.$route_id.basename($_FILES["poiAudio"]["name"]);
    //aaj         if (move_uploaded_file($_FILES["poiAudio"]["tmp_name"], $target_filePOI)) {
    //aaj             $imagesPOI=$route_id.basename( $_FILES["poiAudio"]["name"],".jpg"); 
    //aaj             $actualpathPOI = "https://bazar4you.online/gaurav/Jrarron/admin/poi/$imagesPOI";
    //aaj             $sql="UPDATE `admin` SET `point_of_interest`='$poi',`poi_audio_file`='$actualpathPOI',`no_poi`='$i',`poi_desc`='$poiDesc' WHERE route_id='$route_id'";
		  //    //  $sql = "INSERT INTO `admin`(`place`, `rating`, `category`, `img_name`, `img_url`, `about_route`, `point_of_interest`, `poi_audio_file`,`source`,`destination`,`poi_text_file`,`no_poi`) VALUES
		  //    //      ('$route_name','0','$category','$images','$actualpath','$about_route','$poi','$actualpathPOI','$source','$destination','$actualpathPOIT','$i')";
    //aaj             if ($conn->query($sql)) {
    //aaj                     $message="POI successfully Added.";
    //aaj             } 
    //aaj             else 
    //aaj             {
    //aaj                      $message="Error while adding";
    //aaj             }
    //aaj         } 
    //aaj         else {
    //aaj             $message="Sorry, there was an error uploading your file.";
    //aaj         }
            
            
            
            
            if ($message=="Sorry, there was an error uploading your file.") {
                $message="Sorry, there was an error uploading your file.";
            } 
            else {
                $sql="UPDATE `admin` SET `point_of_interest`='$poi',`poi_audio_file`='$actualpathPOI',`no_poi`='$i',`poi_desc`='$poiDesc' WHERE route_id='$route_id'";
                if ($conn->query($sql)) {
                        $message="POI successfully Added.";
                } 
                else 
                {
                         $message="Error while adding";
                }
            }
            
            
            
            
            
            
        }
    }
    catch(PDOException $e)
    {
        $message="Error in Network";
        $_SESSION["end"]="false";
        echo '<script>
            window.location="adminLogin.php";
            </script>';
    }
    ?>
        <div class="container">
            <header>
				<nav class="codrops-demos">
				</nav>
            </header>
            <section>				
                <div id="container_demo" >
                    <div id="wrapper">

                        <div id="login" class="animate form">
                            <form  action="" method="post" autocomplete="on" enctype="multipart/form-data"> 
                                <h1> Add Point Of Interest </h1> 
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Point of Interest</label></t></t></t></t>
                                    <label for="passwordsignup_confirm" class="youpasswd" onclick="myFunction('poi','poiDesc','poiAudio')" style="  margin-left: 280px;font-size: 10px;">+Add</label>
                                    
                                    <input id="poi" name="poi"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc" name="poiDesc"  type="text" placeholder="Description" autocomplete="on"/>
                                    <input type="file" id="poiAudio" name="poiAudio" class="to_register"  />
                                    <label id="b" onclick="myFunctionn('b','poi','poiDesc','poiAudio')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <input id="poi1" name="poi1"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc1" name="poiDesc1"  type="text" placeholder="Description" autocomplete="on"/>
                                    <input type="file" id="poiAudio1" name="poiAudio1" class="to_register"  />
                                    <label id="b1" onclick="myFunctionn('b1','poi1',''poiDesc1,'poiAudio1')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <input id="poi2" name="poi2"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc2" name="poiDesc2"  type="text" placeholder="Description" autocomplete="on"/>
                                    <input type="file" id="poiAudio2" name="poiAudio2" class="to_register" />
                                    <label id="b2" onclick="myFunctionn('b2','poi2','poiDesc2','poiAudio2')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <input id="poi3" name="poi3"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc3" name="poiDesc3"  type="text" placeholder="Description" autocomplete="on"/>
                                    <input type="file" id="poiAudio3" name="poiAudio3" class="to_register" />
                                    <label id="b3" onclick="myFunctionn('b3','poi3','poiDesc3','poiAudio3')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <input id="poi4" name="poi4"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc4" name="poiDesc4"  type="text" placeholder="Description"  autocomplete="on"/>
                                    <input type="file" id="poiAudio4" name="poiAudio4" class="to_register" />
                                    <label id="b4" onclick="myFunctionn('b4','poi4','poiDesc4','poiAudio4')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <input id="poi5" name="poi5"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc5" name="poiDesc5"  type="text" placeholder="Description" autocomplete="on"/>
                                    <input type="file" id="poiAudio5" name="poiAudio5" class="to_register"  />
                                    <label id="b5" onclick="myFunctionn('b5','poi5','poiDesc5','poiAudio5')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <input id="poi6" name="poi6"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc6" name="poiDesc6"  type="text" placeholder="Description" autocomplete="on"/>
                                    <input type="file" id="poiAudio6" name="poiAudio6" class="to_register"  />
                                    <label id="b6" onclick="myFunctionn('b6','poi6','poiDesc6','poiAudio6')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <input id="poi7" name="poi7" type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc7" name="poiDesc7" type="text" placeholder="Description" autocomplete="on"/>
                                    <input type="file" id="poiAudio7" name="poiAudio7" class="to_register"  />
                                    <label id="b7" onclick="myFunctionn('b7','poi7','poiDesc7','poiAudio7')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <input id="poi8" name="poi8"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc8" name="poiDesc8"  type="text" placeholder="Description" autocomplete="on"/>
                                    <input type="file" id="poiAudio8" name="poiAudio8" class="to_register"  />
                                    <label id="b8" onclick="myFunctionn('b8','poi8','poiDesc8','poiAudio8')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <input id="poi9" name="poi9" type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>
                                    <input id="poiDesc9" name="poiDesc9" type="text" placeholder="Description" autocomplete="on"/>
                                    <input type="file" id="poiAudio9" name="poiAudio9" class="to_register" />
                                    <label id="b9" onclick="myFunctionn('b9','poi9','poiDesc9','poiAudio9')" style="  margin-left: 380px;font-size: 10px;">.remove</label>
                                    
                                    <script>
                                        var i='';
                                        var j;
                                        var y;
                                        y = document.getElementById('poi');
                                        y.style.display = "none";
                                        y = document.getElementById('poiDesc');
                                        y.style.display = "none";
                                        y = document.getElementById('poiAudio');
                                        y.style.display = "none";
                                        y = document.getElementById('b');
                                        y.style.display = "none";
                                        for (j = 1; j < 10; j++) { 
                                            y = document.getElementById('poi'+j);
                                            y.style.display = "none";
                                            y = document.getElementById('poiDesc'+j);
                                            y.style.display = "none";
                                            y = document.getElementById('poiAudio'+j);
                                            y.style.display = "none";
                                            y = document.getElementById('b'+j);
                                            y.style.display = "none";
                                        }
                                        function myFunction(id,poiDescs,poiAudio) {
                                            var x = document.getElementById(id+i);
                                            x.style.display = "block";
                                            x = document.getElementById(poiDescs+i);
                                            x.style.display = "block";
                                            x = document.getElementById(poiAudio+i);
                                            x.style.display = "block";
                                            var z = document.getElementById('b'+i);
                                            z.style.display = "block";
                                            i++;
                                        }
                                        function myFunctionn(id,idd,poiDescs,poiAudio) {
                                            var x = document.getElementById(id);
                                            x.style.display = "none";
                                            var z = document.getElementById(idd);
                                                    document.getElementById(idd).value = "";
                                            z.style.display = "none";
                                            z = document.getElementById(poiDescs);
                                                    document.getElementById(poiDescs).value = "";
                                            z.style.display = "none";
                                            z = document.getElementById(poiAudio);
                                            z.style.display = "none";
                                            var res = id.substring(1, 2);
                                            i='';
                                        }
                                        function initt() {
                                            var In = [];
                                            var autocomplete = [];
                                            In[0] = document.getElementById('poi');
                                            autocomplete[0] = new google.maps.places.Autocomplete(In[0]);
                                            
                                            In[1] = document.getElementById('poi1');
                                            autocomplete[1] = new google.maps.places.Autocomplete(In[1]);
                                            
                                            In[2] = document.getElementById('poi2');
                                            autocomplete[2] = new google.maps.places.Autocomplete(In[2]);
                                            
                                            In[3] = document.getElementById('poi3');
                                            autocomplete[3] = new google.maps.places.Autocomplete(In[3]);
                                            
                                            In[4] = document.getElementById('poi4');
                                            autocomplete[4] = new google.maps.places.Autocomplete(In[4]);
                                            
                                            In[5] = document.getElementById('poi5');
                                            autocomplete[5] = new google.maps.places.Autocomplete(In[5]);
                                            
                                            In[6] = document.getElementById('poi6');
                                            autocomplete[6] = new google.maps.places.Autocomplete(In[6]);
                                            
                                            In[7] = document.getElementById('poi7');
                                            autocomplete[7] = new google.maps.places.Autocomplete(In[7]);
                                            
                                            In[8] = document.getElementById('poi8');
                                            autocomplete[8] = new google.maps.places.Autocomplete(In[8]);
                                            
                                            In[9] = document.getElementById('poi9');
                                            autocomplete[9] = new google.maps.places.Autocomplete(In[9]);
                                        }
                                        google.maps.event.addDomListener(window, 'load', initt);
                                    </script>
                                </p>
                                <!--<p> -->
                                <!--    <label for="passwordsignup_confirm" class="youpasswd" >Point of Interest Audio file</label>-->
                                <!--    <input type="file" id="poiAudio" name="poiAudio" class="to_register" required="required" />-->
                                <!--</p>-->
                                <p class="signin button"> 
									<input type="submit" name="register" value="Done"/> 
								</p>
								<p class="uname">
                                    <?=$message?>
                                </p>
                                <p class="change_link">  
									Don't want to add new route ?
									<a href="tables.php" class="to_register"> Go to Tables view </a>
								</p>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
