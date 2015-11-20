<?php

	header ('Content-type: text/html; charset=utf-8');

   $servername = "clementsjwdata.mysql.db";
   $username = "clementsjwdata";
   $password = file_get_contents("../password.txt");
     
   // Create connection
   $conn = new PDO("mysql:host=$servername;dbname=clementsjwdata;charset=utf8", $username, $password);
   // Check connection
   if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
   }
   
   $sql = "SELECT * FROM Groupes ORDER BY id DESC";
   $result = $conn->query($sql);
   
   //if ($result->num_rows > 0) { /!\ variable num_rows for $result does not exist for PDO queries
           // output data of each row
       while($row = $result->fetch(PDO::FETCH_ASSOC)) {
       echo "
	   <div class='postText'>
		   <p class='date'>Posté le: ".htmlspecialchars($row["date"])."</p>
           <p class='className'>".htmlspecialchars($row["class_name"])."</p>
           <p class='exercice'>".htmlspecialchars($row["exercice"])."</p>
           <p class='description'>".htmlspecialchars($row["description"])."</p>
	       <div class='newsFooter'>

           </div> 
      </div>
";
       };


?>