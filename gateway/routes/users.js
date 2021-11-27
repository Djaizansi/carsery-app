var express = require('express');
var router = express.Router();
const routesList = require('./routeLists');
const getRequest = require('../middleware/request');
const authJwt = require('../middleware/authJwt');

/* GET users listing. */
router.post('/login', async function(req, res, next) {
  const url = routesList.BASE_URL + routesList.users.routes.login;
  const data = await getRequest(url,req,res);
  res.json({
    logged: true,
    token: data.token
  });
});

router.get('/', authJwt, async function(req,res,next){
  const url = routesList.BASE_URL + routesList.users.routes.getUsers;
  const data = await getRequest(url,req,res);
  res.json(data);
})

module.exports = router;
