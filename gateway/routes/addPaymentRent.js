var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const axios = require("axios");
const sendMail = require("../Services/sendMail");

/* POST addPaymentRent  */
router.post('/', async function(req, res) {
    const bookingRoute = routesList.bookings;
    const orderRoute = routesList.orders;
    const paymentRoute = routesList.payments;
    const carsRoute = routesList.cars;

    try {
        const bookingCreate = await axios.post(bookingRoute,{
            startDate: req.body.rent.chooseDate[0],
            endDate: req.body.rent.chooseDate[1],
            user: req.body.user.id,
            car: req.body.rent.id,
            price: req.body.rent.price,
            kilometer: req.body.rent.kilometer
        });
        if(bookingCreate.status === 201){
            const order = await axios.post(orderRoute,{
                booking: bookingCreate.data.id,
                amount: req.body.paymentIntent.amount
            });
            if(order.status === 201){
                const payment = await axios.post(paymentRoute,{
                    orderId: parseInt(order.data.id),
                    cbTransactionStripe: req.body.paymentIntent.id,
                    cbTransactionMethodStripe: req.body.paymentMethod.id
                });
                if(payment.status === 201){
                    const rentCarStatus = await axios.put(carsRoute+'/'+req.body.rent.id,{rent: true});
                    const mailer = await sendMail(req.body.user.username,'Votre location','recap_car',{
                        car: {
                            ...req.body.rent,
                            amount: req.body.paymentIntent.amount,
                            ref: order.data.num
                        }
                    });
                    if(mailer.status === 200){
                        res.status(mailer.status)
                        res.json(true);
                    }
                }
            }
        }
    }catch(e){
        res.status(e.response.status);
        return res.json(e.response.data);
    }
});

module.exports = router;