<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI & Machine Learning Solutions - Technova Technologies</title>
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
                    AI & Machine Learning <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-pink-500">Solutions</span>
                </h1>
                <p class="text-xl sm:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed">Transform your business with intelligent AI and ML solutions that automate processes, predict outcomes, and deliver actionable insights for smarter decision-making.</p>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-20 bg-black relative">
        <div class="container mx-auto px-6 lg:px-12 xl:px-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h3 class="text-3xl font-bold text-white mb-6">Why Choose Our AI & ML Solutions?</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Intelligent Automation</h4>
                                <p class="text-gray-300">Automate complex business processes with AI-powered solutions that learn and adapt to your needs.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Predictive Analytics</h4>
                                <p class="text-gray-300">Leverage machine learning models to forecast trends, predict outcomes, and make data-driven decisions.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Custom AI Models</h4>
                                <p class="text-gray-300">Tailored machine learning models designed specifically for your business requirements and data.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900/30 p-8 rounded-xl">
                    <h4 class="text-2xl font-bold text-white mb-6">Our Development Process</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">1</span>
                            <span class="text-gray-300">Data Assessment & Strategy</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">2</span>
                            <span class="text-gray-300">Model Design & Architecture</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">3</span>
                            <span class="text-gray-300">Training & Optimization</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">4</span>
                            <span class="text-gray-300">Integration & Deployment</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">5</span>
                            <span class="text-gray-300">Monitoring & Refinement</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">6</span>
                            <span class="text-gray-300">Continuous Learning & Support</span>
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
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-8">AI & ML Solutions</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">Cutting-edge artificial intelligence and machine learning services tailored to your business needs.</p>
            </div>
            <div class="space-y-16">
                <!-- Natural Language Processing -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-green-500/20 to-teal-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-green-500/30 to-teal-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Natural Language Processing</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Build intelligent chatbots, sentiment analysis tools, and language translation systems. Our NLP solutions understand and process human language to enhance customer interactions and automate text-based tasks.
                        </p>
                    </div>
                </div>

                <!-- Computer Vision -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Computer Vision</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Implement image recognition, object detection, and facial recognition systems. Our computer vision solutions enable machines to interpret and understand visual information from the world.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Predictive Analytics -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-orange-500/30 to-red-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Predictive Analytics</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Forecast future trends and behaviors using advanced machine learning algorithms. Our predictive models help businesses anticipate customer needs, optimize inventory, and reduce risks.
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
                <!-- Recommendation Systems -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Recommendation Systems</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Create personalized recommendation engines that suggest products, content, or services based on user behavior and preferences. Increase engagement and drive conversions with intelligent recommendations.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-500/30 to-cyan-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deep Learning -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-indigo-500/30 to-purple-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Deep Learning Solutions</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Develop neural networks and deep learning models for complex pattern recognition tasks. Our solutions handle unstructured data and solve challenging problems in image, speech, and text processing.
                        </p>
                    </div>
                </div>

                <!-- AI Chatbots -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">AI-Powered Chatbots</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Deploy intelligent conversational AI that understands context and provides human-like interactions. Our chatbots handle customer support, lead generation, and automate routine inquiries 24/7.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-pink-500/20 to-rose-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-pink-500/30 to-rose-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
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
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Transform Your Business with AI?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">Let's build intelligent solutions that drive innovation and deliver measurable results for your organization.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.php" class="bg-primary hover:bg-primary/80 px-8 py-4 rounded-full text-white font-semibold transition-all hover:transform hover:scale-105">Start Your Project</a>
                <a href="portfolio.php" class="border-2 border-primary hover:bg-primary px-8 py-4 rounded-full text-primary hover:text-white font-semibold transition-all hover:transform hover:scale-105">View Our Work</a>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
