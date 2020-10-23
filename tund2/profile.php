<?php
  require("../../../config.php");
  require("fnc_common.php");
  require("fnc_user.php");
  
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $firstnameerror = "";
  $lastnameerror = "";
  $gendererror = "";
  $birthdateerror = "";
  $birthdayerror = "";
  $birthmontherror = "";
  $birthyearerror = "";
  $emailerror = "";
  $passworderror = "";
  $passwordsecondaryerror ="";
  $firstname = "";
  $lastname = "";
  $gender = "";
  $birthdate = null;
  $birthday = null;
  $birthmonth = null;
  $birthyear = null;
  $email = "";
  
  if(isset($_POST["profilesubmit"])){
	if(!empty($_POST["firstnameinput"]))  {
		$firstname = test_input($_POST["firstnameinput"]);
	} else {
		$firstnameerror = "Eesnimi puudub!";
	}	
	if(!empty($_POST["lastnameinput"]))  {
		$lastname = test_input($_POST["lastnameinput"]);
	} else {	
		$lastnameerror .= "Perekonnanimi puudub!";	
	}	
	if(isset($_POST["genderinput"]))  {
		$gender = intval($_POST["genderinput"]);
	} else {
		$gendererror .= "Sugu puudub!";
	}
	if(!empty($_POST["birthdayinput"])){
		$birthday = intval($_POST["birthdayinput"]);
	} else {
		$birthdayerror = "Palun vali oma sünnikuupäev!";
	}	
	if(!empty($_POST["birthmonthinput"])){
		$birthmonth = intval($_POST["birthmonthinput"]);
	} else {
		$birthmontherror = "Palun vali oma sünnikuu!";
	}
	if(!empty($_POST["birthyearinput"])){
		$birthyear = intval($_POST["birthyearinput"]);
	} else {
		$birthyearerror = "Palun vali oma sünniaasta!";
	}	
	// Kontrollime, kas sisestati reaalne kuupäev
	if(!empty($birthday) and !empty($birthmonth) and !empty($birthyear)){
		if(checkdate($birthmonth, $birthday, $birthyear)){
			$tempdate = new DateTime($birthyear ."-" .$birthmonth ."-" .$birthday);
			$birthdate = $tempdate->format("Y-m-d");
			//echo $birthdate;
		} else {
			$birthdateerror = "Kuupäev on vigane!";
		}
	}	
	
	if(!empty($_POST["emailinput"]))  {
		$email = test_input($_POST["emailinput"]);
	} else {	
		$emailerror .= "E-post puudub!";
	}	
	if(empty($_POST["passwordinput"]))  {
		$passworderror .= "Salasõna puudub!";
	} else {
			if(strlen($_POST["passwordinput"]) < 8){
				$passworderror = "Salasõna peab olema vähemalt 8 tähemärki pikk!";
			}
	}	
	if(empty($_POST["passwordsecondaryinput"])) {
		$passwordsecondaryerror .= "Salasõna kordus puudub!";
	} else {
		if($_POST["passwordsecondaryinput"] != $_POST["passwordinput"]){
			  $passwordsecondaryerror = "Sisestatud salasõnad ei olnud ühesugused!";
		  }
	  }
	  
	   if(empty($firstnameerror) and empty($lastnameerror) and empty($gendererror) and empty ($birthdayerror) and empty ($birthmontherror) and empty ($birthyearerror) and empty ($birthdateerror) and empty($emailerror) and empty($passworderror) and empty($passwordsecondaryerror)){
		$notice = signup($firstname, $lastname, $email, $gender, $birthdate, $_POST["passwordinput"]);
		//$notice = "Kõik ok!";
		if($notice == "ok"){
		  $firstname= "";
	      $lastname = "";
		  $gender = "";
		  $birthday = null;
		  $birthdate = null;
		  $birthmonth = null;
		  $birthyear = null;
		  $email = "";
		  $notice = "Kasutaja loomine õnnestus!";
		  } else {
			$notice = "Kahjuks tekkis tehniline viga";
	  }
  }
  }
	require("header.php");
?>

<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner"> 
  <h1>Kasutaja loomine</h1>
  <p>Tagasi <a href="page.php">pealehele!</a></p>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="firstnameinput">Eesnimi: </label>
	<input type="text" name="firstnameinput" id="firstnameinput" placeholder="Eesnimi" value="<?php echo $firstname; ?>">
	<span><?php echo $firstnameerror; ?></span>
	<br>
	<label for="lastnameinput">Perekonnanimi: </label>
	<input type="text" name="lastnameinput" id="lastnameinput" placeholder="Perekonnanimi" value="<?php echo $lastname; ?>">
	<span><?php echo $lastnameerror; ?></span>
	<br>
	<input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo " checked";}?>><label for="gendermale">Mees </label><input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo " checked";}?>><label for="genderfemale">Naine </label>
	<span><?php echo $gendererror; ?></span>
	<br>
	
	 <label for="birthdayinput">Sünnipäev: </label>
		  <?php
			echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
			echo '<option value="" selected disabled>päev</option>' ."\n";
			for ($i = 1; $i < 32; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthday){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		  ?>
	  <label for="birthmonthinput">Sünnikuu: </label>
	  <?php
	    echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
		echo '<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthmonth){
				echo " selected ";
			}
			echo ">" .$monthnameset[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label for="birthyearinput">Sünniaasta: </label>
	  <?php
	    echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <br>
	  <span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span>
	
	<br>
	<label for="emailinput">E-post: </label>
	<input type="email" name="emailinput" id="emailinput" placeholder="E-post" value="<?php echo $email; ?>">
	<span><?php echo $emailerror; ?></span>
	<br>
	<label for="passwordinput">Salasõna: </label>
	<input type="password" name="passwordinput" id="passwordinput" placeholder="Salasõna">
	<span><?php echo $passworderror; ?></span>
	<br>
	<label for="passwordsecondaryinput">Salasõna uuesti: </label>
	<input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput" placeholder="Salasõna uuesti">
	<span><?php echo $passwordsecondaryerror; ?></span>
	<br>
	<input type="submit" name="profilesubmit" value="Salvesta">

  </form>
  <hr>

</body>
</html>