<?php
        $name = "";
        $email = "";
        $message = "";
        $error = "";
        $success = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']); 
            if(! str_contains($email , '@'))
                $error = "Désolé, l'adresse email doit contenir un '@'.";
            else{
                $success = "Merci $name, votre message a bien été envoyé !";  
                $name = "";
                $email = "";
                $message = "";
            } 

        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mon Formulaire</title>
</head>
<body>

    <h1>Challenge 7</h1><br>
    <h2>Contactez-nous !</h2>

    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="POST" action="Challenge7.php">

        Nom :<br>
        <input type="text" name="name" value="<?php echo $name; ?>" required>
        <br><br>

        Email :<br>
        <input type="text" name="email" value="<?php echo $email; ?>" required>
        <br><br>

        Message :<br>
        <textarea name="message" required><?php echo $message; ?></textarea>
        <br><br>

        <button type="submit">Envoyer</button>

    </form>

</body>
</html>
        