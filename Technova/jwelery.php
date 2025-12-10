<!DOCTYPE php>
<php lang="en">
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
  <title>Project Details - Technova Technoloiges</title>
  <meta name="description" content="Detailed view of our portfolio project - W3nuts Premium Digital Agency">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script type="text/javascript" src="script.js"></script>
<!-- In <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  
  <!-- Critical Inline CSS -->
  <style>
    :root {
      --primary: #e11d48;
      --primary-hover: #be123c;
      --primary-light: rgba(225, 29, 72, 0.2);
      --primary-dark: #9f1239;
      --secondary: #111827;
      --secondary-light: #1f2937;
    }
    
    php {
      scroll-behavior: smooth;
      scroll-padding-top: 80px;
    }
    
    body {
      font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      overflow-x: hidden;
      background-color: black;
      color: white;
    }
    
    /* Preloader */
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: black;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      transition: opacity 0.5s ease, visibility 0.5s ease;
    }
    
    .loader {
      width: 80px;
      height: 80px;
      position: relative;
    }
    
    .loader-ring {
      position: absolute;
      width: 100%;
      height: 100%;
      border: 4px solid transparent;
      border-top-color: var(--primary);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    
    .loader-ring:nth-child(2) {
      width: 80%;
      height: 80%;
      top: 10%;
      left: 10%;
      border-top-color: transparent;
      border-right-color: var(--primary);
      animation-duration: 1.2s;
      animation-direction: reverse;
    }
    
    .loader-ring:nth-child(3) {
      width: 60%;
      height: 60%;
      top: 20%;
      left: 20%;
      border-top-color: transparent;
      border-bottom-color: var(--primary);
      animation-duration: 1.5s;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    /* Custom Cursor */
    .cursor-dot,
    .cursor-outline {
      pointer-events: none;
      position: fixed;
      top: 0;
      left: 0;
      transform: translate(-50%, -50%);
      border-radius: 50%;
      z-index: 9999;
      transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    }
    
    .cursor-dot {
      width: 8px;
      height: 8px;
      background-color: var(--primary);
    }
    
    .cursor-outline {
      width: 40px;
      height: 40px;
      border: 2px solid var(--primary);
      transition: all 0.2s ease-out;
    }
    
    /* Navigation Links */
    .nav-link {
      position: relative;
      transition: color 0.3s ease;
    }
    
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -4px;
      left: 0;
      background-color: var(--primary);
      transition: width 0.3s ease;
    }
    
    .nav-link:hover::after {
      width: 100%;
    }
    
    /* Reveal Animation */
    .reveal {
      position: relative;
      transform: translateY(50px);
      opacity: 0;
      transition: all 1s ease;
    }
    
    .reveal.active {
      transform: translateY(0);
      opacity: 1;
    }
    
    /* Button Styles */
    .btn {
      display: inline-block;
      padding: 12px 24px;
      background-color: var(--primary);
      color: white;
      border-radius: 50px;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.7s ease;
      z-index: -1;
    }
    
    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(225, 29, 72, 0.3);
    }
    
    .btn:hover::before {
      left: 100%;
    }
    
    .btn-outline {
      background-color: transparent;
      border: 2px solid white;
    }
    
    .btn-outline:hover {
      background-color: var(--primary);
      border-color: var(--primary);
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
      body {
        cursor: auto;
      }
      
      .cursor-dot, 
      .cursor-outline {
        display: none;
      }
      
      .reveal {
        transform: translateY(20px);
      }
    }
    
    @media (max-width: 640px) {
      h1 {
        font-size: 2rem !important;
      }
      
      h2 {
        font-size: 1.75rem !important;
      }
      
      .container {
        padding-left: 1rem;
        padding-right: 1rem;
      }
    }
    
    /* Project Gallery */
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-gap: 1rem;
    }
    
    @media (max-width: 768px) {
      .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    
    @media (max-width: 480px) {
      .gallery-grid {
        grid-template-columns: 1fr;
      }
    }
    
    .gallery-item {
      position: relative;
      overflow: hidden;
      border-radius: 0.5rem;
      transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
      transform: scale(1.05);
    }
    
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: all 0.5s ease;
    }

    
.logo-container {
    position: relative;
    width: 100px; /* Adjust as needed */
    height: 100px; /* Adjust as needed */
}

.line {
    position: absolute;
    background-color: #ff4081; /* Change to your desired color */
    height: 5px; /* Thickness of the line */
    width: 50px; /* Length of the line */
    animation: rotate 2s linear infinite;
}

.line-1 {
    top: 0;
    left: 50%;
    transform-origin: left center;
    animation-delay: 0s;
}

.line-2 {
    top: 50%;
    left: 50%;
    transform-origin: top center;
    animation-delay: 0.67s;
}

.line-3 {
    top: 100%;
    left: 50%;
    transform-origin: left center;
    animation-delay: 1.33s;
}

@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.logo {
    color: white;
    font-weight: bold;
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
  </style>
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
      <a href="index.php" class="flex items-center gap-2 group">
        <img src="logo.svg" alt="Logo" class="h-8 sm:h-10 w-auto transition-transform duration-300 transform group-hover:scale-110" />
      </a>
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
          Careers
        </a>
      </nav>
      <div>
        <a href="contact.php" class="btn text-sm sm:text-base py-2 px-4 sm:py-3 sm:px-6">
          Contact Us
        </a>
      </div>
      <button id="mobile-menu-button" class="md:hidden text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>
    </div>


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

  <!-- Project Hero Section -->
  <section class="pt-32 pb-16 md:pb-24 relative overflow-hidden">
    <div class="absolute inset-0" style="background: radial-gradient(circle at center, rgba(225, 29, 72, 0.1), transparent 70%);"></div>
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
      <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-center">
        <div class="w-full lg:w-1/2 reveal">
          <div class="flex items-center gap-2 mb-4">
            <span class="text-primary font-medium">Project</span>
            <span class="w-12 h-px bg-primary"></span>
          </div>
          <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6">First Night</h1>
          <p class="text-gray-400 text-lg mb-8">
            A modern, luxurious online platform designed to showcase and sell First Night’s exquisite jewelry collections, offering an intuitive and seamless shopping experience for high-end customers.          </p>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 mb-8">
            <div>
              <h4 class="text-sm text-gray-500 mb-1">Client</h4>
              <p>First Night</p>
            </div>
            <div>
              <h4 class="text-sm text-gray-500 mb-1">Category</h4>
              <p>Jwelery Shop, Web Platform</p>
            </div>
            <div>
              <h4 class="text-sm text-gray-500 mb-1">Timeline</h4>
              <p>3 Months</p>
            </div>
            <div>
              <h4 class="text-sm text-gray-500 mb-1">Services</h4>
              <p>MERN, Web Development</p>
            </div>
          </div>
          <div class="flex flex-wrap gap-4">
            <a href="#project-details" class="btn">View Project Details</a>
            <a href="Contact.php" class="btn btn-outline">Start a Similar Project</a>
          </div>
        </div>
        <div class="w-full lg:w-1/2 reveal">
          <img src="https://img.freepik.com/free-vector/jewelry-shop-concept-precious-stones-jewelry-business-goldsmith-workshop-luxury-treasure-industry-idea-creative-people-professionvector-illustration_613284-1654.jpg" alt="I Project" class="w-full h-auto rounded-lg shadow-2xl">
        </div>
      </div>
    </div>
  </section>

  <!-- Project Details Section -->
  <section id="project-details" class="py-16 md:py-24 bg-black">
    <div class="container mx-auto px-4 sm:px-6">
      <div class="max-w-3xl mx-auto reveal">
        <h2 class="text-2xl sm:text-3xl font-bold mb-8">Project Overview</h2>
        <p class="text-gray-300 mb-6">
          First Night needed a complete overhaul of their digital presence to provide a seamless and luxurious shopping experience for their growing customer base. The luxury jewelry industry thrives on exclusivity and elegance, and our goal was to create a digital platform that reflects Bulgari’s heritage while offering a modern and intuitive user experience.        </p>
        <p class="text-gray-300 mb-6">
          We developed a sleek, responsive platform that enhances the luxury shopping experience with intuitive navigation, high-definition product displays, and a seamless checkout process. The result is a 45% increase in online sales and a significant boost in customer engagement.        </p>
        
        <h3 class="text-xl font-bold mt-10 mb-4">The Challenge</h3>
        <p class="text-gray-300 mb-6">
          The insurance industry is notorious for its complex processes and terminology that confuse customers. I faced high abandonment rates during the quote and purchase process, with many potential customers opting to call customer service instead of completing transactions online.
        </p>
        <p class="text-gray-300 mb-6">
          Additionally, their previous digital platform was not optimized for mobile devices, causing friction for the growing number of customers browsing and purchasing luxury jewelry via smartphones and tablets.        </p>
        
        <h3 class="text-xl font-bold mt-10 mb-4">Our Approach</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-8">
          <div class="bg-gray-900/30 p-6 rounded-lg">
            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
              </svg>
            </div>
            <h4 class="font-bold mb-2">User Research</h4>
            <p class="text-gray-400">We carried out in-depth user interviews and comprehensive usability testing to identify customer pain points and refine their digital experience.</p>
          </div>
          <div class="bg-gray-900/30 p-6 rounded-lg">
            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
              </svg>
            </div>
            <h4 class="font-bold mb-2">UX Design</h4>
            <p class="text-gray-400">We streamlined the interface, minimized form fields, and incorporated clear step-by-step guidance to enhance user experience.</p>
          </div>
          <div class="bg-gray-900/30 p-6 rounded-lg">
            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 004.5 4.5m11.25-4.5H21m-3.75 0h1.5m-1.5 0a3 3 0 01-3 3m0 0a3 3 0 01-3-3m3 3a3 3 0 100 6h-3m3-6h-3m-3.75 0H4.5m0 0a3 3 0 01-3-3m3 3a3 3 0 100 6h.75m-4.5-6h1.5m12 0h1.5" />
              </svg>
            </div>
            <h4 class="font-bold mb-2">Development</h4>
            <p class="text-gray-400">We developed a fully responsive platform optimized for speed, accessibility, and seamless user experience across all devices.</p>
          </div>
        </div>
        
        <h3 class="text-xl font-bold mt-10 mb-6">Project Gallery</h3>
      </div>
      
       <div class="gallery-grid max-w-5xl mx-auto mb-12 reveal" id="thumbnailGallery">
    <!-- Each image thumbnail -->
    <img src="uploads/images/FNP1.png" class="thumb cursor-pointer w-full h-48 object-cover rounded shadow" alt="Image 1" />
    <img src="uploads/images/FNP2.png" class="thumb cursor-pointer w-full h-48 object-cover rounded shadow" alt="Image 2" />
    <img src="uploads/images/FNP3.png" class="thumb cursor-pointer w-full h-48 object-cover rounded shadow" alt="Image 3" />
    <img src="uploads/images/FNP4.png" class="thumb cursor-pointer w-full h-48 object-cover rounded shadow" alt="Image 4" />
    <img src="uploads/images/FNP5.jpeg" class="thumb cursor-pointer w-full h-48 object-cover rounded shadow" alt="Image 5" />
    <img src="uploads/images/FNP6.jpeg" class="thumb cursor-pointer w-full h-48 object-cover rounded shadow" alt="Image 6" />
        <img src="uploads/images/FNP8.jpeg" class="thumb cursor-pointer w-full h-48 object-cover rounded shadow" alt="Image 8" />
    <img src="uploads/images/FNP7.jpeg" class="thumb cursor-pointer w-full h-48 object-cover rounded shadow" alt="Image 7" />

  </div>
  
  
  <!-- Custom Modal -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 flex flex-col">
    <div class="flex justify-end p-4">
      <button onclick="closeModal()" class="text-white text-3xl font-bold">&times;</button>
    </div>
    <div class="flex-1 overflow-x-auto px-4 py-2">
      <div id="modalImages" class="flex space-x-4 items-center">
        <!-- Images will be cloned here -->
      </div>
    </div>
  </div>
      <div class="max-w-3xl mx-auto reveal">
        <h3 class="text-xl font-bold mt-10 mb-4">Results & Impact</h3>
        <p class="text-gray-300 mb-6">
          The new platform launched to overwhelmingly positive feedback from both customers and internal stakeholders. Key metrics include:
        </p>
        <ul class="list-disc list-inside space-y-2 text-gray-300 mb-8">
          <li>Achieved a 50% increase in online sales for Bulgari Jewels.
          </li>
          <li>Reduced cart abandonment by 65% through an optimized checkout process.</li>
          <li>Lowered customer inquiries by 40% with enhanced product descriptions and AI-driven assistance.</li>
          <li>Boosted mobile engagement by 70% with a fully responsive and immersive shopping experience.</li>
          <li>Improved average customer satisfaction scores by 30% through a seamless and luxurious online experience.</li>
        </ul>
        
        <div class="mt-12 flex flex-col md:flex-row gap-6 justify-center">
          <a href="portfolio.php" class="btn btn-outline">View More Projects</a>
          <a href="contact.php" class="btn">Discuss Your Project</a>
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

  <!-- Inline JavaScript -->
  <script>
    // Preloader
    window.addEventListener('load', function() {
      setTimeout(function() {
        document.getElementById('preloader').style.opacity = '0';
        document.getElementById('preloader').style.visibility = 'hidden';
      }, 1000);
    });

    // Custom Cursor
    document.addEventListener('DOMContentLoaded', function() {
      const cursorDot = document.querySelector('.cursor-dot');
      const cursorOutline = document.querySelector('.cursor-outline');

      if (window.innerWidth > 768) {
        document.addEventListener('mousemove', function(e) {
          const posX = e.clientX;
          const posY = e.clientY;

          cursorDot.style.left = `${posX}px`;
          cursorDot.style.top = `${posY}px`;

          // Add slight delay to cursor outline for smooth effect
          setTimeout(function() {
            cursorOutline.style.left = `${posX}px`;
            cursorOutline.style.top = `${posY}px`;
          }, 50);
        });

        // Cursor effects on hover
        document.querySelectorAll('a, button, input, textarea, select, .gallery-item').forEach(function(item) {
          item.addEventListener('mouseenter', function() {
            cursorOutline.style.transform = 'translate(-50%, -50%) scale(1.5)';
            cursorOutline.style.borderColor = 'var(--primary)';
            cursorDot.style.transform = 'translate(-50%, -50%) scale(0.5)';
          });
          
          item.addEventListener('mouseleave', function() {
            cursorOutline.style.transform = 'translate(-50%, -50%) scale(1)';
            cursorOutline.style.borderColor = 'var(--primary)';
            cursorDot.style.transform = 'translate(-50%, -50%) scale(1)';
          });
        });
      }

      // Mobile Menu Toggle
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');

      if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
          mobileMenu.classList.toggle('hidden');
        });
      }

      // Smooth Scrolling for Anchor Links
      document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();

          const targetId = this.getAttribute('href');
          if (targetId === '#') return;

          const targetElement = document.querySelector(targetId);
          if (targetElement) {
            // Close mobile menu if open
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
              mobileMenu.classList.add('hidden');
            }

            // Scroll to target
            window.scrollTo({
              top: targetElement.offsetTop - 80, // Adjust for header height
              behavior: 'smooth',
            });
          }
        });
      });

      // Header Scroll Effect
      const header = document.querySelector('header');
      let lastScrollTop = 0;

      window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 100) {
          header.style.backgroundColor = 'rgba(0,0,0,0.95)';
          header.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
        } else {
          header.style.backgroundColor = 'rgba(0,0,0,0.9)';
          header.style.boxShadow = 'none';
        }
        
        // Hide/show header on scroll
        if (scrollTop > lastScrollTop && scrollTop > 300) {
          header.style.transform = 'translateY(-100%)';
        } else {
          header.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
      });

      // Back to Top Button
      const backToTopButton = document.getElementById('back-to-top');

      if (backToTopButton) {
        window.addEventListener('scroll', function() {
          if (window.pageYOffset > 300) {
            backToTopButton.classList.add('visible');
          } else {
            backToTopButton.classList.remove('visible');
          }
        });

        backToTopButton.addEventListener('click', function() {
          window.scrollTo({
            top: 0,
            behavior: 'smooth',
          });
        });
      }

      // Reveal on Scroll
      const revealElements = document.querySelectorAll('.reveal');
      
      function reveal() {
        revealElements.forEach(function(element) {
          const windowHeight = window.innerHeight;
          const elementTop = element.getBoundingClientRect().top;
          const elementVisible = 150;
          
          if (elementTop < windowHeight - elementVisible) {
            element.classList.add('active');
          }
        });
      }
      
      window.addEventListener('scroll', reveal);
      reveal(); // Initial check
    });

    //Mobilw view btn
    const mobileMenuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');

  mobileMenuButton.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
  </script>
  
    <!-- JavaScript to handle modal logic -->
  <script>
    const thumbnails = document.querySelectorAll('.thumb');
    const modal = document.getElementById('modal');
    const modalImages = document.getElementById('modalImages');

    thumbnails.forEach(thumb => {
      thumb.addEventListener('click', () => {
        modalImages.innerHTML = '';
        thumbnails.forEach(image => {
          const full = document.createElement('img');
          full.src = image.src;
          full.className = 'h-[80vh] rounded shadow';
          modalImages.appendChild(full);
        });
        modal.classList.remove('hidden');
      });
    });

    function closeModal() {
      modal.classList.add('hidden');
    }
  </script>
</body>
</php>

