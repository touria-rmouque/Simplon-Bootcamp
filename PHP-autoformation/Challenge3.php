<?php

$friends = array("Manal" => 40 ,"Najwa" => 70 , "Farah" => 98 , "Meryem" => 140 , "Salma" => 200);
$total = 0;
echo"--------Dette-------\n";
foreach($friends as $key=>$value){
$total = $total + $value;
echo "$key : $value DH";
if($value > 100)
    echo " (Dette elevée !)";
echo "\n";
}
echo "--------------------\nTotal : $total";

?>