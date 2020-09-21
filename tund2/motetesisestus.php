<?php

  $username = "Caroly Vilo";
  //loeme andmebaasi login info muutujad
  require("../../../config.php");
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  $database = "if20_caroly_v_1";
  if(isset($_POST["submitnonsens"])) {
	  if(!empty($_POST["nonsens2"])) {
		  //andmebaasi lisamine
		  //loome andmebaasi ühenduse
		  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
		  //valmistame ette SQL käsu
		  $stmt = $conn->prepare("INSERT INTO nonsens2 (nonsensidea) VALUES(?)");
		  echo $conn->error;
		  //s-string, i-integer, d-decimal
		  $stmt->bind_param("s", $_POST["nonsens2"]);
		  $stmt->execute();
		  echo "tegutse";
		  //käsk ja ühendus
		  $stmt->close();
		  $conn->close();
	  }
  }	  

  //vaatame, mida vormist serverile saadetakse
  //var_dump($_POST);

?>

  
  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner"> 
  <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  
  <ul>
    <li><a href="home.php">Avalehele</a></li>
  </ul>

  <form method="POST">
    <label>Sisesta oma tänane mõttetu mõte!</label>
	<input type="text" name="nonsens2" placeholder="mõttekoht">
	<input type="submit" value="Saada ära!" name="submitnonsens">
  </form>

  <p>Tagasi <a href="home.php">pealehele!</a></p>
</body>
</html>