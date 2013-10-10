<?php 
	require_once "cart_functions.php"; 
?>

<?php
if(isset($_SESSION["username"])) {
?>

<h1>Hallo <?php echo $_SESSION["username"]; ?></h1>

<html>
<head>
	<title>Mein Bereich</title>
</head>
<body>
<?php cart(); ?>
<br /> <br />
<?php products(); ?>



<a href="logout.php">Ausloggen</a>

</body>
</html>

<?php
} else {
?>
Bitte erst einloggen, <a href="index.php">hier</a>.
<?php
}
?>