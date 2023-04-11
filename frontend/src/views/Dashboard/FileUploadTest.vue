<template>
  <form @submit.prevent="onUpload">
          <div class="form-group">
              <input type="file" name="images" @change="onChange">
          </div>
          <div class="form-group">
              <button class="btn btn-success">Submit</button>
          </div>
      </form>
</template>

<script>
export default {
    data() {
      return {
         imagesArray: null
      };
    },
    methods: {
        onChange (event) {
          this.imagesArray = event.target.files[0]
        },
        async onUpload() {
          const formData = new FormData()
          formData.append('file', this.imagesArray, this.imagesArray.name)
          try{
              const response = await this.callApi("post", "/media_objects", formData)
          }catch(e){
              console.log(e)
          }
        }  
    }

}
</script>

<style>

</style>