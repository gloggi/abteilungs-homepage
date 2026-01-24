<template>
  <div class="mx-auto max-w-7xl pt-6">
    <PageHeader :title="$t('dashboard.menuFooterLinks')" />
    <div class="bg-gray-50 rounded-lg p-3">
      <MenuPicker />
    </div>
  </div>
</template>
<script>
import MenuPicker from "../../components/admin/MenuPicker.vue";
import PageHeader from "../../components/admin/PageHeader.vue";

export default {
  components: { MenuPicker, PageHeader },
  data() {
    return {};
  },
};
</script>
