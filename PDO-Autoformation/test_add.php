<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
<?php
include 'db.php';
$title="my title";
$author="Touria";
$price=700.44;

$query = "INSERT INTO  library_books (title, author, price) VALUES (:title , :author, :price)";
$stmt = $conn->prepare($query);
$stmt->execute(['title' => $title, 'author' => $author ,'price' => $price]);
echo"<br>";
echo"Success! Book added with ID: ". $conn->lastInsertId();

?>
</div>
</body>
</html>