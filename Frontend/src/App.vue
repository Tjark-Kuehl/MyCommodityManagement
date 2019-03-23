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
                { 'http-equiv': 'X-UA-Compatible', content: 'IE=edge' },
                {
                    name: 'description',
                    content:
                        'A simple commodity management system powered by modern web technologies like vue.js and websockets for easy handling.'
                },
                { name: 'keywords', content: '' },
                { name: 'author', content: 'exomia.com' },
                { name: 'copyright', content: 'exomia.com' },
                // PWA
                {
                    name: 'apple-mobile-web-app-capable',
                    content: 'yes'
                },
                {
                    name: 'apple-mobile-web-app-title',
                    content: 'Exomia Cloud'
                },
                {
                    name: 'apple-mobile-web-app-status-bar-style',
                    content: 'black'
                },
                {
                    name: 'application-name',
                    content: 'Exomia Cloud'
                },
                {
                    name: 'msapplication-TileColor',
                    content: '#ffffff'
                },
                {
                    name: 'theme-color',
                    content: '#ffffff'
                }
            ]
        }
    }
}
</script>

<style src="@/assets/scss/_global.scss" lang="scss"></style>
