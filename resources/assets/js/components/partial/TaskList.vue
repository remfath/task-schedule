<style type="text/scss" lang="scss" scoped>
    .list-table {
        font-size: 13px;
        width: 100%;
    }

    .fa {
        margin-right: 5px;
        width: 12px;
    }

    .el-tag {
        padding: 0 12px;
    }

    .fa-play {
        color: green;
    }

    .fa-pause {
        color: red;
    }

    .el-dialog__wrapper .el-dialog .el-dialog__body {
        padding: 20px 0 !important;
        margin: 30px 20px !important;
        border-radius: 10px;
    }

    .el-table .cell {
        padding: 0 !important;
    }

    .demo-table-expand {
        font-size: 0;
    }

    .demo-table-expand label {
        width: 90px;
        color: #99a9bf;
    }

    .demo-table-expand .el-form-item {
        margin-right: 0;
        margin-bottom: 0;
        width: 50%;
    }

    .el-form-item-full {
        width: 100% !important;
    }
</style>

<template>
    <box title="任务列表" icon="fa fa-list">
        <el-table :data="tasks" border stripe class="list-table" :height="600">
            <el-table-column type="expand">
                <template scope="props">
                    <el-form label-position="left" inline class="demo-table-expand">
                        <el-form-item label="任务ID：">
                            <span>{{ props.row.id }}</span>
                        </el-form-item>
                        <el-form-item label="任务名称：">
                            <span>{{ props.row.task_title }}</span>
                        </el-form-item>
                        <el-form-item label="任务描述：">
                            <span>{{ props.row.task_desc }}</span>
                        </el-form-item>
                        <el-form-item label="任务命令：" class="el-form-item-full">
                            <span><el-tag type="gray">{{ props.row.task_command }}</el-tag></span>
                        </el-form-item>
                        <el-form-item label="任务类型：">
                            <span>{{ props.row.task_type }}</span>
                        </el-form-item>
                        <el-form-item label="任务语言：">
                            <span>{{ props.row.task_lang }}</span>
                        </el-form-item>
                        <el-form-item label="运行时间：">
                            <span>{{ props.row.task_run_time }}</span>
                        </el-form-item>
                        <el-form-item label="任务依赖：">
                            <span>{{ props.row.task_dependencies }}</span>
                        </el-form-item>
                        <el-form-item label="警报手机：">
                            <span>{{ props.row.phones ? props.row.phones.task_phones : '无'}}</span>
                        </el-form-item>
                        <el-form-item label="邮箱收件人：">　
                            <span>{{ props.row.mails ? props.row.mails.task_mails_to : '无'}}</span>
                        </el-form-item>
                        <el-form-item label="邮箱抄送人：">
                            <span>{{ props.row.mails ? props.row.mails.task_mails_cc : '无' }}</span>
                        </el-form-item>
                        <el-form-item label="邮箱密送人：">
                            <span>{{ props.row.mails ? props.row.mails.task_mails_bcc : '无'}}</span>
                        </el-form-item>

                        <el-form-item label="创建时间：">
                            <span>{{ props.row.created_at }}</span>
                        </el-form-item>
                        <el-form-item label="更新时间：">
                            <span>{{ props.row.updated_at }}</span>
                        </el-form-item>
                    </el-form>
                </template>
            </el-table-column>
            </el-table-column>
            <el-table-column label="任务名称">
                <template scope="scope">
                    <p>
                        <i class="fa fa-pause" v-if="scope.row.task_status === 0"
                           @click="updateTaskStatus(scope.row.id, 1)"></i>
                        <i class="fa fa-play" v-if="scope.row.task_status === 1"
                           @click="updateTaskStatus(scope.row.id, 0)"></i>
                        {{ scope.row.task_title }}
                    </p>
                </template>
            </el-table-column>
            <el-table-column prop="task_run_time" label="时间表达式" width="120"></el-table-column>
            <el-table-column label="收件人" width="85" align="center">
                <template scope="scope">
                    <el-tag>
                        {{ getTotalTaskMailsCount(scope.row.mails) }}人
                    </el-tag>
                </template>
            </el-table-column>
            <el-table-column label="手机" width="85" align="center">
                <template scope="scope">
                    <el-tag>
                        {{ getFieldCount(scope.row.phones, 'task_phones') }}人
                    </el-tag>
                </template>
            </el-table-column>
            <el-table-column label="创建人" width="120" align="center">
                <template scope="scope">
                    <el-tag>
                        {{ scope.row.user.user_name }}
                    </el-tag>
                </template>
            </el-table-column>
            <el-table-column label="操作" width="400" align="center">
                <template scope="scope">
                    <el-button size="small"
                               type="success" :plain="true"
                               @click="runTask(scope.row.id)"
                               :loading="scope.row.id === runningTaskId">
                        <i class="fa fa-refresh" v-if="scope.row.id !== runningTaskId"></i>运行
                    </el-button>
                    <el-button size="small">
                        <i class="fa fa-pencil-square-o"></i>编辑
                    </el-button>
                    <el-button size="small" @click="showLogs(scope.row.id)">
                        <i class="fa fa-comments"></i>日志
                    </el-button>
                    <el-button size="small" type="danger" :plain="true" @click="removeTask(scope.row.id)">
                        <i class="fa fa-times"></i>删除
                    </el-button>
                    <el-button size="small" type="success" :plain="true" @click="restoreTask(scope.row.id)" v-if="deleted">
                        <i class="fa fa-times"></i>恢复
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog title="运行结果" :visible.sync="showResultDialog">
            <group title="任务ID" :value="runResult.id"></group>
            <group title="任务名称" :value="runResult.task_title"></group>
            <group title="执行命令" :value="runResult.real_command"></group>
            <group title="执行结果" :value="runResult.task_run_status === 0 ? '成功' : '失败'"></group>
            <group title="执行输出" :value="runResult.task_output"></group>
            <group title="错误信息" :value="runResult.task_error"></group>
            <group title="开始时间" :value="runResult.task_start_time"></group>
            <group title="结束时间" :value="runResult.task_end_time"></group>
        </el-dialog>

        <el-dialog title="任务日志" :visible.sync="showTaskLogDialog" class="dialog-logs">
            <logs :task-id="selectedTaskId" :height="500"></logs>
        </el-dialog>
    </box>
</template>

<script>
    import Logs from '../partial/Logs.vue';
    import Group from '../content/RunResultGroup.vue'

    export default {
        data() {
            return {
                runningTaskId: -1,
                runResult: false,
                tasks: [],
                showResultDialog: false,

                selectedTaskId: -1,
                showTaskLogDialog: false
            }
        },
        props: ['deleted'],
        components: {
            Logs,
            Group
        },
        methods: {
            getFieldArray(result, field) {
                if (result && field in result) {
                    return result[field].split(',');
                }
                return [];
            },
            getFieldCount(result, fields) {
                if (Array.isArray(fields)) {
                    let sum = 0;
                    fields.forEach((field) => {
                        sum += this.getFieldArray(result, field).length;
                    });
                    return sum;
                }
                return this.getFieldArray(result, fields).length;
            },
            getTotalTaskMailsCount(mails) {
                return this.getFieldCount(mails, ['task_mails_to', 'task_mails_cc', 'task_mails_bcc']);
            },
            updateLocalTaskInfo(taskId, updateFields) {
                let taskIdx = this.getLocalTaskIndex(taskId);
                if (taskIdx) {
                    for (let key in updateFields) {
                        if (updateFields.hasOwnProperty(key)) {
                            if (typeof updateFields[key] === 'object') {
                                for (let k in updateFields[key]) {
                                    if (updateFields[key].hasOwnProperty(k)) {
                                        this.tasks[taskIdx][key][k] = updateFields[key][k];
                                    }
                                }
                            } else {
                                this.tasks[taskIdx][key] = updateFields[key];
                            }
                        }
                    }
                    return updateFields;
                }
                return null;
            },
            updateTaskStatus(taskId, taskStatus) {
                let updateFields = {
                    task_status: taskStatus
                };
                let updateLocalResult = this.updateLocalTaskInfo(taskId, updateFields);
                if (updateLocalResult) {
                    this.updateTask(taskId, updateFields);
                }
            },
            getTasks() {
                const that = this;
                let isDeleted = this.deleted ? 'y' : 'n';
                axios.get('/api/task/list?is_deleted=' + isDeleted).then(response => {
                    that.tasks = response.data;
                }).catch(() => {
                    that.$message.error('获取任务列表错误');
                });
            },
            runTask(taskId) {
                this.runningTaskId = taskId;
                const that = this;
                axios.get('/api/task/run/' + taskId).then(response => {
                    that.runningTaskId = -1;
                    that.runResult = response.data;
                    that.showResultDialog = true;
                }).catch((response) => {
                    console.error(response);
                    that.runningTaskId = -1;
                    that.$message.error('运行命令错误');
                });
            },
            getLocalTaskInfo(taskId) {
                let taskIdx = this.getLocalTaskIndex(taskId);
                if (taskIdx) {
                    return this.tasks[taskIdx];
                }
                return null;
            },
            getLocalTaskIndex(taskId) {
                for (let idx in this.tasks) {
                    if (this.tasks.hasOwnProperty(idx) && taskId === this.tasks[idx].id) {
                        return idx;
                    }
                }
                return null;
            },
            updateTask(taskId, updateFields) {
                const that = this;
                axios.post('/api/task/update/' + taskId, {
                    fields: updateFields
                }).then((response) => {
                    let updateStatus = response.data;
                    if (updateStatus === 1) {
                        that.$notify({
                            title: '成功',
                            message: '任务更新成功',
                            type: 'success'
                        });
                    } else {
                        that.$notify({
                            title: '失败',
                            message: '任务更新失败',
                            type: 'error'
                        });
                    }
                }).catch(() => {
                    that.$notify({
                        title: '失败',
                        message: '任务更新失败',
                        type: 'error'
                    });
                });
            },
            removeTask(taskId) {
                if(!this.deleted) {
                    this.deleteTask(taskId);
                    return;
                }
                this.$confirm('此操作将永久删除该任务, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.deleteTask(taskId);
                }).catch(() => {
                    this.$notify.info({
                        title: '取消',
                        message: '任务删除取消'
                    });
                });
            },
            deleteTask(taskId) {
                const that = this;
                let isDeleted = this.deleted ? 'y' : 'n';
                axios.get('/api/task/delete/' + taskId + '?is_deleted=' + isDeleted).then((response) => {
                    let updateStatus = response.data;
                    if (updateStatus === 1) {
                        that.getTasks();
                        that.$notify({
                            title: '成功',
                            message: '任务删除成功',
                            type: 'success'
                        });
                    } else {
                        that.$notify({
                            title: '失败',
                            message: '任务删除失败',
                            type: 'error'
                        });
                    }
                }).catch(() => {
                    that.$notify({
                        title: '失败',
                        message: '任务删除失败',
                        type: 'error'
                    });
                });
            },
            restoreTask(taskId) {
                const that = this;
                axios.get('/api/task/restore/' + taskId).then((response) => {
                    that.getTasks();
                }).catch(() => {});
            },
            showLogs(taskId) {
                this.selectedTaskId = taskId;
                this.showTaskLogDialog = true;
            }
        },
        created() {
            this.getTasks();
        }
    }
</script>