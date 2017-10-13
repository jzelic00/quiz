<?php

	//include('config.php');
	$dept = array();
	$nizIskoristenih = array(0,0,0,0);
	$nizPitanja = array(0,0,0,0); //Zavisi od broja pitanja
	$nizTocnihOdgovora = array("","","",""); //Zavisno od broja pitanja
	$brojac = 0;
	$brojac2=0;
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
		
		//echo "Uslo u funkciju!";
		global $flag, $rndBroj, $brojac2, $nizIskoristenih, $brojOdgovora;
		$brojac2=0;
		for($z=0; $z<$brojOdgovora; $z++)
		{
			$nizIskoristenih[$z]=0;
		}
		while($brojac2 < $brojOdgovora){
		$flag = true;
		$rndBroj = rand(1,4);
		//echo "op: $rndBroj";
		for($j=0; $j<4; $j++){
			if($nizIskoristenih[$j] == $rndBroj){
				$flag = false;
				break;
			}
		}
		if($flag){
			$nizIskoristenih[$brojac2]=$rndBroj;
			//echo "$nizIskoristenih[$brojac2]";
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
<div class="wrapper">
	<div id="obican_box">
			<div id="obican_box_naslov">
			<button id="obican_box_button" type="submit">
				<a href="index.php" title="Povratak na početnu stranicu">
				<i class="fa fa-arrow-left fa-1x" aria-hidden="true"></i></a><br>
			</button>
			Nova igra
			</div>
			
			<form id="form1" action="index.php?action=nova_igra" method="POST">	
				<?php
					for($i=0; $i< $brojOdgovora; $i++)
					{
						$b=$i+1;
						global $imePitanja;
						PostaviPitanje();
							echo '
							<div id="div'.$i.'">
								<div id="nova_igra_box2">
									<div id="igra_broj">'.$b.'</div>
									<div id="nova_igra_pitanje">
										 '. $red["Pitanje"] . '<br><br>
									<span>
										<button class="butt_new" type="button" name="'.$imePitanja. '" value="' . $odgovor1 . '" onclick="myFunction(value)"> '. $odgovor1 . '</button><br>
										<button class="butt_new" type="button" name="'.$imePitanja. '" value="' . $odgovor2 . '" onclick="myFunction(value)"> '. $odgovor2 . '</button><br>
										<button class="butt_new" type="button" name="'.$imePitanja. '" value="' . $odgovor3 . '" onclick="myFunction(value)"> '. $odgovor3 . '</button><br>
										<button class="butt_new" type="button" name="'.$imePitanja. '" value="' . $odgovor4 . '" onclick="myFunction(value)"> '. $odgovor4 . '</button><br>
									</span>
									</div>
								</div>
							</div>';								
						$imePitanja++;
					};



					
					//Klik na button 
					if(isset($_POST['posalji_formu']))
					{	
						//global $nizTocnihOdgovora;
						$odg1 = $_POST['1'];
						$odg2 = $_POST['2'];
						$odg3 = $_POST['3'];
						$odg4 = $_POST['4'];
						$totalBod=0;
						
						if($odg1 == "" || $odg2 == "" || $odg3 == "" || $odg4 == "")
						{
							echo "Niste odgovorili na sva pitanja!";
						}
						else
						{
							$op1 =$nizTocnihOdgovora[0];
							$op2 =$nizTocnihOdgovora[1];
							$op3 =$nizTocnihOdgovora[2];
							$op4 =$nizTocnihOdgovora[3];
							if($op1 == $odg1) 
								$totalBod++;	
							if($op2 == $odg2) 
								$totalBod++;											
							if($op3 == $odg3) 
								$totalBod++;														
							if($op4 == $odg4) 
								$totalBod++;
								
		
							echo "Broj tocnih odgovora je: ".$totalBod;
						}
						
					}
					else
					{
						echo "Niste odgovorili na sva pitanja!";
					}

						
									
				?>
			<button type="button" name="konacni" value="konacno" onclick="Ispis()">Rezultat</button>
			<!--<button type="button" name="zadnji" value="zadnje" onclick="Popunjavanje()">Ucitaj</button>-->
						
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

				function Popunjavanje(){
					//window.alert("Odgovori nisu ucitani!");

					j=0;
					var pokusaj1 = "<?php echo $nizTocnihOdgovora[0] ?>";
					var pokusaj2 = "<?php echo $nizTocnihOdgovora[1] ?>";
					var pokusaj3 = "<?php echo $nizTocnihOdgovora[2] ?>";
					var pokusaj4 = "<?php echo $nizTocnihOdgovora[3] ?>";

					
					window.alert("Odgovor 1:"+pokusaj1);
					window.alert("Odgovor 2:"+pokusaj2);
					window.alert("Odgovor 3:"+pokusaj3);
					window.alert("Odgovor 4:"+pokusaj4);
				}


				function myFunction(vrijednost) {
					//	window.alert("Kliknuto je: "+vrijednost);
					nizOdgovora[i] = vrijednost;
					//i++;
					if(i==3) {
						for(i=0;i<4;i++){
							if(nizOdgovora[i]==nizTocnihOdgovora[i])
								bodovi += 25;
						}
						window.alert("Ukupno bodova: " + bodovi);
						location.reload();

					}
					else {
						document.getElementById('div'+i).style.display = "none";
						i++;
						document.getElementById('div'+i).style.display = "block";
					}
					
					
					


				}

				function Ispis(){				
					nizTacnihOdgovora[0] = "<?php echo $nizTocnihOdgovora[0] ?>";
					nizTacnihOdgovora[1] = "<?php echo $nizTocnihOdgovora[1] ?>";
					nizTacnihOdgovora[2] = "<?php echo $nizTocnihOdgovora[2] ?>";
					nizTacnihOdgovora[3] = "<?php echo $nizTocnihOdgovora[3] ?>";
					

					if(nizOdgovora[0]==nizTacnihOdgovora[0])
						bodovi ++;
					if(nizOdgovora[1]==nizTacnihOdgovora[1])
						bodovi ++;
					if(nizOdgovora[2]==nizTacnihOdgovora[2])
						bodovi ++;
					if(nizOdgovora[3]==nizTacnihOdgovora[3])
						bodovi ++;

					window.alert("Tocnih odgovora je: "+bodovi);
					
					
					window.location.href = "index.php";
				}

			</script>
		</div>	
	</div>
	</div>