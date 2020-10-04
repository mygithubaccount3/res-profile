<?php
require_once "pdo.php";
session_start();

if(isset($_POST['update'])) {
    if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])
     && isset($_POST['headline']) && isset($_POST['summary']) ) {

    // Data validation
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php");
        return;
    }

    if ( strpos($_POST['email'],'@') === false ) {
        $_SESSION['error'] = 'Bad data';
        header("Location: edit.php?");
        return;
    }

    $sql = "UPDATE profile SET first_name = :first_name,
            last_name = :last_name,
            email = :email, headline = :headline, summary = :summary
            WHERE profile_id = :profile_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        ':profile_id' => $_SESSION['profile_id'],
        ':user_id' => $_SESSION['user_id']));
    $_SESSION['success'] = 'Record updated!!!!';
    header( 'Location: index.php' ) ;
    return;
}
}

// Guardian: Make sure that user_id is present
if ( ! isset($_SESSION['user_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}

if(isset($_GET)) {
    $_SESSION['profile_id'] = $_GET['profile_id'];
}
$stmt = $pdo->prepare("SELECT * FROM profile where user_id = :user_id AND profile_id = :profile_id");
$stmt->execute(array(":user_id" => $_SESSION['user_id'], ":profile_id" => $_SESSION['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id or profile_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$e = htmlentities($row['email']);
$h = htmlentities($row['headline']);
$s = htmlentities($row['summary']);
/*$user_id = $row['user_id'];*/
?>
<p>Edit User</p>
<form method="post">
<p>First Name:
<input type="text" name="first_name" value="<?= $fn ?>"></p>
<p>Last Name:
<input type="text" name="last_name" value="<?= $ln ?>"></p>
<p>Email:
<input type="text" name="email" value="<?= $e ?>"></p>
<p>Headline:
<input type="text" name="headline" value="<?= $h ?>"></p>
<p>Summary:
<input type="text" name="summary" value="<?= $s ?>"></p>
<!-- <input type="hidden" name="user_id" value="<?= $user_id ?>"> -->
<p><input type="submit" value="Save" name="update" />
<a href="index.php">Cancel</a></p>
<?php print_r($_SESSION); ?>
</form>
