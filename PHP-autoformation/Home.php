<?php
session_start();

if(!isset($_SESSION['nom'])){
    header("Location: LoginPage.php");
    exit();
}

if(isset($_POST['language'])){
    $_SESSION['language'] = $_POST['language'];

    header("Location: Summary.php");
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

<h2>
<?php
echo "Welcome " . $_SESSION['nom'];
?>
</h2>

<form method="POST">
Favorite Programming Language ? <br><br>

<input type="radio" name="language" value="PHP" > PHP <br>
<input type="radio" name="language" value="JAVA"> JAVA <br>
<input type="radio" name="language" value="PYTHON"> PYTHON <br><br>

<button type="submit">Envoyer</button>

</form>

</body>
</html>