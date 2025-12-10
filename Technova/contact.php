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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        Carrers
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

  <!-- Contact Section -->
<section id="contact" class="pt-24 sm:pt-28 py-16 sm:py-22 relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12">
        <div class="reveal">
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6">HAVE A GREAT IDEA?<br />TELL US ABOUT IT</h2>
          <p class="text-xl mb-8">Partner with Technova Technologies & strategize for the future</p>
          <p class="text-gray-400 mb-8">
            From eCommerce, to legal, to healthcare, and everything in between, we work together with
            organizations to solve real business problems and drive innovative solutions.
          </p>
          <div class="space-y-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-primary">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
              </div>
              <a href="tel:+91 9427300816">+91 94273 00816</a>
            </div>
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                  <rect width="20" height="16" x="2" y="4" rx="2" />
                  <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                </svg>
              </div>
              <a href="mailto:info@technovatechnologies.com">info@technovatechnologies.com</a>
            </div>
          </div>
        </div>
        

        <div class="reveal">
          <div class="bg-gray-900 p-6 sm:p-8 rounded-lg shadow-lg">
            <h3 class="text-xl sm:text-2xl font-bold mb-6">Submit the Request</h3>
            <form class="space-y-6" id="contact-form" method="post" action="contact_add.php">
              <div class="form-input">
                <input type="text" name="full_name" id="name" placeholder=" ">
                <label for="name">Name & Company</label>
              </div>

              <div class="form-input">
                <input type="email" name="email" id="email" placeholder=" ">
                <label for="email">Your Email</label>
              </div>

              <div>
                <p class="mb-2 text-sm font-medium">I'm interested in...</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                  <div class="flex items-center space-x-2">
                    <input type="checkbox" id="interest-1" name="interests[]" value="Web Development" class="h-4 w-4 rounded border-gray-700 text-primary">
                    <label for="interest-1" class="text-sm">Web Development</label>
                  </div>
                  <div class="flex items-center space-x-2">
                    <input type="checkbox" id="interest-2" name="interests[]" value="App from scratch" class="h-4 w-4 rounded border-gray-700 text-primary">
                    <label for="interest-2" class="text-sm">App from scratch</label>
                  </div>
                  <div class="flex items-center space-x-2">
                    <input type="checkbox" id="interest-3" name="interests[]" value="UX/UI Design" class="h-4 w-4 rounded border-gray-700 text-primary">
                    <label for="interest-3" class="text-sm">UX/UI Design</label>
                  </div>
                  <div class="flex items-center space-x-2">
                    <input type="checkbox" id="interest-4" name="interests[]" value="Branding" class="h-4 w-4 rounded border-gray-700 text-primary">
                    <label for="interest-4" class="text-sm">Branding</label>
                  </div>
                  <div class="flex items-center space-x-2">
                    <input type="checkbox" id="interest-5" name="interests[]" value="Site from scratch" class="h-4 w-4 rounded border-gray-700 text-primary">
                    <label for="interest-5" class="text-sm">Site from scratch</label>
                  </div>
                  <div class="flex items-center space-x-2">
                    <input type="checkbox" id="interest-6" name="interests[]" value="App Development" class="h-4 w-4 rounded border-gray-700 text-primary">
                    <label for="interest-6" class="text-sm">App Development</label>
                  </div>
                </div>
              </div>

              <div class="form-input">
                <select id="budget" name="budget">
                  <option value="" selected disabled hidden>Select your budget</option>
                  <option value="10-20k">Rs.10k - Rs.20k</option>
                  <option value="30-40k">Rs.30k - Rs.40k</option>
                  <option value="50-60k">Rs.50k - Rs.60k</option>
                  <option value="100k+"> Rs.100k</option>
                </select>
              </div>

              <div class="form-input">
                <textarea id="message" name="message" rows="4" placeholder=" "></textarea>
                <label for="message">Tell us more about your project</label>
              </div>

              <button type="submit" class="btn w-full">
                Submit the Request
              </button>
              
              
               <!-- Social Media Icons -->
  <div class="flex justify-center space-x-4 p-4 bg-black-800">
    <a href="https://wa.me/919427300816" target="_blank" class="text-white hover:text-green-500">
        <i class="fab fa-whatsapp fa-3x"></i>
    </a>
    <!-- <a href="https://www.facebook.com/your-page" target="_blank" class="text-white hover:text-blue-600">
        <i class="fab fa-facebook fa-3x"></i>
    </a> -->
    <!-- <a href="https://www.youtube.com/your-channel" target="_blank" class="text-white hover:text-red-600">
        <i class="fab fa-youtube fa-3x"></i>
    </a> -->
    <a href="https://www.instagram.com/technovatechnologies_?igsh=NDBjaDM2MmxyaXFn" target="_blank" class="text-white hover:text-pink-500">
        <i class="fab fa-instagram fa-3x"></i>
    </a>
    <a href="https://www.linkedin.com/company/technova-technologies1/" target="_blank" class="text-white hover:text-blue-700">
        <i class="fab fa-linkedin fa-3x"></i>
    </a>
</div>

<!-- Razorpay Payment Button -->
<script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_QGxcgcjyKjEbHg" async> </script>

            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="map-section">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3690.8460542943394!2d70.7648577752932!3d22.321661179671256!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959c98ef63b6a9d%3A0xb6633d33f92d4beb!2sTime%20Square!5e0!3m2!1sen!2sin!4v1739526953503!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    
    
<!--Whatsapp Drawer-->

<!--<div id="whatsappDrawer" style="-->
<!--    position: fixed;-->
<!--    right: -220px; /* Hidden by default */-->
<!--    top: 80%;-->
<!--    transform: translateY(-50%);-->
<!--    width: 180px;-->
<!--    background-color: #e11d48;-->
<!--    color: white;-->
<!--    padding: 15px;-->
<!--    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);-->
<!--    transition: right 0.3s ease-in-out;-->
<!--    z-index: 1000;-->
<!--    border-radius: 10px 0px 0px 10px; /* Curvy edges */-->
<!--">-->
<!--    <a href="https://wa.me/919427300816" target="_blank" style="-->
<!--        color: white;-->
<!--        text-decoration: none;-->
<!--        font-weight: bold;-->
<!--        display: block;-->
<!--        text-align: center;-->
<!--    ">Chat on WhatsApp</a>-->
<!--</div>-->

<!--<script>-->
<!--    document.addEventListener('DOMContentLoaded', function () {-->
<!--        window.addEventListener('scroll', function () {-->
<!--            const drawer = document.getElementById('whatsappDrawer');-->
<!--            if (window.scrollY > 200) { -->
<!--                drawer.style.right = "0";-->
<!--            } else {-->
<!--                drawer.style.right = "-220px";-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->


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
 

  <!-- Js For Whatsapp Drawer -->

</body>

</html>