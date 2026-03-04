<?php
$tea_price = 7;
$numbre_cup = readline("How many cups of tea do you want? : ");
$profil = readline("Are you a student? (1 = yes, 2 = no): ");

$bill = $numbre_cup * $tea_price;

if($profil == 1){
    $bill = $bill - ($bill * 0.2);
}

if($numbre_cup > 5){
    $bill = $bill - $numbre_cup;
}

echo "-------- Your Bill --------\nNumber of cups : " . $numbre_cup . "\nPrice per cup  : " . $tea_price  . " DH". " \nTotal :  " . $bill . " DH" . "\n----------------------------";
?>