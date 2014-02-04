<?php 
// $hostname = null;
// $username = "root";
// $password = "";
// $database = "cruiser_app";
// $port = null;
// $socket = "/cloudsql/colgate-cruiser:get-cru2";

// local db 
// $hostname = 'localhost:3306';
// $username = "robera";
// $password = "password";
// $database = "cruiser_app";
// $port = null;
// $socket = null;


// $con = new mysqli($hostname,$username,$password,$database,$port,$socket);


// if (mysqli_connect_errno())
  // {
  // echo "Failed to connect to MySQL: " . mysqli_connect_error();
  // }





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
	<div id="full-screen"></div>
	<section class="row">
	
	<h1 class="col-xs-8 col-xs-offset-2" style="font-family: 'Graduate', cursive; color:rgb(148, 13, 56); font-weight:900; text-align:center; position: fixed;
top: -1px; " >CRUISER APP</h2>
	</section>
	
	<div class="row">
	<section class="col-sm-5 col-sm-offset-4 " style=" opacity: .9; /* background-color: rgb(62, 111, 69); */ color: black; background-color: rgba(7, 22, 27, 0.91);  ">
		<?php 
error_reporting(E_ERROR);

$hostname = 'localhost:3306';
$username = "robera";
$password = "password";
$database = "cruiser_app";
$port = null;
$socket = null;

$con = new mysqli($hostname,$username,$password,$database,$port,$socket);


if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


  //helper functions checks if the difference between the two hours is >=2
function t_diff($t1,$t2){
		/**
		This will come in handy in cases where for the fork case(aka hop on the cruiser now
		drive around crossing over to the next hour zone and get off at your destination)
		---specfically this will help us check if the waiting lasts for more than an hour 
		if that is the case then we can't say we have a solution because in these cases the
		cruiser stops running at some point (usually a lunch time scenario )
		**/
		// echo "CARE";
		// echo "<br>";
		$t1 = explode(":",$t1);
		$t1h = (int) $t1[0];
		$t1m = (int) $t1[1];
		$t2 = explode(":",$t2);
		$t2h = (int) $t2[0];
		$t2m = (int) $t2[1];
		// echo "T1H ".$t1h."==================="." T2H".$t2h;
		// echo "<br>";
		if (( $t1h-$t2h) >=2){
			return True;
		}else{return False;
		
		}
}
  
//helper for the next function compares two set of times that are imputed as strings
//returns true if the first time is after the second
	function t1_vs_t2($t1,$t2){
		$t1 = explode(":",$t1);
		$t1h = (int) $t1[0];
		$t1m = (int) $t1[1];
		$t2 = explode(":",$t2);
		$t2h = (int) $t2[0];
		$t2m = (int) $t2[1];
		if ( $t1h > $t2h){ return True;}
		elseif ($t2h > $t1h){return False;
		}else{ 
				if ( $t1m > $t2m){ return True;}
				elseif ($t2h > $t1h){return False;}
			}
		
	}

//-----------HELPER FUNCTIONS TO COVERT TIME FROM 24 hour to AM/PM 	
	function standard_time($input_time){
		$input_time = explode(":",$input_time);
		$input_time_h = (int) $input_time[0];
		$input_time_m = $input_time[1];//note that this is a string
		if ($input_time_h  == 24){//am next day 
			$net_h = (string) ($input_time_h - 12);
			return $net_h.":".$input_time_m."AM";
		}
		if ($input_time_h  == 12){//pm in the afternoon 
			$net_h = (string) ($input_time_h );
			return $net_h.":".$input_time_m."PM";
		}
		
		if ($input_time_h > 12){//pm zone
			$net_h = (string) ($input_time_h - 12);
			return $net_h.":".$input_time_m."PM";
		}
		else{//am current day 
			$net_h = (string) ($input_time_h );
			return $net_h.":".$input_time_m."AM";
		}
		
		
	}			
//wrapper function for asking the db the types of queries that we are interested in 
	function db_query($departure,$destination,$hour,$min,$given_route,$con,$mid_night){
	/**
	input will be the point of departure and destination,given hour and route + db connection 
	return will be a set of php raw handles
	**/
		if ( (int)$min >= 30){
			$ts = $hour * 2;
		}else{
			$ts = ($hour *2) - 1 ;
		}
		
		if ((!$mid_night) == True ){
			
			$the_query = sprintf("SELECT %s,%s FROM %s WHERE timeslot > %s ",$departure,$destination,$given_route,(string)($ts -1));//ts is for timeslot
			$result  = mysqli_query($con,$the_query);
			// echo "DAY QUERY ".$the_query; 
			// echo "<br>";
			if (!$result){
				 echo "DAY Database query failed for day query";
				 	echo "<br>";
				return -1 ;		
			}else{
				return $result; 
			}
		}else{
			$the_query = sprintf("SELECT %s,%s FROM %s WHERE timeslot BETWEEN  1  AND 4",$departure,$destination,$given_route);
			$result  = mysqli_query($con,$the_query);

			echo "NIGHT QUERY ".$the_query; 
			echo "<br>";
			if (!$result){
				echo "NIGHT Database query failed for day query";
				echo "<br>";

				return -1 ;		
			}else{
				
				return $result; 
			}
		
		}
	
	}
	
//filters and gets relevant info from db
	function from_db($day,$hour,$route,$from,$to,$con,$hour,$min){
		/**
	Input----takes in the given time in 24 hour system and day, and place to go from 
	, to get to , and the route + the db connection  
	Output --- cuts out irrelevant information and turns the db arrays to php arrays .
		    ----returns an array that contains "tuples" of start and finish times 
		 
	**/
	//----------------perrson hall is visited twice in every path so if we find that frank is at 
	//the from position then we pull out perrson_b else we'll pull out perrson_a column and the opposite 
	// echo "OK----------------------";
	// echo "<br>";
		if ($to == "Perrson_Hall"){
			switch ($from){
			
				case "Frank_Dining_Hall":
					$to = "Perrson_Hall_b";
					break ;
				default:
					$to = "Perrson_Hall_a";
			}
		}
		if($from == "Perrson_Hall"){#if we are trying to go from person to frank then we need to use the a(earlier) col
			switch ($to){
				case "Frank_Dining_Hall":
					$from = "Perrson_Hall_a";
					break ;
				default:
					$from = "Perrson_Hall_b";
			}
		}
		//first we check if it is between 11pm -12:59 am if not we just need one query else we need two
		//one for the 11pm -12:59am range and the other from 1:00am to 4am. also note that past midnight 
		//queries are allowed only for days Wen- Sat inclusive 
		
		if ( ($hour < 23 ) && ( $hour >= 4 )){

			$times = db_query($from,$to,$hour,$min,$route,$con,False);
			if ($times != -1 ){//aka we were able to get data from the db
				$ret_handler = array();
				array_push($ret_handler,$times,NULL);

			}else{
				$ret_handler = array();
				array_push($ret_handler,NULL,NULL);

			}
		}else{// now we are dealing with midnight business 

				
			if ( (2 < $day ) && ($day < 7)){//we first check if we are between W-Sat 
				echo "<br>";
				echo "I SOULDN'T BE SEEING THIS MESSAGE";
				echo "<br>";
				$times1 = db_query($from,$to,$hour,$min,$route,$con,False);
				$times2 = db_query($from,$to,1,NULL,$route,$con,True);
				if ( ($times1 != -1)  && ($times2 != -1)){//both pre and post midnight queries are successful
						$ret_handler = array();
						echo "WTFFFFFFFFFFFFFFFFFFFFFFF1";
						echo "<br>";
						array_push($ret_handler,$times1,$times2);

					}
					elseif ($times1 != -1 ){//aka we were able to get data from the db --pre midnight
						$ret_handler = array();
						array_push($ret_handler,$times1,NULL);
											echo "WTFFFFFFFFFFFFFFFFFFFFFFF2";
						echo "<br>";

					}
					elseif ($times2 != -1 ){//aka we were able to get data from the db --post midnight 
						$ret_handler = array();
						array_push($ret_handler,NULL,$times2);
											echo "WTFFFFFFFFFFFFFFFFFFFFFFF3";
						echo "<br>";

					}
				
			}else{//we are not in the range of W-Sat and hence no cruisers run past midnight 
			//so if its currently pre midnight and there is a cruiser that starts pre midnight and stops pre midnight or almost after
			//use the that.
								// if ( ($hour >= 23)){
									if(($hour == 23) ) {
									
										$times = db_query($from,$to,$hour,$min,$route,$con,False);
										if ($times != -1 ){//aka we were able to get data from the db
											$ret_handler = array();
											array_push($ret_handler,$times,NULL);

										}else{
											$ret_handler = array();
											array_push($ret_handler,NULL,NULL);
										}
									}else{
										 $times = db_query($from,$to,6,5,$route,$con,False);
										// echo "<br>";
										// echo "THIS SHOULD BE GETTING HIT";
										// echo "<br>";
										
										if ($times != -1 ){//aka we were able to get data from the db
										
											$ret_handler = array();
											array_push($ret_handler,$times,NULL);

										}else{
											$ret_handler = array();
											array_push($ret_handler,NULL,NULL);
										}
									}
				}
			}
		
		////=========================>cuts out irrelevant information and turns the db arrays to php arrays 
		// =================================================================================================
		// =================================================================================================
		// =================================================================================================
		// =================================================================================================
		// =================================================================================================
		
		$hour = (string)$hour;
		$min = (string )$min;

		 $current_time = $hour.":".$min; 
		 $tset1 = $ret_handler[0];//results from every other query during 24 hours 
		 $tset2 = $ret_handler[1];//results from  11pm - 12:59am 
		 
		 $clean_times = array();/// THIS WILL Be the array containing all of our times will be 

		 if ($tset1 != NULL){//meaning we have now rows of time tuples(start/finish)---each row is a "tuple"
			// echo "yyyyyyyyyyyyyyyyyyyyyyyyyyyyyy";
			echo "<br>";
			while ( $start_finish = mysqli_fetch_row($tset1)){
				$start_time =  $start_finish[0];
				$finish_time =  $start_finish[1];
				// echo $start_time."++++++".$current_time;
					// echo "<br>";		
				//we check if they are null or if the start time < current time if so we skip 
				if ( ($start_time != NULL ) && t1_vs_t2($start_time,$current_time) || ($current_time == 24)){
					$sf = array();
					// echo $start_time."++++++".$finish_time;
					// echo "<br>";		

					array_push($sf,$start_time,$finish_time);
					array_push($clean_times,$sf);
				}
				elseif( ($start_time == NULL)  && ($finish_time != NULL)) {
					$sf = array();
					echo $start_time."----".$finish_time;
					echo "<br>";
					array_push($sf,$start_time,$finish_time);
					array_push($clean_times,$sf);						
				}
				else{
					continue; 
				}
			}
		 }
		 //----------------------------------
		 if ($tset2 != NULL){//test2 times are all ahead of their time because the only time we make this query is when we are 
				// in the 11pm till 12:59am range as our current time , but the our list $test2 contains times after 1am
				while($start_finish = mysqli_fetch_row($tset2) ){
					$start_time =  $start_finish[0];
					$finish_time =  $start_finish[1];
	
					if ( ($start_time != NULL ) || ( $finish_time != NULL) ){//check if both of them are not null at the same time 
						$sf = array();
						// echo $start_time."----".$finish_time;
						// echo "<br>";
						array_push($sf,$start_time,$finish_time);
						array_push($clean_times,$sf);			
					}
				}
		 }
		 $len_arr = count($clean_times);
		 // // echo $len_arr;
		 // echo "<br>";
		 // for ( $itr = 0; $itr < $len_arr ; $itr ++){
			// $start = $clean_times[$itr][0];
			// $finish = $clean_times[$itr][1];
			// echo "START:: ".$start." FINISH:: ".$finish;
			// echo "<br>";
		 // }
		
		return $clean_times;
		
		
	}
	


	function best_time($time_sets){

	/**
		given an array of times figures out the next best time if there is none returns the string NO PATH
	**/

		$len_arr = count($time_sets) ;
		$best_times = array();
		if($len_arr == 0){//if we don't get any results from the cleaned array of start/finish times 
			return "NO PATH";
		}

		for ( $itr = 0 ; $itr < $len_arr; $itr++){

				$start = $time_sets[$itr][0];
				$finish = $time_sets[$itr][1];
				$final = False ;
				
				if ($itr <= ($len_arr - 2) ){//check if we are at the final set of start/finish times 
					$start_next = $time_sets[($itr+1)][0];//the next start time
					$finish_next = $time_sets[($itr+1)][1];//the next finish time
				}else{//if we are the final sets of times then the next set(star/finish) will be NULL/NULL
					$start_next = NULL;
					$finish_next = NULL;
				}
				//now we check for a possible set of accepted times and if we find we return it 
					// echo "---------".$start."+++++".$finish_next; 
					// echo "<br>";
				// echo "START: ".$start." FINISH ".$finish;
				// echo "<br>";
				// echo "START-NEXT: ".$start_next." FINISH-NEXT ".$finish_next;
				// echo "<br>";
				
				//perfect scenario when the first time set includes both start/finish times not null and start < finish 
				if ($finish != NULL && $start != NULL){
					if ( t1_vs_t2($finish,$start)){
						echo "CASE 1";
						array_push($best_times,$start,$finish);
						return $best_times;
					}elseif ( ($start == 24 ) && ($finish  != 24 )){//check for the midnight scenario 
							
							array_push($best_times,$start,$finish);
							return $best_times;
						}
				}
				//situation where you can hop on the cruiser in the next hour and get to your destination in the same hour 
				//it is quite possible that you could jump on the cruiser now and do a trip PASS BY YOUR CURRENT DEPARTURE POING AGAIN 
				//and then proceed to your destination but that doesn't make much sense unless you like to ride the cruiser and is better
				//if you take the cruiser that next cruiser and gets to your destination and doge the situation where you will be in the 
				//cruiser for hours(possibly) ----aka you are taking advantage of the fact that you are moving in the same direction as the 
				// cruiser current 
				if ($finish_next != NULL && $start_next != NULL){
					if ( t1_vs_t2($finish_next,$start_next)){
						echo "CASE 2";
						array_push($best_times,$start_next,$finish_next);
						return $best_times;
					}elseif  ( ($start == 24 ) && ($finish  != 24 )){//check for the midnight scenario 
							
							array_push($best_times,$start_next,$finish_next);
							return $best_times;
						}
				}
				//scenario where the user needs to hop on the most recent cruiser and take a round trip to get the desired stop in an hour or so.
				//this might happen for 1) the cruiser does rounds and you are trying to in the opposite direction that the cruiser is going 
				//the cruiser doesn't go where you want it to at the current hour but will get there in the next hour
				// 2)the cruiser just doesn't go to your destination at within the current hour and you can hop on the current cruiser at your 
				//point of departure and get to your destination quicker than wait an "hour" because you are going against the cruiser current 
				// echo "--------->".$start."+++++>".$finish_next; 
				if ($finish_next != NULL && $start != NULL){
					if ( t1_vs_t2($finish_next,$start)){
						// echo "CASE 3 ---Fork ";
						if (!t_diff($finish_next,$start)){
							array_push($best_times,$start,$finish_next);
							return $best_times;
						}
					}elseif ($start == 24){//check for the midnight scenario 
							// echo "YOOOOOOOOOOOOOOOOOOOOOO";
							array_push($best_times,$start,$finish_next);
							return $best_times;
						}
					}
			}
		
		return "NO PATH";
	}

	
	function combine($departure,$destination,$hour = NULL,$min = NULL,$con){
		/**
		Takes in the the db connection point of departure/destination and time(if given by the user or will be
		current time by default )and  puts the best time/s(and their respective cruiser) 
		into a list format "Cruiser A will leave DEPARTURE at ----AM/PM and get to DESTINATION 
		at ---AM/PM 
		**/
		$time_info = getdate();//inquire the current date/time
		if ($hour == NULL  || $min == NULL  ){	
			$hour = $time_info['hours'];
			$min = $time_info['minutes'];
		}
		
		// //Artificial testing for time 
		 $hour = 24;
		 $min  = 10;
		 $day = 2;
		
		//now we have our user input hours or just the current time + the day of the week 
		// $day = (int) $time_info['wday'];
		$hour = (int) $hour;
		$min = (int) $min;
		
		//each array represents a range of days and each item in the string is the name of the  
		//possible route as seen in the db(each cruiser route is a table in the db)
		$m_f = "ca_mf cb_mf cc_mf cd_mf ce_w_s";
		$sun = "ca_sun cb_sun";
		$sat = "ca_sat cb_sat ce_w_s";
		//on a given day we select a set of possible routes
		$week_routes =  array($sun,$m_f,$m_f,$m_f,$m_f,$m_f,$sat);//matches the day with the set of cruisers one might use 
		$todays_cruisers = $week_routes[$day];//based on the given day we choose the set of possible cruiser related routes we can use
		$todays_cruisers = explode(' ',$todays_cruisers);//make  a list out of them 
		
		
		/** ---------------------------Now for some naming conversions (this will help to create the 
		final string/s with the format Cruiser A will leave DEPARTURE at ----AM/PM and get to DESTINATION 
		 at ---AM/PM ) 
		**/
		//NAME CONVERSTION FOR PLACES-----> give cleaned up user friendly version of the place names that were pulled from the db
		$for_user = array();
		$for_user["Frank_Dining_Hall"] = "Frank Dining Hall";
		$for_user["Gate_House"]= "Gate House";
		$for_user["Whitnall_Field"] = "Whitnall Field";
		$for_user["Newell_Apartments"]= "Newell Apartments ";
		$for_user["Newell_Apartments"] = "University Ct./Burch";
		$for_user["110_Broad_St"] = "110 Broad St.";
		$for_user["Kendrick_and_Broad"] = "Kendrick &amp; Broad ";
		$for_user["Cutten_Hall"] = "Cutten Hall";
		$for_user["Townhouses"] = "Townhouses";
		$for_user["Bookstore"] = "Bookstore";
		$for_user["SOMAC"] =  "SOMAC";
		$for_user["Hamilton_Airport"] = "Hamilton Airport";
		$for_user["Parrys_Plaza"] = "Parry&#39;s Plaza";
		$for_user["Price_Chopper"] = "Price Chopper";
		$for_user["Village_Green"] = "Village Green ";
		$for_user["Parker_Apartments"] = "Parker Apartments";
		$for_user["Case_Geyer_Library"] = "Case-Geyer Library";
		//NAME CONVERSTION FOR PLACES-----> give cleaned up user friendly version of the  cruiser names
		// that correspond to the database route names
		$route_to_cruiser_name["ca_mf"]="Cruiser A"; $route_to_cruiser_name["cb_mf"]="Cruiser B"; 
		$route_to_cruiser_name["cc_mf"]="Cruiser C"; $route_to_cruiser_name["cd_mf"]="Cruiser D";
		$route_to_cruiser_name["ca_sun"]="Cruiser A"; $route_to_cruiser_name["cb_sun"]="Cruiser B";
		$route_to_cruiser_name["ca_sat"]="Cruiser A"; $route_to_cruiser_name["cb_sat"]="Cruiser B";
		$route_to_cruiser_name["ce_w_s"]="Cruiser E";
		
		//now we iterate through the routes(that pertain to the current day) perform the 
		//use the functions defined earlier to find the best start/stop times and 
		
		$genie = array(); //THIS IS WHERE THE STRINGS TELLING THE USER WHAT DO WILL BE STORED. THE MAGIC
		
		foreach ($todays_cruisers as $a_route){
					// echo $a_route." *************************************************************************************";
				// echo "<br>";
			//First we query the db appropriately and get the results back 
			$data = from_db($day,$hour,$a_route,$departure,$destination,$con,$hour,$min);
			$show_me_how = best_time($data);
			if ( $show_me_how == "NO PATH"){//then this cruiser can't get us where we want 
				continue ;
			}else{

				$time_of_departure = $show_me_how[0];
				$time_of_arrival = $show_me_how[1];
				$ans = $route_to_cruiser_name[$a_route]." will leave ".$for_user[$departure]." at ".standard_time($time_of_departure)." and
				get to ".$for_user[$destination]." at ".standard_time($time_of_arrival);		
				
				// $ans = $route_to_cruiser_name[$a_route]." will leave ".$for_user[$departure]." at ".$time_of_departure." and
				// get to ".$for_user[$destination]." at ".$time_of_arrival;
				array_push($genie,$ans);
				
			}	
		}
		return $genie ;
	}
	
	
	//NOW LETS GET THE DB CONNNECTION,DEPARTURE,DESTIATION POINTS 
	//THIS COULD ALSO BE THE POINT WHERE YOU GET TIME INPUT FROM THE USER
	$FROM =  $_GET["from"];
	$TO = $_GET["to"];
	
	//the db connection will be there (because this will be used as an include )
	$list_of_results = combine($FROM,$TO,NULL,NULL,$con);
	
	echo "<ul class=\"nav nav-pills\">";
		if ( count($list_of_results) == 0 ){
			echo "<li><a href=\"#\">"." THERE IS NO CRUISER THAT CAN GET YOU TO YOUR DESTINATION FROM YOUR POINT OF DEPARTURE AT THIS POINT "."</a></li>";
		}
		foreach ($list_of_results as $answer){	
			echo "<li><a href=\"#\">".$answer."</a></li>";
		}
	
	echo "</ul>";

	mysqli_close($con);
 ?>

	</section>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/less.js" type="text/javascript"></script>
  </body>
</html>