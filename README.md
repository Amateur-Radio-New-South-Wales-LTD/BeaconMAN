<pre>
// BeaconMAN
// Matt Perkins - Copyright (C) 2024 
// This is a quick and somewhat nasty php program to monitor the Beacons at the VK2WI Radio station. 
// It uses the rtl_power package to sample segments of the band and  then compare output power. 

/*

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see .

*/


Dependences: 
rtl_power 
php5.6 
php-mysql-lib 5.6 
mysql 



DB schema
<pre> 
CREATE TABLE beacon.beacons (
    `sequence` INTEGER NOT NULL,
    `call` varchar(6) NULL,
    description varchar(32) NULL,
    start_freq FLOAT NULL,
    end_freq float NULL,
    sample_width float NULL,
    tx_type varchar(32) NULL
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;
CREATE INDEX beacons_sequence_IDX USING BTREE ON beacon.beacons (`sequence`);




