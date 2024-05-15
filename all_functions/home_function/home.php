<?php 
session_start();

include("C:/Program Files/xampp/htdocs/ffntions/ffntions/all_functions/database/config.php");

if(!isset($_SESSION['valid'])){
    header("Location: C:/Program Files/xampp/htdocs/ffntions/ffntions/all_functions/login_function/index.php");
    exit; 
}

$id = $_SESSION['id'];

$query = mysqli_query($con, "SELECT * FROM users WHERE Id='$id'");

if(!$query) {
    die("Error en la consulta SQL: " . mysqli_error($con));
}

$res_Uname = $res_Email = $res_Age = "";

if(mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);
    $res_Uname = $result['Username'];
    $res_Email = $result['Email'];
    $res_Age = $result['Age'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/all_functions/login_function/styles/login_style.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a> </p>
        </div>

        <div class="right-links">

            <?php if(!empty($res_Uname)): ?>
                <a href='edit.php?Id=<?php echo $id ?>'>Change Profile</a>
            <?php endif; ?>

            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
    </div>
    <main>

       <div class="main-box top">
          <div class="top">
            <div class="box">
  
                <?php if(!empty($res_Uname)): ?>
                    <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
                <?php endif; ?>
            </div>
            <div class="box">
 
                <?php if(!empty($res_Email)): ?>
                    <p>Your email is <b><?php echo $res_Email ?></b>.</p>
                <?php endif; ?>
            </div>
          </div>
          <div class="bottom">
            <div class="box">

                <?php if(!empty($res_Age)): ?>
                    <p>And you are <b><?php echo $res_Age ?> years old</b>.</p>
                <?php endif; ?> 
            </div>
          </div>
       </div>

    </main>
</body>
</html>
