<template>
    <div class="content__block" id="kontakt">
        <h2 style="margin-top: 0px;">{{formTitle}}</h2>
        <h3 v-if="error">Es gab einen Fehler bei der Übermittlung des Formulars.</h3>
        <h3 v-if="success">Vielen Dank, die Nachricht wurde verschickt.</h3>
        <form @submit.prevent="validateForm" v-if="!success">
            <ul>
                <li :key="index" v-for="(field,index) in formFields">
                    <label :for="'field-'+index">{{field.name}} {{field.required ? '*':''}}</label>
                    <textarea v-model="field.answer" v-if="field.type=='textarea'" type="text" :name="'field-'+index" :id="'field-'+index"
                              value="" required="required" class="form-control"/>
                    <select v-model="field.answer" v-if="field.type=='gender'" type="text" :name="'field-'+index" :id="'field-'+index" value=""
                            required="required" class="form-control">
                        <option value="m">m</option>
                        <option value="f">f</option>
                        <option value="x">x</option>
                    </select>
                    <select v-model="field.answer" v-if="field.type=='clothing-size'" type="text" :name="'field-'+index" :id="'field-'+index"
                            value="" required="required" class="form-control">
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                    <input v-model="field.answer" v-if="field.type=='text'||field.type=='number'||field.type=='tel'||field.type=='date'||field.type=='email'"
                           :type="field.type" :name="'field-'+index" :id="'field-'+index" value=""
                           :required="field.required ? 'required':''" class="form-control"/>
                </li>
            </ul>
            <template v-if="recaptchaSiteKey&&useRecaptcha">
                <vue-recaptcha @verify="response=>{this.responseKey=response}"
                               :sitekey="recaptchaSiteKey"
                               :loadRecaptchaScript="true"></vue-recaptcha>
            </template>
            <button type="submit" class="button" name="submit" value="1">Absenden</button>
        </form>
    </div>
</template>

<script>
    import VueRecaptcha from 'vue-recaptcha'
export default {
    name: "FormFields",
    components:{VueRecaptcha},
    props: ["formFields", "formTitle", "recaptchaSiteKey", "useRecaptcha", "formEmail"],
    data(){
        return{
            responseKey: null,
            success: null,
            error: false
        }
    },
    methods:{
        validateForm(){
            var data = {
                useRecaptcha: this.useRecaptcha,
                responseKey: this.responseKey,
                formTitle: this.formTitle,
                formEmail: this.formEmail,
                formFields: this.formFields
            }
            this.$http.post('custom/form', data).then(response=>{
                this.success= response.data.data.success
                this.error = !this.success
            }, error=>{
                this.error=!error.ok
            })
        }
    }
}
</script>

<style scoped>

</style>