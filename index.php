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


  <!-- Hero Section -->
  <section id="home" class="py-20 md:py-32 min-h-screen flex items-center relative overflow-hidden" style="background: linear-gradient(to bottom, rgba(0,0,0,1), rgba(20,0,10,1));">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden">
      <div id="stars-container" style="position: absolute; width: 100%; height: 100%;"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-2 gap-8 items-center relative z-10">
      <div class="reveal">
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight mb-6">
          A Bespoke<br />and Holistic<br />
          <span class="gradient-text">Tech</span> Company
        </h1>
        <p class="text-base sm:text-lg text-gray-400 mb-8">
          UI/UX, WEBDESIGN, WEB DEVELOPMENT, ECOMMERCE.
        </p>
        <div class="flex flex-wrap gap-4">
          <a href="service.php" class="btn">
            Our Services
          </a>
          <a href="portfolio.php" class="btn">
            View Portfolio
          </a>
        </div>
      </div>
      <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs"
  type="module">
      </script>

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





  
  </section>
  
  <!-- Services -->
  
  <section id="services" class="py-16 sm:py-20 relative overflow-hidden">
    <div class="absolute inset-0" style="background: radial-gradient(circle at center, rgba(225, 29, 72, 0.05), transparent 70%);"></div>
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
      <div class="mb-12 sm:mb-16 reveal">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 text-white">
          <span class="text-gray-500">OUR</span><br />
          SERVICES
        </h2>
        <p class="text-gray-400 max-w-2xl">We offer a comprehensive range of digital services to help your business thrive in the digital landscape.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
        <div class="service-card p-6 bg-gray-900/30 rounded-lg reveal" style="transition-delay: 100ms;">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-primary/20 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01  d=" M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-6">DESIGN</h3>
          <ul class="space-y-4">
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Brand Design</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>UI/UX</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Service Design</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Web Design</span>
            </li>
          </ul>
        </div>

        <div class="service-card p-6 bg-gray-900/30 rounded-lg reveal" style="transition-delay: 200ms;">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-primary/20 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-6">WEB</h3>
          <ul class="space-y-4">
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>.NET</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Laravel</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Nodejs</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Php</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Python</span>
            </li>
          </ul>
        </div>

        <div class="service-card p-6 bg-gray-900/30 rounded-lg reveal" style="transition-delay: 300ms;">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-primary/20 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-6">E-COMMERCE</h3>
          <ul class="space-y-4">
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>BigCommerce</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Magento</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>PrestaShop</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Shopify</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>WooCommerce</span>
            </li>
          </ul>
        </div>

        <div class="service-card p-6 bg-gray-900/30 rounded-lg reveal" style="transition-delay: 400ms;">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-primary/20 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="text-xl font-bold mb-6">MOBILE</h3>
          <ul class="space-y-4">
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Android</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Flutter</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>IOS</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>Kotlin</span>
            </li>
            <li class="flex items-center gap-2 hover:translate-x-1 transition-transform duration-300">
              <span class="text-primary">•</span>
              <span>React Native</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  

  <!-- Nutty Process Section -->
  <section id="process" class="py-16 sm:py-20 bg-black">
    <div class="container mx-auto px-4 sm:px-6">
      <div class="mb-12 sm:mb-16 reveal">
        <h2 class="text-2xl sm:text-3xl font-bold mb-4">Technova PROCESS</h2>
        <p class="text-gray-400 max-w-2xl">Our proven methodology ensures consistent results and exceptional quality for every project.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12">
        <div class="space-y-12">
          <div class="flex gap-4 sm:gap-6 reveal" style="transition-delay: 100ms;">
            <div class="relative">
              <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-primary/20 flex items-center justify-center process-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 sm:w-8 sm:h-8 text-primary">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
              </div>
              <div class="absolute top-16 bottom-0 left-1/2 w-px bg-primary/20 process-line"></div>
            </div>
            <div>
              <h3 class="text-xl font-bold mb-2">Discover</h3>
              <p class="text-gray-400">
                All great things begin with a conversation and a cup of coffee. Is there something we can help you with? We're all ears.
              </p>
            </div>
          </div>

          <div class="flex gap-4 sm:gap-6 reveal" style="transition-delay: 200ms;">
            <div class="relative">
              <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-primary/20 flex items-center justify-center process-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 sm:w-8 sm:h-8 text-primary">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
              </div>
              <div class="absolute top-16 bottom-0 left-1/2 w-px bg-primary/20 process-line"></div>
            </div>
            <div>
              <h3 class="text-xl font-bold mb-2">Define</h3>
              <p class="text-gray-400">
                Post the initial meeting, the team gathers for a communal brainstorming session. Our creative minds doing what they do best: Ideating.
              </p>
            </div>
          </div>
        </div>

        <div class="space-y-12">
          <div class="flex gap-4 sm:gap-6 reveal" style="transition-delay: 300ms;">
            <div class="relative">
              <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-primary/20 flex items-center justify-center process-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 sm:w-8 sm:h-8 text-primary">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                </svg>
              </div>
              <div class="absolute top-16 bottom-0 left-1/2 w-px bg-primary/20 process-line"></div>
            </div>
            <div>
              <h3 class="text-xl font-bold mb-2">Design & Develop</h3>
              <p class="text-gray-400">
                With the design approved, we begin developing the final product with painstaking precision. If you don't look good, we don't look good.
              </p>
            </div>
          </div>

          <div class="flex gap-4 sm:gap-6 reveal" style="transition-delay: 400ms;">
            <div>
              <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-primary/20 flex items-center justify-center process-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 sm:w-8 sm:h-8 text-primary">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                </svg>
              </div>
            </div>
            <div>
              <h3 class="text-xl font-bold mb-2">Deliver</h3>
              <p class="text-gray-400">
                After the final product has been thoroughly vetted by our experts, we prepare to go live. All the grinding and toiling, ultimately paying dividend.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

 
  


  <!-- Testimonials Section -->
  <section id="testimonials" class="py-16 sm:py-20 bg-black relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0" style="background: radial-gradient(circle at center, rgba(225, 29, 72, 0.05), transparent 70%);"></div>
    
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
      <!-- Section Header -->
      <div class="text-center mb-12 sm:mb-16 reveal">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">
          <span class="text-gray-500">CLIENT</span><br />
          <span class="gradient-text">TESTIMONIALS</span>
        </h2>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">Precious words from our clients worldwide who trust us with their digital transformation</p>
      </div>

      <!-- Main Card Container -->
      <div class="max-w-6xl mx-auto bg-gradient-to-r from-gray-900/80 to-black/80 backdrop-blur-sm rounded-3xl border border-red-500/20 overflow-hidden relative shadow-2xl">
        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary via-red-400 to-primary"></div>
        


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 min-h-[450px]">
          <!-- Left Side - Fixed Accredited By -->
          <div class="bg-gradient-to-br from-red-900/30 to-black/50 p-8 lg:p-12 text-center border-r border-red-500/20 relative">
            <!-- Decorative Corner -->
            <div class="absolute top-0 left-0 w-20 h-20 border-l-2 border-t-2 border-primary/30 rounded-tl-3xl"></div>
            
            <h3 class="text-2xl lg:text-3xl font-bold text-white mb-6 relative">
              <span class="gradient-text">Accredited By</span>
            </h3>
            <p class="text-lg text-gray-300 mb-8">World's leading rating &<br>review firms</p>
            
            <!-- Clutch Rating -->
            <div class="mb-8 p-4 bg-black/30 rounded-xl border border-red-500/20">
              <div class="text-sm text-gray-400 mb-2">REVIEWED ON</div>
              <div class="text-2xl font-bold text-white mb-2">Clutch</div>
              <div class="flex justify-center items-center gap-1 mb-2">
                <span class="text-primary text-xl">★★★★★</span>
              </div>
              <div class="text-sm text-gray-400">10 REVIEWS</div>
            </div>

            <!-- Goodfirms Rating -->
            <div class="bg-gradient-to-r from-black/50 to-red-900/20 rounded-xl p-6 border border-red-500/30">
              <div class="text-xl font-bold text-primary mb-2">EXCELLENT</div>
              <div class="flex justify-center items-center gap-1 mb-2">
                <span class="text-primary text-xl">★★★★★</span>
              </div>
              <div class="flex items-center justify-center gap-2">
                <span class="text-sm text-gray-400">Based on 8 Reviews</span>
                <span class="text-primary font-bold">Goodfirms</span>
              </div>
            </div>
            
            <!-- Decorative Corner -->
            <div class="absolute bottom-0 right-0 w-20 h-20 border-r-2 border-b-2 border-primary/30 rounded-br-3xl"></div>
          </div>

          <!-- Right Side - Scrolling Testimonials -->
          <div class="relative h-[450px]" id="testimonial-container">
            <!-- Navigation Arrows -->
            <button id="scroll-up" class="absolute top-6 right-6 w-10 h-10 bg-primary/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-primary hover:scale-110 transition-all duration-300 z-20 border border-primary/30">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
              </svg>
            </button>
            <button id="scroll-down" class="absolute bottom-6 right-6 w-10 h-10 bg-primary/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-primary hover:scale-110 transition-all duration-300 z-20 border border-primary/30">
              <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div id="testimonial-scroll" class="overflow-y-auto h-full pr-4 pb-8" style="scroll-snap-type: y mandatory; scrollbar-width: none; -ms-overflow-style: none;">
              <style>
                #testimonial-scroll::-webkit-scrollbar {
                  display: none;
                }
              </style>
              <!-- Testimonial 1 -->
              <div class="testimonial-card p-8 pb-12 min-h-[450px] flex flex-col justify-between" style="scroll-snap-align: start;">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-primary/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-primary/30">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-primary/30 mb-2">“</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        Hi, this is Erika from Sweden. I am the managing director of Zorbeto. We are just launching a web shop that Technova has built in Laravel PHP and I like working with Technova.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        They are quick to respond and nothing is impossible. We will definitely continue to work with them on a regular basis, that is for sure.
                      </p>
                    </div>
                  </div>
                  
                  <button class="flex items-center gap-3 text-primary hover:text-white font-medium group transition-all duration-300">
                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center group-hover:bg-primary transition-all duration-300">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                      </svg>
                    </div>
                    <span class="group-hover:translate-x-1 transition-transform duration-300">Watch Video →</span>
                  </button>
                </div>
                
                <div class="mt-8 pt-6 border-t border-red-500/20">
                  <div class="text-center">
                    <div class="font-bold text-white text-lg">Erica Lindgren</div>
                    <div class="text-primary font-medium">Zorbeto AB</div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 2 -->
              <div class="testimonial-card p-8 pb-12 min-h-[450px] flex flex-col justify-between" style="scroll-snap-align: start;">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-primary/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-primary/30">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-primary/30 mb-2">“</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        Technova Technologies delivered an exceptional e-commerce platform for our business. Their attention to detail and commitment to quality is outstanding.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        We highly recommend their services to anyone looking for reliable web development solutions. The communication was excellent throughout the project.
                      </p>
                    </div>
                  </div>
                  
                  <button class="flex items-center gap-3 text-primary hover:text-white font-medium group transition-all duration-300">
                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center group-hover:bg-primary transition-all duration-300">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                      </svg>
                    </div>
                    <span class="group-hover:translate-x-1 transition-transform duration-300">Watch Video →</span>
                  </button>
                </div>
                
                <div class="mt-8 pt-6 border-t border-red-500/20">
                  <div class="text-center">
                    <div class="font-bold text-white text-lg">John Smith</div>
                    <div class="text-primary font-medium">Tech Solutions Inc</div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 3 -->
              <div class="testimonial-card p-8 pb-12 min-h-[450px] flex flex-col justify-between" style="scroll-snap-align: start;">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-primary/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-primary/30">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-primary/30 mb-2">“</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        Working with Technova has been a game-changer for our digital presence. Their innovative approach and technical expertise helped us achieve our goals.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        The team's dedication and professionalism made the entire process smooth and enjoyable. We look forward to future collaborations.
                      </p>
                    </div>
                  </div>
                  
                  <button class="flex items-center gap-3 text-primary hover:text-white font-medium group transition-all duration-300">
                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center group-hover:bg-primary transition-all duration-300">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                      </svg>
                    </div>
                    <span class="group-hover:translate-x-1 transition-transform duration-300">Watch Video →</span>
                  </button>
                </div>
                
                <div class="mt-8 pt-6 border-t border-red-500/20">
                  <div class="text-center">
                    <div class="font-bold text-white text-lg">Sarah Johnson</div>
                    <div class="text-primary font-medium">Digital Marketing Pro</div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 4 -->
              <div class="testimonial-card p-8 pb-12 min-h-[450px] flex flex-col justify-between" style="scroll-snap-align: start;">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-primary/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-primary/30">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-primary/30 mb-2">“</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        Technova's mobile app development exceeded our expectations. The app is fast, user-friendly, and has significantly improved our customer engagement.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        Their team understood our vision perfectly and delivered a product that truly represents our brand. Highly professional and reliable.
                      </p>
                    </div>
                  </div>
                  
                  <button class="flex items-center gap-3 text-primary hover:text-white font-medium group transition-all duration-300">
                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center group-hover:bg-primary transition-all duration-300">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                      </svg>
                    </div>
                    <span class="group-hover:translate-x-1 transition-transform duration-300">Watch Video →</span>
                  </button>
                </div>
                
                <div class="mt-8 pt-6 border-t border-red-500/20">
                  <div class="text-center">
                    <div class="font-bold text-white text-lg">Michael Chen</div>
                    <div class="text-primary font-medium">RetailMax Solutions</div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 5 -->
              <div class="testimonial-card p-8 pb-12 min-h-[450px] flex flex-col justify-between" style="scroll-snap-align: start;">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-primary/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-primary/30">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-primary/30 mb-2">“</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        The UI/UX design services from Technova transformed our website completely. Our conversion rates increased by 40% after the redesign.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        They have an excellent eye for design and understand user behavior perfectly. The project was completed on time and within budget.
                      </p>
                    </div>
                  </div>
                  
                  <button class="flex items-center gap-3 text-primary hover:text-white font-medium group transition-all duration-300">
                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center group-hover:bg-primary transition-all duration-300">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                      </svg>
                    </div>
                    <span class="group-hover:translate-x-1 transition-transform duration-300">Watch Video →</span>
                  </button>
                </div>
                
                <div class="mt-8 pt-6 border-t border-red-500/20">
                  <div class="text-center">
                    <div class="font-bold text-white text-lg">Amanda Rodriguez</div>
                    <div class="text-primary font-medium">Creative Studios Ltd</div>
                  </div>
                </div>
              </div>

              <!-- Testimonial 6 -->
              <div class="testimonial-card p-8 pb-12 min-h-[450px] flex flex-col justify-between" style="scroll-snap-align: start;">
                <div>
                  <div class="flex items-start gap-6 mb-6">
                    <div class="flex-shrink-0">
                      <div class="w-16 h-16 bg-gradient-to-br from-primary/20 to-red-600/20 rounded-full flex items-center justify-center border-2 border-primary/30">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                      </div>
                    </div>
                    <div class="flex-1">
                      <div class="text-4xl text-primary/30 mb-2">“</div>
                      <p class="text-gray-300 mb-4 leading-relaxed text-lg">
                        Technova developed a custom ERP system for our manufacturing business. The system streamlined our operations and improved efficiency by 60%.
                      </p>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                        Their technical expertise and understanding of business processes is remarkable. They provided excellent post-launch support as well.
                      </p>
                    </div>
                  </div>
                  
                  <button class="flex items-center gap-3 text-primary hover:text-white font-medium group transition-all duration-300">
                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center group-hover:bg-primary transition-all duration-300">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                      </svg>
                    </div>
                    <span class="group-hover:translate-x-1 transition-transform duration-300">Watch Video →</span>
                  </button>
                </div>
                
                <div class="mt-8 pt-6 border-t border-red-500/20">
                  <div class="text-center">
                    <div class="font-bold text-white text-lg">David Thompson</div>
                    <div class="text-primary font-medium">Industrial Solutions Corp</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Reviews Section -->
  <section class="py-4 bg-gray-900/50 border-t border-gray-800">
    <div class="container mx-auto px-4 sm:px-6">
      <div class="text-center">
        <button id="toggle-reviews" class="text-primary hover:text-white font-medium transition-colors duration-300 flex items-center gap-2 mx-auto">
          <span>View More Reviews</span>
          <svg id="toggle-icon" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        
        <div id="hidden-content" class="hidden mt-6 pt-6 border-t border-gray-700">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto mb-6">
            <div class="bg-gray-800/50 p-6 rounded-lg border border-primary/20 min-h-[200px] flex flex-col justify-between">
              <div>
                <div class="flex items-center gap-1 mb-4">
                  <span class="text-primary text-lg">★★★★★</span>
                </div>
                <p class="text-gray-300 mb-4 text-sm leading-relaxed">"Technova delivered our e-commerce platform on time with exceptional quality. Their team understood our requirements perfectly and provided excellent support throughout the project."</p>
              </div>
              <div class="border-t border-gray-600 pt-3 mt-auto">
                <div class="font-semibold text-white text-sm">Robert Johnson</div>
                <div class="text-xs text-primary">CEO, Digital Commerce Ltd</div>
              </div>
            </div>
            <div class="bg-gray-800/50 p-6 rounded-lg border border-primary/20 min-h-[200px] flex flex-col justify-between">
              <div>
                <div class="flex items-center gap-1 mb-4">
                  <span class="text-primary text-lg">★★★★★</span>
                </div>
                <p class="text-gray-300 mb-4 text-sm leading-relaxed">"Amazing web development services! The mobile app they created for us has significantly improved our customer engagement. Highly professional team with great communication."</p>
              </div>
              <div class="border-t border-gray-600 pt-3 mt-auto">
                <div class="font-semibold text-white text-sm">Lisa Chen</div>
                <div class="text-xs text-primary">Marketing Director, TechFlow</div>
              </div>
            </div>
            <div class="bg-gray-800/50 p-6 rounded-lg border border-primary/20 min-h-[200px] flex flex-col justify-between">
              <div>
                <div class="flex items-center gap-1 mb-4">
                  <span class="text-primary text-lg">★★★★★</span>
                </div>
                <p class="text-gray-300 mb-4 text-sm leading-relaxed">"Outstanding UI/UX design work! Our website conversion rate increased by 45% after their redesign. The team's attention to detail and user experience is remarkable."</p>
              </div>
              <div class="border-t border-gray-600 pt-3 mt-auto">
                <div class="font-semibold text-white text-sm">Mark Williams</div>
                <div class="text-xs text-primary">Founder, StartupHub</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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
      let autoScrollInterval;
      
      function scrollToTestimonial(index) {
        const targetScroll = index * 450;
        scrollContainer.scrollTo({ top: targetScroll, behavior: 'smooth' });
      }
      
      function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
          currentIndex = currentIndex < testimonials.length - 1 ? currentIndex + 1 : 0;
          scrollToTestimonial(currentIndex);
        }, 4000);
      }
      
      function stopAutoScroll() {
        clearInterval(autoScrollInterval);
      }
      
      function resetAutoScroll() {
        stopAutoScroll();
        setTimeout(startAutoScroll, 2000); // Resume after 2 seconds
      }
      
      scrollUp.addEventListener('click', () => {
        currentIndex = currentIndex > 0 ? currentIndex - 1 : testimonials.length - 1;
        scrollToTestimonial(currentIndex);
        resetAutoScroll();
      });
      
      scrollDown.addEventListener('click', () => {
        currentIndex = currentIndex < testimonials.length - 1 ? currentIndex + 1 : 0;
        scrollToTestimonial(currentIndex);
        resetAutoScroll();
      });
      
      // Pause auto-scroll on hover
      scrollContainer.addEventListener('mouseenter', stopAutoScroll);
      scrollContainer.addEventListener('mouseleave', startAutoScroll);
      
      // Start auto-scroll
      startAutoScroll();
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