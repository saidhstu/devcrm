<?php
$con=mysqli_connect('localhost','manninternationa_crm','Welcome##1234##','manninternationa_crm'); 
//$con=mysqli_connect('localhost','root','','manninternationa_crm');
 if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
mysqli_query($con,"SET GLOBAL time_zone = '-5:00'");
mysqli_query($con, 'SET GLOBAL time_zone = "America/New_York"');
mysqli_query($con, 'SET time_zone = "-05:00"');
mysqli_query($con, 'SET @@session.time_zone = "-05:00"');
date_default_timezone_set('America/New_York');

?>

