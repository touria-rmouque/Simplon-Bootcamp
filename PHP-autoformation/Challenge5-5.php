<!DOCTYPE html>
<html>
    <body>
        <h1>Challenge 05: The Text Flipper (Algorithmic Synthesis)</h1>
<?php

$text= "Touria";
function manualReverse($text) {
    $revers="";
    for ($i=strlen($text)-1 ; $i >= 0 ; $i-- )
        {

        $revers .= $text[$i];

        }
    return $revers;
}
echo "Original: " . $text . "<br>";
echo "Reversed: " . manualReverse($text);
?>
    </body>
</html>