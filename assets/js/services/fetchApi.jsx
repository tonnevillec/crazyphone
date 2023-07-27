function getProducts(){
    return fetch('api/products', {
        headers: {
            'Accept': 'application/json',
        }
    }).then(r => r.json())
}

function get(endpoint){
    return fetch('api/' + endpoint, {
        headers: {
            'Accept': 'application/json',
        }
    }).then(r => r.json())
}

export default {
    getProducts,
    get
}