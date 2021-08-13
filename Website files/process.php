<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, intial-scale=1">
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
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

<!-- CONTENT HERE -->
<?php
    $markup = 1.1; //10% markup
    $cnx = new mysqli('localhost', 'root', 'Rightguard123', 'storeDB');

    $item_id = $_POST['item_id'];
    $store = $_POST['store'];
    $competeingstore = '';

    $query = "SELECT * FROM products WHERE id = '$item_id'";
    $cursor = $cnx->query($query);

    $checkprice = 500000;
    $cheapeststore = "";
    while ($row = $cursor->fetch_assoc()) {

        if ($row['price'] < $checkprice) {
            $checkprice = $row['price'];
            $cheapeststore = $row['store'];
        }


    }

    if ($store == "michaels") {
        $competeingstore = "hobbylobby";
        $query = "SELECT * FROM products WHERE id = '$item_id' ORDER BY store DESC";
    }
    else {
        $competeingstore = "michaels";
        $query = "SELECT * FROM products WHERE id = '$item_id' ORDER BY store ASC";
    }
    
    echo '<div class="padmain">';
        $cursor = $cnx->query($query);
        while ($row = $cursor->fetch_assoc()) {

            $price = $row['price'] * $markup;
            $price = number_format($price,2,'.','');

            if ($row['store'] == $competeingstore) {
                echo '<br><h2 class="pad">Another item you may be interested in:</h2>';
            }
            else {
                echo '<br><h2 class="pad">Your Item:</h2>'; 
            }
            echo '<div class="pair">';
                $image = $row['iurl'];
                $imageData = base64_encode(file_get_contents($image));	
                $dispimg = '<img src="data:image/jpeg;base64,'.$imageData.'" width="200" height="200" />';
                $button = '<input type="button" value="Buy">';

                echo '<h1 style="border:black;">';
                    if($row['store'] == $cheapeststore) {
                        echo '<h2><mark>' . $row['title'] . '</mark></h2>';
                    }
                    else {
                        echo '<h2>' . $row['title'] . '</h2>';
                    }
                    
                    echo '<h4>' . $row['description'] . '</h4>';

                    echo '<div>' . $dispimg . '</div>';

                    if($row['store'] == $cheapeststore) {
                        echo '<br><h3 class="bold"><mark>Price: $' . $price . '</mark></h3>';
                    }
                    else {
                        echo '<br><h3 class="bold">Price: $' . $price . '</h3>';
                    }
                    echo '<h3 class="bold">Rating: ' . $row['rating'] . ' / 5 </h3>';

                echo '<form method="post" action="thank-you.php">';
                    echo '<button class="button button1">BUY</button>';
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '"/>';
                    echo '<input type="hidden" name="store" value="' . $row['store'] . '"/>';
                    
                echo '</form>';

                echo '</h1>';
            echo '</div><br>';

        }

    echo '</div>';

    $cnx->close();
?>
</body>
</html>