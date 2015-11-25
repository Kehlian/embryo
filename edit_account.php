<?php

    // First we execute our common code to connection to the database and start the session
    require("common.php");
    
    // At the top of the page we check to see whether the user is logged in or not
    if(empty($_SESSION['user']))
    {
        // If they are not, we redirect them to the login page.
        header("Location: login.php");
        
        // Remember that this die statement is absolutely critical.  Without it,
        // people can view your members-only content without logging in.
        die("Redirecting to login.php");
    }
    
    // This if statement checks to determine whether the edit form has been submitted
    // If it has, then the account updating code is run, otherwise the form is displayed
    if(!empty($_POST))
    {
        // Make sure the user entered a valid E-Mail address
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            die("Invalid E-Mail Address");
        }
        
        // If the user is changing their E-Mail address, we need to make sure that
        // the new value does not conflict with a value that is already in the system.
        // If the user is not changing their E-Mail address this check is not needed.
        if($_POST['email'] != $_SESSION['user']['email'])
        {
            // Define our SQL query
            $query = "
                SELECT
                    1
                FROM users
                WHERE
                    email = :email
            ";
            
            // Define our query parameter values
            $query_params = array(
                ':email' => $_POST['email']
            );
            
            try
            {
                // Execute the query
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            }
            catch(PDOException $ex)
            {
                // Note: On a production website, you should not output $ex->getMessage().
                // It may provide an attacker with helpful information about your code. 
                die("Failed to run query: " . $ex->getMessage());
            }
            
            // Retrieve results (if any)
            $row = $stmt->fetch();
            if($row)
            {
                die("This E-Mail address is already in use");
            }
        }
        
        // If the user entered a new password, we need to hash it and generate a fresh salt
        // for good measure.
        if(!empty($_POST['password']))
        {
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $password = hash('sha256', $_POST['password'] . $salt);
            for($round = 0; $round < 65536; $round++)
            {
                $password = hash('sha256', $password . $salt);
            }
        }
        else
        {
            // If the user did not enter a new password we will not update their old one.
            $password = null;
            $salt = null;
        }
        
        // Initial query parameter values
        $query_params = array(
            ':email' => $_POST['email'],
            ':user_id' => $_SESSION['user']['id'],
        );
        
        // If the user is changing their password, then we need parameter values
        // for the new password hash and salt too.
        if($password !== null)
        {
            $query_params[':password'] = $password;
            $query_params[':salt'] = $salt;
        }
        
        // Note how this is only first half of the necessary update query.  We will dynamically
        // construct the rest of it depending on whether or not the user is changing
        // their password.
        $query = "
            UPDATE users
            SET
                email = :email
        ";
        
        // If the user is changing their password, then we extend the SQL query
        // to include the password and salt columns and parameter tokens too.
        if($password !== null)
        {
            $query .= "
                , password = :password
                , salt = :salt
            ";
        }
        
        // Finally we finish the update query by specifying that we only wish
        // to update the one record with for the current user.
        $query .= "
            WHERE
                id = :user_id
        ";
        
        try
        {
            // Execute the query
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            // Note: On a production website, you should not output $ex->getMessage().
            // It may provide an attacker with helpful information about your code. 
            die("Failed to run query: " . $ex->getMessage());
        }
        
        // Now that the user's E-Mail address has changed, the data stored in the $_SESSION
        // array is stale; we need to update it so that it is accurate.
        $_SESSION['user']['email'] = $_POST['email'];
        
        // This redirects the user back to the members-only page after they register
        header("Location: private.php");
        
        // Calling die or exit after performing a redirect using the header function
        // is critical.  The rest of your PHP script will continue to execute and
        // will be sent to the user if you do not die or exit.
        die("Redirecting to private.php");
    }
    
?>

	<head>
		<title>Mon compte | EMBRYO</title>

		<link rel="stylesheet" href="_style/style.css" />

		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<link rel="shortcut icon" href="_img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="_img/favicon.ico" type="image/x-icon">

	</head>

	<body>
		<!-- Navigation -->
		<nav>
			<ul>
				<li><a class="nav__element nav__element--logo" href="index.php">Embryo</a></li>
				<li class="nav__element nav__element--empty"></li>
				<li><a class="nav__element nav__element--link " href="index.php">Accueil</a></li>
				<li><a href="private.php" class="nav__element nav__element--link">Posts</a></li>
				<li>
					<a href="edit_account.php" class="nav__element nav__element--link onPage">
						<?php 
					if(empty($_SESSION['user']))
					{
							echo"Login";
						}
					else
					{
						echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); //protect script injection via name
					} 
				?>
					</a>
				</li>
				<?php                 
                        if(empty($_SESSION['user']))
                        {
                                echo" ";
                            
                            }   
                        else
                        {
							if ($_SESSION['user']['admin'] == 1) {
                            echo"<li><a href='admin.php' class='nav__element nav__element--link'>Admin</a></li>";
                        	}  
                        	echo"<li><a href='logout.php' class='nav__element nav__element--link'>Logout</a></li>";
                        }
                    ?>
			</ul>
		</nav>
		<main>
			<h1 class="editTitle loginTitle">Editer mon compte</h1>
			<form action="edit_account.php" method="post">

				<fieldset>
					<p>Nom d'utilisateur:</p>
					<b><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></b>
				</fieldset>

				<fieldset>
					<label for="email">Adresse Mail:</label>
					<input id="email" type="text" name="email" value="<?php echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>" />
				</fieldset>

				<fieldset>
					<label for="password">Mot de passe:</label>
					<input id="password" type="password" name="password" value="" placeholder="Laisser vide pour ne pas le modifier" />
				</fieldset>
				<input class="button button--input" type="submit" value="Mettre à jour" />
			</form>
		</main>
	</body>