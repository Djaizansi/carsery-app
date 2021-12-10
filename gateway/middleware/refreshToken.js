const routeLists = require('../routes/routeLists');
const axios = require('axios');

module.exports = async function (req, res, decoded) {
    try {
        if (decoded && req.headers.authorization && req.headers['refresh-token']) {
            const url = routeLists.refreshToken;
            const body = {refresh_token: req.headers['refresh-token']};
            const response = await axios.post(url, body);
            res.setHeader("Authorization", `Bearer ${response.data.token}`)
                .setHeader('refresh-token', response.data.refresh_token);
        }
    } catch (e) {
        console.log(e);
        return res.status(e.response.data.code)
            .json(e.response.data.message);
    }
}
