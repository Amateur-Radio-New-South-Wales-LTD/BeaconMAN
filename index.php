<?php
include 'config_in.php';

mysql_connect("localhost","root","$sql_password") or die ("unable to connect to database");
@mysql_select_db("beacon") or die ("unable to select database");




?>
