<?php 
$con=mysqli_connect("localhost","robera","password","cruiser_app");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }




?>

<!DOCTYPE html>
<html>
  <head>
    <title>Cruiser</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
	<link href='http://fonts.googleapis.com/css?family=Bree+Serif|Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/custom.css" rel="stylesheet" >

	   <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/respond.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	<!-- This is to enable us to use less -->
	<!-- <link rel="stylesheet/less" type="text/css" href="css/styles.less"  /> -->
	<link href='http://fonts.googleapis.com/css?family=Graduate' rel='stylesheet' type='text/css'>

  </head>
  <body id="home" style=" background-color: black; ">
	<!-- <div id="full-screen"></div>-->
	<section class="row">
	
	<h1 class="col-xs-8 col-xs-offset-2" style="font-family: 'Graduate', cursive; color:rgb(148, 13, 56); font-weight:900; text-align:center; " >CRUISER APP</h2>
	</section>
			<ul class="nav nav-pills">
			  <li class="active"><a href="#"></a></li>
				<?php include_once '../includes/compute.php'; ?>
			</ul>

	 
	 <?php 
	 mysqli_close($con);
	 ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/less.js" type="text/javascript"></script>
  </body>
</html>