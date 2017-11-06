<?php
	//LOGIN FORMA!!!!!
	include('config.php');
	
	//Kada je gumb "PRIJAVA" kliknnut
	if(isset($_POST['login_submit']))
	{
		$username = $_POST['login_username'];
		$password = md5($_POST['login_password']);
		
		//Ako su polja prazna
		if($username && $password)
		{
			//Dohvaca iz baze korisnika i password njegov
			$korisnik = mysqli_query($connect, 
			"
				SELECT * FROM `quiz_user`
				WHERE `Username` = '$username'
				AND `Password` = '$password'
			");
			//$brojac = mysqli_num_rows($korisnik);
			//if($brojac == 0)
			if(!$red = mysqli_fetch_assoc($korisnik))
			{
				echo '<div id="errorBox">Pogrešno ste unijeli korisničko ime ili lozinku!</div>';
			}
			else
			{
				//upijesna prijava
				$_SESSION['ID'] = $red['ID'];
				header("Location:index.php");
			}
		}
		else
		{
			echo '<div id="errorBox">Upišite korisničko ime i lozinku!</div>';
		}
	}

?>

<form method="POST" action="index.php?action=login">
	<div id="login_box">
		<div class="login_box_input">
			<div id="login_box_naslov">Prijava</div>
			<div id="op">
				<span>Korisničko ime</span><br>
				<input id="login_input" type="text" name="login_username">
			</div>
			<div id="op">
				<span>Lozinka</span><br>
				<input id="login_input" type="password" name="login_password">
			</div>
			<div id="zaboravljenaLozinka"><a href="forget_password.php">Zaboravljena lozinka?</a></div>
		</div>
		<button class="login_box_button" type="submit" name="login_submit">
				<i class="fa fa-sign-in fa-4x" aria-hidden="true"></i><br>
				<span>Prijava</span>
		</button>		
	</div>
</form>
