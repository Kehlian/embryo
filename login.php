<?php

    // First we execute our common code to connection to the database and start the session
    require("common.php");
    
    // This variable will be used to re-display the user's username to them in the
    // login form if they fail to enter the correct password.  It is initialized here
    // to an empty value, which will be shown if the user has not submitted the form.
    $submitted_username = '';
    
    // This if statement checks to determine whether the login form has been submitted
    // If it has, then the login code is run, otherwise the form is displayed
    if(!empty($_POST))
    {
        // This query retreives the user's information from the database using
        // their username.
        $query = "
            SELECT
                id,
                username,
                password,
                salt,
                email,
                admin
            FROM users
            WHERE
                username = :username
        ";
        
        // The parameter values
        $query_params = array(
            ':username' => $_POST['username']
        );
        
        try
        {
            // Execute the query against the database
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            // Note: On a production website, you should not output $ex->getMessage().
            // It may provide an attacker with helpful information about your code. 
            die("Failed to run query: " . $ex->getMessage());
        }
        
        // This variable tells us whether the user has successfully logged in or not.
        // We initialize it to false, assuming they have not.
        // If we determine that they have entered the right details, then we switch it to true.
        $login_ok = false;
        
        // Retrieve the user data from the database.  If $row is false, then the username
        // they entered is not registered.
        $row = $stmt->fetch();
        if($row)
        {
            // Using the password submitted by the user and the salt stored in the database,
            // we now check to see whether the passwords match by hashing the submitted password
            // and comparing it to the hashed version already stored in the database.
            $check_password = hash('sha256', $_POST['password'] . $row['salt']);
            for($round = 0; $round < 65536; $round++)
            {
                $check_password = hash('sha256', $check_password . $row['salt']);
            }
            
            if($check_password === $row['password'])
            {
                // If they do, then we flip this to true
                $login_ok = true;
            }
        }
        

        if($login_ok)
        {

            unset($row['salt']);
            unset($row['password']);

            $_SESSION['user'] = $row;
            

            header("Location: index.php");
            die("Redirecting to: index.php");
        }
        else
        {

            print("<p class='loginFailed'>Login Failed.</p>");
            
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        }
    }
    
?>

	<head>
		<title>Login | EMBRYO</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="_style/style.css" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<link rel="shortcut icon" href="_img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="_img/favicon.ico" type="image/x-icon">

	</head>

	<body>
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
				<h1 class="loginTitle">Login</h1>
				<form action="login.php" method="post">

					<fieldset>
						<label for="username"> Nom d'utilisateur:</label>
						<input type="text" id="username" name="username" value="<?php echo $submitted_username; ?>" />
					</fieldset>

					<fieldset>
						<label for="password">Mot de passe:</label>
						<input type="password" id="password" name="password" value="" />
					</fieldset>

					<input class="button button--input" type="submit" value="Login" />
					<div class="cf"></div>
				</form>
				<a href="index.php" class="link--underForm link--underForm--left">Retour à l'accueil</a>
				<a href="register.php" class="link--underForm">Pas de compte ?</a>
			</main>
	</body>