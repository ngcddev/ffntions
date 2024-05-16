<?php

@include "C:/Program Files/xampp/htdocs/ffntions/ffntions/all_functions/database/config.php";

if (isset($_POST['add_product'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = '../../home_function/inventory_functions/uploaded_img/' . $product_image;


    if (empty($product_name) || empty($product_price) || empty($product_image)) {
        $message[] = 'please fill out all';
    } else {
        $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
        $upload = mysqli_query($con, $insert);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'new product added successfully';
        } else {
            $message[] = 'could not add the product';
        }
    }

}
;

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM products WHERE id = $id");
    header('location:Inventory.php');
}
;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
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
        foreach ($message as $message) {
            echo '<span class="message">' . $message . '</span>';
        }
    }

    ?>

    <div class="container">

        <div class="admin-product-form-container">

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>add a new product</h3>
                <input type="text" placeholder="enter product name" name="product_name" class="box">
                <input type="number" placeholder="enter product price" name="product_price" class="box">
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <input type="submit" class="btn" name="add_product" value="add product">
            </form>

        </div>

        <?php

        $select = mysqli_query($con, "SELECT * FROM products");

        ?>
        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>product image</th>
                        <th>product name</th>
                        <th>product price</th>
                        <th>action</th>
                    </tr>
                </thead>
                <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                    <tr>
                        <td><img src="../../home_function/inventory_functions/uploaded_img/<?php echo $row['image']; ?>"
                                height="100" alt=""></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>$<?php echo $row['price']; ?></td>
                        <td>
                            <a href="Inventory_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i
                                    class="fas fa-edit"></i> edit </a>
                            <a href="Inventory.php?delete=<?php echo $row['id']; ?>" class="btn"> <i
                                    class="fas fa-trash"></i> delete </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>


</body>

</html>