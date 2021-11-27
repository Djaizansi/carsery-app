const httpError = require('http-errors');
const fs = require('fs');
const jwt = require('jsonwebtoken')

module.exports = (req,res,next) => {
    const cert = fs.readFileSync('./jwt/public.pem');  // get public key
    jwt.verify(req.headers?.authorization.split(' ')[1], cert, function(err, decoded) {
        if(decoded){
            req.user = decoded;
            next();
        }else{
            res.json({message: "Une erreur est survenue"});
        }
    });
}
