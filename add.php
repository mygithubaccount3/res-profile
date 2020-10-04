<?php
    require_once "pdo.php";

    session_start();

    if ( ! isset($_SESSION['name']) ) {
        die('Not logged in');
    }

    /*$stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');*/
    $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');

    if ( isset($_POST['add'] ) ) {# It is a good practice to put the 'All fields are required' check before the other checks (like is_numeric)
        if(isset($_POST['first_name']) &&
            isset($_POST['last_name']) &&
            isset($_POST['email']) &&
            isset($_POST['headline']) &&
            isset($_POST['summary']) &&
            ctype_alpha($_POST['first_name']) &&
            ctype_alpha($_POST['last_name']) &&
            preg_match("/^(?=.{1,60}$)[a-zA-Z]+([.+]?[a-zA-Z0-9]+)*@[a-zA-Z]+\.[a-zA-Z]+$/", $_POST['email']) &&
            ctype_alpha($_POST['headline']) &&
            ctype_alpha($_POST['summary'])) {
            if(strlen($_POST['first_name']) > 0) {
                /*$stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'])
                );*/
                $stmt->execute(array(
                    ':uid' => $_SESSION['user_id'],
                    ':fn' => $_POST['first_name'],
                    ':ln' => $_POST['last_name'],
                    ':em' => $_POST['email'],
                    ':he' => $_POST['headline'],
                    ':su' => $_POST['summary'])
                );
                $_SESSION['success'] = "Record added";
                header("Location: index.php");
                return;
            } else {
                $_SESSION['error'] = "First name is required";
                header("Location: add.php");
                return;
            }

        } else {
            $_SESSION['error'] = "All values are required";
            header("Location: add.php");
            return;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <?php
        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
    ?>
    <h1>Tracking autos for <?=$_SESSION['name']?></h1>
    <form method="post">
        <p>First Name:
        <input type="text" name="first_name" size="40"></p>
        <p>Last Name:
        <input type="text" name="last_name"></p>
        <p>Email:
        <input type="email" name="email"></p>
        <p>Headline:
        <input type="text" name="headline" size="40"></p>
        <p>Summary:
        <textarea name="summary" cols="10" rows="10" /></p>
        <p><button type="submit" name="add">Add</button></p>
        <input type="submit" value="Cancel" name="cancel"/>
    </form>
</body>
</html>