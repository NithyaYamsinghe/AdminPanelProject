
<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: admin-login.php');
	}

	$errors = array();
	$user_id = '';
	$first_name = '';
	$last_name = '';
	$user_name ='';
	$email = '';

	if (isset($_GET['user_id'])) {
		// getting the user information
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
		$query = "SELECT * FROM student WHERE id = {$user_id} UNION SELECT * FROM teacher WHERE id = {$user_id} ";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				// user found
				$result = mysqli_fetch_assoc($result_set);
				$first_name = $result['firstName'];
				$last_name = $result['lastName'];
				$user_name = $result['userName'];
				$email = $result['email'];
				$user_type = $result['userType'];
			} else {
				// user not found
				header('Location: users.php?err=user_not_found');	
			}
		} else {
			// query unsuccessful
			header('Location: users.php?err=query_failed');
		}
	}

	if (isset($_POST['submit'])) {
		$user_id = $_POST['user_id'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$user_name = $_POST['user_name'];
		$email = $_POST['email'];
		$user_type = $_POST['user_type'];

		// checking required fields
		$req_fields = array('user_id', 'first_name', 'last_name','user_name' ,'email');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('first_name' => 50, 'last_name' =>100, 'email' => 100);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// checking email address
		if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
		}

		// checking if email address already exists
		$email = mysqli_real_escape_string($connection, $_POST['email']);

		$query = "SELECT * FROM student WHERE email = '{$email}' AND id != {$user_id} UNION
				  SELECT * FROM teacher WHERE email = '{$email}' AND id != {$user_id} ";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Email address already exists';
			}
		}
		// Checking username already exists
		$user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
		$query = "SELECT * FROM student WHERE userName = '{$user_name}' AND id != {$user_id} UNION
				  SELECT * FROM teacher WHERE userName = '{$user_name}' AND id != {$user_id} ";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = ' Username already exists';
			}
		}


		if (empty($errors)) {
			// no errors found... adding new record
			$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
			$last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
			$user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
			$user_type = mysqli_real_escape_string($connection, $_POST['user_type']);
			// email address is already sanitized
			if($user_type == 'student')
				
			{	
				$query = "UPDATE student SET ";
				$query .= "firstName = '{$first_name}', ";
				$query .= "lastName = '{$last_name}', ";
				$query .= "userName = '{$user_name}', ";
				$query .= "email = '{$email}' ";
				$query .= "WHERE id = {$user_id} LIMIT 1";


				$result = mysqli_query($connection, $query);

				if ($result) {
					// query successful... redirecting to users page
					header('Location: users.php?user_modified=true');
				} else {
					$errors[] = 'Failed to modify the record.';
			
				}
			}
			elseif($user_type == 'teacher')
			{
				$query = "UPDATE teacher SET ";
				$query .= "firstName = '{$first_name}', ";
				$query .= "lastName = '{$last_name}', ";
				$query .= "userName = '{$user_name}', ";
				$query .= "email = '{$email}' ";
				$query .= "WHERE id = {$user_id} LIMIT 1";


				$result = mysqli_query($connection, $query);

				if ($result) {
					// query successful... redirecting to users page
					header('Location: users.php?user_modified=true');
				} else {
					$errors[] = 'Failed to modify the record.';
			
				}


			}
			else
			{

			}










		}



	}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet" href = "css/fontawesome/css/all.css" type = "text/css">
    <link rel="stylesheet" type="text/css" href="css/adminStyle.css">
    <link rel = "stylesheet" href = "css/main.css" type ="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Muli|Roboto|ZCOOL+XiaoWei|Work+Sans|Hind+Siliguri|Lobster|Merienda" rel="stylesheet">
    
    <title>4Institute | Modify Users</title>
</head>

<body>
    <div class="backgroundimg">
        <img src="images/background.jpg" width = "100%" alt="">
    </div>
<!-- Page Header Start -->
    <div class="logo_bar">

        <div id = "socialmedia_icons">

                <a href="https://www.facebook.com">
                    <i class="fab fa-facebook fa-2x"></i>
                </a>
        
                <a href="https://www.instagram.com">
                    <i class="fab fa-instagram fa-2x"></i>
                </a>
        
                <a href="https://www.twitter.com">
                    <i class="fab fa-twitter fa-2x"></i>
                </a>
        
                <a href="https://www.youtube.com">
                    <i class="fab fa-youtube fa-2x"></i>
                </a>
        
                <a href="https://www.linkedin.com">
                    <i class="fab fa-linkedin fa-2x"></i>
                </a>
        </div>

        <div id = "logo">
            <img src="images/Logo.png" alt="4Institute" width="350px" height="100px">
        </div>

        <br/><br/><br/>
        <!--<?php //echo '<img src="'.$_SESSION['profilePicture'].'" class="avatar">'?>-->
        <a href="logout.php"><div id = "login_button">Log out</div></a>
        <a href="users.php"><div id = "login_button">Users</div></a>

        
        
    </div>
    <nav>
    <div class = "nav_bar">
        <div class = "nav_items">
                <a href="index.html"><div id = "button1">HOME</div></a> 
            
                <a href="#"><div id = "button2">TUTORIALS</div></a> 
            
                <a href="#"><div id = "button3">VIDEOS</div></a> 
            
                <a href="#"><div id = "button4" >eBOOKS</div></a> 
            
                <a href="#"><div id = "button5" >TUTORS</div></a> 
            
                <a href="#"><div id = "button6" >ABOUT US</div></a> 
            
                <a href="#"><div id = "button7" >CONTACT US</div></a> 
            </div>
         
            <div id="search_bar">
                <form action="#">
                    <input type="text" placeholder="Search Here...">        
                </form>
        </div>
    </div>
    </nav>
<!-- Page Header End -->
	<main>
		<h1>View / Modify User<span> <a href="users.php">< Back to User List</a></span></h1>

		<?php 

			if (!empty($errors)) {
				display_errors($errors);
			}

		 ?>
		<div id="modifyUserForm">
		<form action="modify-user.php" method="post" class="userform">
			<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
			<p>
				<label for="">First Name:</label>
				<input type="text" name="first_name" <?php echo 'value="' . $first_name . '"'; ?>>
			</p>

			<p>
				<label for="">Last Name:</label>
				<input type="text" name="last_name" <?php echo 'value="' . $last_name . '"'; ?>>
			</p>

			<p>
				<label for="">User Name:</label>
				<input type="text" name="user_name" <?php echo 'value="' . $user_name . '"'; ?>>
			</p>


			<p>
				<label for="">Email Address:</label>
				<input type="text" name="email" <?php echo 'value="' . $email . '"'; ?>>
			</p>

			<p>
				<label for="">User Type:</label>
				<select name="user_type" class="userType"  >
					<option <?php echo 'value="' . $user_type . '"'; ?>>Student</option>
					<option <?php echo 'value="' . $user_type . '"'; ?>>Teacher</option>
				</select><br><br>
			</p>

			<p>
				<label for="">Password:</label>
				<span>******</span> | <a href="change-password.php?user_id=<?php echo $user_id; ?>">Change Password</a>
			</p>

			<p>
				<label for="">&nbsp;</label>
				<button type="submit" name="submit">Save</button>
			</p>

		</form>
	</div>

		
		
	</main>
</body>
</html>
<?php include('footer.php'); ?>