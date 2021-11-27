var express = require('express');
var cookieParser = require('cookie-parser');
var logger = require('morgan');

var indexRouter = require('./routes/index');
var usersRouter = require('./routes/users');
// var carsRouter = require('./routes/cars');
// var ordersRouter = require('./routes/orders');
// var paymentsRouter = require('./routes/payments');

var app = express();

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());

app.use((req,res,next) => {
    next();
});

app.use('/', indexRouter);
app.use('/users', usersRouter);
// app.use('/cars', carsRouter);
// app.use('/orders', ordersRouter);
// app.use('/payments', paymentsRouter);



module.exports = app;
