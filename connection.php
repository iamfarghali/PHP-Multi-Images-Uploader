<?php
$host 		= 'localhost';
$db_name 	= 'uploaded_images';
$name 		= 'root';
$pass 		= '';

$conn = new PDO('mysql:host='.$host.';dbname='.$db_name, $name, $pass);

?>