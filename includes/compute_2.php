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
	
	function db_query($departure,$destination,$hour,$given_route,$con){
	/**
	input will be the point of departure and destination,given hour and route + db connection 
	return will be a php raw handle 
	**/
		$the_query = sprintf("SELECT %s,%s FROM %s WHERE timeslot > %s ",$departure,$destination,$given_route,(string)($hour -1));
		$result  = mysqli_query($con,$the_query);
		if (!$result){
			// echo "Database query failed for day query";
			return -1 ;
			}
		}else{
			return $result; 
		}
	}
	
	function from_db($day,$hour,$min,$from,$to,$con){
		/**
	Input----takes in the given time in 24 hour system and day, and place to go from 
	and to get to + the db connection  
	Output --- returns a list of upto 2 php row handles depends if there is a request close to 
	(11pm or within the midnight hour). else we just get one handle 
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
		//one for the 11pm -12:59am range and the other from 1:00am to 4am
		if ( $hour)
		
	
	
	}
	
?>
