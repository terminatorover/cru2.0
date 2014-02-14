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
	 <!-- Google analytics -->
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
	<!-- <div id="full-screen"></div>-->
	<div id="full-screen"></div>
	<section class="row">
	
	<h1 class="col-xs-8 col-xs-offset-2" style="font-family: 'Graduate', cursive; color:rgb(148, 13, 56); font-weight:900; text-align:center;
top: -1px; " >GATE CRUISER</h2>
	</section>
	
	<div class="row">
	<section class="col-sm-5 col-sm-offset-4 " style=" opacity: .9; /* background-color: rgb(62, 111, 69); */ color: black; background-color: rgba(7, 22, 27, 0.91);  ">
		<?php 
error_reporting(E_ERROR);
	// $hostname = null;
	// $username = "root";
	// $password = "";
	// $database = "cruiser_app";
	// $port = null;
	// $socket = "/cloudsql/colgate-cruiser:get-cru5";
	
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

  function ans_format($cruiser,$departure_place,$arrival_place,$departure_time,$arrival_time){
  /**
  takes in the parameters and outputs the string that will be displayed to the user in a nice format(which we can modify here )
  **/

  return $cruiser." will leave ".$$departure_place." at ".standard_time($departure_time)." and
				get to ".$arrival_place." at ".standard_time($arrival_time);		
  }
  
  
  function compare( $tset1, $tset2){
  /**
//takes in a "data structure" just a (route/start-finish time) .
  //takes two of these and returns true if the first one is better than the second one 
  **/
  
	$start1 = $tset1[3];
	$finish1 = $tset1[4];
  
    $start2 = $tset2[3];
    $finish2 = $tset2[4];
	echo "START 1-->".$start1." --------"."FINSIH 1--->".$finish1;
	echo "<br>";	
	echo "START 2-->".$start2." --------"."FINSIH 2--->".$finish2;
	
	// /first check if the finish times are different and the one with the earlier finish time is better 
	if ( !is_null(t1_vs_t2($finish2,$finish1)) && (t1_vs_t2($finish2,$finish1) == True ) ){
		echo "FIRT ONE IS BETTER";
		echo "<br>";
		return True;
	}elseif ( !is_null(t1_vs_t2($finish2,$finish1)) && (t1_vs_t2($finish2,$finish1) == False ) ){
			echo "SECOND ONE IS BETTER";
		echo "<br>";
		return False;
	}	
	// /second check if the start times are different and the one with the later the start time the better the total time-set is  

	if ( !is_null(t1_vs_t2($start1,$start2)) && (t1_vs_t2($start1,$start2) == True ) ){
			echo "FIRT ONE IS BETTER";
		echo "<br>";
		return True;
	}elseif ( !is_null(t1_vs_t2($start1,$start2)) && (t1_vs_t2($start1,$start2) == False ) ){
			echo "SECOND ONE IS BETTER";
		echo "<br>";
		return False;
	}
	
  }

  //MERGE STEP
  function merge_step( $arr1, $arr2){
  /**
  merge step essential for the mergesort 
  **/
  $res = array();
  $ind1 = 0 ;
  $ind2 = 0;
  $len_a1 = count( $arr1);
  $len_a2 = count( $arr2);
	while( ($ind1 < $len_a1 )  && ($ind2 < $len_a2 )) {
		$item_a = $arr1[$ind1];
		$item_b = $arr2[$ind2];
		if (compare( $item_a, $item_b )){
			array_push($res, $item_a);
			$ind1 ++ ;
		}else{
			array_push($res, $item_b);
			$ind2 ++ ;
		}
  
	}

   for ( ; $ind1 < $len_a1 ; $ind1 ++){
	$item = $arr1[$ind1];
	array_push($res,$item );
   }
   for ( ; $ind2 < $len_a2 ; $ind2 ++){
   $item = $arr2[$ind2];
	array_push($res,$item );
   }
   
   return $res; 
  }
 
function merge( $list_of_time_sets){
/***
	recursive implementation of merge sort 
**/
	$len_arr = count($list_of_time_sets);
	if ($len_arr == 1){
		return  $list_of_time_sets;
	}else{
		$first_half = array_slice( $list_of_time_sets, 0, $len_arr/2);
		$second_half = array_slice( $list_of_time_sets, $len_arr/2);
		return merge_step( merge( $first_half), merge( $second_half));
		
	}
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
			// echo "<br>";
			// echo "TRUE ";
			// echo "<br>";
			return True;
		}elseif((( $t1h-$t2h) == 1 ) )  {
			$until = 60 - $t2m ;
			$to = $t1m ;
			$total_min_diff = $until + $to ; 
			// echo "TOTAL TIME ".$total_min_diff;
			if ($total_min_diff > 61){
			// echo "<br>";
			// echo "TRUE ";
			// echo "<br>";
				return True ;
			}else{
				// echo "<br>";
			// echo "FALSE ";
			// echo "<br>";
			return False;
			}
			
		}else{
		// echo "<br>";
			// echo "FALSE ";
			// echo "<br>";
			return False;
		
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
				elseif ($t2m > $t1m){return False;}
				else{
					return NULL;
				}
			}
		
	}
	
	//helper function, to check if a given time is between two sets of times 
	function between($input_time, $before_side,$after_side){
	/**
	returns true if the inputed time is between the twyo given times 
	**/
		// echo "INPUT TIME ---->".$input_time."[[[[".$before_side."--------".$after_side."]]]]]";
		// echo "<br>";
		if (is_null($input_time)){
			// echo "give me null";
			// echo "<br>";
			return False; 
		}
		if (t1_vs_t2($input_time,$before_side) && t1_vs_t2($after_side,$input_time)){
			echo "GOT ONE ";
			echo "<br>";
			return True; 
		}else{
			// echo 
			echo "<br>";
			return False;
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

//function for handling the quirks of the non coherent schedule

function  exceptor($start,$finish,$exceptions,$route){
/**this takes in the "cleaned time array and then a list of exceptions in a dictionary format
[ $route as the key  and  the value of that key is the list containing [(start-times range) ],[(end times range )]]
for the route being considered we look it up in the exceptions array and FOR NOW WE GET THE 1 set of star/finish ranges 
BUT we will later make this iterating through the list and of start/finish ranges and then if we enocuter an error we return False 
and if we go through all non allowed result mappings then we just return True at the end of the function 

start-time range format will be a tuple containing strings ("12:30","1:30")
end-time range format will be a tuple containing strings ("12:30","1:30")

the idea is for the given $route we use the exceptions dictionary to look up the exceptions and we iterate 
through them and check if the current best times provided by the best time function is misleading since its in 
the exceptions time range
**/		
		$route = trim($route);

		$exceptions_list = $exceptions[$route];
		// var_dump($exceptions_list);
		foreach ($exceptions_list as $exception){
								// echo "START ".$start." -------------------- "."FINISH".$finish;

						// var_dump($exception);
						$non_allowed_start = $exception[0];
						$non_allowed_finish = $exception[1];
						// var_dump($not_allowed_start);
						$non_allowed_start_a = $non_allowed_start[0];
						$non_allowed_start_b = $non_allowed_start[1];
						
						$non_allowed_finish_a = $non_allowed_finish[0];
						$non_allowed_finish_b = $non_allowed_finish[1];
						// echo "range 1 ===>".$non_allowed_start_a."range2 ===>".$non_allowed_start_b;
						// echo "<br>";
						if (between($start,$non_allowed_start_a,$non_allowed_start_b) && between($finish,$non_allowed_finish_a,$non_allowed_finish_b) ){//now we say, hey if the given start time is in the range of not allowed times then don't include it in the list of possible choices 
							// echo "SKIPPED START --->".$start;
							// echo "<br>";
							return False ;#this means we failed aka the answer that best times was going to submit to the user is wrong (since it is within the not allowed range)so try again besttimes
						}
						
					
		}

					
		return True;
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
		// echo "ROUTE ".$given_route;
		
		if ((!$mid_night) == True ){
			
			$the_query = sprintf("SELECT %s,%s FROM %s WHERE timeslot > %s ",$departure,$destination,$given_route,(string)($ts -1));//ts is for timeslot
			$result  = mysqli_query($con,$the_query);
			// echo "DAY QUERY ".$the_query; 
			// echo "<br>";			echo "DAY QUERY ".$the_query; 
			// echo "<br>";
			if (!$result){
				 // echo "DAY Database query failed for day query";
				 	// echo "<br>";
				return -1 ;		
			}else{
				return $result; 
			}
		}else{
			$the_query = sprintf("SELECT %s,%s FROM %s WHERE timeslot BETWEEN  1  AND 4",$departure,$destination,$given_route);
			$result  = mysqli_query($con,$the_query);

			// echo "NIGHT QUERY ".$the_query; 
			// echo "<br>";	
			if (!$result){
				// echo "NIGHT Database query failed for day query";
				// echo "<br>";

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
		if ( ($hour < 23 ) && ( $hour >= 4 )){//these are nice hours 
			
			$times = db_query($from,$to,$hour,$min,$route,$con,False);
			if ($times != -1 ){//aka we were able to get data from the db
				$ret_handler = array();
				array_push($ret_handler,$times,NULL);

			}else{
				$ret_handler = array();
				array_push($ret_handler,NULL,NULL);

			}
		}else{// now we are dealing with midnight business 

				
			if ( (3 < $day ) && ($day < 7)){//we first check if we are between W-Sat 
				// echo "<br>";
				// echo "I SOULDN'T BE SEEING THIS MESSAGE";
				// F
				$times1 = db_query($from,$to,$hour,$min,$route,$con,False);
				$times2 = db_query($from,$to,1,NULL,$route,$con,True);
				if ( ($times1 != -1)  && ($times2 != -1)){//both pre and post midnight queries are successful
						$ret_handler = array();
						// // echo "WTFFFFFFFFFFFFFFFFFFFFFFF1";
						// echo "<br>";
						array_push($ret_handler,$times1,$times2);

					}
					elseif ($times1 != -1 ){//aka we were able to get data from the db --pre midnight
						$ret_handler = array();
						array_push($ret_handler,$times1,NULL);
											// echo "WTFFFFFFFFFFFFFFFFFFFFFFF2";
						// echo "<br>";

					}
					elseif ($times2 != -1 ){//aka we were able to get data from the db --post midnight 
						$ret_handler = array();
						array_push($ret_handler,NULL,$times2);
											// echo "WTFFFFFFFFFFFFFFFFFFFFFFF3";
						// echo "<br>";

					}
				
			}else{//we are not in the range of Thur-Sat and hence no cruisers run past midnight 
			//so if its currently pre midnight and there is a cruiser that starts pre midnight and stops pre midnight or almost after
			//use the that.
								// if ( ($hour >= 23)){
									if(($hour == 23)  ) {
									// echo "I SHOULD BE SEEING THIS ";
										$times = db_query($from,$to,$hour,$min,$route,$con,False);
										if ($times != -1 ){//aka we were able to get data from the db
										// echo "GOT IT";
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
											// echo " I SHOULD Se ";
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
			// echo "<br>";
			while ( $start_finish = mysqli_fetch_row($tset1)){
				$start_time =  $start_finish[0];
				$finish_time =  $start_finish[1];
				// echo "<br>";
				// echo "<br>";
				// echo "start time".$start_time."++++--------++"."finish time".$finish_time;
				// echo "<br>";
				// echo "start time".$start_time."++++--------++"."current time".$current_time;
					// echo "<br>";		
				$curfew = array(0,1,2,3);
				//we check if they are null or if the start time < current time if so we skip 
				if ( (!is_null($start_time ) ) && (t1_vs_t2($start_time,$current_time) || (in_array($day,$curfew) && ($hour == 24)   ))){//notice the part after the or is the what is allowing us to get the answers 
				//to on our curfew days when our current hour (24 ) is > the coming hours example 7am and hence won't pass the start time < current time test 
					$sf = array();
					// echo $start_time."++++++".$finish_time;
					// echo "<br>";		
						array_push($sf,$start_time,$finish_time);
						array_push($clean_times,$sf);
					
				}
				elseif( is_null($start_time )   && !is_null($finish_time ) ) {
					$sf = array();
					// echo $start_time."----".$finish_time;
					// echo "<br>";
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
		 // echo $len_arr;
		 // echo "<br>";
		 	 for ( $itr = 0; $itr < $len_arr ; $itr ++){
			$start = $clean_times[$itr][0];
			$finish = $clean_times[$itr][1];
			// echo "<br>";
			// echo "START:: ".$start." FINISH:: ".$finish;
			// echo "<br>";
		 }


		return $clean_times;
		
		
	}
	


	function best_time($time_sets,$route){

	/**
		given an array of times figures out the next best time if there is none returns the string NO PATH
		---->THE TOP OF THIS FUNCTION WILL CONTAIN ALL THE EXCEPTIONS !! very easy for anyone to do 
	**/
	
		
	$exceptions = array();
							
	$exceptions["ca_mf"] = [[["16:00","17:51"],["17:59","19:00"]] , [["10:38","11:26"],["11:27","11:53"]]];
	$exceptions["cb_mf"] = [[["16:00","17:51"],["17:59","19:00"]] ,[["10:38","11:26"],["11:27","11:53"]] ];

		$len_arr = count($time_sets) ;
		$best_times = array();
		if($len_arr == 0){//if we don't get any results from the cleaned array of start/finish times 
			return "NO PATH";
		}

		for ( $itr = 0 ; $itr < $len_arr; $itr++){

				$start = $time_sets[$itr][0];
				$finish = $time_sets[$itr][1];
				//get the start/finish hours 
				$start_d = explode(":",$start );
				$finish_d = explode(":",$finish );
				$start_h= (int) $start_d[0];
				$finish_h= (int) $finish_d[0];
				
				$final = False ;
				
				if ($itr <= ($len_arr - 2) ){//check if we are at the final set of start/finish times 
					$start_next = $time_sets[($itr+1)][0];//the next start time
					$finish_next = $time_sets[($itr+1)][1];//the next finish time
					//get the start_next/finish_next hours 
					// echo "ASGADDDDDDDDDDDDDDDDDDDDDDDDDD";
					// echo "<br>";
					$start_next_d = explode(":",$start_next );
					$finish_next_d = explode(":",$finish_next );
					$start_next_h= (int) $start_next_d[0];
					$finish_next_h= (int) $finish_next_d[0];
					
				}else{//if we are the final sets of times then the next set(star/finish) will be NULL/NULL
					$start_next = NULL;
					$finish_next = NULL;
				}
				//now we check for a possible set of accepted times and if we find we return it 
					// echo "---------".$start."+++++".$finish_next; 
					// // echo "<br>";
				// echo "START: ".$start." FINISH ".$finish;
				// echo "<br>";
				// echo "START-NEXT: ".$start_next." FINISH-NEXT ".$finish_next;
				// echo "<br>";
				// echo "===========================";
				// echo "<br>";
				
				
				//perfect scenario when the first time set includes both start/finish times not null and start < finish 
				if ($finish != NULL && $start != NULL){
			
					if ( t1_vs_t2($finish,$start)){
						// echo "CASE 1";
						// echo "<br>";
						if (!t_diff($finish,$start)){
						array_push($best_times,$start,$finish);
						return $best_times;
						}
					}elseif ( ($start_d == 24 ) && ($finish_d  != 24 )){//check for the midnight scenario 							
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
					// echo "SHOULDN't GET HIT";
					// echo "<br>";
					
					if ( t1_vs_t2($finish_next,$start_next)){
						// echo "CASE 2";
						// echo "start_next ".$start_next."===============>".$finish_next;
						if (!t_diff($finish_next,$start_next)){
						array_push($best_times,$start_next,$finish_next);
						return $best_times;
						}
					}elseif  ( ($start_next_h == 24 ) && ($finish_next_h != 24 )){//check for the midnight scenario 
							// echo "HERE";
							// echo "<br>";
														// echo "start_next ".$start_next."===============>".$finish_next;

				// echo "<br>";
			
						
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
				// echo "<br>";
							// echo "START2: ".$start." FINISH-NEXT2: ".$finish_next;
				// echo "<br>";		
					
					if ( t1_vs_t2($finish_next,$start)){
							 // echo "CASE 3 ---Fork ";
							 // echo "<br>";
						if (!t_diff($finish_next,$start)){
						// echo "OKAY";
						// echo "start_d".$start_d;
						// echo "<br>";
						// echo "START3: ".$start." FINISH-NEXT3: ".$finish_next;
				// echo "<br>";
							
							// echo "MY DEAR BOY ";
							// echo "<br>";
							if(exceptor($start,$finish_next,$exceptions,$route)){
								array_push($best_times,$start,$finish_next);
								return $best_times;
							}
							
							
						}
					}elseif ($start_h == 24){//check for the midnight scenario 
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
		date_default_timezone_set("America/New_York");
		$time_info = getdate();//inquire the current date/time
		if ($hour == NULL  || $min == NULL  ){	
			$hour = $time_info['hours'];
			$min = $time_info['minutes'];
		}
		// &&&
		
		// //Artificial testing for time 
		 $hour = 6;
		 $min  = 17;
		  // $day = 1;	
		  
		 //REAL TIME 
		  	$day = (int) $time_info['wday'];
		// $hour = (int) $hour;	
		// $min = (int) $min;
		
		
		// echo $hour ;
		if(is_numeric ($hour)){
		// echo "OHHHHHHHHHHHHHHHHHHH";
		}
			if ($hour == 0){
			// echo "WTF";
				$hour = 24;
			}
			
		/////=====================================================================> TREAT AS <========================================================================
		// because of the way the schedule is setup Sat 1am-4am is still Friday 
		//and sunday 1am-4am is still saturuday 
		if ($day == 6 && (( $hour < 3 ) || ( $hour == 24 ) )){//namely if its Saturday midnight -4am, then use the Friday schedule 
			$day = 5;
		
		}
		
		if ($day == 0 && (( $hour < 4 ) || ( $hour == 24 ) )) {//namely if its Sunday  midnight-4am, then use the Saturday schedule 
			$day = 6;
		
		}
		
		// now we have our user input hours or just the current time + the day of the week 
	
		
				// echo "HOUR ".$hour;
			// echo "<br>";
			// echo "DAY ".$day;
			// echo "<br>";
		// echo "MINUTE ".$minute;
		// echo "<br>";
		//each array represents a range of days and each item in the string is the name of the  
		//possible route as seen in the db(each cruiser route is a table in the db)
		// $m_f = "ca_mf cb_mf cc_mf cd_mf ce_w_s";
		
		$m_t = "ca_mf cb_mf cc_mf cd_mf";
		$w_f = "ca_mf cb_mf cc_mf cd_mf ce_w_s";
		$sun = "ca_sun cb_sun";
		$sat = "ca_sat cb_sat ce_w_s";
		//on a given day we select a set of possible routes
		$week_routes =  array($sun,$m_t,$m_t,$w_f,$w_f,$w_f,$sat);//matches the day with the set of cruisers one might use 
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
		$for_user["110_Broad_St"] = "110 Broad St.";
		$for_user["104_Broad_St"] = "104 Broad St.";
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
		$for_user["Perrson_Hall"] = "Perrson Hall";
		$for_user["University_Ct_Burch"] = "University Ct./Burch";
		

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
		$genie2  = array (); //stores the suggested set of optimal start/stop times (this is queuing them for sorting )
		foreach ($todays_cruisers as $a_route){
		// echo "<br>";
					echo "----------".$a_route." *************************************************************************************";
				echo "<br>";
			//First we query the db appropriately and get the results back 
			$data = from_db($day,$hour,$a_route,$departure,$destination,$con,$hour,$min);
			$show_me_how = best_time($data,$a_route);
			if ( $show_me_how == "NO PATH"){//then this cruiser can't get us where we want 
				continue ;
			}else{

				$time_of_departure = $show_me_how[0];
				$time_of_arrival = $show_me_how[1];
				// echo $time_of_arrival."000000000000000000000000000".$time_of_departure;
				// echo "<br>";
				//This check is for the quirky situation on M/T at 11pm-12am range when we can't use the bus if our 
				//arrival time (at destination )is after 12am 
				if (( ( $day < 3) &&( $day > 0))  && t1_vs_t2($time_of_arrival,"23:59")){
					// echo "WF";
						continue ;
				}
				//this is for another quirky situation on m/f cruiser stop running around 5:30 and start back up again at 6 so 
				//since the time difference between these two is < an hour the t_diff won't pick up on the fact that you can't 
				//actually hop on a cruiser after 5pm and get droped off if you "get" to your dest on and after 6pm 
				
				// if ( ( $day > 0) &&( $day  < 6 )  && (t1_vs_t2($time_of_arrival,"17:59") && (($hour == 17 ) || ($hour == 16)) ) ){
					// continue ;
					
				// }
				
				$ans = $route_to_cruiser_name[$a_route]." will leave ".$for_user[$departure]." at ".standard_time($time_of_departure)." and
				get to ".$for_user[$destination]." at ".standard_time($time_of_arrival);		
				// echo $ans;	
				// $ans = $route_to_cruiser_name[$a_route]." will leave ".$for_user[$departure]." at ".$time_of_departure." and
				// get to ".$for_user[$destination]." at ".$time_of_arrival;
				array_push($genie,$ans);
				$t_set = array();
				//now we construct a "data structure" that holds the cruiser name,point of departure, arrival and time of departure, arrival 
				array_push($t_set,$route_to_cruiser_name[$a_route],$for_user[$departure],$for_user[$destination],$time_of_departure,$time_of_arrival );
				// var_dump($t_set);
				array_push($genie2,$t_set);
			}	
		}
		// var_dump($genie2);
		$genie = merge( $genie2);
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
			echo "<li><a href=\"#\">".ans_format($answer[0],$answer[1],$answer[2],$answer[3],$answer[4])."</a></li>";
		}
	
	echo "</ul>";

	mysqli_close($con);
 ?>
	<form action="index_copy.php" action="get" >
		<div class="row">
				<button type="submit"  class="btn btn-danger  col-xs-6 col-xs-offset-3" style ="margin-top:3em; font-family: 'Graduate', cursive;" >BACK</button>
		</div>
	</form>

	</section>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/less.js" type="text/javascript"></script>
	
  </body>
</html>