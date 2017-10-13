<?php
	if(isset($_GET['action']))
	{
		if($_GET['action'] == 'admin')
		{
			echo ' <title>Admin Panel</title>';
		}
		else if($_GET['action'] == 'profile')
		{
			echo ' <title>Profil</title>';
		}
		else if($_GET['action'] == 'contact')
		{
			echo ' <title>Kontakt</title>';
		}
		else if($_GET['action'] == 'register')
		{
			echo ' <title>Registracija</title>';
		}
		else if($_GET['action'] == 'login')
		{
			echo ' <title>Prijava</title>';
		}
		else if($_GET['action'] == 'logout')
		{
			echo ' <title>Odjava</title>';
		}	
	}
	else
	{ 
	
		echo ' 
		<title>Quiz</title>';
	}
	echo '
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="slike/favicon.ico" type="image/x-icon"/>
	<link type="text/css" rel="stylesheet" href="stil.css"/>
	<link type="text/css" rel="stylesheet" href="responsive.css"/>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
	<script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
	<script> 
		$(document).ready(function(){
			$("#register_box_naslov").click(function(){
				$("#register_box").toggle();
			});
		});
	</script>
	';

?>