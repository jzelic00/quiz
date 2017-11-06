<?php

	// Ako zelimo mijenjati broj pitanja koje zelimo imati u igri, moramo promjeniti neke stvari
	// U PHP DIJELU TREBA PROMJENITI SLJEDECE:
	// 		- broj elemenata niza nizPitanja (broj elemenata = broju pitanja koliko zelimo po igri)
	//		+ broj elemenata niza nizTocnihOdgovora ( broj elemenata = broj elemenata niza nizPitanja)
	//		- vrijednost varijable brojPitanja (ista broju elemenata gornjih nizova)
	// U JAVASCRIPT DIJELU TREBA PROMIJENITI SLJEDECE:
	//  	+ broj elemenata niza nizTacnihOdgovora treba imati isti broj elemenata kao nizovi u PHP dijelu (nizPitanja i nizTocnihOdgovora)
	//		+ broj elemenata niza nizOdgovora treba imati isti broj elemenata kao nizTacnihOdgovora
	//		- ucitati dodatne tocne odgovore u nizTacnihOdgovora
	//		+ vrijednost do koje brojac "i" treba ici (onoliko koliko ima pitanja, tj. vrijednost varijable brojPitanja)
	//		+ promjeniti uvjet if grananja (i treba provjeravat je li isti kao brojPitanja - 1) 
	//------------------------------------------- 

	$dept = array();
	$nizIskoristenih = array(); // Broj elemenata ovog niza ovisi o tome koliko cemo odgovora ponuditi korisniku na izbor (fixno 4)
	$nizPitanja = array(0,0,0,0); // Broj elemenata niza ovisi o tome koliko pitanja zelimo staviti po igri
	$nizTocnihOdgovora = array(); // Broj elemenata ovog niza mora biti jednak broju elemenata niza nizPitanja, jer za svako pitanje 										  // moramo imati tocan odgovor
	$indexPitanja=0; // Varijabla pomocu koje cemo prolaziti kroz nizPitanja kako bismo iskoristili random generirane ID-eve
	$brojOdgovora=4; // Varijabla koja oznacava koliko ce korisniku biti ponudeno odgovora (u ovom slucaju, kako nudimo samo a,b,c,d opciju)
					 // ova varijabla je uvijek 4, neovisno o broju pitanja; broj je jednak broju elemenata niza nizIskoristenih
	$brojPitanja=4;  // Varijabla koj oznacava koliko ce biti pitanja po igri
	$indexTocnogOdgovora=0; // Varijabla pomocu koje cemo prolaziti kroz nizTocnihOdgovora kako bismo iskoristili random generirane brojeve
							// za raspored odgovora koji ce biti ponudeni korisniku

	// U nizIskoristenih cemo spremiti 4 broja
	// Ta 4 broja ce biti u rangeu od 1 do 4
	// To nam sluzi kako bismo izmjesali odgovore u odnosu na njihov polozaj u bazi podataka
	// Samim time cemo postici da i ako se u nekoj drugoj igri ponovi isto pitanje, raspored odgovora ne bude isti kao u 
	// 		prethodnom pojavljivanju pitanja.
	//------------------------------------------- 		
	function RandomOdgovori(){
		global $nizIskoristenih, $brojOdgovora, $brojPitanja;
		
		$brojac2 = 0;
		$flag = false;
		$rndBroj = 0;

		// Postavljanje svih clanova niza na vrijednost 0 
		for($z=0; $z<$brojOdgovora; $z++){
			$nizIskoristenih[$z] = 0;
		}


		// Algoritam za generiranje niza random brojeva u odredenom rasponu
		// Posto znamo da cemo korisniku na izbor ponuditi 4 odgovora, radimo glavnu petlju koja ce se provrtiti 4 puta
		// Brojac pocinje od 0, sto znaci da ce imati vrijednosti 0,1,2,3 sto ce ujedno biti i indexi na koje cemo spremati 
		// 		random brojeve
		// Na samom pocetku flag je postavljen na true i potom generiramo neki random broj u intervalu od 1 do 4
		// Zatim prolazimo kroz sam niz u koji spremamo te random brojeve, te ako naidemo na taj random broj koji smo generirali
		// 		par linija iznad, flag postavljamo na false i izlazimo iz te petlje jer ne smijemo imati u nizu vise puta isti broj
		// U if-u provjeravamo sam flag, ako je true, znaci da u dosadasnjem nizu nismo naisli na generirani random broj te ga mozemo
		//		smjestiti u niz, povezati brojac da pokazuje na iduce mjesto u nizu i krenuti sa generiranjem novog random broj
		//-------------------------------------------
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
				$nizIskoristenih[$brojac2] = $rndBroj;
				$brojac2++;
			}
		}
	}
	
	// Koristimo isti algoritam za generiranje niza random brojeva
	// Samo u ovom slucaju raspon je od broja 1 do N (N oznacava broj pitanja u bazi podataka)
	// Ovisno koliko zelimo pitanja imati po igri, mijenjamo vrijednost varijable $brojOdgovora
	// 		takoder trebamo i promjeniti do kojeg broja treba ici $j (treba biti isti broj kao varijabla $brojOdgovora) 
	// Ovo nam sluzi kako bismo iz baze povukli random pitanja, tj. da se ne desi da u svakoj igri budu ista pitanja
	//-------------------------------------------
	$brojac = 0;
	while($brojac < $brojPitanja){
		$flag = true;
		$rndBroj = rand(1,7);
		for($j=0; $j<$brojPitanja; $j++){
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
	
	// Ovo funkcijom dohvacamo pitanje iz baze podataka
	// U nizPitanja imamo rasporedene random brojeve koji oznacavaju ID-ove pitanja koje cemo povuci iz baze podataka
	//------------------------------------------- 
	function PostaviPitanje(){
		global $nizPitanja;
		global $indexPitanja;
		global $dept;
		global $nizIskoristenih;
		global $odgovor1;
		global $odgovor2;
		global $odgovor3;
		global $odgovor4;
		global $db_output;
		global $red;
		global $sql;
		global $connect;
		global $nizTocnihOdgovora;
		global $indexTocnogOdgovora;

		// Spajanje na bazu, sa sql upitom, fohvacamo pitanje sa ID-em kojeg smo random generirali
		// Citav output se sprema u red kao string, pa tako moramo iz varijable $red izvuci odgovore i spremiti u odvojene varijable
		//------------------------------------------- 
		$sql = "SELECT * FROM `quiz_question` WHERE `ID`=$nizPitanja[$indexPitanja]";
		$db_output = mysqli_query($connect, $sql);
		$red = mysqli_fetch_assoc($db_output);
					
		// Odgovore najprije spremamo po tocnom redoslijedu kako se izvlace iz baze
		// Potom nakon poziva funkcije RandomOdgovori() varijable odgovor1, odgovor2, odgovor3 i odgovor4 dobijaju izmjesane
		//	  odgovore po gore generiranim random indexima
		// Na kraju povecavamo brojac (indexPitanja) da prede na izvlacenje iduceg pitanja iz baze
		//------------------------------------------- 
		$dept[0] = 0;	
		$dept[1] = $red['TocanOdgovor'];
		$nizTocnihOdgovora[$indexTocnogOdgovora] = $dept[1];
		$indexTocnogOdgovora++;
		$dept[2] = $red['Odgovor2'];
		$dept[3] = $red['Odgovor3'];
		$dept[4] = $red['Odgovor4'];
		RandomOdgovori();
		$odgovor1 = $dept[$nizIskoristenih[0]];
		$odgovor2 = $dept[$nizIskoristenih[1]];
		$odgovor3 = $dept[$nizIskoristenih[2]];
		$odgovor4 = $dept[$nizIskoristenih[3]];
		$indexPitanja++;
	}

?>

<form id="form1" action="index.php?action=nova_igra" method="POST">	
				<?php
					for($i=0; $i< $brojPitanja; $i++)
					{
						$b=$i+1;
						PostaviPitanje();
							echo '
							<div id="div'.$i.'">
									<div class="naslov">
										 '. $red["Pitanje"] . '
									</div>
									<div class="gumbici">
										<button type="button" class="butt_new" value="' . $odgovor1 . '" onclick="myFunction(value)"> '. $odgovor1 . '</button><br>
										<button type="button" class="butt_new" value="' . $odgovor2 . '" onclick="myFunction(value)"> '. $odgovor2 . '</button><br>
										<button type="button" class="butt_new" value="' . $odgovor3 . '" onclick="myFunction(value)"> '. $odgovor3 . '</button><br>
										<button type="button" class="butt_new" value="' . $odgovor4 . '" onclick="myFunction(value)"> '. $odgovor4 . '</button><br>
									</div>
							</div>';								
					};
					$_SESSION['varname'] = $nizTocnihOdgovora;					
				?>
<script>
	var nizOdgovora = [];
	var nizTacnihOdgovora = [];
	var i = 0;
	var bodovi = 0;
	var brPitanja = "<?php echo $brojPitanja ?>";

	// U nizTacnihOdgovora spremamo sve tocne odgovore koje smo povukli iz baze koje cemo kasnije iskoristiti za usporedbu
	// 		sa unesenim odgovorima korisnika (korisnikove odgovore spremamo u nizOdgovora)
	// Svaki put kada se klikne neki odgovor, poziva se ova funkcija i sprema kliknutu vrijednost u nizTacnihOdgovora
	// 		te trenutno pitanje mice sa ekrana, a prikazuje iduce
	// Sa i dodatno provjeravamo je li doslo do zadnjeg pitanja, ako jest onda se poziva provjera unesenih odgovora sa tocnim 
	// 		odgovorima, zbrajaju bodovi, ispisuju korisniku te ga se vraca u glavni izbornik
	//-------------------------------------------
	function myFunction(vrijednost) {
		nizOdgovora[i] = vrijednost;
		if(i==(brPitanja - 1)) {

			var xmlhttp = new XMLHttpRequest();
       		xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	            	console.log('Uslo u if');
	            	console.log('varijabla is PHP: '+this.responseText);
	                //document.getElementById("txtHint").innerHTML = this.responseText;
	            }
        	};
        	xmlhttp.open("GET", "calculate.php?korisnik="+nizOdgovora, false);
       		xmlhttp.send();

			/*nizTacnihOdgovora[0] = "<?php echo $nizTocnihOdgovora[0] ?>";
			nizTacnihOdgovora[1] = "<?php echo $nizTocnihOdgovora[1] ?>";
			nizTacnihOdgovora[2] = "<?php echo $nizTocnihOdgovora[2] ?>";
			nizTacnihOdgovora[3] = "<?php echo $nizTocnihOdgovora[3] ?>";
			for(i=0;i<brPitanja;i++){
				if(nizOdgovora[i]==nizTacnihOdgovora[i])
					bodovi += 25;
			}*/
			//console.log(nizOdgovora);
			//window.alert("Ukupno bodova: " + bodovi);
			window.alert("IGRA ZAVRSENA!");
			window.location.href = "index.php";
		}
		else {
			document.getElementById('div'+i).style.display = "none";
			i++;
			document.getElementById('div'+i).style.display = "block";
		}
	}
</script>