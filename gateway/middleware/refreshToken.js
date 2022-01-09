const routeLists = require('../routes/routeLists');
const axios = require('axios');

module.exports = function (req, res) {
    try {
        console.log(req.headers);
        if ((req.headers["x-refresh-token"] !== null || req.headers["x-refresh-token"] !== undefined)) {
            const url = routeLists.refreshToken;
            const data = {refresh_token: req.headers["x-refresh-token"]};
            return axios.post(url, data)
                .then(newRefresh => {
                    req.headers['authorization'] = "Bearer " + newRefresh.data.token;
                    res.setHeader("Access-Control-Expose-Headers", 'authorization')
                        .setHeader("authorization", newRefresh.data.token)
                });
        }
    } catch (e) {
        console.log(e);
    }
}
