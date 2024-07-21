// service-worker.js

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open('funrun-v1').then(function(cache) {
            return cache.addAll([
                './',
                './index.php',
                './beep.wav', // tambahkan file lain yang perlu di-cache
                // tambahkan file lain yang diperlukan
            ]);
        })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request);
        })
    );
});
