<?php

  $username = "Caroly Vilo";
  //loeme andmebaasi login info muutujad
  require("../../../config.php");
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  $database = "if20_caroly_v_1";
  if(isset($_POST["submitnonsens"])) {
	  if(!empty($_POST["nonsens2"])) {
		  //andmebaasi lisamine
		  //loome andmebaasi �henduse
		  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
		  //valmistame ette SQL k�su
		  $stmt = $conn->prepare("INSERT INTO nonsens2 (nonsensidea) VALUES(?)");
		  echo $conn->error;
		  //s-string, i-integer, d-decimal
		  $stmt->bind_param("s", $_POST["nonsens2"]);
		  $stmt->execute();
		  echo "tegutse";
		  //k�sk ja �hendus
		  $stmt->close();
		  $conn->close();
	  }
  }	  

  //vaatame, mida vormist serverile saadetakse
  //var_dump($_POST);

?>

  
  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse b�nner"> 
  <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud �ppet�� k�igus ning ei sisalda mingit t�siseltv�etavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna �likooli</a> Digitehnoloogiate instituudis.</p>
  
  <ul>
    <li><a href="home.php">Avalehele</a></li>
  </ul>

  <form method="POST">
    <label>Sisesta oma t�nane m�ttetu m�te!</label>
	<input type="text" name="nonsens2" placeholder="m�ttekoht">
	<input type="submit" value="Saada �ra!" name="submitnonsens">
  </form>

  <p>Tagasi <a href="home.php">pealehele!</a></p>
</body>
</html>