<?php
 
  $username = "Caroly Vilo";
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  $monthdaynow = date("d");
  $timenow = date("H:i:s");
  
  //vaatame, mida vormist serverile saadetakse
  //var_dump($_POST);
  
  $weekdaynameset = ["esmasp�ev", "teisip�ev", "kolmap�ev", "neljap�ev", "reede", "laup�ev", "p�hap�ev"];
  $monthnameset = ["jaanuar", "veebruar", "m�rts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  
  //k�sime n�dalap�eva
  $weekdaynow = date("N");
  //k�sime kuud
  $monthnow = date("n");
  //echo $weekdaynow;
  
  if($hournow < 6){
	  $partofday = "uneaeg";
  }
  if($hournow >= 6 and $hournow < 8){
	  $partofday = "hommikuste protseduuride aeg";
  }
  if($hournow >= 8 and $hournow < 18){
	  $partofday = "�ppimise aeg";
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
	  $semesterinfo = "Semester algab t�na!";
  }
  if($fromsemesterstartdays > 0 and $fromsemesterstartdays < $semesterdurationdays){
	  $semesterpercentage = ($fromsemesterstartdays / $semesterdurationdays) * 100;
	  $semesterinfo = "Semester on kestnud juba " .$fromsemesterstartdays ." p�eva, l�bitud on " .$semesterpercentage ."%.";
  }
  if($fromsemesterstartdays == $semesterdurationdays){
	  $semesterinfo = "Semester l�ppeb t�na!";
  }
  if($fromsemesterstartdays > $semesterdurationdays){
	  $semesterinfo = "Semester on l�bi saanud!";
  }
  
  //loen kataloogist piltide nimekirja
  //$allfiles = scandir("../vp_pics/");
  $allfiles = array_slice(scandir("../vp_pics/"), 2);
  //echo $allfiles; //massiivi nii n�idata ei saa
  //var_dump($allfiles);
  //$allpicfiles = array_slice($allfiles, 2);
  //var_dump($allpicfiles);
  $allpicfiles = [];
  $picfiletypes = ["image/jpeg", "image/png"];
  //k�in kogu massiivi l�bi ja kontrollin iga �ksikut elementi, kas on sobiv fail ehk pilt
  foreach ($allfiles as $file) {
	  $fileinfo = getImagesize("../vp_pics/" .$file);
	  if(in_array($fileinfo["mime"], $picfiletypes) == true) {
		  array_push($allpicfiles, $file);
	  }
  }
  
  //paneme k�ik pildid j�rjest ekraanile
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
	  $imghtml .= 'alt="Tallinna �likool">';
	  
	  } */
	   $imghtml .= '<img src="../vp_pics/' .$allpicfiles[mt_rand(0, ($piccount - 1))] .'" ';
       $imghtml .= 'alt="Tallinna �likool">';
 
  
  require("header.php");
  
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse b�nner"> 
  <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud �ppet�� k�igus ning ei sisalda mingit t�siseltv�etavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna �likooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise aeg: <?php echo $weekdaynameset[$weekdaynow -1] .", " . $monthdaynow .". " . $monthnameset[$monthnow -1] ." kell ". $timenow . ", semestri algusest on m��dunud " .$fromsemesterstartdays ." p�eva"; ?>. 
  <?php echo "Parajasti on " .$partofday ."."; ?></p>
  <p><?php echo $semesterinfo; ?></p>
  
  <ul>
    <li><a href="motetesisestus.php">M�tete sisestus!</a></li>
	<li><a href="motetelugemine.php">M�tete lugemine!</a></li>
	<li><a href="listfilms.php">Filmiinfo n�itamine</a></li>
	<li><a href="addfilms.php">Filmide lisamine</a></li>
  </ul>
  
  <hr>
  <?php echo $imghtml; ?>
</body>
</html>
