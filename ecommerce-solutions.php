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
    <section class="pt-32 pb-16 bg-gradient-to-br from-black to-gray-900">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold text-white mb-6">E-Commerce <span class="text-primary">Solutions</span></h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">Powerful online stores with secure payments and inventory management</p>
        </div>
    </section>

    <!-- Technologies -->
    <section class="py-16 bg-black">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-white text-center mb-12">E-Commerce Platforms</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Shopify</h3>
                    <p class="text-gray-300 mb-4">Leading e-commerce platform for online stores</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Custom Themes</li>
                        <li>• App Integration</li>
                        <li>• Payment Gateways</li>
                        <li>• Inventory Management</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">WooCommerce</h3>
                    <p class="text-gray-300 mb-4">WordPress-based e-commerce solution</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• WordPress Integration</li>
                        <li>• Flexible Customization</li>
                        <li>• Plugin Ecosystem</li>
                        <li>• SEO Friendly</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Magento</h3>
                    <p class="text-gray-300 mb-4">Enterprise-level e-commerce platform</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Multi-store Management</li>
                        <li>• Advanced Features</li>
                        <li>• B2B Capabilities</li>
                        <li>• Scalable Architecture</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">BigCommerce</h3>
                    <p class="text-gray-300 mb-4">Cloud-based e-commerce platform</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Built-in Features</li>
                        <li>• API-first Approach</li>
                        <li>• Multi-channel Selling</li>
                        <li>• No Transaction Fees</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">PrestaShop</h3>
                    <p class="text-gray-300 mb-4">Open-source e-commerce solution</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Free & Open Source</li>
                        <li>• Module System</li>
                        <li>• Multi-language Support</li>
                        <li>• Community Driven</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Custom Solutions</h3>
                    <p class="text-gray-300 mb-4">Tailored e-commerce platforms for unique needs</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Custom Development</li>
                        <li>• Unique Features</li>
                        <li>• Third-party Integration</li>
                        <li>• Scalable Solutions</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-primary/10">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Ready to Launch Your Online Store?</h2>
            <a href="contact.php" class="bg-primary hover:bg-primary/80 px-8 py-4 rounded-full text-white font-semibold transition-all">Get Started</a>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>