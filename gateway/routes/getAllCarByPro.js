var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const axiosRequest = require('../middleware/axiosRequest');

/* POST ActivationAccount */
router.get('/', async function(req, res) {
    const users = routesList.users+"?type=pro";
    const userPro = [];
    const usersPro = await axiosRequest(users,req,res);
    usersPro.data.map(user => {
        userPro.push({
            id:user.id,
            company:user.company
        })
    });
    const getCarsByUser = await hasCar(userPro,req,res);
    res.json(getCarsByUser);
    res.json(200);
});

async function hasCar(userPro,req,res){
    const usersGetCars = [];
    for(let user of userPro){
        const cars = routesList.cars+"?user="+user.id;
        const carsUser = await axiosRequest(cars,req,res);
        if(carsUser.data.length > 0){
            user.cars = carsUser.data;
            usersGetCars.push(user);
        }
    }
    return usersGetCars;
}

module.exports = router;