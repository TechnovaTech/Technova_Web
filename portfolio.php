

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
  <title>Technova Technologies - Premium Tech Company</title>
  <meta name="description" content="A holistic digital agency specializing in UI/UX, web design, web development, and ecommerce solutions.">
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
  <div class="container mx-auto px-4 sm:px-6 flex h-20 items-center justify-between">
    <a href="#" class="flex items-center gap-2 group">
      <img src="logo.svg" alt="Logo" class="h-8 sm:h-10 w-auto transition-transform duration-300 transform group-hover:scale-110" />
    </a>
    
    <!-- Desktop Navigation -->
    <nav class="hidden md:flex items-center gap-6 lg:gap-8">
      <a href="index.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">
        Home
      </a>
      <a href="service.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">
        Services
      </a>
      <a href="hireteam.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">
        Hire Team
      </a>
      <div class="relative group">
        <button class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link flex items-center gap-1">
          Work
          <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <div class="absolute top-full left-0 mt-2 w-48 bg-black bg-opacity-90 backdrop-blur-md rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
          <div class="py-2">
            <a href="portfolio.php" class="block px-4 py-2 text-white hover:text-primary hover:bg-gray-800 transition-colors duration-300">Portfolio</a>
            <a href="product.php" class="block px-4 py-2 text-white hover:text-primary hover:bg-gray-800 transition-colors duration-300">Product</a>
          </div>
        </div>
      </div>
      <a href="about.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">
        About
      </a>
      <a href="carrer.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">
        Careers
      </a>
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
  <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-black via-gray-900 to-black pt-20">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23E11D48" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="1"%3E%3C/circle%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Left Content -->
        <div class="text-left mx-auto">
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
            Our Recent <span class="text-primary">Work</span>
          </h1>
          <div class="w-24 h-1 bg-primary mb-6"></div>
          <p class="text-lg text-gray-300 mb-8 leading-relaxed max-w-lg">
            Our portfolio is not just a catalogue, it shows cutting-edge solutions we built for our valuable clients to achieve their lucrative business dreams.
          </p>
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="#portfolio" class="btn text-base px-8 py-4 inline-flex items-center gap-2">
              View Portfolio
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
              </svg>
            </a>
            <a href="contact.php" class="text-white hover:text-primary transition-colors duration-300 font-medium inline-flex items-center gap-2 px-8 py-4">
              Start Project
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>
        
        <!-- Right Visual Pattern -->
        <div class="relative h-96 w-full max-w-lg me-auto ">
          <!-- Main Code Block (Center - Large) -->
          <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-50 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg shadow-2xl border border-gray-600 z-30">
            <div class="p-6 text-sm text-green-400 font-mono">
              <div class="mb-2">&lt;div class="portfolio"&gt;</div>
              <div class="ml-4 mb-2 text-blue-400">const projects = [];</div>
              <div class="ml-4 mb-2 text-yellow-400">const skills = ['React', 'Node'];</div>
              <div class="ml-4 mb-2 text-primary">render();</div>
              <div class="ml-4 mb-2 text-purple-400">deploy();</div>
              <div>&lt;/div&gt;</div>
            </div>
          </div>
          
          <!-- Elements Around Center -->
          
          <!-- Top Left (Clear) -->
          <div class="absolute top-8 left-8 w-24 h-18 bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg transform -rotate-12 shadow-lg border border-gray-700 opacity-80 z-15">
            <div class="p-2 text-center">
              <div class="text-gray-400 text-xs font-mono mb-1">API</div>
              <div class="flex justify-center gap-1">
                <div class="w-1 h-1 bg-primary/60 rounded-full"></div>
                <div class="w-1 h-1 bg-green-500/60 rounded-full"></div>
              </div>
            </div>
          </div>
          
          <!-- Top Right (Clear) -->
          <div class="absolute top-12 right-8 w-26 h-20 bg-gradient-to-br from-gray-700 to-gray-800 rounded transform rotate-8 shadow-lg border border-gray-600 opacity-80 z-15">
            <div class="p-2 text-center">
              <div class="text-gray-400 text-xs font-mono mb-1">DATABASE</div>
              <div class="flex justify-center gap-1">
                <div class="w-2 h-1 bg-blue-500/60 rounded-sm"></div>
                <div class="w-2 h-1 bg-gray-500/60 rounded-sm"></div>
              </div>
            </div>
          </div>
          
          <!-- Bottom Left (Clear) -->
          <div class="absolute bottom-12 left-6 w-24 h-18 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl transform -rotate-6 shadow-lg border border-gray-700 opacity-80 z-15">
            <div class="p-2 flex items-center justify-center h-full">
              <div class="relative">
                <div class="w-6 h-6 border border-primary/60 rounded-full"></div>
                <div class="absolute top-1 left-1 w-4 h-4 bg-primary/30 rounded-full"></div>
              </div>
            </div>
          </div>
          
          <!-- Bottom Right (Clear) -->
          <div class="absolute bottom-8 right-6 w-28 h-20 bg-gradient-to-br from-gray-700 to-gray-800 rounded-2xl transform rotate-4 shadow-lg border border-gray-600 opacity-80 z-15">
            <div class="p-2 flex flex-wrap gap-1 items-center justify-center h-full">
              <div class="w-4 h-4 bg-primary/40 rounded border border-primary/60 flex items-center justify-center text-xs text-primary font-bold">JS</div>
              <div class="w-4 h-4 bg-gray-600/40 rounded border border-gray-500/60 flex items-center justify-center text-xs text-gray-300 font-bold">PY</div>
            </div>
          </div>
          
          <!-- Left Side (Blurred) -->
          <div class="absolute top-1/2 left-2 transform -translate-y-1/2 w-16 h-20 bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg transform -rotate-8 shadow-lg border border-gray-700 blur-sm opacity-50 z-5">
            <div class="p-2 text-center">
              <div class="text-gray-400 text-xs font-mono">APP</div>
            </div>
          </div>
          
          <!-- Right Side (Blurred) -->
          <div class="absolute top-1/2 right-2 transform -translate-y-1/2 w-18 h-22 bg-gradient-to-br from-gray-700 to-gray-800 rounded transform rotate-6 shadow-lg border border-gray-600 blur-sm opacity-50 z-5">
            <div class="p-2 text-center">
              <div class="text-gray-400 text-xs font-mono">WEB</div>
            </div>
          </div>
          
          <!-- Top Center (Blurred) -->
          <div class="absolute top-4 left-1/2 transform -translate-x-1/2 w-20 h-12 bg-gradient-to-br from-gray-700 to-gray-800 rounded transform rotate-2 shadow-lg border border-gray-600 blur-sm opacity-40 z-5">
            <div class="p-1 text-center">
              <div class="text-gray-400 text-xs font-mono">CLOUD</div>
            </div>
          </div>
          
          <!-- Bottom Center (Blurred) -->
          <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 w-22 h-14 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl transform -rotate-3 shadow-lg border border-gray-700 blur-sm opacity-40 z-5">
            <div class="p-1 text-center">
              <div class="text-gray-400 text-xs font-mono">SERVER</div>
            </div>
          </div>
          
          <!-- Floating Dots -->
          <div class="absolute top-20 left-16 w-2 h-2 bg-primary/30 rounded-full blur-sm opacity-60"></div>
          <div class="absolute top-32 right-20 w-1.5 h-1.5 bg-gray-500/40 rounded-full blur-sm opacity-50"></div>
          <div class="absolute bottom-24 right-12 w-2 h-2 bg-primary/20 rounded-full blur-sm opacity-40"></div>
          <div class="absolute bottom-32 left-12 w-1.5 h-1.5 bg-gray-400/30 rounded-full blur-sm opacity-50"></div>
        </div>
          
         
          
          
        </div>
      </div>
    </div>
  </section>

  <!-- Portfolio Section -->
<section id="portfolio" class="pt-24 sm:pt-28 py-16 sm:py-22 relative overflow-hidden">
    <div class="container mx-auto px-12 sm:px-16 lg:px-24 xl:px-32">
      <div class="mb-12 sm:mb-16 reveal">
        <h2 class="text-2xl sm:text-3xl font-bold mb-4">OUR PORTFOLIO</h2>
        <p class="text-gray-400 max-w-2xl">Explore our diverse portfolio of successful projects across various industries.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!--Shopcart-->
        <div class="group bg-gray-900/50 rounded-xl overflow-hidden border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:shadow-2xl hover:shadow-primary/10 reveal" style="transition-delay: 100ms;">
          <div class="overflow-hidden">
            <img src="uploads/images/e-commerce1.webp" alt="ShopCart" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
          </div>
          <div class="p-6">
            <div class="flex items-center gap-2 mb-3">
              <span class="text-xs bg-primary/20 text-primary px-2 py-1 rounded-full">🛒 E-commerce</span>
              <span class="text-xs bg-gray-700 text-gray-300 px-2 py-1 rounded-full">Web Platform</span>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2 group-hover:text-primary transition-colors duration-300">ShopCart</h3>
            <p class="text-sm text-gray-400 mb-3">Complete E-commerce Solution</p>
            <p class="text-gray-300 text-sm mb-4 leading-relaxed">A full-featured e-commerce platform designed to convert visitors into customers through seamless shopping experiences, secure payments, and intuitive user interface.</p>
            <div class="flex flex-wrap gap-1 mb-4">
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">React</span>
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">Node.js</span>
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">Stripe</span>
            </div>
            <a href="shopcart.php" class="inline-flex items-center text-primary hover:text-white text-sm font-medium transition-colors duration-300">
              View Project
              <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>

        <!--9-ELEVEN WRAP ERP-->
        <div class="group bg-gray-900/50 rounded-xl overflow-hidden border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:shadow-2xl hover:shadow-primary/10 reveal" style="transition-delay: 200ms;">
          <div class="overflow-hidden">
            <img src="uploads/images/Dashboard1.png" alt="9-ELEVEN WRAP ERP" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
          </div>
          <div class="p-6">
            <div class="flex items-center gap-2 mb-3">
              <span class="text-xs bg-primary/20 text-primary px-2 py-1 rounded-full">🏢 ERP System</span>
              <span class="text-xs bg-gray-700 text-gray-300 px-2 py-1 rounded-full">Web Platform</span>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2 group-hover:text-primary transition-colors duration-300">9-ELEVEN WRAP ERP</h3>
            <p class="text-sm text-gray-400 mb-3">Enterprise Resource Planning System</p>
            <p class="text-gray-300 text-sm mb-4 leading-relaxed">A comprehensive ERP solution for business management with inventory control, sales tracking, and automated reporting for streamlined operations. Features real-time dashboard analytics, multi-location inventory management, and integrated accounting modules. Includes customer relationship management, supplier management, and automated workflow processes. Built with scalable architecture to handle growing business needs and complex operational requirements. Provides detailed insights through customizable reports and business intelligence tools for data-driven decision making.</p>
            <div class="flex flex-wrap gap-1 mb-4">
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">Next.js</span>
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">MongoDB</span>
            </div>
            <a href="erp.php" class="inline-flex items-center text-primary hover:text-white text-sm font-medium transition-colors duration-300">
              View Project
              <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>

        <!--Jungle Adventure-->
        <div class="group bg-gray-900/50 rounded-xl overflow-hidden border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:shadow-2xl hover:shadow-primary/10 reveal" style="transition-delay: 300ms;">
          <div class="overflow-hidden">
            <img src="uploads/images/jungle-game.webp" alt="Jungle Adventure" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
          </div>
          <div class="p-6">
            <div class="flex items-center gap-2 mb-3">
              <span class="text-xs bg-primary/20 text-primary px-2 py-1 rounded-full">🎮 Gaming</span>
              <span class="text-xs bg-gray-700 text-gray-300 px-2 py-1 rounded-full">Mobile Game</span>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2 group-hover:text-primary transition-colors duration-300">Jungle Adventure</h3>
            <p class="text-sm text-gray-400 mb-3">Adventure Mobile Game</p>
            <p class="text-gray-300 text-sm mb-4 leading-relaxed">An exciting jungle-themed adventure game with stunning graphics, challenging levels, and immersive gameplay mechanics for mobile platforms.</p>
            <div class="flex flex-wrap gap-1 mb-4">
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">Unity</span>
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">C#</span>
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">Android</span>
            </div>
            <a href="JungleAdventure.php" class="inline-flex items-center text-primary hover:text-white text-sm font-medium transition-colors duration-300">
              View Project
              <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>

        <!--Insurance Case Study-->
        <div class="group bg-gray-900/50 rounded-xl overflow-hidden border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:shadow-2xl hover:shadow-primary/10 reveal" style="transition-delay: 400ms;">
          <div class="overflow-hidden">
            <img src="uploads/images/insurance-web.webp" alt="Insurance Platform" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
          </div>
          <div class="p-6">
            <div class="flex items-center gap-2 mb-3">
              <span class="text-xs bg-primary/20 text-primary px-2 py-1 rounded-full">🏥 Insurance</span>
              <span class="text-xs bg-gray-700 text-gray-300 px-2 py-1 rounded-full">Web Platform</span>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2 group-hover:text-primary transition-colors duration-300">Insurance Platform</h3>
            <p class="text-sm text-gray-400 mb-3">Digital Insurance Management</p>
            <p class="text-gray-300 text-sm mb-4 leading-relaxed">A comprehensive insurance management platform with policy management, claims processing, and customer portal for streamlined insurance operations.</p>
            <div class="flex flex-wrap gap-1 mb-4">
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">Laravel</span>
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">MySQL</span>
              <span class="text-xs bg-gray-800 text-gray-400 px-2 py-1 rounded">Vue.js</span>
            </div>
            <a href="Insurancecase.php" class="inline-flex items-center text-primary hover:text-white text-sm font-medium transition-colors duration-300">
              View Project
              <svg class="w-4 h-4 ml-1 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>
        



        
      </div>
  </section>

 

  <!-- Footer -->
  <footer class="bg-black text-grey py-12 sm:py-16 border-t border-gray-800">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-12">
            <div class="mb-6"> <!-- Added mb-6 for consistent spacing -->
                <h3 class="text-lg font-bold mb-4 text-grey-600">Contact Us</h3>
                <p class="text-gray-200 mb-2"><strong>Email:</strong> <a href="mailto:info@technovatechnologies.com" class="text-gray-200 hover:text-red-600">info@technovatechnologies.com</a></p>
                <p class="text-gray-200 mb-2"><strong>Phone:</strong> <a href="tel:+91 94273 00816" class="text-gray-200 hover:text-red-600">+91 94273 00816</a></p>
                <p class="text-gray-200 mb-2"><strong>Address:</strong> 608 - Time Square Commercial Complex</p>
                <p class="text-gray-200"> Near Ayodhya Chowk, 150 Feet Ring Rd, Rajkot, Gujarat 360007</p>
            </div>
            <div class="mb-6"> <!-- Added mb-8 for consistent spacing -->
                <h3 class="text-lg font-bold mb-4 text-gery-600">Services</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">Web Development</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">App Development</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">Web Design</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">ERP Development</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">SEO Development</a></li>
                </ul>
            </div>
            <div class="mb-6"> <!-- Added mb-6 for consistent spacing -->
                <h3 class="text-lg font-bold mb-4 text-grey-600">Our Technologies</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">ASP.NET</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">MERN Stack</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">PHP,My SQL</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">Cloud Computing</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300"></a>Angular</li>
                </ul>
            </div>
            
        </div>
            
        <div class="flex justify-between items-center pt-8 border-t border-gray-800">
          <!-- Copyright -->
            <p class="mt-4 text-sm">&copy; 2025 Technova Technologies. All rights reserved.</p>
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
</body>

</html>