<?php
    require_once "pdo.php";

    session_start();

    if ( ! isset($_SESSION['name']) ) {
        die('Not logged in');
    }

    $cars = $pdo->query("SELECT make, year, mileage FROM autos");
    $rows = $cars->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <?php
        if ( isset($_SESSION['success']) ) {
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }
    ?>
    <h1>Tracking autos for <?=$_SESSION['name']?></h1>
    <h2>Automobiles</h2>
    <?php
        echo "<ul>";
        foreach ( $rows as $row ) {
            echo("<li>" . htmlentities($row['year']) . ' ' . htmlentities($row['make']) . ' ' . htmlentities($row['mileage']) . "</li>");
        }
        echo "</ul>";
        ?>
        <a href="add.php">Add New</a>
        <a href="logout.php">Logout</a>
</body>
</html>