<!DOCTYPE html>
<html lang="en" class="no-js"> 
    <head>
        <meta charset="UTF-8" />
        <title>Jrarron | Add Route</title>
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
        <script type="text/javascript">
               function initialize() {
                    var input = document.getElementById('source');
                    var autocompletess = new google.maps.places.Autocomplete(input);
                    var inputs = document.getElementById('destination');
                    var autocompletes = new google.maps.places.Autocomplete(inputs);
               }
               google.maps.event.addDomListener(window, 'load', initialize);
       </script>
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
        if(isset($_POST["register"])){
            $category=$_POST["category"];
            $source=$_POST["source"]; 
            $i=0;
            $destination=$_POST["destination"];
            $route_name=$_POST["passwordsignup"];
            $about_route=$_POST["passwordsignup_confirm"];
            // $poi=$_POST["poi"];
            // for ($num = 1; $num <= 9; $num ++) { 
            //     $temp='poi'.$num;
            //     if($_POST[$temp]!=""){
            //         $poi=$poi.'|'.$_POST[$temp];
            //         $i++;
            //     }
            // }   
            $sql="SELECT * FROM `admin` where place='$route_name' and category='$category'";
            $finding = mysqli_query($conn,$sql);
            if(mysqli_num_rows($finding) > 0)
            {
                $message= "Oops! Route with Same Category already exists.";
            }
            else
            {
                $target_dir = "uploads/";
                $target_file = $target_dir . $category.$route_name.basename($_FILES["imageUpload"]["name"]);
		        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
                    $images= $category.$route_name.basename( $_FILES["imageUpload"]["name"],".jpg"); 
                    $actualpath = "http://rbtechsolution.com/Jrarron/admin/uploads/$images";
                    // $target_dirPOI = "poi/";
                    // $target_filePOI = $target_dirPOI . $category.$route_name. basename($_FILES["poiAudio"]["name"]);
                    // move_uploaded_file($_FILES["poiAudio"]["tmp_name"], $target_filePOI);
                    // $imagesPOI=$category.$route_name.basename( $_FILES["poiAudio"]["name"],".jpg"); 
                    // $actualpathPOI = "https://bazar4you.online/gaurav/Jrarron/admin/poi/$imagesPOI";
                
                    // $target_dirPOIT = "poiText/";
                    // $target_filePOIT = $target_dirPOIT . $category.$route_name. basename($_FILES["poiText"]["name"]);
                    // move_uploaded_file($_FILES["poiText"]["tmp_name"], $target_filePOIT);
                    // $imagesPOIT=$category.$route_name.basename( $_FILES["poiText"]["name"],".jpg"); 
                    // $actualpathPOIT = "https://bazar4you.online/gaurav/Jrarron/admin/poiText/$imagesPOIT";
                    // $sql = "INSERT INTO `admin`(`place`, `rating`, `category`, `img_name`, `img_url`, `about_route`, `point_of_interest`, `poi_audio_file`,`source`,`destination`,`poi_text_file`,`no_poi`) VALUES
		                //  ('$route_name','0','$category','$images','$actualpath','$about_route','$poi','$actualpathPOI','$source','$destination','$actualpathPOIT','$i')";
		            $sql = "INSERT INTO `admin`(`place`, `rating`, `category`, `img_name`, `img_url`, `about_route`, `point_of_interest`, `poi_audio_file`,`source`,`destination`,`poi_text_file`,`no_poi`) VALUES
		                ('$route_name','0','$category','$images','$actualpath','$about_route','0','0','$source','$destination','0','0')";
                    if ($conn->query($sql)) {
                        $resultss = mysqli_query($conn,"SELECT * FROM `admin` where place='$route_name' and category='$category'");
                        $message="Route successfully Added.Now add Point of Interest";
                        while($row=mysqli_fetch_row($resultss)){
                            echo '<script>window.location="add_poi.php?route_id=';
                            echo $row[8];
                            echo '"</script>';
                        }
                    } 
                    else 
                    {
                        $message="Error while adding";
                    }
                } 
                else {
                    $message="Sorry, there was an error uploading your file.";
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
                                <h1> Add New Route </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname"  > Category </label>
                                    <select id="category" name="category" required="required"  class="to_register" size="1">
                                            <option value="Driving">Driving</option>
                                            <option value="Bike">Bike</option>
                                            <option value="Walking">Walking</option>
                                            <option value="Scooter">Scooter</option>
                                    </select>
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" >Route Name</label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="text" placeholder="eg. Berclona" maxlength="200"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Source</label>
                                    <input id="source" name="source" required="required" type="text" maxlength="100" placeholder="eg. Berclona" autocomplete="on"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Destination</label>
                                    <input id="destination" name="destination" required="required" type="text" maxlength="100" placeholder="eg. Berclona" autocomplete="on"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >About Route</label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="text" maxlength="300" placeholder="eg. Good place"/>
                                </p>
                                <!--<p> -->
                                <!--    <label for="passwordsignup_confirm" class="youpasswd" >Point of Interest</label></t></t></t></t>-->
                                <!--    <label for="passwordsignup_confirm" class="youpasswd" onclick="myFunction('poi')" style="  margin-left: 280px;font-size: 10px;">+Add</label>-->
                                <!--    <input id="poi" name="poi"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b" onclick="myFunctionn('b','poi')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <input id="poi1" name="poi1"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b1" onclick="myFunctionn('b1','poi1')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <input id="poi2" name="poi2"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b2" onclick="myFunctionn('b2','poi2')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <input id="poi3" name="poi3"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b3" onclick="myFunctionn('b3','poi3')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <input id="poi4" name="poi4"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b4" onclick="myFunctionn('b4','poi4')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <input id="poi5" name="poi5"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b5" onclick="myFunctionn('b5','poi5')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <input id="poi6" name="poi6"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b6" onclick="myFunctionn('b6','poi6')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <input id="poi7" name="poi7" type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b7" onclick="myFunctionn('b7','poi7')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <input id="poi8" name="poi8"  type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b8" onclick="myFunctionn('b8','poi8')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <input id="poi9" name="poi9" type="text" placeholder="eg.Sagrada Famili " autocomplete="on"/>-->
                                <!--    <label id="b9" onclick="myFunctionn('b9','poi9')" style="  margin-left: 380px;font-size: 10px;">.remove</label>-->
                                <!--    <script>-->
                                <!--        var i='';-->
                                <!--        var j;-->
                                <!--        var y;-->
                                <!--        y = document.getElementById('poi');-->
                                <!--        y.style.display = "none";-->
                                <!--        y = document.getElementById('b');-->
                                <!--        y.style.display = "none";-->
                                <!--        for (j = 1; j < 10; j++) { -->
                                <!--            y = document.getElementById('poi'+j);-->
                                <!--            y.style.display = "none";-->
                                <!--            y = document.getElementById('b'+j);-->
                                <!--            y.style.display = "none";-->
                                <!--        }-->
                                <!--        function myFunction(id) {-->
                                <!--            var x = document.getElementById(id+i);-->
                                <!--            x.style.display = "block";-->
                                <!--            var z = document.getElementById('b'+i);-->
                                <!--            z.style.display = "block";-->
                                <!--            i++;-->
                                <!--        }-->
                                <!--        function myFunctionn(id,idd) {-->
                                <!--            var x = document.getElementById(id);-->
                                <!--            x.style.display = "none";-->
                                <!--            var z = document.getElementById(idd);-->
                                <!--                    document.getElementById(idd).value = "";-->
                                <!--            z.style.display = "none";-->
                                <!--            var res = id.substring(1, 2);-->
                                <!--            i='';-->
                                <!--        }-->
                                <!--        function initt() {-->
                                <!--            var In = [];-->
                                <!--            var autocomplete = [];-->
                                <!--            In[0] = document.getElementById('poi');-->
                                <!--            autocomplete[0] = new google.maps.places.Autocomplete(In[0]);-->
                                            
                                <!--            In[1] = document.getElementById('poi1');-->
                                <!--            autocomplete[1] = new google.maps.places.Autocomplete(In[1]);-->
                                            
                                <!--            In[2] = document.getElementById('poi2');-->
                                <!--            autocomplete[2] = new google.maps.places.Autocomplete(In[2]);-->
                                            
                                <!--            In[3] = document.getElementById('poi3');-->
                                <!--            autocomplete[3] = new google.maps.places.Autocomplete(In[3]);-->
                                            
                                <!--            In[4] = document.getElementById('poi4');-->
                                <!--            autocomplete[4] = new google.maps.places.Autocomplete(In[4]);-->
                                            
                                <!--            In[5] = document.getElementById('poi5');-->
                                <!--            autocomplete[5] = new google.maps.places.Autocomplete(In[5]);-->
                                            
                                <!--            In[6] = document.getElementById('poi6');-->
                                <!--            autocomplete[6] = new google.maps.places.Autocomplete(In[6]);-->
                                            
                                <!--            In[7] = document.getElementById('poi7');-->
                                <!--            autocomplete[7] = new google.maps.places.Autocomplete(In[7]);-->
                                            
                                <!--            In[8] = document.getElementById('poi8');-->
                                <!--            autocomplete[8] = new google.maps.places.Autocomplete(In[8]);-->
                                            
                                <!--            In[9] = document.getElementById('poi9');-->
                                <!--            autocomplete[9] = new google.maps.places.Autocomplete(In[9]);-->
                                <!--        }-->
                                <!--        google.maps.event.addDomListener(window, 'load', initt);-->
                                <!--    </script>-->
                                <!--</p>-->
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" >Image</label>
                                    <input  type="file" id="imageUpload" name="imageUpload" class="to_register" required="required" />
                                </p>
                                <!--<p> -->
                                <!--    <label for="passwordsignup_confirm" class="youpasswd" >Point of Interest Text file</label>-->
                                <!--    <input type="file" id="poiText" name="poiText" class="to_register" required="required" sty/>-->
                                <!--</p>-->
                                <!--<p> -->
                                <!--    <label for="passwordsignup_confirm" class="youpasswd" >Point of Interest Audio file</label>-->
                                <!--    <input type="file" id="poiAudio" name="poiAudio" class="to_register" required="required" sty/>-->
                                <!--</p>-->
                                <p class="signin button"> 
									<input type="submit" name="register" value="Submit & Add Point of Interest" style="width:60%"/> 
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
