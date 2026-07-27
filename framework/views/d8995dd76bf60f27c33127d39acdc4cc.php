<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - ICTRent</title>

    <link rel="stylesheet" href="<?php echo e(asset('css/welcome.css')); ?>">
    
</head>
<body>
    <div class="background">
        <img src="<?php echo e(asset('storage/image/logo.png')); ?>" alt="">
    </div>

    <nav>
        <div class="logo-section">
            <div class="logo-icon">ICT</div>
            <div class="logo-text">ICTRent </div>
        </div>

         <?php if(Route::has('login')): ?>
                <nav class="flex items-center justify-end gap-4">
                    <?php if(auth()->guard()->check()): ?>
                        <a
                            href="<?php echo e(route('dashboard')); ?>"
                            class="nav-btn btn-signin">Dashboard</a>
                        </a>
                    <?php else: ?>
                        <a
                            href="<?php echo e(route('login')); ?>"
                            class="nav-btn btn-signin">Log In</a>
                        </a>

                        <?php if(Route::has('register')): ?>
                            <a
                                href="<?php echo e(route('register')); ?>"
                                class="nav-btn btn-signup">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">🚀 ICT Equipment Rental</div>
            <h1>Easy Renting System For Better</h1>
            <p class="hero-description">
                Access for laptops, projectors, cables and others equipment for your best needs. Flexible rental terms.
            </p>
            <div class="cta-buttons">
                <a href="<?php echo e(route('login')); ?>" class="cta-btn btn-primary">
                    <span>Start Renting Now</span>
                    <div class="stat-label">Login</div>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="<?php echo e(url('/equip_avail')); ?>" class="cta-btn btn-secondary">Browse Equipment</a>
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="stat-item">
            <div class="stat-number">BEST</div>
            <div class="stat-label">Equipment Available</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">Equipment</div>
            <div class="stat-label">Great Condition</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">Services</div>
            <div class="stat-label">Best Service Support</div>
        </div>
    </section>

    <section class="features">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">💻</div>
                <h3>Latest Technology</h3>
                <p>Access the newest laptops, computers, and devices from top brands like Dell, HP.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Fast Response</h3>
                <p> Get your equipment when you need it most.</p>
            </div>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Great Condition</h3>
                <p>All equipment is in great condition with the most required system needed</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔧</div>
                <h3>Tech Support</h3>
                <p>Expert technical support available 24/7 to help you with setup and troubleshooting.</p>
            </div>
        </div>
    </section>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = this.getAttribute('href');
                
                // For demonstration, navigate to signin page
                // In production, you'd link to actual pages
                if (target === 'login') {
                    alert('This would navigate to your sign-in page. Replace this with: window.location.href = "signin.html";');
                } else if (target === 'register') {
                    alert('This would navigate to your sign-up page.');
                }
            });
        });
    </script>
</body>
</html><?php /**PATH C:\laragon\www\projectlaravel\resources\views/welcome.blade.php ENDPATH**/ ?>