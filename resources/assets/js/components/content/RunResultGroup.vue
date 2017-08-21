<template>
    <div class="result-group">
        <span class="title">{{ title }}：</span>
        <span class="value">{{ value }}</span>
    </div>
</template>

<script>

    export default {
        data() {
            return {}
        },
        props: ['title', 'value']
    }
</script>

<style type="text/scss" lang="scss" scoped>
    .result-group {
        margin-bottom: 10px;
        .title {
            font-weight: bold;
            display: inline-block;
            width: 100px;
            text-align: right;
        }
    }
</style>