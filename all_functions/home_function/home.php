<?php
session_start();

include ("C:/Program Files/xampp/htdocs/ffntions/ffntions/all_functions/database/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: C:/Program Files/xampp/htdocs/ffntions/ffntions/all_functions/login_function/index.php");
    exit;
}

$id = $_SESSION['id'];

$query = mysqli_query($con, "SELECT * FROM users WHERE Id='$id'");

if (!$query) {
    die("Error en la consulta SQL: " . mysqli_error($con));
}

$res_Uname = $res_Email = $res_Age = $res_Role = "";

if (mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);
    $res_Uname = $result['Username'];
    $res_Email = $result['Email'];
    $res_Age = $result['Age'];
    $res_Role = $result['Role'];
}

// Procesar el formulario de feedback
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $observation = $_POST['observation'];

    if (empty($name) || empty($email) || empty($observation)) {
        $message[] = 'Please fill out all fields';
    } else {
        $datetime_feedback = date("Y-m-d H:i:s");
        $insert = "INSERT INTO feedbacks (name_feedback, email_feedback, feedback, datetime_feedback) VALUES ('$name', '$email', '$observation', '$datetime_feedback')";
        if (mysqli_query($con, $insert)) {
            $message[] = 'Feedback sent successfully';
        } else {
            $message[] = 'Could not send feedback: ' . mysqli_error($con);
        }
    }
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
            <p><a href="home.php">Ecommerce Shop</a></p>
        </div>

        <div class="right-links">
            <?php if (!empty($res_Uname)): ?>
                <a href='changeprfl.php?Id=<?php echo $id ?>'><button class="btn">Update Profile</button></a>
            <?php endif; ?>

            <?php if ($res_Role == 1): ?>
                <div class="dropdown">
                    <button class="dropbtn">Manage</button>
                    <div class="dropdown-content">
                        <a href="Feedbacks_functions/Feedbacks.php">Feedbacks</a>
                        <a href="Inventory_functions/Inventory.php">Inventory</a>
                    </div>
                </div>
            <?php endif; ?>

            <a href="../../../all_functions/database/logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>

    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <?php if (!empty($res_Uname)): ?>
                        <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
                    <?php endif; ?>
                </div>
                <div class="box">
                    <?php if (!empty($res_Email)): ?>
                        <p>Your email is <b><?php echo $res_Email ?></b>.</p>
                    <?php endif; ?>
                </div>
                <div class="box">
                    <?php if (!empty($res_Role)): ?>
                        <p>Your role is <b><?php echo $res_Role ?></b>.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bottom">
                <div class="box">
                    <?php if (!empty($res_Age)): ?>
                        <p>And you are <b><?php echo $res_Age ?> years old</b>.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="feedback-container">
            <h2>Feedback Form</h2>
            <form method="post">
                <h3>Send your feedback or observation</h3>
                <input type="text" name="name" placeholder="Full name" class="input"
                    value="<?php echo htmlspecialchars($res_Uname); ?>">
                <input type="email" name="email" placeholder="E-Mail" class="input"
                    value="<?php echo htmlspecialchars($res_Email); ?>">
                <input type="text" name="observation" placeholder="Feedback or observation" class="input">
                <input type="submit" name="register" class="btn submit" value="Send Feedback">
            </form>
        </div>

    </main>
</body>

</html>