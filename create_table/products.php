<?php  

//Hier wird die Verbindung zur Datenbank hergestellt
require "../datenbank/connect_to_mysql.php"; 

$sqlCommand = "create table products ( 
	catalog_number	int(6)			not null auto_increment,
	name			varchar(20)		not null,
	added_date		date			not null,
	category		varchar(20)		not null,
	type			varchar(20)		not null,
	description		varchar(255)	not null,
	price			decimal(7,2)	not null,
	pix				varchar(20)		not null default 'missing.jpg',
	primary key(catalog_number)
)";
	
if(mysql_query($sqlCommand)) {
	echo "Die Tabelle products wurde erstellt.";
} else {
	echo "ERROR die Tabelle products wurde nicht erstellt!";
}

?>