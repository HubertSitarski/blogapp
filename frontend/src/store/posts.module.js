import localforage from 'localforage'
import axios from 'axios'

export const posts = {
    state: {
        posts: [],
        post: null,
    },
    mutations: {
        SET_POSTS(state, content) {
            state.posts = content
        },
        SET_POST(state, content) {
            state.post = content
        }
    },
    actions: {
        fetchPosts({ commit }) {
            return localforage.getItem('authUser').then((headers) => {
                return axios.get( process.env.VUE_APP_API+'api/posts', { headers })
                    .then((response) => {
                        commit('SET_POSTS', response.data.data)
                    })
                    .catch((e) => {
                        console.error(e);
                    })
            })
        },
        fetchPost({ commit }, payload) {
            return localforage.getItem('authUser').then((headers) => {
                return axios.put(process.env.VUE_APP_API + `api/posts/${payload.id}`, payload, {headers})
                    .then((response) => {
                        if (response.status === 200) {
                            commit('SET_POST', response.data.data)
                        } else {
                            console.error(response.data)
                        }
                    })
                    .catch(error => {
                        console.error(error)
                    })
            })
        },
        createPost({ commit }, payload) {
            return localforage.getItem('authUser').then((headers) => {
                const formData = new FormData()
                Object.keys(payload).forEach(e => {
                    if (Array.isArray(payload[e])) {
                        let counter = 0
                        payload[e].forEach(el => {
                            formData.append(e + '[' + counter.toString() + ']', el)
                            counter += 1
                        })
                    } else {
                        formData.append(e, payload[e])
                    }
                })

                return axios.post(process.env.VUE_APP_API + `api/posts`, formData, {headers})
                    .then((response) => {
                        if (response.status === 201) {
                            commit('SET_POST', response.data.data)
                        } else {
                            console.error(response)
                        }
                    })
                    .catch(error => {
                        console.error(error)
                    })
            })
        },
        removePost({ commit }, payload) {
            return localforage.getItem('authUser').then((headers) => {
                return axios.delete( process.env.VUE_APP_API+`api/posts/${payload.id}`, { headers })
                    .then(() => {
                        axios.get( process.env.VUE_APP_API+'api/posts', { headers })
                            .then((response) => {
                                commit('SET_POSTS', response.data.data)
                            })
                            .catch((e) => {
                                console.error(e);
                            })
                    })
                    .catch((e) => {
                        console.error(e);
                    })
            })
        },
    },
    getters: {
        getPosts: (state) => {
            if(state.posts){
                return state.posts
            }
        },
        getPost: (state) => {
            if(state.post){
                return state.post
            }
        }
    }
}