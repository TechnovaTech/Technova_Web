<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Development - Technova Technologies</title>
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
            <h1 class="text-5xl font-bold text-white mb-6">Mobile <span class="text-primary">Development</span></h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">Native and cross-platform mobile applications for iOS and Android</p>
        </div>
    </section>

    <!-- Technologies -->
    <section class="py-16 bg-black">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-white text-center mb-12">Mobile Technologies</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Flutter</h3>
                    <p class="text-gray-300 mb-4">Google's UI toolkit for cross-platform mobile development</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Single Codebase</li>
                        <li>• Native Performance</li>
                        <li>• Hot Reload</li>
                        <li>• Material Design</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">React Native</h3>
                    <p class="text-gray-300 mb-4">Facebook's framework for building native mobile apps</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• JavaScript Based</li>
                        <li>• Code Reusability</li>
                        <li>• Live Reload</li>
                        <li>• Third-party Plugins</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Android</h3>
                    <p class="text-gray-300 mb-4">Native Android development with Java and Kotlin</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Android Studio</li>
                        <li>• Material Design</li>
                        <li>• Google Services</li>
                        <li>• Play Store Optimization</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">iOS</h3>
                    <p class="text-gray-300 mb-4">Native iOS development with Swift and Objective-C</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Xcode IDE</li>
                        <li>• Human Interface Guidelines</li>
                        <li>• App Store Connect</li>
                        <li>• Core Data</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Kotlin</h3>
                    <p class="text-gray-300 mb-4">Modern programming language for Android development</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Concise Syntax</li>
                        <li>• Java Interoperability</li>
                        <li>• Null Safety</li>
                        <li>• Coroutines</li>
                    </ul>
                </div>
                <div class="bg-gray-900/50 p-8 rounded-xl border border-gray-800 hover:border-primary/50 transition-all">
                    <h3 class="text-2xl font-bold text-primary mb-4">Swift</h3>
                    <p class="text-gray-300 mb-4">Apple's powerful programming language for iOS development</p>
                    <ul class="text-gray-400 space-y-2">
                        <li>• Type Safety</li>
                        <li>• Memory Management</li>
                        <li>• SwiftUI Framework</li>
                        <li>• Performance Optimized</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-primary/10">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Ready to Build Your Mobile App?</h2>
            <a href="contact.php" class="bg-primary hover:bg-primary/80 px-8 py-4 rounded-full text-white font-semibold transition-all">Get Started</a>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>