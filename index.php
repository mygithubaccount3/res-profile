<?php
    require_once 'pdo.php';
    session_start();

    $isLogged = true;

    /*if(isset($_SESSION['name']) && strlen($_SESSION['name']) > 0) {
        $isLogged = true;
    }*/

    /*if(isset($_POST['edit'])) {
        $_SESSION['profile_id'] = $_POST['profile_id'];
        header("Location: edit.php");
    }*/

    $rows = $pdo->query('SELECT * from profile');
    $profiles = $rows->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
<head><title>Vladyslav Honcharov 5290f86d</title></head><body>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT * FROM profile");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['first_name']));
    echo("</td><td>");
    echo(htmlentities($row['last_name']));
    echo("</td><td>");
    echo(htmlentities($row['email']));
    echo("</td><td>");
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
?>
</table>
<a href="add.php">Add New Entry</a>
<a href="login.php">Please log in</a>

<!-- <!DOCTYPE html>
<html>
<head>
<title>Vladyslav Honcharov 5290f86d</title>
</head>
<body>
<div class="container">
<h1>Welcome to Profiles Manager</h1> -->
<?php
        /*if ( isset($_SESSION['success']) ) {
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }*/
    # session_start();

    # if(isset($_SESSION['name']) && strlen($_SESSION['name']) > 0) {
        # header('Location: view.php');
    # }

    /*foreach ($profiles as $profile) {
        echo "<form method='post'>" .
                "<span name='profile_id'>" . htmlentities($profile['profile_id']) . "</span>" . ' ' .
                htmlentities($profile['first_name']) . ' ' .
                htmlentities($profile['last_name']) . ' ' .
                htmlentities($profile['email']) . ' ' .
                "<a href='view.php'>Detail</a>";
        if($isLogged) {
            echo "<a href='add.php'>Add</a> <button type='submit' name='edit'>Edit</button> <a href='delete.php'>Delete</a>";
        } else {
            echo "<a href='login.php'>Login</a>";
        }
        echo "</form>";
        print_r($_SESSION);
        print_r($_POST);
    }*/
?>
<!-- <a href="add.php">Add New Entry</a>
<a href="login.php">Please log in</a> -->
</body>
