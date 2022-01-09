import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: ""
    },
    mutations: {
        SET_USER(state,payload){
            if(payload !== ''){
                state.user = JSON.parse(payload);
            }else {
                state.user = payload;
            }
        },
    },
    actions: {

    }
})
