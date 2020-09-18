Nova.booting((Vue, router, store) => {
    Vue.component('index-unsplash', require('./components/IndexField'))
    Vue.component('detail-unsplash', require('./components/DetailField'))
    Vue.component('form-unsplash', require('./components/FormField'))
})
