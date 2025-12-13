

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
      <a href="portfolio.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">
        Portfolio
      </a>
      <a href="about.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">
        About
      </a>
      <a href="carrer.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">
        Carerrs
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
    <a href="about.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">About</a>
    <a href="carrer.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Carrers</a>
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
          <img src="image17.png" alt="Addurance" class="w-full h-full object-fill aspect-[4/3]">
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
          <img src="uploads/images/r1.PNG" alt="ERP System" class="w-full h-full object-fill aspect-[4/3]">
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
          <img src="uploads/images/r2.PNG" alt="Commonwoods" class="w-full h-full object-fill aspect-[4/3]">
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
          <div class="bg-orange-200 p-8 rounded-lg flex justify-center items-center aspect-[4/3]">
            <!-- Mobile Frame -->
            <div class="bg-black rounded-3xl p-2 shadow-2xl">
              <div class="bg-white rounded-2xl overflow-hidden w-48 h-80">
                <!-- Mobile Screen -->
                <div class="h-full bg-cover bg-center" style="background-image: url('uploads/images/y0.png');">
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
          <div class="bg-blue-200 p-8 rounded-lg flex justify-center items-center aspect-[4/3]">
            <!-- Mobile Frame -->
            <div class="bg-black rounded-3xl p-2 shadow-2xl">
              <div class="bg-white rounded-2xl overflow-hidden w-48 h-80">
                <!-- Mobile Screen -->
                <div class="h-full bg-cover bg-center" style="background-image: url('uploads/images/n1.png');">
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
          <img src="uploads/images/w6.PNG" alt="WalkIn FirstPregnancy" class="w-full h-full object-fill aspect-[4/3]">
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
          <img src="uploads/images/f1.png" alt="First Trimester Care" class="w-full h-full object-fill aspect-[4/3]">
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