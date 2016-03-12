<!DOCTYPE html>
<html lang="en">

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-73568956-2', 'auto');
  ga('send', 'pageview');

</script>
 
<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tau Kappa Epsilon | Theta-Chi</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

	<!--Forum CSS TESTING-->
	<link href="css/forum.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
 
<body>
	
	<div class="brand">TAU KAPPA EPSILON | Θ Χ</div>
    <div class="address-bar"> Better Men for A Better World </div> 
    
    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="rush.html">TKE</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="rush.html">Rush</a>
                    </li>
                    <li>
                        <a href="about.html">About</a>
                    </li>
                    <!-- li>
                        <a href="charity.html">Charity</a>
                    </li-->
                    <li>
                        <a href="roster.html">Roster</a>
                    </li>
                    <li>
                        <a href="contact.html">Contact</a>
                    </li>
                    <li>
                        <a href="forum.html">Forum</a>
                    </li>
                </ul>
            </div>
        <!-- /.container -->
    </nav>

<div class="container">

 
<div class="content">
<div class="newsBox">
<p>Using the Boxes below, sign in to the forum :)</p>

<?php
$fields = ('username','password','scroll');
$newconn = connectDB();

if(isset($_POST['submit'])){
	$error = false;
	foreach($fields AS $fieldname) {
		//For each field, check to make sure the field has a value
		if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
			$error = true;
		}
	}

	if(!$error) { //Only create queries when no error occurs
		updateUsers($newconn);
	}
	else{
		echo "<p><font color='red'>Please fill out all required fields before submitting changes.</font></p>";
	}
}

function connectDB() {
	try{
	$conn = new PDO("sqlsrv:Server=52.73.15.164\\sqlexpress;Database=Tke1", "login", "Sweetarts11");
    return $conn;
	}
	catch (Exception $e){
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}
function getUsers($dbc){
	try{
		$query = $dbc->prepare("SELECT FirstName, LastName, EmployeeID FROM dbo.Users");
		$query->execute();
		echo"<form method=\"post\" action=\"{$_SERVER['PHP_SELF']}\">";
		echo "<select name=\"formUserID\">";
		echo "<option value=\"\">Select...</option>";
		for ($i = 0; $row = $query->fetch(); $i++){
			$employees = $row['EmployeeID'];
			$valueData = "{$row['LastName']}, {$row['FirstName']}";
			echo "<option value=\"{$row['EmployeeID']}\">{$valueData}</option>";
		}
		echo "</select>";
	}
	catch(Exception $e){echo "Oh well!";}
}
function updateUsers($c){
	try{
		$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = $c->prepare("UPDATE dbo.Users SET SundayOnDuty = :sunOn, SundayOffDuty = :sunOff, MondayOnDuty = :monOn,
		MondayOffDuty = :monOff, TuesdayOnDuty = :tueOn, TuesdayOffDuty = :tueOff, WednesdayOnDuty = :wedOn,
		WednesdayOffDuty = :wedOff, ThursdayOnDuty = :thuOn, ThursdayOffDuty = :thuOff, FridayOnDuty = :friOn,
		FridayOffDuty = :friOff, SaturdayOnDuty = :satOn, SaturdayOffDuty = :satOff, OnVacation = :onVac,
		Active = :activ, EscalationLevel = :escLev WHERE EmployeeID = :formID;");
		
		$sundatfo = date("Y-m-d H:i:s",strtotime($_POST['sunOnDuty']));
		$sun2datfo = date("Y-m-d H:i:s",strtotime($_POST['sunOffDuty']));
		$mondatfo = date("Y-m-d H:i:s",strtotime($_POST['monOnDuty']));
		$mon2datfo = date("Y-m-d H:i:s",strtotime($_POST['monOffDuty']));
		$tuedatfo = date("Y-m-d H:i:s",strtotime($_POST['tuesOnDuty']));
		$tue2datfo = date("Y-m-d H:i:s",strtotime($_POST['tuesOffDuty']));
		$weddatfo = date("Y-m-d H:i:s",strtotime($_POST['wedsOnDuty']));
		$wed2datfo = date("Y-m-d H:i:s",strtotime($_POST['wedsOffDuty']));
		$thudatfo = date("Y-m-d H:i:s",strtotime($_POST['thursOnDuty']));
		$thu2datfo = date("Y-m-d H:i:s",strtotime($_POST['thursOffDuty']));
		$fridatfo = date("Y-m-d H:i:s",strtotime($_POST['friOnDuty']));
		$fri2datfo = date("Y-m-d H:i:s",strtotime($_POST['friOffDuty']));
		$satdatfo = date("Y-m-d H:i:s",strtotime($_POST['satOnDuty']));
		$sat2datfo = date("Y-m-d H:i:s",strtotime($_POST['satOffDuty']));
		
		$sql->bindParam(':sunOn', $sundatfo, PDO::PARAM_STR);
		$sql->bindParam(':sunOff', $sun2datfo, PDO::PARAM_STR);
		$sql->bindParam(':monOn', $mondatfo, PDO::PARAM_STR);
		$sql->bindParam(':monOff', $mon2datfo, PDO::PARAM_STR);
		$sql->bindParam(':tueOn', $tuedatfo, PDO::PARAM_STR);
		$sql->bindParam(':tueOff', $tue2datfo, PDO::PARAM_STR);
		$sql->bindParam(':wedOn', $weddatfo, PDO::PARAM_STR);
		$sql->bindParam(':wedOff', $wed2datfo, PDO::PARAM_STR);
		$sql->bindParam(':thuOn', $thudatfo, PDO::PARAM_STR);
		$sql->bindParam(':thuOff', $thu2datfo, PDO::PARAM_STR);
		$sql->bindParam(':friOn', $fridatfo, PDO::PARAM_STR);
		$sql->bindParam(':friOff', $fri2datfo, PDO::PARAM_STR);
		$sql->bindParam(':satOn', $satdatfo, PDO::PARAM_STR);
		$sql->bindParam(':satOff', $sat2datfo, PDO::PARAM_STR);
		
		$sql->bindParam(':onVac', $_POST['onVacation'], PDO::PARAM_BOOL);
		$sql->bindParam(':activ', $_POST['active'], PDO::PARAM_BOOL);
		$sql->bindParam(':escLev', $_POST['escLevel'], PDO::PARAM_INT);
		$sql->bindParam(':formID', $_POST['formUserID'], PDO::PARAM_INT);
		
		$sql->execute();
		echo "User updated successfully!";	
	}
	catch(Exception $e){
		echo "Check Input Error: " .$e->getMessage(). "</br>";
		echo "Trouble at the mill!";
	}
}
try{
	$conn = connectDB();
	if($conn) {
		getUsers($conn);		
	}
	else {
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}
}
catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
 ?>

<input type="submit", name="submit", value = "Submit"/>

</form>

</div>

</div>

<div class="footer">
		
</div><!-- end .footer -->
</div><!-- end .container -->
</body>
</html>