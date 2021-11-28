const axios = require('axios');

module.exports = async function(url,req,res){
    try {
        let headers = url.split('/');
        //After in the last, remove this line and put req.headers in headers
        headers = headers[headers.length - 1] === 'login' ? {'Content-Type': 'application/json'} : req.headers;
        return await axios({
            method: req.method,
            url: url,
            headers: headers,
            data: req.body
        });
    }catch(e){
        res.status(e.response.data.code);
        return res.json(e.response.data);
    }
}
