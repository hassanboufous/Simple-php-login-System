<?php
include 'db/connect.php';

if(isset($_COOKIE['user_id'])){
  $user_id = $_COOKIE['user_id'];

}
else{
   $user_id ='';
   header('location:login.php') ;
}
$select_profile = $con->prepare('SELECT * FROM users WHERE id = ?');
$select_profile->execute([$user_id]);
$profile = $select_profile->fetch() ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- bootstrap css file  -->
    <link rel="stylesheet" href="./bootstrap.css">
     <!-- custom css file -->
        <link rel="stylesheet" href="css/style.css">
</head>
<body>
        <?php
        if(!empty($messages)):
            '<div class="alert-box">';
                foreach($messages as $message):
                    echo "<li>$message<span class='times' onclick='this.parentElement.remove()'>X</span></li>";
                endforeach;
            '</div>';
        endif;
        
        ?>
    <section class="form-container home">
            <h1><?php echo $profile['name'] ?></h1>
            <a href="logout.php" 
            class="btn" id="btn-logout" 
            onclick="return confirm('logout from this website');" >Logout</a>
       
    </section>
    <script src="./bootstrap.js"></script>
</body>
</html>