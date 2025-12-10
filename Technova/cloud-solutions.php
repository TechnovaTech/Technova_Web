<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Solutions - Technova Technologies</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#E11D48' },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 2s infinite',
                    }
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
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-8 leading-tight">
                    Cloud <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-pink-500">Solutions</span>
                </h1>
                <p class="text-xl sm:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed">Deploy and scale your applications with cloud infrastructure. We provide cloud migration, DevOps, and infrastructure management services using leading cloud platforms.</p>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-20 bg-black relative">
        <div class="container mx-auto px-6 lg:px-12 xl:px-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h3 class="text-3xl font-bold text-white mb-6">Why Choose Our Cloud Solutions?</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Scalable Infrastructure</h4>
                                <p class="text-gray-300">Auto-scaling capabilities that grow with your business needs, ensuring optimal performance at all times.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Enterprise Security</h4>
                                <p class="text-gray-300">Advanced security measures including encryption, access controls, and compliance with industry standards.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">High Performance</h4>
                                <p class="text-gray-300">Optimized cloud architecture with load balancing and CDN integration for lightning-fast delivery.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900/30 p-8 rounded-xl">
                    <h4 class="text-2xl font-bold text-white mb-6">Cloud Platforms We Work With</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                            <span class="text-primary font-semibold text-lg">AWS</span>
                        </div>
                        <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                            <span class="text-primary font-semibold text-lg">Azure</span>
                        </div>
                        <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                            <span class="text-primary font-semibold text-lg">Google Cloud</span>
                        </div>
                        <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                            <span class="text-primary font-semibold text-lg">Docker</span>
                        </div>
                        <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                            <span class="text-primary font-semibold text-lg">Kubernetes</span>
                        </div>
                        <div class="bg-gray-800/50 p-4 rounded-lg text-center">
                            <span class="text-primary font-semibold text-lg">DevOps</span>
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
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-8">Our Cloud Services</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">Comprehensive cloud solutions using industry-leading platforms and technologies.</p>
            </div>
            <div class="space-y-16">
                <!-- AWS -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-orange-500/20 to-yellow-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-orange-500/30 to-yellow-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Cloud Consulting</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Our cloud consulting services help identify the right strategy and infrastructure for your business. Through in-depth analysis, we develop scalable cloud application solutions that ensure a solid return on your technology investment.
                        </p>
                    </div>
                </div>

                <!-- Azure -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Cloud Application Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            We create robust, scalable, and future-ready cloud applications using the latest cloud-native technologies. With hands-on expertise in cloud-based software development, our services are built to boost agility, performance, and efficiency.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-500/30 to-cyan-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Cloud -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-red-500/20 to-yellow-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-red-500/30 to-yellow-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Implementation & Migration</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Technova enables seamless cloud adoption with expert implementation and cloud migration services. We minimize downtime and ensure secure data transfer, helping businesses transition apps, workflows, or entire infrastructure to the cloud efficiently.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Services -->
    <section class="py-20 bg-black relative">
        <div class="container mx-auto px-6 lg:px-12 xl:px-20">
            <div class="space-y-16">
                <!-- Docker & Kubernetes -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Cloud Security & Risk Management</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Security is a cornerstone of any cloud strategy. We integrate comprehensive security frameworks— including risk management, identity access controls, and security audits—into all our cloud applications to protect your data and systems.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-500/30 to-purple-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DevOps & CI/CD -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-green-500/20 to-teal-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-green-500/30 to-teal-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Cloud Monitoring & Support</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Our monitoring and support solutions provide real-time insights, performance tracking, and proactive issue resolution. With advanced analytics and industry-standard tools, we ensure optimal uptime and system reliability.
                        </p>
                    </div>
                </div>

                <!-- Cloud Migration -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Cloud Architecture Design</h3>
                        <p class="text-gray-300 leading-relaxed">
                            We design cloud architecture that aligns with business priorities and supports multi-cloud environments. Our cloud solutions include a tailored strategy, technical blueprint, and detailed implementation plan.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
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
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Move to the Cloud?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">Let's build scalable, secure cloud infrastructure that powers your business growth and innovation.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.php" class="bg-primary hover:bg-primary/80 px-8 py-4 rounded-full text-white font-semibold transition-all hover:transform hover:scale-105">Start Your Project</a>
                <a href="portfolio.php" class="border-2 border-primary hover:bg-primary px-8 py-4 rounded-full text-primary hover:text-white font-semibold transition-all hover:transform hover:scale-105">View Our Work</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-grey py-12 sm:py-16 border-t border-gray-800">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-12">
                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-4 text-grey-600">Contact Us</h3>
                    <p class="text-gray-200 mb-2"><strong>Email:</strong> <a href="mailto:info@technovatechnologies.com" class="text-gray-200 hover:text-red-600">info@technovatechnologies.com</a></p>
                    <p class="text-gray-200 mb-2"><strong>Phone:</strong> <a href="tel:+91 94273 00816" class="text-gray-200 hover:text-red-600">+91 94273 00816</a></p>
                    <p class="text-gray-200 mb-2"><strong>Address:</strong> 608 - Time Square Commercial Complex</p>
                    <p class="text-gray-200"> Near Ayodhya Chowk, 150 Feet Ring Rd, Rajkot, Gujarat 360007</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-4 text-gery-600">Services</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">Web Development</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">App Development</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">Web Design</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">ERP Development</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">SEO Development</a></li>
                    </ul>
                </div>
                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-4 text-grey-600">Our Technologies</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">ASP.NET</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">MERN Stack</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">PHP,My SQL</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">Cloud Computing</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-red-600 transition-colors duration-300">Angular</a></li>
                    </ul>
                </div>
            </div>
            <div class="flex justify-between items-center pt-8 border-t border-gray-800">
                <div class="container mx-auto text-center">
                    <p class="mt-4 text-sm">&copy; 2025 Technova Technologies. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
