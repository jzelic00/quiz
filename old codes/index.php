<?php
	session_start();

	//povezivanje na bazu
	include('config.php');
	include('head.php');
	
	//KADA JE KORISNIK PRIJAVLJEN!!!!!
	if(isset($_SESSION['login_username']))
	{
		?>
		<a href="index.php">Početna</a> |
		<a href="index.php?action=profil">Profil</a> |
		<a href="index.php?action=lista_korisnika">Korisnici</a> |
		<a href="index.php?action=oops">Oops</a> |
		<a href="index.php?action=logout">Odjava</a> 
		<hr>
		<?php
		if(isset($_GET['action']))
		{
			$fajl = $_GET['action'] . ".php";
			if(file_exists($fajl))
				include_once($fajl); 
			else
				include('404.php'); //Kada stanica ne postoji!!
		}
		else
		{
			include('pocetna.php');
		}
	}
	//PREGLEDAVANJE STRANICE KAO "GOST"
	else
	{

		?>
		<a href="index.php">Početna</a> |
		<a href="index.php?action=login">Prijava</a> |
		<a href="index.php?action=register">Registracija</a> 
		<hr>
		<div class="wrapper">
			<?php include('login.php'); ?>
		
			<?php include('register.php'); ?>
			
		</div>
		<?php
	}

?>