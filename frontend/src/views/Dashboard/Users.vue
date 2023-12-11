<template>
    <OverviewTemplate
      name="Users"
      entity="users"
      titles="Nickname,First Name,Last Name,E-Mail"
      columns="nickname:link(id),firstname,lastname,email"
      pushAfterCreationTo="User" />
  </template>
  
  <script>
  import OverviewTemplate from '../../components/admin/OverviewTemplate.vue';
  
  
  export default {
    components: { OverviewTemplate },
    
  };
  </script>
  
  <style>
  </style>