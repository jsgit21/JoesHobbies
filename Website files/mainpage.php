<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, intial-scale=1">
<head>
    <title>Joe's Store</title>
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

    if ($cnx->connect_error)
	die('Connection failed: ' . $cnx->connect_error);

    $query = 'SELECT * FROM products ORDER BY title ASC';
    $cursor = $cnx->query($query);

    echo '<div class="padmain">';
        while ($row = $cursor->fetch_assoc()) {

            $price = $row['price'] * $markup;
            $price = number_format($price,2,'.','');

            echo '<div class="pair">';
            $image = $row['iurl'];
            $imageData = base64_encode(file_get_contents($image));	
            $dispimg = '<img src="data:image/jpeg;base64,'.$imageData.'" width="200" height="200" />';
            $button = '<input type="button" value="Buy">';
            
            echo '<h2>' . $row['title'] . '</h2>';
            echo '<td>' . $dispimg . '</td>';
            echo '<div class="padmain">';
                echo '<form method="post" action="process.php">';
                    echo '<button class="button button1">VIEW</button>';
                    echo '<input type="hidden" name="item_id" value="' . $row['id'] . '"/>';
                    echo '<input type="hidden" name="store" value="' . $row['store'] . '"/>';
                echo '</form>';
            echo '</div>';
            echo '</td>';

            echo '</div><br>';

        }

    echo '</div>';

    $cnx->close();
?>
</body>
</html>


