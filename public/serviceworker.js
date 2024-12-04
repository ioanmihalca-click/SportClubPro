var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/',
    '/offline',
    '/loading'
];

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
    event.respondWith(
        fetch(event.request)
            .catch(() => {
                return caches.match(event.request)
                    .then(response => {
                        if (response) {
                            return response;
                        }
                        if (event.request.mode === 'navigate') {
                            return caches.match('/loading');
                        }
                        return Promise.reject('no-match');
                    });
            })
    );
});