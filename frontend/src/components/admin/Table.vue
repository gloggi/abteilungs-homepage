<template>
  <div class="bg-gray-50 w-full flex justify-between p-3 rounded-t-md">
      <div v-for="(key, i) in getTitles" :key="`text-${i}`" class="text" :style="`width: ${columnWidth}%;`"> {{key}}</div>
  </div>
  <hr>
  <div v-for="(item, j) in content" :key="`row-${j}`" class="bg-white w-full flex justify-between p-3 border-b">
      <div v-for="(key, i) in keys" :key="`text-${j}-${i}`" class="text" :style="`width: ${columnWidth}%;`"> 
          <template v-if="( actions[key] && actions[key].actionName=='link')">
              <router-link class="text-sm text-blue-600 hover:text-blue-900" :to="`${item[actions[key].actionArgument].substr(1)}`">{{item[key]}}</router-link>
          </template>
          <template v-else>
            <div class="text-sm text-gray-500">{{item[key]}}</div>
          </template>
          </div>
  </div>
</template>

<script>
export default {
    props: ["entity", "columns", "titles"],
    data(){
        return {
            content: undefined,
            keys: undefined,
            actions: {}
        }
    },
    computed:{
        columnWidth(){
            return parseInt(100/this.columns.split(",").length)
        },
        getTitles(){
            return this.titles.split(",")
        }

    },
    methods:{
      async getItems(){
          try{
              const response = await this.callApi("get", `/${this.entity}`)
              this.content = response.data["hydra:member"]
              console.log(this.content)
          }catch(e){
              console.log(e)

          }
      },
      entryProcesser(){
          const columns = this.columns.split(",")
          this.keys = columns.map((column)=>{
              if(column.split(":").length==1){
                  return column
              }else{
                  const [c, action] = column.split(":")
                  const [actionName, actionArgument] = action.split(/\(|\)/)
                  this.actions[c]= {actionName, actionArgument}

                  return c
              }

          })

      }
  },
  async created(){
      await this.getItems()
      this.entryProcesser()
  }

}
</script>

<style>

</style>