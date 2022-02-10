var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const axiosRequest = require('../middleware/axiosRequest');

/* POST ActivationAccount */
router.get('/', function(req, res) {
    const users = routesList.users+"?type=pro";
    const userPro = [];
    axiosRequest(users,req,res)
        .then(response => {
            response.data.map(user => {
                userPro.push({
                    id:user.id,
                    company:user.company
                })
            })
            hasCar(userPro,req,res);
        })
        .catch(err => console.log(err));

});

function hasCar(userPro,req,res){
    const usersGetCars = [];
    userPro.map(user => {
        const cars = routesList.cars+"?user="+user.id;
        axiosRequest(cars,req,res)
            .then(response => {
                if(response.data.length > 0){
                    user.cars = response.data;
                    usersGetCars.push(user);
                    res.status(response.status);
                    res.json(usersGetCars);
                }
            })
            .catch(err => console.log(err));
    })
}

module.exports = router;