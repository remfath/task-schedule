<template>
    <container>
        <task-list :deleted="true"></task-list>
    </container>
</template>

<script>
    import TaskList from '../partial/TaskList.vue';

    export default {
        data() {
            return {}
        },
        components: { TaskList }
    }
</script>

<style type="text/scss" lang="scss" scoped>

</style>