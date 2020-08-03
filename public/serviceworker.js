const useCachedFiles = true;

const staticCachePagesName = 'static-pages-01';
const staticCachePages = [
    '/',
    '/login'
];
const staticCacheIncludesName = 'static-includes-01';
const staticCacheIncludes = [
    '/css/stylesheet.css',
    '/css/linearicons.css',
    '/_debugbar/assets/stylesheets',
    '/js/functions.js',
    '/_debugbar/assets/javascript',
    '/site.webmanifest',
    '/manifest.webmanifest'
];
const staticCacheImagesName = 'static-images-01';
const staticCacheImages = [
    '/images/icons/laravel-blueprint-pwa-icon-192.png',
    '/favicon-32x32.png',
    '/favicon-16x16.png',
    '/android-chrome-192x192.png',
    '/apple-touch-icon.png'
];
const staticCacheFontsName = 'static-fonts-01';
const staticCacheFonts = [
    'https://use.typekit.net/ski7rfi.css'
];

// Install the service worker
self.addEventListener( 'install', evt => {

    console.log( 'The service worker is installed.' );
    evt.waitUntil(
        callSwAddToCacheFunctions()
    );

} );

// The service worker is activated
self.addEventListener( 'activate', evt => {

    console.log( 'The service worker is activated.' );
    evt.waitUntil(
        caches.keys().then( keys => {
            return Promise.all(
                keys.filter( key => key !== staticCachePagesName && key !== staticCacheIncludesName && key !== staticCacheImagesName && key !== staticCacheFontsName ).map( key => caches.delete( key ) )
            )
        } )
    );

} );

// The service worker fetch events
if( useCachedFiles ) {
    self.addEventListener( 'fetch', evt => {

        let url = evt.request.url.split( '?' )[0];
        evt.respondWith(
            caches.match( url ).then( cacheResponse => {
                return cacheResponse || fetch( evt.request );
            } )
        );

    } );
}

function callSwAddToCacheFunctions() {
    swAddToCache( staticCachePagesName, staticCachePages );
    swAddToCache( staticCacheIncludesName, staticCacheIncludes );
    swAddToCache( staticCacheImagesName, staticCacheImages );
    swAddToCache( staticCacheFontsName, staticCacheFonts );
}

/**
 * A function to let the service worker cache the files.
 * @param {String} cacheName - The name of the cache.
 * @param {Array} fileNames - The files to be cached.
 */
function swAddToCache( cacheName, fileNames ) {
    caches.open( cacheName ).then( cache => {
        cache.addAll( fileNames );
    } )
}
