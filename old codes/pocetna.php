
<div class="wrapper">
	<div id="naslovna_box">
		<div id="naslovna_box_input">
			<div id="naslovna_box_naslov">Dobrodošli, <?php echo $_SESSION['login_username']; ?></div>
		</div>
		<a href="index.php?action=logout" title="Odjava" alt="Odjava">
			<button id="naslovna_box_button" type="submit" name="login_submit">
					<i class="fa fa-power-off fa-4x" aria-hidden="true"></i><br>
					<span>Odjava</span>
			</button>
		</a>
		<a href="index.php?action=nova_igra" title="Nova igra" alt="Nova igra">
		<button id="naslovna2_box_button" type="submit" name="login_submit">
				<i class="fa fa-plus-circle fa-4x" aria-hidden="true"></i><br>
				<span>Nova igra</span>
		</button>
		</a>
		<a href="index.php?action=profile" title="Profil korinika" alt="Profil korisnika">
		<button id="naslovna2_box_button" type="submit" name="login_submit">
				<i class="fa fa-user fa-4x" aria-hidden="true"></i><br>
				<span>Profil</span>
		</button>
		</a>
		<a href="index.php?action=lista_korisnika" title="Lista korisnika" alt="Lista korisnika">
			<button id="naslovna2_box_button" type="submit" name="login_submit">
					<i class="fa fa-list fa-4x" aria-hidden="true"></i><br>
					<span>Lista</span>
			</button>	
		</a>
		<a href="index.php?action=contact" title="Kontakt" alt="Kontakt">
		<button id="naslovna2_box_button" type="submit" name="login_submit">
				<i class="fa fa-phone-square fa-4x" aria-hidden="true"></i><br>
				<span>Kontakt</span>
		</button>	
		</a>
	</div>
	</div>
