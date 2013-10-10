<?php  

//Hier wird die Verbindung zur Datenbank hergestellt
require "../datenbank/connect_to_mysql.php"; 

$sqlCommand = "create table order_item ( 
	order_number	int(6)			not null,
	item_number		int(5)			not null,
	catalog_number	int(6)			not null,
	quantity		decimal(7,2)	not null,
	price			decimal(9,2)	not null,
	primary key(order_number,item_number)
)";
	
if(mysql_query($sqlCommand)) {
	echo "Die Tabelle order_item wurde erstellt.";
} else {
	echo "ERROR die Tabelle order_item wurde nicht erstellt!";
}

?>