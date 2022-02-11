var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const FormData = require('form-data');
const fetch = require('node-fetch');
const axiosRequest = require("../middleware/axiosRequest");

/* POST AddCar */
router.post('/', function(req, res) {
    const aws = routesList.aws+'/upload';
    const carRouter = routesList.cars;
    const formData = new FormData();

    if(req.body.hasOwnProperty('image')){
        const {image,path} = req.body;
        formData.append('file[]', image);
        formData.append('path', path);
        fetch(aws, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                res.status(response.status)
                res.json(response.data);
            })
            .then(data => console.log(data))
            .catch(err => console.log(err));
    }else{
        console.log(req.body);
        axiosRequest(carRouter,req,res)
            .then(response => {
                res.status(response.status);
                res.json(response.data);
            })
            .catch(err => console.log(err))
    }
});

module.exports = router;
