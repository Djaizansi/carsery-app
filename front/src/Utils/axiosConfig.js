import axios from "axios";
import VueCookies from "vue-cookies";

export default function(){
    axios.interceptors.response.use(function(response){
        return response;
    }, function (error){
        if (401 === error.response.status){
            return Promise.resolve(error.response);
        }else{
            return Promise.reject(error);
        }
    });

    axios.interceptors.request.use(
        config => {
            config.headers['Content-Type'] = 'application/json';
            config.headers.Accept = 'application/json';
            if (VueCookies.VueCookies?.get('refresh-token') && VueCookies.VueCookies?.get('token')){
                config.headers['x-refresh-token'] = VueCookies.VueCookies.get('refresh-token');
                config.headers.Authorization = 'Bearer ' + VueCookies.VueCookies.get('token');
            }
            return config;
        },
        error => {
            return Promise.reject(error);
        })
}
