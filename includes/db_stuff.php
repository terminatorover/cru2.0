<?php 
$con = mysqli_connect("localhost","robera","password","cruiser_app"); //try to connect
//check if the connection has worked 
if ( mysqli_connect_errno()){
 echo "Failed to connect".mysqli_connect_error();
}
//create a table 


$places = ["Perrson_Hall_a","Perrson_Hall_b","Frank Dining Hall","Gate House","Whitnall Field","Newell Apartments","University Ct Burch","110 Broad St","Kendrick and Broad","Cutten Hall","Townhouses","Bookstore","SOMAC","Hamilton Airport","Parrys Plaza","Price Chopper","Village Green","104_Broad_St","Academic_Dr","Parker_Apartments","Case_Geyer_Library"];
$sql =  "CREATE TABLE ce_w_s  ( timeslot INT NOT NULL AUTO_INCREMENT,Dummy TINYINT(1)";
 foreach ($places as $place){
	// echo "{$place} TINYINT(1)"; 
	// $place = htmlentities($place);
	// $place = mysqli_real_escape_string($con,$place);


	$place = str_replace(" ","_",$place);
	echo $place;

	
	$place =  mysqli_real_escape_string($con, $place);
	// echo $place;
	$sql .= ", {$place}  VARCHAR(20)";
	
	?>
	<br>
<?php } $sql .= ",PRIMARY KEY(timeslot) )"; echo $sql ;?>

 <?php 
 
  if (mysqli_query($con,$sql))
    {
    echo "Table  ce_w_s  	 created successfully";
  
   }
  else
    {
    echo "Error creating table: ". mysqli_error($con);
    }
 ?>










<?php mysqli_close($con);?>