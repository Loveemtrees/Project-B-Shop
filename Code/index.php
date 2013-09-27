test
<?php
	session_start();

	$verhalten = 0;

	if(!isset($_SESSION["username"]) and !isset($_GET["page"])) {
		$verhalten = 0;
	}
	
	if(isset($_GET["page"]) == "log") {
		$user = strtolower($_POST["user"]);
		$passwort = md5($_POST["passwort"]);

		$verbindung = mysql_connect("localhost", "root", "")
		or die ("Fehler im System");

		mysql_select_db("projekt_b") 
		or die ("Verbindung zur Datenbank war nicht moeglich.");

		$control = 0;
		$abfrage = "select * from login where user = '$user' and passwort = '$passwort'";
		$ergebnis = mysql_query($abfrage);

		while($row = mysql_fetch_object($ergebnis)) {
			$control++;
		}

		if($control != 0) {
			$_SESSION["username"] = $user;
			$verhalten = 1;
		} else {
			$verhalten = 2;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Geschuetzer Bereich</title>
<?php
	if($verhalten == 1) {
?>
	<meta http-equiv="refresh" content="3; URL=seite2.php">
<?php
	}
?>
	</head>
	<body>
<?php 
	if($verhalten == 0) {
?>
		Bitte logge dich ein:<br />
	
		<form method="post" action="index.php?page=log">
			User:<input type="text" name="user" /><br /> 
			Passwort:<input type="password" name="passwort" /><br />
			<input type="submit" value="Einloggen" />
		</form>
	
		<p><a href="register.php">Noch nicht dabei? Jetzt registrieren...</a><p>
	
<?php
	}
	if($verhalten == 1) {
?>
		Du hast dich richtig eingeloggt und wirst nun weitergeleitet....
<?php
	} 
	if($verhalten == 2) {
?>
		Du hast dich nicht richtig eingeloggt, <a href="index.php">back</a>.
<?php
	}
?>
	</body>
</html>