<html>
</head>
	<title>Mein Bereich - Registrieren</title>
</head>
<body>
	<h3>Registrieren</h3>
	<?php
		if(!isset($_GET["page"])) {
	?>
	<form method="post" action="sign_up.php?page=2">
		first_name:<input type="text" name="first_name" placeholder="first name" required/><br /> 
		last_name:<input type="text" name="last_name" placeholder="last name" required/><br /> 
		email: <input type="text" name="email" placeholder="email" required/><br /> 
		place: <input type="text" name="place" placeholder="place" required/><br /> 
		postcode: <input type="text" name="postcode" placeholder="postcode" required/><br />
		street: <input type="text" name="street" placeholder="street" required/><br />
		house_number: <input type="text" name="house_number" placeholder="house number" required/><br />
		date_of_birth: <input type="text" name="date_of_birth" placeholder="dd.mm.yyyy" required/><br />
		password:<input type="password" name="password" placeholder="password" required/><br />
		password repeat:<input type="password" name="password2" placeholder="password repeat" required/><br />
		<input type="submit" value="Senden" />
	</form>
		<?php
		}
		?>
	<?php
	if(isset($_GET["page"])) {
		if($_GET["page"] == "2") {
			$first_name = strtolower($_POST["first_name"]);
			$last_name = strtolower($_POST["last_name"]);
			$email = $_POST["email"];
			$place = strtolower($_POST["place"]);
			$postcode = $_POST["postcode"];
			$street = strtolower($_POST["street"]);
			$house_number = $_POST["house_number"];
			$date_of_birth = $_POST["date_of_birth"];
			$password = md5($_POST["password"]);
			$password2 = md5($_POST["password2"]);
					
			//Überprüfung der einzelnen Eingaben des Benutzers
			if($password != $password2) {
				echo "Deine Passwoerter stimmen nicht ueberein. Bitte wiederholen deine Eingabe...<a href=\"index.php\">back</a>";
			} 
			else if(validateMail($email) == false) {
				echo "Deine E-Mail ist nicht gueltig!";
			}			
			else if(!preg_match('/^([a-zA-Z]{3,20})*$/', $_POST['first_name'])) {
				echo "Bitte ueberpruefe die Eingabe von deinem Vornamen!";
			} 
			else if(!preg_match('/^([a-zA-Zäöü]{3,20})*$/', utf8_encode($_POST['last_name']))) {
				echo "Bitte ueberpruefe die Eingabe von deinem Nachnamen!";
			} 
			else if(!preg_match('/^([a-zA-ZäöüÄÖÜß]{2,20})*$/', utf8_encode($_POST['place']))) {
				echo "Bitte ueberpruefe die Eingabe von deinem Wohnort!";
			} 
			else if(!preg_match('/^(\d{5})$/', $_POST['postcode'])) {
				echo "Bitte ueberpruefe die Eingabe von deiner PLZ!";
			} 
			else if(!preg_match('/^([a-zA-ZäöüÄÖÜß]{3,20})*$/', utf8_encode($_POST['street']))) {
				echo "Bitte ueberpruefe die Eingabe von deiner Strasse!";
			} 
			else if(!preg_match('/^(\d{1,3})$/', $_POST['house_number'])) {
				echo "Bitte ueberpruefe die Eingabe von deiner Hausnummer!";
			} 
			else if(!preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $_POST['date_of_birth'])) {
				echo "Bitte ueberpruefe die Eingabe von deinem Geburtsdatum!";
			} 
			else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $_POST['password'])) {
				echo "Bitte ueberpruefe die Eingabe von deinem Passwort!";
			} else {
				$verbindung = mysql_connect("localhost", "root", "")
				or die ("Fehler im System");

				mysql_select_db("projekt_b") 
				or die ("Verbindung zur Datenbank war nicht moeglich.");

				$control = 0;
				$abfrage = "select email from sign_up where email = '$email'";
				$ergebnis = mysql_query($abfrage);

				while($row = mysql_fetch_object($ergebnis)) {
					$control++;
				}
				if($control != 0) {
					echo "E-Mail schon vergen. Bitte verwende einen andere E-Mail...<a href=\"sign_up.php\">back</a>";
				} else {
					$eintrag = "insert into sign_up (first_name, last_name, email, place, postcode, street, house_number, date_of_birth, password) values ('$first_name', '$last_name', '$email', '$place', '$postcode', '$street', '$house_number', '$date_of_birth', '$password')";
					$eintragen = mysql_query($eintrag);
					
					if($eintragen == true) {
						echo "Vielen Dank. Du hast dich nun registriert...<a href=\"index.php\">Jetzt anmelden</a>";
					} else {
						echo "Fehler im System. Bitte versuche es spaeter noch einmal...";
					}
					mysql_close($verbindung);
				}	
			}
		}
	}
	
	//Validierung der E-Mail Adresse
	function validateMail($email, $checkdns = true, $consider_umlauts = true) {
		if(preg_match('/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9][a-zA-Z0-9-.]+\.([a-zA-Z]{2,6})$/' , $email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false ) {
			$tmp = explode('@', $email);
			$domain = $tmp[1];
			if($checkdns && @dns_get_record($domain) === false) {
			   return false;
			}
			//Die E-Mail Adresse arbeitet mit Umlauten
		} elseif($consider_umlauts && preg_match('/^[a-zA-Z0-9äöüÄÖÜ_.-]+@[a-zA-Z0-9äöüÄÖÜ][a-zA-Z0-9-äöüÄÖÜ.]+\.([a-zA-Z]{2,6})$/', $email)) {
			return true;
		} else {
			return false;
		}
		return true;
	}	
		
	?>
	
</body>
</html>