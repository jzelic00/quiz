
<?php

	include('config.php');
	
	if(isset($_POST['forget_submit']))
	{
		$email = $_POST['forget_email'];
		$submit=$_POST['forget_submit'];

	

		//Provjera maila!!
		$check_mail = mysqli_query($connect,"SELECT * FROM `quiz_user`WHERE `E-mail` = '$email'");
		$brojac = mysqli_num_rows($check_mail);

		if(!$brojac != 0)
		{
			$random = rand(72891, 92729);
			$new_password = $random;
			
			$email_password = $new_password;
			
			$new_password = md5($new_password);
			
			mysqli_query($connect,"UPDATE `quiz_user` SET `Password` = '$new_password' WHERE WHERE `E-mail` = '$email'");
		}
		else
		{
			echo  "Niste unijeli valjani e-mail!";
		}
	}

	
	
?>
<html>

<body>

<form method="post" action="index.php?action=forget_password">
	E-mail<input type="text" name="forget_email"><br>
	<input type="submit" name="forget_submit" value="Pošalji">
</form>
</body>
</html>