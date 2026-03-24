<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <title>Галерия - СПА Комплекс "Cherry"</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="style.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffbdc9, #ffc6a5);
            min-height: 100vh;
        }

        /* ===== PAGE CONTENT ===== */
        .gallery-header {
            max-width: 1200px;
            margin: 60px auto 40px;
            padding: 0 20px;
            text-align: center;
        }

        .gallery-header h1 {
            font-family: "Dancing Script", cursive;
            font-size: 56px;
            color: #d4265b;
            margin-bottom: 15px;
        }

        .gallery-header p {
            font-size: 18px;
            color: #555;
        }

        .filter-buttons {
            max-width: 1200px;
            margin: 0 auto 40px;
            padding: 0 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 12px 30px;
            background: white;
            border: 2px solid #d4265b;
            border-radius: 25px;
            color: #d4265b;
            font-weight: 600;
            cursor: pointer;
        }

        .filter-btn.active,
        .filter-btn:hover {
            background: #d4265b;
            color: white;
        }

        .gallery-container {
            max-width: 1200px;
            margin: 0 auto 80px;
            padding: 0 20px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .gallery-item {
            border-radius: 15px;
            overflow: hidden;
            background: white;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 280px;
            object-fit: cover;
        }

        .gallery-item-overlay {
            padding: 15px;
            background: #d4265b;
            color: white;
        }

        /* ===== LIGHTBOX ===== */
        .lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.9);
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .lightbox.active { display: flex; }

        .lightbox img {
            max-width: 90%;
            max-height: 90vh;
            border-radius: 10px;
        }

        .lightbox-close {
            position: absolute;
            top: 30px;
            right: 40px;
            font-size: 40px;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

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

<!-- ===== CONTENT ===== -->
<div class="gallery-header">
    <h1>Нашата Галерия</h1>
    <p>Разгледайте нашите СПА зони и релакс пространства</p>
</div>

<div class="filter-buttons">
    <button class="filter-btn active" onclick="filterGallery('all')">Всички</button>
    <button class="filter-btn" onclick="filterGallery('spa')">СПА</button>
    <button class="filter-btn" onclick="filterGallery('massage')">Масаж</button>
    <button class="filter-btn" onclick="filterGallery('relax')">Зона за релакс</button>
</div>

<div class="gallery-container">
    <div class="gallery-grid">

        <div class="gallery-item" data-category="relax" onclick="openLightbox(this)">
            <img src="gallery/spa8.jpg" alt="">
            <div class="gallery-item-overlay">Релакс басейн</div>
        </div>

        <div class="gallery-item" data-category="massage" onclick="openLightbox(this)">
            <img src="gallery/spa3.jpg" alt="">
            <div class="gallery-item-overlay">Масажна зала</div>
        </div>

        <div class="gallery-item" data-category="massage" onclick="openLightbox(this)">
            <img src="gallery/spa4.jpg" alt="">
            <div class="gallery-item-overlay">Арома терапия</div>
        </div>

        <div class="gallery-item" data-category="spa" onclick="openLightbox(this)">
            <img src="gallery/spa5.jpg" alt="">
            <div class="gallery-item-overlay">Финландска сауна</div>
        </div>

        <div class="gallery-item" data-category="spa" onclick="openLightbox(this)">
            <img src="gallery/spa6.jpg" alt="">
            <div class="gallery-item-overlay">Парна баня</div>
        </div>

        <div class="gallery-item" data-category="relax" onclick="openLightbox(this)">
            <img src="gallery/spa7.jpg" alt="">
            <div class="gallery-item-overlay">Зона за релакс</div>
        </div>

    </div>
</div>

<!-- ===== LIGHTBOX ===== -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close">&times;</span>
    <img id="lightbox-img">
</div>
    <img src="chb3.png" class="right-image">

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
function filterGallery(category) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');

    document.querySelectorAll('.gallery-item').forEach(item => {
        item.style.display =
            category === 'all' || item.dataset.category === category
            ? 'block' : 'none';
    });
}



function openLightbox(el) {
    document.getElementById('lightbox').classList.add('active');
    document.getElementById('lightbox-img').src = el.querySelector('img').src;
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
}
</script>

</body>
</html>
