var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const axiosRequest = require('../middleware/axiosRequest');

/* GET All cars by date booking and user */
router.get('/:id', async function(req, res) {
    const bookingsRoute = routesList.bookings;
    const carsRoute = routesList.cars;
    const id = req.params.id;
    const type = req.query.type;
    const now = new Date();
    const bookingsUser = await axiosRequest(bookingsRoute+'?user='+id,req,res);
    const allCars = [];
    if(bookingsUser.data.length > 0){
        for(let booking of bookingsUser.data){
            const cars = await getCarByType(carsRoute,booking,now,type,req,res);
            if(cars.hasOwnProperty('data')){
                const objCars = cars.data;
                objCars.datesRent = [new Date(booking.startDate),new Date(booking.endDate)];
                objCars.idBooking = booking.id;
                allCars.push(objCars);
            }
        }
        res.status(200);
        res.json(allCars);
    }else{
        res.status(200);
        res.json(allCars);
    }
});

async function getCarByType(url,booking,now,type,req,res) {
    const endDate = new Date(booking.endDate);
    const condition = type === 'historic' ? endDate < now : endDate > now;
    if(condition){
        return await axiosRequest(url+'/'+booking.car,req,res);
    }else{
        return [];
    }
}

module.exports = router;