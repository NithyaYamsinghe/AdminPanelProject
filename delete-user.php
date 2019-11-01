<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: admin-login.php');
	}

	if (isset($_GET['user_id'])) {
		// getting the user information
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
		//$user_type = mysqli_real_escape_string($connection, $_GET['user_type']);
		$query = "SELECT * FROM student WHERE id = {$user_id} UNION SELECT * FROM teacher WHERE id = {$user_id} ";
		$result_set = mysqli_query($connection, $query);
		
		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) 
			{	// user found
				$result = mysqli_fetch_assoc($result_set);
				$user_type =$result['userType'];


				if($user_type == 'student' )
				{	// deleting the user
					$query = "UPDATE student SET isDeleted = 1 WHERE id = {$user_id} LIMIT 1";

					$result = mysqli_query($connection, $query);

					if ($result) {
						// user deleted
						header('Location: users.php?msg=user_deleted');
					} 
					else 
					{
		
						header('Location: users.php?err=delete_failed');
					}
				}
				else
				{

					// deleting the user
					$query = "UPDATE teacher SET isDeleted = 1 WHERE id = {$user_id} LIMIT 1";

					$result = mysqli_query($connection, $query);

					if ($result) {
						// user deleted
						header('Location: users.php?msg=user_deleted');
					} 
					else 
					{
		
						header('Location: users.php?err=delete_failed');
					}
				} 


			}
			else 
			{
				// user not found
				header('Location: users.php?err=user_not_found');	
			}


		} 
		else
		{
			// query unsuccessful
			header('Location: users.php?err=query_failed');
		}

	}



		



		
		
//else 
//{
	//header('Location: users.php');
//}
?>