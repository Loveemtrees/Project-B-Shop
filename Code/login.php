<?php
session_start();
$verhalten = 0;
if(isset($_SESSION["username"]) and isset($_GET["page"])) {
$verhalten = 0;
}
if(isset($_GET["page"]) == "log") {
	$email = strtolower($_POST["email"]);
	$password = md5($_POST["password"]);
 
$verbindung = mysql_connect("localhost", "root", "") or die ("Fehler im System");
mysql_select_db("projekt_b") or die ("Verbindung zur Datenbank war nicht moeglich.");

$control = 0;
$abfrage = "select * from sign_up where email = '$email' and password = '$password'";
$ergebnis = mysql_query($abfrage);

while($row = mysql_fetch_object($ergebnis)) {
	$control++;
}

if($control != 0) {
	$_SESSION["username"] = $email;
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
		<meta http-equiv="refresh" content="3; URL=cart.php"
	<?php
	}
	?>
</head>
<body>
<?php 
if($verhalten == 0) {
?>
Bitte logge dich ein:<br />
<form method="post" action="login.php?page=log">
	email:<input type="text" name="email" placeholder="email" required/><br /> 
	password:<input type="password" name="password" placeholder="password" required/><br />
	<input type="submit" value="log in" />
</form>
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