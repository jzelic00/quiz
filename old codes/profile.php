<?php
	//Profilna stranica
	if(isset($_GET['pid']))
	{
		//profil drugog registriranog korisnika
	}
	else
	{
		
		$sql = "SELECT * FROM `quiz_user` WHERE `ID` = $korisnik";
		$db_output = mysqli_query($connect, $sql);
		$brojac = mysqli_num_rows($db_output);
	}

?>