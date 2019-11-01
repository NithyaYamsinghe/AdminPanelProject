<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: admin-login.php');
	}

	$errors = array();
	$first_name = '';
	$last_name = '';
	$user_name = '';
	$email = '';
	$password = '';
	$user_type ='';


	if (isset($_POST['submit'])) {
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$user_name = $_POST['user_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$user_type = $_POST['user_type'];
	

		// checking required fields
		$req_fields = array('first_name', 'last_name','user_name', 'email','user_type' ,'password');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('first_name' => 50, 'last_name' =>100, 'email' => 100, 'password' => 40);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// checking email address
		if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
		}

		// checking if email address already exists
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query = "SELECT * FROM student WHERE email = '{$email}'
		UNION SELECT * FROM teacher WHERE email = '{$email}'";


		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Email address already exists';
			}
		}

		if (empty($errors)) {
			if($user_type == 'student')
			{	// no errors found... adding new record
				$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
				$last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
				$user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
				$password = mysqli_real_escape_string($connection, $_POST['password']);
				$user_type = mysqli_real_escape_string($connection, $_POST['user_type']);
				
				// email address is already sanitized
				$hashed_password = sha1($password);

				$query = "INSERT INTO student ( ";
				$query .= "firstName, lastName,userName, email,userType, password, isDeleted";
				$query .= ") VALUES (";
				$query .= "'{$first_name}', '{$last_name}','{$user_name}', '{$email}','{$user_type}' ,'{$hashed_password}', 0";
				$query .= ")";

				$result = mysqli_query($connection, $query);

				if ($result) {
					// query successful... redirecting to users page
					header('Location: users.php?user_added=true');
				} else {
					$errors[] = 'Failed to add the new record.';
				}
			}else{


				// no errors found... adding new record
				$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
				$last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
				$user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
				$password = mysqli_real_escape_string($connection, $_POST['password']);
				$user_type = mysqli_real_escape_string($connection, $_POST['user_type']);
				
				// email address is already sanitized
				$hashed_password = sha1($password);

				$query = "INSERT INTO teacher ( ";
				$query .= "firstName, lastName,userName, email,userType, password, isDeleted";
				$query .= ") VALUES (";
				$query .= "'{$first_name}', '{$last_name}','{$user_name}', '{$email}','{$user_type}', '{$hashed_password}', 0";
				$query .= ")";

				$result = mysqli_query($connection, $query);

				if ($result) {
					// query successful... redirecting to users page
					header('Location: users.php?user_added=true');
				} else {
					$errors[] = 'Failed to add the new record.';
				}





















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
    
    <title>4Institute | Add Users</title>
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
		<h1>Add New User<span> <a href="users.php">< Back to User List</a></span></h1>

		<?php 

			if (!empty($errors)) {
				display_errors($errors);
			}

		 ?>
		<div id="adduserform">
		<form action="add-user.php" method="post" class="userform">
			
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
				<label for="">UserType:</label>
				<select name="user_type" class="userType">
					<option value="student">Student</option>
					<option value="teacher">Teacher</option>
				</select><br>
			</p>

				
			


			<p>
				<label for="">New Password:</label>
				<input type="password" name="password">
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