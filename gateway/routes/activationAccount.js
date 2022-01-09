var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const axiosRequest = require('../middleware/axiosRequest');

/* POST ActivationAccount */
router.post('/', function(req, res) {
    const url = routesList.activationAccount;
    axiosRequest(url,req,res,{'Content-Type': 'application/json'})
        .then(response => {
            res.status(response.status);
            res.json(response.data);
        })
        .catch(err => console.log(err))
});

module.exports = router;
