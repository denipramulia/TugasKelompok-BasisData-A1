<?php
    session_start(); 

    include "connection.php";
    
    if(isset($_SESSION["log_id"])){
	  	header('Location: index.php');
	} 

	global $db;

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["username"]) && isset($_POST["password"])){
			$myusername = $_POST["username"];
			$mypassword = $_POST["password"];
			
			$query = "SELECT * FROM AKUN WHERE username='$myusername' AND password='$mypassword'";
			$result = pg_query($db, $query);
			$row = pg_fetch_assoc($result);
			
			if($row["username"] == $myusername)
			{
				if($row["password"] == $mypassword)
				{

						$_SESSION["activeuser"] = $row["username"];
						$_SESSION["log_id"] = $row["username"];
						$_SESSION["user_type"] = $row["role"];
						header("Location: index.php");
					
				}
			}						
			echo "Password Salah";
		}
	}	
?>

<!Doctype html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>SIRIMA - LOGIN</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link id="general_theme" rel="stylesheet" type = "text/css" href = "../css/style.css"/>
		<link id="local_theme" rel="stylesheet" type = "text/css" href = "../css/login.css"/>
		<link type = "text/css" rel="stylesheet" href="../css/bootstrap.min.css"/>
	</head>

	<body style="overflow-x:hidden">
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">SIRIMA</a>
		    </div>
		    <ul class="nav navbar-nav">
		      
		    </ul>
		  </div>
		</nav>
		<div class="outer">
			<div class="middle">
				<div class="inner">
					<form class="form" method="post" action="login.php">
						<h1>Welcome to SIRIMA</h1>
						<input id="username" type="text" name="username" placeholder="Username">
						<input id="password" type="password" name="password" placeholder="Password">
						<button type="submit" id="login-button">Login</button>
						<p> Don't Have an Account? <a href="register.php"> Sign Up </a></p>
					</form>
				</div>
			</div>
		</div>		
	</body>
</html>