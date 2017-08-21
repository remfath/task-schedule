<template>
    <div class="app-footer">
        <container>
            <p>@2016 remfath</p>
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

    .app-footer {
        @include flex-row-center;
        height: 35px;
        background: #324057;
        color: #fff;
        font-size: 90%;
        padding: 15px;
        text-align: center;
    }
</style>