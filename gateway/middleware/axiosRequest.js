const axios = require('axios');

module.exports = async function(url,req,res/*,headers*/){
    try {
        return await axios({
            method: req.method,
            url: url,
            headers: req.headers,//headers,
            data: req.body
        });
    }catch(e){
        res.status(e.response.status);
        return res.json(e.response.data);
    }
}
