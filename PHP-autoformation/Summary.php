<html>
    <head>
    <title>Challenge 8</title>
    </head>
<body>
<h1>
<?php
session_start();
echo "Hello " . $_SESSION['nom'] . " you love " .  $_SESSION['language']. " !";
session_destroy();
?>
</h1>
</body>
</html>