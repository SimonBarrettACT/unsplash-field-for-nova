<template>
    <panel-item :field="field">

        <div slot="value">
            <div v-if="imageUrl">
                <img class="rounded"
                     :src="imageUrl" :alt="imageAlt"/>
                <div v-if="photographer" class="font-normal text-base text-80">Photo by:
                    <a :href="portfolio" class="no-underline text-primary dim">{{ photographer }}</a>
                </div>
            </div>
            <div v-else>&mdash;</div>
        </div>

    </panel-item>
</template>

<script>
    import axios from 'axios'

    export default {

        data() {
            return {
                imageUrl: '',
                imageAlt: '',
                photographer: '',
                portfolio: '',
                image: [],
            }
        },

        props: ['resourceName', 'field'],

        mounted() {

            axios.get(`https://api.unsplash.com/photos/${this.field.value}/?client_id=${this.field.unsplashKey}`)
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.image = response.data
                    this.imageUrl = this.image.urls[this.field.previewSize]
                    this.imageAlt = this.image['description']
                    this.photographer = this.image.user['name']
                    this.portfolio = this.image.user.links['html']
                })
                .catch(e => {
                    this.imageUrl = ''
                    this.imageAlt = ''
                    this.photographer = ''
                })

        },

    }

</script>

