<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
	// Validate username
	if(empty(trim($_POST["username"]))){
		$username_err = "Please enter a username.";
	} else{
		// Prepare a select statement
		$sql = "SELECT id FROM users WHERE username = ?";
		
		if($stmt = $mysqli->prepare($sql)){
			// Bind variables to the prepared statement as parameters
			$stmt->bind_param("s", $param_username);
			
			// Set parameters
			$param_username = trim($_POST["username"]);
			
			// Attempt to execute the prepared statement
			if($stmt->execute()){
				// store result
				$stmt->store_result();
				
				if($stmt->num_rows == 1){
					$username_err = "This username is already taken.";
				} else{
					$username = trim($_POST["username"]);
				}
			} else{
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		 
		// Close statement
		$stmt->close();
	}
	
	// Validate password
	if(empty(trim($_POST["password"]))){
		$password_err = "Please enter a password.";     
	} elseif(strlen(trim($_POST["password"])) < 6){
		$password_err = "Password must have atleast 6 characters.";
	} else{
		$password = trim($_POST["password"]);
	}
	
	// Validate confirm password
	if(empty(trim($_POST["confirm_password"]))){
		$confirm_password_err = "Please confirm password.";     
	} else{
		$confirm_password = trim($_POST["confirm_password"]);
		if(empty($password_err) && ($password != $confirm_password)){
			$confirm_password_err = "Password did not match.";
		}
	}
	
	// Check input errors before inserting in database
	if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
		
		// Prepare an insert statement
		$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
		 
		if($stmt = $mysqli->prepare($sql)){
			// Bind variables to the prepared statement as parameters
			$stmt->bind_param("ss", $param_username, $param_password);
			
			// Set parameters
			$param_username = $username;
			$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
			
			// Attempt to execute the prepared statement
			if($stmt->execute()){
				// Redirect to login page
				header("location: login.php");
			} else{
				echo "Something went wrong. Please try again later.";
			}
		}
		 
		// Close statement
		$stmt->close();
	}
	
	// Close connection
	$mysqli->close();
}
?>
 
<!DOCTYPE html>
<!--
	Interphase by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Charity Drop - Donation</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>

		<!-- Header -->
			<header id="header">
				<h1><a href="index.html">Interphase</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.html">Home</a></li>
						<li><a href="generic.html">Generic</a></li>
						<li><a href="elements.html">Elements</a></li>
					</ul>
				</nav>
			</header>

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">

					<header class="major">
						<h2>Almost there!</h2>
						<p></p>
					</header>

					<!-- Form -->
						<section>
							
							<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
							
								<h3>Tell us about yourself.</h3>
								<div class="row uniform 50%">
									<div class="6u 12u$(xsmall)">
										<input type="text" name="name" id="name" value="" placeholder="First Name" />
									</div>
									<div class="6u$ 12u$(xsmall)">
										<input type="text" name="name" id="name" value="" placeholder="Last Name" />
									</div>
									
									<div class="6u$ 12u$(xsmall)">
										<input type="text" name="name" id="name" value="" placeholder="Address Line 1" />
									</div>
									<div class="6u$ 12u$(xsmall)">
											<input type="text" name="name" id="name" value="" placeholder="Address Line 2" />
									</div>
									<div class="6u 12u$(xsmall)">
										<input type="text" name="name" id="name" value="" placeholder="City" />
									</div>
									<div class="6u$ 12u$(xsmall)">
											<input type="text" name="name" id="name" value="" placeholder="Zip Code" />
									</div>

										
									
								</div>
								<div class ="row uniform 50%">
									<h3><br>Let's get you set up with an account.</h3></div>
								<div class="row uniform 50%">
									<div class="6u$ 12u$(xsmall)">
										<input type="text" name="name" id="name" value="" placeholder="Email Address" />
									</div>
									
									
									<div class="6u 12u$(xsmall)">
										<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
											<input type="text" name="name" id="name" value="<?php echo $password; ?>" placeholder="Password" />
											<span class="help-block"><?php echo $password_err; ?></span>
										</div>
									</div>
									<div class="6u$ 12u$(xsmall)">
										<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
											<input type="text" name="name" id="name" value="<?php echo $confirm_password; ?>" placeholder="Re-enter Password" />
											<span class="help-block"><?php echo $confirm_password_err; ?></span>
										</div>
									</div>
									
									<div class="6u$ 12u$(xsmall)">
										<input type="text" name="name" id="name" value="" placeholder="Donation Pickup Location" />
									</div>
								
									<div class="6u$ 12u$(xsmall)">
										<input type="email" name="email" id="email" value="" placeholder="Size of Donation" />
										
									</div>
									<div class="6u$ 12u$(xsmall)">
										<div class="select-wrapper">
											<select name="category" id="category">
												<option value="">- Pickup Time -</option>
												<option value="1">December 2nd, 2019</option>
												<option value="1">December 9th, 2019</option>
												<option value="1">December 16th, 2019</option>
												<option value="1">December 23rd, 2019</option>											</select>
										</div>
									</div>
								</div>
								
							</form>
							
						</section>
						<section>
						<div class="6u$ 12u$(small)">
							<ul class="actions">
							<br>
								<li><a href="verify.html" class="button small">Donate!</a></li>
																
						</div>
												
						</div>
						</section>
						
				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<div class="row">
						<section class="4u 6u(medium) 12u$(small)">
							<h3>Lorem ipsum</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, cumque!</p>
							<ul class="alt">
								<li><a href="#">Lorem ipsum dolor sit amet.</a></li>
								<li><a href="#">Quod adipisci perferendis et itaque.</a></li>
								<li><a href="#">Itaque eveniet ullam, veritatis reiciendis?</a></li>
								<li><a href="#">Accusantium repellat accusamus a, soluta.</a></li>
							</ul>
						</section>
						<section class="4u 6u$(medium) 12u$(small)">
							<h3>Nostrum, repellat!</h3>
							<p>Tenetur voluptate exercitationem eius tempora! Obcaecati suscipit, soluta earum blanditiis.</p>
							<ul class="alt">
								<li><a href="#">Lorem ipsum dolor sit amet.</a></li>
								<li><a href="#">Id inventore, qui necessitatibus sunt.</a></li>
								<li><a href="#">Deleniti eum odit nostrum eveniet.</a></li>
								<li><a href="#">Illum consectetur quibusdam eos corporis.</a></li>
							</ul>
						</section>
						<section class="4u$ 12u$(medium) 12u$(small)">
							<h3>Contact Us</h3>
							<ul class="icons">
								<li><a href="#" class="icon rounded fa-twitter"><span class="label">Twitter</span></a></li>
								<li><a href="#" class="icon rounded fa-facebook"><span class="label">Facebook</span></a></li>
								<li><a href="#" class="icon rounded fa-pinterest"><span class="label">Pinterest</span></a></li>
								<li><a href="#" class="icon rounded fa-google-plus"><span class="label">Google+</span></a></li>
								<li><a href="#" class="icon rounded fa-linkedin"><span class="label">LinkedIn</span></a></li>
							</ul>
							<ul class="tabular">
								<li>
									<h3>Address</h3>
									1234 Somewhere Road<br>
									Nashville, TN 00000
								</li>
								<li>
									<h3>Mail</h3>
									<a href="#">someone@untitled.tld</a>
								</li>
								<li>
									<h3>Phone</h3>
									(000) 000-0000
								</li>
							</ul>
						</section>
					</div>
					<ul class="copyright">
						<li>&copy; Untitled. All rights reserved.</li>
						<li>Design: <a href="http://templated.co">TEMPLATED</a></li>
						<li>Images: <a href="http://unsplash.com">Unsplash</a></li>
					</ul>
				</div>
			</footer>

	</body>
</html>