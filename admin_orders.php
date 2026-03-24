<!DOCTYPE html>
<html lang="bg">
<head>
	<meta charset="utf-8" />
	<title>История на резервациите - Администрация</title>
	<link rel="stylesheet" href="style.css">
	<style>
		.orders-table {
			width: 100%;
			background: white;
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
			margin-top: 20px;
		}
		.orders-table table {
			width: 100%;
			border-collapse: collapse;
		}
		.orders-table th {
			background: #d4265b;
			color: white;
			padding: 15px;
			text-align: left;
			font-weight: 600;
			font-size: 14px;
		}
		.orders-table td {
			padding: 12px 15px;
			border-bottom: 1px solid #f0f0f0;
			font-size: 14px;
		}
		.orders-table tr:hover {
			background: #fff5f7;
		}
		.status-badge {
			padding: 5px 12px;
			border-radius: 15px;
			font-size: 12px;
			font-weight: 600;
			display: inline-block;
		}
		.status-pending {
			background: #fff3cd;
			color: #856404;
		}
		.status-confirmed {
			background: #d4edda;
			color: #155724;
		}
		.status-cancelled {
			background: #f8d7da;
			color: #721c24;
		}
		.filter-section {
			background: white;
			padding: 20px;
			border-radius: 12px;
			margin-bottom: 20px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
			display: flex;
			gap: 15px;
			flex-wrap: wrap;
			align-items: center;
		}
		.filter-section select, .filter-section input {
			padding: 10px;
			border-radius: 8px;
			border: 1px solid #ddd;
		}
		.stats-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
			gap: 20px;
			margin-bottom: 30px;
		}
		.stat-card {
			background: white;
			padding: 25px;
			border-radius: 12px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
		}
		.stat-number {
			font-size: 36px;
			font-weight: 700;
			color: #d4265b;
			margin-bottom: 5px;
		}
		.stat-label {
			color: #666;
			font-size: 14px;
		}
		.stat-icon {
			font-size: 24px;
			margin-bottom: 10px;
		}
		.action-btn {
			padding: 6px 12px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-size: 12px;
			background: #d4265b;
			color: white;
			transition: 0.3s;
		}
		.action-btn:hover {
			background: #930f36;
		}
		.export-btn {
			background: #4CAF50;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 8px;
			cursor: pointer;
			font-weight: 600;
		}
		.export-btn:hover {
			background: #45a049;
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
		header('Location: login.php');
		exit;
	}

	// Филтриране
	$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
	$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
	$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

	$where_conditions = [];
	if($status_filter != 'all') {
		$where_conditions[] = "r.status = '$status_filter'";
	}
	if($date_from) {
		$where_conditions[] = "DATE(r.reservation_date) >= '$date_from'";
	}
	if($date_to) {
		$where_conditions[] = "DATE(r.reservation_date) <= '$date_to'";
	}

	$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

	// Статистика
	$total_reservations = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM reservations"))['count'];
	$pending_reservations = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM reservations WHERE status='pending'"))['count'];
	$confirmed_reservations = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM reservations WHERE status='confirmed'"))['count'];
	$total_revenue = mysqli_fetch_assoc(mysqli_query($connect, "SELECT SUM(s.price * r.quantity) as total FROM reservations r JOIN spa_services s ON r.id_service = s.id_service WHERE r.status='confirmed'"))['total'] ?? 0;
	$today_reservations = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM reservations WHERE DATE(reservation_date) = CURDATE()"))['count'];
	?>

	<h1 style="color:#d4265b;">История на резервациите</h1>
	
	<div style="margin-bottom: 20px;">
		<a href="admin.php" style="color: #d4265b; text-decoration: none; font-weight: 500;">← Назад към администрация</a>
	</div>

	<!-- Статистика -->
	<div class="stats-grid">
		<div class="stat-card">
			<div class="stat-icon">📊</div>
			<div class="stat-number"><?php echo $total_reservations; ?></div>
			<div class="stat-label">Общо резервации</div>
		</div>
		<div class="stat-card">
			<div class="stat-icon">⏳</div>
			<div class="stat-number"><?php echo $pending_reservations; ?></div>
			<div class="stat-label">Чакащи плащане</div>
		</div>
		<div class="stat-card">
			<div class="stat-icon">✅</div>
			<div class="stat-number"><?php echo $confirmed_reservations; ?></div>
			<div class="stat-label">Потвърдени</div>
		</div>
		<div class="stat-card">
			<div class="stat-icon">💰</div>
			<div class="stat-number"><?php echo number_format($total_revenue, 2); ?> лв</div>
			<div class="stat-label">Общ приход</div>
		</div>
		<div class="stat-card">
			<div class="stat-icon">📅</div>
			<div class="stat-number"><?php echo $today_reservations; ?></div>
			<div class="stat-label">Резервации днес</div>
		</div>
	</div>

	<!-- Филтри -->
	<div class="filter-section">
		<form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center; width: 100%;">
			<div>
				<label style="font-weight: 600; display: block; margin-bottom: 5px;">Статус:</label>
				<select name="status">
					<option value="all" <?php echo $status_filter == 'all' ? 'selected' : ''; ?>>Всички</option>
					<option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Чакащи</option>
					<option value="confirmed" <?php echo $status_filter == 'confirmed' ? 'selected' : ''; ?>>Потвърдени</option>
					<option value="cancelled" <?php echo $status_filter == 'cancelled' ? 'selected' : ''; ?>>Отказани</option>
				</select>
			</div>
			<div>
				<label style="font-weight: 600; display: block; margin-bottom: 5px;">От дата:</label>
				<input type="date" name="date_from" value="<?php echo $date_from; ?>">
			</div>
			<div>
				<label style="font-weight: 600; display: block; margin-bottom: 5px;">До дата:</label>
				<input type="date" name="date_to" value="<?php echo $date_to; ?>">
			</div>
			<div style="margin-top: 20px;">
				<button type="submit" class="action-btn">🔍 Филтрирай</button>
				<a href="?" class="action-btn" style="display: inline-block; text-decoration: none; margin-left: 10px;">🔄 Изчисти</a>
			</div>
		</form>
	</div>

	<!-- Таблица с резервации -->
	<div class="orders-table">
		<table id="ordersTable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Клиент</th>
					<th>Телефон</th>
					<th>Услуга</th>
					<th>Количество</th>
					<th>Дата на услугата</th>
					<th>Дата на резервация</th>
					<th>Начин на плащане</th>
					<th>Обща сума</th>
					<th>Статус</th>
					<th>Действия</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$query = "SELECT r.*, s.service_name, s.price, s.duration, 
						  p.ime_potrebitel, p.familiq_potrebitel, p.telefon_potrebitel, p.email_potrebitel
						  FROM reservations r
						  JOIN spa_services s ON r.id_service = s.id_service
						  JOIN potrebiteli p ON r.id_potrebitel = p.id_potrebitel
						  $where_clause
						  ORDER BY r.reservation_date DESC";
				$result = mysqli_query($connect, $query);

				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$total = $row['price'] * $row['quantity'];
						$status_class = 'status-' . $row['status'];
						$status_text = [
							'pending' => 'Чакаща',
							'confirmed' => 'Потвърдена',
							'cancelled' => 'Отказана',
							'completed' => 'Завършена'
						];

						echo '<tr>';
						echo '<td><b>#'.$row['reservation_id'].'</b></td>';
						echo '<td>'.$row['ime_potrebitel'].' '.$row['familiq_potrebitel'].'</td>';
						echo '<td>'.$row['telefon_potrebitel'].'</td>';
						echo '<td><b>'.$row['service_name'].'</b><br><small style="color:#666;">'.$row['duration'].' мин</small></td>';
						echo '<td>x'.$row['quantity'].'</td>';
						echo '<td>'.($row['service_datetime'] ? date('d.m.Y H:i', strtotime($row['service_datetime'])) : '-').'</td>';
						echo '<td>'.date('d.m.Y H:i', strtotime($row['reservation_date'])).'</td>';
						echo '<td>'.($row['payment_method'] == 'card' ? '💳 Карта' : '💵 В брой').'</td>';
						echo '<td><b style="color:#d4265b;">'.number_format($total, 2).' лв</b></td>';
						echo '<td><span class="status-badge '.$status_class.'">'.$status_text[$row['status']].'</span></td>';
						echo '<td><button class="action-btn" onclick="viewDetails('.$row['reservation_id'].')">👁️ Детайли</button></td>';
						echo '</tr>';
					}
				} else {
					echo '<tr><td colspan="11" style="text-align:center; padding:30px; color:#999;">Няма намерени резервации</td></tr>';
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
		function viewDetails(id) {
			alert('Детайли за резервация #' + id + '\n\nТази функция ще покаже пълна информация за резервацията.');
		}
		
		function toggleMenu() {
			const navMenu = document.getElementById('navMenu');
			navMenu.classList.toggle('active');
		}
	</script>
</body>
</html>