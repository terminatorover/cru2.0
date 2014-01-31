<?php 

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
	function db_query($departure,$destination,$hour,$given_route,$con,$mid_night){
	/**
	input will be the point of departure and destination,given hour and route + db connection 
	return will be a php raw handle 
	**/
		if (mid_night != True ){
		
			$the_query = sprintf("SELECT %s,%s FROM %s WHERE timeslot > %s ",$departure,$destination,$given_route,(string)($hour -1));
			$result  = mysqli_query($con,$the_query);
			if (!$result){
				// echo "Database query failed for day query";
				return -1 ;		
			}else{
				return $result; 
			}
		}else{
			$the_query = sprintf("SELECT %s,%s FROM %s WHERE timeslot BETWEEN  1  AND 4",$departure,$destination,$given_route);
			$result  = mysqli_query($con,$the_query);
			if (!$result){
				// echo "Database query failed for day query";
				return -1 ;		
			}else{
				return $result; 
			}
		
		}
	
	}
	
//filters and gets relevant info from db
	function from_db($day,$hour,$min,$route,$from,$to,$con){
		/**
	Input----takes in the given time in 24 hour system and day, and place to go from 
	, to get to , and the route + the db connection  
	Output --- returns a list of upto 2 php row handles depends if there is a request close to 
	(11pm or within the midnight hour). else we just get one handle 
	-----Note that we could return NULL,NULL if we don't get anything back(aka we can't establish db connection)
	*/
	//----------------perrson hall is visited twice in every path so if we find that frank is at 
	//the from position then we pull out perrson_b else we'll pull out perrson_a column and the opposite 
		if ($to == "Perrson_Hall"){
			switch ($from){
			
				case "Frank_Dining_Hall":
					$to = "Perrson_Hall_b";
				break 
				default:
					$to = "Perrson_Hall_a";
			}
		}
		if($from == "Perrson_Hall"){#if we are trying to go from person to frank then we need to use the a(earlier) col
			switch ($to){
				case "Frank_Dining_Hall":
					$from = "Perrson_Hall_a";
				break 
				default:
					$from = "Perrson_Hall_b";
			}
		}
		
		//first we check if it is between 11pm -12:59 am if not we just need one query else we need two
		//one for the 11pm -12:59am range and the other from 1:00am to 4am. also note that past midnight 
		//queries are allowed only for days Wen- Sat inclusive 
		if ( $hour < 23){
			$times = db_query($from,$to,$hour,$route,$con,False);
			if ($times != -1 ){//aka we were able to get data from the db
				$ret_handler = array();
				array_push($ret_handler,$times,NULL);
				return $res_handler;
			}else{
				$ret_handler = array();
				array_push($ret_handler,NULL,NULL);
				return $res_handler;
			}
		}else{// now we are dealing with midnight business 
			if ( (2 < $day )&& ($day < 7)){//we first check if we are between W-Sat 
				$times1 = db_query($from,$to,$hour,$route,$con,False);
				$times2 = db_query($from,$to,1,$route,$con,True);
				if ( $times1 != -1 && $times2 != -1){//both pre and post midnight queries are successful
					$ret_handler = array();
					array_push($ret_handler,$times1,$times2);
					return $res_handler;
				}
				if ($times1 != -1 ){//aka we were able to get data from the db --pre midnight
					$ret_handler = array();
					array_push($ret_handler,$times1,NULL);
					return $res_handler;
				}
				if ($times2 != -1 ){//aka we were able to get data from the db --post midnight 
					$ret_handler = array();
					array_push($ret_handler,NULL,$times2);
					return $res_handler;
				}
				
			}else{//we are not in the range of W-Sat and hence no cruisers run past midnight so just one query for us
				$times = db_query($from,$to,$hour,$route,$con,False);
				if ($times != -1 ){//aka we were able to get data from the db
					$ret_handler = array();
					array_push($ret_handler,$times,NULL);
					return $res_handler;
				}else{
					$ret_handler = array();
					array_push($ret_handler,NULL,NULL);
					return $res_handler;
				}
			}
		}
	}
	
	
		
	
//cuts out irrelevant information and turns the db arrays to php arrays 
 function lean_array($tset1_tset2,$hour = NULL,$min =NULL){
	if ($hour === NULL  || $min === NULL){
		$time_info = getdate();
		$hour = $time_info['hours'];
		$min = $time_info['minutes'];
		$day = $time_info['wday'];
	}
	 $current_time = $hour.":".$min; 

	 $tset1 = $tset1_tset2[0];//results from every other query during 24 hours 
	 $tset2 = $tset1_tset2[1];//results from  11pm - 12:59am 
	 
	 $clean_times = array();/// THIS WILL Be the array containing all of our times will be 
	 
	 
	 if ($tset1 != NULL){//meaning we have now rows of time tuples(start/finish)---each row is a "tuple"
		while ( $start_finish = mysqli_fetch_row($test1)){
			$start_time =  $start_finish[0];
			$finish_time =  $start_finish[1];
			//we check if they are null or if the start time < current time if so we skip 
			if ( ($start_time != NULL ) && t1_vs_t2($start_time,$current_time)){
				$sf = array();
				array_push($sf,$start_time,$finish_time);
				array_push($clean_times,$sf);
			}elseif( $finish_time != NULL) {
				$sf = array();
				array_push($sf,$start_time,$finish_time);
				array_push($clean_times,$sf);						
			}else{
				continue; 
			}
		}
	 }
	 //----------------------------------
	 if ($test2 != NULL){//test2 times are all ahead of their time because the only time we make this query is when we are 
			// in the 11pm till 12:59am range as our current time , but the our list $test2 contains times after 1am
			while($start_finish = mysqli_fetch_row($test1) ){
			
				$start_time =  $start_finish[0];
				$finish_time =  $start_finish[1];
				if ( ($start_time != NULL ) || ( $finish_time != NULL) ){//check if both of them are not null at the same time 
					$sf = array();
					array_push($sf,$start_time,$finish_time);
					array_push($clean_times,$sf);			
				}
			}
	 }
	
	return $clean_times;
 
 }





 ?>
