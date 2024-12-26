#!/usr/bin/php5.6
<?php
// Program to scan the band for beacons and store rx power 
include 'config_in.php';
mysql_connect("localhost","root","$sql_password") or die ("unable to connect to database");
@mysql_select_db("beacon") or die ("unable to select database");


echo "Beacond - Part of BeaconMAN - Matt Perkins (VK2FLY) Version $version\n"; 

$query = "SELECT * FROM beacons where test_active = 1"; 
$result = mysql_query($query); 
$rows = mysql_num_rows($result); 
$row = 0; 
echo "Loaded $rows transmitters to scan.\n"; 

while(1){ 

// Power cycle the SDR. 
echo "Power SDR OFF/";
system("$power_cmd >/dev/null"); 
sleep(1); 
echo "ON\n";

$row = 0; 
while($row != $rows){
	$seq = mysql_result($result,$row,"sequence"); 
	$call = mysql_result($result,$row,"call"); 
	$description = mysql_result($result,$row,"description"); 
	$start_freq = mysql_result($result,$row,"start_freq"); 
	$end_freq = mysql_result($result,$row,"end_freq"); 
	$sample_width = mysql_result($result,$row,"sample_width"); 
	$tx_type = mysql_result($result,$row,"tx_type"); 
	$threshold = mysql_result($result,$row,"threshold"); 
	$cmdbuf = "timeout $exec_timeout $rtl_power -i $sample_time -f $start_freq:$end_freq:$sample_width -1 - 2>/dev/null "; 
	$data = shell_exec($cmdbuf); 
	$data = trim($data); 
	$pwr_result = explode(",",$data); 
	$srows =0 ; 
	$srows = count($pwr_result); 
	if($srows == 0){ 
		echo "Bad result from SDR\n"; 
		break; 
	}	
	$srow = 6; 
	$db_total =0 ; 
	while ($srows != $srow){ 
		$db_total = $db_total + $pwr_result[$srow];
		$srow = $srow + 1; 
	}
	$db_av = $db_total / ($srows -6);
	$db_av = $db_av + $offset;
	$datetime = "$pwr_result[0]$pwr_result[1]"; 

	// Beacon Detection. 
	if($tx_type == "Beacon"){
		if($threshold > $db_av){
			echo "$seq $pwr_result[0] $pwr_result[1] $call - $description $db_av db FAULT\n";
			$query = "UPDATE beacons SET tx_status = \"FAULT\",last_update = \"$datetime\" WHERE sequence = $seq AND tx_status !=\"FAULT\""; 
			$x_result = mysql_query($query); 
		}else{
			echo "$seq $pwr_result[0] $pwr_result[1] $call - $description $db_av db \n";
			$query = "UPDATE beacons SET tx_status = \"\",last_update = \"$datetime\" WHERE sequence = $seq AND tx_status !=\"\""; 
			$x_result = mysql_query($query); 
		}
	}
	//  Broadcast detection. 
	if($tx_type == "Broadcast"){
		if($threshold > $db_av){
			echo "$seq $pwr_result[0] $pwr_result[1] $call - $description $db_av db OFF AIR\n";
			$query = "UPDATE beacons SET tx_status = \"OFF AIR\",last_update = \"$datetime\" WHERE sequence = $seq AND tx_status !=\"OFF AIR\""; 
			$x_result = mysql_query($query); 
		}else{
			echo "$seq $pwr_result[0] $pwr_result[1] $call - $description $db_av db ON AIR \n";
			$query = "UPDATE beacons SET tx_status = \"ON AIR\",last_update = \"$datetime\" WHERE sequence = $seq AND tx_status !=\"ON AIR\""; 
			$x_result = mysql_query($query); 
		}
	}


	$query = "INSERT INTO  beacon_history values (\"$seq\",\"$datetime\",\"$db_av\");";
	$x_result = mysql_query($query); 
	$row = $row + 1; 
}
if($pause_time){
	echo "sleeping $pause_time\n"; 
	sleep($pause_time); 
	}
}
?>
