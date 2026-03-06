<!DOCTYPE html>
<html>
    <body>
        <h1>Challenge 03: The Logic Gatekeeper (Boolean Return)</h1>
<?php
$age = 30;
 function isAdult ($age){
    if($age >= 18)
        return true ;
    else 
        return false ;
 }

 echo "Your age is : $age <br>" ;

 if (isAdult ($age))
    echo "Access Granted";
else
    echo "Access Denied."
 
?>
    </body>
</html>