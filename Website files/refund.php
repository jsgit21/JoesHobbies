<!DOCTYPE html>
<html>
<head>
    <title>Refund</title>
    <link rel="stylesheet" href="style.css">

<style>

form {
    display: inline-block;
    padding-right: 20px;
}

</style>
</head>
<body>

<header>
    <div class="container">
        <img src="icon.png" alt="logo" class="logo">
        <nav>
            <ul>
                <li><a href="mainpage.php">Home</a></li>
                <li><a href="purchase-history.php">History</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </div>
</header>

<?php
    $markup = 1.1; //10% markup
    $cnx = new mysqli('localhost', 'root', 'Rightguard123', 'storeDB');

    $item_id = $_POST['item_id'];
    $trans_id = $_POST['trans_id'];
    $store = $_POST['store'];

    $query = "SELECT * FROM products WHERE id = '$item_id' AND store = '$store'";
    $cursor = $cnx->query($query);
    $row = $cursor->fetch_assoc();

    $price = $row['price'] * $markup;
    $price = number_format($price,2,'.','');
    $title = $row['title'];

    $image = $row['iurl'];
    $imageData = base64_encode(file_get_contents($image));	
    $dispimg = '<img src="data:image/jpeg;base64,'.$imageData.'" width="200" height="200" />';

    echo '<div class="padmain">';
        echo '<div class="pair">';
            echo '<h1>REFUND PROCESSED!</h1>';
            echo '<h3>We are sorry to hear you were not happy with your order. Please return it
            with the shipping label that was sent to your email address. Your refund will
            be processed 2-3 business days after it was received.</h3>';
            echo '<h3>Confirmation ID: ' . $trans_id . '</h3>';
        echo '</div><br>';
        echo '<div class="pair">';
            echo '<h2>' . $title . '</h2>';
            echo '<div>' . $dispimg . '</div>';
            echo '<h3 class="bold">Amount Refunded: $' . $price . '</h3>';

            echo '<form method="post" action="mainpage.php">';
                echo '<button class="button button1">CONTINUE SHOPPING</button>';
            echo '</form>';

            echo '<form method="post" action="purchase-history.php">';
                echo '<button class="button button1">VIEW HISTORY</button>';
            echo '</form>';
        echo '</div>';
    echo '</div>';

    $query = "DELETE FROM transactions WHERE trans_id = '$trans_id'";
    $cursor = $cnx->query($query);

    $cnx->close();

?>

</body>
</html>