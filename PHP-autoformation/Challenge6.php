<?php 
$products = [
    'tech' => ['Laptop', 'Phone', 'Tablet'],
    'food' => ['Apple', 'Banana' , 'Bread']
];

$categoryFilter = $_GET['category'] ?? null;
$sortOrder = $_GET['sort'] ?? null;
$filteredProducts = [];

if($categoryFilter ){
    $filteredProducts = $products[$categoryFilter];
}else{
    foreach($products as $category){
        $filteredProducts = array_merge($filteredProducts,$category);
    }
}

if($sortOrder == "asc"){
    sort($filteredProducts);
}
elseif($sortOrder == "desc"){
    rsort($filteredProducts);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Challenge 6</title>
</head>
<body>

<h1>Challenge 6</h1>

<h3>Category</h3>
<a href="?category=tech">Tech</a><br>
<a href="?category=food">Food</a><br>
<a href="Challenge6.php">All</a>

<h3>Sort</h3>
<a href="?category=<?php echo $categoryFilter; ?>&sort=asc">Asc</a><br>
<a href="?category=<?php echo $categoryFilter; ?>&sort=desc">Desc</a>
<h3>Product</h3>
<ul>
<?php
foreach($filteredProducts as $product){
    echo "<li>$product</li>";
}
?>
</ul>

</body>
</html>