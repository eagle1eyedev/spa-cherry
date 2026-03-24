<!DOCTYPE html>
<html lang="bg">
<head>
	<meta charset="utf-8" />
	<title>Информация за клиентите - Администрация</title>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
	<style>
		.users-table {
			width: 100%;
			background: white;
			border-radius: 12px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
			margin-top: 20px;
		}
		.users-table table {
			width: 100%;
			border-collapse: collapse;
			table-layout: fixed;
		}
		.users-table th {
			background: #d4265b;
			color: white;
			padding: 15px 10px;
			text-align: left;
			font-weight: 600;
			font-size: 13px;
		}
		.users-table td {
			padding: 10px;
			border-bottom: 1px solid #f0f0f0;
			font-size: 13px;
			word-wrap: break-word;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		.users-table tr:hover {
			background: #fff5f7;
		}
		.rank-badge {
			padding: 5px 12px;
			border-radius: 15px;
			font-size: 12px;
			font-weight: 600;
			display: inline-block;
		}
		.rank-1 {
			background: #e3f2fd;
			color: #1976d2;
		}
		.rank-2 {
			background: #fce4ec;
			color: #c2185b;
		}
		.filter-section {
			background: white;
			padding: 20px;
			border-radius: 12px;
			margin-bottom: 20px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
		}
		.filter-section input, .filter-section select {
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
			padding: 25px;
			border-radius: 12px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.1);
			text-align: center;
		}
		.stat-number {
			font-size: 36px;
			font-weight: 700;
			color: #d4265b;
		}
		.stat-label {
			color: #666;
			margin-top: 5px;
		}
		.stat-icon {
			font-size: 28px;
			margin-bottom: 10px;
		}
		.search-box {
			padding: 12px;
			border: 2px solid #d4265b;
			border-radius: 25px;
			width: 300px;
			font-size: 14px;
			outline: none;
		}
		.search-box:focus {
			box-shadow: 0 0 10px rgba(212, 38, 91, 0.3);
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

	// Търсене и филтриране
	$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';
	$rank_filter = isset($_GET['rank']) ? intval($_GET['rank']) : 0;

	$where_conditions = [];
	if($search) {
		$where_conditions[] = "(p.ime_potrebitel LIKE '%$search%' OR p.familiq_potrebitel LIKE '%$search%' OR p.username_potrebitel LIKE '%$search%' OR p.email_potrebitel LIKE '%$search%' OR p.telefon_potrebitel LIKE '%$search%')";
	}
	if($rank_filter > 0) {
		$where_conditions[] = "p.rank_id = $rank_filter";
	}

	$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

	// Статистика
	$total_users = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM potrebiteli"))['count'];
	$regular_clients = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM potrebiteli WHERE rank_id=1"))['count'];
	$admins = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM potrebiteli WHERE rank_id=2"))['count'];
	$new_today = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as count FROM potrebiteli WHERE DATE(data_registraciq)=CURDATE()"))['count'];
	$active_clients = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(DISTINCT id_potrebitel) as count FROM reservations WHERE status='confirmed'"))['count'];
	?>

	<h1 style="color:#d4265b;">Информация за клиентите</h1>
	
	<div style="margin-bottom: 20px;">
		<a href="admin.php" style="color: #d4265b; text-decoration: none; font-weight: 500;">← Назад към администрация</a>
	</div>

	<!-- Статистика -->
	<div class="stats-grid">
		<div class="stat-card">
			<div class="stat-icon">👥</div>
			<div class="stat-number"><?php echo $total_users; ?></div>
			<div class="stat-label">Общо потребители</div>
		</div>
		<div class="stat-card">
			<div class="stat-icon">👤</div>
			<div class="stat-number"><?php echo $regular_clients; ?></div>
			<div class="stat-label">Клиенти</div>
		</div>
		<div class="stat-card">
			<div class="stat-icon">⚙️</div>
			<div class="stat-number"><?php echo $admins; ?></div>
			<div class="stat-label">Администратори</div>
		</div>
		<div class="stat-card">
			<div class="stat-icon">✅</div>
			<div class="stat-number"><?php echo $active_clients; ?></div>
			<div class="stat-label">Активни клиенти</div>
		</div>
		<div class="stat-card">
			<div class="stat-icon">🆕</div>
			<div class="stat-number"><?php echo $new_today; ?></div>
			<div class="stat-label">Нови днес</div>
		</div>
	</div>

	<!-- Търсене и филтри -->
	<div class="filter-section">
		<form method="GET" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
			<input type="text" name="search" class="search-box" placeholder="🔍 Търси по име, имейл, телефон..." value="<?php echo htmlspecialchars($search); ?>">
			<select name="rank">
				<option value="0">Всички рангове</option>
				<option value="1" <?php echo $rank_filter == 1 ? 'selected' : ''; ?>>Клиент</option>
				<option value="2" <?php echo $rank_filter == 2 ? 'selected' : ''; ?>>Администратор</option>
			</select>
			<button type="submit" style="padding: 10px 20px; background: #d4265b; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Търси</button>
			<a href="?" style="padding: 10px 20px; background: #666; color: white; border: none; border-radius: 8px; text-decoration: none; font-weight: 600;">Изчисти</a>
		</form>
	</div>

	<!-- Таблица с клиенти -->
	<div class="users-table">
		<table>
			<thead>
				<tr>
					<th style="width: 5%;">ID</th>
					<th style="width: 15%;">Име</th>
					<th style="width: 10%;">Потребителско име</th>
					<th style="width: 15%;">Email</th>
					<th style="width: 10%;">Телефон</th>
					<th style="width: 15%;">Адрес</th>
					<th style="width: 8%;">Ранг</th>
					<th style="width: 7%;">Резервации</th>
					<th style="width: 8%;">Харчени пари</th>
					<th style="width: 7%;">Дата на регистрация</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$query = "SELECT p.*, r.rank_ime,
						  (SELECT COUNT(*) FROM reservations WHERE id_potrebitel = p.id_potrebitel AND status='confirmed') as total_reservations,
						  (SELECT SUM(s.price * res.quantity) FROM reservations res JOIN spa_services s ON res.id_service = s.id_service WHERE res.id_potrebitel = p.id_potrebitel AND res.status='confirmed') as total_spent
						  FROM potrebiteli p
						  JOIN rankove r ON p.rank_id = r.rank_id
						  $where_clause
						  ORDER BY p.data_registraciq DESC";
				$result = mysqli_query($connect, $query);

				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$rank_class = 'rank-' . $row['rank_id'];
						$total_spent = $row['total_spent'] ?? 0;

						echo '<tr>';
						echo '<td><b>#'.$row['id_potrebitel'].'</b></td>';
						echo '<td><b>'.$row['ime_potrebitel'].' '.$row['familiq_potrebitel'].'</b></td>';
						echo '<td>'.$row['username_potrebitel'].'</td>';
						echo '<td>'.$row['email_potrebitel'].'</td>';
						echo '<td>'.$row['telefon_potrebitel'].'</td>';
						echo '<td>'.$row['adres_potrebitel'].'</td>';
						echo '<td><span class="rank-badge '.$rank_class.'">'.$row['rank_ime'].'</span></td>';
						echo '<td><b style="color:#d4265b;">'.$row['total_reservations'].'</b></td>';
						echo '<td><b style="color:#930f36;">'.number_format($total_spent, 2).' лв</b></td>';
						echo '<td>'.date('d.m.Y', strtotime($row['data_registraciq'])).'</td>';
						echo '</tr>';
					}
				} else {
					echo '<tr><td colspan="10" style="text-align:center; padding:30px; color:#999;">Няма намерени клиенти</td></tr>';
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
		function toggleMenu() {
			const navMenu = document.getElementById('navMenu');
			navMenu.classList.toggle('active');
		}
	</script>
</body>
</html>