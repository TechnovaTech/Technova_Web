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
  <title>Our Technologies - Technova Technologies</title>
  <meta name="description" content="Explore our comprehensive technology stack and expertise in web development, mobile apps, cloud solutions, and more.">
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
</head>

<body>

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
      <a href="technology.php" class="text-base font-medium text-primary transition-colors duration-300 nav-link">
        Technologies
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
    <a href="technology.php" class="text-base font-medium text-primary transition-colors duration-300 nav-link">Technologies</a>
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
  <section class="pt-32 pb-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-black"></div>
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
      <div class="text-center max-w-4xl mx-auto">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 text-white">
          Our <span class="text-primary">Technologies</span>
        </h1>
        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
          Discover the cutting-edge technologies we use to build exceptional digital solutions
        </p>
      </div>
    </div>
  </section>

  <!-- Technologies Grid -->
  <section class="py-16 bg-black">
    <div class="container mx-auto px-4 sm:px-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <!-- Web Development -->
        <div class="group bg-gray-900/50 rounded-xl p-8 border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mb-6 group-hover:bg-primary/30 transition-colors duration-300">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">Web Development</h3>
          <p class="text-gray-400 mb-6">Full-stack web applications with modern frameworks and robust backend systems.</p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">.NET</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Laravel</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Node.js</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">React</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">PHP</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Python</span>
          </div>
          <a href="web-development.php" class="text-primary hover:text-white transition-colors duration-300 font-semibold">Learn More →</a>
        </div>

        <!-- Mobile Development -->
        <div class="group bg-gray-900/50 rounded-xl p-8 border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mb-6 group-hover:bg-primary/30 transition-colors duration-300">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">Mobile Development</h3>
          <p class="text-gray-400 mb-6">Native and cross-platform mobile apps for iOS and Android platforms.</p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Flutter</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">React Native</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Android</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">iOS</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Kotlin</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Swift</span>
          </div>
          <a href="mobile-development.php" class="text-primary hover:text-white transition-colors duration-300 font-semibold">Learn More →</a>
        </div>

        <!-- E-Commerce -->
        <div class="group bg-gray-900/50 rounded-xl p-8 border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mb-6 group-hover:bg-primary/30 transition-colors duration-300">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">E-Commerce</h3>
          <p class="text-gray-400 mb-6">Powerful online stores with secure payments and inventory management.</p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Shopify</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">WooCommerce</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Magento</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">BigCommerce</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">PrestaShop</span>
          </div>
          <a href="ecommerce-solutions.php" class="text-primary hover:text-white transition-colors duration-300 font-semibold">Learn More →</a>
        </div>

        <!-- UI/UX Design -->
        <div class="group bg-gray-900/50 rounded-xl p-8 border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mb-6 group-hover:bg-primary/30 transition-colors duration-300">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">UI/UX Design</h3>
          <p class="text-gray-400 mb-6">Beautiful interfaces and exceptional user experiences that convert.</p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Figma</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Adobe XD</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Sketch</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Photoshop</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Illustrator</span>
          </div>
          <a href="ui-ux-design.php" class="text-primary hover:text-white transition-colors duration-300 font-semibold">Learn More →</a>
        </div>

        <!-- Cloud Solutions -->
        <div class="group bg-gray-900/50 rounded-xl p-8 border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mb-6 group-hover:bg-primary/30 transition-colors duration-300">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">Cloud Solutions</h3>
          <p class="text-gray-400 mb-6">Scalable cloud infrastructure and DevOps solutions for modern applications.</p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">AWS</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Azure</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Google Cloud</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Docker</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Kubernetes</span>
          </div>
          <a href="#" class="text-primary hover:text-white transition-colors duration-300 font-semibold">Learn More →</a>
        </div>

        <!-- AI & ML -->
        <div class="group bg-gray-900/50 rounded-xl p-8 border border-gray-800 hover:border-primary/50 transition-all duration-300 hover:transform hover:scale-105">
          <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mb-6 group-hover:bg-primary/30 transition-colors duration-300">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">AI & Machine Learning</h3>
          <p class="text-gray-400 mb-6">Intelligent systems with AI capabilities for data analysis and automation.</p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">TensorFlow</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">PyTorch</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">OpenAI</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">Scikit-learn</span>
            <span class="px-3 py-1 bg-gray-800 text-primary text-sm rounded-full">NLP</span>
          </div>
          <a href="#" class="text-primary hover:text-white transition-colors duration-300 font-semibold">Learn More →</a>
        </div>

      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-16 bg-gradient-to-r from-primary/10 to-pink-500/10">
    <div class="container mx-auto px-4 sm:px-6 text-center">
      <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
        Ready to Build Something Amazing?
      </h2>
      <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
        Let's discuss how our technologies can transform your business ideas into reality
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="contact.php" class="bg-primary hover:bg-primary/80 px-8 py-4 rounded-full text-white font-semibold transition-all duration-300 hover:transform hover:scale-105">
          Start Your Project
        </a>
        <a href="portfolio.php" class="border-2 border-primary hover:bg-primary px-8 py-4 rounded-full text-primary hover:text-white font-semibold transition-all duration-300 hover:transform hover:scale-105">
          View Our Work
        </a>
      </div>
    </div>
  </section>

<!-- Footer -->
 <footer class="bg-black text-grey py-12 sm:py-16 border-t border-gray-800">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-12">
            <div class="mb-6">
                <h3 class="text-lg font-bold mb-4 text-grey-600">Contact Us</h3>
                <p class="text-gray-200 mb-2"><strong>Email:</strong> <a href="mailto:info@technovatechnologies.com" class="text-gray-200 hover:text-red-600">info@technovatechnologies.com</a></p>
                <p class="text-gray-200 mb-2"><strong>Phone:</strong> <a href="tel:+91 94273 00816" class="text-gray-200 hover:text-red-600">+91 94273 00816</a></p>
                <p class="text-gray-200 mb-2"><strong>Address:</strong> 608 - Time Square Commercial Complex</p>
                <p class="text-gray-200"> Near Ayodhya Chowk, 150 Feet Ring Rd, Rajkot, Gujarat 360007</p>
            </div>
            <div class="mb-6">
                <h3 class="text-lg font-bold mb-4 text-gery-600">Services</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">Web Development</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">App Development</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">Web Design</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">ERP Development</a></li>
                    <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">SEO Development</a></li>
                </ul>
            </div>
            <div class="mb-6">
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
        <div class="container mx-auto text-center">
        
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