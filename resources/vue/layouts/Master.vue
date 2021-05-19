<template>
    <div>
        <core-nav/>
        <router-view/>
        <core-confirm ref="confirm"></core-confirm>
    </div>
</template>

<script>
    import createApp from '@shopify/app-bridge';
    import Redirect from '@shopify/app-bridge/actions';
   // import create from '@shopify/app-bridge/actions';
   // import {History, Toast, TitleBar, Redirect} from '@shopify/app-bridge/actions';
    export default {
        name: "Master",
        components: {},
        data() {
            return {
            }
        },
        async beforeCreate() {
           var queryStrings = this.$route.query;
          //  console.log('queryString-->', queryStrings);
            try {
               if (Object.keys(queryStrings).length) {
                     window.axios.defaults.headers.common['shopify'] = JSON.stringify(queryStrings);
                  let shop = document.getElementsByName('shopify-domain')[0].content;
                let {data} = await axios.post('/api/shopify-domain/get_api_key', {shop});
                  console.log(data.apiKey);
        //             this.$root.$currency = data.currency_symbol;
                    this.$root.$shopifyApp = createApp({
                        apiKey: data.apiKey,
                        shopOrigin: this.$route.query.shop,
                        forceRedirect: true,
                    });
        //
                   await axios.post('/api/validate/domain');
                //     const titleBarOptions = {
                //         title: this.$route.meta.title,
                //     };
                //     this.titleBar = TitleBar.create(this.$root.$shopifyApp, titleBarOptions);
                // } else {
                //     throw new Error('Unauthenticated!');
                 }
            } catch (error) {
               // console.log('error---->', error);
                const redirect = Redirect.create(this.$root.$shopifyApp)
               //  const redirect = Redirect.create(this.$root.$shopifyApp)
                 redirect.dispatch(Redirect.Action.APP, '/login');
            }
         },
        created() {
        },
    }
</script>

<style scoped>

</style>
