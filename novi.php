<?php

	$dept = array();
	$nizIskoristenih = array(0,0,0,0);
	$nizPitanja = array(0,0,0,0); //Zavisi od broja pitanja
	$nizTocnihOdgovora = array("","","",""); //Zavisno od broja pitanja
	$brojac = 0;
	$flag = false;
	$rndBroj = 0;
	$brPitanja=0; //Broj pitanja
	$brojOdgovora=4;
	$indexTocnogOdgovora=0;
	$j = 0;
	$imePitanja=1;

	//Random odgovori!!!!!
	function RandomOdgovori()
	{
		global $flag, $rndBroj, $nizIskoristenih, $brojOdgovora;
		$brojac2=0;
		for($z=0; $z<$brojOdgovora; $z++)
		{
			$nizIskoristenih[$z]=0;
		}
		while($brojac2 < $brojOdgovora){
		$flag = true;
		$rndBroj = rand(1,4);

		for($j=0; $j<4; $j++){
			if($nizIskoristenih[$j] == $rndBroj){
				$flag = false;
				break;
			}
		}
		if($flag){
			$nizIskoristenih[$brojac2]=$rndBroj;
			$brojac2++;
		}
		}
	}
	
	$brojac = 0;
	while($brojac < $brojOdgovora){
		$flag = true;
		$rndBroj = rand(1,7);
		for($j=0; $j<4; $j++){
			if($nizPitanja[$j] == $rndBroj){
				$flag = false;
				break;
			}
		}
		if($flag){
			$nizPitanja[$brojac] = $rndBroj;
			$brojac++;
		}
	}
	
	//$randPitanje = rand(1,7);
	function PostaviPitanje()
	{
		global $nizPitanja;
		global $brPitanja;
		global $dept;
		global $nizIskoristenih;
		global $odgovor1; //Pitanje
		global $odgovor2;
		global $odgovor3;
		global $odgovor4;
		global $db_output;
		global $red;
		global $sql;
		global $connect;
		global $nizTocnihOdgovora;
		global $indexTocnogOdgovora;
		$sql = "SELECT * FROM `quiz_question` WHERE `ID`=$nizPitanja[$brPitanja]";
		$db_output = mysqli_query($connect, $sql);
		
		$red = mysqli_fetch_assoc($db_output);
		//$brojac = mysqli_num_rows($db_output);
						
		
		
		$dept[0] = 0;	
		$dept[1] = $red['TocanOdgovor'];
		$nizTocnihOdgovora[$indexTocnogOdgovora] = $dept[1];
		$indexTocnogOdgovora++;
		$dept[2] = $red['Odgovor2'];
		$dept[3] = $red['Odgovor3'];
		$dept[4] = $red['Odgovor4'];
		RandomOdgovori();
		$odgovor1 = $dept[$nizIskoristenih[0]]; //Pitanje
		$odgovor2 = $dept[$nizIskoristenih[1]];
		$odgovor3 = $dept[$nizIskoristenih[2]];
		$odgovor4 = $dept[$nizIskoristenih[3]];
		$brPitanja++;
	}


?>

<form id="form1" action="index.php?action=nova_igra" method="POST">	
				<?php
					for($i=0; $i< $brojOdgovora; $i++)
					{
						$b=$i+1;
						global $imePitanja;
						PostaviPitanje();
							echo '
							<div id="div'.$i.'">
									<div class="naslov">
										 '. $red["Pitanje"] . '
									</div>
									<div class="gumbici">
										<button type="button" class="button" name="'.$imePitanja. '" value="' . $odgovor1 . '" onclick="myFunction(value)"> '. $odgovor1 . '</button><br>
										<button type="button" class="button" name="'.$imePitanja. '" value="' . $odgovor2 . '" onclick="myFunction(value)"> '. $odgovor2 . '</button><br>
										<button type="button" class="button" name="'.$imePitanja. '" value="' . $odgovor3 . '" onclick="myFunction(value)"> '. $odgovor3 . '</button><br>
										<button type="button" class="button" name="'.$imePitanja. '" value="' . $odgovor4 . '" onclick="myFunction(value)"> '. $odgovor4 . '</button><br>
									</div>
							</div>';								
						$imePitanja++;
					};
						
									
				?>
<script>
				var nizOdgovora = ["","","",""];
				var nizTacnihOdgovora = ["","","",""];
				var i = 0;
				var j = 0;
				var bodovi = 0;
				var pokusaj1=0;
				var pokusaj2=0;
				var pokusaj3=0;
				var pokusaj4=0;
				//' . $odgovor1 . '

				function myFunction(vrijednost) {
					//	window.alert("Kliknuto je: "+vrijednost);
					nizOdgovora[i] = vrijednost;
					//i++;
					if(i==3) {
						nizTacnihOdgovora[0] = "<?php echo $nizTocnihOdgovora[0] ?>";
						nizTacnihOdgovora[1] = "<?php echo $nizTocnihOdgovora[1] ?>";
						nizTacnihOdgovora[2] = "<?php echo $nizTocnihOdgovora[2] ?>";
						nizTacnihOdgovora[3] = "<?php echo $nizTocnihOdgovora[3] ?>";
						for(i=0;i<4;i++){
							if(nizOdgovora[i]==nizTacnihOdgovora[i])
								bodovi += 25;
						}
						window.alert("Ukupno bodova: " + bodovi);
						window.location.href = "index.php";
					}
					else {
						document.getElementById('div'+i).style.display = "none";
						i++;
						document.getElementById('div'+i).style.display = "block";
					}
					
					
					
				}
				
</script>