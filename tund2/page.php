<?php

  require("../../../config.php");
  require("fnc_user.php");
  require("header.php");
  require("fnc_common.php");
  // Käivitame sessiooni
  session_start();
  
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  $monthdaynow = date("d");
  $timenow = date("H:i:s");
  
  //vaatame, mida vormist serverile saadetakse
  //var_dump($_POST);
  
  $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  
  //küsime nädalapäeva
  $weekdaynow = date("N");
  //küsime kuud
  $monthnow = date("n");
  //echo $weekdaynow;
  
  if($hournow < 6){
	  $partofday = "uneaeg";
  }
  if($hournow >= 6 and $hournow < 8){
	  $partofday = "hommikuste protseduuride aeg";
  }
  if($hournow >= 8 and $hournow < 18){
	  $partofday = "õppimise aeg";
  }
  if($hournow >=18 and $hournow < 22) {
	  $partofday = "puhkamisaeg";
  }
  if($hournow >=22) {
	  $partofday = "uneaeg";
  }
  
  $semesterstart = new DateTime("2020-8-31");
  $semesterend = new DateTime("2020-12-13");
  $semesterduration = $semesterstart->diff($semesterend);
  $semesterdurationdays = $semesterduration->format("%r%a");
  $today = new DateTime("now");
  $fromsemesterstart = $semesterstart->diff($today);
  $fromsemesterstartdays = $fromsemesterstart->format("%r%a");
  $semesterpercentage = 0;
  
  $semesterinfo = "Semester kulgeb vastavalt akadeemilisele kalendrile.";
  if($semesterstart > $today){
	  $semesterinfo = "Semester pole veel peale hakanud!";
  }
  if($fromsemesterstartdays === 0){
	  $semesterinfo = "Semester algab täna!";
  }
  if($fromsemesterstartdays > 0 and $fromsemesterstartdays < $semesterdurationdays){
	  $semesterpercentage = ($fromsemesterstartdays / $semesterdurationdays) * 100;
	  $semesterinfo = "Semester on kestnud juba " .$fromsemesterstartdays ." päeva, läbitud on " .$semesterpercentage ."%.";
  }
  if($fromsemesterstartdays == $semesterdurationdays){
	  $semesterinfo = "Semester lõppeb täna!";
  }
  if($fromsemesterstartdays > $semesterdurationdays){
	  $semesterinfo = "Semester on läbi saanud!";
  }
  
  //loen kataloogist piltide nimekirja
  //$allfiles = scandir("../vp_pics/");
  $allfiles = array_slice(scandir("../vp_pics/"), 2);
  //echo $allfiles; //massiivi nii näidata ei saa
  //var_dump($allfiles);
  //$allpicfiles = array_slice($allfiles, 2);
  //var_dump($allpicfiles);
  $allpicfiles = [];
  $picfiletypes = ["image/jpeg", "image/png"];
  //käin kogu massiivi läbi ja kontrollin iga üksikut elementi, kas on sobiv fail ehk pilt
  foreach ($allfiles as $file) {
	  $fileinfo = getImagesize("../vp_pics/" .$file);
	  if(in_array($fileinfo["mime"], $picfiletypes) == true) {
		  array_push($allpicfiles, $file);
	  }
  }
  
  //paneme kõik pildid järjest ekraanile
  //uurime, mitu pilti on ehk mitu faili on nimekirjas - massiivis
  $piccount = count($allpicfiles);
  //echo $piccount;
  //$i = $i + 1;
  //$i += 1;
  //$i ++;
  $imghtml = "";
  /*for($i = 0; $i < $piccount; $i ++) {
	  //<img src="../img/vp_banner.png" alt="tekst"> 
	  $picnum = mt_rand(0, ($piccount - 1));
	  $imghtml .= '<img src="../vp_pics/' .$allpicfiles[mt_rand(0, ($piccount -1))] .'" ';
	  $imghtml .= 'alt="Tallinna Ülikool">';
	  
	  } */
	   $imghtml .= '<img src="../vp_pics/' .$allpicfiles[mt_rand(0, ($piccount - 1))] .'" ';
       $imghtml .= 'alt="Tallinna Ülikool">';
 
  // Sisselogimise asjad
  $passworderror = "";
  $emailerror = "";
  $password = "";
  $email = "";
  if(isset($_POST["submituserdata"])){
	  if (!empty($_POST["emailinput"])){
		//$email = test_input($_POST["emailinput"]);
		$email = filter_var($_POST["emailinput"], FILTER_SANITIZE_EMAIL);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		} else {
		  $emailerror = "Palun sisesta õige kujuga e-postiaadress!";
		}		
	  } else {
		  $emailerror = "Palun sisesta e-postiaadress!";
	  }
	  
	  if (empty($_POST["passwordinput"])){
		$passworderror = "Palun sisesta salasõna!";
	  } else {
		  if(strlen($_POST["passwordinput"]) < 8){
			  $passworderror = "Liiga lühike salasõna!";
		  }
	  }
	  
	  if(empty($emailerror) and empty($passworderror)){
		  //echo "Jee" .$email .$_POST["passwordinput"];
		  $notice = signin($email, $_POST["passwordinput"]);
	  }
  }
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner"> 
  <h1>Veebiprogrammeerimine</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise aeg: <?php echo $weekdaynameset[$weekdaynow -1] .", " . $monthdaynow .". " . $monthnameset[$monthnow -1] ." kell ". $timenow . ", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>. 
  <?php echo "Parajasti on " .$partofday ."."; ?></p>
  <p><?php echo $semesterinfo; ?></p>
  
  <ul>
	<li><a href="profile.php">Kasutaja loomine</a></li>
  </ul>
  <hr>
  <p>Sisselogimine<p>
    <form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label for="emailinput">E-post: </label>
		<input type="email" name="emailinput" id="emailinput" placeholder="E-post" value="<?php echo $email; ?>">
		<span><?php echo $emailerror; ?></span>
		<br>
		<label for="passwordinput">Salasõna: </label>
		<input type="password" name="passwordinput" id="passwordinput" placeholder="Salasõna">
		<span><?php echo $passworderror; ?></span>
		<br>
		<input type="submit" name="submituserdata" value="Sisselogimine">
	</form>
  <hr>
  <?php echo $imghtml; ?>
</body>
</html>
