<template>
    <div class="task">
        <!-- <app-header></app-header> -->
        <app-content></app-content>
        <!-- <app-footer></app-footer> -->
    </div>
</template>

<script>
    import AppHeader from './components/AppHeader.vue';
    import AppContent from './components/AppContent.vue';
    import AppFooter from './components/AppFooter.vue';

    export default {
        name: 'app',
        components: {AppHeader, AppContent, AppFooter}
    }
</script>

<style type="text/scss" lang="scss">
    body {
        margin: 0 auto;
    }

    .task {
        margin-top: -22px;
    }

    * {
        margin: 0;
        padding: 0;
    }
</style>
