const axios = require('axios');

module.exports = async function(url,req,res,headers = null){
    try {
        return await axios({
            method: req.method,
            url: url,
            headers: headers === null ? req.headers : headers,
            data: req.body
        });
    }catch(e){
        console.log(e);
        res.status(e.response.status);
        return res.json(e.response.data);
    }
}
