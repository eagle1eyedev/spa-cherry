<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СПА Комплекс "Cherry" - Луксозен релакс във Варна</title>
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="style.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffbdc9, #ffc6a5);
            min-height: 100vh;
        }
        /* Hero Section */
        .hero {
            max-width: 1200px;
            margin: 60px auto;
            padding: 0 20px;
            text-align: center;
        }

        .hero h1 {
            font-family: "Dancing Script", cursive;
            font-size: 64px;
            color: #d4265b;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero .subtitle {
            font-size: 24px;
            color: #930f36;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .stars {
            font-size: 32px;
            color: #FFD700;
            margin: 20px 0;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
        }

        .hero p {
            font-size: 18px;
            color: #555;
            max-width: 800px;
            margin: 20px auto;
            line-height: 1.8;
        }

        .cta-buttons {
            margin-top: 40px;
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary, .btn-secondary {
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background: #d4265b;
            color: white;
        }

        .btn-primary:hover {
            background: #930f36;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(212, 38, 91, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #d4265b;
            border: 2px solid #d4265b;
        }

        .btn-secondary:hover {
            background: #d4265b;
            color: white;
        }

        /* Features Section */
        .features {
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            font-size: 42px;
            color: #d4265b;
            margin-bottom: 50px;
            font-family: "Dancing Script", cursive;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 35px rgba(212, 38, 91, 0.2);
        }

        .feature-icon {
            font-size: 56px;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            color: #d4265b;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Services Preview */
        .services-preview {
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .service-item {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #d4265b;
            transition: all 0.3s;
        }

        .service-item:hover {
            border-left-width: 8px;
            transform: translateX(5px);
        }

        .service-item h4 {
            color: #d4265b;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .service-item .price {
            color: #930f36;
            font-weight: 600;
            font-size: 18px;
            margin-top: 10px;
        }

        /* Location Section */
        .location {
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .location-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .location-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 30px;
        }

        .info-item {
            display: flex;
            align-items: start;
            gap: 15px;
            padding: 15px;
            background: #fff5f7;
            border-radius: 10px;
        }

        .info-icon {
            font-size: 28px;
            min-width: 35px;
        }

        .info-text h4 {
            color: #d4265b;
            margin-bottom: 5px;
        }

        .info-text p {
            color: #666;
            line-height: 1.6;
        }

        .map-placeholder {
            width: 100%;
            height: 300px;
            background: #f0f0f0;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 18px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .nav-menu.active {
                display: flex;
            }

            .hero h1 {
                font-size: 42px;
            }

            .hero .subtitle {
                font-size: 20px;
            }

            .location-grid {
                grid-template-columns: 1fr;
            }

            .cta-buttons {
                flex-direction: column;
            }
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

    <!-- Hero Section -->
    <section class="hero" id="home">
        <h1>СПА Комплекс "Cherry"</h1>
        <p class="subtitle">Луксозен 5-звезден СПА център във Варна</p>
        <div class="stars">★★★★★</div>
        <p>
            Открийте оазис на спокойствието и релакса в сърцето на Варна. 
            СПА комплекс "Cherry" предлага изключителни СПА процедури, масажи и wellness програми 
            в луксозна обстановка с професионален екип от сертифицирани терапевти.
        </p>
        <p>
            С над 10 години опит в индустрията, ние сме вашето място за пълно възстановяване 
            на тялото и духа. Използваме само натурални био продукти от най-високо качество.
        </p>
        <div class="cta-buttons">
            <a href="login.php" class="btn-primary">Резервирай сега</a>
            <a href="#services" class="btn-secondary">Разгледай услуги</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2 class="section-title">Защо да изберете нас?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🌿</div>
                <h3>Натурални продукти</h3>
                <p>100% био сертифицирани продукти от водещи производители в Европа</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👨‍⚕️</div>
                <h3>Професионален екип</h3>
                <p>Опитни терапевти с международни сертификати и специализации</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✨</div>
                <h3>Луксозна обстановка</h3>
                <p>Модерен интериор и най-новото оборудване за вашия комфорт</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏆</div>
                <h3>10+ години опит</h3>
                <p>Над 50,000 доволни клиенти и множество награди в бранша</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💎</div>
                <h3>VIP услуги</h3>
                <p>Индивидуални програми и ексклузивни стаи за двойки</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Гъвкави часове</h3>
                <p>Отворени 7 дни в седмицата с удобни часове за резервация</p>
            </div>
        </div>
    </section>

    <!-- Services Preview -->
    <section class="services-preview" id="services">
        <h2 class="section-title">Нашите услуги</h2>
        <div class="services-grid">
            <div class="service-item">
                <h4>СПА Терапии</h4>
                <p>Пълна релаксация с ароматни масла, топла вана и специални процедури</p>
                <div class="price">от 89.90 лв.</div>
            </div>
            <div class="service-item">
                <h4>Масажи</h4>
                <p>Класически, спортни, hot stone и аромотерапевтични масажи</p>
                <div class="price">от 59.90 лв.</div>
            </div>
            <div class="service-item">
                <h4>Козметични процедури</h4>
                <p>Почистване, хидратация и анти-ейдж терапии за лице</p>
                <div class="price">от 49.00 лв.</div>
            </div>
            <div class="service-item">
                <h4>Грижа за тяло</h4>
                <p>Пилинг, обвивки с водорасли и детоксикиращи терапии</p>
                <div class="price">от 55.00 лв.</div>
            </div>
            <div class="service-item">
                <h4>Уелнес програми</h4>
                <p>Комбинирани пакети с масаж, сауна, джакузи и релакс зона</p>
                <div class="price">от 159.00 лв.</div>
            </div>
            <div class="service-item">
                <h4>VIP пакети</h4>
                <p>Ексклузивни програми за двойки и специални поводи</p>
                <div class="price">от 199.00 лв.</div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 40px;">
            <a href="login.php" class="btn-primary">Виж пълен ценоразпис</a>
        </div>
    </section>

    <!-- Location Section -->
    <section class="location">
        <h2 class="section-title">Къде се намираме</h2>
        <div class="location-content">
            <div class="location-grid">
                <div>
                    <div class="info-item">
                        <div class="info-icon">📍</div>
                        <div class="info-text">
                            <h4>Адрес</h4>
                            <p>бул. "Цар Освободител" 125<br>9000 Варна, България<br>(до Морската градина)</p>
                        </div>
                    </div>
                    <div class="info-item" style="margin-top: 20px;">
                        <div class="info-icon">🚗</div>
                        <div class="info-text">
                            <h4>Паркинг</h4>
                            <p>Безплатен подземен паркинг<br>за всички клиенти</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="info-item">
                        <div class="info-icon">🕐</div>
                        <div class="info-text">
                            <h4>Работно време</h4>
                            <p>Пон-Чет: 09:00 - 21:00<br>Петък: 09:00 - 22:00<br>Събота: 10:00 - 22:00<br>Неделя: 10:00 - 20:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="map-container" style="margin-top: 20px;">
        <h2>🗺️ Как да ни намерите</h2>
        <iframe 
            class="map-frame"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2909.3861234567890!2d27.9147!3d43.2141!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDPCsDEyJzUwLjgiTiAyN8KwNTQnNTMuMCJF!5e0!3m2!1sbg!2sbg!4v1234567890123!5m2!1sbg!2sbg"
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        
        <div style="margin-top: 20px; padding: 15px; background: #f0f8f0; border-radius: 8px;">
            <strong style="color: #d4265b;">🚗 Паркинг:</strong> Безплатен подземен паркинг за клиенти<br>
            <strong style="color: #d4265b;">🚌 Обществен транспорт:</strong> Автобуси 9, 109, 409 - спирка "Морска градина"<br>
            <strong style="color: #d4265b;">♿ Достъпност:</strong> Рампа за инвалидни колички при главния вход
        </div>
    </div>
    
    </section>

        <img src="chb2.png" class="left-image">

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

    <script>
        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>

</body>
</html>