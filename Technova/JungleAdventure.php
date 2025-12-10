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
  <title><?php echo $project['title']; ?> - Project Detail</title>
  <meta name="description" content="Detailed view of our portfolio project - W3nuts Premium Digital Agency">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script type="text/javascript" src="script.js"></script>
<!-- In <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
  border-bottom-right-radius: 60px;
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
    <div class=" mx-auto px-5 sm:px-6 flex h-20 items-center justify-between">
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
  <body>
    <section> 
    <div class="container">
      <div class="row align-items-center justify-content-center project-hero">
        <div class="col-12 col-lg-5 d-flex justify-content-center mb-4 mb-lg-0 hero-img-side">
          <img src="uploads/images/protfolio6.webp" alt="Project Main" class="img-fluid" />
        </div>
        <div class="col-12 col-lg-7 d-flex flex-column align-items-center hero-text-side">
          <div class="glass-notebook-stack w-100">
            <div class="glass-notebook card-under card-under-1"></div>
            <div class="glass-notebook card-under card-under-2"></div>
            <div class="glass-notebook card-top">
              <h1 class="hero-title text-center">Jungle Adventure</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    </section>

  <!-- Two Glass Cards Section (No Images) -->
  <section class="container my-5 ">
    <div class="row justify-content-center g-4">
      <h1 class="text-center text-light mt-5 mb-5 w-100">Project Overview</h1>
      <div class="col-12 col-md-6 col-lg-5 mb-4 mx-auto">
        <div class="glass-card animated-card slide-in-left">
          <div class="p-4">
            <h3 class="card-title mb-4">The Challenge</h3>
           <ul class="card-text" style="list-style-type: square;">
              <li>Ensuring smooth animations at 60fps across all devices</li>
              <li>Reducing asset load time (images, sounds)</li>
              <li>Preventing unexpected behavior in edge cases (e.g., double-clicking a tile too fast)</li>
              <li>Designing a flexible system for level progression</li>
              <li>Balancing game difficulty for both beginners and advanced users</li>
              <li>Making gameplay intuitive on both desktop and mobile</li>
              <li>Using readable fonts and clear instructions for all users</li>
              <li>Allowing multiplayer or socket-based real-time gameplay</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-5 mb-4 mx-auto">
        <div class="glass-card animated-card slide-in-right">
          <div class="p-4">
            <h3 class="card-title mb-4">Key Features </h3>
            <ul class="card-text" style="list-style-type: square;">
              <li><strong>Interactive Gameplay Mechanics –</strong> Real-time interaction with smooth logic flow.</li>
              <li><strong>Reset/Restart Functionality -</strong> One-click reset to play again without reloa</li>
              <li><strong>Save Progress –</strong> Stores progress using localStorage or database (optional).</li>
              <li><strong>Multiplayer Mode –</strong> Local 2-player mode or real-time socket-based (advanced).</li>
              <li><strong>Sound Effects –</strong> Audio feedback on actions like correct match, win, or error.</li>
              <li><strong>Win/Lose Conditions –</strong> Clear logic for detecting game over and victory states.</li>
              <li><strong>Scoring System –</strong> Tracks and displays the player’s score in real-time.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="insight-section my-5">
  <div class="insight-card mx-auto animated-card pop-in">
    <h2 class="insight-title mb-4">Insights</h2>
    <p>
      While developing the game, we discovered how small enhancements like animations and sound effects significantly improve user engagement. Prioritizing core logic—such as scoring, timers, and win/loss detection—early 
      on helped us build a strong foundation before refining the UI.We focused on a mobile-first approach, ensuring the game was responsive and touch-friendly across devices. Accessibility was also considered by using readable 
      fonts and proper color contrasts.Edge cases like rapid clicks and early restarts were carefully handled to improve stability. We also optimized performance by minimizing DOM updates and using lightweight animations for 
      a smooth user experience.Lastly, user feedback played a key role. Testing with real users helped us identify usability issues and improve overall flow, making the game more enjoyable and polished.
    </p>
  </div>
</section>

<section class="container my-5">
  <h2 class="text-center mb-4 creative-title">Creative Designs</h2>
  <div class="row justify-content-center align-items-end">
    <div class="col-6 col-sm-6 col-md-3 mb-3 d-flex justify-content-center">
      <img src="uploads/images/protfolio1.webp" alt="Design 1" class="creative-img img-fluid">
    </div>
    <div class="col-6 col-sm-6 col-md-3 mb-3 d-flex justify-content-center">
      <img src="uploads/images/protfolio2.webp" alt="Design 2" class="creative-img img-fluid">
    </div>
    <div class="col-6 col-sm-6 col-md-3 mb-3 d-flex justify-content-center">
      <img src="uploads/images/protfolio3.webp" alt="Design 3" class="creative-img img-fluid">
    </div>
    <div class="col-6 col-sm-6 col-md-3 mb-3 d-flex justify-content-center">
      <img src="uploads/images/protfolio4.webp" alt="Design 4" class="creative-img img-fluid">
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
            
        <div class=" pt-8 border-t border-gray-800">
           <!-- Copyright -->
            <p class="text-center mt-4 text-sm">&copy; 2025 Technova Technologies. All rights reserved.</p>
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
    revealOnScroll(); // Initial check
  });
  </script>



</body>
</php>


