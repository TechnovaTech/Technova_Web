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
  <title><?php echo $project['title']; ?> - Project Detail</title>
  <meta name="description" content="Detailed view of our portfolio project - W3nuts Premium Digital Agency">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script type="text/javascript" src="script.js"></script>
<!-- In <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

<!-- Lightbox CSS -->
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css" rel="stylesheet" />

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Lightbox2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css" rel="stylesheet">

<!-- Font Awesome (for custom close icon) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



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
    
    html {
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

.project-hero {
  /* display: flex; */
  align-items: center;
  justify-content: center;
  min-height: 500px;
  background: linear-gradient(120deg, #000 40%,rgb(75, 28, 27) 100%);
  border-bottom-left-radius: 60px;
}

/* Auto Scroll Background */
.auto-scroll-bg {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: black;
  z-index: -1;
  overflow: hidden;
}

.scroll-image {
  position: absolute;
  width: 100vw;
  height: 100vh;
  object-fit: cover;
  animation: autoScroll 20s linear infinite;
}

@keyframes autoScroll {
  0% { transform: translateY(0); }
  100% { transform: translateY(-100vh); }
}

.gallery-item img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  background: black;
}tom-right-radius: 60px;
  margin-bottom: 40px;
  margin-top:70px;
}
.hero-img-side {
  flex: 1.1;
  display: flex;
  align-items: center;
  justify-content: center;
}
.hero-img-side img {
  width: 90%;
  max-width: 400px;
  border-radius: 24px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.45);
  margin: 32px 0;
}
.hero-text-side {
  flex: 1.2;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 40px 98px 40px 0px;
}


.glass-notebook-stack {
  position: relative;
  width: 600px;
  max-width: 100%;
  height: 260px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.glass-notebook {
  position: absolute;
  left: 50%;
  width: 100%;      /* Example size, adjust as needed */
  height: 320px;     /* Example size, adjust as needed */
  min-height: unset; /* Remove min-height if set */
  max-width: unset;  
  background: rgba(34, 34, 34, 0.45);
  border-radius: 18px;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1.5px solid rgba(255,255,255,0.12);
  transition: box-shadow 0.3s, transform 0.3s;
  padding: 28px 24px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.card-under-1 {
  z-index: 1;
  top: 40px;
  left: 0;
  transform: rotate(-12deg) scale(1);
  /* ...rest of your styles... */
}
.card-under-2 {
  z-index: 2;
  top: 20px;
  left: 20px;
  transform: rotate(8deg) scale(1);
  /* ...rest of your styles... */
}
.card-top {
  z-index: 3;
  top: 0;
  left: 40px;
  transform: rotate(0deg) scale(1);
  /* ...rest of your styles... */
}
.hero-title {
  font-size: 2.2rem;
  font-weight: 700;
  margin-bottom: 18px;
  letter-spacing: 1px;
  color: #fff;
  text-shadow: 0 2px 8px rgba(0,0,0,0.18);
}
.hero-desc {
  font-size: 1.1rem;
  color: #ffe066;
  font-weight: 500;
  text-shadow: 0 2px 8px rgba(0,0,0,0.18);
}
@media (max-width: 900px) {
  .hero-text-side {
    padding: 24px 10px;
  }
  .glass-notebook-stack {
    width: 100%;
    height: 180px;
  }
  .glass-notebook {
    width: 95vw;
    min-height: 200px;
    padding: 16px 8px;
  }
  .hero-title {
    font-size: 1.2rem;
  }
  .hero-desc {
    font-size: 1rem;
  }
}

@media (max-width: 600px) {
  .project-hero {
    flex-direction: column;
    min-height: unset;
    padding: 10px 0;
    margin-bottom: 10px;
    margin-top: 20px;
  }
  .hero-img-side {
    max-width: 220px;
    width: 100%;
    margin-bottom: 10px;
  }
  .glass-notebook-stack {
    width: 100%;
    height: 500px;
  }
  .glass-notebook {
    width: 90vw;
    height: 60px;
    padding: 8px 4px;
  }
  .hero-title {
    font-size: 1rem;
  }
  .hero-desc {
    font-size: 0.9rem;
  }
}

.glass-card {
  background: rgba(34, 34, 34, 0.45);
  border-radius: 18px;
  border: 2px solid rgba(255,255,255,0.18);
  box-shadow: 0 8px 32px 0 rgba(131, 7, 7, 0.7), 0 2px 8px 0 rgba(131, 18, 18, 0.18);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  overflow: hidden;
  transition: box-shadow 0.3s, transform 0.3s;
}
.card-img-top {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-top-left-radius: 18px;
  border-top-right-radius: 18px;
}
.card-title{
  font-size: 2rem;
  text-align:center;
  font-weight: 700;
  color:var(--primary); /* Gold/yellow for contrast */
  letter-spacing: 1px;
  margin-bottom: 12px;
  text-shadow: 0 2px 8px rgba(0,0,0,0.18);
  
}
.card-text{
  text-align:justify;
}




.insight-section {
  width: 100%;
  display: flex;
  justify-content: center;
}

.insight-card {
  background: rgba(34, 34, 34, 0.45);
  border-radius: 18px;
  border: 2px solid rgba(255,255,255,0.18);
  box-shadow: 0 8px 32px 0 rgba(131, 7, 7, 0.7), 0 2px 8px 0 rgba(131, 18, 18, 0.18);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  overflow: hidden;
  transition: box-shadow 0.3s, transform 0.3s;
  border-radius: 24px;
  padding: 40px 48px;
  max-width: 70vw;
  margin: 0 auto;
}

.insight-title {
  font-size: 2rem;
  
  font-weight: 700;
  color:var(--primary); /* Gold/yellow for contrast */
  letter-spacing: 1px;
  margin-bottom: 12px;
  text-shadow: 0 2px 8px rgba(0,0,0,0.18);;
}

.insight-card p {
  font-size: 1.15rem;
  margin-bottom: 0;
  text-align:justify;
}

.insight-card strong {
  font-weight: 700;
  color: #fff;
}



.creative-title {
  font-size: 2rem;
  font-weight: 700;
  color: #fff;
  letter-spacing: 1px;
  margin-bottom: 32px;
}

.creative-img {
  width: 100%;
  height: auto;
  border-radius: 24px;
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
  background: #222;
  padding: 8px;
}
@media (max-width: 768px) {
  .card-img-top {
    height: 140px;
  }
}

/* Card Animation CSS - Cleaned */
@keyframes fadeInLeft {
  0% { opacity: 0; transform: translateX(-60px) scale(0.96); }
  100% { opacity: 1; transform: translateX(0) scale(1); }
}
@keyframes fadeInRight {
  0% { opacity: 0; transform: translateX(60px) scale(0.96); }
  100% { opacity: 1; transform: translateX(0) scale(1); }
}
@keyframes popIn {
  0% { opacity: 0; transform: scale(0.7); }
  80% { opacity: 1; transform: scale(1.08); }
  100% { opacity: 1; transform: scale(1); }
}


@media (max-width: 991.98px) {
  .project-hero {
    min-height: unset;
    padding: 20px 0;
    margin-bottom: 20px;
    margin-top: 40px;
  }
  .hero-img-side {
    margin-bottom: 20px;
    max-width: 320px;
    width: 100%;
    justify-content: center;
  }
  .hero-text-side {
    padding: 16px 0 0 0;
    width: 100%;
    align-items: center;
  }
  .glass-notebook-stack {
    width: 100%;
    height: 600px;
    min-width: 0;
  }
  .glass-notebook {
    width: 95vw;
    height: 120px;
    padding: 12px 6px;
  }
  .hero-title {
    font-size: 1.3rem;
  }
  .glass-card {
    margin-bottom: 24px;
  }
  .insight-card {
    padding: 24px 8px;
    max-width: 98vw;
  }
  .creative-img {
    max-width: 120px;
  }
}
@media (max-width: 600px) {
  .glass-notebook-stack {
    width: 100%;
    height: 500px;
  }
  .glass-notebook {
    width: 90vw;
    height: 60px;
    padding: 8px 4px;
  }
  .hero-title {
    font-size: 1rem;
  }
  .container {
    padding-left: 8px !important;
    padding-right: 8px !important;
  }
}

@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}

.animate-scroll:hover {
  animation-play-state: paused;
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
  <body>
    <section style="background-color: black; padding: 80px 0;"> 
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-12 text-center">
          <!-- Icon -->
          <div class="mb-4">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto">
              <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z" fill="#E11D48"/>
              <path d="M9 8V17H11V8H9ZM13 8V17H15V8H13Z" fill="#E11D48"/>
            </svg>
          </div>
          
          <!-- Heading -->
          <h1 class="hero-title mb-4" style="font-size: 2.5rem; font-weight: 700; color: #fff; margin-bottom: 2rem;">ShopCart</h1>
          
          <!-- Divider Line -->
          <div class="w-100 mx-auto mb-4" style="height: 2px; background-color: #E11D48; max-width: 800px;"></div>
          
          <!-- Description -->
          <div class="mx-auto" style="max-width: 800px;">
            <p class="text-center" style="font-size: 1.1rem; color: #d1d5db; line-height: 1.8; margin-bottom: 0;">
              A vision built on experience and fueled by passion—ShopCart E-commerce Platform stands as a testament to expertise in online retail solutions. Our platform design captures the company's journey from a skilled developer's ambition to a trusted industry leader. With a seamless and modern interface, the design reflects ShopCart's commitment to efficiency, reliability, and innovation in e-commerce operations.
            </p>
          </div>
        </div>
      </div>
    </div>
    </section>

    <!-- Auto-Scroll Gallery -->
    <section class="py-16" style="background-color: #111;">
      <div class="container">
        <h2 class="text-center text-white text-3xl font-bold mb-8">Project Gallery</h2>
        <div class="overflow-hidden">
          <div class="flex animate-scroll" style="animation: scroll 15s linear infinite;">
            <img src="uploads/images/e-commerce1.webp" class="w-80 h-60 object-cover rounded-lg mx-4 flex-shrink-0">
            <img src="uploads/images/e-commerce2.webp" class="w-80 h-60 object-cover rounded-lg mx-4 flex-shrink-0">
            <img src="uploads/images/e-commerce3.webp" class="w-80 h-60 object-cover rounded-lg mx-4 flex-shrink-0">
            <img src="uploads/images/Dashboard1.png" class="w-80 h-60 object-cover rounded-lg mx-4 flex-shrink-0">
            <img src="uploads/images/e-commerce1.webp" class="w-80 h-60 object-cover rounded-lg mx-4 flex-shrink-0">
            <img src="uploads/images/e-commerce2.webp" class="w-80 h-60 object-cover rounded-lg mx-4 flex-shrink-0">
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

  document.addEventListener("DOMContentLoaded", function() {
    function revealOnScroll() {
      document.querySelectorAll('.animated-card').forEach(function(card) {
        const rect = card.getBoundingClientRect();
        if (rect.top < window.innerHeight - 60) {
          card.classList.add('visible');
        }
      });
    }
    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll();
  });
  

  </script>

<!-- Lightbox JS -->
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/js/lightbox.min.js"></script>



</body>
</php>


