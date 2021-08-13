<!DOCTYPE html>
<html>
<head>
    <title>Purchase History</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>

form {
    display: inline-block;
    padding-right: 20px;
}

h1 {
        text-align: center;
    }

h4 {
    text-align: center;
}

.paircus {
    border: 3px rgb(0, 0, 0) solid;
    background-color: lightcyan;
    padding: 9px;
    padding-right: 50px;
    padding-left: 50px;
    padding-bottom: 10px;
    margin-left: 100px;
    margin-right: 100px;
    display: block;
}

</style>
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
    $markup = 1.1;
    $cnx = new mysqli('localhost', 'root', 'Rightguard123', 'storeDB');

    $query = "SELECT * FROM transactions";
    $cursor = $cnx->query($query);

    $count = 0;
    $spent = 0;

    while ($row = $cursor->fetch_assoc()) {

        $count = $count + 1;

        $id = $row['id'];
        $store = $row['store'];

        $query = "SELECT * FROM products WHERE id = '$id' AND store = '$store'";
        $innercursor = $cnx->query($query);
        $innerrow = $innercursor->fetch_assoc();

        $title = $innerrow['title'];

        $price = $innerrow['price'] * $markup;
        $price = number_format($price,2,'.','');
        $spent = $spent + $price;

        $image = $innerrow['iurl'];
        $imageData = base64_encode(file_get_contents($image));	
        $dispimg = '<img src="data:image/jpeg;base64,'.$imageData.'" width="200" height="200" />';

        
        echo '<div class="padmain">';
            echo '<div class="pair">';
                echo '<h2>' . $title . '</h2>';
                echo '<div>' . $dispimg . '</div>';
                echo '<h3 class="bold">Confirmation ID: ' . $row['trans_id'] . '</h3>';
                echo '<h3 class="bold">You paid: $' . $price . '</h3>';


                echo '<form method="post" action="process.php">';
                    echo '<button class="button button1">BUY AGAIN</button>';
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '"/>';
                    echo '<input type="hidden" name="store" value="' . $row['store'] . '"/>';
                echo '</form>';

                echo '<form method="post" action="refund.php">';
                    echo '<button class="button button1">REFUND</button>';
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '"/>';
                    echo '<input type="hidden" name="trans_id" value="' . $row['trans_id'] . '"/>';
                    echo '<input type="hidden" name="store" value="' . $row['store'] . '"/>';
                echo '</form>';

            echo '</div>';
        echo '</div>';
        
    }

    if ($count == 0) {
        echo '<div class="padmain">';
            echo '<div class="paircus">';
                echo '<h1>Welcome to Joe\'s Hobbies!</h1>';
            echo '</div>';

            echo '<div class="padmain">';
                echo '<div class="paircus">';
                    echo '<h3>Here is where you
                    will be able to see the history
                    of your purchases on Joe\'s Hobbies.
                    We don\'t have any data for you yet.
                    Please visit the home store by clicking
                    on the tag at the top to begin shopping!';
                    echo '</h3>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
    else {
        echo '<div class="paircus">';
            echo '<h1 class="bold">Total spent $: ' . $spent . '</h1>';
        echo '</div>';
    }

    $cnx->close();

?>

</body>
</html>