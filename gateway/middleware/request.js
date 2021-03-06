const routesList = require("../routes/routeLists");
const axiosRequest = require('./axiosRequest')
module.exports = async (req, res, next) => {
    const params = req.params['0'].split('/');
    const filter = req.url.split('?').length > 1 ? '?'+req.url.split('?')[1] : '';
    params.forEach((e, index) => e.length === 0 ? params.splice(index, 1) : e);
    if (params.length <= 2) {
        let url = params.length === 1 ? routesList[params[0]] + filter : routesList[params[0]] + '/' + params[1] + filter;
        let headers = req.headers;
        if (params[0] === 'users' && req.method === "POST") {
            headers = {'Content-Type': 'application/json'};
        }
        const response = await axiosRequest(url, req, res, headers);
        res.status(response.status);
        res.json(response.data);
    }
}
