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

  <!-- Mobile App Showcase Section -->
  <section class="py-20 sm:py-28 bg-gradient-to-br from-black via-gray-900 to-black relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
      <div class="absolute top-20 left-10 w-72 h-72 bg-primary/5 rounded-full blur-3xl animate-pulse-slow"></div>
      <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1s;"></div>
      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-primary/3 to-blue-500/3 rounded-full blur-3xl opacity-50"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
      <div class="text-center mb-20">
        <div class="inline-flex items-center gap-2 bg-primary/10 border border-primary/20 rounded-full px-4 py-2 mb-6">
          <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
          <span class="text-primary text-sm font-medium">MOBILE INNOVATION</span>
        </div>
        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
          Mobile <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-pink-500">Applications</span>
        </h2>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">Crafting intuitive mobile experiences that users love with cutting-edge technology and seamless design</p>
      </div>
      
      <!-- Phone Mockups Display -->
      <div class="flex justify-center items-end gap-6 lg:gap-8 relative">
        <!-- Left Phone (Modern Blur Effect) -->
        <div class="relative transform -translate-y-12 scale-90 group">
          <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-blue-500/20 rounded-[3rem] blur-xl opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
          <div class="relative w-64 h-[520px] bg-gradient-to-b from-gray-800 to-black rounded-[2.5rem] p-2 shadow-2xl border border-gray-700/50">
            <div class="w-full h-full bg-black rounded-[2rem] overflow-hidden relative">
              <!-- Dynamic Notch -->
              <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-32 h-6 bg-black rounded-full z-20"></div>
              
              <!-- Screen Content -->
              <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-black p-4">
                <!-- Enhanced Status Bar -->
                <div class="flex justify-between items-center mb-8 text-white text-sm pt-4">
                  <div class="flex items-center gap-1">
                    <div class="w-1 h-1 bg-green-400 rounded-full"></div>
                    <span class="text-xs">9:41</span>
                  </div>
                  <div class="flex items-center gap-1">
                    <div class="w-4 h-2 bg-white/80 rounded-sm"></div>
                    <div class="w-1 h-3 bg-white rounded-sm"></div>
                  </div>
                </div>
                
                <!-- Modern App Interface -->
                <div class="text-center mb-8">
                  <div class="w-20 h-20 bg-gradient-to-br from-orange-400 via-red-500 to-pink-500 rounded-3xl mx-auto mb-4 flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                  </div>
                  <h3 class="text-white font-semibold text-base mb-1">PowerHub</h3>
                  <p class="text-gray-400 text-sm">Productivity Suite</p>
                </div>
                
                <!-- Modern Cards -->
                <div class="space-y-3 mb-6">
                  <div class="bg-gradient-to-r from-gray-800/80 to-gray-700/60 rounded-2xl p-4 backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <div class="w-4 h-4 bg-white rounded-sm"></div>
                      </div>
                      <div class="flex-1">
                        <div class="w-24 h-2 bg-gray-600 rounded mb-2"></div>
                        <div class="w-20 h-1.5 bg-gray-700 rounded"></div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Floating Action Button -->
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
                  <div class="w-14 h-14 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Center Phone (Hero/Main Focus) -->
        <div class="relative z-20 transform scale-125 group">
          <!-- Glowing Ring Effect -->
          <div class="absolute inset-0 bg-gradient-to-br from-primary via-pink-500 to-blue-500 rounded-[3rem] blur-2xl opacity-30 group-hover:opacity-50 transition-all duration-1000 animate-pulse-slow"></div>
          
          <div class="relative w-72 h-[580px] bg-gradient-to-b from-gray-900 via-black to-gray-900 rounded-[2.8rem] p-2 shadow-2xl border border-gray-600/50">
            <div class="w-full h-full bg-black rounded-[2.4rem] overflow-hidden relative">
              <!-- Dynamic Island -->
              <div class="absolute top-3 left-1/2 transform -translate-x-1/2 w-36 h-7 bg-black rounded-full z-30 border border-gray-800"></div>
              
              <!-- Screen Content -->
              <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-black to-gray-900">
                <!-- Enhanced Header -->
                <div class="bg-gradient-to-br from-primary via-pink-500 to-purple-600 p-6 pb-10 relative overflow-hidden">
                  <!-- Floating Elements -->
                  <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                  <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                  
                  <div class="flex justify-between items-center mb-6 text-white text-sm pt-4 relative z-10">
                    <div class="flex items-center gap-2">
                      <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                      <span>9:41</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <div class="w-5 h-2.5 bg-white/90 rounded-sm"></div>
                      <div class="w-1.5 h-4 bg-white rounded-sm"></div>
                    </div>
                  </div>
                  
                  <!-- Profile Section -->
                  <div class="text-center relative z-10">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-full mx-auto mb-4 flex items-center justify-center border border-white/30">
                      <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                      </svg>
                    </div>
                    <h2 class="text-white text-xl font-bold mb-2">Let's Get Started</h2>
                    <p class="text-white/90 text-sm">Choose your perfect solution</p>
                  </div>
                </div>
                
                <!-- Content Area -->
                <div class="p-6 -mt-6 relative z-10">
                  <div class="bg-white/95 backdrop-blur-xl rounded-3xl p-6 shadow-2xl mb-6 border border-gray-200/50">
                    <div class="grid grid-cols-2 gap-4">
                      <div class="text-center group/item">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary/10 to-pink-500/10 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover/item:scale-110 transition-transform duration-300">
                          <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                          </svg>
                        </div>
                        <span class="text-gray-800 text-sm font-semibold">Web</span>
                      </div>
                      <div class="text-center group/item">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover/item:scale-110 transition-transform duration-300">
                          <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                          </svg>
                        </div>
                        <span class="text-gray-800 text-sm font-semibold">Mobile</span>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Enhanced Action Button -->
                  <div class="text-center">
                    <div class="relative group/btn">
                      <div class="absolute inset-0 bg-gradient-to-r from-primary to-pink-500 rounded-full blur-lg opacity-50 group-hover/btn:opacity-75 transition-opacity duration-300"></div>
                      <div class="relative w-16 h-16 bg-gradient-to-br from-primary via-pink-500 to-purple-600 rounded-full flex items-center justify-center mx-auto shadow-2xl group-hover/btn:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Right Phone (Modern Remote) -->
        <div class="relative transform -translate-y-12 scale-90 group">
          <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-[3rem] blur-xl opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
          <div class="relative w-64 h-[520px] bg-gradient-to-b from-gray-800 to-black rounded-[2.5rem] p-2 shadow-2xl border border-gray-700/50">
            <div class="w-full h-full bg-black rounded-[2rem] overflow-hidden relative">
              <!-- Dynamic Notch -->
              <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-32 h-6 bg-black rounded-full z-20"></div>
              
              <!-- Screen Content -->
              <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-black p-4">
                <!-- Enhanced Status Bar -->
                <div class="flex justify-between items-center mb-8 text-white text-sm pt-4">
                  <div class="flex items-center gap-1">
                    <div class="w-1 h-1 bg-blue-400 rounded-full"></div>
                    <span class="text-xs">9:41</span>
                  </div>
                  <div class="flex items-center gap-1">
                    <div class="w-4 h-2 bg-white/80 rounded-sm"></div>
                    <div class="w-1 h-3 bg-white rounded-sm"></div>
                  </div>
                </div>
                
                <!-- Modern Remote Interface -->
                <div class="text-center">
                  <!-- Enhanced Control Pad -->
                  <div class="grid grid-cols-3 gap-4 mb-8 justify-items-center">
                    <div></div>
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-full flex items-center justify-center border border-gray-600 shadow-lg">
                      <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                      </svg>
                    </div>
                    <div></div>
                    
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-full flex items-center justify-center border border-gray-600 shadow-lg">
                      <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                      </svg>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-pink-500 rounded-full flex items-center justify-center shadow-xl border border-primary/50">
                      <div class="w-4 h-4 bg-white rounded-full"></div>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-full flex items-center justify-center border border-gray-600 shadow-lg">
                      <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                      </svg>
                    </div>
                    
                    <div></div>
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-700 to-gray-800 rounded-full flex items-center justify-center border border-gray-600 shadow-lg">
                      <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </div>
                    <div></div>
                  </div>
                  
                  <!-- Modern Number Pad -->
                  <div class="grid grid-cols-3 gap-3 text-white text-sm max-w-32 mx-auto">
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center border border-gray-600 font-medium">1</div>
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center border border-gray-600 font-medium">2</div>
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center border border-gray-600 font-medium">3</div>
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center border border-gray-600 font-medium">4</div>
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center border border-gray-600 font-medium">5</div>
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center border border-gray-600 font-medium">6</div>
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center border border-gray-600 font-medium">7</div>
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center border border-gray-600 font-medium">8</div>
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center border border-gray-600 font-medium">9</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
          
          <div class="hidden lg:flex gap-3">
            <button id="scroll-left" class="group w-14 h-14 bg-gray-800/50 hover:bg-primary border border-gray-700 hover:border-primary rounded-2xl flex items-center justify-center transition-all duration-300 backdrop-blur-sm">
              <svg class="w-6 h-6 text-gray-300 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
            </button>
            <button id="scroll-right" class="group w-14 h-14 bg-gray-800/50 hover:bg-primary border border-gray-700 hover:border-primary rounded-2xl flex items-center justify-center transition-all duration-300 backdrop-blur-sm">
              <svg class="w-6 h-6 text-gray-300 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Horizontal Scrolling Portfolio -->
      <div id="portfolio-container" class="overflow-x-auto pb-6 scroll-smooth" style="scrollbar-width: thin; scrollbar-color: #E11D48 #1F2937;">
        <div class="flex gap-6 px-2" style="width: max-content;">
          <!-- ShopCart Project Card -->
          <div class="portfolio-card group relative overflow-hidden" style="transition-delay: 100ms;">
            <!-- E-commerce Background Pattern -->
            <div class="absolute inset-0 bg-black rounded-3xl">
              <div class="absolute inset-0 opacity-20">
                <div class="absolute top-6 right-6 w-6 h-6 border border-green-500/30 rounded-full"></div>
                <div class="absolute bottom-8 left-6 w-4 h-4 bg-green-500/20 rounded-full"></div>
                <div class="absolute top-12 left-8 w-8 h-8 border border-primary/20 transform rotate-45"></div>
              </div>
            </div>
            
            <!-- Modern Card Design -->
            <div class="relative bg-gradient-to-br from-gray-900/95 via-gray-800/90 to-gray-900/95 backdrop-blur-xl border border-gray-700/40 rounded-3xl overflow-hidden group-hover:border-green-500/40 transition-all duration-500 hover:shadow-2xl hover:shadow-green-500/10">
              <!-- Enhanced Image Section -->
              <div class="relative h-48 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/5"></div>
                <img src="uploads/images/e-commerce1.webp" alt="ShopCart" class="w-full h-full object-cover transform group-hover:scale-105 transition-all duration-700">
                
                <!-- E-commerce Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                
                <!-- Shopping Cart Icon -->
                <div class="absolute top-4 right-4 w-12 h-12 bg-black/60 backdrop-blur-md rounded-2xl flex items-center justify-center border border-green-500/40 transform group-hover:scale-110 transition-transform duration-500">
                  <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5M7 13l-1.1 5m0 0h9.2M16 18a2 2 0 11-4 0 2 2 0 014 0zM9 18a2 2 0 11-4 0 2 2 0 014 0z"></path>
                  </svg>
                </div>
                
                <!-- Project Number -->
                <div class="absolute bottom-4 left-4 w-14 h-14 bg-black/60 backdrop-blur-md rounded-full flex items-center justify-center border border-green-500/30">
                  <span class="text-green-400 font-bold">01</span>
                </div>
              </div>
              
              <!-- Content Section -->
              <div class="p-6 relative transform group-hover:translate-y-1 transition-transform duration-300">
                <!-- E-commerce Category -->
                <div class="flex items-center gap-3 mb-4">
                  <div class="flex items-center gap-2 bg-gradient-to-r from-green-500/20 to-emerald-500/20 px-3 py-1.5 rounded-2xl border border-green-500/30">
                    <svg class="w-3 h-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5zM10 18V7l5 4v7H10z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-xs text-green-400 font-semibold">E-COMMERCE</span>
                  </div>
                  <div class="px-2 py-1 bg-gray-800/50 rounded-lg">
                    <span class="text-xs text-gray-400">PLATFORM</span>
                  </div>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-green-400 group-hover:to-emerald-500 transition-all duration-500">ShopCart</h3>
                <p class="text-sm text-gray-400 mb-4">Complete E-commerce Platform Solution</p>
                
                <!-- Tech Stack -->
                <div class="flex gap-2 mb-6">
                  <span class="tech-tag">React</span>
                  <span class="tech-tag">Node.js</span>
                  <span class="tech-tag">MongoDB</span>
                </div>
                
                <!-- Enhanced CTA -->
                <a href="shopcart.php" class="group/btn relative inline-flex items-center gap-2 bg-gradient-to-r from-green-500/10 to-emerald-500/10 hover:from-green-500 hover:to-emerald-500 text-green-400 hover:text-white px-6 py-3 rounded-2xl border border-green-500/30 hover:border-transparent font-semibold transition-all duration-300 overflow-hidden">
                  <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  <span class="relative z-10">View Project</span>
                  <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-500 transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></div>
                </a>
              </div>
            </div>
          </div>

        <!--9-ELEVEN WRAP ERP-->
        <div class="portfolio-card group relative overflow-hidden" style="transition-delay: 200ms;">
          <!-- Hexagonal Background Pattern -->
          <div class="absolute inset-0 bg-black rounded-3xl">
            <div class="absolute inset-0 opacity-20">
              <div class="absolute top-4 left-4 w-8 h-8 border border-primary/30 transform rotate-45"></div>
              <div class="absolute top-12 right-8 w-6 h-6 border border-pink-500/20 transform rotate-12"></div>
              <div class="absolute bottom-8 left-8 w-4 h-4 bg-primary/20 transform rotate-45"></div>
            </div>
          </div>
          
          <!-- Tilted Card Design -->
          <div class="relative bg-gradient-to-br from-gray-900/95 via-gray-800/85 to-gray-900/95 backdrop-blur-xl border border-gray-700/40 rounded-3xl transform group-hover:-rotate-1 transition-all duration-700 hover:shadow-2xl hover:shadow-primary/15">
            <!-- Diagonal Image Layout -->
            <div class="relative h-48 overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-pink-500/5"></div>
              <img src="uploads/images/Dashboard1.png" alt="9-ELEVEN WRAP ERP" class="w-full h-full object-cover transform group-hover:scale-105 group-hover:-rotate-1 transition-all duration-700">
              
              <!-- Geometric Overlay -->
              <div class="absolute inset-0 bg-gradient-to-tr from-black/60 via-transparent to-primary/20"></div>
              
              <!-- Animated Corner Element -->
              <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-primary/30 to-transparent transform rotate-45 translate-x-10 -translate-y-10 group-hover:translate-x-5 group-hover:-translate-y-5 transition-transform duration-500"></div>
              
              <!-- Project Number -->
              <div class="absolute bottom-4 left-4 w-14 h-14 bg-black/60 backdrop-blur-md rounded-full flex items-center justify-center border border-primary/30">
                <span class="text-primary font-bold">02</span>
              </div>
            </div>
            
            <!-- Content with Slide Animation -->
            <div class="p-6 relative transform group-hover:translate-y-1 transition-transform duration-300">
              <!-- Category with Icon -->
              <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-2 bg-gradient-to-r from-blue-500/20 to-primary/20 px-3 py-1.5 rounded-2xl border border-blue-500/30">
                  <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                  <span class="text-xs text-blue-400 font-semibold">ENTERPRISE</span>
                </div>
                <div class="w-8 h-8 bg-gray-800/50 rounded-lg flex items-center justify-center">
                  <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                  </svg>
                </div>
              </div>
              
              <h3 class="text-xl font-bold text-white mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-blue-400 group-hover:to-primary transition-all duration-500">9-ELEVEN WRAP ERP</h3>
              <p class="text-sm text-gray-400 mb-4">Enterprise Resource Planning System</p>
              
              <!-- Tech Stack -->
              <div class="flex gap-2 mb-6">
                <span class="tech-tag">Next.js</span>
                <span class="tech-tag">MongoDB</span>
              </div>
              
              <!-- CTA with Slide Effect -->
              <a href="erp.php" class="group/btn relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-500/10 to-primary/10 hover:from-blue-500 hover:to-primary text-blue-400 hover:text-white px-6 py-3 rounded-2xl border border-blue-500/30 hover:border-transparent font-semibold transition-all duration-300 overflow-hidden">
                <span class="relative z-10">View Details</span>
                <svg class="w-4 h-4 relative z-10 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-primary transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></div>
              </a>
            </div>
          </div>
        </div>

        <!--Jungle Adventure-->
        <div class="portfolio-card group relative overflow-hidden" style="transition-delay: 300ms;">
          <!-- Organic Flowing Background -->
          <div class="absolute inset-0 bg-black rounded-3xl">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 via-emerald-500/5 to-primary/10 opacity-0 group-hover:opacity-100 transition-all duration-1000"></div>
            <!-- Floating Organic Shapes -->
            <div class="absolute top-8 right-8 w-16 h-16 bg-gradient-to-br from-green-400/20 to-emerald-500/10 rounded-full blur-xl transform group-hover:scale-150 group-hover:translate-x-4 group-hover:-translate-y-4 transition-all duration-1000"></div>
            <div class="absolute bottom-12 left-6 w-12 h-12 bg-gradient-to-tr from-primary/15 to-green-400/10 rounded-full blur-lg transform group-hover:scale-125 group-hover:-translate-x-2 group-hover:translate-y-2 transition-all duration-700"></div>
          </div>
          
          <!-- Card with Curved Design -->
          <div class="relative bg-gradient-to-br from-gray-900/95 via-gray-800/90 to-gray-900/95 backdrop-blur-xl border border-gray-700/40 rounded-3xl overflow-hidden group-hover:border-green-500/40 transition-all duration-500 hover:shadow-2xl hover:shadow-green-500/10">
            <!-- Curved Image Section -->
            <div class="relative h-48 overflow-hidden">
              <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 via-transparent to-emerald-500/10"></div>
              <img src="uploads/images/jungle-game.webp" alt="Jungle Adventure" class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-700">
              
              <!-- Curved Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
              <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-gray-900 to-transparent transform group-hover:translate-y-2 transition-transform duration-500"></div>
              
              <!-- Gaming Elements -->
              <div class="absolute top-4 left-4 flex gap-2">
                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse" style="animation-delay: 0.3s;"></div>
                <div class="w-3 h-3 bg-primary rounded-full animate-pulse" style="animation-delay: 0.6s;"></div>
              </div>
              
              <!-- Project Number with Game Controller Icon -->
              <div class="absolute top-4 right-4 w-12 h-12 bg-black/50 backdrop-blur-md rounded-2xl flex items-center justify-center border border-green-500/30 transform group-hover:rotate-12 transition-transform duration-500">
                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 7a1 1 0 00-2 0v2a1 1 0 002 0V7zM12 7a1 1 0 10-2 0v2a1 1 0 102 0V7z" clip-rule="evenodd"></path>
                </svg>
              </div>
            </div>
            
            <!-- Content with Bounce Animation -->
            <div class="p-6 relative transform group-hover:-translate-y-1 transition-transform duration-300">
              <!-- Gaming Category -->
              <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-2 bg-gradient-to-r from-green-500/20 to-emerald-500/20 px-3 py-1.5 rounded-2xl border border-green-500/30">
                  <svg class="w-3 h-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span class="text-xs text-green-400 font-semibold">GAMING</span>
                </div>
                <div class="px-2 py-1 bg-gray-800/50 rounded-lg">
                  <span class="text-xs text-gray-400">MOBILE</span>
                </div>
              </div>
              
              <h3 class="text-xl font-bold text-white mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-green-400 group-hover:to-emerald-500 transition-all duration-500">Jungle Adventure</h3>
              <p class="text-sm text-gray-400 mb-4">Immersive Mobile Gaming Experience</p>
              
              <!-- Tech Stack -->
              <div class="flex gap-2 mb-6">
                <span class="tech-tag">Unity</span>
                <span class="tech-tag">C#</span>
                <span class="tech-tag">Android</span>
              </div>
              
              <!-- Play Button Style CTA -->
              <a href="JungleAdventure.php" class="group/btn relative inline-flex items-center gap-2 bg-gradient-to-r from-green-500/10 to-emerald-500/10 hover:from-green-500 hover:to-emerald-500 text-green-400 hover:text-white px-6 py-3 rounded-2xl border border-green-500/30 hover:border-transparent font-semibold transition-all duration-300 overflow-hidden">
                <svg class="w-4 h-4 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                </svg>
                <span class="relative z-10">Play Demo</span>
                <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-500 transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></div>
              </a>
            </div>
          </div>
        </div>

        <!--Insurance Case Study-->
        <div class="portfolio-card group relative overflow-hidden" style="transition-delay: 400ms;">
          <!-- Professional Grid Background -->
          <div class="absolute inset-0 bg-black rounded-3xl">
            <div class="absolute inset-0 opacity-30">
              <!-- Grid Pattern -->
              <div class="absolute inset-0" style="background-image: linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px); background-size: 20px 20px;"></div>
            </div>
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-500/5 via-transparent to-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
          </div>
          
          <!-- Professional Card Design -->
          <div class="relative bg-gradient-to-br from-gray-900/98 via-gray-800/95 to-gray-900/98 backdrop-blur-xl border border-gray-700/50 rounded-3xl overflow-hidden group-hover:border-blue-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/10">
            <!-- Split Layout Image -->
            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-blue-900/20 to-indigo-900/10">
              <img src="uploads/images/insurance-web.webp" alt="Insurance Platform" class="w-full h-full object-cover transform group-hover:scale-105 transition-all duration-700">
              
              <!-- Professional Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
              
              <!-- Data Visualization Elements -->
              <div class="absolute top-4 left-4 flex flex-col gap-2">
                <div class="flex gap-1">
                  <div class="w-8 h-1 bg-blue-400 rounded-full"></div>
                  <div class="w-6 h-1 bg-blue-300 rounded-full"></div>
                  <div class="w-4 h-1 bg-blue-200 rounded-full"></div>
                </div>
                <div class="flex gap-1">
                  <div class="w-6 h-1 bg-indigo-400 rounded-full"></div>
                  <div class="w-8 h-1 bg-indigo-300 rounded-full"></div>
                  <div class="w-3 h-1 bg-indigo-200 rounded-full"></div>
                </div>
              </div>
              
              <!-- Security Badge -->
              <div class="absolute top-4 right-4 w-12 h-12 bg-black/60 backdrop-blur-md rounded-xl flex items-center justify-center border border-blue-500/40 transform group-hover:scale-110 transition-transform duration-500">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
              </div>
            </div>
            
            <!-- Content with Professional Styling -->
            <div class="p-6 relative">
              <!-- Professional Category -->
              <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-2 bg-gradient-to-r from-blue-500/20 to-indigo-500/20 px-3 py-1.5 rounded-2xl border border-blue-500/30">
                  <svg class="w-3 h-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-xs text-blue-400 font-semibold">FINTECH</span>
                </div>
                <div class="px-2 py-1 bg-gray-800/50 rounded-lg">
                  <span class="text-xs text-gray-400">PLATFORM</span>
                </div>
              </div>
              
              <h3 class="text-xl font-bold text-white mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-blue-400 group-hover:to-indigo-500 transition-all duration-500">Insurance Platform</h3>
              <p class="text-sm text-gray-400 mb-4">Digital Insurance Management System</p>
              
              <!-- Tech Stack -->
              <div class="flex gap-2 mb-6">
                <span class="tech-tag">Laravel</span>
                <span class="tech-tag">MySQL</span>
                <span class="tech-tag">Vue.js</span>
              </div>
              
              <!-- Professional CTA -->
              <a href="Insurancecase.php" class="group/btn relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 hover:from-blue-500 hover:to-indigo-500 text-blue-400 hover:text-white px-6 py-3 rounded-2xl border border-blue-500/30 hover:border-transparent font-semibold transition-all duration-300 overflow-hidden">
                <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span class="relative z-10">Case Study</span>
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></div>
              </a>
            </div>
          </div>
        </div>
        </div>
      </div>
      
      <!-- Mobile scroll indicators -->
      <div class="flex md:hidden justify-center mt-6 gap-2">
        <div class="w-2 h-2 bg-primary rounded-full"></div>
        <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
        <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
        <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
      </div>
    </div>
  </section>

  <style>
    /* Modern Scrollbar Styles */
    #portfolio-container {
      scrollbar-width: thin;
      scrollbar-color: #E11D48 #1F2937;
    }
    
    #portfolio-container::-webkit-scrollbar {
      height: 8px;
    }
    
    #portfolio-container::-webkit-scrollbar-track {
      background: linear-gradient(90deg, #1F2937, #374151);
      border-radius: 10px;
      margin: 0 20px;
    }
    
    #portfolio-container::-webkit-scrollbar-thumb {
      background: linear-gradient(90deg, #E11D48, #F472B6);
      border-radius: 10px;
      border: 1px solid #374151;
    }
    
    #portfolio-container::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(90deg, #DC2626, #E11D48);
      box-shadow: 0 0 10px rgba(225, 29, 72, 0.5);
    }
    
    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }
    
    .portfolio-card {
      min-width: 380px;
      max-width: 380px;
      flex-shrink: 0;
    }
    
    .tech-tag {
      @apply text-xs bg-gray-800/60 text-gray-300 px-3 py-1.5 rounded-xl border border-gray-700/50 backdrop-blur-sm hover:border-primary/40 hover:text-primary transition-all duration-300 cursor-default;
    }
    
    .tech-tag:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(225, 29, 72, 0.2);
    }
    
    @media (max-width: 768px) {
      .portfolio-card {
        min-width: 300px;
        max-width: 300px;
      }
    }
    
    @media (max-width: 480px) {
      .portfolio-card {
        min-width: 280px;
        max-width: 280px;
      }
    }
  </style>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const container = document.getElementById('portfolio-container');
      const scrollLeftBtn = document.getElementById('scroll-left');
      const scrollRightBtn = document.getElementById('scroll-right');
      
      if (scrollLeftBtn && scrollRightBtn && container) {
        scrollLeftBtn.addEventListener('click', () => {
          container.scrollBy({ left: -420, behavior: 'smooth' });
        });
        
        scrollRightBtn.addEventListener('click', () => {
          container.scrollBy({ left: 420, behavior: 'smooth' });
        });
        
        // Auto-hide scrollbar on mobile
        if (window.innerWidth < 768) {
          container.style.scrollbarWidth = 'none';
          container.style.msOverflowStyle = 'none';
        }
      }
    });
  </script>

 

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