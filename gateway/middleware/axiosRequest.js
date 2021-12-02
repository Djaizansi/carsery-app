const axios = require('axios');

module.exports = async function(url,req,res,headers){
    try {
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
