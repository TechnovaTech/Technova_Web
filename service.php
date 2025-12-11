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
  <section class="pt-24 sm:pt-28 pb-20 sm:pb-24 relative overflow-hidden min-h-[80vh] flex items-center">
    <!-- Animated Background -->
    <div class="absolute inset-0">
      <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-black"></div>
      <div class="absolute inset-0" style="background: radial-gradient(circle at 30% 20%, rgba(225, 29, 72, 0.15), transparent 50%), radial-gradient(circle at 70% 80%, rgba(225, 29, 72, 0.1), transparent 50%);"></div>
      <div class="absolute top-20 left-10 w-72 h-72 bg-primary/5 rounded-full blur-3xl animate-pulse-slow"></div>
      <div class="absolute bottom-20 right-10 w-96 h-96 bg-primary/3 rounded-full blur-3xl animate-bounce-slow"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-primary rounded-full animate-ping" style="animation-delay: 0s;"></div>
      <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-white rounded-full animate-ping" style="animation-delay: 1s;"></div>
      <div class="absolute bottom-1/4 left-1/3 w-1.5 h-1.5 bg-primary/70 rounded-full animate-ping" style="animation-delay: 2s;"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 relative z-10">
      <div class="text-center max-w-5xl mx-auto">
        <!-- Main Title -->
        <div class="mb-8">
          <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold mb-4 text-white leading-tight">
            Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-pink-500 animate-pulse-slow">Services</span>
          </h1>
          <div class="w-24 h-1 bg-gradient-to-r from-primary to-pink-500 mx-auto rounded-full"></div>
        </div>
        
        <!-- Subtitle -->
        <p class="text-xl sm:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed font-light">
          Empowering businesses with <span class="text-primary font-semibold">cutting-edge technology</span> solutions and innovative digital experiences that drive growth
        </p>
        

        
        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
          <a href="#technologies" class="group bg-gradient-to-r from-primary to-pink-600 hover:from-pink-600 hover:to-primary px-8 py-4 rounded-full text-white font-semibold transition-all duration-300 hover:transform hover:scale-105 hover:shadow-lg hover:shadow-primary/30 flex items-center gap-2">
            Explore Technologies
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
          </a>
          <a href="contact.php" class="group border-2 border-primary hover:bg-primary px-8 py-4 rounded-full text-primary hover:text-white font-semibold transition-all duration-300 hover:transform hover:scale-105 flex items-center gap-2">
            Get Started
            <svg class="w-5 h-5 group-hover:rotate-45 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Overview Section -->
  <section class="py-16 sm:py-20 bg-black">
    <div class="container mx-auto px-4 sm:px-6">
      <div class="mb-12 text-center">
        <h2 class="text-4xl sm:text-5xl font-bold mb-6 text-white">
          Our <span class="text-primary">Services</span>
        </h2>
        <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
          Explore our comprehensive technology stack and discover how we can transform your business
        </p>
      </div>

      <!-- Services Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border border-white mb-12">
        <!-- Websites -->
        <div class="p-8 border-r border-b border-white bg-gray-900/30">
          <h3 class="text-xl font-bold mb-4 text-primary">Websites</h3>
          <ul class="space-y-2 text-gray-300">
            <li>• 500+ Websites Delivered</li>
            <li>• Attractive and Responsive Design</li>
            <li>• 7+ Years of Experienced Developers</li>
          </ul>
        </div>

        <!-- Mobile -->
        <div class="p-8 border-r border-b border-white bg-gray-900/30">
          <h3 class="text-xl font-bold mb-4 text-primary">Mobile</h3>
          <ul class="space-y-2 text-gray-300">
            <li>• 70+ Apps Developed</li>
            <li>• 7+ Years of Experienced Developers</li>
            <li>• 2 In-house Products (100k+ Downloads)</li>
          </ul>
        </div>

        <!-- SaaS -->
        <div class="p-8 border-b border-white bg-gray-900/30">
          <h3 class="text-xl font-bold mb-4 text-primary">SaaS</h3>
          <ul class="space-y-2 text-gray-300">
            <li>• 5 VC Funded Products Developed</li>
            <li>• Created 20+ SaaS Products</li>
            <li>• 4 In-house SaaS Products</li>
          </ul>
        </div>

        <!-- E-commerce -->
        <div class="p-8 border-r border-white bg-gray-900/30">
          <h3 class="text-xl font-bold mb-4 text-primary">E-commerce</h3>
          <ul class="space-y-2 text-gray-300">
            <li>• 100+ Stores Developed</li>
            <li>• Worked with $5 Mn+ Stores</li>
            <li>• 1 In-house Product</li>
          </ul>
        </div>

        <!-- UI/UX -->
        <div class="p-8 border-r border-white bg-gray-900/30">
          <h3 class="text-xl font-bold mb-4 text-primary">UI/UX</h3>
          <ul class="space-y-2 text-gray-300">
            <li>• Intuitive & Purpose-centric Designs</li>
            <li>• 80+ Thoughts Transformed into Reality</li>
            <li>• 15+ Ideators, Creators, and Designers</li>
          </ul>
        </div>

        <!-- Branding -->
        <div class="p-8 bg-gray-900/30">
          <h3 class="text-xl font-bold mb-4 text-primary">Branding</h3>
          <ul class="space-y-2 text-gray-300">
            <li>• Built Brands That Dance with Design</li>
            <li>• Crafted 100+ Identities</li>
            <li>• 5+ Brand Experts</li>
          </ul>
        </div>
      </div>

      <!-- See Projects Button -->
      <div class="text-left">
        <a href="portfolio.php" class="group inline-flex items-center gap-3 bg-gradient-to-r from-primary to-pink-600 hover:from-pink-600 hover:to-primary text-white px-8 py-4 rounded-lg font-bold text-sm tracking-wider transition-all duration-300 hover:transform hover:scale-105 hover:shadow-lg hover:shadow-primary/30">
          SEE PROJECTS
          <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- Technology Services Section -->
  <!-- <section id="technologies" class="py-16 sm:py-20 bg-black">
    <div class="container mx-auto px-4 sm:px-6">
      <div class="mb-12 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-white">
          Our <span class="text-primary">Technologies</span>
        </h2>
        <p class="text-gray-400 max-w-2xl mx-auto">Explore our comprehensive technology stack and discover how we can transform your business</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
          <div class="bg-gray-900/50 rounded-lg p-6 sticky top-24">
            <h3 class="text-xl font-bold mb-6 text-white">Technology Stack</h3>
            <div class="space-y-2">
              <button onclick="showTechInfo('web')" class="tech-menu-item w-full text-left px-4 py-3 rounded-lg transition-all duration-300 hover:bg-primary/20 hover:text-primary" data-tech="web">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                  </svg>
                  Web Development
                </div>
              </button>
              <button onclick="showTechInfo('mobile')" class="tech-menu-item w-full text-left px-4 py-3 rounded-lg transition-all duration-300 hover:bg-primary/20 hover:text-primary" data-tech="mobile">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                  </svg>
                  Mobile Development
                </div>
              </button>
              <button onclick="showTechInfo('ecommerce')" class="tech-menu-item w-full text-left px-4 py-3 rounded-lg transition-all duration-300 hover:bg-primary/20 hover:text-primary" data-tech="ecommerce">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                  </svg>
                  E-Commerce Solutions
                </div>
              </button>
              <button onclick="showTechInfo('design')" class="tech-menu-item w-full text-left px-4 py-3 rounded-lg transition-all duration-300 hover:bg-primary/20 hover:text-primary" data-tech="design">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                  UI/UX Design
                </div>
              </button>
              <button onclick="showTechInfo('cloud')" class="tech-menu-item w-full text-left px-4 py-3 rounded-lg transition-all duration-300 hover:bg-primary/20 hover:text-primary" data-tech="cloud">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                  </svg>
                  Cloud Solutions
                </div>
              </button>
              <button onclick="showTechInfo('ai')" class="tech-menu-item w-full text-left px-4 py-3 rounded-lg transition-all duration-300 hover:bg-primary/20 hover:text-primary" data-tech="ai">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                  </svg>
                  AI & Machine Learning
                </div>
              </button>
            </div>
          </div>
        </div>


        <div class="lg:col-span-2">
          <div id="tech-details" class="bg-gray-900/30 rounded-lg p-8 min-h-[500px]">
            <div id="web-details" class="tech-details active">
              <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">Web Development</h3>
              </div>
              <p class="text-gray-300 mb-6 leading-relaxed">
                We create powerful, scalable web applications using cutting-edge technologies. Our full-stack development expertise ensures robust backend systems and intuitive frontend experiences. From enterprise-level applications to dynamic websites, we deliver solutions that drive business growth and enhance user engagement.
              </p>
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Key Features:</h4>
                <ul class="text-gray-300 space-y-2">
                  <li>• Custom web application development</li>
                  <li>• API development and integration</li>
                  <li>• Database design and optimization</li>
                  <li>• Performance optimization and security</li>
                  <li>• Responsive design implementation</li>
                </ul>
              </div>
              <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">.NET</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Laravel</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Node.js</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">PHP</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Python</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">React</span>
                </div>
              </div>
              <a href="web-development.php" class="btn-primary px-6 py-3 rounded-lg hover:bg-primary/80 transition-colors duration-300 inline-block text-white no-underline">
                Read More
              </a>
            </div>

            <div id="mobile-details" class="tech-details hidden">
              <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">Mobile Development</h3>
              </div>
              <p class="text-gray-300 mb-6 leading-relaxed">
                Build native and cross-platform mobile applications that deliver exceptional user experiences. We develop for both iOS and Android platforms using the latest frameworks and technologies. Our mobile solutions are optimized for performance, security, and user engagement across all devices.
              </p>
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Our Expertise:</h4>
                <ul class="text-gray-300 space-y-2">
                  <li>• Native iOS and Android development</li>
                  <li>• Cross-platform app development</li>
                  <li>• App Store optimization and deployment</li>
                  <li>• Push notifications and real-time features</li>
                  <li>• Mobile app testing and maintenance</li>
                </ul>
              </div>
              <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Flutter</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">React Native</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Android</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">iOS</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Kotlin</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Swift</span>
                </div>
              </div>
              <a href="mobile-development.php" class="btn-primary px-6 py-3 rounded-lg hover:bg-primary/80 transition-colors duration-300 inline-block text-white no-underline">
                Read More
              </a>
            </div>

            <div id="ecommerce-details" class="tech-details hidden">
              <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">E-Commerce Solutions</h3>
              </div>
              <p class="text-gray-300 mb-6 leading-relaxed">
                Create powerful online stores and marketplaces with secure payment gateways, inventory management, and seamless user experiences. We build scalable e-commerce platforms that drive sales and maximize conversions. Our solutions include everything from simple online stores to complex multi-vendor marketplaces.
              </p>
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">E-Commerce Solutions:</h4>
                <ul class="text-gray-300 space-y-2">
                  <li>• Custom e-commerce development</li>
                  <li>• Payment gateway integration</li>
                  <li>• Inventory and order management</li>
                  <li>• Multi-vendor marketplace development</li>
                  <li>• SEO optimization and analytics</li>
                </ul>
              </div>
              <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Shopify</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">WooCommerce</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Magento</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">BigCommerce</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">PrestaShop</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Custom</span>
                </div>
              </div>
              <a href="ecommerce-solutions.php" class="btn-primary px-6 py-3 rounded-lg hover:bg-primary/80 transition-colors duration-300 inline-block text-white no-underline">
                Read More
              </a>
            </div>

            <div id="design-details" class="tech-details hidden">
              <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">UI/UX Design</h3>
              </div>
              <p class="text-gray-300 mb-6 leading-relaxed">
                Design beautiful, intuitive interfaces that provide exceptional user experiences. Our design process focuses on user research, wireframing, prototyping, and creating visually stunning designs. We create designs that not only look great but also convert visitors into customers and enhance brand identity.
              </p>
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Design Services:</h4>
                <ul class="text-gray-300 space-y-2">
                  <li>• User experience (UX) research and strategy</li>
                  <li>• User interface (UI) design and prototyping</li>
                  <li>• Brand identity and logo design</li>
                  <li>• Responsive web design</li>
                  <li>• Design system development</li>
                </ul>
              </div>
              <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Figma</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Adobe XD</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Sketch</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Photoshop</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Illustrator</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Prototyping</span>
                </div>
              </div>
              <a href="ui-ux-design.php" class="btn-primary px-6 py-3 rounded-lg hover:bg-primary/80 transition-colors duration-300 inline-block text-white no-underline">
                Read More
              </a>
            </div>

            <div id="cloud-details" class="tech-details hidden">
              <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">Cloud Solutions</h3>
              </div>
              <p class="text-gray-300 mb-6 leading-relaxed">
                Deploy and scale your applications with cloud infrastructure. We provide cloud migration, DevOps, and infrastructure management services using leading cloud platforms. Our cloud solutions ensure high availability, scalability, and cost-effectiveness for your business operations.
              </p>
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Cloud Services:</h4>
                <ul class="text-gray-300 space-y-2">
                  <li>• Cloud migration and deployment</li>
                  <li>• Infrastructure as Code (IaC)</li>
                  <li>• Continuous integration and deployment</li>
                  <li>• Cloud security and monitoring</li>
                  <li>• Auto-scaling and load balancing</li>
                </ul>
              </div>
              <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">AWS</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Azure</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Google Cloud</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Docker</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Kubernetes</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">DevOps</span>
                </div>
              </div>
              <a href="#" class="btn-primary px-6 py-3 rounded-lg hover:bg-primary/80 transition-colors duration-300 inline-block text-white no-underline">
                Read More
              </a>
            </div>

            <div id="ai-details" class="tech-details hidden">
              <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                  <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">AI & Machine Learning</h3>
              </div>
              <p class="text-gray-300 mb-6 leading-relaxed">
                Integrate artificial intelligence and machine learning capabilities into your applications. We develop intelligent systems that can analyze data, make predictions, and automate processes. Our AI solutions help businesses make data-driven decisions and automate complex workflows for improved efficiency.
              </p>
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">AI Capabilities:</h4>
                <ul class="text-gray-300 space-y-2">
                  <li>• Machine learning model development</li>
                  <li>• Natural language processing (NLP)</li>
                  <li>• Computer vision and image recognition</li>
                  <li>• Predictive analytics and forecasting</li>
                  <li>• Chatbots and virtual assistants</li>
                </ul>
              </div>
              <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">TensorFlow</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">PyTorch</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">OpenAI</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Scikit-learn</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">NLP</span>
                </div>
                <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                  <span class="text-primary font-semibold">Computer Vision</span>
                </div>
              </div>
              <a href="#" class="btn-primary px-6 py-3 rounded-lg hover:bg-primary/80 transition-colors duration-300 inline-block text-white no-underline">
                Read More
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->

  

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
  
  <script>
    // Technology menu functionality
    function showTechInfo(tech) {
      // Hide all tech details
      const allDetails = document.querySelectorAll('.tech-details');
      allDetails.forEach(detail => {
        detail.classList.add('hidden');
        detail.classList.remove('active');
      });
      
      // Remove active class from all menu items
      const allMenuItems = document.querySelectorAll('.tech-menu-item');
      allMenuItems.forEach(item => {
        item.classList.remove('bg-primary/20', 'text-primary');
        item.classList.add('text-gray-300');
      });
      
      // Show selected tech details
      const selectedDetail = document.getElementById(tech + '-details');
      if (selectedDetail) {
        selectedDetail.classList.remove('hidden');
        selectedDetail.classList.add('active');
      }
      
      // Add active class to selected menu item
      const selectedMenuItem = document.querySelector(`[data-tech="${tech}"]`);
      if (selectedMenuItem) {
        selectedMenuItem.classList.add('bg-primary/20', 'text-primary');
        selectedMenuItem.classList.remove('text-gray-300');
      }
    }
    
    // Initialize with web development selected
    document.addEventListener('DOMContentLoaded', function() {
      showTechInfo('web');
    });
  </script>
  
  <style>
    .btn-primary {
      background: linear-gradient(135deg, #E11D48, #BE185D);
      color: white;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(225, 29, 72, 0.3);
    }
    
    .tech-details {
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.3s ease;
    }
    
    .tech-details.active {
      opacity: 1;
      transform: translateY(0);
    }
    
    .tech-menu-item {
      color: #D1D5DB;
    }
    
    .tech-menu-item:hover {
      transform: translateX(5px);
    }
  </style>
</body>

</html>