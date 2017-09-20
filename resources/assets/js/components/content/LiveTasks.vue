<template>
    <container>
        <el-button type="success" class="add-btn" @click="showFormDialog=true">
            <i class="fa fa-plus"></i>添加新任务
        </el-button>
        <el-dialog title="添加新任务" :visible.sync="showFormDialog">
            <el-form :model="form" label-position="right" inline label-width="150" class="new-task-form-table">
                <el-form-item label="任务名称">
                    <el-input v-model="form.task_title" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="任务描述">
                    <el-input v-model="form.task_desc" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="任务类型">
                    <el-input v-model="form.task_type" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="任务语言">
                    <el-input v-model="form.task_lang" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="执行命令">
                    <el-input v-model="form.task_command" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="命令参数">
                    <el-input v-model="form.task_params" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="命令类型">
                    <el-input v-model="form.commend_type" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="运行时间">
                    <el-input v-model="form.task_run_time" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="任务状态">
                    <el-input v-model="form.task_status" auto-complete="off"></el-input>
                </el-form-item>
                <!-- <el-form-item label="警报手机">
                    <el-input v-model="form.phones.task_phones" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="收件人">
                    <el-input v-model="form.mails.task_mails_to" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="抄送人">
                    <el-input v-model="form.mails.task_mails_cc" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="密送人">
                    <el-input v-model="form.mails.task_mails_bcc" auto-complete="off"></el-input>
                </el-form-item> -->
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showFormDialog = false">取 消</el-button>
                <el-button type="primary" @click="addTask">确 定</el-button>
            </div>
        </el-dialog>

        <task-list :deleted="false"></task-list>
    </container>
</template>

<script>
    import TaskList from '../partial/TaskList.vue';

    export default {
        data() {
            return {
                showFormDialog: false,
                form: {
                    task_title: '',
                    task_type: 'script',
                    task_lang: 'php',
                    commend_type: 'file',
                    task_command: '',
                    task_params: '',
                    http_method: '',
                    task_dependencies: '',
                    task_priority: '',
                    task_desc: '',
                    task_run_time: '',
                    task_status: 0,
                    group_id: 1,
                    user_id: 1,
                    server_id: 1,
                    // phones: {
                    //     task_phones: ''
                    // },
                    // mails: {
                    //     task_mails_to: '',
                    //     task_mails_cc: '',
                    //     task_mails_bcc: ''
                    // }
                }
            }
        },
        components: {
            TaskList
        },
        methods: {
            addTask() {
                const that = this;
                axios.post('/api/task/add', {
                    task: this.form
                }).then((response) => {
                    that.showFormDialog = false;
                    let updateStatus = response.data;
                    if (updateStatus === 1) {
                        that.$notify({
                            title: '成功',
                            message: '添加任务成功',
                            type: 'success'
                        });
                        that.getTasks();
                    } else {
                        that.$notify({
                            title: '失败',
                            message: '添加任务失败',
                            type: 'error'
                        });
                    }
                }).catch(() => {
                    that.showFormDialog = false;
                    that.$notify({
                        title: '失败',
                        message: '添加任务失败',
                        type: 'error'
                    });
                });
            }
        }
    }
</script>

<style type="text/scss" lang="scss" scoped>
    .add-btn {
        margin: 30px 0 10px;
    }

    .new-task-form-table {
        .el-form-item {
            width: 40%;
            .el-form-item__content {
                width: 80%;
            }
        }
    }
</style>