<template>
    <div class="content__block" id="kontakt">
        <h2 style="margin-top: 0px;">Formular</h2>
        <form>
            <ul>
                <li :key="index" v-for="(field,index) in form_fields">
                    <label :for="'field-'+index">{{field.name}} {{field.required ? '*':''}}</label>
                    <textarea v-if="field.type=='textarea'" type="text" :name="'field-'+index" :id="'field-'+index"
                              value="" required="required" class="form-control"/>
                    <select v-if="field.type=='gender'" type="text" :name="'field-'+index" :id="'field-'+index" value=""
                            required="required" class="form-control">
                        <option value="m">m</option>
                        <option value="f">f</option>
                        <option value="x">x</option>
                    </select>
                    <select v-if="field.type=='clothing-size'" type="text" :name="'field-'+index" :id="'field-'+index"
                            value="" required="required" class="form-control">
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                    <input v-if="field.type=='text'||field.type=='number'||field.type=='tel'||field.type=='date'||field.type=='email'"
                           :type="field.type" :name="'field-'+index" :id="'field-'+index" value=""
                           :required="field.required ? 'required':''" class="form-control"/>
                </li>
            </ul>
            <button type="submit" class="button" name="submit" value="1">Absenden</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "FormFields",
        props: ["form_fields"]
    }
</script>

<style scoped>

</style>