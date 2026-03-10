<?php
session_start();

if(isset($_POST['username'])){
    $_SESSION['nom'] = $_POST['username'];
    header("Location: Home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Challenge 8</title>
</head>
<body>

<h1>Challenge 8</h1>

<form method="POST">
Username :<br>
<input type="text" name="username" required>
<br><br>

<button type="submit">Login</button>
</form>

</body>
</html>