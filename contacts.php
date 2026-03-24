<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/x-icon" href="logo.png">
    <title>Контакти - СПА Комплекс "Cherry"</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
     <style>
        .contacts-page {
            min-height: 100vh;
        }
        
        .contacts-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 10px;
        }
        
        .page-header h1 {
            font-size: 48px;
            color: #d4265b;
            margin-bottom: 10px;
        }
        
        .page-header p {
            font-size: 18px;
            color: #555;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .info-card {
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
        }
        
        .info-card h2 {
            color: #d4265b;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
            border-bottom: 3px solid #d4265b;
            padding-bottom: 10px;
        }
        
        .info-item {
            display: flex;
            align-items: start;
            margin-bottom: 15px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 8px;
        }
        
        .info-icon {
            font-size: 24px;
            margin-right: 15px;
            min-width: 30px;
        }
        
        .info-text strong {
            display: block;
            color: #d4265b;
            margin-bottom: 5px;
        }
        
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .schedule-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .schedule-table td:first-child {
            font-weight: 600;
            color: #d4265b;
            width: 40%;
        }
        
        .map-container {
            background: white;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
            margin-bottom: 40px;
        }
        
        .map-container h2 {
            color: #d4265b;
            margin-top: 0;
            margin-bottom: 20px;
        }
        
        .map-frame {
            width: 100%;
            height: 450px;
            border: none;
            border-radius: 12px;
        }
        
        .about-section {
            background: white;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
            margin-bottom: 40px;
        }
        
        .about-section h2 {
            color: #d4265b;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 32px;
            text-align: center;
        }
        
        .about-section p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 15px;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        
        .feature-card {
            text-align: center;
            padding: 25px;
            background: #fef1f7ff;
            border-radius: 12px;
            border: 2px solid #d4265b;
        }
        
        .feature-card .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .feature-card h3 {
            color: #d4265b;
            margin-bottom: 10px;
        }
        
        .feature-card p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: #d4265b;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.25s;
        }
        
        .back-link:hover {
            background: #1b5e20;
        }
        
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .page-header h1 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body class="contacts-page">
<!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo"><img src="logo.png" width="25" class="logo-img"/>СПА "Cherry"</div>
            <ul class="nav-menu" id="navMenu">
                <a href="usercp.php">Нова резервация</a>
                <a href="userorders.php">Моите резервации</a>
                <li><a href="contacts.php">Контакти</a></li>
                <a href="logout.php">Изход</a>
            </ul>
        </div>
    </nav>
<div class="contacts-container">
    
    <div class="page-header">
        <h1>СПА Комплекс "Cherry"</h1>
        <p>Вашето място за релакс и възстановяване</p>
    </div>
        <!-- <div class="nav-links">
        <a href="usercp.php">Нова резервация</a>
        <a href="userorders.php">Моите резервации</a>
        <a href="logout.php">Изход</a>
    </div> -->

    <!-- За Нас -->
    <div class="about-section">
        <h2>За Нас</h2>
        <p>
            СПА Комплекс "Cherry" е модерен оазис на спокойствието, разположен в сърцето на Варна. 
            От нашето основаване през 2015 година, ние се стремим да предоставим на нашите клиенти 
            незабравимо изживяване чрез съчетание на традиционни техники и съвременни СПА процедури.
        </p>
        <p>
            Нашият екип от професионални терапевти и козметици е преминал специализирано обучение 
            в водещи СПА центрове в Европа и Азия. Използваме само висококачествени натурални продукти 
            и най-новите технологии в областта на wellness индустрията.
        </p>
        <p>
            В "Cherry" вярваме, че грижата за тялото и духа е инвестиция в здравето и щастието. 
            Нашата мисия е да създадем пространство, където можете да се отпуснете, да се възстановите 
            и да открие отново хармонията със себе си.
        </p>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="icon">🌿</div>
                <h3>Натурални Продукти</h3>
                <p>Използваме само био сертифицирани продукти от най-високо качество</p>
            </div>
            <div class="feature-card">
                <div class="icon">👨‍⚕️</div>
                <h3>Професионален Екип</h3>
                <p>Висококвалифицирани специалисти с международен опит</p>
            </div>
            <div class="feature-card">
                <div class="icon">✨</div>
                <h3>Луксозна Атмосфера</h3>
                <p>Модерен интериор и спокойна обстановка за пълна релаксация</p>
            </div>
        </div>
    </div>
    
    <!-- Контактна Информация -->
    <div class="content-grid">
        <div class="info-card">
            <h2>📞 Контакти</h2>
            
            <div class="info-item">
                <div class="info-icon">📍</div>
                <div class="info-text">
                    <strong>Адрес:</strong>
                    гр. Варна, бул. "Цар Освободител" 125<br>
                    (до Морската градина)
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">☎️</div>
                <div class="info-text">
                    <strong>Телефон:</strong>
                    +359 52 123 456<br>
                    +359 888 123 456
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">📧</div>
                <div class="info-text">
                    <strong>Имейл:</strong>
                    info@spa-edelweiss.bg<br>
                    reservations@spa-edelweiss.bg
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">🌐</div>
                <div class="info-text">
                    <strong>Социални мрежи:</strong>
                    Facebook: /SpaEdelweissVarna<br>
                    Instagram: @spa_edelweiss
                </div>
            </div>
        </div>
        
        <div class="info-card">
            <h2>🕐 Работно Време</h2>
            
            <table class="schedule-table">
                <tr>
                    <td>Понеделник</td>
                    <td>09:00 - 21:00</td>
                </tr>
                <tr>
                    <td>Вторник</td>
                    <td>09:00 - 21:00</td>
                </tr>
                <tr>
                    <td>Сряда</td>
                    <td>09:00 - 21:00</td>
                </tr>
                <tr>
                    <td>Четвъртък</td>
                    <td>09:00 - 21:00</td>
                </tr>
                <tr>
                    <td>Петък</td>
                    <td>09:00 - 22:00</td>
                </tr>
                <tr>
                    <td>Събота</td>
                    <td>10:00 - 22:00</td>
                </tr>
                <tr>
                    <td>Неделя</td>
                    <td>10:00 - 20:00</td>
                </tr>
            </table>
            
            <div class="info-item" style="margin-top: 20px;">
                <div class="info-icon">⚠️</div>
                <div class="info-text">
                    <strong>Важно:</strong>
                    Препоръчваме предварителна резервация.<br>
                    Последен час за записване: 1 час преди закриване.
                </div>
            </div>
        </div>
    </div>
    
    <!-- Google Maps -->
    <div class="map-container">
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
    
    <!-- Информация за Удобства -->
    <div class="info-card" style="grid-column: 1/-1;">
        <h2>🏛️ Нашите Удобства</h2>
        
        <div class="content-grid">
            <div>
                <h3 style="color: #d4265b;">СПА Зона</h3>
                <ul style="line-height: 2;">
                    <li>Финландска сауна</li>
                    <li>Парна баня</li>
                    <li>Джакузи с хидромасаж</li>
                    <li>Ледена стая</li>
                    <li>Релакс зона с шезлонги</li>
                </ul>
            </div>
            
            <div>
                <h3 style="color: #d4265b;">Допълнителни Услуги</h3>
                <ul style="line-height: 2;">
                    <li>Фитнес зала</li>
                    <li>Здравословно меню в SPA бар</li>
                    <li>Магазин за био козметика</li>
                    <li>VIP стаи за двойки</li>
                    <li>Съблекални с душове</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 40px; padding: 30px; background: white; border-radius: 18px; box-shadow: 0 6px 25px rgba(0,0,0,0.15);">
        <h3 style="color: #d4265b; font-size: 24px;">Очакваме Ви!</h3>
        <p style="font-size: 18px; color: #555;">
            Позволете си да се отпуснете и да се погрижим за Вас.<br>
            Резервирайте своята процедура днес!
        </p>
        <a href="login.php" style="display: inline-block; margin-top: 20px; padding: 15px 40px; background: #d4265b; color: white; text-decoration: none; border-radius: 10px; font-size: 18px; transition: 0.25s;">
            Резервирай Сега
        </a>
    </div>
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

</body>
</html>