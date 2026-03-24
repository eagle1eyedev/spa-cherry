<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title>СПА Комплекс "Cherry"</title>
	<link rel="stylesheet" href="style.css">
</head>
<?php
require_once('inc/db.php');
if(!isset($_SESSION)){
	session_start();
	?> 

	<body>
	    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
        <div class="logo"><img src="logo.png" class="logo-img"/>СПА "Cherry"</div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php">Начало</a></li>
                <li><a href="#services">Услуги</a></li>
                <li><a href="gallery.php">Галерия</a></li>
                <li><a href="contacts_index.php">Контакти</a></li>
                <li><a href="login.php" class="login-btn">Вход</a></li>
            </ul>
        </div>
    </nav>

	<div class="payment-container" style="margin-top: 50px;">
	<h1>Довършете вашите резервации:</h1>

		<a href="usercp.php" class="btn" style="text-decoration: none;"> Назад</a>
		<br>
		<form action="" method="POST" name="pay_order">
			<br>
			<button class="btn" type="submit" name="promo">Добави код за отстъпка</button>
			<input style="text-transform: uppercase;" type="text" name="promocode">
			<button class="btn" type="submit" name="pay">Потвърди и плати</button>
		</form>

		<?php

		$queryuser = "SELECT * FROM  `reservations` JOIN `spa_services` ON reservations.id_service = spa_services.id_service JOIN `potrebiteli` ON reservations.id_potrebitel = potrebiteli.id_potrebitel WHERE reservations.id_potrebitel = '{$_SESSION['uid']}'";

		$resultuser = mysqli_query($connect,$queryuser);
		$rows = mysqli_fetch_assoc($resultuser);
		echo '<br/>';
		echo 'Име на клиент: '.$rows['ime_potrebitel'].' ';
		echo $rows['familiq_potrebitel'].'<br/>';
		echo 'Адрес: '.$rows['adres_potrebitel'].' <br/>';
		echo '<hr/>';


		$query = "SELECT * FROM  `reservations` JOIN `spa_services` ON reservations.id_service = spa_services.id_service JOIN `potrebiteli` ON reservations.id_potrebitel = potrebiteli.id_potrebitel WHERE reservations.id_potrebitel = '{$_SESSION['uid']}' AND reservations.status = 'pending'";

		$result = mysqli_query($connect,$query);
		echo '<h2>Резервации изчакващи заплащане: </h2>';
		echo '<hr/>';

		$total_price = 0;
		echo 'Услуги: ';
		echo '<br/>';
		echo '<hr/>';
		while($row = mysqli_fetch_assoc($result)){
			echo $row['service_name'].' (' . $row['duration'] . ' мин.) x ' .$row['quantity']. ', '. '<span style="color:#d4265b">'.number_format($row['price'],2,'.','') * $row['quantity'] . ' лв.' . '</span>'.'<br/>';
			$total_price += $row['price'] * $row['quantity'];
		}
		
		if(isset($_POST['promo']) && $_POST['promocode'] != ""){
			$querycode = "SELECT size_promo FROM promo WHERE name_promo = '{$_POST['promocode']}'";
			$resultcode = mysqli_query($connect,$querycode);
			$rowcode = mysqli_fetch_assoc($resultcode);
			if($rowcode){
				echo '<h3>Обща сума за заплащане: ' . number_format($total_price - $total_price * $rowcode['size_promo'],2,'.','') . ' лв.'.'</h3>';
				echo '<b>Вашият код за отстъпка: </b>'. '<b><span style="color:red; text-transform: uppercase;">'.$_POST['promocode'].'</span></b><br/>';
				echo '<br/>';
				echo '<b>Вие ще спестите: </b>'. '<span style="color:red;">'.number_format($total_price * $rowcode['size_promo'],2,'.',''). ' лв.'.'</span>';
			}
			else{
				echo '<h3>Обща сума за заплащане: ' . number_format($total_price,2,'.','') . ' лв.'.'</h3>';
				echo '<b><div style="color:red">Грешен код за отстъпка, моля опитайте друг!</div></b>';
			}
		}
		else{
			echo '<h3>Обща сума за заплащане: ' . number_format($total_price,2,'.','') . ' лв.'.'</h3>';
		}

		if(isset($_POST['pay'])){
			$query = "UPDATE `reservations` SET status='confirmed' WHERE id_potrebitel = '{$_SESSION['uid']}' AND status='pending'";

			$result = mysqli_query($connect,$query);
			if($result){
				echo '<script>';
				echo 'jQuery(document).ready(function($) {';
				echo 'alert("Всички резервации са потвърдени и заплатени!");';
				echo '});';
				echo '</script>';
				echo '<meta http-equiv="refresh" content="0; url=payconfirm.php" />';
			}
			else{
				echo 'problem!';
			}
		}
		?>
	</div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>За Нас</h3>
                <p>СПА Комплекс "Cherry" е водещ луксозен СПА център във Варна, предлагащ изключителни wellness услуги от 2015 година.</p>
            </div>
            <div class="footer-section">
                <h3>Бързи връзки</h3>
                <a href="#services">Услуги</a>
                <a href="gallery.php">Галерия</a>
                <a href="contacts.php">Контакти</a>
            </div>
            <div class="footer-section">
                <h3>Контакти</h3>
                <p>📞 +359 52 123 456</p>
                <p>📧 info@spa-edelweiss.bg</p>
                <p>📍 бул. "Цар Освободител" 125, Варна</p>
            </div>
            <div class="footer-section">
                <h3>Социални мрежи</h3>
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
                <a href="#">TripAdvisor</a>
            </div>
        </div>
        <div class="copyright">
            &copy; 2024 СПА Комплекс "Cherry". Всички права запазени.
        </div>
    </footer>
</body>
	
	<?php
	}
	else{
		echo '<b><span style=color:red;>Моля първо влезте в системата!</span></b>';
		echo '<br/>';
		echo '<br/>';
		echo '<a href="../login.php">Назад</a>';
	}
	?>

	<script>
		 $("div").fadeIn(100,1);
		 
	</script>
</html>