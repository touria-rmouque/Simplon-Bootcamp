<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

<?php
include 'db.php';
$query = "SELECT * FROM categories";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo"<br>";
echo"<select>";
if (count($result) > 0) {
    foreach($result as $row){
    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
}
echo"</select>";
?>

</div>

</body>
</html>