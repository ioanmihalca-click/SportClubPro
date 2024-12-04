const staticCacheName = "pwa-v" + new Date().getTime();
const filesToCache = [
    '/',
    '/offline'
];

// HTML pentru loading screen
const loadingHTML = `
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportClubPro</title>
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
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        @keyframes bounce {
            from { transform: translateY(0); }
            to { transform: translateY(-10px); }
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
        <img src="/assets/logo.webp" alt="SportClubPro Logo" class="logo">
        <div class="loading-text">Se încarcă SportClubPro...</div>
        <div class="loading-dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
    <script>
        setTimeout(() => { window.location.href = '/'; }, 2000);
    </script>
</body>
</html>
`;

self.addEventListener("install", event => {
    event.waitUntil(
        caches.open(staticCacheName)
        .then(cache => {
            return Promise.all(
                filesToCache.map(url => {
                    return cache.add(url).catch(error => {
                        console.error('Failed to cache:', url, error);
                        return Promise.resolve();
                    });
                })
            );
        })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

self.addEventListener('fetch', event => {
    // Doar pentru cereri de navigare (când se deschide PWA-ul)
    if (event.request.mode === 'navigate') {
        event.respondWith(
            new Response(loadingHTML, {
                headers: {
                    'Content-Type': 'text/html'
                }
            })
        );
    } else {
        event.respondWith(
            fetch(event.request)
                .catch(() => {
                    return caches.match(event.request)
                        .then(response => {
                            if (response) {
                                return response;
                            }
                            if (event.request.mode === 'navigate') {
                                return caches.match('/offline');
                            }
                            return Promise.reject('no-match');
                        });
                })
        );
    }
});