<?php
require ('koneksi.php');
session_start();

$error = '';
$validate = '';

if (isset($_SESSION['username'])) header('Location: index.php');
if (isset($_POST['submit'])){
    $username = stripslashes($_POST['username']);
    $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    if (!empty(trim($username)) && !empty(trim($password))){
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn,$query);
        $rows = mysqli_num_rows($result);
        if ($rows != 0){
            $hash = mysqli_fetch_assoc($result)['password'];
            if (password_verify($password, $hash)){
                $_SESSION['username'] = $username;
                header('Location: index.php');
            }
        } else{
            $error = 'Login user gagal';
        }
    } else{
        $error = 'Data tidak boleh kosong';
    }
}
?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Login</span></div>
        <form action="#">
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" required>
          </div>
          <div class = "row">
                        <td><center><img src="captcha.php" alt="gambar"/></center></td>
                        <td>
                        <input type="Captcha" class="form-control" id="Captcha" name="Captcha" placeholder="Masukkan kode Captcha">
                            <?php if ($validate != ''){ ?>
                            <p class="text-danger"><?=$validate;?></p>
                        <?php }?>
                    </div>
          <div class="pass"><a href="#">Forgot password?</a></div>
          <div class="row button">
            <input type="submit" value="Login">
          </div>
          <div class="signup-link">Dont Have an Account? <a href="register.php">Register Here</a></div>
        </form>
      </div>
    </div>

  </body>
</html>
