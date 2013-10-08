<?php

$page = "index.php";
$page = "description.php";

mysql_connect("localhost", "root", "") or die (mysql_error());
mysql_select_db("projekt_b") or die (mysql_error());

function products() {
	$get = mysql_query("select product_id, name, description, price from products where quantity > 0 order by product_id desc");
	if(mysql_num_rows($get) == 0) {
			echo "There are no product to display!";
	} else {
		while($get_row = mysql_fetch_assoc($get)) {
			echo '<p>'.$get_row['name'].'<br />'.$get_row['description'].'<br />&euro;'.number_format($get_row['price'], 2).'</p>';
		}
	}
}
?>