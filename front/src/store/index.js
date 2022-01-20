import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: ""
    },
    plugins: [createPersistedState()],
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
