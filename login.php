
<?php
 include 'db/connect.php';

if(isset($_POST['submit'])):
    $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) ;
    $pass  = sha1( $_POST['pass']);
    if(empty($email) || empty($pass)){
        $messages[] = ' please fill all input fields '; 
    }
    else {
            $select_users = $con->prepare('SELECT * FROM users WHERE email = ? AND password = ? ');
            $select_users->execute([$email,$pass]);

            $row = $select_users->fetch();
        if($select_users->rowCount() > 0){
            setcookie('user_id',$row['id'],time()+ 60 * 60 * 24,'/'); 
            header('location:home.php');
        }
        else {
          $messages[] = ' Incorrect email or password !'; 
        }
    }
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
     <!-- custom css file -->
        <link rel="stylesheet" href="css/style.css">
</head>
<body>
     <?php
    if(!empty($messages)):
        foreach($messages as $message):
            echo '<div class="alert-box">
                    <li>'.$message.'</li>
                    <span class="times" onclick="this.parentElement.remove()">X</span>
                </div>';
        endforeach;
    endif;
    ?>
    <section class="form-container">
        <form action="" class="form" method="POST">
            <h3>Login Now</h3>

            <input type="email" name="email" class="box" 
             maxlength="40" placeholder="Enter your email ...">

            <input type="password" name="pass" class="box"
             maxlength="40" placeholder="Enter your password ...">

             <input type="submit" value="Login Now" name="submit" class="btn">
             <p>don't have an account ? <a href="register.php">Register now</a></p>
        </form>
    </section>
</body>
</html>