<?php 
	session_start();
	include('config.php');



	$korOdgovori = $_REQUEST["korisnik"];
	$myArray = explode(',', $korOdgovori);
	$var_value = $_SESSION['varname'];
	$username = $_SESSION['login_username'];
	$id = $_SESSION['ID']; 

	$i=0;
	$bodovi=0;

	for($i=0;$i<4;$i++){
		if($myArray[$i]==$var_value[$i]){
			$bodovi = $bodovi + 25;
		}
	}

	/*
	$upit ="SELECT Bodovi as Bodovi FROM quiz_user WHERE ID=1";
	$db_output = mysqli_query($connect, $upit);
	$count = $db_output->fetch_assoc();

	$bodovi += $count['Bodovi'];

	*/
	$sql = "UPDATE quiz_user SET Bodovi=$bodovi WHERE ID=$id";

	if (mysqli_query($connect, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($connect);
}
	//$db_output = mysqli_query($connect, $sql);
	//mysqli_close($conn);

	echo $bodovi;

?>


	

	