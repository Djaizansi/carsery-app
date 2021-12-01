const routesList = require("../routes/routeLists");
const axiosRequest = require('./axiosRequest')
module.exports = async (req, res, next) => {
    // On split pour récuperer les différents paramètres de notre routes
    const params = req.params['0'].split('/');
    // On supprime les éléments vide -> ''
    params.forEach((e, index) => e.length === 0 ? params.splice(index, 1) : e);

    let headers = {'Content-Type': 'application/json'};
    if(req.headers.authorization) headers = {...headers, "Authorization": req.headers.authorization};
    if (params.length <= 2) {
        let url = params.length === 1 ? routesList[params[0]] : routesList[params[0]] + params[1];
        const response = await axiosRequest(url, req, res, headers);
        res.status(response.status)
        res.json(response.data)
    }
}
