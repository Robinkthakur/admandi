const CACHE_NAME = 'admandi-cache-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/favicon.png',
    '/icon-192.png',
    '/icon-512.png',
    '/assets/css/bootstrap.min.css',
    '/assets/css/style.css',
    '/assets/css/responsive.css',
    '/assets/js/jquery.min.js'
];

// Install Service Worker and cache essential static assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                return cache.addAll(ASSETS_TO_CACHE);
            })
            .then(() => self.skipWaiting())
    );
});

// Activate Service Worker and clean up old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cache => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch handler - Network-first for dynamic requests, falling back to cache
self.addEventListener('fetch', event => {
    // Only handle GET requests and skip Livewire/admin/api requests to avoid conflicts
    if (event.request.method !== 'GET' || 
        event.request.url.includes('/livewire/') || 
        event.request.url.includes('/admin/') || 
        event.request.url.includes('/api/')) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then(response => {
                // If it's a valid response, clone and cache it for static assets
                if (response && response.status === 200 && response.type === 'basic') {
                    const responseClone = response.clone();
                    // We only cache CSS, JS, fonts, and images on the fly
                    const url = new URL(event.request.url);
                    if (url.pathname.match(/\.(js|css|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot)$/)) {
                        caches.open(CACHE_NAME).then(cache => {
                            cache.put(event.request, responseClone);
                        });
                    }
                }
                return response;
            })
            .catch(() => {
                // Network failed, try to serve from cache
                return caches.match(event.request).then(cachedResponse => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    // If everything fails and it's a page request, return root / offline message
                    if (event.request.headers.get('accept').includes('text/html')) {
                        return caches.match('/');
                    }
                });
            })
    );
});
