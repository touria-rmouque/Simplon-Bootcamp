<!DOCTYPE html>
<html>
    <body>
        <h1>Challenge 04: The "Safe" Multiplier (Logic Guarding)</h1>
<?php

function multiplyNumbers($a, $b) {
    if(is_numeric($a) && is_numeric($b) )
        return "their product is : ".$a*$b;
    else 
        return "Error: Invalid Input";
}

echo multiplyNumbers(5, 10) ;
echo "<br>";
echo multiplyNumbers(5, "apple") ;
 
?>
    </body>
</html>