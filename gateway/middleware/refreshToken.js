const routeLists = require('../routes/routeLists');
const axios = require('axios');

module.exports = function (req, res) {
    try {
        if (req.headers.authorization && req.headers['x-refresh-token']) {
            const url = routeLists.refreshToken;
            const body = {refresh_token: req.headers['x-refresh-token']};
            axios.post(url, body)
                .then(response => {
                    res.setHeader('Access-Control-Expose-Headers','authorization,x-refresh-token')
                        .setHeader("Authorization", `Bearer ${response.data.token}`)
                        .setHeader('x-refresh-token', response.data.refresh_token);
                });
        }
    } catch (e) {
        console.log(e);
        return res.status(e.response.data.code)
            .json(e.response.data.message);
    }
}
