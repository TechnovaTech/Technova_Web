<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Solutions - Technova Technologies</title>
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
                    E-Commerce <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-pink-500">Solutions</span>
                </h1>
                <p class="text-xl sm:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed">Build powerful online stores with secure payments, inventory management, and seamless shopping experiences that drive sales and customer satisfaction.</p>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-20 bg-black relative">
        <div class="container mx-auto px-6 lg:px-12 xl:px-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h3 class="text-3xl font-bold text-white mb-6">Why Choose Our E-Commerce Solutions?</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Secure Payment Processing</h4>
                                <p class="text-gray-300">Multiple payment gateways with PCI compliance, SSL encryption, and fraud protection for safe transactions.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Advanced Analytics</h4>
                                <p class="text-gray-300">Real-time insights into sales, customer behavior, and inventory to make data-driven business decisions.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Mobile-First Design</h4>
                                <p class="text-gray-300">Responsive stores optimized for mobile shopping, ensuring seamless experiences across all devices.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900/30 p-8 rounded-xl">
                    <h4 class="text-2xl font-bold text-white mb-6">Our Development Process</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">1</span>
                            <span class="text-gray-300">Business Requirements Analysis</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">2</span>
                            <span class="text-gray-300">Platform Selection & Setup</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">3</span>
                            <span class="text-gray-300">Custom Design & Development</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">4</span>
                            <span class="text-gray-300">Payment Gateway Integration</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">5</span>
                            <span class="text-gray-300">Testing & Quality Assurance</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">6</span>
                            <span class="text-gray-300">Launch & Ongoing Support</span>
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
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-8">E-Commerce Platform Solutions</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">We build custom e-commerce solutions on leading platforms tailored to your business needs.</p>
            </div>
            <div class="space-y-16">
                <!-- Shopify -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-green-500/20 to-teal-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-green-500/30 to-teal-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">eCommerce Website Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Customized development of dynamic, mobile-optimized, user-friendly eCommerce web development solutions with support for multiple currencies, Payment Gateway integration, Secure Checkout, Sales Analytics, and Order Management. We make it simple for retailers to move from the brick-and-mortar model to the click-and-collect model with a seamless eCommerce website development approach.
                        </p>
                    </div>
                </div>

                <!-- eCommerce Mobile App -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">eCommerce Mobile App Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Our eCommerce app developers have the highest level of expertise in creating efficient, safe, and user-friendly solutions for eCommerce mobile app development. We know how to use the most recent technologies and tools to help you develop an eCommerce app that gives your customers the best possible shopping experience.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Magento -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-orange-500/30 to-red-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Multi-Vendor Marketplace Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Multiple vendors can sell a wide range of physical goods through the online multi-vendor marketplace. The one-stop shop meets all customers' needs, creates memorable experiences, and offers attractive discounts. Build B2C or B2B multi-vendor marketplaces that let customers place a single order for multiple sellers' products.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Solutions -->
    <section class="py-20 bg-black relative">
        <div class="container mx-auto px-6 lg:px-12 xl:px-20">
            <div class="space-y-16">
                <!-- Inventory and Supply Chain -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Inventory and Supply Chain Management Software</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Build effective eCommerce supply chain management solutions with our top-notch expertise. Our real-time and customer-centric end-to-end eCommerce development solutions will help your company achieve autonomous supply chain management and increase logistics efficiency.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-500/30 to-cyan-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Custom Solutions -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-indigo-500/30 to-purple-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">eCommerce Promotional Activities</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Our eCommerce marketing solutions include SEO, PPC, social media optimization (SMO), content marketing, email marketing, and many other methods. We specialize in comprehending your brand's concept, developing a well-known brand image on social media and search engines, and driving significant website traffic.
                        </p>
                    </div>
                </div>

                <!-- Plugin Development -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Plugin Development</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Our developers focus on providing premium plugin customization and development services that meet all your business needs. To combine our inventiveness with cutting-edge technology, our team stays abreast of the most recent technological developments.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-pink-500/20 to-rose-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-pink-500/30 to-rose-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
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
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Launch Your Online Store?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">Let's build a powerful e-commerce platform that drives sales and delivers exceptional shopping experiences.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.php" class="bg-primary hover:bg-primary/80 px-8 py-4 rounded-full text-white font-semibold transition-all hover:transform hover:scale-105">Start Your Project</a>
                <a href="portfolio.php" class="border-2 border-primary hover:bg-primary px-8 py-4 rounded-full text-primary hover:text-white font-semibold transition-all hover:transform hover:scale-105">View Our Work</a>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
