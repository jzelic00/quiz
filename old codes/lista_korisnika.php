<div class="wrapper">
		<div id="boxonja">
			<div id="boxonja_naslov">Lista korisnika</div>
			<button id="boxonja_button" type="submit">
				<a href="index.php" title="Povratak na početnu stranicu">
				<i class="fa fa-arrow-left fa-1x" aria-hidden="true"></i></a><br>
			</button>
			<table id="table_lista" width="90%" align="center">
<tr>
		<td id="table_lista_naslov"></td>
		<td id="table_lista_naslov" width="30%">Korisničko ime</td>
		<td id="table_lista_naslov">E-mail</td>
		<td id="table_lista_naslov" width="40%">Ime i prezime</td>
		<td id="table_lista_naslov">Broj bodova</td>
	</tr>
<?php

	//Lista korisnika
	include('config.php');
	
	$sql = "SELECT * FROM `quiz_user`";
	$db_output = mysqli_query($connect, $sql);
	$brojac = mysqli_num_rows($db_output);

	//echo "Dobijeno redova: " . $brojac;
	
	$a=0;
	
	while ($red = mysqli_fetch_assoc($db_output)) {
		$a=$a+1;
		if($a % 2 == 0)
		{
			echo "<tr>";
			echo "<td align='center' id='parni_boxonja'>$a.</td>"; 
			echo "<td id='parni_boxonja'> " . $red["Username"] . " </td>";
			echo "<td id='parni_boxonja'> " . $red["E-mail"] . " </td>";
			//Ime i prezime
			if($red["Name"] == "")
				echo "<td id='parni_boxonja' align='center'> - </td>";
			else
				echo "<td id='parni_boxonja'> " . $red["Name"] . " </td>";
			echo "<td id='parni_boxonja'> <center>-</center> </td>";
			echo "</tr>";
		}
		else
		{
			echo "<tr>";
			echo "<td align='center'>$a.</td>"; 
			echo "<td> " . $red["Username"] . " </td>";
			echo "<td> " . $red["E-mail"] . " </td>";
			//Ime i prezime
			if($red["Name"] == "")
				echo "<td align='center'> - </td>";
			else
				echo "<td> " . $red["Name"] . " </td>";
			echo "<td> <center>-</center> </td>";
			echo "</tr>";
		}
    }
?>
</table>			
			
		</div>	
	</div>
	</div>

<table>



