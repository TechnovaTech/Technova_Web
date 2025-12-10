
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
        document.querySelectorAll('a, button, input, textarea, select, .tech-icon, .portfolio-item').forEach(function(item) {
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

      // Tilt Effect
      const tiltElements = document.querySelectorAll('.tilt');

      tiltElements.forEach(function(element) {
        element.addEventListener('mousemove', function(e) {
          const rect = element.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;

          const xc = rect.width / 2;
          const yc = rect.height / 2;

          const dx = x - xc;
          const dy = y - yc;

          element.style.transform = `perspective(1000px) rotateX(Rs.{-dy / 20}deg) rotateY(Rs.{dx / 20}deg) scale3d(1.02, 1.02, 1.02)`;
        });

        element.addEventListener('mouseleave', function() {
          element.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
        });
      });

      // Animated Counters
      const counters = document.querySelectorAll('.counter');

      function startCounting(counter) {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps

        let current = 0;
        const updateCounter = function() {
          current += step;
          if (current < target) {
            counter.textContent = Math.ceil(current);
            requestAnimationFrame(updateCounter);
          } else {
            counter.textContent = target;
          }
        };

        updateCounter();
      }

      const counterObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            startCounting(entry.target);
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.5
      });

      counters.forEach(function(counter) {
        counterObserver.observe(counter);
      });

      // Create stars for the hero section background
      const starsContainer = document.getElementById('stars-container');
      if (starsContainer) {
        for (let i = 0; i < 100; i++) {
          const star = document.createElement('div');
          star.className = 'star';
          star.style.width = `Rs.{Math.random() * 2 + 1}px`;
          star.style.height = star.style.width;
          star.style.position = 'absolute';
          star.style.left = `Rs.{Math.random() * 100}%`;
          star.style.top = `Rs.{Math.random() * 100}%`;
          star.style.background = 'white';
          star.style.borderRadius = '50%';
          star.style.opacity = `Rs.{Math.random() * 0.7 + 0.3}`;
          star.style.animation = `twinkle Rs.{Math.random() * 5 + 3}s infinite`;
          starsContainer.appendChild(star);
        }
      }

      // Fix navigation links
      document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function(e) {
          const href = this.getAttribute('href');
          if (href.startsWith('#')) {
            const targetSection = document.querySelector(href);
            if (!targetSection) {
              e.preventDefault();
              console.log(`Section Rs.{href} not found`);
            }
          }
        });
      });

      // Make portfolio items more responsive
      const portfolioItems = document.querySelectorAll('.portfolio-item');
      if (window.innerWidth < 640) {
        portfolioItems.forEach(item => {
          item.addEventListener('click', function() {
            this.querySelector('.portfolio-overlay').style.opacity = '1';
            setTimeout(() => {
              this.querySelector('.portfolio-overlay').style.opacity = '';
            }, 3000);
          });
        });
      }

      // Add animation keyframes for twinkling stars
      const styleSheet = document.createElement('style');
      styleSheet.type = 'text/css';
      styleSheet.innerText = `
        @keyframes twinkle {
          0% { opacity: 0.3; }
          50% { opacity: 1; }
          100% { opacity: 0.3; }
        }
      `;
      document.head.appendChild(styleSheet);
    });

    // Career Application Modal Functions
    function openCareerModal(button) {
      const position = button.getAttribute('data-position');
      const modal = document.getElementById('career-modal');
      const titleElement = modal.querySelector('.career-modal-title');
      const positionInput = document.getElementById('application-position');
      const positionSelect = document.getElementById('application-position-select');

      // Set the position in the hidden input and select dropdown
      positionInput.value = position;

      // Try to select the matching option in the dropdown
      for (let i = 0; i < positionSelect.options.length; i++) {
        if (positionSelect.options[i].value === position) {
          positionSelect.selectedIndex = i;
          break;
        }
      }

      // Update the modal title
      titleElement.textContent = `Apply for ${position}`;

      // Show the modal
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeCareerModal() {
      const modal = document.getElementById('career-modal');
      modal.classList.add('hidden');
      document.body.style.overflow = ''; // Re-enable scrolling

      // Reset the form
      document.getElementById('career-form').reset();
      document.getElementById('file-name-display').textContent = 'No file selected';
    }

    // Handle resume file selection
    document.addEventListener('DOMContentLoaded', function() {
      const fileInput = document.getElementById('resume-upload');
      const fileNameDisplay = document.getElementById('file-name-display');

      if (fileInput && fileNameDisplay) {
        fileInput.addEventListener('change', function() {
          if (this.files && this.files[0]) {
            fileNameDisplay.textContent = this.files[0].name;
            fileNameDisplay.style.color = 'var(--primary)';
          } else {
            fileNameDisplay.textContent = 'No file selected';
            fileNameDisplay.style.color = '';
          }
        });
      }
    });

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
      const modal = document.getElementById('career-modal');
      if (modal) {
        modal.addEventListener('click', function(e) {
          if (e.target === this) {
            closeCareerModal();
          }
        });
      }
    });
// Mobile Menu Toggle
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden'); // Toggle visibility
    });
}

  //submit alert 

  document.getElementById("contact-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(this); // Get form data

    fetch("contact_add.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            showCustomAlert(data.message, "success"); // Show success alert
            this.reset(); // Reset form after success
        } else {
            showCustomAlert(data.message, "error"); // Show error alert
        }
    })
    .catch(error => {
        showCustomAlert("Something went wrong!", "error");
        console.error("Error:", error);
    });
});

// Custom animated alert function
function showCustomAlert(message, type = "success") {
    let alertBox = document.createElement("div");
    alertBox.textContent = message;
    alertBox.classList.add("custom-alert", type);
    
    document.body.appendChild(alertBox);

    setTimeout(() => {
        alertBox.classList.add("fade-out");
        setTimeout(() => alertBox.remove(), 500); // Remove alert after animation
    }, 3000);
}


// Whatsapp icon

document.addEventListener("DOMContentLoaded", function () {
  const whatsappBtn = document.getElementById("whatsapp-btn");

  window.addEventListener("scroll", function () {
    if (window.scrollY > 200) {  // Show after 200px scroll
      whatsappBtn.classList.add("show-whatsapp");
    } else {
      whatsappBtn.classList.remove("show-whatsapp");
    }
  });
});



// function closeCustomAlert() {
//   document.getElementById('custom-alert').classList.add('hidden');
// }
window.addEventListener('scroll', function() {
    const drawer = document.getElementById('whatsappDrawer');
    if (window.scrollY > 100) { // Change this value to adjust when the drawer appears
        drawer.classList.add('show');
    } else {
        drawer.classList.remove('show');
    }
});
  
  
  
  document.addEventListener('DOMContentLoaded', function () {
        window.addEventListener('scroll', function () {
            console.log("Scroll event fired! Y Offset:", window.scrollY); // Debugging log
            const drawer = document.getElementById('whatsappDrawer');
            if (drawer) {
                if (window.scrollY > 100) {
                    console.log("Adding .show class");
                    drawer.classList.add('show');
                } else {
                    console.log("Removing .show class");
                    drawer.classList.remove('show');
                }
            } else {
                console.error("whatsappDrawer element not found");
            }
        });
    });
    
    
    
    
    
    
