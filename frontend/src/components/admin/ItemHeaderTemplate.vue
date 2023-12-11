<template>
    <Card class="flex justify-between items-center mb-2">
      <h2 class="font-extrabold text-4xl">{{ title }}</h2>
    </Card>
    <div class="flex justify-between mb-2">
      <router-link :to="{ name: backLinkTo }">
        <button class="rounded-l-lg bg-white p-1">
          <font-awesome-icon :icon="icons.faChevronLeft" class="h-6 w-6 text-gray-500" />
        </button>
      </router-link>
      <div>
        <button
          v-if="!noDelete"
          @click="deleteItem"
          class="bg-white p-1 border-r border-l border-gray-200"
        >
        <font-awesome-icon :icon="icons.faTrash" class="h-6 w-6 text-gray-500" />
        </button>
        <button class="rounded-r-lg bg-white p-1" @click="updateItem">
          <font-awesome-icon :icon="icons.faArrowsRotate" class="h-6 w-6 text-gray-500" />
        </button>
      </div>
    </div>
</template>
<script>
import Card from "../../components/admin/Card.vue";
import { faArrowsRotate, faChevronLeft, faTrash, faPlus } from "@fortawesome/free-solid-svg-icons";
export default {
    components: {
        Card,
    },
    props: ["title","content", "backLinkTo","entity", "noDelete"],
    data() {
        return {
            icons: {
                faArrowsRotate,
                faChevronLeft,
                faTrash,
                faPlus,
            },
            isDragging: false,
        };
    },
    methods: {
        async deleteItem() {
            try{
                await this.callApi("delete", `/${this.entity}/${this.content.id}`);
                this.notifyUser("Item deleted");
                this.$router.push({ name: this.backLinkTo });
            }catch(e){
                console.log(e);
            }
        },
        async updateItem() {
            try{
                await this.callApi("put", `/${this.entity}/${this.content.id}`, this.content);
                this.notifyUser("Item updated");
            }catch(e){
                console.log(e);
            }
        }
    },
};
</script>