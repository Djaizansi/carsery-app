const express = require('express');
const cookieParser = require('cookie-parser');
const logger = require('morgan');
const cors = require('cors');
const authJwt = require('./middleware/authJwt');
const login = require('./routes/login');
const activationAccount = require('./routes/activationAccount');
const addCar = require('./routes/addCar');
const getAllCarByPro = require('./routes/getAllCarByPro');
const getAllCarByDateBooking = require('./routes/getAllCarByDateBooking');
const addPaymentRent = require('./routes/addPaymentRent');
const fileUpload = require('express-fileupload');

var indexRouter = require('./routes/index');

var app = express();

app.use(cors());

app.use(logger('dev'));
app.use(express.urlencoded({ extended: false,limit: '50mb'}));
app.use(express.json({limit: '50mb'}));
app.use(cookieParser());
app.use(fileUpload());

app.use((req,res,next) => {
    next();
});

app.use('/login',login);
app.use('/activation',activationAccount);
app.use('/getCarByDateBooking',getAllCarByDateBooking);
app.use('/addPaymentRent',authJwt,addPaymentRent);
app.use('/addCar',authJwt,addCar);
app.use('/getAllCarByPro',authJwt,getAllCarByPro);
app.use('/', authJwt, indexRouter);

module.exports = app;
