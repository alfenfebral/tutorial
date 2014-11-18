<?php
   session_start();
   if(isset($_POST['kirim'])) {
   if($_SESSION['kodecap']==$_POST['kodeval']) {
      echo "Benar"; 
   } else {
      echo "Salah"; 
      }
   }
?>
<form id="FAcak" name="FAcak" method="post" action="./kirim.php">
	<p>
 	<input name="kodeval" type="text" id="kodeval" size="6" maxlength="6" />
 	<img src="kodeacak.php" width="75" height="25" alt="Kode Acak" />
	</p>
	<p><input type="submit" name="kirim" id="button" value="kirim" /></p>
</form>
<a href="./kirim.php">aaa</a>