<?php
// Определяме активната страница
$current_page = basename($_SERVER['PHP_SELF']);

// Проверяваме дали потребителят е логнат
$is_logged_in = isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] === true;
$is_admin = isset($_SESSION['ur']) && $_SESSION['ur'] == 2;
?>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo"><img src="logo.png" width="25" class="logo-img"/>Cherry</div>
        
        <!-- Hamburger menu -->
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <ul class="nav-menu" id="navMenu">
            <?php if ($is_logged_in): ?>
                <?php if ($is_admin): ?>
                    <!-- Admin навигация -->
                    <li><a href="admin.php" <?php echo $current_page == 'admin.php' ? 'class="active"' : ''; ?>>🏠 Начало</a></li>
                    <li><a href="admin_services.php" <?php echo $current_page == 'admin_services.php' ? 'class="active"' : ''; ?>>🛎️ Услуги</a></li>
                    <li><a href="admin_orders.php" <?php echo $current_page == 'admin_orders.php' ? 'class="active"' : ''; ?>>📋 Резервации</a></li>
                    <li><a href="admin_users.php" <?php echo $current_page == 'admin_users.php' ? 'class="active"' : ''; ?>>👥 Клиенти</a></li>
                <?php else: ?>
                    <!-- User навигация -->
                    <li><a href="usercp.php" <?php echo $current_page == 'usercp.php' ? 'class="active"' : ''; ?>>Нова резервация</a></li>
                    <li><a href="userorders.php" <?php echo $current_page == 'userorders.php' ? 'class="active"' : ''; ?>>Моите резервации</a></li>
                    <li><a href="contacts.php" <?php echo $current_page == 'contacts.php' ? 'class="active"' : ''; ?>>Контакти</a></li>
                <?php endif; ?>
                <li><a href="logout.php" class="logout-btn">🚪 Изход</a></li>
            <?php else: ?>
                <!-- Гост навигация -->
                <li><a href="index.php" <?php echo $current_page == 'index.php' ? 'class="active"' : ''; ?>>Начало</a></li>
                <li><a href="index.php#services">Услуги</a></li>
                <li><a href="gallery.php" <?php echo $current_page == 'gallery.php' ? 'class="active"' : ''; ?>>Галерия</a></li>
                <li><a href="contacts_index.php" <?php echo $current_page == 'contacts_index.php' ? 'class="active"' : ''; ?>>Контакти</a></li>
                <li><a href="login.php" class="login-btn">Вход</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<script>
function toggleMenu() {
    const navMenu = document.getElementById('navMenu');
    navMenu.classList.toggle('active');
}

// Затваряне на менюто при клик върху линк
document.querySelectorAll('.nav-menu a').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            document.getElementById('navMenu').classList.remove('active');
        }
    });
});
</script>