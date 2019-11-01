<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 

	// check for form submission
	if (isset($_POST['submit'])) {

		$errors = array();

		// check if the username and password has been entered
		if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 ) {
			$errors[] = 'Username is Missing / Invalid';
		}

		if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1 ) {
			$errors[] = 'Password is Missing / Invalid';
		}

		// check if there are any errors in the form
		if (empty($errors)) {
			// save username and password into variables
			$email 		= mysqli_real_escape_string($connection, $_POST['email']);
			$password 	= mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password);

			// prepare database query
			$query = "SELECT * FROM admin 
						WHERE email = '{$email}' 
						AND password = '{$hashed_password}' 
						LIMIT 1";

			$result_set = mysqli_query($connection, $query);

			verify_query($result_set);

			if (mysqli_num_rows($result_set) == 1) {
				// valid user found
				$user = mysqli_fetch_assoc($result_set);
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['first_name'] = $user['firstName'];
				
				// updating last login
				$query = "UPDATE admin SET lastLogin = NOW() ";
				$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

				$result_set = mysqli_query($connection, $query);

				verify_query($result_set);

				// redirect to users.php
				header('Location: users.php');
			} else {
				// user name and password invalid
				$errors[] = 'Invalid Username / Password';
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
    
    <title>4Institute | Admin Login</title>
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
        <a href="admin-login.php"><div id = "login_button">Log In</div></a>
     
        
        
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
	<div class="login">

		<form action="admin-login.php" method="post" class="form">
			
			<fieldset>
				<legend><h1 class="heading">Log In</h1></legend>

				<?php 
					if (isset($errors) && !empty($errors)) {
						echo '<p class="error">Invalid Username / Password</p>';
					}
				?>

				<?php 
					if (isset($_GET['logout'])) {
						echo '<p class="info">You have successfully logged out from the system</p>';
					}
				?>

				<p>
					<label for="">Username:</label>
					<input type="text" name="email" id="" placeholder="Email Address">
				</p>

				<p>
					<label for="">Password:</label>
					<input type="password" name="password" id="" placeholder="Password">
				</p>

				<p>
					<button type="submit" name="submit">Log In</button>
				</p>

			</fieldset>

		</form>		

	</div> <!-- .login -->
</body>
</html>
<?php include('footer.php'); ?>
<?php mysqli_close($connection); ?>