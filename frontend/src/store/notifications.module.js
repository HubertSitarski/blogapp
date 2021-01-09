export const notifications = {
    state: {
        notifications: Array(),
    },
    mutations: {
        ADD_NOTIFICATION(state, notification) {
            state.notifications.push(notification)
        },
        REMOVE_NOTIFICATION(state, notification) {
            let i = state.notifications.map(item => item.id).indexOf(notification.id);
            state.notifications.splice(i, 1);
        }
    },
    actions: {
        addNotification({ commit, dispatch }, notification) {
            commit('ADD_NOTIFICATION', notification)
            setTimeout(() => {
                dispatch('removeNotification', notification)
            }, 4000)
        },
        removeNotification({ commit }, notification) {
            commit('REMOVE_NOTIFICATION', notification)
        }
    },
    getters: {
        getNotifications: (state) => {
            if(state.notifications){
                return state.notifications
            }
        },
    }
}