<?php

//loeme andmebaasi login info muutujad
  require("../../../config.php");
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  $database = "if20_caroly_v_1";

//loeme andmebaasist
  $nonsens2html= "";
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  //valmistame ette SQL käsu
  $stmt = $conn->prepare("SELECT nonsensidea FROM nonsens2");
  echo $conn->error;
  //seome tulemuse mingi muutujaga
  $stmt->bind_result($nonsens2fromdb);
  $stmt->execute();
  //võtan, kuni on
  while($stmt->fetch()) {
	  //<p>suvaline mõte </p>
	  $nonsens2html .= "<p>" .$nonsens2fromdb ."</p>";
	  
  }
  $stmt->close();
  $conn->close();
  //ongi andmebaasist loetud
  //vaatame, mida vormist serverile saadetakse
  //var_dump($_POST);

?>

  <h1>Loe huvitavaid mõtteid!</h1>
  <hr>
  <?php echo $nonsens2html; ?>
  <hr>

  <ul>
    <li><a href="home.php">Avalehele</a></li>
  </ul>

</body>
</html>