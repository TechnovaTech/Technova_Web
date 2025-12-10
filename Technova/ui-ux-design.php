<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UI/UX Design - Technova Technologies</title>
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
                    UI/UX <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-pink-500">Design</span> Services
                </h1>
                <p class="text-xl sm:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed">Create beautiful interfaces and exceptional user experiences that engage users, drive conversions, and build lasting brand connections.</p>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-20 bg-black relative">
        <div class="container mx-auto px-6 lg:px-12 xl:px-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <h3 class="text-3xl font-bold text-white mb-6">Why Choose Our UI/UX Design Services?</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">User-Centered Design</h4>
                                <p class="text-gray-300">Research-driven designs focused on user needs, behaviors, and pain points for optimal experiences.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Beautiful Aesthetics</h4>
                                <p class="text-gray-300">Stunning visual designs that align with your brand identity and create memorable impressions.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-white mb-2">Conversion Optimization</h4>
                                <p class="text-gray-300">Strategic design decisions that guide users toward desired actions and maximize conversions.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900/30 p-8 rounded-xl">
                    <h4 class="text-2xl font-bold text-white mb-6">Our Design Process</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">1</span>
                            <span class="text-gray-300">Research & Discovery</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">2</span>
                            <span class="text-gray-300">Wireframing & Information Architecture</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">3</span>
                            <span class="text-gray-300">Visual Design & Branding</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">4</span>
                            <span class="text-gray-300">Interactive Prototyping</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">5</span>
                            <span class="text-gray-300">Usability Testing</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">6</span>
                            <span class="text-gray-300">Design Handoff & Support</span>
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
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-8">Our Design Services</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">Comprehensive UI/UX design solutions using industry-leading tools and methodologies.</p>
            </div>
            <div class="space-y-16">
                <!-- Figma Design -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">UI/UX Consulting</h3>
                        <p class="text-gray-300 leading-relaxed">
                            With years of expertise, we are a trusted UI/UX design service company that helps businesses create engaging designs. Our professional UI designers stay updated with the latest trends and best practices, ensuring systematic, highly functional, and reliable designs when you hire our UI/UX experts.
                        </p>
                    </div>
                </div>

                <!-- Adobe XD -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Web & Mobile UI/UX Design</h3>
                        <p class="text-gray-300 leading-relaxed">
                            We specialize in UI/UX web and mobile design, ensuring seamless experiences across all devices. Our approach enhances user satisfaction and retention by optimizing digital products for usability, accessibility, and aesthetics.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-pink-500/20 to-purple-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-pink-500/30 to-purple-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UX Research -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-500/30 to-cyan-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">MVP Design</h3>
                        <p class="text-gray-300 leading-relaxed">
                            An MVP design lays the foundation for your product's success. A new idea is just the seed of a vision. We create intuitive layouts, smooth navigation, and engaging designs that resonate with target users, enabling businesses to validate ideas during development and secure investor confidence before the final release.
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
                <!-- Sketch Design -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Wireframe Design</h3>
                        <p class="text-gray-300 leading-relaxed">
                            A well-defined wireframe design process ensures a smooth transition from concept to final product. We provide detailed UI/UX design services, helping businesses visualize application flow and refine concepts before full-scale development, saving valuable time and resources.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-orange-500/20 to-yellow-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-orange-500/30 to-yellow-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Adobe Creative Suite -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-red-500/20 to-pink-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-red-500/30 to-pink-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <h3 class="text-3xl font-bold text-white mb-6">Prototype Design</h3>
                        <p class="text-gray-300 leading-relaxed">
                            As one of the leading UI/UX design service companies, we create high-fidelity prototypes that closely replicate real-world interactions for an exceptional user experience. We guide businesses through multiple design stages to gather valuable user feedback, ensuring the final product resonates with customers.
                        </p>
                    </div>
                </div>

                <!-- Design Systems -->
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-6">Research & Testing</h3>
                        <p class="text-gray-300 leading-relaxed">
                            By conducting in-depth user experience research and rigorous product testing, we ensure digital solutions meet industry standards. Data-driven insights help optimize functionality, engagement, and overall satisfaction.
                        </p>
                    </div>
                    <div>
                        <div class="bg-gradient-to-br from-green-500/20 to-teal-500/20 rounded-3xl p-1">
                            <div class="bg-black rounded-3xl p-8 h-64 flex items-center justify-center">
                                <div class="w-32 h-32 bg-gradient-to-br from-green-500/30 to-teal-500/30 rounded-2xl flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
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
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Design Amazing Experiences?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">Let's create beautiful, user-centered designs that engage your audience and drive business results.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="contact.php" class="bg-primary hover:bg-primary/80 px-8 py-4 rounded-full text-white font-semibold transition-all hover:transform hover:scale-105">Start Your Project</a>
                <a href="portfolio.php" class="border-2 border-primary hover:bg-primary px-8 py-4 rounded-full text-primary hover:text-white font-semibold transition-all hover:transform hover:scale-105">View Our Work</a>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
