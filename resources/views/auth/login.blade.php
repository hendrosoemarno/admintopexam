<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart-Learning Hub | Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3ccfcf;
      --accent: #7209b7;
      --text: #333333;
      --bg-light: #f8f9fa;
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
      background-color: var(--bg-light);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }
    
    .login-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      max-width: 1000px;
      background-color: var(--card-bg);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(67, 97, 238, 0.15);
    }
    
    .login-image {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      color: white;
      position: relative;
    }
    
    .login-image::after {
      content: '';
      position: absolute;
      width: 200px;
      height: 200px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      top: -100px;
      right: -100px;
    }
    
    .login-image::before {
      content: '';
      position: absolute;
      width: 150px;
      height: 150px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      bottom: -75px;
      left: -75px;
    }
    
    .login-image img {
      max-width: 80%;
      margin-bottom: 20px;
      animation: float 3s ease-in-out infinite;
    }
    
    .login-image h2 {
      font-size: 28px;
      margin-bottom: 15px;
      text-align: center;
    }
    
    .login-image p {
      text-align: center;
      line-height: 1.6;
    }
    
    .login-form {
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    .login-form h1 {
      color: var(--primary);
      margin-bottom: 30px;
      font-weight: 600;
    }
    
    .form-group {
      margin-bottom: 25px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--text);
      font-weight: 500;
    }
    
    .input-group {
      position: relative;
    }
    
    .input-group i.input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--primary);
    }
    
    .form-input {
      width: 100%;
      padding: 12px 15px 12px 45px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    
    /* Menyesuaikan padding pada form input password untuk memberikan ruang bagi toggle icon */
    .form-input[type="password"],
    .form-input[type="text"] {
      padding-right: 45px;
    }
    
    .form-input:focus {
      border-color: var(--primary);
      outline: none;
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }
    
    /* Perbaikan styling untuk icon toggle password */
    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--primary);
      cursor: pointer;
      z-index: 10;
      background: none;
      border: none;
      padding: 0;
      font-size: 16px;
    }
    
    .remember-forgot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }
    
    .remember-me {
      display: flex;
      align-items: center;
    }
    
    .remember-me input {
      margin-right: 8px;
      accent-color: var(--primary);
    }
    
    .forgot-password {
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .forgot-password:hover {
      color: var(--accent);
    }
    
    .btn {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
    }
    
    .btn:hover {
      background-color: #3050dd;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
    }
    
    .btn i {
      margin-left: 8px;
    }
    
    .register-link {
      margin-top: 30px;
      text-align: center;
      color: var(--text);
    }
    
    .register-link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .register-link a:hover {
      color: var(--accent);
    }
    
    .social-login {
      margin-top: 30px;
    }
    
    .social-login p {
      text-align: center;
      color: var(--text);
      position: relative;
      margin-bottom: 20px;
    }
    
    .social-login p::before,
    .social-login p::after {
      content: "";
      position: absolute;
      height: 1px;
      width: 40%;
      background-color: #e0e0e0;
      top: 50%;
    }
    
    .social-login p::before {
      left: 0;
    }
    
    .social-login p::after {
      right: 0;
    }
    
    .social-icons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }
    
    .social-icon {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 45px;
      height: 45px;
      border-radius: 50%;
      background-color: #f5f5f5;
      color: var(--text);
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .social-icon:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
      color: white;
    }
    
    .social-icon.google:hover {
      background-color: #DB4437;
    }
    
    .social-icon.facebook:hover {
      background-color: #4267B2;
    }
    
    .social-icon.twitter:hover {
      background-color: #1DA1F2;
    }
    
    @keyframes float {
      0% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-10px);
      }
      100% {
        transform: translateY(0px);
      }
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
      .login-container {
        grid-template-columns: 1fr;
      }
      
      .login-image {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-image">
      <img src="{{ asset('images/login.png') }}" alt="Learning Illustration">
      <h2>Selamat Datang di Smart-Learning Hub!</h2>
      <p>Platform belajar cerdas untuk siswa Indonesia. Temukan kemudahan belajar dengan bantuan AI dan materi berkualitas.</p>
    </div>
    <div class="login-form">
      <h1>Masuk ke Akun Anda</h1>

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <label for="username">Username</label>
          <div class="input-group">
            <i class="fas fa-user input-icon"></i>
            <input type="text" id="username" name="username" class="form-input" placeholder="Masukkan username Anda" required>
          </div>
          @error('username')
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="password">Kata Sandi</label>
          <div class="input-group">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan kata sandi Anda" required>
            <button type="button" class="toggle-password" id="togglePassword" aria-label="Lihat kata sandi">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        <div class="remember-forgot">
          <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Ingat saya</label>
          </div>
          <a href="#" class="forgot-password">Lupa kata sandi?</a>
        </div>
        <button type="submit" class="btn">
          Masuk
          <i class="fas fa-arrow-right"></i>
        </button>
      </form>

      <div class="register-link">
        <p>Belum punya akun? <a href="#">Daftar Sekarang</a></p>
      </div>
      <div class="social-login">
        <p>Atau masuk dengan</p>
        <div class="social-icons">
          <a href="#" class="social-icon google">
            <i class="fab fa-google"></i>
          </a>
          <a href="#" class="social-icon facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="social-icon twitter">
            <i class="fab fa-twitter"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Script untuk toggle password visibility
    document.addEventListener('DOMContentLoaded', function() {
      const togglePassword = document.querySelector('#togglePassword');
      const password = document.querySelector('#password');
      
      togglePassword.addEventListener('click', function() {
        // Toggle tipe input antara password dan text
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Toggle icon antara eye dan eye-slash
        const icon = togglePassword.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
      });
    });
  </script>
</body>
</html>
