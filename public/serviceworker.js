const useCachedFiles = true;

const staticCachePagesName = 'static-pages-01';
const staticCachePages = [
    '/',
    '/login'
];
const staticCacheIncludesName = 'static-includes-02';
const staticCacheIncludes = [
    '/css/stylesheet.css',
    '/css/linearicons.css',
    '/js/functions.js',
    '/manifest.webmanifest'
];
const staticCacheImagesName = 'static-images-01';
const staticCacheImages = [
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

        evt.respondWith(
            caches.match( evt.request ).then( cacheResponse => {
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
