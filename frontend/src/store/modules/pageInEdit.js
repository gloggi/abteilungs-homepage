import {api} from '../../mixins';

export const pageInEdit = {
    namespaced: true,
    state() {
        return {
            page: undefined,
        }
    },
    mutations: {
        setPage(state, page){
            state.page = page
        },
        updateItem(state, newItem){
            if(!state.page){
                return
            }
            if(Object.keys(newItem).length===1&&newItem.id){
                state.page.page_items = state.page.page_items.filter(item=>item.id!=newItem.id);
              }else{
                const index = state.page.page_items.findIndex(item=>item.id===newItem.id);
                state.page.page_items[index] = newItem
              }
              this.dispatch("pageInEdit/updatePage")
        },
        addItem(state, type){
            state.page.page_items.push({type})
            this.dispatch("pageInEdit/updatePage")
        }
    },
    actions: {
        async getPage({commit}, id){
            try{
                const response = await api({method:"get", url:`pages/${id}`})
                commit("setPage",response.data)
                
            }catch(e){
                console.log(e)
            }
            
        },
        async updatePage({state, dispatch}){
            try{
                await api({method:"put", url:`pages/${state.page.id}`, data: state.page})
                dispatch("getPage",state.page.id)
                
            }catch(e){
                console.log(e)
            }
            
        }
    },
    getters: {}
}