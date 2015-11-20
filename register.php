<?php

    // First we execute our common code to connection to the database and start the session
    require("common.php");
    
    // This if statement checks to determine whether the registration form has been submitted
    // If it has, then the registration code is run, otherwise the form is displayed
    if(!empty($_POST))
    {
        // Ensure that the user has entered a non-empty username
        if(empty($_POST['username']))
        {
            // Note that die() is generally a terrible way of handling user errors
            die("Please enter a username.");
        }
        
        // Ensure that the user has entered a non-empty password
        if(empty($_POST['password']))
        {
            die("Please enter a password.");
        }
        
        // Make sure the user entered a valid E-Mail address filter_var is a useful PHP function for validating form input
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            die("Invalid E-Mail Address");
        }

        $query = "
            SELECT
                1
            FROM users
            WHERE
                username = :username
        ";
        
        // This contains the definitions for any special tokens that we place in our SQL query.
        $query_params = array(
            ':username' => $_POST['username']
        );
        
        try
        {
            // These two statements run the query against your database table.
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
        
        // The fetch() method returns an array representing the "next" row from the selected results, or false if there are no more rows to fetch.
        $row = $stmt->fetch();
        
        // If a row was returned, then we know a matching username was found in the database already and we should not allow the user to continue.
        if($row)
        {
            die("This username is already in use");
        }
        
        // Now we perform the same type of check for the email address, in order to ensure that it is unique.
        $query = "
            SELECT
                1
            FROM users
            WHERE
                email = :email
        ";
        
        $query_params = array(
            ':email' => $_POST['email']
        );
        
        try
        {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            die("Failed to run query: " . $ex->getMessage());
        }
        
        $row = $stmt->fetch();
        
        if($row)
        {
            die("This email address is already registered");
        }
        
        // An INSERT query is used to add new rows to a database table.
        $query = "
            INSERT INTO users (
                username,
                password,
                salt,
                email
            ) VALUES (
                :username,
                :password,
                :salt,
                :email
            )
        ";
        

        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        

        $password = hash('sha256', $_POST['password'] . $salt);
        

        for($round = 0; $round < 65536; $round++)
        {
            $password = hash('sha256', $password . $salt);
        }

        $query_params = array(
            ':username' => $_POST['username'],
            ':password' => $password,
            ':salt' => $salt,
            ':email' => $_POST['email']
        );
        
        try
        {
            // Execute the query to create the user
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {

            die("Failed to run query: " . $ex->getMessage());
        }
        

        header("Location: login.php");
        
        die("Redirecting to login.php");
    }
    
?>

<head>
    <title>Embryo | Login</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="_style/style.css" />
    
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <link rel="shortcut icon" href="_img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="_img/favicon.ico" type="image/x-icon">
        
        
            <!-- Font Insertion -->
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>
</head>
<body>
    <div class="loginContainer">
        <h1 class="loginTitle">Register</h1>
        <form action="register.php" method="post">
            
            <div class="loginField">
                <label for="username">Nom d'utilisateur:</label>
                <input id="username" type="text" name="username" value="" placeholder=" ex: Charles D." />
                <p class="loginnote">Utilisez quelque chose de facilement identifiable, comme "Charles D."</p>
            </div>
            
            <div class="loginField">
                <label for="email">E-Mail:</label>
                <input id="email" type="text" name="email" value="" placeholder=" ex: charles.dupuits@gmail.com" />
            </div>
            
            <div class="loginField">
                <label for="password">Mot de passe:</label>
                <input id="password" type="password" name="password" value="" />
            </div>
            
            <input class="loginSubmit" type="submit" value="S'enregistrer" />
        </form>
    <a href="index.php">Retour à l'accueil</a>
    </div>
</body>