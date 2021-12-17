var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const axiosRequest = require('../middleware/axiosRequest');

/* POST login */
router.post('/', function(req, res) {
    const url = routesList.login;
    axiosRequest(url,req,res)
        .then(response => {
            res.status(response.status);
            res.json(response.data);
        })
});

module.exports = router;
