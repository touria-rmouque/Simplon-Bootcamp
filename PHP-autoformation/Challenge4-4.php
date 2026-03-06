<!DOCTYPE html>
<html>
    <body>
        <h1>Challenge 04: Even Number Counter</h1>
<?php
$total=0;
for($i=1 ; $i<=50 ; $i++)
    {
        if(!($i % 2))
            $total += 1 ;

    }
echo "Total even numbers : $total";
?>
    </body>
</html>