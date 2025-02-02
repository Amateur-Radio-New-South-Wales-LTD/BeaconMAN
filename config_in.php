<?php
$version = "1.1";
$tmpdir = "/tmp"; 
$rtl_power = "/usr/bin/rtl_power"; 
$sql_password = "753a651b6211"; 
$sample_time = 5; 
$offset = 0; 
$pause_time_cmd = "uhubctl --search RTL2838UHIDIR -a 2 -d 60 >/dev/null 2>/dev/null ";
$power_cmd = "uhubctl --search RTL2838UHIDIR -a 2 -d 5"; 
$exec_timeout =10;
$shutdown_cmd = "/usr/sbin/shutdown -r +90 restart-usb";

