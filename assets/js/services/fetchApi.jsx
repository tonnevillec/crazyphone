function getProducts(){
    return fetch('api/products', {
        headers: {
            'Accept': 'application/json',
        }
    }).then(r => r.json())
}

export default {
    getProducts
}