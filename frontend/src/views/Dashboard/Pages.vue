<template>
  <div class="bg-gray-50 rounded-lg p-5 flex justify-between items-center mb-2">
    <h2 class="font-extrabold text-4xl">Pages</h2>
    <div><button class="rounded-lg bg-green-500 text-white p-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
</svg></button></div>
  </div>
  <Table entity="pages" titles="Titel,Permalink" columns="title:link(@id),route"/>
</template>

<script>
import Table from '../../components/admin/Table.vue'
export default {
  components: { Table },
  data(){
      return{
          content: undefined
      }
  },
  

}
</script>

<style>

</style>