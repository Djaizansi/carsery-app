const fs = require('fs');
const jwt = require('jsonwebtoken');
const refreshToken = require('./refreshToken');

module.exports = (req, res, next) => {
    const cert = fs.readFileSync('./jwt/public.pem');  // get public key
    const token = req.headers?.authorization?.split(' ')[1]; // BEARER Token -> get only token
    jwt.verify(token, cert, async function (err, decoded) {
        if (decoded || (req.path === "/users" && req.method === "POST")) {
            //console.log('coucou');
            if (!(req.path === "/users" && req.method === "POST")) {
                req.headers['authorization'] = "Bearer " + token;
                res.setHeader("Access-Control-Expose-Headers", 'authorization').setHeader("authorization", null)
                    .setHeader("x-refresh-token", null);
            }
            next();
        } else {
            //console.log('orv');
            if(!decoded){
                //console.log('not decoded');
                await refreshToken(req, res, decoded);
                next();
            }else{
                //console.log('401 error');
                res.status(401);
                res.json({message: "Unauthorized JWT expire or not valid"});
            }
        }
    });
}
