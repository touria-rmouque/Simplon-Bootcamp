<?php
$age = readline("Enter Your Age : ");
$price;

if($age < 12)
    $price=20;
elseif($age >= 12 && $age<= 18 )
    $price=40;
elseif($age > 60)
    $price=30;
else
    $price=60;

if($price == 20)
    echo "------ Ticket ------\n Price : " . $price . "\n Special: Children's Menu included!\n---------------------" ; 
else
    echo "------ Ticket ------\n Price : " . $price . "\n--------------------" ; 

?>