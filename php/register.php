<?php
  session_start(); 

    include "connection.php";
    
    if(isset($_SESSION["log_id"])){
      header('Location: index.php');
  } 

  global $db;

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
      
      $result = $conn->query("SELECT username FROM AKUN WHERE username='.$username.'");
      
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
        $a = $conn->query("INSERT INTO AKUN (username,role,password) VALUES ('$username','FALSE','$password')");
        $s = $conn->query("INSERT INTO PELAMAR (username,nama_lengkap,alamat,jenis_kelamin,tanggal_lahir,no_ktp,email) VALUES ('$username','$name','$alamat','$jenis_kelamin','$tgl_lahir','$noKTP','$email1')");
        
        header("location: login.php");
            
      }
  }?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Register</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="../css/bootstrap.min.css" />
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <header>
      <nav class="navbar navbar-inverse">
      		  <div class="container-fluid">
      		    <div class="navbar-header">
      		      <a class="navbar-brand" href="login.php">SIRIMA - REGISTER</a>
      		    </div>
      		  </div>
      		</nav>
      </header>
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script>
        $( function() {
          $( "#datepicker" ).datepicker();
        } );
      </script>
  </head>
  <body>
      <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h2> Register </h2>
                        </div>
                        <div class="panel-body">
                            <form method="post" id="form-register">
                                <table class="table">
                                    <tbody>                                       
                                       <tr>
                                          <td> Username </td>
                                          <td>
                                            <div class="form-group">
                                             <input class="form-control" placeholder="Username" type="username"  name="username" >
                                             <span class="error"><?php echo $usrErr;?></span>
                                            </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td> Password </td>
                                          <td>
                                            <div class="form-group">
                                             <input class="form-control"  placeholder="Password" type="password" name="pass1" >
                                             <span class="error"><?php echo $pass1Err;?></span>
                                            </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td> Ulangi Password </td>
                                          <td>
                                            <div class="form-group">
                                             <input class="form-control"  placeholder="Ketik Ulang Password" type="password" name="pass2" >
                                             <span class="error"><?php echo $pass2Err;?></span>
                                            </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td> Nama Lengkap </td>
                                          <td>
                                            <div class="form-group">
                                             <input class="form-control"  placeholder="Nama Lengkap" type="text" name="fullName" >
                                            </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td> Nomor Identitas </td>
                                          <td>
                                            <div class="form-group">
                                             <input class="form-control"  placeholder="Nomor Identitas" type="text" name ="noKTP" >
                                             <span class="error"><?php echo $ktpErr;?></span>
                                            </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td> Jenis Kelamin </td>
                                          <td>
                                              <div class="form-group">
                                                 <select class="form-control"  name="Gender" >  
                                                  <option selected="" value="">(Pilih jenis kelamin)</option>  
                                                  <option value="L">Laki-Laki</option>  
                                                  <option value="P">Perempuan</option>  
                                                 </select>
                                              </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td> Tanggal Lahir </td>
                                          <td>
                                            <div class="form-group">
                                             <input class="form-control"  placeholder="Tanggal Lahir" type="date" name="tglLahir" id="datepicker" >
                                            </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td> Alamat </td>
                                          <td>
                                            <div class="form-group">
                                             <input class="form-control"  placeholder="Alamat Tempat Tinggal" type="text" name="alamat" >
                                            </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td> Alamat Email </td>
                                          <td>
                                            <div class="form-group">
                                             <input class="form-control"  placeholder="Alamat email" type="email" name="email1" >
                                             <span class="error"><?php echo $mail1Err;?></span>
                                            </div>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td> Ulangi Alamat Email </td>
                                          <td>
                                            <div class="form-group">
                                             <input class="form-control"  placeholder="Ketik ulang alamat email" type="email" name="email2" >
                                             <span class="error"><?php echo  $mail2Err;?></span>
                                            </div>
                                          </td>
                                       </tr>
                                    </tbody>
                                </table>
                                <a href="login.php" type="submit" class="btn btn-primary"> Create </a>     
                                <button type="reset" class="btn btn-danger"> Reset </button>          
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </body>
</html>