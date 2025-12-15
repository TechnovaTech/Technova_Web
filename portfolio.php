

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


 
  <!-- Portfolio Section -->
<section id="portfolio" class="pt-24 sm:pt-28 py-16 sm:py-22 relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6">
      <div class="mb-12 sm:mb-16 reveal">
        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6">OUR PORTFOLIO</h2>
        <p class="text-gray-400 max-w-2xl text-lg sm:text-xl">Explore our diverse portfolio of successful projects across various industries.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="portfolio-item reveal" style="transition-delay: 100ms;">
          <div class="bg-gradient-to-br from-gray-50 to-gray-200 p-6 rounded-lg flex justify-center items-center aspect-[4/3]">
            <!-- MacBook Style Laptop -->
            <div class="relative">
              <!-- Laptop Screen -->
              <div class="bg-black rounded-t-lg" style="width: 400px; height: 250px; padding: 10px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <!-- Screen Bezel -->
                <div class="bg-gray-800 rounded-lg p-1" style="width: 380px; height: 230px;">
                  <!-- Webcam -->
                  <div class="flex justify-center mb-1">
                    <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                  </div>
                  <!-- Actual Screen -->
                  <div class="bg-white rounded overflow-hidden" style="width: 370px; height: 220px;">
                    <img src="image17.png" alt="Once Pay" class="w-full h-full object-cover" />
                  </div>
                </div>
              </div>
              
              <!-- Laptop Base (Black Style) -->
              <div class="bg-black rounded-b-lg" style="width: 400px; height: 20px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
                <!-- Trackpad Area -->
                <div class="flex justify-center pt-1">
                  <div class="bg-gray-600 rounded-sm opacity-70" style="width: 70px; height: 6px;"></div>
                </div>
              </div>
              
              <!-- Drop Shadow -->
              <div class="absolute -bottom-6 left-2 right-2 h-6 bg-black opacity-15 rounded-full" style="filter: blur(8px);"></div>
            </div>
          </div>
          <div class="portfolio-overlay">
            <div class="portfolio-content text-center p-4">
              <h3 class="text-xl font-bold text-white mb-2">Once Pay</h3>
              <p class="text-white/80 mb-4">Payments Made Simple with WhatsApp</p>
              <a href="oncepay_detail.php" class="btn">
                View Project
              </a>
            </div>
          </div>
        </div>

        <div class="portfolio-item reveal" style="transition-delay: 200ms;">
          <div class="bg-gradient-to-br from-gray-50 to-gray-200 p-6 rounded-lg flex justify-center items-center aspect-[4/3]">
            <!-- MacBook Style Laptop -->
            <div class="relative">
              <!-- Laptop Screen -->
              <div class="bg-black rounded-t-lg" style="width: 400px; height: 250px; padding: 10px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <!-- Screen Bezel -->
                <div class="bg-gray-800 rounded-lg p-1" style="width: 380px; height: 230px;">
                  <!-- Webcam -->
                  <div class="flex justify-center mb-1">
                    <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                  </div>
                  <!-- Actual Screen -->
                  <div class="bg-white rounded overflow-hidden" style="width: 370px; height: 220px;">
                    <img src="uploads/images/r1.PNG" alt="ERP System" class="w-full h-full object-cover" />
                  </div>
                </div>
              </div>
              
              <!-- Laptop Base (Black Style) -->
              <div class="bg-black rounded-b-lg" style="width: 400px; height: 20px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
                <!-- Trackpad Area -->
                <div class="flex justify-center pt-1">
                  <div class="bg-gray-600 rounded-sm opacity-70" style="width: 70px; height: 6px;"></div>
                </div>
              </div>
              
              <!-- Drop Shadow -->
              <div class="absolute -bottom-6 left-2 right-2 h-6 bg-black opacity-15 rounded-full" style="filter: blur(8px);"></div>
            </div>
          </div>
          <div class="portfolio-overlay">
            <div class="portfolio-content text-center p-4">
              <h3 class="text-xl font-bold text-white mb-2">Retailians ERP System</h3>
              <p class="text-white/80 mb-4">Enterprise Resource Planning Solution</p>
              <a href="erp_detail.php" class="btn">
                View Project
              </a>
            </div>
          </div>
        </div>

        <div class="portfolio-item reveal" style="transition-delay: 300ms;">
          <div class="bg-gradient-to-br from-gray-50 to-gray-200 p-6 rounded-lg flex justify-center items-center aspect-[4/3]">
            <!-- MacBook Style Laptop -->
            <div class="relative">
              <!-- Laptop Screen -->
              <div class="bg-black rounded-t-lg" style="width: 400px; height: 250px; padding: 10px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <!-- Screen Bezel -->
                <div class="bg-gray-800 rounded-lg p-1" style="width: 380px; height: 230px;">
                  <!-- Webcam -->
                  <div class="flex justify-center mb-1">
                    <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                  </div>
                  <!-- Actual Screen -->
                  <div class="bg-white rounded overflow-hidden" style="width: 370px; height: 220px;">
                    <img src="uploads/images/r2.PNG" alt="Commonwoods" class="w-full h-full object-cover" />
                  </div>
                </div>
              </div>
              
              <!-- Laptop Base (Black Style) -->
              <div class="bg-black rounded-b-lg" style="width: 400px; height: 20px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
                <!-- Trackpad Area -->
                <div class="flex justify-center pt-1">
                  <div class="bg-gray-600 rounded-sm opacity-70" style="width: 70px; height: 6px;"></div>
                </div>
              </div>
              
              <!-- Drop Shadow -->
              <div class="absolute -bottom-6 left-2 right-2 h-6 bg-black opacity-15 rounded-full" style="filter: blur(8px);"></div>
            </div>
          </div>
          <div class="portfolio-overlay">
            <div class="portfolio-content text-center p-4">
              <h3 class="text-xl font-bold text-white mb-2">9-Eleven Wrap ERP</h3>
              <p class="text-white/80 mb-4">Enterprise Resource Planning Solution</p>
              <a href="nineelevenerp_detail.php" class="btn">
                View Project
              </a>
            </div>
          </div>
        </div>

        <div class="portfolio-item reveal" style="transition-delay: 400ms;">
          <div class="bg-gradient-to-br from-gray-50 to-gray-200 p-6 rounded-lg flex justify-center items-center aspect-[4/3]">
            <!-- Realistic iPhone Frame -->
            <div class="relative">
              <div class="bg-gray-900 rounded-[2rem] p-1" style="width: 160px; height: 320px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                <div class="bg-white rounded-[1.7rem] overflow-hidden relative" style="width: 148px; height: 308px;">
                  <!-- Dynamic Island -->
                  <div class="absolute top-2 left-1/2 transform -translate-x-1/2 bg-black rounded-full" style="width: 50px; height: 16px; z-index: 10;"></div>
                  <!-- Screen Content -->
                  <div class="h-full bg-cover bg-center" style="background-image: url('uploads/images/y0.png');">
                  </div>
                  <!-- Home Indicator -->
                  <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-black rounded-full" style="width: 35px; height: 3px;"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="portfolio-overlay">
            <div class="portfolio-content text-center p-4">
              <h3 class="text-xl font-bold text-white mb-2">Yaari Dating App</h3>
              <p class="text-white/80 mb-4">Connect hearts, create memories - Your love story starts here</p>
              <a href="yaari_detail.php" class="btn">
                View Project
              </a>
            </div>
          </div>
        </div>
        
        <div class="portfolio-item reveal" style="transition-delay: 500ms;">
          <div class="bg-gradient-to-br from-gray-50 to-gray-200 p-6 rounded-lg flex justify-center items-center aspect-[4/3]">
            <!-- Realistic iPhone Frame -->
            <div class="relative">
              <div class="bg-gray-900 rounded-[2rem] p-1" style="width: 160px; height: 320px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                <div class="bg-white rounded-[1.7rem] overflow-hidden relative" style="width: 148px; height: 308px;">
                  <!-- Dynamic Island -->
                  <div class="absolute top-2 left-1/2 transform -translate-x-1/2 bg-black rounded-full" style="width: 50px; height: 16px; z-index: 10;"></div>
                  <!-- Screen Content -->
                  <div class="h-full bg-cover bg-center" style="background-image: url('uploads/images/n1.png');">
                  </div>
                  <!-- Home Indicator -->
                  <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-black rounded-full" style="width: 35px; height: 3px;"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="portfolio-overlay">
            <div class="portfolio-content text-center p-4">
              <h3 class="text-xl font-bold text-white mb-2">Asiaze News App</h3>
              <p class="text-white/80 mb-4">Stay informed with latest news and updates</p>
              <a href="asiaze_detail.php" class="btn">
                View Project
              </a>
            </div>
          </div>
        </div>

        <div class="portfolio-item reveal" style="transition-delay: 600ms;">
          <div class="bg-gradient-to-br from-gray-50 to-gray-200 p-6 rounded-lg flex justify-center items-center aspect-[4/3]">
            <!-- MacBook Style Laptop -->
            <div class="relative">
              <!-- Laptop Screen -->
              <div class="bg-black rounded-t-lg" style="width: 400px; height: 250px; padding: 10px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <!-- Screen Bezel -->
                <div class="bg-gray-800 rounded-lg p-1" style="width: 380px; height: 230px;">
                  <!-- Webcam -->
                  <div class="flex justify-center mb-1">
                    <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                  </div>
                  <!-- Actual Screen -->
                  <div class="bg-white rounded overflow-hidden" style="width: 370px; height: 220px;">
                    <img src="uploads/images/w6.PNG" alt="WalkIn FirstPregnancy" class="w-full h-full object-cover" />
                  </div>
                </div>
              </div>
              
              <!-- Laptop Base (Black Style) -->
              <div class="bg-black rounded-b-lg" style="width: 400px; height: 20px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
                <!-- Trackpad Area -->
                <div class="flex justify-center pt-1">
                  <div class="bg-gray-600 rounded-sm opacity-70" style="width: 70px; height: 6px;"></div>
                </div>
              </div>
              
              <!-- Drop Shadow -->
              <div class="absolute -bottom-6 left-2 right-2 h-6 bg-black opacity-15 rounded-full" style="filter: blur(8px);"></div>
            </div>
          </div>
          <div class="portfolio-overlay">
            <div class="portfolio-content text-center p-4">
              <h3 class="text-xl font-bold text-white mb-2">WalkIn FirstPregnancy</h3>
              <p class="text-white/80 mb-4">Comprehensive pregnancy care and guidance platform</p>
              <a href="walkin_firstpregnancy_detail.php" class="btn">
                View Project
              </a>
            </div>
          </div>
        </div>

        <div class="portfolio-item reveal" style="transition-delay: 700ms;">
          <div class="bg-gradient-to-br from-gray-50 to-gray-200 p-6 rounded-lg flex justify-center items-center aspect-[4/3]">
            <!-- MacBook Style Laptop -->
            <div class="relative">
              <!-- Laptop Screen -->
              <div class="bg-black rounded-t-lg" style="width: 400px; height: 250px; padding: 10px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <!-- Screen Bezel -->
                <div class="bg-gray-800 rounded-lg p-1" style="width: 380px; height: 230px;">
                  <!-- Webcam -->
                  <div class="flex justify-center mb-1">
                    <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                  </div>
                  <!-- Actual Screen -->
                  <div class="bg-white rounded overflow-hidden" style="width: 370px; height: 220px;">
                    <img src="uploads/images/f1.png" alt="First Trimester Care" class="w-full h-full object-cover" />
                  </div>
                </div>
              </div>
              
              <!-- Laptop Base (Black Style) -->
              <div class="bg-black rounded-b-lg" style="width: 400px; height: 20px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
                <!-- Trackpad Area -->
                <div class="flex justify-center pt-1">
                  <div class="bg-gray-600 rounded-sm opacity-70" style="width: 70px; height: 6px;"></div>
                </div>
              </div>
              
              <!-- Drop Shadow -->
              <div class="absolute -bottom-6 left-2 right-2 h-6 bg-black opacity-15 rounded-full" style="filter: blur(8px);"></div>
            </div>
          </div>
          <div class="portfolio-overlay">
            <div class="portfolio-content text-center p-4">
              <h3 class="text-xl font-bold text-white mb-2">Your First Trimester Prenatal Care</h3>
              <p class="text-white/80 mb-4">Essential care for your pregnancy journey</p>
              <a href="trimester_detail.php" class="btn">
                View Project
              </a>
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
</body>

</html>