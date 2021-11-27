const axios = require('axios');

module.exports = async function(url,req,res){
    try {
        const response = await axios({
            method: req.method,
            url: url,
            headers: {headers: req.headers},
            data: req.body
        });
        return response.data;
    }catch(e){
        console.log(e);
    }
}
