<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>СПА Комплекс "Cherry"</title>

	<link rel="stylesheet" href="style.css">
</head>

<?php
require_once('inc/db.php');
if(!isset($_SESSION)){
	session_start();
	?> 

	<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">СПА "Cherry"</div>
            <ul class="nav-menu" id="navMenu">
                <a href="usercp.php">Нова резервация</a>
                <a href="userorders.php">Моите резервации</a>
                <li><a href="contacts.php">Контакти</a></li>
                <a href="logout.php">Изход</a>
            </ul>
        </div>
    </nav>
	<div class="container">
	<h1>История на вашите резервации</h1>
	
		<?php
		$queryuser = "SELECT * FROM  `reservations` JOIN `spa_services` ON reservations.id_service = spa_services.id_service JOIN `potrebiteli` ON reservations.id_potrebitel = potrebiteli.id_potrebitel WHERE reservations.id_potrebitel = '{$_SESSION['uid']}'";

		$resultuser = mysqli_query($connect,$queryuser);
		echo '<br/>';
		echo '<h2 style="margin: 0;">Вашите резервации: </h2>';
		echo '<hr/>';
		$rows = mysqli_fetch_assoc($resultuser);
		echo 'Име на клиент: '.$rows['ime_potrebitel'].' ';
		echo $rows['familiq_potrebitel'].'<br/>';
		echo 'Адрес: '.$rows['adres_potrebitel'].' <br/>';
		echo '<hr/>';


		$query = "SELECT r.*, s.*, p.*, i.image 
		          FROM `reservations` r
		          JOIN `spa_services` s ON r.id_service = s.id_service 
		          JOIN `potrebiteli` p ON r.id_potrebitel = p.id_potrebitel 
		          LEFT JOIN `images` i ON s.id_image = i.id_image
		          WHERE r.id_potrebitel = '{$_SESSION['uid']}' 
		          AND r.status = 'confirmed' 
		          ORDER BY r.reservation_id DESC";

		$result = mysqli_query($connect,$query);

		while($row = mysqli_fetch_assoc($result)){
			echo '<div class="reservation-item">';
			
			// Показване на изображението
			if(!empty($row['image'])){
				echo '<img src="'.$row['image'].'" style="width:150px;height:100px;border-radius:8px;float:left;margin-right:15px;" alt="'.$row['service_name'].'">';
			}
			
			echo '<div style="overflow:hidden;">';
			echo 'Номер на резервация: <b>'.$row['reservation_id'].'</b><br/>';
			echo 'Услуга: <b>'.$row['service_name'].'</b><br/>';
			echo 'Продължителност: '.$row['duration'].' мин.<br/>';
			echo 'Количество: x' .$row['quantity'].'<br/>';
			
			// Показване на датата и часа на услугата
			if(!empty($row['service_datetime'])){
				$service_date = date('d.m.Y', strtotime($row['service_datetime']));
				$service_time = date('H:i', strtotime($row['service_datetime']));
				echo '<span style="color:#2e7d32;"><b>Дата на услугата: '.$service_date.' в '.$service_time.' часа</b></span><br/>';
			}
			
			echo 'Начин на плащане: '.$row['payment_method'].'<br/>';
			echo 'Дата на резервация: '.date('d.m.Y H:i', strtotime($row['reservation_date'])).'<br/>';
			echo 'Обща сума: <b>' . number_format($row['price'],2,'.','') * $row['quantity'] . ' лв.</b>';
			echo '</div>';
			echo '<div style="clear:both;"></div>';
			echo '</div>';
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

</html>