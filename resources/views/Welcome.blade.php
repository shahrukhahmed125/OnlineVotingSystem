<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pakistan Online Voting System | Secure Digital Elections</title>
    <link rel="icon" href="{{ asset('assets/img/emblem-of-the-election-commission-of-pakistan-logo-png_seeklogo-411520.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header/Navigation -->
    <header>
        <div class="container">
            <div class="logo">
                <img src="{{ asset('assets/img/emblem-of-the-election-commission-of-pakistan-logo-png_seeklogo-411520.png') }}" alt="Election Commission of Pakistan Logo">
                <h1>Pakistan Online Voting System</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#how-it-works">How It Works</a></li>
                    <li><a href="#security">Security</a></li>
                    <li><a href="#contact">Contact</a></li>
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        @elseif(auth()->user()->hasRole('candidate') || auth()->user()->hasRole('voter'))
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        @endif
                    @endauth

                    @guest
                        <li><a href="{{ route('login') }}" class="btn">Login</a></li>
                    @endguest
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h2>Secure Digital Voting for Pakistan's Future</h2>
                <p>A blockchain-based online voting system to ensure transparent, secure, and accessible elections across Pakistan.</p>
                <div class="hero-buttons">
                    <a href="{{route('register') }}" class="btn primary">Register to Vote</a>
                    <a href="#how-it-works" class="btn secondary">Learn More</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('assets/img/undraw_voting_3ygx.png') }}" alt="Online Voting Illustration" style="border-radius: 15px;">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2>Key Features</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Military-Grade Security</h3>
                    <p>End-to-end encryption and blockchain technology ensure your vote remains secure and anonymous.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-mobile-alt"></i>
                    <h3>Mobile Friendly</h3>
                    <p>Cast your vote from any smartphone, tablet, or computer with internet access.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-fingerprint"></i>
                    <h3>Biometric Verification</h3>
                    <p>Multi-factor authentication including biometric verification prevents fraudulent votes.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-chart-bar"></i>
                    <h3>Real-Time Results</h3>
                    <p>View election results in real-time with complete transparency.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-image">
                <img src="{{ asset('assets/img/freepik_assistant_1754323797851.png') }}" alt="About Online Voting">
            </div>
            <div class="about-content">
                <h2>About Our Online Voting System</h2>
                <p>Developed as part of a Final Year Project in Pakistan, this online voting system aims to revolutionize the electoral process by providing a secure, transparent, and accessible platform for citizens to exercise their democratic rights.</p>
                <p>Our system is designed in collaboration with the Election Commission of Pakistan to meet all legal requirements and security standards for national elections.</p>
                <ul class="about-list">
                    <li><i class="fas fa-check"></i> Approved by ECP</li>
                    <li><i class="fas fa-check"></i> Developed by Pakistani students</li>
                    <li><i class="fas fa-check"></i> Open-source technology</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <h2>How It Works</h2>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Voter Registration</h3>
                        <p>Register using your CNIC and biometric verification through NADRA's database.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Identity Verification</h3>
                        <p>Complete multi-factor authentication including SMS verification and facial recognition.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Casting Your Vote</h3>
                        <p>Select your preferred candidate and confirm your choice. Your vote is encrypted and recorded on the blockchain.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Results</h3>
                        <p>After polls close, view the verified results in real-time while maintaining voter anonymity.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Security Section -->
    <section class="security" id="security">
        <div class="container">
            <h2>Security Measures</h2>
            <p class="security-subtitle">We've implemented multiple layers of security to protect the integrity of your vote</p>
            
            <div class="security-features">
                <div class="security-card">
                    <i class="fas fa-lock"></i>
                    <h3>Blockchain Technology</h3>
                    <p>Immutable ledger ensures votes cannot be altered or deleted after submission.</p>
                </div>
                <div class="security-card">
                    <i class="fas fa-user-shield"></i>
                    <h3>Voter Anonymity</h3>
                    <p>Your identity is never linked to your vote in the system.</p>
                </div>
                <div class="security-card">
                    <i class="fas fa-qrcode"></i>
                    <h3>Unique Vote IDs</h3>
                    <p>Each vote receives a unique identifier for verification without revealing voter identity.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <h2>What People Are Saying</h2>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>"This system will revolutionize democracy in Pakistan by making voting accessible to overseas Pakistanis and people in remote areas."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="{{ asset('assets/img/avtar/06.jpg') }}" alt="Dr. Ali Khan">
                        <h4>Dr. Ali Khan</h4>
                        <p>Political Science Professor, LUMS</p>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>"As someone with mobility challenges, I appreciate being able to vote from home securely. This is a game-changer for accessibility."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="{{ asset('assets/img/avtar/07.jpg') }}" alt="Ayesha Malik">
                        <h4>Ayesha Malik</h4>
                        <p>Voter from Karachi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Experience the Future of Voting?</h2>
            <p>Register now to participate in Pakistan's next digital election.</p>
            <div class="cta-buttons">
                <a href="{{route('register')}}" class="btn primary">Register as Voter</a>
                <a href="{{route('login')}}" class="btn secondary">Already Registered? Login</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <h3>Pakistan Online Voting System</h3>
                    <p>A Final Year Project developed by Pakistani students to modernize the electoral process with secure digital technology.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#security">Security</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-contact" id="contact">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Election Commission of Pakistan, Islamabad</li>
                        <li><i class="fas fa-phone"></i> +92 51 111 111 111</li>
                        <li><i class="fas fa-envelope"></i> info@onlinevoting.pk</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Pakistan Online Voting System. All rights reserved. A Final Year Project.</p>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href').slice(1);
            const target = document.getElementById(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
</html>