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
            <h1 class="text-5xl font-bold text-white mb-6">UI/UX <span class="text-primary">Design</span></h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">Beautiful interfaces and exceptional user experiences that convert</p>
        </div>
    </section>

    <!-- Technologies -->
    <section class="py-16 bg-black">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-white text-center mb-12">Design Tools & Services</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Figma</h3>
                    <p class="text-gray-300 mb-4">Collaborative design tool for modern teams</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Real-time Collaboration</li>
                        <li>• Prototyping</li>
                        <li>• Design Systems</li>
                        <li>• Developer Handoff</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Adobe XD</h3>
                    <p class="text-gray-300 mb-4">Vector-based user experience design tool</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Wireframing</li>
                        <li>• Interactive Prototypes</li>
                        <li>• Voice Prototyping</li>
                        <li>• Creative Cloud Integration</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Sketch</h3>
                    <p class="text-gray-300 mb-4">Digital design toolkit for Mac</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Vector Editing</li>
                        <li>• Symbol Libraries</li>
                        <li>• Plugin Ecosystem</li>
                        <li>• Responsive Design</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Photoshop</h3>
                    <p class="text-gray-300 mb-4">Industry-standard image editing software</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Photo Manipulation</li>
                        <li>• Digital Art</li>
                        <li>• Web Design</li>
                        <li>• Asset Creation</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Illustrator</h3>
                    <p class="text-gray-300 mb-4">Vector graphics and illustration software</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Logo Design</li>
                        <li>• Icon Creation</li>
                        <li>• Typography</li>
                        <li>• Brand Identity</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">UX Research</h3>
                    <p class="text-gray-300 mb-4">User research and testing methodologies</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• User Interviews</li>
                        <li>• Usability Testing</li>
                        <li>• Analytics Review</li>
                        <li>• A/B Testing</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-primary/10">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Ready to Design Amazing Experiences?</h2>
            <a href="contact.php" class="bg-primary hover:bg-primary/80 px-8 py-4 rounded-full text-white font-semibold transition-all">Get Started</a>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>