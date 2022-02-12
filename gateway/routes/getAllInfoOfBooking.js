var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const axios = require("axios");
const axiosRequest = require('../middleware/axiosRequest');

/* GET All info booking */
router.get('/:id', async function(req, res) {
    const bookingsRoute = routesList.bookings;
    const carsRoute = routesList.cars;
    const ordersRoute = routesList.orders;
    const paymentsRoute = routesList.payments;
    const stripeRoute = routesList.stripe;
    const awsRoute = routesList.aws;

    const booking = await axiosRequest(bookingsRoute+'/'+req.params.id,req,res);
    const cars = await axiosRequest(carsRoute+'/'+booking.data.car,req,res);
    const orders = await axiosRequest(ordersRoute+'?booking='+booking.data.id,req,res);
    const payments = await axiosRequest(paymentsRoute+'?orderId='+orders.data[0].id,req,res);
    const stripe = await axios({
        method: 'POST',
        url: stripeRoute+'/info',
        headers: req.headers,
        data: {idChargeStripe: payments.data[0].cbTransactionMethodStripe}
    });
    const aws = await axios({
        method: 'POST',
        url: awsRoute+'/download',
        headers: req.headers,
        data: {filePath: "voiture/"+cars.data.id}
    });
    if(cars.data && booking.data && stripe.data && payments.data && aws.data && orders.data){
        cars.data.images = aws.data
        res.status(200);
        res.json({
            booking: booking.data,
            car: cars.data,
            order: orders.data[0],
            stripe: stripe.data,
            payment: payments.data[0]
        });
    }else{
        res.status(404);
        res.json('Une erreur est survenue');
    }

});

module.exports = router;