<template>
    <container>
        <box title="任务日志" icon="fa fa-comments">
            <Logs :height="600"></Logs>
        </box>
    </container>
</template>

<script>
    import Logs from '../partial/Logs.vue';

    export default {
        components: { Logs },
    }
</script>

<style type="text/scss" lang="scss" scoped>

</style>