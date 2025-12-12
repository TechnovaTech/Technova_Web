<!DOCTYPE html>
<html lang="en">
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
  </style>
</head>

<body>
  <!-- Header -->
  <header class="fixed top-0 w-full z-50 bg-black/90 backdrop-blur-md">
    <div class="container mx-auto px-4 flex h-20 items-center justify-between">
      <a href="#" class="flex items-center gap-2">
        <img src="logo.svg" alt="Logo" class="h-8 w-auto" />
      </a>
      
      <nav class="hidden md:flex items-center gap-8">
        <a href="index.php" class="text-white hover:text-primary transition-colors">Home</a>
        <a href="service.php" class="text-white hover:text-primary transition-colors">Services</a>
        <a href="hireteam.php" class="text-white hover:text-primary transition-colors">Hire Team</a>
        <a href="portfolio.php" class="text-white hover:text-primary transition-colors">Portfolio</a>
        <a href="about.php" class="text-white hover:text-primary transition-colors">About</a>
        <a href="carrer.php" class="text-white hover:text-primary transition-colors">Careers</a>
      </nav>
      
      <div>
        <a href="contact.php" class="btn">Contact Us</a>
      </div>
      
      <button id="mobile-menu-button" class="md:hidden text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-black/90 backdrop-blur-md">
      <nav class="flex flex-col items-center gap-4 py-6">
        <a href="index.php" class="text-white hover:text-primary transition-colors">Home</a>
        <a href="service.php" class="text-white hover:text-primary transition-colors">Services</a>
        <a href="hireteam.php" class="text-white hover:text-primary transition-colors">Hire Team</a>
        <a href="portfolio.php" class="text-white hover:text-primary transition-colors">Portfolio</a>
        <a href="about.php" class="text-white hover:text-primary transition-colors">About</a>
        <a href="carrer.php" class="text-white hover:text-primary transition-colors">Careers</a>
        <a href="contact.php" class="btn">Contact Us</a>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="pt-20">
    <!-- Hero Section -->
    <section class="py-20 min-h-screen flex items-center relative overflow-hidden">
      <!-- Background Images -->
      <div class="absolute inset-0 z-0 hero-bg">
        <img src="uploads/images/Homebg1.gif" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-20 slow-gif">
        <img src="uploads/images/Homebg2.png" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-80" style="mix-blend-mode: screen;">

        <div class="absolute inset-0 bg-black/30"></div>
      </div>
      
      <div class="container mx-auto px-4 text-center relative z-10 hero-text">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
          HAVE AN <span class="text-red-600">IDEA</span><br>
          THAT WILL CHANGE THE <span class="text-red-600">WORLD</span>...?
        </h1>
        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
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
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 min-h-[350px]">
            <div class="bg-gradient-to-br from-red-900/30 to-black/50 p-8 lg:p-12 flex items-center justify-center border-r border-red-500/20">
              <div class="text-center">
                <h3 class="text-2xl lg:text-3xl font-bold text-white mb-4">
                  <span class="text-red-600">Accredited By</span>
                </h3>
                <p class="text-lg text-gray-300">World's leading rating & review firms</p>
              </div>
            </div>

            <div class="p-6 pb-8 min-h-[350px] flex flex-col justify-between">
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
              
              <div class="mt-6 pt-4 border-t border-red-500/20">
                <div class="text-center">
                  <div class="font-bold text-white text-xl">Erica Lindgren</div>
                  <div class="text-red-600 font-semibold text-lg">Zorbeto AB</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer class="bg-black text-gray-300 py-12 border-t border-gray-800">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <div>
          <h3 class="text-lg font-bold mb-4 text-white">Contact Us</h3>
          <p class="mb-2"><strong>Email:</strong> info@technovatechnologies.com</p>
          <p class="mb-2"><strong>Phone:</strong> +91 94273 00816</p>
          <p><strong>Address:</strong> 608 - Time Square Commercial Complex, Rajkot, Gujarat</p>
        </div>
        
        <div>
          <h3 class="text-lg font-bold mb-4 text-white">Services</h3>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-primary transition-colors">Web Development</a></li>
            <li><a href="#" class="hover:text-primary transition-colors">App Development</a></li>
            <li><a href="#" class="hover:text-primary transition-colors">UI/UX Design</a></li>
            <li><a href="#" class="hover:text-primary transition-colors">E-Commerce</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-lg font-bold mb-4 text-white">Technologies</h3>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-primary transition-colors">Laravel</a></li>
            <li><a href="#" class="hover:text-primary transition-colors">React</a></li>
            <li><a href="#" class="hover:text-primary transition-colors">Node.js</a></li>
            <li><a href="#" class="hover:text-primary transition-colors">Flutter</a></li>
          </ul>
        </div>
      </div>
      
      <div class="pt-8 border-t border-gray-800 text-center">
        <p>&copy; 2025 Technova Technologies. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    });
  </script>
</body>
</html>
