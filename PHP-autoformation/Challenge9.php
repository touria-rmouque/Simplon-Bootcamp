<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$items = ['Apple', 'Banana', 'Orange'];

if (isset($_POST['item'])) {
    $item = $_POST['item'];
    
    if (!in_array($item, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $item;
    }
}
if(isset($_POST['clear_cart'])){
     $_SESSION['cart'] = [];

}

$cart_count = count($_SESSION['cart']);

?>

<h2>Panier : <?php echo $cart_count; ?> article<?php echo ($cart_count > 1 ? 's' : ''); ?></h2>

<h3>Articles disponibles :</h3>
<?php foreach ($items as $i): ?>
    <form method="POST">
        <?php echo $i; ?>
        <input type="hidden" name="item" value="<?php echo $i; ?>">
        <button type="submit">Ajouter au panier</button>
    </form>
    <br>
<?php endforeach; ?>
<form method="POST">
    <button type="submit" name="clear_cart" >Vider le panier</button>
</form>
<h3 >Votre panier :</h3>
<?php if ($cart_count > 0): ?>
    <ul>
        <?php 
        foreach ($_SESSION['cart'] as $c){
             echo"<li> $c </li>";
        }
            
        ?>
    </ul>
<?php endif; ?>