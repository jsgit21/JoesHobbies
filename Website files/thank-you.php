<!DOCTYPE html>
<html>
<head>
    <title>Thank you!</title>
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
    $store = $_POST['store'];

    $transaction_id = $item_id . $item_id * 6 . $item_id + $item_id;

    $query = "SELECT * FROM transactions WHERE trans_id = '$transaction_id'";
    $cursor = $cnx->query($query);
    $count = 0;

    while ($row = $cursor->fetch_assoc()) {
        $count = $count + 1;
    }

    while ( $count > 0 ) {
        $transaction_id = $transaction_id + 1;

        $query = "SELECT * FROM transactions WHERE trans_id = '$transaction_id'";
        $cursor = $cnx->query($query);
        $count = 0;
        while ($row = $cursor->fetch_assoc()) {
            $count = $count + 1;
        }
    }   

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
            echo '<h1>THANK YOU!</h1>';
            echo '<h3>Your transaction has been processed, please keep this confirmation for your records.</h3>';
            echo '<h3>Confirmation ID: ' . $transaction_id . '</h3>';
        echo '</div><br>';
        echo '<div class="pair">';
            echo '<h2>' . $title . '</h2>';
            echo '<div>' . $dispimg . '</div>';
            echo '<h3 class="bold">You paid: $' . $price . '</h3>';

            echo '<form method="post" action="mainpage.php">';
                echo '<button class="button button1">CONTINUE SHOPPING</button>';
            echo '</form>';

            echo '<form method="post" action="purchase-history.php">';
                echo '<button class="button button1">VIEW HISTORY</button>';
            echo '</form>';
        echo '</div>';
    echo '</div>';

    $query = "INSERT INTO transactions(trans_id, id, store) VALUES ('$transaction_id', '$item_id', '$store')";
    $cursor = $cnx->query($query);

    $cnx->close();

?>

</body>
</html>