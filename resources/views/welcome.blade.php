<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart-Learning Hub | Platform Belajar Cerdas untuk Siswa Indonesia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #6a89f7;
            --secondary: #3ccfcf;
            --accent: #7209b7;
            --text: #333333;
            --background: #f8f9fa;
            --card-bg: #ffffff;
            --success: #38b000;
            --warning: #ffbe0b;
            --danger: #ff5263;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--background);
            color: var(--text);
            overflow-x: hidden;
        }
        
        .container {
			position: relative; /* Penting untuk posisi absolut tombol navigasi */
			padding: 0 20px;
			max-width: 1200px;
			margin: 0 auto;
        }
        
        /* Header Styles */
        header {
            background-color: var(--card-bg);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary);
            font-weight: 700;
            font-size: 24px;
        }
        
        .logo i {
            color: var(--accent);
        }
        
        .nav-links {
            display: flex;
            gap: 30px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-links a:hover {
            color: var(--primary);
        }
        
        .auth-buttons {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            border: none;
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }
        
        /* Hero Section */
		.hero {
			padding-top: 120px;
			padding-bottom: 80px;
		}
		
		.hero .container {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 40px;
			align-items: center;
		}
        
        .hero-content {
            animation: fadeIn 1s ease;
        }
        
        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--text);
            line-height: 1.2;
        }
        
        .hero-content h1 span {
            color: var(--primary);
        }
        
        .hero-content p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: #666;
            line-height: 1.6;
        }
        
        .hero-image {
            text-align: center;
            animation: floatUp 1s ease;
        }
        
        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        /* Features Section */
        .features {
            padding: 80px 0;
            background-color: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--text);
            margin-bottom: 15px;
        }
        
        .section-title p {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            transition: all 0.3s ease;
            animation: fadeIn 1s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .feature-card:nth-child(1) .feature-icon {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }
        
        .feature-card:nth-child(2) .feature-icon {
            background-color: rgba(60, 207, 207, 0.1);
            color: var(--secondary);
        }
        
        .feature-card:nth-child(3) .feature-icon {
            background-color: rgba(114, 9, 183, 0.1);
            color: var(--accent);
        }
        
        .feature-card h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: var(--text);
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
        }
        
        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Testimonials Section */
        .testimonials {
            padding: 80px 0;
            background-color: white;
        }
        
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .testimonial-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            position: relative;
            animation: fadeIn 1s ease;
        }
        
        .testimonial-card::before {
            content: """;
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 80px;
            color: rgba(67, 97, 238, 0.1);
            font-family: serif;
        }
        
        .testimonial-content {
            font-style: italic;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 20px;
        }
        
        .author-info h4 {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        
        .author-info p {
            font-size: 0.9rem;
            color: #666;
        }
        
        /* CTA Section */
        .cta {
            padding: 80px 0;
            background-color: white;
            text-align: center;
        }
        
        .cta-content {
            max-width: 700px;
            margin: 0 auto;
        }
        
        .cta-content h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--text);
        }
        
        .cta-content p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: #666;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }
        
        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-about h3, .footer-links h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: white;
        }
        
        .footer-about p {
            margin-bottom: 20px;
            opacity: 0.8;
            line-height: 1.6;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: var(--primary);
            transform: translateY(-5px);
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--secondary);
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes floatUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Media Queries */
        @media (max-width: 968px) {
			.hero .container {
				grid-template-columns: 1fr;
				text-align: center;
			}

            .hero {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
		
		/* FAQ */
        .container-faq {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px 0;
        }

        .faq-item {
            background-color: white;
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
        }
        
        .faq-question {
            padding: 15px 20px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            line-height: 1.6;
            color: #333;
        }
        
        .faq-answer.active {
            padding: 0 20px 15px;
            max-height: 500px;
        }
        
        .chevron {
            transition: transform 0.3s ease;
        }
        
        .rotate {
            transform: rotate(180deg);
        }
        
        .read-more {
            text-align: center;
            margin-top: 20px;
        }
        
        .read-more a {
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        
        .read-more a:hover {
            text-decoration: underline;
        }		
		
		/* course card */
        .card-carousel {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            gap: 15px;
            padding: 20px 0;
            scrollbar-width: none;
        }
        
        .card-carousel::-webkit-scrollbar {
            display: none;
        }
        
        .card {
            flex: 0 0 auto;
            width: 250px;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .card-header {
            padding: 12px;
            position: relative;
        }
        
        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #ff4d4f;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .card-tag {
            display: inline-block;
            background-color: #4361ee;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            margin-bottom: 8px;
        }
        
        .card-title {
            font-size: 14px;
            color: #333;
            margin-bottom: 6px;
            font-weight: 600;
        }
        
        .card-subtitle {
            font-size: 16px;
            font-weight: bold;
            color: #111;
            margin-bottom: 12px;
        }
        
        .card-image {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .card-price {
            padding: 12px;
            border-top: 1px solid #eee;
        }
        
        .original-price {
            text-decoration: line-through;
            color: #999;
            font-size: 12px;
        }
        
        .discount {
            color: #ff4d4f;
            font-size: 12px;
            font-weight: bold;
            margin-right: 5px;
        }
        
        .current-price {
            font-size: 16px;
            font-weight: bold;
            color: #111;
        }
        
        .price-period {
            font-size: 12px;
            color: #666;
        }
        
        .buy-button {
            display: block;
            width: 100%;
            background-color: #ff7a00;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            text-align: center;
        }
        
        .features {
            padding: 12px;
        }
        
        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
            font-size: 12px;
            color: #333;
        }
        
        .feature-icon {
            color: #ff7a00;
            margin-right: 8px;
            font-weight: bold;
        }
        
        .rating {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .star {
            color: #ffc107;
            margin-right: 5px;
        }
        
        .detail-link {
            display: block;
            text-align: center;
            color: #0088cc;
            font-size: 14px;
            padding: 12px;
            text-decoration: none;
            border-top: 1px solid #eee;
        }
        
        .detail-link:hover {
            text-decoration: underline;
        }
        
        .navigation-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 10;
        }
        
        .prev-btn {
            left: -20px;
        }
        
        .next-btn {
            right: -20px;
        }

        .view-all {
            background-color: #f0f6ff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            text-align: center;
        }
        
        .view-all-title {
            font-size: 18px;
            font-weight: bold;
            color: #1a56db;
            margin-bottom: 12px;
        }
        
        .view-all-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            color: #1a56db;
            font-weight: bold;
            cursor: pointer;
        }		
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="TOP EXAM Logo" style="height: 40px;">
                    <span>TOP EXAM</span>
                </div>
                <div class="nav-links">
                    <a href="#beranda">Beranda</a>
                    <a href="#kelas">Kelas</a>
                    <a href="#fitur">Fitur</a>
                    <a href="#testimonial">Testimoni</a>
                    <a href="#faq">FAQ</a>
                    <a href="https://api.whatsapp.com/send?phone=085101442463">Kontak</a>
                </div>
                <div class="auth-buttons">
                    <a href="{{ route('moodle.login') }}" class="btn btn-outline">Masuk</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-content">
                <h1>Belajar <span>Cerdas</span>, Raih Prestasi <span>Gemilang</span></h1>
                <p>Platform belajar digital dengan dukungan AI yang membantu siswa meningkatkan prestasi akademik melalui pembelajaran yang dipersonalisasi dan analisis performa mendalam.</p>
                <div class="auth-buttons">
                    <a href="https://lms.topexam.id/login/signup.php" class="btn btn-primary">Mulai Belajar</a>
                    <a href="#whytopexam" class="btn btn-outline">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/landing1.png') }}" alt="Smart Learning Hub Dashboard">
            </div>

        </div>
    </section>

    <section class="features" id="kelas">
    <div class="container">
            <div class="section-title">
                <h2>Paket Belajar</h2>
                <p>Pilihlah paket belajar yang paling sesuai untuk mendukung perkembangan belajar Ananda.</p>
            </div>

        <div class="card-carousel" id="cardCarousel">
            <!-- Card 1 -->
            <div class="card">
                <div class="card-header">
                    <!-- <div class="badge">Diskon 50% 12:00:29</div> -->
                    <div class="card-tag">Premium TKA SMP</div>
                    <h3 class="card-title">Belajar & Berlatih</h3>
                    <h2 class="card-subtitle">Video belajar, Try Out TKA SMP, Detil Rapor</h2>
                </div>
                <div class="card-image">
                    <img src="/api/placeholder/250/150" alt="ruangbelajar SNBT">
                </div>
                <div class="card-price">
                    <div>
                        <span class="original-price">Rp 275.000</span>
                        <span class="discount">50%</span>
                    </div>
                    <div>
                        <span class="current-price">Rp 54.083</span>
                        <span class="price-period">/bulan</span>
                    </div>
                    <button class="buy-button">Beli Paket</button>
                </div>
                <div class="features">
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Pengguna berpelunag 3x lebih besar masuk kampus impian</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Hingga 20x tryout UTBK/SNBT Tes Skolastik</span>
                    </div>
                </div>
                <a href="#" class="detail-link">Lihat Detail</a>
            </div>
            
            <!-- Card 2 -->
            <div class="card">
                <div class="card-header">
                    <div class="card-tag">Fasilitas lengkap</div>
                    <h3 class="card-title">Brain Academy Center</h3>
                    <h2 class="card-subtitle">Kelas tatap muka + video belajar dan latihan soal</h2>
                </div>
                <div class="card-image">
                    <img src="/api/placeholder/250/150" alt="Brain Academy Center">
                </div>
                <div class="card-price">
                    <div>
                        <span class="original-price">Rp 533.333,33 Mulai dari</span>
                        <span class="discount">48%</span>
                    </div>
                    <div>
                        <span class="current-price">Rp 280.000</span>
                        <span class="price-period">/bulan</span>
                    </div>
                    <button class="buy-button">Beli Paket</button>
                </div>
                <div class="features">
                    <div class="rating">
                        <span class="star">★</span>
                        <span>4.8/5 rating kelas</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Belajar intensif di kelas dengan tryout persiapan PTS dan PAS</span>
                    </div>
                </div>
                <a href="#" class="detail-link">Lihat Detail</a>
            </div>
            
            <!-- Card 3 -->
            <div class="card">
                <div class="card-header">
                    <div class="card-tag">Live Teaching</div>
                    <h3 class="card-title">Brain Academy Online</h3>
                    <h2 class="card-subtitle">Live Teaching interaktif + konsultasi PR</h2>
                </div>
                <div class="card-image">
                    <img src="/api/placeholder/250/150" alt="Brain Academy Online">
                </div>
                <div class="card-price">
                    <div>
                        <span class="original-price">Rp 2.864.000</span>
                        <span class="discount">25%</span>
                    </div>
                    <div>
                        <span class="current-price">Rp 1.000.000</span>
                        <span class="price-period">/bulan</span>
                    </div>
                    <button class="buy-button">Beli Paket</button>
                </div>
                <div class="features">
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Live Teaching terbaik pilihan orang tua</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Sesi pertemuan online hingga 10x seminggu</span>
                    </div>
                </div>
                <a href="#" class="detail-link">Lihat Detail</a>
            </div>
            
            <!-- Card 4 -->
            <div class="card">
                <div class="card-header">
                    <div class="card-tag">Standar Internasional</div>
                    <h3 class="card-title">English Academy</h3>
                    <h2 class="card-subtitle">Kursus bahasa Inggris bersama Native Teacher</h2>
                </div>
                <div class="card-image">
                    <img src="/api/placeholder/250/150" alt="English Academy">
                </div>
                <div class="card-price">
                    <div>
                        <span class="original-price">Rp 2.400.000</span>
                        <span class="discount">20%</span>
                    </div>
                    <div>
                        <span class="current-price">Rp 1.920.000</span>
                    </div>
                    <button class="buy-button">Beli Paket</button>
                </div>
                <div class="features">
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>92% pengguna lebih mahir berbahasa inggris</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Dilengkapi English Club untuk latihan speaking skill dengan cara seru</span>
                    </div>
                </div>
                <a href="#" class="detail-link">Lihat Detail</a>
            </div>
            
            <!-- View All Card -->
            <div class="card">
                <div class="view-all">
                    <h3 class="view-all-title">Lihat semua paket belajar</h3>
                    <div class="view-all-button">></div>
                </div>
            </div>
        </div>
        
        <button class="navigation-button prev-btn" id="prevBtn">◀</button>
        <button class="navigation-button next-btn" id="nextBtn">▶</button>
    </div>	
    </section>


    <!-- Features Section -->
    <section class="features" id="fitur">
        <div class="container">
            <div class="section-title">
                <h2>Fitur Unggulan Kami</h2>
                <p>Tingkatkan kemampuan belajarmu dengan teknologi terdepan dan pendekatan yang menyenangkan</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🤖</div>
                    <h3>Analisis AI Personal</h3>
                    <p>Sistem kecerdasan buatan kami menganalisis pola belajar dan memberikan rekomendasi yang tepat untuk meningkatkan performa akademikmu.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📝</div>
                    <h3>Try Out Interaktif</h3>
                    <p>Uji kemampuanmu dengan berbagai simulasi ujian yang dirancang sesuai kurikulum terbaru dan dapatkan pembahasan lengkap.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Visualisasi Progres</h3>
                    <p>Pantau perkembanganmu dengan grafik interaktif yang menunjukkan peningkatan dari waktu ke waktu pada setiap mata pelajaran.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Target & Pencapaian</h3>
                    <p>Tetapkan target belajar dan pantau pencapaianmu melalui sistem reward yang memotivasi untuk terus berprestasi.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎓</div>
                    <h3>Tutor Berpengalaman</h3>
                    <p>Dapatkan bimbingan dari tutor berkualitas yang siap membantu menyelesaikan kesulitan belajarmu kapanpun.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3>Adaptif & Fleksibel</h3>
                    <p>Sistem pembelajaran yang menyesuaikan dengan ritme belajarmu, akses materi kapanpun dan dimanapun.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>10K+</h3>
                    <p>Siswa Aktif</p>
                </div>
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Tutor Handal</p>
                </div>
                <div class="stat-item">
                    <h3>95%</h3>
                    <p>Tingkat Kelulusan</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Mata Pelajaran</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonial">
        <div class="container">
            <div class="section-title">
                <h2>Yang Mereka Katakan</h2>
                <p>Kisah sukses dari para siswa yang telah menggunakan Smart-Learning Hub</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>Smart-Learning Hub benar-benar mengubah cara saya belajar. Dengan analisis AI, saya bisa fokus pada materi yang benar-benar saya butuhkan. Hasilnya, nilai saya naik signifikan dalam waktu singkat!</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <h4>Anindita Putri</h4>
                            <p>Siswa SMA Kelas 12</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>Sebagai orang tua, saya senang bisa memantau kemajuan anak saya melalui dashboard yang interaktif. Try out yang dipersonalisasi sangat membantu persiapan UTBK-nya.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <h4>Budi Santoso</h4>
                            <p>Orang Tua Siswa</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>Platform ini luar biasa! UI-nya ramah pengguna dan fitur analisis performa membantu saya memahami kekuatan dan kelemahan saya. Berkat Smart-Learning Hub, saya diterima di universitas impian saya!</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <h4>Randi Pratama</h4>
                            <p>Alumni SMA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq" id="faq">
    <div class="container-faq">
		<div class="section-title">
			<h2>Paling sering ditanyakan</h2>
		</div>
        
        <div class="faq-item">
            <div class="faq-question">
                Apa yang dimaksud dengan aplikasi belajar online?
                <span class="chevron">▼</span>
            </div>
            <div class="faq-answer">
                Aplikasi belajar online adalah platform digital yang memungkinkan proses belajar dan mengajar dilakukan secara daring. Aplikasi ini menyediakan berbagai fitur seperti konten pembelajaran, latihan soal, video tutorial, dan interaksi antara pengajar dan siswa melalui internet.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Bagaimana efektivitas penggunaan aplikasi pembelajaran online di Indonesia?
                <span class="chevron rotate">▼</span>
            </div>
            <div class="faq-answer active">
                Sejak pandemi Covid 19 melanda Indonesia, intensitas penggunaan aplikasi pembelajaran oleh guru dan siswa naik secara signifikan. Kegiatan belajar mengajar menjadi terbantu dengan adanya aplikasi pembelajaran online yang digunakan.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Apakah bimbel online Ruangguru tersedia juga dalam versi desktop/PC?
                <span class="chevron">▼</span>
            </div>
            <div class="faq-answer">
                Ya, Ruangguru tersedia dalam versi desktop/PC. Pengguna dapat mengakses layanan bimbel online Ruangguru melalui website resmi atau aplikasi desktop yang bisa diunduh, selain menggunakan aplikasi mobile di smartphone.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Apa saja kendala yang dihadapi saat menggunakan aplikasi pembelajaran secara online?
                <span class="chevron rotate">▼</span>
            </div>
            <div class="faq-answer active">
                Belum meratanya akses internet di Indonesia, menjadi kendala utama dalam pemanfaatan aplikasi pembelajaran secara online. Siswa di daerah pelosok harus mencari sinyal internet yang stabil guna kelancaran menerima materi pembelajaran.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Apa yang dimaksud dengan belajar online?
                <span class="chevron">▼</span>
            </div>
            <div class="faq-answer">
                Belajar online adalah proses pembelajaran yang dilakukan melalui jaringan internet dengan menggunakan perangkat elektronik seperti komputer, laptop, atau smartphone. Metode ini memungkinkan siswa untuk belajar dari jarak jauh tanpa harus hadir secara fisik di ruang kelas tradisional.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Bagaimana langkah-langkah penerapan belajar online?
                <span class="chevron">▼</span>
            </div>
            <div class="faq-answer">
                Langkah-langkah penerapan belajar online meliputi: (1) Menyiapkan perangkat dan koneksi internet yang stabil, (2) Mendaftar atau login ke aplikasi pembelajaran yang digunakan, (3) Mengatur jadwal belajar yang disiplin, (4) Aktif berpartisipasi dalam forum diskusi atau kelas virtual, dan (5) Mengerjakan tugas atau ujian secara mandiri dan tepat waktu.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Apakah yang dimaksud dengan aplikasi bimbingan belajar online?
                <span class="chevron">▼</span>
            </div>
            <div class="faq-answer">
                Aplikasi bimbingan belajar online adalah platform digital yang menyediakan layanan bimbingan belajar secara daring, dilengkapi dengan tenaga pengajar profesional, materi pembelajaran terstruktur, dan sistem evaluasi untuk memantau perkembangan belajar siswa. Biasanya disertai fitur konsultasi langsung dengan tutor.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Apa saja aplikasi belajar online yang gratis?
                <span class="chevron">▼</span>
            </div>
            <div class="faq-answer">
                Beberapa aplikasi belajar online yang gratis antara lain: Rumah Belajar (dari Kemdikbud), Khan Academy, Quipper (versi dasar), Zenius (beberapa konten gratis), Google Classroom, dan YouTube EDU. Aplikasi-aplikasi ini menyediakan konten pembelajaran yang bisa diakses tanpa biaya.
            </div>
        </div>
        
        <div class="faq-item">
            <div class="faq-question">
                Apa yang dimaksud dengan bimbel?
                <span class="chevron">▼</span>
            </div>
            <div class="faq-answer">
                Bimbel (Bimbingan Belajar) adalah program pendidikan non-formal yang bertujuan memberikan bantuan kepada siswa dalam memahami materi pelajaran sekolah, persiapan ujian, atau pengembangan kemampuan akademik lainnya. Bimbel dapat dilakukan secara tatap muka langsung atau melalui platform online.
            </div>
        </div>
        
        <div class="read-more">
            <a href="#">
                Baca Selengkapnya
                <span style="margin-left: 5px;">►</span>
            </a>
        </div>
    </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Siap Meraih Prestasi Gemilang?</h2>
                <p>Bergabunglah dengan ribuan siswa yang telah meningkatkan kemampuan akademik mereka melalui Smart-Learning Hub</p>
                <div class="cta-buttons">
                <a href="https://lms.topexam.id/login/signup.php" class="btn btn-primary">Daftar Gratis Sekarang</a>
                <a href="https://api.whatsapp.com/send?phone=085101442463" class="btn btn-primary">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <h3>Smart-Learning Hub</h3>
                    <p>Platform belajar cerdas yang dirancang untuk membantu siswa Indonesia meraih prestasi akademik maksimal dengan dukungan teknologi AI dan analisis performa.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h3>Jelajahi</h3>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Fitur</a></li>
                        <li><a href="#">Kelas</a></li>
                        <li><a href="#">Testimoni</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Pelajaran</h3>
                    <ul>
                        <li><a href="#">Matematika</a></li>
                        <li><a href="#">Bahasa Indonesia</a></li>
                        <li><a href="#">Bahasa Inggris</a></li>
                        <li><a href="#">IPA</a></li>
                        <li><a href="#">IPS</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Bantuan</h3>
                    <ul>
                        <li><a href="#">Pusat Bantuan</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Smart-Learning Hub. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>
	
    <script>
        // JavaScript untuk fungsi dropdown FAQ
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const chevron = question.querySelector('.chevron');
                
                // Toggle active class pada jawaban
                answer.classList.toggle('active');
                
                // Toggle rotate class pada chevron
                chevron.classList.toggle('rotate');
            });
        });
		
        // JavaScript untuk card carausel

        const carousel = document.getElementById('cardCarousel');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const cardWidth = 265; // Card width + gap
        
        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -cardWidth, behavior: 'smooth' });
        });
        
        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: cardWidth, behavior: 'smooth' });
        });
		
    </script>
	
	
</body>
</html>
