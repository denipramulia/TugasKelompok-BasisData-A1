<?php
    session_start(); 
 	
 	if(!isset($_SESSION["log_id"])){
	  	header('Location: login.php');
	} 
 	include "connection.php";
    
	global $db;

	$user_type = $_SESSION['role'];
	$username = $_SESSION['activeuser'];
	$log_id = $_SESSION['log_id'];
?>

<!Doctype html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>SIRIMA - Home</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link id="general_theme" rel="stylesheet" type = "text/css" href = "../css/style.css"/>
		<link id="local_theme" rel="stylesheet" type = "text/css" href = "../css/login.css"/>
		<link type = "text/css" rel="stylesheet" href="../css/bootstrap.min.css"/>
	</head>

	<body style="overflow-x:hidden">
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="index.php">SIRIMA</a>
		    </div>
		    <ul class="nav navbar-nav">
		    <?php
		      echo '<li class="active"><a href="#">Home</a></li>';
		      if($user_type == "admin"){
		      	echo '<li><a href="rekap_pendaftaran.php">Rekap Pendaftaran</a></li>';
		      	echo '<li><a href="daftar_pelamar_diterima.php">Daftar Pelamar Diterima</a></li>';
		      } 
		      if($user_type == "pelamar"){
		      	echo '<li><a href="membuat_pendaftaran.php">Membuat Pendaftaran</a></li>';
		      	echo '<li><a href="riwayat_pendaftaran.php">Riwayat Pendaftaran</a></li>';
		      	echo '<li><a href="lihat_kartu_ujian.php">Kartu Ujian</a></li>';
		      	echo '<li><a href="lihat_hasil_seleksi.php">Hasil Seleksi</a></li>';
		      }
		      echo '<li><a href="logout.php">Logout</a></li>;' 
		    ?>
		    </ul>
		  </div>
		</nav>

		<?php
			if($user_type == "admin"){
				echo '<p> Welcome Admin! </p>';
			}
			if($user_type == "pelamar"){
				echo '<p> Welcome Pelamar </p>';
			}
			
		?>		
	
		<footer>			
		</footer>
		<script type="text/javascript" src="../js/jquery-3.1.1.js"></script>
	</body>
</html>