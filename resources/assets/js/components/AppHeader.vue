<template>
    <div class="app-header">
        <container>
            <div class="header-wrapper">
                <a href="/#/summary"><h3><i class="el-icon-time"></i> 定时任务管理系统</h3></a>
                <i class="fa fa-rocket logo"></i>
            </div>
        </container>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        }
    }
</script>

<style type="text/scss" lang="scss" scoped>
    @import "../../sass/lib";

    .app-header {
        @include flex-row-between;
        background: $app-header-bg;
        color: $app-header-color;
        height: $app-header-height;
        @include content-container;
    }

    .header-wrapper {
        @include flex-row-between;
        a {
            text-decoration: none;
            color: #fff;
        }
    }

    .logo {
        font-size: 25px;
        color: orange;
    }
</style>