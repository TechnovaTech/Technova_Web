<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Development - Technova Technologies</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#E11D48' },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body>
    <!-- Header -->
    <header class="fixed top-0 w-full z-50 bg-black/90 backdrop-blur-md">
        <div class="container mx-auto px-4 flex h-20 items-center justify-between">
            <a href="index.php"><img src="logo.svg" alt="Logo" class="h-10"></a>
            <nav class="hidden md:flex gap-8">
                <a href="index.php" class="text-white hover:text-primary">Home</a>
                <a href="service.php" class="text-white hover:text-primary">Services</a>
                <a href="technology.php" class="text-white hover:text-primary">Technologies</a>
                <a href="about.php" class="text-white hover:text-primary">About</a>
            </nav>
            <a href="contact.php" class="btn">Contact Us</a>
        </div>
    </header>

    <!-- Hero -->
    <section class="pt-32 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-black"></div>
        <div class="absolute inset-0" style="background: radial-gradient(circle at 30% 20%, rgba(225, 29, 72, 0.15), transparent 50%), radial-gradient(circle at 70% 80%, rgba(225, 29, 72, 0.1), transparent 50%);"></div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-primary/3 rounded-full blur-3xl animate-bounce"></div>
        
        <div class="container mx-auto px-6 lg:px-12 xl:px-20 relative z-10">
            <div class="text-center max-w-6xl mx-auto">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-8 leading-tight">
                    Web <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-pink-500">Development</span> Services
                </h1>
                <p class="text-xl sm:text-2xl text-gray-300 max-w-4xl mx-auto mb-12 leading-relaxed">Transform your business with custom web applications, responsive websites, and scalable solutions built with cutting-edge technologies. We deliver high-performance web experiences that drive growth and engagement.</p>
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <span class="bg-gradient-to-r from-primary/20 to-pink-500/20 backdrop-blur-sm px-6 py-3 rounded-full text-primary font-semibold border border-primary/30 hover:border-primary/50 transition-all duration-300">Custom Development</span>
                    <span class="bg-gradient-to-r from-primary/20 to-pink-500/20 backdrop-blur-sm px-6 py-3 rounded-full text-primary font-semibold border border-primary/30 hover:border-primary/50 transition-all duration-300">Responsive Design</span>
                    <span class="bg-gradient-to-r from-primary/20 to-pink-500/20 backdrop-blur-sm px-6 py-3 rounded-full text-primary font-semibold border border-primary/30 hover:border-primary/50 transition-all duration-300">API Integration</span>
                    <span class="bg-gradient-to-r from-primary/20 to-pink-500/20 backdrop-blur-sm px-6 py-3 rounded-full text-primary font-semibold border border-primary/30 hover:border-primary/50 transition-all duration-300">Performance Optimization</span>
                </div>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="contact.php" class="group bg-gradient-to-r from-primary to-pink-600 hover:from-pink-600 hover:to-primary px-10 py-4 rounded-full text-white font-semibold transition-all duration-300 hover:transform hover:scale-105 hover:shadow-lg hover:shadow-primary/30 flex items-center justify-center gap-3">
                        Get Free Consultation
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="portfolio.php" class="group border-2 border-primary hover:bg-primary px-10 py-4 rounded-full text-primary hover:text-white font-semibold transition-all duration-300 hover:transform hover:scale-105 flex items-center justify-center gap-3">
                        View Portfolio
                        <svg class="w-5 h-5 group-hover:rotate-45 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-20 bg-black relative">
        <div class="container mx-auto px-6 lg:px-12 xl:px-20">
            
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h3 class="text-3xl font-bold text-white mb-6">Why Choose Our Web Development Services?</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Lightning Fast Performance</h4>
                                <p class="text-gray-300">Optimized code and modern frameworks ensure your website loads quickly and performs seamlessly across all devices.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Enterprise-Grade Security</h4>
                                <p class="text-gray-300">Advanced security measures protect your data and users with SSL certificates, secure coding practices, and regular updates.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Scalable Architecture</h4>
                                <p class="text-gray-300">Built to grow with your business, our solutions can handle increased traffic and expanding functionality requirements.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900/30 p-8 rounded-xl">
                    <h4 class="text-2xl font-bold text-white mb-6">Our Development Process</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">1</span>
                            <span class="text-gray-300">Requirements Analysis & Planning</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">2</span>
                            <span class="text-gray-300">UI/UX Design & Prototyping</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">3</span>
                            <span class="text-gray-300">Frontend & Backend Development</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">4</span>
                            <span class="text-gray-300">Testing & Quality Assurance</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">5</span>
                            <span class="text-gray-300">Deployment & Launch</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">6</span>
                            <span class="text-gray-300">Maintenance & Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Offerings -->
    <section class="py-20 bg-gradient-to-b from-gray-900/10 to-gray-900/30 relative">
        <div class="container mx-auto px-6 lg:px-12 xl:px-20">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-8">Our Offerings</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">At Technova, our dedicated web developers provide top-notch, user-friendly website design and development services to enhance your business conversions.</p>
            </div>
            <div class="space-y-16">
                <!-- Custom Web Development -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Custom Web Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Our custom web development solutions are robust and scalable, designed to meet your specific business needs with improved functionality, speed, and performance. We offer a range of solutions that leverage modern technologies and multiple platforms, ensuring you receive the best possible development service tailored to your specific requirements.
                        </p>
                    </div>
                </div>

                <!-- E-Commerce Development -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">E-Commerce Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            We simplify eCommerce development by providing merchants with robust solutions using cutting-edge technologies and frameworks. Our goal is to build high-performing online stores that deliver seamless shopping experiences for customers. With our expertise, we help you build a strong online presence.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-green-500/20 to-teal-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-green-500/30 to-teal-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Full Stack Development -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-yellow-500/20 to-orange-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-yellow-500/30 to-orange-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Full Stack Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Full stack development involves end-to-end web processing for web and desktop applications. On the frontend, we utilize Angular and React, while on the backend, we specialize in Node.js, Laravel, and Python. We provide comprehensive full-stack solutions tailored to meet your business objectives.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Development Services -->
    <section class="py-20 bg-black relative">
        <div class="container mx-auto px-6 lg:px-12 xl:px-20">
            <div class="space-y-16">
                <!-- MEAN Stack Development -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">MEAN Stack Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            We build dynamic applications using MongoDB, Express.js, Angular, and Node.js. This powerful combination enables us to create seamless business processes, enhance efficiency, and deliver scalable digital platforms.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-500/30 to-cyan-500/30 rounded-2xl flex items-center justify-center">
                                    <span class="text-4xl font-bold text-primary">ME</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MERN Stack Development -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-cyan-500/20 to-blue-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-cyan-500/30 to-blue-500/30 rounded-2xl flex items-center justify-center">
                                    <span class="text-4xl font-bold text-primary">ME</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">MERN Stack Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            We empower businesses to stay ahead of the competition by building robust and scalable enterprise-level MERN stack development services. Our dedicated website developers expertly utilize MongoDB, Express.js, React, and Node.js technologies to address your business's critical needs.
                        </p>
                    </div>
                </div>

                <!-- Open Source Development -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Open Source Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            We offer customized, high-end open-source development services to businesses across various industries. Our team of skilled developers uses current processes by providing integrated services, cost-consulting to development.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-purple-500/20 to-indigo-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-purple-500/30 to-indigo-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Full Stack Development (Repeated) -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-yellow-500/20 to-orange-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-yellow-500/30 to-orange-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Full Stack Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Full stack development involves end-to-end web processing for web and desktop applications. On the frontend, we utilize Angular and React, while on the backend, we specialize in Node.js, Laravel, and Python. Our full-stack development services provide seamless solutions tailored to meet your business objectives.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-gradient-to-r from-primary/10 via-primary/5 to-pink-500/10 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-black/50 to-transparent"></div>
        <div class="absolute top-10 right-10 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-pink-500/10 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-6 lg:px-12 xl:px-20 text-center relative z-10">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Transform Your Business Online?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">Let's discuss your web development needs and create a solution that drives results for your business.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.php" class="bg-primary hover:bg-primary/80 px-8 py-4 rounded-full text-white font-semibold transition-all hover:transform hover:scale-105">Start Your Project</a>
                <a href="portfolio.php" class="border-2 border-primary hover:bg-primary px-8 py-4 rounded-full text-primary hover:text-white font-semibold transition-all hover:transform hover:scale-105">View Our Work</a>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>