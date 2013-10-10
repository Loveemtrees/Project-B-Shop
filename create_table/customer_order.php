<?php  

//Hier wird die Verbindung zur Datenbank hergestellt
require "../datenbank/connect_to_mysql.php"; 

$sqlCommand = "create table customer_order ( 
	order_number	int(6)			not null auto_increment,
	order_date		date			not null,
	shipping_fee	decimal(9,2),
	sales_tax		decimal(9,2),
	submitted		enum('yes','no'),
	ship_name		varchar(50),
	ship_street		varchar(50),
	ship_city		varchar(50),
	ship_state		varchar(2),
	ship_zip		varchar(10),
	email			varchar(50),
	phone			varchar(20),
	primary key(order_number)
)";
	
if(mysql_query($sqlCommand)) {
	echo "Die Tabelle customer_order wurde erstellt.";
} else {
	echo "ERROR die Tabelle customer_order wurde nicht erstellt!";
}

?>