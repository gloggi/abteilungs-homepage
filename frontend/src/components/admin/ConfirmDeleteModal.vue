<template>
  <Modal :title="title || $t('dashboard.deleteItem')" @close="$emit('close')">
    <p class="text-gray-600 mb-6">
      {{ message || $t('dashboard.confirmDeleteItem') }}
    </p>
    <template #footer>
      <div class="flex justify-end space-x-3 mt-6">
        <ButtonComponent variant="outline-solid" @click="$emit('close')">
          {{ $t("dashboard.cancel") }}
        </ButtonComponent>
        <ButtonComponent variant="destructive" @click="$emit('confirm')">
          {{ $t("dashboard.delete") }}
        </ButtonComponent>
      </div>
    </template>
  </Modal>
</template>

<script>
import Modal from "./Modal.vue";
import ButtonComponent from "./ButtonComponent.vue";

export default {
  components: {
    Modal,
    ButtonComponent,
  },
  emits: ["close", "confirm"],
  props: {
    title: {
      type: String,
      default: "",
    },
    message: {
      type: String,
      default: "",
    },
  },
};
</script>
