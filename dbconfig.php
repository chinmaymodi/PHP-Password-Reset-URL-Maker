<?php

/*  Connect to a MySQL server
	Useful to separate the db code from the application code
*/
// Change details and add user/id while testing


$host='localhost';
$user='root';
$pass='';
$schema='test';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
$mysqli = mysqli_connect(
            $host,  /* MySQL server host */
            $user,        /*  Username */
            $pass,   /* password  */
            $schema);   /* The default database schema */

if (!$mysqli) {
   printf("Can't connect to MySQL Server. Errorcode: %s\n", mysqli_connect_error());
   exit;
}
?>