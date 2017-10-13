<?php
	//REGISTER FORMA!!!!!
	include('config.php');
	
	//KAD SE KLIKNE NA Registracija gumb!!!
	if(isset($_POST['register_submit']))
	{
		$username 			= $_POST['username_reg'];
		$password 			= md5($_POST['password_reg']);
		$repeat_password 	= md5($_POST['repeat_pass_reg']);
		$email				= $_POST['email_reg'];
		$name				= $_POST['name_reg'];
		
		//Ako su lozinke iste uđi ovde!!
		if($password == $repeat_password)
		{
			//Dohvaca iz baze sve korisnike sa IMENOM i EMAILom!!!
			$korisnik = mysqli_query($connect, 
			"
				SELECT * FROM `quiz_user`
				WHERE `Username` = '$username'
				OR `E-mail` = '$email'
			");
			$brojac = mysqli_num_rows($korisnik);
			
			//Ako korisnik ne postoji uđi ovde
			if($brojac == 0)
			{
					mysqli_query($connect, 
					"
						INSERT INTO `quiz_user`
						SET `Username` = '$username',
							`Password` = '$password',
							`E-mail` = '$email',
							`Name` = '$name',
							`IP` = '".$_SERVER['REMOTE_ADDR']."'
					");
					include('reg_ok.php');
			}
			//Ako vec postoji korisnicko ime ili mail ispisi ovo
			else
			{
				echo '<div id="reg_errorBox">Korisničko ime ili E-mail je već u uporabi!</div>';	
			}
		}
		else
		{
			echo '<div id="reg_errorBox">Greska! Lozinke nisu iste!</div>';
		}		
	}
?>
<form method="POST" action="index.php?action=register">
	<div id="register_box_naslovcek">
		<div id="register_box_naslov">Registriraj se</div>
	</div>
	
	<div id="register_box">	
		<div id="register_box_input">
			<div id="opa">
				<span>Korisničko ime</span><br>
				<input id="register_input" name="username_reg" type="text"  pattern=".{0}|.{4,32}" required  title="Korisničko ime mora biti veće od 3, a manje od 32 znaka!">
			</div>
			<div id="opa">
				<span>Lozinka</span><br>
				<input id="register_input" name="password_reg" type="password" required>
			</div>
			<div id="opa">
				<span>Ponovi lozinku</span><br>
				<input id="register_input" name="repeat_pass_reg" type="password" required>
			</div>
			<div id="opa">
				<span>E-mail</span><br>
				<input id="register_input" name="email_reg" type="email" required>
			</div>
			<div id="opa">
				<span>Ime i Prezime</span><br>
				<input id="register_input" name="name_reg" type="text" required>
			</div>
			<button id="register_box_button" type="submit" name="register_submit">
				<span>Registriraj se</span>
				<i class="fa fa-arrow-right fa-1x" aria-hidden="true"></i><br>
			</button>
			
		</div>
	</div>
		 

</form>