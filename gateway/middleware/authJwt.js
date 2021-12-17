const fs = require('fs');
const jwt = require('jsonwebtoken');
const refreshToken = require('./refreshToken');

module.exports = (req, res, next) => {
    const cert = fs.readFileSync('./jwt/public.pem');  // get public key
    jwt.verify(req.headers?.authorization?.split(' ')[1], cert, async function (err, decoded) {
        if (decoded || (req.path === "/users" && req.method === "POST")) {
            next();
        } else {
            if(!decoded){
                await refreshToken(req, res, decoded);
                next();
            }
            res.status(401);
            res.json({message: "Unauthorized JWT expire or not valid"});
        }
    });
}
