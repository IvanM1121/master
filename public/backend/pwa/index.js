if ('serviceWorker' in navigator) {

    navigator.serviceWorker.register('sw.js').then(registration => {
        console.log('registred')
    })
}