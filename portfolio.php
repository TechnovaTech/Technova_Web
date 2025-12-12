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

  <!-- Property Showcase Section -->
  <section class="py-20 sm:py-28 bg-gradient-to-br from-gray-900 via-black to-gray-800 relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Left - Laptop Mockup -->
        <div class="relative">
          <div class="relative transform hover:scale-105 transition-transform duration-700">
            <div class="relative w-full max-w-lg mx-auto">
              <!-- Laptop Frame -->
              <div class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-t-3xl p-4 shadow-2xl">
                <div class="bg-white rounded-2xl overflow-hidden shadow-inner">
                  <!-- Browser Header -->
                  <div class="bg-gray-100 h-8 flex items-center px-4 gap-2">
                    <div class="flex gap-1.5">
                      <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                      <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                      <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                    </div>
                    <div class="flex-1 bg-white h-5 rounded-full mx-4 flex items-center px-3">
                      <div class="text-xs text-gray-400">property.com</div>
                    </div>
                  </div>
                  
                  <!-- Website Content -->
                  <div class="p-6 bg-gradient-to-br from-teal-50 to-blue-50">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                      <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center">
                          <div class="w-4 h-4 bg-white rounded-sm"></div>
                        </div>
                        <span class="font-bold text-gray-800">Property</span>
                      </div>
                      <div class="flex gap-4 text-xs text-gray-600">
                        <span>Landlords</span>
                        <span>Tenants</span>
                      </div>
                    </div>
                    
                    <!-- Main Content -->
                    <div class="grid grid-cols-2 gap-4">
                      <!-- Left Content -->
                      <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Happy tenants,<br>hassle-free.</h2>
                        <p class="text-xs text-gray-600 mb-4">Advertise your property, choose the best tenants, always get your rent on time - all in one place.</p>
                        <div class="flex gap-2">
                          <button class="bg-teal-500 text-white px-3 py-1.5 rounded-lg text-xs font-medium">View my property</button>
                          <button class="border border-gray-300 px-3 py-1.5 rounded-lg text-xs">Talk to an expert</button>
                        </div>
                      </div>
                      
                      <!-- Right Content - Property Image -->
                      <div class="relative">
                        <div class="bg-gradient-to-br from-green-400 to-blue-500 rounded-xl h-24 relative overflow-hidden">
                          <!-- House illustration -->
                          <div class="absolute bottom-0 right-2 w-16 h-16 bg-yellow-200 rounded-t-lg">
                            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-8 border-r-8 border-b-6 border-transparent border-b-red-600"></div>
                            <div class="absolute bottom-2 left-2 w-3 h-4 bg-blue-600 rounded-sm"></div>
                            <div class="absolute bottom-2 right-2 w-3 h-3 bg-yellow-400 rounded-sm"></div>
                          </div>
                        </div>
                        
                        <!-- Property Card -->
                        <div class="absolute -bottom-2 -right-2 bg-white rounded-lg p-2 shadow-lg border">
                          <div class="text-xs font-medium">Next steps</div>
                          <div class="flex items-center gap-1 mt-1">
                            <div class="flex -space-x-1">
                              <div class="w-4 h-4 bg-blue-400 rounded-full border border-white"></div>
                              <div class="w-4 h-4 bg-green-400 rounded-full border border-white"></div>
                              <div class="w-4 h-4 bg-yellow-400 rounded-full border border-white"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Laptop Base -->
              <div class="bg-gradient-to-b from-gray-600 to-gray-800 h-6 rounded-b-3xl shadow-2xl">
                <div class="flex justify-center pt-1">
                  <div class="w-20 h-1 bg-gray-500 rounded-full"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Right - Content -->
        <div class="text-left">
          <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-8">
            PROPERTY
          </h2>
          
          <!-- Tech Stack Tags -->
          <div class="flex flex-wrap gap-3 mb-8">
            <span class="px-4 py-2 bg-transparent border border-green-500 text-green-400 rounded-full text-sm font-medium hover:bg-green-500 hover:text-white transition-all duration-300">
              Next.Js
            </span>
            <span class="px-4 py-2 bg-transparent border border-blue-500 text-blue-400 rounded-full text-sm font-medium hover:bg-blue-500 hover:text-white transition-all duration-300">
              TypeScript
            </span>
            <span class="px-4 py-2 bg-transparent border border-cyan-500 text-cyan-400 rounded-full text-sm font-medium hover:bg-cyan-500 hover:text-white transition-all duration-300">
              Tailwind CSS
            </span>
          </div>
          
          <!-- Description -->
          <p class="text-lg text-gray-300 mb-8 leading-relaxed">
            Property is a leading online platform connecting landlords with tenants across the World. With a focus on simplicity, efficiency, and transparency, the platform facilitates property rental transactions, offering landlords various services from advertising their properties to finding suitable tenants.
          </p>
          
          <!-- CTA Button -->
          <a href="#" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
            View Details
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Portfolio Section -->
<section id="portfolio" class="pt-24 sm:pt-32 py-20 sm:py-28 relative overflow-hidden bg-gradient-to-br from-black via-gray-900 to-black">
    <!-- Background Elements -->
    <div class="absolute inset-0">
      <div class="absolute top-0 left-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
      <div class="absolute bottom-0 right-0 w-80 h-80 bg-blue-500/5 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
      <div class="mb-16 sm:mb-20 reveal">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-8 mb-12">
          <div class="flex-1">
            <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 rounded-full px-4 py-2 mb-6">
              <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
              <span class="text-primary text-sm font-medium">OUR WORK</span>
            </div>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6">
              <span class="text-white">Featured </span>
              <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-pink-500">Portfolio</span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl leading-relaxed">Explore our diverse portfolio of successful projects across various industries, showcasing innovation and excellence in every solution.</p>
          </div>
          

        </div>
      </div>

      <!-- 3-Card Carousel -->
      <div class="relative overflow-hidden">
        <div id="carousel-container" class="flex justify-center items-center gap-8 px-4 py-8">
          <!-- ShopCart Project -->
          <div class="portfolio-card bg-gray-900/50 rounded-2xl overflow-hidden border border-gray-700/50 transition-all duration-500">
            <div class="relative h-48 overflow-hidden">
              <img src="uploads/images/e-commerce1.webp" alt="ShopCart" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
              <div class="absolute bottom-4 left-4">
                <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-medium">E-COMMERCE</span>
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-white mb-2">ShopCart</h3>
              <p class="text-gray-400 mb-4">Complete E-commerce Platform Solution</p>
              <div class="flex gap-2 mb-4">
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">React</span>
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">Node.js</span>
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">MongoDB</span>
              </div>
              <a href="shopcart.php" class="inline-flex items-center gap-2 text-primary hover:text-white font-medium transition-colors">
                View Project
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>

          <!-- 9-ELEVEN WRAP ERP -->
          <div class="portfolio-card bg-gray-900/50 rounded-2xl overflow-hidden border border-gray-700/50 transition-all duration-500">
            <div class="relative h-48 overflow-hidden">
              <img src="uploads/images/Dashboard1.png" alt="9-ELEVEN WRAP ERP" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
              <div class="absolute bottom-4 left-4">
                <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-medium">ENTERPRISE</span>
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-white mb-2">9-ELEVEN WRAP ERP</h3>
              <p class="text-gray-400 mb-4">Enterprise Resource Planning System</p>
              <div class="flex gap-2 mb-4">
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">Next.js</span>
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">MongoDB</span>
              </div>
              <a href="erp.php" class="inline-flex items-center gap-2 text-primary hover:text-white font-medium transition-colors">
                View Details
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>

          <!-- Jungle Adventure -->
          <div class="portfolio-card bg-gray-900/50 rounded-2xl overflow-hidden border border-gray-700/50 transition-all duration-500">
            <div class="relative h-48 overflow-hidden">
              <img src="uploads/images/jungle-game.webp" alt="Jungle Adventure" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
              <div class="absolute bottom-4 left-4">
                <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-medium">GAMING</span>
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-white mb-2">Jungle Adventure</h3>
              <p class="text-gray-400 mb-4">Immersive Mobile Gaming Experience</p>
              <div class="flex gap-2 mb-4">
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">Unity</span>
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">C#</span>
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">Android</span>
              </div>
              <a href="JungleAdventure.php" class="inline-flex items-center gap-2 text-primary hover:text-white font-medium transition-colors">
                Play Demo
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>

          <!-- Insurance Platform -->
          <div class="portfolio-card bg-gray-900/50 rounded-2xl overflow-hidden border border-gray-700/50 transition-all duration-500">
            <div class="relative h-48 overflow-hidden">
              <img src="uploads/images/insurance-web.webp" alt="Insurance Platform" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
              <div class="absolute bottom-4 left-4">
                <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-medium">FINTECH</span>
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-white mb-2">Insurance Platform</h3>
              <p class="text-gray-400 mb-4">Digital Insurance Management System</p>
              <div class="flex gap-2 mb-4">
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">Laravel</span>
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">MySQL</span>
                <span class="text-xs bg-gray-800 text-gray-300 px-2 py-1 rounded">Vue.js</span>
              </div>
              <a href="Insurancecase.php" class="inline-flex items-center gap-2 text-primary hover:text-white font-medium transition-colors">
                Case Study
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Navigation Arrows -->
        <button id="prev-btn" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-black/50 hover:bg-primary rounded-full flex items-center justify-center transition-all duration-300 z-20">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
        </button>
        <button id="next-btn" class="absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-black/50 hover:bg-primary rounded-full flex items-center justify-center transition-all duration-300 z-20">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </button>
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
</body>

</html>