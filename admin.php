<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			setInterval(runningTime, 1);
		});
		function runningTime() {
			$.ajax({
				url: 'currenttime.php',
				success: function(data) {
					$('#runningTime').html(data);
				},
			});
		}
	</script>
	<title>СПА Комплекс "Cherry"</title>
	<link rel="stylesheet" href="style.css">
</head>

<body class="admin-page">

    <nav class="navbar">
    <div class="nav-container">
        <div class="logo">СПА "Cherry"</div>
        
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <ul class="nav-menu" id="navMenu">
            <li><a href="admin.php">Начало</a></li>
            <li><a href="admin_services.php">Виж услуги в менюто</a></li>
            <li><a href="admin_orders.php">Виж история на резервациите</a></li>
            <li><a href="admin_users.php">Виж информация за клиентите</a></li>
            <li><a href="logout.php">Изход</a></li>
        </ul>
    </div>
</nav>


	<h1>Администраторски панел</h1>
	<?php
	require_once('inc/db.php');
	if(!isset($_SESSION)){
		session_start();


		$query = "SELECT username_potrebitel FROM potrebiteli WHERE id_potrebitel = {$_SESSION['uid']}";
		$result = mysqli_query($connect,$query);
		$row = mysqli_fetch_assoc($result);
		echo '<br/>';
		echo 'Добре дошъл, ' . '<b><span style="color: #d4265b">'.$row['username_potrebitel'].'</span></b>' . '!';
		echo '<br/>';
		echo '<br/>';
		?>

		<div id="runningTime"></div>
		<br>
		<a href="logout.php" class="btn" style="text-decoration: none;"> Изход</a>
		<form action="" method="POST" name="insert_items" enctype="multipart/form-data" style="margin-top: 20px">

			<br>
			Изберете категория услуга:<select name="type" id="type">
				<option name="spa_therapy" id="spa_therapy" >СПА Терапии</option>
				<option name="massage" id="massage" >Масажи</option>
				<option name="facial" id="facial" >Козметични процедури</option>
				<option name="body_treatment" id="body_treatment">Грижа за тяло</option>
				<option name="wellness" id="wellness" >Уелнес програми</option>
			</select>

			Име:<input type="text" name="ime_usluga" required="true">
			Продължителност (мин.):<input type="text" name="produlzhitelnost" required="true">
			Цена: <input type="text" name="price" required="true">
			Изображение: <input type="file" name="photo" required="true">
			<input type="submit" name="submit" value="Добави">

		</form>
		<form action="" method="POST" name="lookup">
			<br>
			Код: <input style="text-transform: uppercase;" type="text" name="promocode">
			<br><br>
			Отстъпка в %: <input type="text" name="promosize">
			<input type="submit" name="submitcode" value="Добави код за отстъпка">
		</form>
		
		<?php



		if(isset($_POST['lookup_menu'])){
			$query = "SELECT * FROM spa_services";
			$result = mysqli_query($connect,$query);

			echo '<br/>';
			echo '<h2>СПА Услуги: </h2>';
			echo '<hr/>';

			while($row = mysqli_fetch_assoc($result)){
				echo $row['service_name'].'<br/>';
				echo $row['duration'].' мин.'.'<br/>';
				echo $row['price'].' лв.'.'<br/>';
				echo '<hr/>';
			}
		}
		else if (isset($_POST['lookup_orders'])){
			$query = "SELECT * FROM `reservations` JOIN `spa_services` ON reservations.id_service = spa_services.id_service JOIN `potrebiteli` ON reservations.id_potrebitel = potrebiteli.id_potrebitel;
			";
			$result = mysqli_query($connect,$query);
			echo '<br/>';
			echo '<h2>Резервации: </h2>';
			echo '<hr/>';

			while($row = mysqli_fetch_assoc($result)){
				echo 'Номер на резервация: '.$row['reservation_id'].'<br/>';
				echo 'Име на клиент: '.$row['ime_potrebitel'].' ';
				echo $row['familiq_potrebitel'].'<br/>';
				echo 'Услуга: '.$row['service_name'].' x ' .$row['quantity'].'<br/>';
				echo 'Начин на плащане: '.$row['payment_method'].'<br/>';
				echo 'Дата на резервация: '.$row['reservation_date'].'<br/>';
				echo 'Обща сума: ' . number_format($row['price'],2,'.','') * $row['quantity'];

				echo '<hr/>';
			}
		}
		else if (isset($_POST['lookup_users'])){
			$query = "SELECT * FROM `potrebiteli` JOIN `rankove` on potrebiteli.rank_id = rankove.rank_id";
			$result = mysqli_query($connect,$query);

			echo '<br/>';
			echo '<h2>Клиенти: </h2>';
			echo '<hr/>';

			while($row = mysqli_fetch_assoc($result)){
				echo $row['id_potrebitel'].' <br/>  ';
				echo 'Име: '. $row['ime_potrebitel'].' ';
				echo $row['familiq_potrebitel'].' <br/>  ';
				echo 'Потребителско име: ' . $row['username_potrebitel'].' <br/>  ';
				echo 'Телефон: '. $row['telefon_potrebitel'].' <br/>  ';
				echo 'Адрес: '. $row['adres_potrebitel'].' <br/>  ';
				echo 'Ранг: '. $row['rank_ime'].'  ';
				echo '<hr/>';
			}
		}

		?>

		<?php
		if(isset($_POST['submit'])) {

			



			if(isset($_POST['ime_usluga']) && isset($_POST['produlzhitelnost']) && isset($_FILES["photo"]) && isset($_POST['price']) && $_POST['type'] == "СПА Терапии") {

				$ime_usluga = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['ime_usluga']));
				$produlzhitelnost = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['produlzhitelnost']));
				$price = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['price']));

				$imageName = $_FILES["photo"]["name"];    
				$imagePath = "./images/".$imageName;
				$image = "images/".$imageName; 
				move_uploaded_file($_FILES["photo"]["tmp_name"],$imagePath);

				$query = "INSERT INTO `images`(`image`) VALUES ('$image')";
				$result = mysqli_query($connect, $query);

				$query = "SELECT id_image FROM `images` WHERE image = '$image'";
				$result = $connect -> query($query);
				$row = mysqli_fetch_assoc($result);

				$query = "INSERT INTO `spa_services`(`service_type`, `service_name`, `duration`, `price`, `id_image`) VALUES ('СПА Терапии','$ime_usluga','$produlzhitelnost','$price',{$row['id_image']})";
				$result = mysqli_query($connect, $query);
				if($result) {
					echo '<script>';
					echo 'jQuery(document).ready(function($) {';
					echo 'alert("Услугата беше успешно добавена в менюто!");';
					echo '});';
					echo '</script>';
				}	
				else {
					echo "Problem call IT!";
				}
			}
			else if(isset($_POST['ime_usluga']) && isset($_POST['produlzhitelnost']) && isset($_FILES["photo"]) && isset($_POST['price']) && $_POST['type'] == "Масажи") {

				$ime_usluga = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['ime_usluga']));
				$produlzhitelnost = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['produlzhitelnost']));
				$price = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['price']));

				$imageName = $_FILES["photo"]["name"];    
				$imagePath = "./images/".$imageName;
				$image = "images/".$imageName; 
				move_uploaded_file($_FILES["photo"]["tmp_name"],$imagePath);

				$query = "INSERT INTO `images`(`image`) VALUES ('$image')";
				$result = mysqli_query($connect, $query);

				$query = "SELECT id_image FROM `images` WHERE image = '$image'";
				$result = $connect -> query($query);
				$row = mysqli_fetch_assoc($result);

				$query = "INSERT INTO `spa_services`(`service_type`, `service_name`, `duration`, `price`, `id_image`) VALUES ('Масажи','$ime_usluga','$produlzhitelnost','$price',{$row['id_image']})";
				$result = mysqli_query($connect, $query);
				if($result) {
					echo '<script>';
					echo 'jQuery(document).ready(function($) {';
					echo 'alert("Услугата беше успешно добавена в менюто!");';
					echo '});';
					echo '</script>';				
				}
				else {
					echo "Problem call IT!";
				}
			}
			else if(isset($_POST['ime_usluga']) && isset($_POST['produlzhitelnost']) && isset($_FILES["photo"]) && isset($_POST['price']) && $_POST['type'] == "Козметични процедури") {

				$ime_usluga = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['ime_usluga']));
				$produlzhitelnost = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['produlzhitelnost']));
				$price = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['price']));

				$imageName = $_FILES["photo"]["name"];    
				$imagePath = "./images/".$imageName;
				$image = "images/".$imageName; 
				move_uploaded_file($_FILES["photo"]["tmp_name"],$imagePath);

				$query = "INSERT INTO `images`(`image`) VALUES ('$image')";
				$result = mysqli_query($connect, $query);

				$query = "SELECT id_image FROM `images` WHERE image = '$image'";
				$result = $connect -> query($query);
				$row = mysqli_fetch_assoc($result);

				$query = "INSERT INTO `spa_services`(`service_type`, `service_name`, `duration`, `price`, `id_image`) VALUES ('Козметични процедури','$ime_usluga','$produlzhitelnost','$price',{$row['id_image']})";
				$result = mysqli_query($connect, $query);
				if($result) {
					echo '<script>';
					echo 'jQuery(document).ready(function($) {';
					echo 'alert("Услугата беше успешно добавена в менюто!");';
					echo '});';
					echo '</script>';	
				}
				else {
					echo "Problem call IT!";
				}
			}
			else if(isset($_POST['ime_usluga']) && isset($_POST['produlzhitelnost']) && isset($_FILES["photo"]) && isset($_POST['price']) && $_POST['type'] == "Грижа за тяло") {

				$ime_usluga = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['ime_usluga']));
				$produlzhitelnost = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['produlzhitelnost']));
				$price = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['price']));

				$imageName = $_FILES["photo"]["name"];    
				$imagePath = "./images/".$imageName;
				$image = "images/".$imageName; 
				move_uploaded_file($_FILES["photo"]["tmp_name"],$imagePath);

				$query = "INSERT INTO `images`(`image`) VALUES ('$image')";
				$result = mysqli_query($connect, $query);

				$query = "SELECT id_image FROM `images` WHERE image = '$image'";
				$result = $connect -> query($query);
				$row = mysqli_fetch_assoc($result);

				$query = "INSERT INTO `spa_services`(`service_type`, `service_name`, `duration`, `price`, `id_image`) VALUES ('Грижа за тяло','$ime_usluga','$produlzhitelnost','$price',{$row['id_image']})";
				$result = mysqli_query($connect, $query);
				if($result) {
					echo '<script>';
					echo 'jQuery(document).ready(function($) {';
					echo 'alert("Услугата беше успешно добавена в менюто!");';
					echo '});';
					echo '</script>';			
				}
				else {
					echo "Problem call IT!";
				}
			}
			else if(isset($_POST['ime_usluga']) && isset($_POST['produlzhitelnost']) && isset($_FILES["photo"]) && isset($_POST['price']) && $_POST['type'] == "Уелнес програми") {

				$ime_usluga = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['ime_usluga']));
				$produlzhitelnost = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['produlzhitelnost']));
				$price = htmlspecialchars(mysqli_real_escape_string($connect,$_POST['price']));

				$imageName = $_FILES["photo"]["name"];    
				$imagePath = "./images/".$imageName;
				$image = "images/".$imageName; 
				move_uploaded_file($_FILES["photo"]["tmp_name"],$imagePath);

				$query = "INSERT INTO `images`(`image`) VALUES ('$image')";
				$result = mysqli_query($connect, $query);

				$query = "SELECT id_image FROM `images` WHERE image = '$image'";
				$result = $connect -> query($query);
				$row = mysqli_fetch_assoc($result);

				$query = "INSERT INTO `spa_services`(`service_type`, `service_name`, `duration`, `price`, `id_image`) VALUES ('Уелнес програми','$ime_usluga','$produlzhitelnost','$price',{$row['id_image']})";
				$result = mysqli_query($connect, $query);
				if($result) {

					echo '<script>';
					echo 'jQuery(document).ready(function($) {';
					echo 'alert("Услугата беше успешно добавена в менюто!");';
					echo '});';
					echo '</script>';
					
				}
				else {
					echo "Problem call IT!";
				}
			}
		}
	}
	else{
		echo '<b><span style=color:red;>Моля първо влезте в системата!</span></b>';
		echo '<br/>';
		echo '<br/>';
		echo '<a href="../login.php">Назад</a>';
	}

	if(isset($_POST['submitcode']) && isset($_POST['promocode']) && isset($_POST['promosize']) && $_POST['promocode'] != "" && $_POST['promosize'] !=""){
		$querycheck = "SELECT name_promo FROM promo WHERE name_promo = '{$_POST['promocode']}'";
		$resultcheck = mysqli_query($connect, $querycheck);
		$rowcheck = mysqli_fetch_assoc($resultcheck);
		if($rowcheck)
		{
			echo '<br/>';
			echo '<b><p style="color:red">Вече съществува код с това име!</p></b>';
		}
		else{
			$promopercent = $_POST['promosize'] / 100;
			$query = "INSERT INTO `promo`(`name_promo`, `size_promo`) VALUES ('{$_POST['promocode']}','$promopercent')";
			$result = $connect -> query($query);
			if($result){
				echo '<script>';
				echo 'jQuery(document).ready(function($) {';
				echo 'alert("Кодът беше успешно добавен!");';
				echo '});';
				echo '</script>';
			}
		}
	}
	?>

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

	<script>
		$("p").fadeIn(100,1)

		function toggleMenu() {
			const navMenu = document.getElementById('navMenu');
			navMenu.classList.toggle('active');
		}
	</script>
</body>
</html>