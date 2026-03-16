<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

<?php
include 'db.php';

$minPrice = 100;

$query = "SELECT * FROM library_books WHERE price > :price";
$stmt = $conn->prepare($query);
$stmt->execute(['price' => $minPrice]);

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (count($result) > 0) {

    echo "<ul class='list-group'>";
     echo "<li class='list-group-item'> Title </li>";
    foreach ($result as $row) {
        echo "<li class='list-group-item'>" . $row['title'] . "</li>";
    }

    echo "</ul>";

} else {
    echo "No records found";
}
?>

</div>

</body>
</html>