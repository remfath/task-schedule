<template>
    <div class="app-content">
        <div class="content-nav">
            <content-nav></content-nav>
        </div>
        <div class="content-main">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import ContentNav from './content/ContentNav.vue';

    export default {
        data() {
            return {}
        },
        components: {ContentNav}
    }
</script>

<style type="text/scss" lang="scss" scoped>
    @import "../../sass/lib";

    .app-content {
        @include flex-col-top;
        width: 100%;
        //min-height: calc(100vh - 65px);
    }

    .content-nav {
        width: 100%;
    }

    .content-main {
        width: 100%;
    }
</style>
