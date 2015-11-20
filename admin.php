<head>
    <title>Admin || Embryo</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="_style/style.css" />
    
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
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
<?php


    require("common.php");
    

    if(empty($_SESSION['user']))
    {

        header("Location: login.php");

        die("Redirecting to login.php");
    }
    if($_SESSION['user']['admin'] == 0) {
        echo " <p class='triche'>Vil petit tricheur, tu n'as pas accès à cette section !</p> ";
        echo "<style>nav, header, .mainContent__Post {display:none;}
                     .triche {text-align:center;padding-top:200px;}
                     a {text-align:center; margin:0 auto;display:block}
              </style>";
    }

    $query = "
        SELECT
            id,
            username,
            email
        FROM users
    ";
    
    try
    {

        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {

        die("Failed to run query: " . $ex->getMessage());
    }
        

    $rows = $stmt->fetchAll();
?>

<!-- Navigation -->
        <nav>
            <ul>
                <li><a class="logo" href="index.php"><img src="_img/logo.svg" alt="logo" /><p>Embryo</p></a></li>
                    <?php 
                        if ($_SESSION['user']['admin'] == 1) {
                            echo"<li><a href='admin.php'>Admin</a></li>";
                        }   
                        if(empty($_SESSION['user']))
                        {
                                echo" ";
                            
                            }
                        else
                        {
                            echo"<li><a href='logout.php'>Logout</a></li>";
                        } 
                    ?>
                <li><a href="edit_account.php">
                    <?php 
                        if(empty($_SESSION['user']))
                        {
                                echo"Log in";
                            }
                        else
                        {
                            echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
                        } 
                    ?>
                    </a>
                </li>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="private.php">Posts</a></li>
            </ul>
        </nav>
        
        <header>
            <h1>Memberlist</h1>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>E-Mail Address</th>
                </tr>
                <?php foreach($rows as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td> <!-- htmlentities is not needed here because $row['id'] is always an integer -->
                        <td><?php echo htmlentities($row['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlentities($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
       </header>


        <!-- Main Content -->
        <div class="mainContent__Post">
            <form id="news" action="sendnews.php" method="POST">
                <h1>Poster une news</h1>
                 <div class="inp_field">
                  <label for="title">Titre: </label>
                  <input  type="text" name="title" id="title" maxlength="50" required placeholder="Titre de la news">
                </div>
                
                <div class="inp_field">
                    <label for="content">Contenu de la news ( 2000 caractères max ): </label>
                    <textarea name="content" id="content" maxlength="2000" required placeholder="Quoi de neuf ?"></textarea>
                </div>
                            
                <div class="inp_field">
                  <input type="submit" id="sendButton" value="Envoyer">
                </div>
                <div class="formFooter">

                </div>
            </form>
        </div>

        <!-- JQuery / JS Insertion -->
        <script src="_js/jquery-1.11.2.min.js"></script>
        <script src="_js/main.js"></script>
<a href="private.php">Go Back</a><br />


</body>