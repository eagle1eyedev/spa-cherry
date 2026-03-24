<!DOCTYPE html>
<html lang="bg">
<head>
	<meta charset="utf-8" />
	<title>Преглед на услуги - Администрация</title>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
	<style>
		.services-table {
			width: 100%;
			background: white;
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
			margin-top: 20px;
		}
		.services-table table {
			width: 100%;
			border-collapse: collapse;
		}
		.services-table th {
			background: #d4265b;
			color: white;
			padding: 15px;
			text-align: left;
			font-weight: 600;
		}
		.services-table td {
			padding: 12px 15px;
			border-bottom: 1px solid #f0f0f0;
		}
		.services-table tr:hover {
			background: #fff5f7;
		}
		.service-image {
			width: 80px;
			height: 60px;
			object-fit: cover;
			border-radius: 8px;
		}
		.action-buttons {
			display: flex;
			gap: 8px;
		}
		.btn-edit, .btn-delete {
			padding: 6px 12px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-size: 14px;
			transition: 0.3s;
		}
		.btn-edit {
			background: #4CAF50;
			color: white;
		}
		.btn-edit:hover {
			background: #45a049;
		}
		.btn-delete {
			background: #f44336;
			color: white;
		}
		.btn-delete:hover {
			background: #da190b;
		}
		.filter-section {
			background: white;
			padding: 20px;
			border-radius: 12px;
			margin-bottom: 20px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
		}
		.filter-section select {
			padding: 10px;
			border-radius: 8px;
			border: 1px solid #ddd;
			margin-right: 10px;
		}
		.stats-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 20px;
			margin-bottom: 30px;
		}
		.stat-card {
			background: white;
			padding: 20px;
			border-radius: 12px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
			text-align: center;
		}
		.stat-number {
			font-size: 32px;
			font-weight: 700;
			color: #d4265b;
		}
		.stat-label {
			color: #666;
			margin-top: 5px;
		}
	</style>
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


	<?php
	require_once('inc/db.php');
	session_start();

	if(!isset($_SESSION['LoggedIn']) || $_SESSION['ur'] != 2){
		header('Location: index.php');
		exit;
	}

	// Изтриване на услуга
	if(isset($_GET['delete'])){
		$id = intval($_GET['delete']);
		
		// Проверка дали има резервации за тази услуга
		$check_query = "SELECT COUNT(*) as count FROM reservations WHERE id_service = $id";
		$check_result = mysqli_query($connect, $check_query);
		$check_row = mysqli_fetch_assoc($check_result);
		
		if($check_row['count'] > 0){
			echo '<script>alert("Не можете да изтриете тази услуга! Има '.$check_row['count'].' резервации свързани с нея.\\n\\nМоже да я деактивирате вместо да я изтриете.");</script>';
		} else {
			// Изтриване на изображението (опционално)
			$img_query = "SELECT id_image FROM spa_services WHERE id_service = $id";
			$img_result = mysqli_query($connect, $img_query);
			$img_row = mysqli_fetch_assoc($img_result);
			
			// Изтриване на услугата
			$query = "DELETE FROM spa_services WHERE id_service = $id";
			if(mysqli_query($connect, $query)){
				// Изтриване на изображението ако няма други услуги да го използват
				if($img_row['id_image']){
					$check_img = "SELECT COUNT(*) as count FROM spa_services WHERE id_image = {$img_row['id_image']}";
					$check_img_result = mysqli_query($connect, $check_img);
					$check_img_row = mysqli_fetch_assoc($check_img_result);
					
					if($check_img_row['count'] == 0){
						mysqli_query($connect, "DELETE FROM images WHERE id_image = {$img_row['id_image']}");
					}
				}
				echo '<script>alert("Услугата е изтрита успешно!"); window.location.href="admin_services.php";</script>';
			}
		}
	}

	// Редакция на услуга
	$edit_service = null;
	if(isset($_GET['edit'])){
		$edit_id = intval($_GET['edit']);
		$edit_query = "SELECT * FROM spa_services WHERE id_service = $edit_id";
		$edit_result = mysqli_query($connect, $edit_query);
		$edit_service = mysqli_fetch_assoc($edit_result);
	}

	// Обновяване на услуга
	if(isset($_POST['update_service'])){
		$service_id = intval($_POST['service_id']);
		$service_name = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['service_name']));
		$service_type = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['service_type']));
		$duration = intval($_POST['duration']);
		$price = floatval($_POST['price']);
		$description = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['description']));

		// Проверка дали има ново изображение
		$image_update = "";
		if(isset($_FILES['new_image']) && $_FILES['new_image']['error'] == 0){
			$imageName = $_FILES["new_image"]["name"];
			$imagePath = "./images/".$imageName;
			$image = "images/".$imageName;
			
			if(move_uploaded_file($_FILES["new_image"]["tmp_name"], $imagePath)){
				// Добавяне на ново изображение
				$img_query = "INSERT INTO `images`(`image`) VALUES ('$image')";
				mysqli_query($connect, $img_query);
				$new_image_id = mysqli_insert_id($connect);
				$image_update = ", id_image = $new_image_id";
			}
		}

		$update_query = "UPDATE spa_services SET 
						service_name = '$service_name',
						service_type = '$service_type',
						duration = $duration,
						price = $price,
						description = '$description'
						$image_update
						WHERE id_service = $service_id";

		if(mysqli_query($connect, $update_query)){
			echo '<script>alert("Услугата е обновена успешно!"); window.location.href="admin_services.php";</script>';
		} else {
			echo '<script>alert("Грешка при обновяване на услугата!");</script>';
		}
	}

	// Филтриране
	$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
	$where_clause = $filter != 'all' ? "WHERE service_type = '$filter'" : '';

	// Статистика
	$total_services = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM spa_services"))['count'];
	$spa_therapies = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM spa_services WHERE service_type='СПА Терапии'"))['count'];
	$massages = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM spa_services WHERE service_type='Масажи'"))['count'];
	$total_revenue = mysqli_fetch_assoc(mysqli_query($connect, "SELECT SUM(price * quantity) as total FROM reservations JOIN spa_services ON reservations.id_service = spa_services.id_service WHERE status='confirmed'"))['total'] ?? 0;
	?>

	<h1 style="color:#d4265b;">Преглед на услуги в менюто</h1>

	<!-- Modal за редакция -->
	<?php if($edit_service): ?>
	<div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px;">
		<div style="background: white; padding: 30px; border-radius: 18px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto;">
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
				<h2 style="color: #d4265b; margin: 0;">Редактиране на услуга</h2>
				<a href="admin_services.php" style="font-size: 28px; color: #999; text-decoration: none; line-height: 1;">&times;</a>
			</div>
			
			<form method="POST" enctype="multipart/form-data">
				<input type="hidden" name="service_id" value="<?php echo $edit_service['id_service']; ?>">
				
				<label style="display: block; margin-top: 15px; font-weight: 600;">Име на услугата:</label>
				<input type="text" name="service_name" value="<?php echo htmlspecialchars($edit_service['service_name']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
				
				<label style="display: block; margin-top: 15px; font-weight: 600;">Категория:</label>
				<select name="service_type" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
					<option value="СПА Терапии" <?php echo $edit_service['service_type'] == 'СПА Терапии' ? 'selected' : ''; ?>>СПА Терапии</option>
					<option value="Масажи" <?php echo $edit_service['service_type'] == 'Масажи' ? 'selected' : ''; ?>>Масажи</option>
					<option value="Козметични процедури" <?php echo $edit_service['service_type'] == 'Козметични процедури' ? 'selected' : ''; ?>>Козметични процедури</option>
					<option value="Грижа за тяло" <?php echo $edit_service['service_type'] == 'Грижа за тяло' ? 'selected' : ''; ?>>Грижа за тяло</option>
					<option value="Уелнес програми" <?php echo $edit_service['service_type'] == 'Уелнес програми' ? 'selected' : ''; ?>>Уелнес програми</option>
				</select>
				
				<label style="display: block; margin-top: 15px; font-weight: 600;">Продължителност (минути):</label>
				<input type="number" name="duration" value="<?php echo $edit_service['duration']; ?>" required min="1" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
				
				<label style="display: block; margin-top: 15px; font-weight: 600;">Цена (лв):</label>
				<input type="number" step="0.01" name="price" value="<?php echo $edit_service['price']; ?>" required min="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
				
				<label style="display: block; margin-top: 15px; font-weight: 600;">Описание:</label>
				<textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px; resize: vertical;"><?php echo htmlspecialchars($edit_service['description'] ?? ''); ?></textarea>
				
				<label style="display: block; margin-top: 15px; font-weight: 600;">Ново изображение (опционално):</label>
				<input type="file" name="new_image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; margin-top: 5px;">
				<small style="color: #666;">Оставете празно, ако не искате да променяте изображението</small>
				
				<div style="display: flex; gap: 10px; margin-top: 25px;">
					<button type="submit" name="update_service" style="flex: 1; padding: 12px; background: #d4265b; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">💾 Запази промените</button>
					<a href="admin_services.php" style="flex: 1; padding: 12px; background: #666; color: white; border: none; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; display: flex; align-items: center; justify-content: center;">❌ Отказ</a>
				</div>
			</form>
		</div>
	</div>
	<?php endif; ?>

	<!-- Статистика -->
	<div class="stats-grid">
		<div class="stat-card">
			<div class="stat-number"><?php echo $total_services; ?></div>
			<div class="stat-label">Общо услуги</div>
		</div>
		<div class="stat-card">
			<div class="stat-number"><?php echo $spa_therapies; ?></div>
			<div class="stat-label">СПА Терапии</div>
		</div>
		<div class="stat-card">
			<div class="stat-number"><?php echo $massages; ?></div>
			<div class="stat-label">Масажи</div>
		</div>
		<div class="stat-card">
			<div class="stat-number"><?php echo number_format($total_revenue, 2); ?> лв.</div>
			<div class="stat-label">Общ приход</div>
		</div>
	</div>

	<!-- Филтър -->
	<div class="filter-section">
		<form method="GET" style="display: flex; align-items: center; gap: 10px;">
			<label style="font-weight: 600;">Филтрирай по категория:</label>
			<select name="filter" onchange="this.form.submit()">
				<option value="all" <?php echo $filter == 'all' ? 'selected' : ''; ?>>Всички услуги</option>
				<option value="СПА Терапии" <?php echo $filter == 'СПА Терапии' ? 'selected' : ''; ?>>СПА Терапии</option>
				<option value="Масажи" <?php echo $filter == 'Масажи' ? 'selected' : ''; ?>>Масажи</option>
				<option value="Козметични процедури" <?php echo $filter == 'Козметични процедури' ? 'selected' : ''; ?>>Козметични процедури</option>
				<option value="Грижа за тяло" <?php echo $filter == 'Грижа за тяло' ? 'selected' : ''; ?>>Грижа за тяло</option>
				<option value="Уелнес програми" <?php echo $filter == 'Уелнес програми' ? 'selected' : ''; ?>>Уелнес програми</option>
			</select>
		</form>
	</div>

	<!-- Таблица с услуги -->
	<div class="services-table">
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Снимка</th>
					<th>Име на услугата</th>
					<th>Категория</th>
					<th>Продължителност (мин)</th>
					<th>Цена (лв)</th>
					<th>Дата на добавяне</th>
					<th>Действия</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$query = "SELECT s.*, i.image FROM spa_services s 
						  LEFT JOIN images i ON s.id_image = i.id_image 
						  $where_clause 
						  ORDER BY s.created_at DESC";
				$result = mysqli_query($connect, $query);

				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						echo '<tr>';
						echo '<td><b>#'.$row['id_service'].'</b></td>';
						echo '<td>';
						if($row['image']){
							echo '<img src="'.$row['image'].'" class="service-image" alt="'.$row['service_name'].'">';
						} else {
							echo '<img src="https://via.placeholder.com/80x60/d4265b/ffffff?text=No+Image" class="service-image">';
						}
						echo '</td>';
						echo '<td><b>'.$row['service_name'].'</b></td>';
						echo '<td><span style="color:#930f36; font-weight:600;">'.$row['service_type'].'</span></td>';
						echo '<td>'.$row['duration'].' мин</td>';
						echo '<td><b style="color:#d4265b;">'.number_format($row['price'], 2).' лв</b></td>';
						echo '<td>'.date('d.m.Y', strtotime($row['created_at'])).'</td>';
						echo '<td>';
						echo '<div class="action-buttons">';
						echo '<button class="btn-edit" onclick="editService('.$row['id_service'].')">✏️ Редактирай</button>';
						echo '<button class="btn-delete" onclick="deleteService('.$row['id_service'].')">🗑️ Изтрий</button>';
						echo '</div>';
						echo '</td>';
						echo '</tr>';
					}
				} else {
					echo '<tr><td colspan="8" style="text-align:center; padding:30px; color:#999;">Няма намерени услуги</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>

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
		function editService(id) {
			window.location.href = 'admin_services.php?edit=' + id;
		}

		function deleteService(id) {
			if(confirm('Сигурни ли сте, че искате да изтриете тази услуга?')) {
				window.location.href = '?delete=' + id + '<?php echo $filter != "all" ? "&filter=".$filter : ""; ?>';
			}
		}

		function toggleMenu() {
			const navMenu = document.getElementById('navMenu');
			navMenu.classList.toggle('active');
		}
	</script>
</body>
</html>