<template>
    <el-table
            :data="logs"
            stripe
            class="logs-table"
            :height="height">
        <el-table-column
                prop="task_start_time"
                label="开始时间">
        </el-table-column>
        <el-table-column v-if="!taskId"
                         prop="task_title"
                         label="任务名称">
        </el-table-column>
        <el-table-column
                align="center"
                label="任务状态">
            <template scope="scope">
                <el-tag v-if="scope.row.task_run_status === 0" type="success">成功</el-tag>
                <el-tag v-else type="danger">失败</el-tag>
            </template>
        </el-table-column>
    </el-table>
</template>

<script>
    import { Loading } from 'element-ui';

    export default {
        data() {
            return {
                logs: []
            }
        },
        props: ['taskId', 'height'],
        methods: {
            getLogs() {
                const that = this;
                let apiUrl = '/api/task/log';
                if(this.taskId) {
                    apiUrl = '/api/task/log/' + this.taskId;
                }
                axios.get(apiUrl).then(response => {
                    that.logs = response.data;
                }).catch(() => {
                    that.$message.error('获取任务列表错误');
                });
            },
        },
        watch: {
            taskId() {
                this.getLogs();
            }
        },
        created() {
            this.getLogs();
        }
    }
</script>

<style type="text/scss" lang="scss" scoped>
    .logs-table {
        width: 100%;
    }
</style>