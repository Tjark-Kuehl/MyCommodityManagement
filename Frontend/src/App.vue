<template>
    <div id="app">
        <router-view name="header"></router-view>
        <section class="middle">
            <router-view name="sidebar"></router-view>
            <router-view />
        </section>
    </div>
</template>

<script>
export default {
    metaInfo() {
        return {
            titleTemplate: 'Wawi - %s',
            htmlAttrs: {
                lang: 'en'
            },
            noscript: [{ innerHTML: 'Please enable JavaScript' }],
            meta: [
                { charset: 'utf-8' },
                {
                    name: 'viewport',
                    content: 'width=device-width, initial-scale=1'
                },
                {
                    'http-equiv': 'Content-Type',
                    content: 'text/html; charset=utf-8'
                },
                { 'http-equiv': 'X-UA-Compatible', content: 'IE=edge' }
            ]
        }
    }
}
</script>

<style src="@/assets/scss/_global.scss" lang="scss"></style>
