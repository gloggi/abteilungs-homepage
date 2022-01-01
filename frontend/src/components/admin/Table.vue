<template>
  <div :key="`table-${tableKey}`" class="bg-gray-50 w-full flex justify-between items-center p-3 rounded-t-md">
     <div class="w-10"><input type="checkbox" 
     v-model="topCheckboxValue"
     @change="topCheckboxHandler"
  class="rounded focus:ring-0 focus:shadow-none ring-offset-0 text-gray-900"></div>
    <div
      v-for="(key, i) in getTitles"
      :key="`text-${i}`"
      class="text"
      :style="`width: ${columnWidth}%;`"
    >
      {{ key }}
    </div>
  </div>
  <hr />
  <div v-if="totalItems==0" class="bg-white w-full p-3 border-b ">
    No items avaiable
  </div>
  <div
    v-for="(item, j) in content"
    :key="`row-${j}`"
    class="bg-white w-full p-3 border-b flex justify-between"
  >
  <div class="w-10"><input type="checkbox" @change="(e)=>changeBox(e, item['@id'])" v-model="checkBoxValues[item['@id']]"
  class="rounded focus:ring-0 focus:shadow-none ring-offset-0 text-gray-900"></div>
    <div
      v-for="(key, i) in keys"
      :key="`text-${j}-${i}`"
      class="text"
      :style="`width: ${columnWidth}%;`"
    >
      <template v-if="actions[key] && actions[key].actionName == 'link'">
        <router-link
          class="text-sm text-blue-600 hover:text-blue-900"
          :to="`${item[actions[key].actionArgument].substr(1)}`"
          >{{ item[key] }}</router-link
        >
      </template>
      <template v-else>
        <div class="text-sm text-gray-500">{{ item[key] }}</div>
      </template>
    </div>
  </div>
  <div v-if="Math.ceil(totalItems / itemsPerPage)>1" class="flex rounded-lg p-3 bg-white mt-2" :key="paginationKey">
    <Button v-for="i in Math.ceil(totalItems / itemsPerPage)" @click="()=>goToPage(i)" class="p-2 w-10 h-10 bg-white rounded-lg mr-1" :key="i">
      {{ i }}
    </Button>
  </div>

</template>

<script>
import Button from './Button.vue';
export default {
  components: { Button },
  props: ["entity", "columns", "titles"],
  emits:["changeSelected"],
  data() {
    return {
      content: undefined,
      keys: undefined,
      actions: {},
      page: 1,
      totalItems: -1,
      itemsPerPage: 1,
      paginationKey: 0,
      topCheckboxValue: false,
      checkBoxValues: {},
      tableKey: 0,
      selected: new Set([])
    };
  },
  computed: {
    columnWidth() {
      return parseInt(90 / this.columns.split(",").length);
    },
    getTitles() {
      return this.titles.split(",");
    },
  },
  methods: {
      changeBox(event, iri){
          if(event.target.checked){
              this.selected.add(iri)
          }else{
              this.selected.delete(iri)
          }
          this.$emit("changeSelected", Array.from(this.selected))
      },
      topCheckboxHandler(){
          if(this.topCheckboxValue){
              Object.keys(this.checkBoxValues).forEach((cbv)=>this.checkBoxValues[cbv]=true)
              this.selected = new Set(Object.keys(this.checkBoxValues))
              this.$emit("changeSelected", Array.from(this.selected))
              this.tableKey++
          }else{
              Object.keys(this.checkBoxValues).forEach((cbv)=>this.checkBoxValues[cbv]=false)
              this.selected = new Set([])
              this.$emit("changeSelected", Array.from(this.selected))
              this.tableKey++
              
          }
      },
      setUpBoxes(){
          this.content.forEach((item)=>{
              this.checkBoxValues[item["@id"]] = false
          })
      },
      goToPage(i){
          this.page = i
          this.getItems()
          window.scrollTo(0, 0);
      },
    async getItems() {
      try {
        const response = await this.callApi(
          "get",
          `/${this.entity}/?page=${this.page}`
        );
        console.log(this.entity)
        if(response.status==204){
            this.page = 1
            this.getItems();
            return
        }
        this.content = response.data["hydra:member"];
        this.totalItems = response.data["hydra:totalItems"];
        if(this.content.length>this.itemsPerPage){
            this.itemsPerPage = this.content.length;
        }
        this.tableKey++
        this.paginationKey++;
        console.log(this.content);
      } catch (e) {
        console.log(e);
      }
    },
    entryProcesser() {
      const columns = this.columns.split(",");
      this.keys = columns.map((column) => {
        if (column.split(":").length == 1) {
          return column;
        } else {
          const [c, action] = column.split(":");
          const [actionName, actionArgument] = action.split(/\(|\)/);
          this.actions[c] = { actionName, actionArgument };

          return c;
        }
      });
    },
  },
  async created() {
    await this.getItems();
    this.setUpBoxes();
    this.entryProcesser();
  },
};
</script>

<style>
</style>