const routesList = require('../routes/routeLists');
const axios = require("axios");

module.exports = async (email,subject,template,data) => {
    const mail = routesList.mail+'/send';
    return await axios.post(mail,{
        email: email,
        subject: subject,
        template: template,
        data: data
    })
}