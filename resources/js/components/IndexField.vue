
<template>
    <p>
        <img
            v-if="imageUrl"
            :src="imageUrl"
            style="object-fit: cover;"
            class="w-8 h-8 rounded"
        />
        <span v-else>&mdash;</span>
    </p>
</template>


<script>
import axios from 'axios'

    export default {

        data() {
            return {
                imageUrl: ''
            }
        },

        props: ['resourceName', 'field'],

        mounted() {

            axios.get(`https://api.unsplash.com/photos/${this.field.value}/?client_id=${this.field.unsplashKey}`)
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.image = response.data
                    this.imageUrl = this.image.urls['small']

                })
                .catch(e => {
                    this.imageUrl = ''
                })
        },

    }

</script>
