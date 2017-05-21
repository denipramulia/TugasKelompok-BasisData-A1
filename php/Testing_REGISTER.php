<?php
	include "connection.php";
	$usrErr = $pass1Err = $pass2Err = $ktpErr = $mail1Err = $mail2Err = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
			$username = $_POST["username"];
			$name =$_POST["fullName"];
			$jenis_kelamin=$_POST["Gender"];
			$alamat =$_POST["alamat"];
			$tgl_lahir =$_POST["tglLahir"];
			$password = $_POST["pass1"];
			$password2 = $_POST["pass2"];
			$noKTP = $_POST["noKTP"];
			$email1 = $_POST["email1"];
			$email2 = $_POST["email2"];
			
			$result = $conn->query("SELECT username FROM AKUN WHERE username='".$username."'");
			
			
			if(!preg_match("/^[A-z0-9.]*$/", $username) && !empty($username)) {
			   $usrErr = '* username not valid, username only can be contain letter, number and (.) ';
			}
			elseif($row = $result->fetch(PDO::FETCH_ASSOC)) { 
			  $usrErr = '* The username '.$username.' is already taken!';
			} 
			elseif(strlen($password) < 6 ) {
			  $pass1Err = '* Password must be more than 6 characters';
			}
			elseif( $password != $password2 ) {
			  $pass2Err = '* Password and confirm password does not match!';
			}
			elseif(!preg_match("/^[0-9]{16}$/", $noKTP)){
			  $ktpErr = '* nomor identitas tidak valid';
			}
			elseif( $email1 != "" && !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST["email1"] ) ) {
			  $mail1Err = '* Enter valid email';
			}
			elseif( $email1 != $email2 ) {
			  $mail2Err = '* email and confirm email does not match!';
			}
			else {
			  $a = $conn->query("INSERT INTO AKUN (username,role,password) VALUES ('$username','TRUE','$password')");
			  $s = $conn->query("INSERT INTO PELAMAR (username,nama_lengkap,alamat,jenis_kelamin,tanggal_lahir,no_ktp,email) VALUES ('$username','$name','$alamat','$jenis_kelamin','$tgl_lahir','$noKTP','$email1')");
			  
			  header("location: user.php");
			  // some pdo statement to insert data 
			  
			   
			  
			}
	}
	?>

<body>
<script>
	$(document).ready(function() {
	    $(document).mousemove(function(event) {
	        TweenLite.to($("body"), 
	        .5, {
	            css: {
	                backgroundPosition: "" + parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / '12') + "px, " + parseInt(event.pageX / '15') + "px " + parseInt(event.pageY / '15') + "px, " + parseInt(event.pageX / '30') + "px " + parseInt(event.pageY / '30') + "px",
	            	"background-position": parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / 12) + "px, " + parseInt(event.pageX / 15) + "px " + parseInt(event.pageY / 15) + "px, " + parseInt(event.pageX / 30) + "px " + parseInt(event.pageY / 30) + "px"
	            }
	        })
	    })
	})
</script>
<style type="text/css">
	body {
        background-color: #444;
        background: url(src/images/background.jpg);
        
    }
    .form-signin input[type="text"] {
        margin-bottom: 5px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .form-signin .form-control {
        position: relative;
        font-size: 16px;
        font-family: 'Open Sans', Arial, Helvetica, sans-serif;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .vertical-offset-100 {
        padding-top: 60px;
    }
	.offset-md-3{
		display: block;
		margin-left: 25%;
		margin-right: 25%;
	}
    .img-responsive {
    display: block;
    max-width: 100%;
    height: auto;
    margin: auto;
    }
    .panel {
    margin-bottom: 5px;
    background-color: rgba(255, 255, 255, 0.75);
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    }
	.error {color: #FF0000;}
</style>

<div class="container center">
    <div class="row vertical-offset-100">
        <div class="col-md-6 offset-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">                                
                    <div class="row-fluid user-row">
                        <img src="src/images/logo.png" class="img-responsive" alt="Conxole Admin"/>
                    </div>
                </div>
                <div class="panel-body">
                    <form id="register" role="form" action='register.php' method="post">
						
							<div class="panel-login">
							  <h5 class="text-center bold">FORM PENDAFTARAN AKUN PELAMAR</h5>
							</div>
							
							  <div class="form-group">
								<label for="exampleInputEmail1">Username</label>
								<input class="form-control" placeholder="username" type="username"  name="username">
								<span class="error"><?php echo $usrErr;?></span>
							  </div>
							  <div class="form-group">
								<label for="exampleInputPassword1">Password</label>
								<input class="form-control"  placeholder="Password" type="password" name="pass1" >
								<span class="error"><?php echo $pass1Err;?></span>
							  </div>
							  <div class="form-group">
								<label for="exampleInputPassword1">Ulangi Password</label>
								<input class="form-control"  placeholder="Password" type="password" name="pass2" >
								<span class="error"><?php echo $pass2Err;?></span>
							  </div>
							  <div class="form-group">
								<label for="exampleInputName">Nama Lengkap</label>
								<input class="form-control"  placeholder="Nama Lengkap" type="text" name="fullName" >
							  </div>
							  <div class="form-group">
								<label for="exampleInputNumb">Nomor Identitas</label>
								<input class="form-control"  placeholder="Nomor Identitas" type="text" name ="noKTP" >
								<span class="error"><?php echo $ktpErr;?></span>
							  </div>
							  <div class="form-group">
								<label for="exampleInputGender">Jenis Kelamin</label>
								<select class="form-control"  name="Gender" >  
									<option selected="" value="">(Pilih jenis kelamin)</option>  
									<option value="L">laki-laki</option>  
									<option value="P">Perempuan</option>  
								</select>
							  </div>
							  
							   <div class="form-group">
								<label for="exampleInputNumb">Tanggal Lahir</label>
								<input class="form-control"  placeholder="Tanggal Lahir" type="date" name="tglLahir" >
							  </div>
							  
							  <div class="form-group">
								<label for="exampleInputAlamat">Alamat</label>
								<input class="form-control"  placeholder="Alamat Tempat tinggal" type="text" name="alamat" >
							  </div>
							  
							  <div class="form-group">
								<label for="exampleInputEmail1">Alamat Email</label>
								<input class="form-control"  placeholder="Alamat email" type="email" name="email1" >
								<span class="error"><?php echo $mail1Err;?></span>
							  </div>
							  
							  <div class="form-group">
								<label for="exampleInputEmail1">Ulangi Email</label>
								<input class="form-control"  placeholder="Ketik ulang alamat email" type="email" name="email2" >
								<span class="error"><?php echo  $mail2Err;?></span>
							  </div>
						
							<div class="modal-footer">
							  <button type="submit" class="btn btn-primary name="submit">DAFTAR</button>
							</div>
						  
					</form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</body>