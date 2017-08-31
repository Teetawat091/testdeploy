<html>
<title>show information</title>
<meta charset="UTF-8">
<meta name="viewport" content="width = device-width, initial-scale = 1.0">
<body >
<iframe src="http://127.0.0.1/testgoogle/dootook.php"height="500" width="100%"frameborder="0"scrolling="auto"align="center">
</iframe>
</body>

<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "ogf";
$conn = mysqli_connect($server, $user, $pass, $db);
mysqli_set_charset($conn,"utf8");

$url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$_POST['or']."&destinations=".$_POST['en']."&key=AIzaSyBHlC_bwi0D_b86YE0ZN1hnymItuDb_5N0";

$json = file_get_contents($url);
$data = json_decode($json, TRUE);
$distance = $_POST['total'];
$dest = $data['destination_addresses'][0];
$origin = $data['origin_addresses'][0];
$dest_description;
if(isset($dest)==false){
	$dest_description = 1;

}
else{
	$dest_description = 0;
}

$datetime = $_POST['datetime'];
echo "Current Time : ".$datetime.'<br>';
$orlatlng = explode(',',$_POST['or']);
$endpos = explode(',',$_POST['en']);
$cost;
$rate;

echo "<pre>";
print_r($_POST['dyroute']);
echo "<pre>";

$steps = json_decode($_POST['dyroute'],TRUE);
$countstep =  count($steps);
//echo "all step : ".$countstep.'<br>';
//echo $steps[0]['distance']['text'];

$eachdistance = [];
$eachaction = [];
$eachstartlat = [];
$eachstartlng = [];
$eachendlat = [];
$eachendlng = [];


for($i=0;$i<$countstep;$i++){
	$eachdistance[$i]= $steps[$i]['distance']['text'];
	$eachaction[$i]= $steps[$i]['instructions'];
	$eachstartlat[$i] = $steps[$i]['start_location']['lat'];
	$eachstartlng[$i] =  $steps[$i]['start_location']['lng'];
	$eachendlat[$i] = $steps[$i]['end_location']['lat'];
	$eachendlng[$i] = $steps[$i]['end_location']['lng'];
	$eachaction[$i] = strip_tags($eachaction[$i]);
	
}

echo '<br>'."Distance : ".$distance." km";
echo '<br>';
echo 'From : '.$origin.'<br>';
echo 'To : '.$dest.'<br>'."Vihecle : ".$_POST['select'].'<br>'.$_POST['cam'];

$campus;

if($_POST['or'] == '7.006341665683104,100.4985523223877'){
	$campus = 2;
}
elseif ($_POST['or']== '7.90608272245317,98.36664140224457') {
	$campus = 1;
}
elseif ($_POST['or']=='13.168317602040103,100.93120604753494') {
	$campus = 5;
}
elseif ($_POST['or']=='9.11065637716888,99.30181503295898') {
	$campus = 4;
}
else if($_POST['or']=='14.343238520299131,100.60918271541595'){
	$campus = 3;
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else {
	if($_POST['select'] == 'car'){
		$rate = 4.5;
	}
	elseif ($_POST['select'] == 'motercycle') {
		$rate = 2 ;
	}

	echo 'Cost : '.$distance*$rate ." bath".'<br>';

	$newdbsql = " INSERT INTO `user_outgoing` (`user_outgoing_id`, `branch_id`, `user_id`, `origin_lat`, `origin_lng`, `origin_branch_description_id`, `destination_lat`, `destination_lng`, `destination_branch_description_id`, `vihecle_type`, `distance`, `rate`, `cost`, `status`, `datetime_enter`) VALUES (NULL,".$campus.", '4', '".$orlatlng[0]."', '".$orlatlng[1]."', '0', '".$endpos[0]."', '".$endpos[1]."', '".$dest_description."', '".$_POST['select']."', ".$distance.", ".$rate.", ".$distance*$rate.",'wait' ,'".$datetime."')";

	if (mysqli_query($conn, $newdbsql)) {
		//echo "add to db complete".'<br>';
  
    }
 else {
    echo "Error: " . $newdbsql . "<br>" . mysqli_error($conn);
}

$ogid;
$foridsql = "SELECT user_outgoing_id FROM user_outgoing WHERE datetime_enter = '".$datetime."'";
$result = mysqli_query($conn,$foridsql);
if($result){
	 while ($arec= mysqli_fetch_array($result,MYSQLI_ASSOC)){
	 	//echo  "Outgoing id : ".$arec['user_outgoing_id']."<br>";
	 	$ogid=$arec['user_outgoing_id'];
	 }
	
}
//echo $ogid;

for($i=0;$i<$countstep;$i++){
	$sqlstep = "INSERT INTO `user_outgoing_detail`(user_outgoing_detail_id,user_outgoing_id,start_lat,start_lng,end_lat,end_lng,distance,instruction) VALUES (NULL,'".$ogid."','".$eachstartlat[$i]."','".$eachstartlng[$i]."','".$eachendlat[$i]."','".$eachendlng[$i]."','".$eachdistance[$i]."','".$eachaction[$i]."')";
	//echo $sqlstep;
	if(mysqli_query($conn,$sqlstep)){
		//echo "complete";
	}
	else{
		echo "<br>"."fail";
	}
}

	}
mysqli_close($conn);

?>
<body>
	<button id="refresh" onclick="redirect()">Back</button>
	<script type="text/javascript">
	function redirect(){
		window.location.href = "http://127.0.0.1/testgoogle/dootook.php";
	}
	</script>
</body>
</html>