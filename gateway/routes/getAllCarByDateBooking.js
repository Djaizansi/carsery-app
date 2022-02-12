var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const axiosRequest = require('../middleware/axiosRequest');
const axios = require("axios");

/* GET All cars by date bookingx */
router.get('/', async function(req, res) {
    const cars = routesList.cars+"?status=true";
    const aws = routesList.aws+'/download';
    const routeBookings = routesList.bookings;

    const bookings = await getBookings(routeBookings,req,res);
    let getCars = await getCar(cars,aws,req,res);
    if(bookings.length > 0 && getCars.length > 0 && !getCars.includes('')){
        bookings.map(booking => {
            getCars = getCars.filter(car => car.id !== booking.car);
        });
        getCars = getCars.length === 0 ? [''] : getCars;
        res.json(getCars);
        res.status(200);
    }else {
        res.json(getCars);
        res.status(200);
    }
});

async function getCar(url,urlImage,req,res){
    const cars = await axiosRequest(url,req,res,{'Content-Type': 'application/json'});
    const resultCars = cars.data['hydra:member'];
    const allCars = [];
    if(resultCars.length > 0){
        for(let car of resultCars){
            const images = await axios.post(urlImage,{"filePath":"voiture/"+car.id},{'Content-Type': 'application/json'});
            car.images = images.data;
            allCars.push(car);
        }
        return allCars;
    }else{
        return [""];
    }
}

async function getBookings(url,req,res){
    const {startDate, endDate} = req.query;
    const bookings = await axiosRequest(url,req,res,{'Content-Type': 'application/json'});
    let allBookings = [];
    if(bookings.data["hydra:member"].length > 0){
        for(let booking of bookings.data["hydra:member"]){
            const startBooking = booking.startDate;
            const endBooking = booking.endDate;
            if((startBooking <= startDate || startBooking >= endDate) && (endBooking >= startDate || endBooking <= endDate) && (startBooking >= startDate || endBooking <= endDate)){
            }else{
                allBookings.push(booking);
            }
        }
        return allBookings;
    }
    return allBookings;
}

module.exports = router;