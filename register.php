<?php
 include 'db/connect.php';

if(isset($_POST['submit'])):

    $name  = filter_var($_POST['name'],FILTER_SANITIZE_STRING) ;
    $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) ;
    $pass  = sha1( $_POST['pass']);
    $cpass =  sha1( $_POST['cpass']);

    $select_users = $con->prepare('SELECT * FROM users WHERE email = ? ');
    $select_users->execute([$email]);
    if($select_users->rowCount() > 0){
        $messages[] = 'Email already taken '; 
    }
    else{
        if($pass != $cpass ){
            $messages[] = 'Confirm password do not match !'; 
        }
        else{
           $insetr_user =  $con->prepare('INSERT INTO users 
                                  (name,email,password) VALUES (? , ? , ?)');
           $insetr_user->execute([$name,$email,$pass]) ;
           if($insetr_user){
             $fetch_user = $con->prepare('SELECT * FROM users WHERE 
                                  email= ? AND password = ?');
             $fetch_user->execute([$email,$cpass]);
             $user = $fetch_user->fetch();
             if($fetch_user){
                 setcookie('user_id',$user['id'],time()+ 60 * 60 * 24,'/'); 
                 header('location:home.php');
             }
           }
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
    <title>Register</title>
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
            <h3>Register Now</h3>
            <input type="text" name="name" class="box" required 
            maxlength="30" placeholder="Enter your name ..." autofocus>

            <input type="email" name="email" class="box" required 
             maxlength="40" placeholder="Enter your email ...">

            <input type="password" name="pass" class="box" required 
             maxlength="40" placeholder="Enter your password ...">

            <input type="password" name="cpass" class="box" required 
             maxlength="30" placeholder="Confirm your password ...">

             <input type="submit" value="Register Now" name="submit" class="btn">
             <p>Already have an account ? <a href="login.php">Login now</a></p>
        </form>
    </section>

</body>
</html>