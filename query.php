<?php 


	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'institute'; 

	$connection = mysqli_connect('localhost', 'root', '', 'institute');

	// Checking the connection
	if (mysqli_connect_errno()) {
		die('Database connection failed ' . mysqli_connect_error());
	}else{

		echo "connected";

	}


$first_name = 'Nithya';
$last_name = 'Yamasinghe';
$email = 'nitheeromeshi@gmail.com';
$password = 'pasindu';


$hashed_password = sha1($password);

$query = "INSERT INTO admin (firstName, lastName, email, password) VALUES ('{$first_name}','{$last_name}', '{$email}', '{$hashed_password}')";


if(mysqli_query($connection , $query)){

	echo "Table created<br>";

}else{


	echo "Table not created". mysqli_error($connection)."<br>";
}
mysqli_close($connection);
?>