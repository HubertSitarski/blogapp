import localforage from 'localforage'
import axios from 'axios'

export const users = {
    state: {
        user: null,
    },
    mutations: {
        SET_USER(state, content) {
            state.user = content
        }
    },
    actions: {
        fetchUser({ commit }, payload) {
            return localforage.getItem('authUser').then((headers) => {
                return axios.get( process.env.VUE_APP_API+`api/profile/${payload.id}`, { headers })
                    .then((response) => {
                        commit('SET_USER', response.data.data)
                    })
                    .catch((e) => {
                        console.error(e);
                    })
            })
        },
        updateUser({ commit }, payload) {
            return localforage.getItem('authUser').then((headers) => {
                return axios.put(process.env.VUE_APP_API + `api/profile/${payload.id}`, payload, {headers})
                    .then((response) => {
                        if (response.status === 200) {
                            commit('SET_USER', response.data.data)
                        } else {
                            console.error(response.data)
                        }
                    })
                    .catch(error => {
                        console.error(error)
                    })
            })
        }
    },
    getters: {
        getUser: (state) => {
            if(state.user){
                return state.user
            }
        }
    }
}