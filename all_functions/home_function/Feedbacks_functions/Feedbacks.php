<?php

@include "C:/Program Files/xampp/htdocs/ffntions/ffntions/all_functions/database/config.php";

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($con, "SELECT * FROM feedbacks WHERE id_feedback = $id");
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update_feedback'])) {
    $id = $_POST['id_feedback'];
    $name = $_POST['name_feedback'];
    $email = $_POST['email_feedback'];
    $feedback = $_POST['feedback'];

    if (empty($name) || empty($email) || empty($feedback)) {
        $message[] = 'please fill out all fields';
    } else {
        $datetime_feedback = date("Y-m-d H:i:s");
        $update = "UPDATE feedbacks SET name_feedback='$name', email_feedback='$email', feedback='$feedback', datetime_feedback='$datetime_feedback' WHERE id_feedback=$id";
        $result = mysqli_query($con, $update);

        if ($result) {
            $message[] = 'feedback updated successfully';
            header('location:Feedbacks.php');
        } else {
            $message[] = 'could not update the feedback';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM feedbacks WHERE id_feedback = $id");
    header('location:Feedbacks.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    <link rel="stylesheet" href="/all_functions/home_function/stylefunctions.css">
</head>

<body>

    <div class="nav-fd">
        <div class="logo-fd">
            <p><a href="../home.php">Ecommerce Shop</a></p>
        </div>

        <div class="right-links-fd">
            <a href="../../../all_functions/database/logout.php"><button class="btn-fd">Log Out</button></a>
        </div>
    </div>

    <?php

    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }

    ?>

    <div class="container">

        <?php if (isset($_GET['edit'])) { ?>
            <div class="admin-product-form-container">
                <form action="Feedback.php" method="post">
                    <h3>Reply feedback</h3>
                    <input type="hidden" name="id_feedback" value="<?php echo $row['id_feedback']; ?>">
                    <input type="email" placeholder="enter email" name="email_feedback" class="box"
                        value="<?php echo $row['email_feedback']; ?>">
                    <textarea placeholder="Enter Reply" name="feedback" class="box"></textarea>
                    <input type="submit" class="btn" name="update_feedback" value="Reply">
                </form>
            </div>
        <?php } ?>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>Feedback ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Feedback</th>
                        <th>Datetime</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                $select = mysqli_query($con, "SELECT * FROM feedbacks");
                while ($row = mysqli_fetch_assoc($select)) { ?>
                    <tr>
                        <td><?php echo $row['id_feedback']; ?></td>
                        <td><?php echo $row['name_feedback']; ?></td>
                        <td><?php echo $row['email_feedback']; ?></td>
                        <td><?php echo $row['feedback']; ?></td>
                        <td><?php echo $row['datetime_feedback']; ?></td>
                        <td>
                            <a href="Feedbacks.php?edit=<?php echo $row['id_feedback']; ?>" class="btn"> <i
                                    class="fas fa-edit"></i> Reply </a>
                            <a href="Feedbacks.php?delete=<?php echo $row['id_feedback']; ?>" class="btn"> <i
                                    class="fas fa-trash"></i> delete </a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>

    </div>

</body>

</html>