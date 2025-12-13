<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KFFHE33255"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-KFFHE33255');
</script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technova Technologies - Premium Tech Company </title>
  <meta name="description" content="A holistic tech Company specializing in UI/UX, web design, web development, and ecommerce solutions.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script type="text/javascript" src="script.js"></script>


  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#E11D48',
            secondary: '#111827',
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          animation: {
            'spin-slow': 'spin 3s linear infinite',
            'bounce-slow': 'bounce 2s infinite',
            'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
          }
        },
      },
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technova Technologies - Demo Homepage</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#E11D48',
            secondary: '#111827',
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        },
      },
    }
  </script>
  
  <style>
    body {
      font-family: "Inter", sans-serif;
      background-color: black;
      color: white;
    }
    
    .btn {
      display: inline-block;
      padding: 12px 24px;
      background-color: #E11D48;
      color: white;
      border-radius: 50px;
      font-weight: 500;
      transition: all 0.3s ease;
      text-decoration: none;
    }
    
    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(225, 29, 72, 0.3);
    }
    
    .slow-gif {
      animation: slowGif 30s infinite linear;
    }
    
    @keyframes slowGif {
      0% { filter: hue-rotate(0deg); }
      100% { filter: hue-rotate(360deg); }
    }
    
    .hero-text {
      animation: textFadeIn 2s ease-in-out;
    }
    
    .hero-bg {
      opacity: 0;
      animation: bgFadeIn 3s ease-in-out 2s forwards;
    }
    
    @keyframes textFadeIn {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes bgFadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }
    
    @keyframes scroll {
      0% { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }
    
    .animate-scroll {
      animation: scroll 20s linear infinite;
    }
    
    .animate-scroll:hover {
      animation-play-state: paused;
    }
    
    @keyframes banner-scroll {
      0% { transform: translateX(100%); }
      100% { transform: translateX(-100%); }
    }
    
    .animate-banner-scroll {
      animation: banner-scroll 60s linear infinite;
    }
    
    .star-dots {
      position: absolute;
      width: 100%;
      height: 100%;
      overflow: hidden;
    }
    
    .star {
      position: absolute;
      background: white;
      clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
      animation: twinkle 3s ease-in-out infinite alternate;
    }
    
    .star:nth-child(1) { width: 8px; height: 8px; top: 20%; left: 10%; animation-delay: 0s; }
    .star:nth-child(2) { width: 6px; height: 6px; top: 30%; left: 80%; animation-delay: 0.5s; }
    .star:nth-child(3) { width: 10px; height: 10px; top: 60%; left: 20%; animation-delay: 1s; }
    .star:nth-child(4) { width: 4px; height: 4px; top: 80%; left: 70%; animation-delay: 1.5s; }
    .star:nth-child(5) { width: 7px; height: 7px; top: 15%; left: 60%; animation-delay: 2s; }
    .star:nth-child(6) { width: 5px; height: 5px; top: 45%; left: 90%; animation-delay: 2.5s; }
    .star:nth-child(7) { width: 9px; height: 9px; top: 70%; left: 40%; animation-delay: 0.8s; }
    .star:nth-child(8) { width: 6px; height: 6px; top: 25%; left: 30%; animation-delay: 1.2s; }
    .star:nth-child(9) { width: 8px; height: 8px; top: 55%; left: 75%; animation-delay: 1.8s; }
    .star:nth-child(10) { width: 4px; height: 4px; top: 85%; left: 15%; animation-delay: 0.3s; }
    .star:nth-child(11) { width: 3px; height: 3px; top: 12%; left: 45%; animation-delay: 0.7s; }
    .star:nth-child(12) { width: 5px; height: 5px; top: 35%; left: 65%; animation-delay: 1.3s; }
    .star:nth-child(13) { width: 7px; height: 7px; top: 75%; left: 25%; animation-delay: 2.1s; }
    .star:nth-child(14) { width: 4px; height: 4px; top: 50%; left: 5%; animation-delay: 0.9s; }
    .star:nth-child(15) { width: 6px; height: 6px; top: 90%; left: 85%; animation-delay: 1.7s; }
    .star:nth-child(16) { width: 3px; height: 3px; top: 8%; left: 25%; animation-delay: 2.3s; }
    .star:nth-child(17) { width: 8px; height: 8px; top: 40%; left: 50%; animation-delay: 0.4s; }
    .star:nth-child(18) { width: 5px; height: 5px; top: 65%; left: 95%; animation-delay: 1.6s; }
    .star:nth-child(19) { width: 4px; height: 4px; top: 18%; left: 85%; animation-delay: 2.4s; }
    .star:nth-child(20) { width: 7px; height: 7px; top: 82%; left: 55%; animation-delay: 0.6s; }
    .star:nth-child(21) { width: 3px; height: 3px; top: 28%; left: 12%; animation-delay: 1.4s; }
    .star:nth-child(22) { width: 6px; height: 6px; top: 52%; left: 35%; animation-delay: 2.2s; }
    .star:nth-child(23) { width: 4px; height: 4px; top: 72%; left: 78%; animation-delay: 0.2s; }
    .star:nth-child(24) { width: 5px; height: 5px; top: 38%; left: 22%; animation-delay: 1.1s; }
    .star:nth-child(25) { width: 8px; height: 8px; top: 88%; left: 42%; animation-delay: 1.9s; }
    .star:nth-child(26) { width: 3px; height: 3px; top: 5%; left: 72%; animation-delay: 2.7s; }
    .star:nth-child(27) { width: 6px; height: 6px; top: 48%; left: 88%; animation-delay: 0.1s; }
    .star:nth-child(28) { width: 4px; height: 4px; top: 78%; left: 8%; animation-delay: 1.5s; }
    .star:nth-child(29) { width: 7px; height: 7px; top: 22%; left: 52%; animation-delay: 2.6s; }
    .star:nth-child(30) { width: 5px; height: 5px; top: 92%; left: 68%; animation-delay: 0.8s; }
    .star:nth-child(31) { width: 3px; height: 3px; top: 42%; left: 18%; animation-delay: 1.8s; }
    .star:nth-child(32) { width: 6px; height: 6px; top: 62%; left: 82%; animation-delay: 2.5s; }
    .star:nth-child(33) { width: 4px; height: 4px; top: 32%; left: 38%; animation-delay: 0.5s; }
    .star:nth-child(34) { width: 8px; height: 8px; top: 68%; left: 62%; animation-delay: 1.2s; }
    .star:nth-child(35) { width: 5px; height: 5px; top: 58%; left: 28%; animation-delay: 2.0s; }
    .star:nth-child(36) { width: 3px; height: 3px; top: 14%; left: 92%; animation-delay: 0.9s; }
    .star:nth-child(37) { width: 7px; height: 7px; top: 84%; left: 32%; animation-delay: 1.7s; }
    .star:nth-child(38) { width: 4px; height: 4px; top: 26%; left: 58%; animation-delay: 2.4s; }
    .star:nth-child(39) { width: 6px; height: 6px; top: 74%; left: 12%; animation-delay: 0.3s; }
    .star:nth-child(40) { width: 5px; height: 5px; top: 46%; left: 78%; animation-delay: 1.6s; }
    .star:nth-child(41) { width: 3px; height: 3px; top: 7%; left: 33%; animation-delay: 2.8s; }
    .star:nth-child(42) { width: 4px; height: 4px; top: 17%; left: 77%; animation-delay: 0.4s; }
    .star:nth-child(43) { width: 6px; height: 6px; top: 37%; left: 13%; animation-delay: 1.9s; }
    .star:nth-child(44) { width: 5px; height: 5px; top: 67%; left: 87%; animation-delay: 2.3s; }
    .star:nth-child(45) { width: 3px; height: 3px; top: 87%; left: 23%; animation-delay: 0.7s; }
    .star:nth-child(46) { width: 7px; height: 7px; top: 27%; left: 67%; animation-delay: 1.4s; }
    .star:nth-child(47) { width: 4px; height: 4px; top: 57%; left: 47%; animation-delay: 2.7s; }
    .star:nth-child(48) { width: 5px; height: 5px; top: 77%; left: 3%; animation-delay: 0.2s; }
    .star:nth-child(49) { width: 6px; height: 6px; top: 47%; left: 93%; animation-delay: 1.8s; }
    .star:nth-child(50) { width: 3px; height: 3px; top: 97%; left: 53%; animation-delay: 2.1s; }
    .star:nth-child(51) { width: 4px; height: 4px; top: 3%; left: 17%; animation-delay: 0.6s; }
    .star:nth-child(52) { width: 8px; height: 8px; top: 23%; left: 83%; animation-delay: 1.3s; }
    .star:nth-child(53) { width: 5px; height: 5px; top: 43%; left: 37%; animation-delay: 2.6s; }
    .star:nth-child(54) { width: 3px; height: 3px; top: 63%; left: 73%; animation-delay: 0.1s; }
    .star:nth-child(55) { width: 6px; height: 6px; top: 83%; left: 7%; animation-delay: 1.7s; }
    .star:nth-child(56) { width: 4px; height: 4px; top: 13%; left: 43%; animation-delay: 2.4s; }
    .star:nth-child(57) { width: 7px; height: 7px; top: 33%; left: 97%; animation-delay: 0.8s; }
    .star:nth-child(58) { width: 5px; height: 5px; top: 53%; left: 27%; animation-delay: 1.5s; }
    .star:nth-child(59) { width: 3px; height: 3px; top: 73%; left: 63%; animation-delay: 2.9s; }
    .star:nth-child(60) { width: 6px; height: 6px; top: 93%; left: 37%; animation-delay: 0.3s; }
    .star:nth-child(61) { width: 4px; height: 4px; top: 9%; left: 59%; animation-delay: 1.1s; }
    .star:nth-child(62) { width: 5px; height: 5px; top: 29%; left: 19%; animation-delay: 2.2s; }
    .star:nth-child(63) { width: 3px; height: 3px; top: 49%; left: 79%; animation-delay: 0.5s; }
    .star:nth-child(64) { width: 7px; height: 7px; top: 69%; left: 9%; animation-delay: 1.6s; }
    .star:nth-child(65) { width: 6px; height: 6px; top: 89%; left: 89%; animation-delay: 2.5s; }
    .star:nth-child(66) { width: 4px; height: 4px; top: 19%; left: 49%; animation-delay: 0.9s; }
    .star:nth-child(67) { width: 5px; height: 5px; top: 39%; left: 29%; animation-delay: 1.8s; }
    .star:nth-child(68) { width: 3px; height: 3px; top: 59%; left: 69%; animation-delay: 2.7s; }
    .star:nth-child(69) { width: 8px; height: 8px; top: 79%; left: 39%; animation-delay: 0.4s; }
    .star:nth-child(70) { width: 6px; height: 6px; top: 99%; left: 99%; animation-delay: 1.2s; }
    .star:nth-child(71) { width: 4px; height: 4px; top: 1%; left: 1%; animation-delay: 2.8s; }
    .star:nth-child(72) { width: 5px; height: 5px; top: 21%; left: 61%; animation-delay: 0.7s; }
    .star:nth-child(73) { width: 3px; height: 3px; top: 41%; left: 21%; animation-delay: 1.4s; }
    .star:nth-child(74) { width: 7px; height: 7px; top: 61%; left: 81%; animation-delay: 2.1s; }
    .star:nth-child(75) { width: 6px; height: 6px; top: 81%; left: 41%; animation-delay: 0.6s; }
    .star:nth-child(76) { width: 4px; height: 4px; top: 11%; left: 71%; animation-delay: 1.9s; }
    .star:nth-child(77) { width: 5px; height: 5px; top: 31%; left: 31%; animation-delay: 2.6s; }
    .star:nth-child(78) { width: 3px; height: 3px; top: 51%; left: 91%; animation-delay: 0.2s; }
    .star:nth-child(79) { width: 8px; height: 8px; top: 71%; left: 51%; animation-delay: 1.7s; }
    .star:nth-child(80) { width: 6px; height: 6px; top: 91%; left: 11%; animation-delay: 2.4s; }
    .star:nth-child(81) { width: 4px; height: 4px; top: 6%; left: 36%; animation-delay: 0.8s; }
    .star:nth-child(82) { width: 5px; height: 5px; top: 26%; left: 76%; animation-delay: 1.5s; }
    .star:nth-child(83) { width: 3px; height: 3px; top: 46%; left: 16%; animation-delay: 2.3s; }
    .star:nth-child(84) { width: 7px; height: 7px; top: 66%; left: 86%; animation-delay: 0.1s; }
    .star:nth-child(85) { width: 6px; height: 6px; top: 86%; left: 46%; animation-delay: 1.8s; }
    .star:nth-child(86) { width: 4px; height: 4px; top: 16%; left: 56%; animation-delay: 2.7s; }
    .star:nth-child(87) { width: 5px; height: 5px; top: 36%; left: 96%; animation-delay: 0.5s; }
    .star:nth-child(88) { width: 3px; height: 3px; top: 56%; left: 26%; animation-delay: 1.2s; }
    .star:nth-child(89) { width: 8px; height: 8px; top: 76%; left: 66%; animation-delay: 2.9s; }
    .star:nth-child(90) { width: 6px; height: 6px; top: 96%; left: 6%; animation-delay: 0.3s; }
    .star:nth-child(91) { width: 4px; height: 4px; top: 4%; left: 44%; animation-delay: 1.6s; }
    .star:nth-child(92) { width: 5px; height: 5px; top: 24%; left: 84%; animation-delay: 2.2s; }
    .star:nth-child(93) { width: 3px; height: 3px; top: 44%; left: 24%; animation-delay: 0.9s; }
    .star:nth-child(94) { width: 7px; height: 7px; top: 64%; left: 64%; animation-delay: 1.3s; }
    .star:nth-child(95) { width: 6px; height: 6px; top: 84%; left: 4%; animation-delay: 2.6s; }
    .star:nth-child(96) { width: 4px; height: 4px; top: 14%; left: 74%; animation-delay: 0.4s; }
    .star:nth-child(97) { width: 5px; height: 5px; top: 34%; left: 14%; animation-delay: 1.7s; }
    .star:nth-child(98) { width: 3px; height: 3px; top: 54%; left: 54%; animation-delay: 2.5s; }
    .star:nth-child(99) { width: 8px; height: 8px; top: 74%; left: 94%; animation-delay: 0.7s; }
    .star:nth-child(100) { width: 6px; height: 6px; top: 94%; left: 34%; animation-delay: 1.1s; }
    
    @keyframes twinkle {
      0% { opacity: 0.3; transform: scale(1); }
      50% { opacity: 1; transform: scale(1.2); }
      100% { opacity: 0.3; transform: scale(1); }
    }
  </style>
</head>
<body>
  <div id="preloader" class="fixed inset-0 flex items-center justify-center bg-black z-50">
    <div class="loader relative">
      <div class="loader-ring w-20 h-20"></div>
      <div class="loader-ring w-16 h-16 absolute top-0 left-0"></div>
      <div class="loader-ring w-12 h-12 absolute top-0 left-0"></div>
      <div class="circle">
        <img src="logo.svg" alt="Technova Technologies Logo" class="logo" />
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="hidden" id="main-content">
    <h1 class="text-3xl text-center mt-10">Welcome to Technova Technologies</h1>
    <p class="text-center mt-4">Your one-stop solution for technology needs.</p>
  </div>

  <!-- Custom Cursor -->
  <div class="cursor-dot hidden md:block"></div>
  <div class="cursor-outline hidden md:block"></div>

 <!-- Header/Navigation -->
  <header class="fixed top-0 w-full z-50 transition-all duration-300" style="background-color: rgba(0,0,0,0.9); backdrop-filter: blur(10px);">
  <div class="container mx-auto px-4 flex h-20 items-center justify-between">
    <a href="#" class="flex items-center gap-2 group">
      <img src="logo.svg" alt="Logo" class="h-8 sm:h-10 w-auto transition-transform duration-300 transform group-hover:scale-110" />
    </a>
    
    <!-- Desktop Navigation (Hidden on Tablet) -->
    <nav class="hidden md:flex items-center gap-12 lg:gap-8">
      <a href="index.php" class="text-base font-medium text-white hover:text-red-600 transition-colors duration-300">Home</a>
      <a href="service.php" class="text-base font-medium text-white hover:text-red-600 transition-colors duration-300">Services</a>
      <a href="hireteam.php" class="text-base font-medium text-white hover:text-red-600 transition-colors duration-300">Hire Team</a>
      <div class="relative group">
        <button class="text-base font-medium text-white hover:text-red-600 transition-colors duration-300 flex items-center gap-1">
          Work
          <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <div class="absolute top-full left-0 mt-2 w-48 bg-black bg-opacity-90 backdrop-blur-md rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
          <div class="py-2">
            <a href="portfolio.php" class="block px-4 py-2 text-white hover:text-red-600 hover:bg-gray-800 transition-colors duration-300">Portfolio</a>
            <a href="product.php" class="block px-4 py-2 text-white hover:text-red-600 hover:bg-gray-800 transition-colors duration-300">Product</a>
          </div>
        </div>
      </div>
      <a href="about.php" class="text-base font-medium text-white hover:text-red-600 transition-colors duration-300">About</a>
      <a href="carrer.php" class="text-base font-medium text-white hover:text-red-600 transition-colors duration-300">Careers</a>
    </nav>

    <!-- Contact Button -->
    <div class="hidden md:block">
      <a href="contact.php" class="btn text-sm sm:text-base py-2 px-4 sm:py-3 sm:px-6">
        Contact Us
      </a>
    </div>

   <!-- Mobile Menu Button -->
<button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
  </svg>
</button>

<!-- Mobile Navigation -->
<div id="mobile-menu" class="hidden md:hidden absolute top-20 left-0 w-full bg-black bg-opacity-90 backdrop-blur-md shadow-lg">
  <nav class="flex flex-col items-center gap-4 py-6">
    <a href="index.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Home</a>
    <a href="service.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Services</a>
    <a href="hireteam.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Hire Team</a>
    <a href="portfolio.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Portfolio</a>
    <a href="product.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Product</a>
    <a href="about.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">About</a>
    <a href="carrer.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Careers</a>
    <a href="contact.php" class="btn text-sm sm:text-base py-2 px-4 sm:py-3 sm:px-6">Contact Us</a>
  </nav>
</div>

</header>




<dotlottie-player
  src="https://lottie.host/864db599-ae0e-4760-9342-70013d44f453/jfImXNzlZP.lottie"
  background="transparent"
  speed="1"
  style="width: 480px; height: 480px"
  loop
  autoplay
></dotlottie-player>
    </div>


<div id="whatsappDrawer" style="
    position: fixed;
    right: -220px; /* Hidden by default */
    top: 80%;
    transform: translateY(-50%);
    width: 180px;
    background-color: #e11d48;
    color: white;
    padding: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    transition: right 0.3s ease-in-out;
    z-index: 1000;
    border-radius: 10px 0px 0px 10px; /* Curvy edges */
">
    <a href="https://wa.me/919427300816" target="_blank" style="
        color: white;
        text-decoration: none;
        font-weight: bold;
        display: block;
        text-align: center;
    ">Chat on WhatsApp</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.addEventListener('scroll', function () {
            const drawer = document.getElementById('whatsappDrawer');
            if (window.scrollY > 200) { // Show when scrolling past 100px
                drawer.style.right = "0";
            } else {
                drawer.style.right = "-220px";
            }
        });
    });
</script>



  <!-- Main Content -->
  <main class="pt-20">
    <!-- Hero Section -->
    <section class="py-20 min-h-screen flex items-center relative overflow-hidden">
      <!-- Background Images -->
      <div class="absolute inset-0 z-0 hero-bg">
        <img src="uploads/images/Homebg1.gif" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-20 slow-gif">
        <img src="uploads/images/Homebg2.png" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-80" style="mix-blend-mode: screen;">
        
        <!-- Star Dots -->
        <div class="star-dots">
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
          <div class="star"></div>
        </div>

        <div class="absolute inset-0 bg-black/30"></div>
      </div>
      
      <div class="container mx-auto px-4 text-center relative z-10 hero-text">
        <h1 class="text-5xl md:text-7xl font-bold mb-6">
          HAVE AN <span class="text-red-600">IDEA</span><br>
          THAT WILL CHANGE THE <span class="text-red-600">WORLD</span>...?
        </h1>
        <p class="text-2xl text-gray-300 mb-8 max-w-2xl mx-auto">
          WE HELP YOU ACCOMPLISH IT
        </p>
        <div class="flex justify-center">
          <a href="contact.php" class="bg-red-600 hover:bg-red-700 text-white px-12 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105">JOIN NOW</a>
        </div>
      </div>
    </section>

    <!-- Technova Technologies Section -->
    <section class="py-16 sm:py-20 relative overflow-hidden bg-black">
      <!-- Background Text -->
      
      <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <!-- Left Content -->
          <div>
            <div class="mb-16">
          <h1 class="text-6xl sm:text-7xl lg:text-8xl font-black text-gray-400 opacity-30 tracking-[0.1em] mb-8">
            TECHNOVA TECHNOLOGIES
          </h1>
        </div>
           
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-8 leading-tight">
              We assure you nothing less than the best!
            </h2>
            
            <div class="space-y-6 text-gray-300">
              <p class="text-lg leading-relaxed">
                With a decade of dedicated service in the IT industry, Technova Technologies has been a trusted partner for businesses seeking excellence in technology solutions. Our commitment revolves around ensuring client satisfaction through cost-effective and high-quality results. We specialize in delivering tailored IT services that meet the unique needs of our clients, ensuring seamless integration and enhanced operational efficiency.
              </p>
              
              <p class="text-lg leading-relaxed">
                At Technova Technologies, we believe in forging long-lasting partnerships built on trust, reliability, and innovation. Our team of experienced professionals is passionate about delivering excellent solutions. We consistently create advanced solutions that help businesses succeed in today's digital world.
              </p>
            </div>
          </div>
          
          <!-- Right Content - Feature Boxes -->
          <div class="grid grid-cols-3 gap-8 mt-12">
            <!-- Row 1 -->
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300 min-h-[140px] flex flex-col justify-center">
              <h4 class="text-lg font-semibold text-white mb-3">Agency Focused</h4>
              <p class="text-base text-gray-400">professionalism</p>
            </div>
            
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300 min-h-[140px] flex flex-col justify-center">
              <h4 class="text-lg font-semibold text-white mb-3">Complete</h4>
              <p class="text-base text-gray-400">confidentiality</p>
            </div>
            
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300 min-h-[140px] flex flex-col justify-center">
              <h4 class="text-lg font-semibold text-white">Utmost reliability</h4>
            </div>
            
            <!-- Row 2 -->
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300 min-h-[140px] flex flex-col justify-center">
              <h4 class="text-lg font-semibold text-white mb-3">Collaborative and</h4>
              <p class="text-base text-gray-400">Flexible</p>
            </div>
            
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300 min-h-[140px] flex flex-col justify-center">
              <h4 class="text-lg font-semibold text-white mb-3">Highest standards of</h4>
              <p class="text-base text-gray-400">quality</p>
            </div>
            
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300 min-h-[140px] flex flex-col justify-center">
              <h4 class="text-lg font-semibold text-white mb-3">International</h4>
              <p class="text-base text-gray-400">customer base</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Services Section -->
    <section class="py-16 sm:py-20 relative overflow-hidden bg-black">
      <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <!-- Section Header -->
        <div class="mb-16">
          <h1 class="text-6xl sm:text-7xl lg:text-8xl font-black text-gray-400 opacity-30 tracking-[0.1em] mb-8">
             SERVICES
          </h1>
        </div>
        
        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 border border-gray-600">
          <!-- Row 1 -->
          <!-- Websites -->
          <div class="border-r border-b border-gray-600 p-8 bg-black hover:bg-gray-900/30 transition-all duration-300">
            <h3 class="text-xl font-bold text-red-600 mb-4">Websites</h3>
            <ul class="space-y-2 text-gray-300">
              <li>• 500+ Websites Delivered</li>
              <li>• Attractive and Responsive Design</li>
              <li>• 7+ Years of Experienced Developers</li>
            </ul>
          </div>
          
          <!-- Mobile -->
          <div class="border-r border-b border-gray-600 p-8 bg-black hover:bg-gray-900/30 transition-all duration-300">
            <h3 class="text-xl font-bold text-red-600 mb-4">Mobile</h3>
            <ul class="space-y-2 text-gray-300">
              <li>• 70+ Apps Developed</li>
              <li>• 7+ Years of Experienced Developers</li>
              <li>• 2 In-house Products (100k+ Downloads)</li>
            </ul>
          </div>
          
          <!-- SaaS -->
          <div class="border-b border-gray-600 p-8 bg-black hover:bg-gray-900/30 transition-all duration-300">
            <h3 class="text-xl font-bold text-red-600 mb-4">SaaS</h3>
            <ul class="space-y-2 text-gray-300">
              <li>• 5 VC Funded Products Developed</li>
              <li>• Created 20+ SaaS Products</li>
              <li>• 4 In-house SaaS Products</li>
            </ul>
          </div>
          
          <!-- Row 2 -->
          <!-- E-commerce -->
          <div class="border-r border-gray-600 p-8 bg-black hover:bg-gray-900/30 transition-all duration-300">
            <h3 class="text-xl font-bold text-red-600 mb-4">E-commerce</h3>
            <ul class="space-y-2 text-gray-300">
              <li>• 100+ Stores Developed</li>
              <li>• Worked with $5 Mn+ Stores</li>
              <li>• 1 In-house Product</li>
            </ul>
          </div>
          
          <!-- UI/UX -->
          <div class="border-r border-gray-600 p-8 bg-black hover:bg-gray-900/30 transition-all duration-300">
            <h3 class="text-xl font-bold text-red-600 mb-4">UI/UX</h3>
            <ul class="space-y-2 text-gray-300">
              <li>• Intuitive & Purpose-centric Designs</li>
              <li>• 80+ Thoughts Transformed into Reality</li>
              <li>• 15+ Ideators, Creators, and Designers</li>
            </ul>
          </div>
          
          <!-- Branding -->
          <div class="p-8 bg-black hover:bg-gray-900/30 transition-all duration-300">
            <h3 class="text-xl font-bold text-red-600 mb-4">Branding</h3>
            <ul class="space-y-2 text-gray-300">
              <li>• Built Brands That Dance with Design</li>
              <li>• Crafted 100+ Identities</li>
              <li>• 5+ Brand Experts</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- Continuous Scroll Services Section -->
    <section class="pb-16 bg-black overflow-hidden">
      <div class="container mx-auto px-4">

        
        <!-- Scrolling Container -->
        <div class="bg-gray-800/30 p-6 overflow-hidden">
          <div class="flex animate-scroll whitespace-nowrap">
            <span class="text-6xl font-bold text-red-600 mx-12">Web Development</span>
            <span class="text-6xl font-bold text-red-600 mx-12">Mobile Apps</span>
            <span class="text-6xl font-bold text-red-600 mx-12">UI/UX Design</span>
            <span class="text-6xl font-bold text-red-600 mx-12">E-commerce</span>
            <span class="text-6xl font-bold text-red-600 mx-12">SaaS Solutions</span>
            <span class="text-6xl font-bold text-red-600 mx-12">Digital Marketing</span>
            <!-- Duplicate for seamless loop -->
            <span class="text-6xl font-bold text-red-600 mx-12">Web Development</span>
            <span class="text-6xl font-bold text-red-600 mx-12">Mobile Apps</span>
            <span class="text-6xl font-bold text-red-600 mx-12">UI/UX Design</span>
            <span class="text-6xl font-bold text-red-600 mx-12">E-commerce</span>
          </div>
        </div>
      </div>
    </section>

    <!-- About Us Section -->
    <section class="py-16 sm:py-20 relative overflow-hidden bg-black">
      <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <!-- Section Header -->
        <div class="mb-16">
          <h1 class="text-6xl sm:text-7xl lg:text-8xl font-black text-gray-400 opacity-30 tracking-[0.1em] mb-8">
            ABOUT US
          </h1>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <!-- Left Content - Stats -->
          <div class="grid grid-cols-2 gap-6">
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300">
              <h3 class="text-4xl font-bold text-red-600 mb-2">250+</h3>
              <p class="text-gray-300">Projects Completed</p>
            </div>
            
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300">
              <h3 class="text-4xl font-bold text-red-600 mb-2">100%</h3>
              <p class="text-gray-300">Deadlines Achieved</p>
            </div>
            
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300">
              <h3 class="text-4xl font-bold text-red-600 mb-2">170+</h3>
              <p class="text-gray-300">Delighted Clients</p>
            </div>
            
            <div class="bg-gray-800/60 border border-gray-600 rounded-xl p-8 text-center hover:bg-gray-700/60 transition-all duration-300">
              <h3 class="text-4xl font-bold text-red-600 mb-2">18+</h3>
              <p class="text-gray-300">Countries Served</p>
            </div>
          </div>
          
          <!-- Right Content -->
          <div>
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-8 leading-tight">
              We cater to the needs of <span class="text-red-600">top Industries</span>
            </h2>
            
            <div class="space-y-6 text-gray-300">
              <p class="text-lg leading-relaxed">
                Our uniqueness lies in the fact that we serve customers(industries) of a plethora of different verticals ranging from social networking, distribution, travel and tourism, on-demand solutions, restaurants, healthcare, gaming and what not! We assure that your target audience cannot resist but only come back for more!
              </p>
              
              <div class="bg-gray-800/40 border border-red-500/20 rounded-xl p-6">
                <h3 class="text-xl font-bold text-red-600 mb-4">"Satisfaction of Clients"</h3>
                <p class="text-gray-300">is our sole motto and we do maximum efforts to make you happy!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Banner -->
    <div class="bg-black text-white py-6 overflow-hidden border-t border-b border-gray-800">
      <div class="animate-banner-scroll whitespace-nowrap text-xl font-medium tracking-wider">
        SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★    •    SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★    •    SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★    •    SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★    •    SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★    •    SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★    •    SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★    •    SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★    •    SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★    •    SAAS    •    ERP    •    AI    •    CLOUD    •    MOBILE    ★
      </div>
    </div>

        <!-- Testimonials Section -->
    <section class="py-16 sm:py-20 bg-black relative overflow-hidden">
      <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <!-- Section Header -->
        <div class="mb-16">
          <h1 class="text-6xl sm:text-7xl lg:text-8xl font-black text-gray-400 opacity-30 tracking-[0.1em] mb-8">
             REVIEWS
          </h1>
        </div>

        <div class="max-w-6xl mx-auto bg-gradient-to-r from-gray-900/80 to-black/80 rounded-3xl border border-red-500/20 overflow-hidden">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 min-h-[400px]">
            <div class="bg-gradient-to-br from-red-900/30 to-black/50 p-8 lg:p-12 flex items-center justify-center border-r border-red-500/20">
              <div class="text-center">
                <h3 class="text-2xl lg:text-3xl font-bold text-white mb-4">
                  <span class="text-red-600">Accredited By</span>
                </h3>
                <p class="text-lg text-gray-300">World's leading rating & review firms</p>
              </div>
            </div>

            <div class="relative h-[400px]" id="testimonial-container">
              <!-- Navigation Arrows -->
              <button id="scroll-up" class="absolute top-6 right-6 w-10 h-10 bg-red-600/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-red-600 hover:scale-110 transition-all duration-300 z-20 border border-red-600/30 group">
                <svg class="w-5 h-5 text-red-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                </svg>
              </button>
              <button id="scroll-down" class="absolute bottom-6 right-6 w-10 h-10 bg-red-600/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-red-600 hover:scale-110 transition-all duration-300 z-20 border border-red-600/30 group">
                <svg class="w-5 h-5 text-red-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </button>

              <!-- Testimonial 1 -->
              <div class="testimonial-card p-6 pb-8 min-h-[400px] flex flex-col justify-between">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-red-600/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-red-600/30">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-red-600/30 mb-2">"</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        Hi, this is Erika from Sweden. I am the managing director of Zorbeto. We are just launching a web shop that Technova has built in Laravel PHP and I like working with Technova.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        They are quick to respond and nothing is impossible. We will definitely continue to work with them on a regular basis, that is for sure.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="mt-auto pt-6 border-t border-red-500/20">
                  <div class="flex items-center justify-between">
                    <div>
                      <div class="font-bold text-white text-xl mb-1">Erica Lindgren</div>
                      <div class="text-red-600 font-semibold text-base">Managing Director, Zorbeto AB</div>
                      <div class="text-gray-400 text-sm mt-1">Sweden</div>
                    </div>
                    <div class="flex text-yellow-400">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 2 -->
              <div class="testimonial-card p-6 pb-8 min-h-[400px] flex flex-col justify-between" style="display: none;">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-red-600/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-red-600/30">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-red-600/30 mb-2">"</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        Technova Technologies delivered an exceptional mobile app for our business. Their team's expertise in Flutter development exceeded our expectations.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        The project was completed on time and within budget. Their communication throughout the process was outstanding.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="mt-auto pt-6 border-t border-red-500/20">
                  <div class="flex items-center justify-between">
                    <div>
                      <div class="font-bold text-white text-xl mb-1">Michael Johnson</div>
                      <div class="text-red-600 font-semibold text-base">CEO, TechStart Inc.</div>
                      <div class="text-gray-400 text-sm mt-1">United States</div>
                    </div>
                    <div class="flex text-yellow-400">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 3 -->
              <div class="testimonial-card p-6 pb-8 min-h-[400px] flex flex-col justify-between" style="display: none;">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-red-600/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-red-600/30">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-red-600/30 mb-2">"</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        Working with Technova has been a game-changer for our e-commerce platform. Their SaaS solutions are robust and scalable.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        The team's attention to detail and commitment to quality is remarkable. Highly recommended for any tech project.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="mt-auto pt-6 border-t border-red-500/20">
                  <div class="flex items-center justify-between">
                    <div>
                      <div class="font-bold text-white text-xl mb-1">Sarah Chen</div>
                      <div class="text-red-600 font-semibold text-base">CTO, Digital Commerce Ltd.</div>
                      <div class="text-gray-400 text-sm mt-1">Singapore</div>
                    </div>
                    <div class="flex text-yellow-400">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 4 -->
              <div class="testimonial-card p-6 pb-8 min-h-[400px] flex flex-col justify-between" style="display: none;">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-red-600/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-red-600/30">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-red-600/30 mb-2">"</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        The UI/UX design services provided by Technova transformed our brand identity completely. Their creative approach is unmatched.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        Professional, innovative, and reliable - everything you need in a technology partner.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="mt-auto pt-6 border-t border-red-500/20">
                  <div class="flex items-center justify-between">
                    <div>
                      <div class="font-bold text-white text-xl mb-1">David Rodriguez</div>
                      <div class="text-red-600 font-semibold text-base">Creative Director, Creative Solutions</div>
                      <div class="text-gray-400 text-sm mt-1">Canada</div>
                    </div>
                    <div class="flex text-yellow-400">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  
  
  


 
  



  <!-- Footer -->
  <footer class="bg-black text-grey py-12 sm:py-16 border-t border-gray-800">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <img src="logo.svg" alt="Logo" class="h-8 w-auto" />
                </div>
                <p class="text-gray-400 text-sm mb-4">Intelligent. Innovative. Infinite.</p>
                <div class="space-y-2 text-sm">
                    <p class="text-gray-300"><span class="text-primary">📧</span> info@technovatechnologies.com</p>
                    <p class="text-gray-300"><span class="text-primary">📞</span> +91 94273 00816</p>
                    <p class="text-gray-300"><span class="text-primary">🇮🇳</span> +91 94273 00816</p>
                </div>
            </div>
            
            <!-- Company -->
            <div>
                <h3 class="text-white font-semibold mb-4">Company</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="about.php" class="text-gray-300 hover:text-primary transition-colors duration-300">About Technova</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Our Team</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Clients</a></li>
                    <li><a href="carrer.php" class="text-gray-300 hover:text-primary transition-colors duration-300">Careers <span class="text-primary text-xs">[HIRING]</span></a></li>
                    <li><a href="contact.php" class="text-gray-300 hover:text-primary transition-colors duration-300">Contact Us</a></li>
                </ul>
            </div>
            
            <!-- Industries -->
            <div>
                <h3 class="text-white font-semibold mb-4">Industries</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Healthcare</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Ed-Tech</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Travel & Hospitality</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Real Estate</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">E-Commerce</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Fintech</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Manufacturing</a></li>
                </ul>
            </div>
            
            <!-- Services -->
            <div>
                <h3 class="text-white font-semibold mb-4">Services</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="service.php" class="text-gray-300 hover:text-primary transition-colors duration-300">UI/UX Design</a></li>
                    <li><a href="service.php" class="text-gray-300 hover:text-primary transition-colors duration-300">Web Development</a></li>
                    <li><a href="service.php" class="text-gray-300 hover:text-primary transition-colors duration-300">Mobile Apps</a></li>
                    <li><a href="service.php" class="text-gray-300 hover:text-primary transition-colors duration-300">Cloud Engineering</a></li>
                    <li><a href="service.php" class="text-gray-300 hover:text-primary transition-colors duration-300">Digital Marketing</a></li>
                    <li><a href="service.php" class="text-gray-300 hover:text-primary transition-colors duration-300">QA & Testing</a></li>
                    <li><a href="service.php" class="text-gray-300 hover:text-primary transition-colors duration-300">ERP Solutions</a></li>
                </ul>
            </div>
            
            <!-- Work & Resources -->
            <div>
                <h3 class="text-white font-semibold mb-4">Work</h3>
                <ul class="space-y-2 text-sm mb-6">
                    <li><a href="portfolio.php" class="text-gray-300 hover:text-primary transition-colors duration-300">Portfolio</a></li>
                    <li><a href="product.php" class="text-gray-300 hover:text-primary transition-colors duration-300">Products</a></li>
                </ul>
                
                <h3 class="text-white font-semibold mb-4">Resources</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Blog</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-primary transition-colors duration-300">Case Studies</a></li>
                </ul>
            </div>
        </div>
            
        <div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-gray-800 gap-4">
            <p class="text-sm text-gray-400">&copy; 2025 Technova Technologies LLP. All rights reserved. <a href="#" class="hover:text-primary">Privacy</a> | <a href="#" class="hover:text-primary">Terms</a> | <a href="#" class="hover:text-primary">Sitemap</a></p>
            <div class="flex gap-4">
                <a href="https://www.linkedin.com/company/technova-technologies" target="_blank" class="text-gray-400 hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
                <a href="https://www.instagram.com/technovatechnologies" target="_blank" class="text-gray-400 hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>
  <!-- Back to Top Button -->
  <button id="back-to-top" class="fixed bottom-6 right-6 bg-primary text-white w-12 h-12 rounded-full flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-red-700 z-50">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
    </svg>
  </button>


  <script type="text/javascript" src="script.js"></script>


  <!-- Js For Whatsapp Drawer -->
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const scrollContainer = document.getElementById('testimonial-scroll');
      const scrollUp = document.getElementById('scroll-up');
      const scrollDown = document.getElementById('scroll-down');
      let currentIndex = 0;
      const testimonials = document.querySelectorAll('.testimonial-card');
      
      // Hide all testimonials except the first one
      testimonials.forEach((testimonial, index) => {
        if (index !== 0) {
          testimonial.style.display = 'none';
        }
      });
      
      function showTestimonial(index) {
        testimonials.forEach((testimonial, i) => {
          testimonial.style.display = i === index ? 'flex' : 'none';
        });
      }
      
      scrollUp.addEventListener('click', () => {
        currentIndex = currentIndex > 0 ? currentIndex - 1 : testimonials.length - 1;
        showTestimonial(currentIndex);
      });
      
      scrollDown.addEventListener('click', () => {
        currentIndex = currentIndex < testimonials.length - 1 ? currentIndex + 1 : 0;
        showTestimonial(currentIndex);
      });
    });
    
    // Toggle reviews section
    document.getElementById('toggle-reviews').addEventListener('click', function() {
      const content = document.getElementById('hidden-content');
      const icon = document.getElementById('toggle-icon');
      const button = this.querySelector('span');
      
      if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
        button.textContent = 'Hide Reviews';
      } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
        button.textContent = 'View More Reviews';
      }
    });
  </script>
  
</body>

</html>