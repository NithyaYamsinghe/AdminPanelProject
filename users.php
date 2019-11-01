<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: admin-login.php');
	}

	$user_list = '';

	// getting the list of users
	$query = "SELECT * FROM student WHERE isDeleted=0 ORDER BY firstName";
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {
		$user_list .= "<tr>";
		$user_list .= "<td>{$user['firstName']}</td>";
		$user_list .= "<td>{$user['lastName']}</td>";
		$user_list .= "<td>{$user['userName']}</td>";
		$user_list .= "<td>{$user['userType']}</td>";
		$user_list .= "<td>{$user['lastLogin']}</td>";
		$user_list .= "<td><a href=\"modify-user.php?user_id={$user['id']}\">Edit</a></td>";
		$user_list .= "<td><a href=\"delete-user.php?user_id={$user['id']}\" 
						onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
		$user_list .= "</tr>";
	}


	$user_list1 = '';

	// getting the list of users
	$query = "SELECT * FROM teacher WHERE isDeleted=0 ORDER BY firstName";
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {
		$user_list1 .= "<tr>";
		$user_list1 .= "<td>{$user['firstName']}</td>";
		$user_list1 .= "<td>{$user['lastName']}</td>";
		$user_list1 .= "<td>{$user['userName']}</td>";
		$user_list1 .= "<td>{$user['userType']}</td>";
		$user_list1 .= "<td>{$user['lastLogin']}</td>";
		$user_list1 .= "<td><a href=\"modify-user.php?user_id={$user['id']}\">Edit</a></td>";
		$user_list1 .= "<td><a href=\"delete-user.php?user_id={$user['id']}\" 
						onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
		$user_list1 .= "</tr>";
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
    
    <title>4Institute | Users</title>
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
         <a href="add-user.php"><div id = "login_button">Add Users</div></a>
       

        
        
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
	<!--<header>
		<div class="appname">User Management System</div>
		<div class="loggedin">Welcome <?php //echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>-->

	<main>
		<h1>Users <span><a href="add-user.php">+ Add New</a></span></h1>

		<table class="masterlist">
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>User Name</th>
				<th>User Type</th>
				<th>Last Login</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>

			<?php echo $user_list; ?>

		</table>
		
			<table class="masterlist1">
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>User Name</th>
				<th>User Type</th>
				<th>Last Login</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>

			<?php echo $user_list1; ?>

		</table>
		
		
	</main>
</body>
</html>
<?php include('footer.php'); ?>