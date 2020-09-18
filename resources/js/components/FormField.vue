<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <img class="mb-4 rounded" v-if="imageUrl" :src="imageUrl" :alt="imageAlt"/>

            <div class="flex items-center py-1">
                <input v-model="query" type="text" :placeholder="field.queryPlaceholder"
                       class="mb-4 w-full form-control form-input form-input-bordered">
                <a @click="getRandomPhoto()" class="mb-4 ml-1 btn btn-default btn-primary cursor-pointer">Search</a>
            </div>

            <div class="mb-6 text-center text-lg text-80">or</div>

            <input
                :id="field.name"
                type="text"
                class="w-full form-control form-input form-input-bordered"
                :class="errorClasses"
                :placeholder="field.name"
                v-model="value"
                @keyup="getPhoto()"
            />

            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>

        </template>
    </default-field>
</template>

<script>
    import {FormField, HandlesValidationErrors} from 'laravel-nova'
    import axios from 'axios'

    export default {
        mixins: [FormField, HandlesValidationErrors],

        data() {
            return {
                imageUrl: '',
                imageAlt: '',
                image: [],
                query: ''
            }
        },

        props: ['resourceName', 'resourceId', 'field'],

        mounted() {
            if (!this.field.unsplashKey) {
                this.$toasted.show('Please add UNSPLASH_ACCESS_KEY to your .env file.', {type: 'error'});
            }

            this.getPhoto()
        },

        methods: {
            /*
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                this.value = this.field.value || ''
            },

            getPhoto() {

                axios.get(`https://api.unsplash.com/photos/${this.value}/?client_id=${this.field.unsplashKey}`)
                    .then(response => {
                        this.image = response.data
                        this.imageUrl = this.image.urls[this.field.previewSize]
                        this.imageAlt = this.image['description']
                    })
                    .catch(e => {
                        this.imageUrl = ''
                    })

            },

            getRandomPhoto() {

                axios.get(`https://api.unsplash.com/photos/random/?client_id=${this.field.unsplashKey}&query=${this.query}&orientation=${this.field.orientation}&featured=${this.field.featured}`)
                    .then(response => {
                        this.image = response.data
                        this.imageUrl = this.image.urls[this.field.size]
                        this.imageAlt = this.image['description']
                        this.value = this.image['id']

                    })
                    .catch(e => {
                        this.imageUrl = ''
                        this.imageAlt = ''
                    })

            },

            /**
             * Fill the given FormData object with the field's internal value.
             */
            fill(formData) {
                formData.append(this.field.attribute, this.value || '')
            },
        },
    }

</script>
