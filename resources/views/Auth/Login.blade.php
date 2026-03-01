<!DOCTYPE html>
<html>
<head>
    <title>Login v4  </title>
    <link rel="stylesheet" href="{{ asset('assets/auth-assets/login.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/auth-assets/login.js') }}"></script>
      <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="bg-animate">
    <div class="circle" style="width: 400px; height: 400px; top: -100px; left: -100px;"></div>
    <div class="circle" style="width: 300px; height: 300px; bottom: -50px; right: -50px; animation-delay: -5s;"></div>
</div>

<div id="spinnerLoader">
    <div class="spinner"></div>
</div>
<div class="container">
    <div class="mascot-section">
        <div class="glow-circle"></div>
        <div class="mascot-container">
            <svg class="robot" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="80" fill="none" stroke="#00d2ff" stroke-width="2" stroke-dasharray="10 5" />
                <rect x="60" y="70" width="80" height="60" rx="15" fill="#1a1a2e" stroke="#00d2ff" stroke-width="4" />
                <circle cx="85" cy="95" r="8" fill="#00d2ff">
                    <animate attributeName="opacity" values="1;0.2;1" dur="2s" repeatCount="indefinite" />
                </circle>
                <circle cx="115" cy="95" r="8" fill="#00d2ff">
                    <animate attributeName="opacity" values="1;0.2;1" dur="2s" repeatCount="indefinite" />
                </circle>
                <path d="M80 115 Q100 125 120 115" stroke="#00d2ff" stroke-width="3" fill="none" stroke-linecap="round" />
                <path d="M100 50 L100 70" stroke="#6a11cb" stroke-width="4" />
                <circle cx="100" cy="45" r="5" fill="#6a11cb" />
            </svg>
        </div>
        <h3>APP NAME</h3>
        <p class="mascot-subtitle">Descriptions</p>
    </div>

    <div class="form-section">
        <div class="form-toggle">
            <button id="btn-login" class="active">Login</button>
            <button id="btn-register">Register</button>
        </div>

        <div class="form-content">
            <div id="login-form" class="form-box active">
                <h2>Welcome Back!</h2>
                <p class="desc">Please enter your credentials to access your neural-link.</p>
              <form method="POST" action="{{ route('login.user') }}">
                    @csrf

                    <div class="input-group">
                        <label>Email Id</label>
                        <input type="text" name="email" placeholder="Enter email" required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-submit">Login</button>
                </form>
            </div>

            <div id="register-form" class="form-box">
                <h2>New Connection</h2>
                <p class="desc">Create your neural profile to start the journey.</p>
                <form class="auth-form" id ="registerForm">

                    @csrf
                    <div class="input-group">
                        <label>Full Name</label>
                        <input type="text" name ="name" placeholder="John Doe" required>
                    </div>
                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="name@neuro.link" required>
                    </div>
                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="button" onclick="createAccount()" class="btn-submit">Create Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
 </html>
