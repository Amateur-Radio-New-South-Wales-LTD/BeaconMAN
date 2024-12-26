<HTML>
<HEAD>
<meta http-equiv="refresh" content="120">
</HEAD>
<BODY>
<?php

include 'config_in.php';
mysql_connect("localhost","root","$sql_password") or die ("unable to connect to database");
@mysql_select_db("beacon") or die ("unable to select database");


echo "<h2>BeaconMAN - Matt Perkins (VK2FLY) Version $version</h2>"; 


$query = "SELECT * FROM beacons where test_active = 1 and tx_type = \"Beacon\"";  
$result = mysql_query($query);
$rows = mysql_num_rows($result);
$row = 0;
echo "<h3> Beacons - $rows</h3>";

echo "<table border=1><tr><th>Callsign</th><th> Frequency</th><th>Last Changed</th><th>Status</th></tr>"; 
while($row != $rows){
       $seq = mysql_result($result,$row,"sequence");
       $call = mysql_result($result,$row,"call");
       $description = mysql_result($result,$row,"description");
       $start_freq = mysql_result($result,$row,"start_freq");
       $end_freq = mysql_result($result,$row,"end_freq");
       $sample_width = mysql_result($result,$row,"sample_width");
       $tx_type = mysql_result($result,$row,"tx_type");
       $threshold = mysql_result($result,$row,"threshold");
       $tx_status = mysql_result($result,$row,"tx_status");
       $last_update = mysql_result($result,$row,"last_update");

       if($tx_status == "FAULT"){
	       echo "<tr><td>$call</td><td>$description</td><td>$last_update</td><td bgcolor = \"#ff0000\" >$tx_status</td></tr>"; 
       }else{
	       echo "<tr><td>$call</td><td>$description</td><td>$last_update</td><td bgcolor = \"#00ff00\" ></td></tr>"; 
	}
       $row = $row + 1; 
}
echo "</table>"; 


$query = "SELECT * FROM beacons where test_active = 1 and tx_type = \"Broadcast\"";  
$result = mysql_query($query);
$rows = mysql_num_rows($result);
$row = 0;
if($rows !=0){ 
echo "<h3> Broadcast Transmitters - $rows</h3>";

echo "<table border=1><tr><th>Callsign</th><th> Frequency</th><th>Last Changed</th><th>Status</th></tr>"; 
while($row != $rows){
       $seq = mysql_result($result,$row,"sequence");
       $call = mysql_result($result,$row,"call");
       $description = mysql_result($result,$row,"description");
       $start_freq = mysql_result($result,$row,"start_freq");
       $end_freq = mysql_result($result,$row,"end_freq");
       $sample_width = mysql_result($result,$row,"sample_width");
       $tx_type = mysql_result($result,$row,"tx_type");
       $threshold = mysql_result($result,$row,"threshold");
       $tx_status = mysql_result($result,$row,"tx_status");
       $last_update = mysql_result($result,$row,"last_update");

       if($tx_status == "ON AIR"){
	       echo "<tr><td>$call</td><td>$description</td><td>$last_update</td><td bgcolor = \"#ff0000\" >$tx_status</td></tr>"; 
       }else{
	       echo "<tr><td>$call</td><td>$description</td><td>$last_update</td><td bgcolor = \"#ffffff\" >Standby</td></tr>"; 
	}
       $row = $row + 1; 
}
echo "</table>"; 
}

echo "</HTML>"; 

