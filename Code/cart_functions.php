<?php

session_start();

$page = "cart.php";

mysql_connect("localhost", "root", "") or die (mysql_error());
mysql_select_db("projekt_b") or die (mysql_error());

if(isset($_GET['add'])) {
	//Behebt die Fehlermeldung beim ersten Item im cart
	error_reporting(0); 
	$quantity = mysql_query('select product_id, quantity from products where product_id='.mysql_real_escape_string((int)$_GET['add']));
	while($quantity_row = mysql_fetch_assoc($quantity)) {
		if($quantity_row['quantity']!=$_SESSION['cart_'.(int)$_GET['add']]) {
			$_SESSION['cart_'.(int)$_GET['add']]+='1';
		}
	}
	header('Location: ' .$page);
}

if(isset($_GET['remove'])) {
	$_SESSION['cart_'.(int)$_GET['remove']]--;
	header('Location: '.$page);
}

if(isset($_GET['delete'])) {
	$_SESSION['cart_'.(int)$_GET['delete']]='0';
	header('Location: '.$page);
}

function products() {
	$get = mysql_query("select product_id, name, description, price from products where quantity > 0 order by product_id desc");
	if(mysql_num_rows($get) == 0) {
			echo "There are no product to display!";
	} else {
		while($get_row = mysql_fetch_assoc($get)) {
			echo '<p>'.$get_row['name'].'<br />'.$get_row['description'].'<br />&euro;'.number_format($get_row['price'], 2).'<a href="cart.php?add='.$get_row['product_id'].'">Add</a></p>';
		}
	}
}

function paypal_items() {
	$num = 0;
	foreach($_SESSION as $name => $value) {
		if($value!=0) {
			if(substr($name, 0, 5)=='cart_') {
				$product_id = substr($name, 5, strlen($name)-5);
				$get = mysql_query('select product_id, name, price, shipping from products where product_id='.mysql_real_escape_string((int)$product_id));
				while($get_row = mysql_fetch_assoc($get)) {
					$num++;
					echo '<input type="hidden" name="item_number_'.$num.'" value="'.$product_id.'">';
					echo '<input type="hidden" name="item_name_'.$num.'" value="'.$get_row['name'].'">';
					echo '<input type="hidden" name="amount_'.$num.'" value="'.$get_row['price'].'">';
					echo '<input type="hidden" name="shipping_'.$num.'" value="'.$get_row['shipping'].'">';
					echo '<input type="hidden" name="shipping2_'.$num.'" value="'.$get_row['shipping'].'">';
					echo '<input type="hidden" name="quantity_'.$num.'" value="'.$value.'">';
				}
			}			
		}
	}
}

function cart() {
	$sub = "";
	$total = "";
	foreach($_SESSION as $name => $value) {
		if($value>0) {
			if(substr($name, 0, 5)=='cart_') {
				//Zeigt nur die cart Nummer an
				$product_id = substr($name, 5, (strlen($name)-5)); 
				$get = mysql_query('select product_id, name, price from products where product_id='.mysql_real_escape_string((int)$product_id));				
				while($get_row = mysql_fetch_assoc($get)) {
					$sub = $get_row['price']*$value;
					echo $get_row['name'].' x '.$value.' @ &euro;'.number_format($get_row['price'], 2).' = &euro;'.number_format($sub, 2).' <a href="cart.php?remove='.$product_id.'">[-]</a> <a href="cart.php?add='.$product_id.'">[+]</a> <a href="cart.php?delete='.$product_id.'">[Delete]</a><br />';
				}
			}
			$total += $sub;
		} 
	}
	

	
	
	if($total==0) {
		echo "Your cart is empty.";
	} else {
		echo '<p>Total: &euro;'.number_format($total, 2).'</p>';
		?>
		<p>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_cart">
		<input type="hidden" name="upload" value="1">
		<input type="hidden" name="business" value="projekt_b-facilitator@web.de">
		<?php paypal_items(); ?>		
		<input type="hidden" name="currency_code" value="EUR">
		<input type="hidden" name="amount" value="<?php echo $total; ?>">
		<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but03.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
		</form>
		</p>
		<?php
			
	}
}
			
		
		


?>