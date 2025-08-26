<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Warehouse</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #bd7a3a, #426cd7);
      font-family: Arial, sans-serif;
      perspective: 1200px;
      overflow: hidden;
    }

    .login-box {
      position: relative;
      width: 220px;
      padding: 15px;
      border-radius: 15px;
      background: linear-gradient(135deg, #cf8235ff, #3876e1ff, #cf8235ff);
      background-size: 400% 400%;
      animation: gradientMove 12s ease infinite;
      box-shadow: 
        0 10px 20px rgba(0,0,0,0.6),
        0 20px 40px rgba(0,0,0,0.4),
        inset 0 0 20px rgba(255,255,255,0.05);
      text-align: center;
      transform-style: preserve-3d;
      transition: all 0.5s ease;
      overflow: hidden;
      cursor: pointer;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .login-box::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 15px;
      padding: 2px;
      background: linear-gradient(270deg, #ff00ff, #00ffff, #ff00ff);
      background-size: 400% 400%;
      -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
      -webkit-mask-composite: xor;
              mask-composite: exclude;
      animation: animBorder 5s linear infinite;
      pointer-events: none;
    }
    @keyframes animBorder {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .login-box h2 {
      color: #fff;
      margin: 0;
      transition: margin-bottom 0.5s ease;
    }

    .login-box.active {
      width: 300px;
      padding: 50px;
    }
    .login-box.active h2 {
      margin-bottom: 25px;
    }

    .form-area {
      max-height: 0;
      opacity: 0;
      overflow: hidden;
      transition: all 0.5s ease;
    }
    .login-box.active .form-area {
      max-height: 500px;
      opacity: 1;
    }

    .form-control {
      background: rgba(255,255,255,0.9);
      border: none;
      border-radius: 8px;
      padding-left: 40px;
    }
    .form-control:focus {
      box-shadow: 0 0 10px rgba(0,255,255,0.6);
    }

    .input-group-text {
      background: transparent;
      border: none;
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #444;
    }

    .btn-custom {
      background: #1976d2;
      color: #fff;
      font-weight: bold;
      border-radius: 8px;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background: #145ca6;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(25,118,210,0.5);
    }

    /* === LOGO di dalam kotak === */
    .login-box .logo {
      position: absolute;
      top: 10px;
      left: 10px;
      width: 45px;
      height: 45px;
      border-radius: 40%;
      object-fit: cover;
      box-shadow: 0 0 15px rgba(0,0,0,0.5);
    }
  </style>
</head>
<body>
  <div class="login-box" id="loginBox">
    <!-- Logo di dalam box -->
    <img src="logo.png" class="logo" alt="Logo">

    <h2>Login</h2>
    <div class="form-area">
      <form action="login_proses.php" method="POST">
        <div class="mb-3 position-relative">
          <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
          <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="mb-3 position-relative">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-custom w-100">Sign in</button>
      </form>
    </div>
  </div>

  <script>
    const box = document.getElementById("loginBox");

    box.addEventListener("mouseenter", () => {
      box.classList.add("active");
    });

    box.addEventListener("mouseleave", () => {
      box.classList.remove("active");
    });

    document.addEventListener("mousemove", (e) => {
      let x = (window.innerWidth / 2 - e.pageX) / 20;
      let y = (window.innerHeight / 2 - e.pageY) / 20;
      box.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
    });

    document.addEventListener("mouseleave", () => {
      box.style.transform = `rotateY(0deg) rotateX(0deg)`;
    });
  </script>
</body>
</html>
