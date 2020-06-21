<template>
    <div class="contact__container">
        <div v-for="contact in contacts" class="contact" :key="contact.id">
            <div class="contact__text">
                <h3>{{contact.function}}</h3>
                <p>{{contact.name}}</p>
                <p><a :href="'mailto:'+contact.email">{{contact.email}}</a></p>
            </div>
            <img class="contact__image" :title="contact.name" :src="contact.image.data.full_url"
                 :alt="contact.function">
        </div>
    </div>
</template>

<script>
    export default {
        name: "ContactContainer",
        props: ["contacts"]
    }
</script>

<style scoped>

</style>