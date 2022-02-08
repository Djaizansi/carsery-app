import axios from "axios";
import VueCookie from "vue-cookie";
import store from '../store';

export default function(router){
    axios.interceptors.response.use(function(response){
        if (response.headers?.authorization !== "null") {
            VueCookie.set('token', response.headers?.authorization);
        }
        return response;
    }, function (error){
        if (error.response.status === 401 && error.response.data.message === "Expired JWT Token") {
            ['user_get','token','refresh_token'].map(cookie => VueCookie.delete(cookie));
            store.commit('SET_USER','');
            return router.push('/');
        }
        return Promise.resolve(error.response);
    });

    axios.interceptors.request.use(
        config => {
            config.headers['Content-Type'] = config.data instanceof FormData ? 'multipart/form-data' : 'application/json';
            config.headers.Accept = config.data instanceof FormData ? 'multipart/form-data' : 'application/json';
            config.headers['x-refresh-token'] = VueCookie.get('refresh_token');
            config.headers.Authorization = 'Bearer ' + VueCookie.get('token');
            return config;
        },
        error => {
            return Promise.reject(error);
        })
}
