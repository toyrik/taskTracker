import { createStore } from 'vuex'
import createPersistedState from "vuex-persistedstate";

const store = createStore({
    state () {
      return {
        user: {
            "src": "https://cdn.vuetifyjs.com/images/john.jpg",
            "alt": "John"
        },
        isAutheticated: false,
        alert: {
            value: false,
            type: 'success',
            text: '',
        }
      }
    },
    getters:{
        GET_USER(state){
            return state.user;
        },
        GET_IS_AUTHENTICATED(state){
            return state.isAutheticated;
        },
        GET_ALERT(state){
            return state.alert;
        },
    },
    mutations:{
        MUTATE_USER(state, payload) {
            state.user = payload
        },
        MUTATE_IS_AUTHENTICATED(state, payload) {
            state.isAutheticated = payload
        },
        MUTATE_ALERT(state, payload) {
            state.alert = payload
        },
    },
    actions:{
        UPDATE_USER({ commit }, payload) {
            commit('MUTATE_USER', payload);
        },
        RESET_USER({ commit }) {
            commit('MUTATE_USER', {
                "src": "https://cdn.vuetifyjs.com/images/john.jpg",
                "alt": "John"
            });
            commit('MUTATE_IS_AUTHENTICATED', false)
        },
        UPDATE_IS_AUTHENTICATED({ commit }, payload) {
            commit('MUTATE_IS_AUTHENTICATED', payload);
        },
        UPDATE_ALERT({ commit }, payload) {
            commit('MUTATE_ALERT', payload);
            setTimeout(() => {
                commit('MUTATE_ALERT', {
                    value: false,
                    type: 'success',
                    text: '',
                })
            }, 2700)
        },
    },

    plugins: [createPersistedState()]
})

export default store