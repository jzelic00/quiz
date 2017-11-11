<?php 
	session_start();
	include('config.php');
	$korOdgovori = $_REQUEST["korisnik"];
	$nizKorisnikovihOdgovora = explode(',', $korOdgovori);
	$nizTocnihOdgovora = $_SESSION['nizTocnihOdgovora'];
	$id = $_SESSION['ID']; 
	$i=0;
	$bodovi=0;
	$vrati = 0;
	$tocni=0;

	for($i=0;$i<4;$i++){
		if($nizKorisnikovihOdgovora[$i]==$nizTocnihOdgovora[$i]){
			$bodovi += 10;
			$tocni++;
			continue;
		}
		$bodovi -= 15;
	}
	

	$upit ="SELECT Bodovi as Bodovi FROM quiz_user WHERE ID=$id";
	$db_output = mysqli_query($connect, $upit);
	$count = $db_output->fetch_assoc();

	if($bodovi<=0){
		$bodovi = 0;
	}

	$vrati = $bodovi;
	$vrati = $vrati . "," . $tocni;

	$bodovi += $count['Bodovi'];
	
	$sql = "UPDATE quiz_user SET Bodovi=$bodovi WHERE ID=$id";
	mysqli_query($connect, $sql);

	//mysqli_close($conn);
	echo $vrati;
?>
