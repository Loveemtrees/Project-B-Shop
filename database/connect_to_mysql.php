 <?php 
 
//Hier wird der aktuelle "host" eingetragen
$db_host = "localhost";
//Hier wird der Benutzername für die Datenbank eingetragen
$db_username = "root"; 
//Hier wird das Passwort für die Datenbank eingetragen
$db_password = ""; 
//Hier wird der Datenbankname eingetragen
$db_name = "online_shop";

//Hier ist die aktuelle Verbindung
mysql_connect("$db_host","$db_username","$db_password") or die ("Verbindung zu mysql ist nicht möglich!");
mysql_select_db("$db_name") or die ("Keine Datenbank vorhanden!");             

?>