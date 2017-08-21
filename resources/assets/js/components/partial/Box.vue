<template>
    <el-card class="box-card">
        <div slot="header">
            <h4><i :class="icon" class="header-icon"></i>{{ title }}</h4>
        </div>
        <div>
            <slot></slot>
        </div>
    </el-card>
</template>

<script>

    export default {
        data() {
            return {}
        },
        props: ['title', 'icon']
    }
</script>

<style type="text/scss" lang="scss">
    .box-card {
        margin: 20px 0;
        .el-card__header {
            padding: 8px 16px !important;
        }
        .header-icon {
            margin-right: 5px;
        }
    }
</style>