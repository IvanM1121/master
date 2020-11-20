self.addEventListener('install', e =>{

	caches.open('static').then(cache => {
	
	
	return cache.addAll(['./'])
	})
})

self.addEventListener('fetch', e => {
e.respondWith(
caches.match(e.request).then(response => {
return response || fetch(e.request)
})
)

})