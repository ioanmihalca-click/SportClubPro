<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SportClubPro') }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
        }
        
        .loading-container {
            text-align: center;
        }
        
        .logo {
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        
        .loading-text {
            color: white;
            font-family: system-ui, -apple-system, sans-serif;
            font-size: 1.2rem;
            margin-top: 1rem;
        }
        
        .loading-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 1rem;
        }
        
        .dot {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: bounce 0.5s infinite alternate;
        }
        
        .dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .dot:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        @keyframes bounce {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-10px);
            }
        }

        @media (prefers-color-scheme: dark) {
            body {
                background: linear-gradient(135deg, #134e4a 0%, #164e63 100%);
            }
        }
    </style>
</head>
<body>
    <div class="loading-container">
        <img src="{{ asset('assets/logo.webp') }}" alt="SportClubPro Logo" class="logo">
        <div class="loading-text">Se încarcă SportClubPro...</div>
        <div class="loading-dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.location.href = '/';
            }, 2000);
        }
    </script>
</body>
</html>