var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const axiosRequest = require('../middleware/axiosRequest');

/* POST login */
router.post('/', async function(req, res) {
    const url = routesList.login;
    const headers = {
        "Content-type": "application/json"
    }
    const response = await axiosRequest(url,req,res,headers);//req.headers);
    res.status(response.status);
    res.json(response.data);
});

module.exports = router;
