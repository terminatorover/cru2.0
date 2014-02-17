

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
	   
			<!-- Slidebars CSS -->
		<link rel="stylesheet" href="css/slidebars.min.css">
	   
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
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-47930591-1', 'colgatecruiser.com');
	  ga('send', 'pageview');

	</script>

  </head>
  <body id="home" style=" background-color: black; ">
  
	

	<div id="sb-site">
	  	<!-- this is the background picture --> 
		<div id="full-screen"></div>
	  	<!-- this is the page header  --> 
		<section class="row">
			<h1 class="col-xs-8 col-xs-offset-2" style=" border-bottom: 1.4px rgba(136, 74, 74, 0.78) solid; font-family: 'Graduate', cursive; color:rgb(148, 13, 56); font-weight:900; text-align:center; " >GATE CRUISER</h2>
		</section>
		<!-- this is the page header  --> 

		<button class="btn btn-danger btn btn-danger col-xs-8 col-xs-offset-2 col-sm-2 col-sm-offset-5 toggle-left" style =" font-family: 'Graduate', cursive;" > Custom Day/Time</button>

	<section id="contain" class="row">
	 <form id="place_form" name="place_form"   method="GET" action="goto_copy.php" class="col-xs-8 col-xs-offset-2">
	 
			<!-- ----------------------------------------------------------------------------------------------------------------->
			<div class="row">
				<div class="col-xs-9 col-xs-offset-1 col-sm-6 col-sm-offset-3">
					<div  style = " text-align: center; margin-top:2em; font-family: 'Graduate', cursive;"><span style=" color: white; font-size:large; text-shadow: black 0.1em 0.1em 0.2em ;">FROM</span></div>

					<section  >						
							<div class="btn-group  " style="width:100%;padding-right: 0px; padding-bottom: 1.6em; padding-left:0px; text-shadow: black 0.1em 0.1em 0.2em;"  >
							  <!-- UPPER CAMPUS-->
							  <button type="button" class="btn btn-default res"  style="padding-right: 14px;width: 100%;; background-color:#B0312A; font-family: 'Graduate', cursive; border: 0px; padding-bottom: 1.6em; padding-top: 1.5em;padding-top: 1.5em;">
								 <select class="form-control" name="from">
											<option value="104_Broad_St">104 Broad St.</option>
											<option value="110_Broad_St">110 Broad St.</option>
											<option value="Bookstore">Bookstore</option>
											<option value="Case_Geyer_Library">Case-Geyer Library </option>
											<option value="Cutten_Hall">Cutten Hall</option>
											<option value="Frank_Dining_Hall">Frank Dining Hall</option>
											<option value="Gate_House">Gate House</option>
											<option value="Hamilton_Airport">Hamilton Airport</option>
											<option value="Kendrick_and_Broad">Kendrick &amp; Broad </option>
											<option value="Newell_Apartments">Newell Apartments</option>
											<option value="Parker_Apartments">Parker Apartments </option>
											<option value="Parrys_Plaza">Parry&#39;s Plaza</option>
											<option value="Perrson_Hall" >Perrson Hall</option>
											<option value="Price_Chopper">Price Chopper </option>
											<option value="SOMAC"> SOMAC</option>
											<option value="Townhouses">Townhouses</option>
											<option value="University_Ct_Burch">University Ct./Burch </option>
											<option value="Village_Green">Village Green </option>
											<option value="Whitnall_Field">Whitnall Field</option>
								 </select>
							  </button>
							</div>
					</section>			
					
					<section >
						<div style = " text-align: center; margin-top:2em; font-family: 'Graduate', cursive;"><span style=" color: white; font-size:large; text-shadow: black 0.1em 0.1em 0.2em ;">TO</span></div>

						<div class="btn-group " style="width:100%;padding-right: 0px; padding-bottom: 1.6em; padding-left:0px; text-shadow: black 0.1em 0.1em 0.2em;"  >
						 
						  <button type="button" class="btn btn-default res"  style="padding-right: 14px; width: 100%; background-color:#B0312A; font-family: 'Graduate', cursive; border: 0px; padding-bottom: 1.6em; padding-top: 1.5em;padding-top: 1.5em;">
							 <select class="form-control" name="to">
										<option value="104_Broad_St">104 Broad St.</option>
										<option value="110_Broad_St">110 Broad St.</option>
										<option value="Bookstore">Bookstore</option>
										<option value="Case_Geyer_Library">Case-Geyer Library </option>
										<option value="Cutten_Hall">Cutten Hall</option>
										<option value="Frank_Dining_Hall">Frank Dining Hall</option>
										<option value="Gate_House">Gate House</option>
										<option value="Hamilton_Airport">Hamilton Airport</option>
										<option value="Kendrick_and_Broad">Kendrick &amp; Broad </option>
										<option value="Newell_Apartments">Newell Apartments</option>
										<option value="Parker_Apartments">Parker Apartments </option>
										<option value="Parrys_Plaza">Parry&#39;s Plaza</option>
										<option value="Perrson_Hall" >Perrson Hall</option>
										<option value="Price_Chopper">Price Chopper </option>
										<option value="SOMAC"> SOMAC</option>
										<option value="Townhouses">Townhouses</option>
										<option value="University_Ct_Burch">University Ct./Burch </option>
										<option value="Village_Green">Village Green </option>
										<option value="Whitnall_Field">Whitnall Field</option>

							 </select>
						  </button>
						</div>
				</section>
				<!-- this is the BUTTON  --> 
				 
				</div>
			
			</div>


			<!-- ----------------------------------------------------------------------------------------------------------------->

		
	 </form>

	 <!-- this is the BUTTON  --> 

	<div class="row">
		<button type="submit"  value="Submit Form 1 & 2" onClick="submitAllDocumentForms()" class="btn btn-danger col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4" style ="margin-top:3em; font-family: 'Graduate', cursive;" >GO</button>
	</div>
	</section>

	</div>

	<!-- Your left Slidebar content. -->
	<div class="sb-slidebar sb-left">
						<!-- this is the side bar itself  --> 	
	<form id="time_form" name="time_form"   method="GET" action="goto_copy.php">							
							<div class="btn-group  " style="width:100%;padding-right: 0px; padding-bottom: 1.6em; padding-left:0px; text-shadow: black 0.1em 0.1em 0.2em;"  >
							  <!--DAY SELECTOR-->
							  <button type="button" class="btn btn-default res"  style="padding-right: 14px;width: 100%;; background-color:#B0312A; font-family: 'Graduate', cursive; border: 0px; padding-bottom: 1.6em; padding-top: 1.5em;padding-top: 1.5em;">
								 <select class="form-control" name="day">
											<option value="today">DAY</option>					
											<option value="1">Monday</option>
											<option value="2">Tuesday</option>
											<option value="3">Wednesday</option>
											<option value="4">Thursday</option>
											<option value="5">Friday</option>
											<option value="6">Saturday</option>
											<option value="0">Sunday</option>										
								 </select>
								 
							  </button>
							  <!--HOUR SELECTOR-->
							  <button type="button" class="btn btn-default res"  style="padding-right: 14px;width: 100%;; background-color:#B0312A; font-family: 'Graduate', cursive; border: 0px; padding-bottom: 1.6em; padding-top: 1.5em;padding-top: 1.5em;">
									 <select class="form-control" name="hour">
											<option value="current_hour">Hour</option>					
											<option value="24">12AM</option>
											<option value="1">1AM</option>
											<option value="2">2AM</option>
											<option value="3">3AM</option>
											<option value="4">4AM</option>
											<option value="5">5AM</option>
											<option value="6">6AM</option>
											<option value="7">7AM</option>
											<option value="8">8AM</option>
											<option value="9">9AM</option>
											<option value="10">10AM</option>
											<option value="11">11AM</option>
											<option value="12">12PM</option>
											<option value="13">1PM</option>
											<option value="14">2PM</option>
											<option value="15">3PM</option>
											<option value="16">4PM</option>
											<option value="17">5PM</option>
											<option value="18">6PM</option>
											<option value="19">7PM</option>
											<option value="20">8PM</option>
											<option value="21">9PM</option>
											<option value="22">10PM</option>
											<option value="23">11PM</option>																		
								 </select>
							   </button>
							<!--MINUTE SELECTOR-->
							  <button type="button" class="btn btn-default res"  style="padding-right: 14px;width: 100%;; background-color:#B0312A; font-family: 'Graduate', cursive; border: 0px; padding-bottom: 1.6em; padding-top: 1.5em;padding-top: 1.5em;">
									 <select class="form-control" name="minute">
									 
											<option value="min">Minute</option>
											<option value="0">0</option>
											<option value="5">5</option>
											<option value="10">10</option>
											<option value="15">15</option>
											<option value="20">20</option>
											<option value="25">25</option>
											<option value="30">30</option>
											<option value="35">35</option>
											<option value="40">40</option>
											<option value="45">45</option>
											<option value="50">50</option>
											<option value="55">55</option>
											<option value="60">60</option>
									</select>
									
							   </button>

							</div>
						<!-- to get back to the main page -->
						<button type="button" class="btn btn-default res toggle-left"  style="color:white ;padding-right: 14px;width: 100%;; background-color:#B0312A; font-family: 'Graduate', cursive; border: 0px; padding-bottom: 1.6em; padding-top: 1.5em;padding-top: 1.5em;">SET</button>
			</form>

			
	</div>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<!-- scripts enabling the sliding side bar action -->  
	
	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>  
<script src="js/slidebars.min.js"></script>
	<!-- script enabling the sliding side bar reasons -->  

<script>
$(document).ready(function() {
var mySlidebars = new $.slidebars();
 
$('.toggle-left').on('click', function() {
mySlidebars.toggle('left');
});
 
});
</script>


<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
/* Collect all forms in document to one and post it */
function submitAllDocumentForms() {
var arrDocForms = document.getElementsByTagName('form');
var formCollector = document.createElement("form");
with(formCollector)
{
method = "get";
action = "goto_copy.php";
name = "formCollector";
id = "formCollector";
}
for(var ix=0;ix<arrDocForms.length;ix++) {
appendFormVals2Form(arrDocForms[ix], formCollector);
}
document.body.appendChild(formCollector);
formCollector.submit();

}
/* Function: add all elements from ``frmCollectFrom´´ and append them to ``frmCollector´´ before returning ``frmCollector´´*/
function appendFormVals2Form(frmCollectFrom, frmCollector) {
var frm = frmCollectFrom.elements;
for(var ix = 0 ; ix < frm.length ; ix++)
frmCollector.appendChild(frm[ix]);
return frmCollector;
}

</SCRIPT>

	<script src="js/less.js" type="text/javascript"></script>


  </body>
</html>