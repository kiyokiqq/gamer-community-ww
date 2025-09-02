<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gamer Community</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Підключаємо сучасний шрифт -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

body {
    overflow-x: hidden;
    background: linear-gradient(to bottom right, #1e1b3c, #4f2d7f, #6b4ff5);
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    position: relative;
    color: #E5E7EB;
}

/* Анімований фон */
body::before {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: radial-gradient(circle at 20% 20%, rgba(255,0,150,0.1), transparent 25%),
                radial-gradient(circle at 80% 80%, rgba(0,200,255,0.1), transparent 25%);
    animation: float 20s infinite alternate;
    z-index: -1;
}
@keyframes float {
    0% { transform: translate(0,0);}
    100% { transform: translate(30px,30px);}
}

/* Навігація */
nav {
    position: fixed;
    top:0;
    width: 100%;
    z-index: 50;
    backdrop-filter: blur(14px);
    background-color: rgba(20, 20, 35, 0.75);
    padding: 0.85rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
}

/* Hero Buttons */
.btn-glow {
    position: relative;
    display: inline-block;
    padding: 0.9rem 2.2rem;
    font-weight: 700;
    font-size: 1.05rem;
    color: white;
    border-radius: 2rem;
    text-decoration: none;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.btn-green {
    background: linear-gradient(135deg, #34d399, #059669);
}
.btn-blue {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
}
.btn-glow:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 0 20px rgba(255,255,255,0.25), 0 0 40px rgba(255,255,255,0.15);
}
.btn-glow::before {
    content: "";
    position: absolute;
    top: 0;
    left: -75%;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        120deg,
        rgba(255, 255, 255, 0.35) 0%,
        rgba(255, 255, 255, 0.1) 50%,
        transparent 100%
    );
    transform: skewX(-20deg);
}
.btn-glow:hover::before {
    animation: shine 1s forwards;
}
@keyframes shine {
    0% { left: -75%; }
    100% { left: 125%; }
}

/* Слайдер */
.slider-container {
    position: relative;
    overflow: visible;
    max-width: 1200px;
    margin: 6rem auto 2rem auto;
    padding: 1rem 0;
}
.slider {
    display: flex;
    gap: 1.5rem;
    padding: 0 10px;
    will-change: transform;
}

/* Картки */
.slide {
    flex: 0 0 300px;
    background: linear-gradient(135deg, rgba(35,35,55,0.9), rgba(55,55,75,0.85));
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 12px 28px rgba(0,0,0,0.55);
    transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1), 
                box-shadow 0.5s ease, 
                background 0.5s ease;
    position: relative;
    z-index: 1;
}

.slide:hover {
    transform: translateY(-10px) scale(1.05); /* плавний підйом і збільшення */
    box-shadow: 0 18px 45px rgba(0,0,0,0.6), 0 0 20px rgba(255,255,255,0.06);
    background: linear-gradient(135deg, rgba(25,25,40,0.9), rgba(45,45,65,0.9));
    z-index: 10;
}

@keyframes bounceIn {
    0%   { transform: translateY(0) scale(1); }
    40%  { transform: translateY(-14px) scale(1.08); }
    70%  { transform: translateY(-9px) scale(1.04); }
    100% { transform: translateY(-12px) scale(1.07); }
}
.slide h3 {
    font-size: 1.45rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    background: linear-gradient(to right, #F472B6, #8B5CF6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.slide p {
    color: #D1D5DB;
    line-height: 1.6;
    font-size: 0.95rem;
}

/* Прогресбар */
.slider-progress {
    position: relative;
    height: 5px;
    background: linear-gradient(to right, #F472B6, #8B5CF6);
    border-radius: 9999px;
    width: 0%;
    margin-top: 10px;
    z-index: 1;
}

/* Кнопки під прогресбаром */
.slider-btn {
    position: absolute;
    top: 100%; 
    transform: translateY(10px);
    background: rgba(255,255,255,0.15);
    border: none;
    padding: 0.75rem 1rem;
    font-size: 1.5rem;
    color: white;
    cursor: pointer;
    border-radius: 9999px;
    z-index: 10;
    transition: background 0.3s, transform 0.3s;
}
.slider-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: scale(1.1);
}
.slider-btn-left { left: 30%; }
.slider-btn-right { right: 30%; }

/* Адаптивність */
@media (max-width: 768px) {
    .slide { flex: 0 0 250px; padding: 1.5rem; }
    .slider-btn-left { left: 20%; }
    .slider-btn-right { right: 20%; }
}
@media (max-width: 480px) {
    .slide { flex: 0 0 200px; padding: 1rem; }
    .slider-btn-left, .slider-btn-right { font-size: 1.2rem; padding: 0.5rem 0.8rem; }
}

.btn-custom {
    position: relative;
    display: inline-block;
    padding: 0.9rem 2.2rem;
    font-weight: 700;
    font-size: 1rem;
    color: #fff;
    border-radius: 2rem;
    text-decoration: none;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
}

/* Зелена кнопка */
.btn-green {
    background: linear-gradient(135deg, #34d399, #059669);
    box-shadow: 0 4px 15px rgba(52, 211, 153, 0.4);
}

/* Синя кнопка */
.btn-blue {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
}

/* Ефект при наведенні */
.btn-custom:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.4), 0 0 15px rgba(255,255,255,0.08);
}

/* Анімація "shine" */
.btn-custom::before {
    content: "";
    position: absolute;
    top: 0;
    left: -75%;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        120deg,
        rgba(255,255,255,0.3) 0%,
        rgba(255,255,255,0.1) 50%,
        transparent 100%
    );
    transform: skewX(-20deg);
    transition: all 0.5s ease;
}
.btn-custom:hover::before {
    left: 125%;
}

/* Активний стан (клік) */
.btn-custom:active {
    transform: scale(0.97);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

/* Додаткові стилі для мобільних */
@media (max-width: 768px) {
    .btn-custom {
        padding: 0.8rem 1.8rem;
        font-size: 0.95rem;
    }
}
@media (max-width: 480px) {
    .btn-custom {
        padding: 0.7rem 1.5rem;
        font-size: 0.9rem;
    }
}


</style>

</head>
<body class="relative min-h-screen flex flex-col">

<!-- Navbar -->
<nav class="w-full px-8 py-4 flex justify-between items-center shadow-xl">
    <h1 class="text-3xl font-extrabold text-white tracking-wide drop-shadow-lg">Gamer Community</h1>
    <div class="space-x-6 flex flex-wrap justify-center gap-4">
    <a href="{{ route('register') }}" class="btn-glow btn-green">Get Started</a>
    <a href="{{ route('login') }}" class="btn-glow btn-blue">Log In</a>
</div>
</nav>

<!-- Hero Section -->
<div class="flex-grow flex flex-col items-center justify-center text-center px-6 pt-36 md:pt-40">
    <h2 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400 drop-shadow-2xl mb-6 animate-pulse">
        Connect with Gamers in Your City
    </h2>
    <p class="text-gray-300 text-lg md:text-xl max-w-3xl mb-10 drop-shadow-lg">
        Join our community, share gameplay moments, find teammates, post memes, and stay updated with local events.
    </p>
    <div class="space-x-6 flex flex-wrap justify-center gap-4">
    <a href="{{ route('register') }}" class="btn-custom btn-green">Get Started</a>
    <a href="{{ route('login') }}" class="btn-custom btn-blue">Log In</a>
</div>
</div>

<!-- Features Slider Section -->
<section class="py-12 px-6 mt-12 relative">
    <h2 class="text-4xl font-bold text-white mb-6 text-center drop-shadow-lg">Community Features</h2>
    <div class="slider-container relative">
        <div class="slider" id="slider">
            <div class="slide"><h3>Find Teammates</h3><p>Search for players in your city with similar interests and skill levels.</p></div>
            <div class="slide"><h3>Share Memes & Posts</h3><p>Post gameplay highlights, funny moments, and interact with other community members.</p></div>
            <div class="slide"><h3>Stay Updated</h3><p>Follow events, tournaments, and local gaming news.</p></div>
            <div class="slide"><h3>Join Teams</h3><p>Request or invite players to create gaming squads in your city.</p></div>
            <div class="slide"><h3>Extra Slide 1</h3><p>Example additional slide for continuity.</p></div>
            <div class="slide"><h3>Extra Slide 2</h3><p>Example additional slide for continuity.</p></div>
        </div>
        <div class="slider-progress" id="slider-progress"></div>
        <button class="slider-btn slider-btn-left">&#8249;</button>
        <button class="slider-btn slider-btn-right">&#8250;</button>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 py-8 text-center text-sm shadow-inner relative z-10 mt-auto">
    &copy; {{ date('Y') }} Gamer Community. All rights reserved.
</footer>

<!-- Slider Script -->
<script>
const slider = document.getElementById('slider');
const leftBtn = document.querySelector('.slider-btn-left');
const rightBtn = document.querySelector('.slider-btn-right');
const progress = document.getElementById('slider-progress');

let baseSpeed = 0.5;
let speed = baseSpeed;
let targetSpeed = baseSpeed;

// Подвоюємо картки для безшовного скролу
slider.innerHTML += slider.innerHTML;
const slidesCount = slider.children.length / 2;
let scrollPos = 0;

// Hover уповільнення
slider.addEventListener('mouseenter', () => targetSpeed = baseSpeed * 0.2);
slider.addEventListener('mouseleave', () => targetSpeed = baseSpeed);

function lerp(a, b, n){ return (1 - n) * a + n * b; }

function autoScroll() {
    speed = lerp(speed, targetSpeed, 0.05);
    scrollPos += speed;

    // Зациклення безшовного скролу
    const slideWidth = slider.children[0].offsetWidth + 24; 
    const totalWidth = slideWidth * slidesCount;
    if(scrollPos >= totalWidth) scrollPos = 0;

    slider.style.transform = `translateX(-${scrollPos}px)`;

    // Прогресбар
    let percent = (scrollPos / totalWidth) * 100;
    progress.style.width = `${percent}%`;

    requestAnimationFrame(autoScroll);
}

// Кнопки під прогресбаром
leftBtn.addEventListener('click', () => scrollPos = Math.max(0, scrollPos - 600));
rightBtn.addEventListener('click', () => scrollPos += 600);

requestAnimationFrame(autoScroll);
</script>
</body>
</html>
