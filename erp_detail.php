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
  <title>ERP System - Project Detail</title>
  <meta name="description" content="Detailed view of our ERP System project - Technova Technologies">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script type="text/javascript" src="script.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const images = document.querySelectorAll('.gallery-image');
      const prevBtn = document.getElementById('prev-btn');
      const nextBtn = document.getElementById('next-btn');
      let currentIndex = 1;
      
      function updateGallery() {
        images.forEach((img, index) => {
          img.classList.add('hidden');
          img.classList.remove('scale-100', 'blur-0', 'opacity-100', 'z-10', 'mx-8', 'w-80', 'h-96');
          img.classList.add('scale-75', 'blur-sm', 'opacity-60', 'w-64', 'h-80');
        });
        
        // Show center image (focused)
        if (images[currentIndex]) {
          images[currentIndex].classList.remove('hidden', 'scale-75', 'blur-sm', 'opacity-60', 'w-64', 'h-80');
          images[currentIndex].classList.add('scale-100', 'blur-0', 'opacity-100', 'z-10', 'mx-8', 'w-80', 'h-96');
        }
        
        // Show left image
        const leftIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
        if (images[leftIndex]) {
          images[leftIndex].classList.remove('hidden');
        }
        
        // Show right image
        const rightIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
        if (images[rightIndex]) {
          images[rightIndex].classList.remove('hidden');
        }
      }
      
      prevBtn.addEventListener('click', () => {
        currentIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1;
        updateGallery();
      });
      
      nextBtn.addEventListener('click', () => {
        currentIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
        updateGallery();
      });
      
      updateGallery();
      
      // Auto scroll every 3 seconds
      setInterval(() => {
        currentIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0;
        updateGallery();
      }, 3000);
      
      // Handle window resize
      window.addEventListener('resize', updateGallery);
    });
  </script>
  
  <style>
    body {
      font-family: "Inter", sans-serif;
      background-color: black;
      color: white;
      overflow-x: hidden;
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
    
    .gallery-image {
      filter: blur(2px);
      transition: all 0.5s ease;
    }
    
    .gallery-image.blur-0 {
      filter: blur(0px);
    }
    
    .gallery-image.blur-sm {
      filter: blur(4px);
    }
  </style>
</head>

<body>
  <!-- Header/Navigation -->
<header class="fixed top-0 w-full z-50 transition-all duration-300" style="background-color: rgba(0,0,0,0.9); backdrop-filter: blur(10px);">
  <div class="container mx-auto px-4 flex h-20 items-center justify-between">
    <a href="#" class="flex items-center gap-2 group">
      <img src="logo.svg" alt="Logo" class="h-8 sm:h-10 w-auto transition-transform duration-300 transform group-hover:scale-110" />
    </a>
    
    <!-- Desktop Navigation -->
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

  <!-- Main Content -->
  <main class="pt-20">
    <!-- Project Hero Section -->
    <section style="background-color: black; padding: 80px 0;"> 
      <div class="container mx-auto px-4">
        <div class="row align-items-center justify-content-center">
          <div class="col-12 text-center">
            <!-- Icon -->
            <div class="mb-4">
              <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto">
                <path d="M3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7Z" stroke="#E11D48" stroke-width="2"/>
                <path d="M8 9L16 9" stroke="#E11D48" stroke-width="2" stroke-linecap="round"/>
                <path d="M8 13L12 13" stroke="#E11D48" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </div>
            
            <!-- Heading -->
            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">ERP System</h1>
            
            <!-- Subtitle -->
            <h2 class="text-2xl sm:text-3xl text-red-600 mb-6">Enterprise Resource Planning Solution</h2>
            
            <!-- Divider Line -->
            <div class="w-100 mx-auto mb-4" style="height: 2px; background-color: #E11D48; max-width: 800px;"></div>
            
            <!-- Description -->
            <div class="mx-auto" style="max-width: 800px;">
              <p class="text-center text-lg text-gray-300 leading-relaxed mb-0">
                Comprehensive ERP solution designed to streamline business operations, manage resources efficiently, and provide real-time insights for better decision making.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Project Gallery Section -->
    <section class="py-16" style="background-color: black;">
      <div class="container mx-auto px-4">
        <h2 class="text-center text-white text-4xl font-bold mb-8">Project Gallery</h2>
        <div class="flex flex-col items-center">
          <div class="relative w-full h-80 sm:h-96 md:h-[34rem] mb-6 overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center">
              <div id="gallery-container" class="flex items-center justify-center h-full transition-transform duration-500 ease-in-out" style="transform: translateX(0px); width: max-content;">
                <img src="uploads/images/erp1.png" class="gallery-image w-72 h-80 sm:w-80 sm:h-96 md:w-96 md:h-[30rem] object-contain rounded-lg mx-2 sm:mx-3 md:mx-4 opacity-60 blur-sm transition-all duration-500" alt="ERP Dashboard">
                <img src="uploads/images/erp2.png" class="gallery-image w-80 h-96 sm:w-96 sm:h-[30rem] md:w-[30rem] md:h-[32rem] object-contain rounded-lg mx-2 sm:mx-3 md:mx-4 opacity-100 blur-0 scale-110 z-10 transition-all duration-500" alt="ERP Reports">
                <img src="uploads/images/erp3.png" class="gallery-image w-72 h-80 sm:w-80 sm:h-96 md:w-96 md:h-[30rem] object-contain rounded-lg mx-2 sm:mx-3 md:mx-4 opacity-60 blur-sm transition-all duration-500" alt="ERP Analytics">
                <img src="uploads/images/erp4.png" class="gallery-image w-72 h-80 sm:w-80 sm:h-96 md:w-96 md:h-[30rem] object-contain rounded-lg mx-2 sm:mx-3 md:mx-4 opacity-60 blur-sm transition-all duration-500" alt="ERP Management">
                <img src="uploads/images/erp5.png" class="gallery-image w-72 h-80 sm:w-80 sm:h-96 md:w-96 md:h-[30rem] object-contain rounded-lg mx-2 sm:mx-3 md:mx-4 opacity-60 blur-sm transition-all duration-500" alt="ERP Interface">
                <img src="uploads/images/erp6.png" class="gallery-image w-72 h-80 sm:w-80 sm:h-96 md:w-96 md:h-[30rem] object-contain rounded-lg mx-2 sm:mx-3 md:mx-4 opacity-60 blur-sm transition-all duration-500" alt="ERP Settings">
                <img src="uploads/images/erp7.png" class="gallery-image w-72 h-80 sm:w-80 sm:h-96 md:w-96 md:h-[30rem] object-contain rounded-lg mx-2 sm:mx-3 md:mx-4 opacity-60 blur-sm transition-all duration-500" alt="ERP Inventory">
                <img src="uploads/images/erp8.png" class="gallery-image w-72 h-80 sm:w-80 sm:h-96 md:w-96 md:h-[30rem] object-contain rounded-lg mx-2 sm:mx-3 md:mx-4 opacity-60 blur-sm transition-all duration-500" alt="ERP Finance">
              </div>
            </div>
            <button id="prev-btn" class="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 bg-red-600 text-white p-2 sm:p-3 rounded-full hover:bg-red-700 transition-colors z-20">
              <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
            </button>
            <button id="next-btn" class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 bg-red-600 text-white p-2 sm:p-3 rounded-full hover:bg-red-700 transition-colors z-20">
              <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Challenges Section -->
    <section class="pb-16" style="background-color: black;">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-4xl font-bold text-white mb-6">The Challenges</h2>
          <div class="w-24 h-1 bg-gradient-to-r from-red-600 to-red-400 mx-auto rounded-full"></div>
        </div>
        
        <div class="max-w-6xl mx-auto">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Challenge 1 -->
            <div class="group relative">
              <div class="absolute inset-0 bg-gradient-to-r from-red-600/20 to-red-400/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
              <div class="relative bg-gray-900/80 backdrop-blur-sm p-8 rounded-2xl border border-red-500/30 hover:border-red-400/50 transition-all duration-300 hover:transform hover:scale-105">
                <div>
                  <h3 class="text-xl font-bold text-red-600 mb-3">Data Integration</h3>
                  <p class="text-gray-300 leading-relaxed">Integrating multiple data sources and legacy systems into a unified platform while maintaining data integrity.</p>
                </div>
              </div>
            </div>
            
            <!-- Challenge 2 -->
            <div class="group relative">
              <div class="absolute inset-0 bg-gradient-to-r from-red-600/20 to-red-400/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
              <div class="relative bg-gray-900/80 backdrop-blur-sm p-8 rounded-2xl border border-red-500/30 hover:border-red-400/50 transition-all duration-300 hover:transform hover:scale-105">
                <div>
                  <h3 class="text-xl font-bold text-red-600 mb-3">Scalability & Performance</h3>
                  <p class="text-gray-300 leading-relaxed">Building a system that can handle growing business needs and large volumes of data without performance degradation.</p>
                </div>
              </div>
            </div>
            
            <!-- Challenge 3 -->
            <div class="group relative">
              <div class="absolute inset-0 bg-gradient-to-r from-red-600/20 to-red-400/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
              <div class="relative bg-gray-900/80 backdrop-blur-sm p-8 rounded-2xl border border-red-500/30 hover:border-red-400/50 transition-all duration-300 hover:transform hover:scale-105">
                <div>
                  <h3 class="text-xl font-bold text-red-600 mb-3">User Training & Adoption</h3>
                  <p class="text-gray-300 leading-relaxed">Ensuring smooth user adoption across different departments with varying technical expertise levels.</p>
                </div>
              </div>
            </div>
            
            <!-- Challenge 4 -->
            <div class="group relative">
              <div class="absolute inset-0 bg-gradient-to-r from-red-600/20 to-red-400/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
              <div class="relative bg-gray-900/80 backdrop-blur-sm p-8 rounded-2xl border border-red-500/30 hover:border-red-400/50 transition-all duration-300 hover:transform hover:scale-105">
                <div>
                  <h3 class="text-xl font-bold text-red-600 mb-3">Security & Compliance</h3>
                  <p class="text-gray-300 leading-relaxed">Implementing robust security measures and ensuring compliance with industry regulations and standards.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Technology Section -->
    <section class="pb-16" style="background-color: #000000ff;">
      <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto bg-gray-900/50 rounded-3xl border border-green-500/30 p-8">
          <h2 class="text-center text-white text-4xl font-bold mb-12">Technologies</h2>
          
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
            <!-- Front End -->
            <div class="text-center">
              <h3 class="text-lg font-semibold mb-6" style="color: #E11D48;">Front End</h3>
              <div class="bg-white rounded-2xl p-6 w-20 h-20 mx-auto flex items-center justify-center mb-3">
                <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center">
                  <span class="text-white font-bold text-lg">N</span>
                </div>
              </div>
              <p class="text-white font-medium">Next.js</p>
            </div>
            
            <!-- Back End -->
            <div class="text-center">
              <h3 class="text-lg font-semibold mb-6" style="color: #E11D48;">Back End</h3>
              <div class="bg-white rounded-2xl p-6 w-20 h-20 mx-auto flex items-center justify-center mb-3">
                <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center">
                  <span class="text-white font-bold text-lg">N</span>
                </div>
              </div>
              <p class="text-white font-medium">Next.js</p>
            </div>
            
            <!-- Database -->
            <div class="text-center">
              <h3 class="text-lg font-semibold mb-6" style="color: #E11D48;">Database</h3>
              <div class="bg-white rounded-2xl p-6 w-20 h-20 mx-auto flex items-center justify-center mb-3">
                <svg class="w-10 h-10 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M17.193 9.555c-1.264-5.58-4.252-7.414-4.573-8.115-.28-.394-.53-.954-.735-1.44-.036.495-.055.685-.523 1.184-.723.566-4.438 3.682-4.74 10.02-.282 5.912 4.27 9.435 4.888 9.884l.07.05A73.49 73.49 0 0111.91 24h.481c.114-1.032.284-2.056.51-3.07.417-.296.604-.463.85-.693a11.342 11.342 0 003.639-8.464c.01-.814-.103-1.662-.197-2.218zm-5.336 8.195s0-8.291.275-8.29c.213 0 .49 10.695.49 10.695-.381-.116-.765-1.6-.765-2.405z"/>
                </svg>
              </div>
              <p class="text-white font-medium">MongoDB</p>
            </div>
            
            <!-- Cloud -->
            <div class="text-center">
              <h3 class="text-lg font-semibold mb-6" style="color: #E11D48;">Cloud</h3>
              <div class="bg-white rounded-2xl p-6 w-20 h-20 mx-auto flex items-center justify-center mb-3">
                <svg class="w-10 h-10 text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                </svg>
              </div>
              <p class="text-white font-medium">AWS</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Solution Section -->
    <section class="pb-16" style="background-color: black;">
      <div class="container mx-auto px-4">
        <h2 class="text-center text-white text-4xl font-bold mb-8">Solution</h2>
        <div class="max-w-6xl mx-auto">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gray-900/50 p-6 rounded-lg border border-red-500/20">
              <h3 class="text-xl font-bold mb-4 text-red-600">Modular Architecture</h3>
              <p class="text-gray-300">Built with modular components allowing easy customization and scalability for different business requirements.</p>
            </div>
            <div class="bg-gray-900/50 p-6 rounded-lg border border-red-500/20">
              <h3 class="text-xl font-bold mb-4 text-red-600">Real-time Analytics</h3>
              <p class="text-gray-300">Advanced reporting and analytics dashboard providing real-time insights into business operations and performance.</p>
            </div>
            <div class="bg-gray-900/50 p-6 rounded-lg border border-red-500/20">
              <h3 class="text-xl font-bold mb-4 text-red-600">Multi-Department Integration</h3>
              <p class="text-gray-300">Seamless integration across HR, Finance, Inventory, Sales, and other departments for unified operations.</p>
            </div>
            <div class="bg-gray-900/50 p-6 rounded-lg border border-red-500/20">
              <h3 class="text-xl font-bold mb-4 text-red-600">Cloud-Based Solution</h3>
              <p class="text-gray-300">Secure cloud deployment ensuring accessibility, automatic backups, and scalable infrastructure.</p>
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

  <!-- JavaScript -->
  <script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // Scroll animation for gallery
    const style = document.createElement('style');
    style.textContent = `
      @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
      }
    `;
    document.head.appendChild(style);
  </script>
</body>
</html>