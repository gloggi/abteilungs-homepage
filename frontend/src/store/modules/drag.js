export const drag = {
    namespaced: true,
    state() {
        return {
            dragging: false
        }
    },
    mutations: {
        startDragging(state){
            state.dragging = true
        },
        stopDragging(state){
            state.dragging = false
        }
    },
    actions: {},
    getters: {}
}