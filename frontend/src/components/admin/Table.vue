<template>
  <div :key="`table-${tableKey}`" class="bg-gray-50 w-full flex justify-between items-center p-3 rounded-t-md">
     <div class="w-10"><input type="checkbox"
      ref="masterbox" 
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
    No items available.
  </div>
  <div
    v-for="(item, j) in content"
    :key="`row-${j}`"
    class="bg-white w-full p-3 border-b flex justify-between items-center"
  >
  <div class="w-10"><input type="checkbox" @change="(e)=>changeBox(e, item['id'])" v-model="checkBoxValues[item['id']]"
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
          :to="`${entity}/${item[actions[key].actionArgument]}`"
          >{{ item[key] || 'No name provided' }}</router-link
        >
      </template>
      <template v-if="actions[key] && actions[key].actionName == 'image'">
       <div v-if="item[key]" class="flex justify-start items-center">
        <img class="h-10 rounded-lg" :src="`${backendURL}${item[key].thumbnail}`"/>
      </div>
      </template>
      <template v-if="!actions[key]">
        <div class="text-sm text-gray-500">{{ getValue(item, key) }}</div>
      </template>
    </div>
  </div>
  <PaginationNav :pageNumber="page" :itemsPerPage="itemsPerPage" :totalItems="totalItems" @goToPage="(i)=>goToPage(i)"/>

</template>

<script>
import {get} from "lodash"
/* import Button from './Button.vue'; */
import PaginationNav from './PaginationNav.vue'
export default {
  components: { /* Button, */ PaginationNav },
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
  watch: {
    checkBoxValues: {
      handler(newValue) {
        if(Object.values(newValue).every((value) => value === true)){
          this.$refs.masterbox.checked = true;
        }else{
          this.$refs.masterbox.checked = false;
        }
      },
      deep: true
    }
  },
  methods: {
    getValue(obj,key){
      return get(obj, key)
    },
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
              this.checkBoxValues[item["id"]] = false
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
        if(response.status==204){
            this.page = 1
            this.getItems();
            return
        }
        this.content = response.data.data;
        this.totalItems = response.data.meta.total;
        if(this.content.length>this.itemsPerPage){
            this.itemsPerPage = this.content.length;
        }
        this.tableKey++
        this.paginationKey++;
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