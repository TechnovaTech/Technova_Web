<?php
include_once("includes/connect_db.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $full_name = $conn->real_escape_string($_POST['full_name']);
  $email = $conn->real_escape_string($_POST['email']);
  $phone = $conn->real_escape_string($_POST['phone']);
  $position = $conn->real_escape_string($_POST['position']);
  $texp = $conn->real_escape_string($_POST['texp']);
  $rexp = $conn->real_escape_string($_POST['rexp']);
  $cctc = $conn->real_escape_string($_POST['cctc']);
  $ectc = $conn->real_escape_string($_POST['ectc']);
  $massage = $conn->real_escape_string($_POST['massage']);

  // Handle File Upload
  $resume_dir = "uploads/resume/";
  if (!is_dir($resume_dir)) {
    mkdir($resume_dir, 0777, true);
  }

  $resume_file = $resume_dir . basename($_FILES["resume"]["name"]);
  $resume_ext = strtolower(pathinfo($resume_file, PATHINFO_EXTENSION));

  // Allow only PDF files
  if ($resume_ext != "pdf") {
    die("Only PDF files are allowed.");
  }

  if (move_uploaded_file($_FILES["resume"]["tmp_name"], $resume_file)) {
    // Check if the user already applied (Update Instead of Insert)
    $check_query = "SELECT id FROM applicants WHERE email = '$email' AND position_applied = '$position'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
      // If exists, update the record
      echo "<script>alert('you are already sent application '); window.location.href='carrer.php';</script>";
    } else {
      // If new, insert the record
      $sql = "INSERT INTO applicants (full_name, email, position_applied, total_experience,relevant_experience,current_ctc,expected_ctc,message,resume_path) VALUES 
                                          ('$full_name', '$email', '$position','$texp','$rexp','$cctc','$ectc','$massage', '$resume_file')";
    }

    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Application Submitted Successfully!'); window.location.href='carrer.php';</script>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "Error uploading file.";
  }
}

$conn->close();
?>


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
    <a href="hireteam.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Hire Team</a>
    <a href="portfolio.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Portfolio</a>
    <a href="product.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Product</a>
    <a href="about.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">About</a>
    <a href="carrer.php" class="text-base font-medium text-white hover:text-primary transition-colors duration-300 nav-link">Careers</a>
    <a href="contact.php" class="btn text-sm sm:text-base py-2 px-4 sm:py-3 sm:px-6">Contact Us</a>
  </nav>
</div>
</header>

 
  <!-- Careers Section -->
<section id="carrers" class="pt-24 sm:pt-28 py-16 sm:py-22 relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6">
      <div class="mb-12 sm:mb-16 reveal">
        <h2 class="text-2xl sm:text-3xl font-bold mb-4">JOIN OUR TEAM</h2>
        <p class="text-gray-400 max-w-2xl">We're always looking for talented individuals to join our growing team. Check out our current openings below.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="career-card p-6 bg-gray-900/30 rounded-lg hover:bg-gray-900/50 transition-all duration-300 reveal" style="transition-delay: 100ms;">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold">Senior Frontend Developer</h3>
            <span class="px-3 py-1 bg-primary/20 text-primary text-xs rounded-full">OnSite</span>
          </div>
          <p class="text-gray-400 mb-4">
            We're looking for an experienced frontend developer with expertise in React, Node.js, and modern CSS frameworks.
          </p>
          <div class="flex flex-wrap gap-2 mb-4">
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">React</span>
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Node.js</span>
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">TypeScript</span>
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Tailwind CSS</span>
          </div>
          <button onclick="openCareerModal(this)" data-position="Senior Frontend Developer" class="btn inline-flex items-center">
            Apply Now
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </button>
        </div>

        <div class="career-card p-6 bg-gray-900/30 rounded-lg hover:bg-gray-900/50 transition-all duration-300 reveal" style="transition-delay: 200ms;">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold">UX/UI Designer</h3>
            <span class="px-3 py-1 bg-primary/20 text-primary text-xs rounded-full">On Site</span>
          </div>
          <p class="text-gray-400 mb-4">
            Join our design team to create beautiful, intuitive interfaces that delight users and solve complex problems.
          </p>
          <div class="flex flex-wrap gap-2 mb-4">
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Figma</span>
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Adobe XD</span>
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Prototyping</span>
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">User Research</span>
          </div>
          <button onclick="openCareerModal(this)" data-position="UX/UI Designer" class="btn inline-flex items-center">
            Apply Now
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </button>
        </div>

        <div class="career-card p-6 bg-gray-900/30 rounded-lg hover:bg-gray-900/50 transition-all duration-300 reveal" style="transition-delay: 300ms;">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold">Backend Developer</h3>
            <span class="px-3 py-1 bg-primary/20 text-primary text-xs rounded-full">On Site</span>
          </div>
          <p class="text-gray-400 mb-4">
            We're seeking a backend developer with experience in Node.js, Python, and database management.
          </p>
          <div class="flex flex-wrap gap-2 mb-4">
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Node.js</span>
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">C#</span>
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">MongoDB</span>
            <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Php</span>
          </div>
          <button onclick="openCareerModal(this)" data-position="Backend Developer" class="btn inline-flex items-center">
            Apply Now
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </button>
        </div>

      <div class="career-card p-6 bg-gray-900/30 rounded-lg hover:bg-gray-900/50 transition-all duration-300 reveal" style="transition-delay: 400ms;">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold">Business Development Executive</h3>
            <span class="px-3 py-1 bg-primary/20 text-primary text-xs rounded-full">OnSite</span>
          </div>
          <p class="text-gray-400 mb-4">
          Drive business development efforts by leading project teams to deliver high-quality digital products on time and within budget.
          </p>
          <div class="flex flex-wrap gap-2 mb-4">
          <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Lead Generation</span>
<span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Sales Strategy</span>
<span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Market Research</span>
<span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">Client Relationship</span>

          </div>
          <button onclick="openCareerModal(this)" data-position="Project Manager" class="btn inline-flex items-center">
            Apply Now
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </button>
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

  <!-- Career Application Modal -->
  <div id="career-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-black opacity-80"></div>
      </div>
      <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-gray-900 rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full md:max-w-xl">
        <div class="relative p-6 sm:p-8">
          <button type="button" onclick="closeCareerModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          <h3 class="text-xl sm:text-2xl font-bold mb-6 text-white career-modal-title">Apply For Position</h3>
          <form class="space-y-4" id="career-form" action="carrer.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="application-position" name="position">

            <div class="form-input">
              <input type="text" name="full_name" id="application-name" placeholder=" " required>
              <label for="application-name">Full Name</label>
            </div>

            <div class="form-input">
              <input type="email" name="email" id="application-email" placeholder=" " required>
              <label for="application-email">Email Address</label>
            </div>

            <div class="form-input">
              <input type="tel" name="phone" id="application-phone" placeholder=" " required>
              <label for="application-phone">Phone Number</label>
            </div>

            <div class="form-input">
              <select id="application-position-select" name="position" required>
                <option value="" selected disabled hidden>Select a position</option>
                <option value="Senior Frontend Developer">Senior Frontend Developer</option>
                <option value="UX/UI Designer">UX/UI Designer</option>
                <option value="Backend Developer">Backend Developer</option>
                <option value="Project Manager">Project Manager</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="form-input">
                <input type="number" name="texp" id="application-total-experience" placeholder=" " required>
                <label for="application-total-experience">Total Experience (years)</label>
              </div>

              <div class="form-input">
                <input type="number" name="rexp" id="application-relevant-experience" placeholder=" " required>
                <label for="application-relevant-experience">Relevant Experience (years)</label>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="form-input">
                <input type="number" name="cctc" id="application-current-ctc" placeholder=" " required>
                <label for="application-current-ctc">Current CTC (USD)</label>
              </div>

              <div class="form-input">
                <input type="number" name="ectc" id="application-expected-ctc" placeholder=" " required>
                <label for="application-expected-ctc">Expected CTC (USD)</label>
              </div>
            </div>

            <div class="form-input">
              <textarea id="application-message" name="massage" rows="3" placeholder=" "></textarea>
              <label for="application-message">Message (Optional)</label>
            </div>

            <div class="mt-4">
              <label class="block text-sm font-medium text-gray-400 mb-2">Upload Resume</label>
              <div class="flex items-center justify-center w-full">
                <label class="flex flex-col w-full h-32 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer hover:bg-gray-800/30 transition-all">
                  <div class="flex flex-col items-center justify-center pt-7">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-100">
                      Attach your resume (PDF, DOC, DOCX)
                    </p>
                  </div>
                  <input type="file" name="resume" class="opacity-0" id="resume-upload" accept=".pdf,.doc,.docx" required />
                </label>
              </div>
              <p class="mt-2 text-xs text-gray-500" id="file-name-display">No file selected</p>
            </div>

            <button type="submit" class="btn w-full mt-6">
              Submit Application
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>  
  <script type="text/javascript" src="script.js"></script>
</body>

</html>