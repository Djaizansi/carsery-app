const express = require('express');
const router = express.Router();
const request = require('../middleware/request')

router.all('*', async function (req, res, next) {
  await request(req, res, next);
  next();
})

module.exports = router;
