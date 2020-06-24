<template>
    <div class="footer">
        <div class="footer__content">
            <div class="footer__column">
                <h3 class="heading--footer">{{settings[0].footer_group_list_title}}</h3>
                <ul>
                    <li v-for="group in groups" :key="group.id"><a href="#">{{group.name}}</a></li>
                </ul>
            </div>
            <div class="footer__column">
                <h3 class="heading--footer">Kontakt</h3>
                <div v-html="settings[0].footer_contact"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Footer",
        props: ['groups', 'settings']
    }
</script>

<style scoped>

</style>