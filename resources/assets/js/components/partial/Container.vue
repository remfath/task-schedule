<template>
    <div class="container">
        <slot></slot>
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
    .container {
        width: 1300px;
        margin: 0 auto;
    }
</style>