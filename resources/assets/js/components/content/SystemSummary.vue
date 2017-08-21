<template>
    <container>
        <box title="系统概览" icon="fa fa-info-circle">
            <el-row :gutter="20" class="summary-details" v-if="summary">
                <el-col :span="6">
                    <el-card class="box-card count-ok">
                        <h4>总共任务数</h4>
                        <h3>{{ summary.all_total_count }}</h3>
                    </el-card>
                </el-col>
                <el-col :span="6">
                    <el-card class="box-card count-bad">
                        <h4>总共失败任务数</h4>
                        <h3>{{ summary.all_failed_count }}</h3>
                    </el-card>
                </el-col>
                <el-col :span="6">
                    <el-card class="box-card count-ok">
                        <h4>今日任务数</h4>
                        <h3>{{ summary.today_total_count }}</h3>
                    </el-card>
                </el-col>
                <el-col :span="6">
                    <el-card class="box-card count-bad">
                        <h4>今日失败任务数</h4>
                        <h3>{{ summary.today_failed_count }}</h3>
                    </el-card>
                </el-col>
            </el-row>
            <chart :options="chartOptions"></chart>
        </box>
    </container>
</template>

<script>
    import VueECharts from 'vue-echarts/components/ECharts.vue';
    import 'echarts/lib/chart/line'
    import 'echarts/lib/component/tooltip'
    import 'echarts/lib/component/legend'
    import 'echarts/lib/component/title'

    export default {
        components: {
            chart: VueECharts
        },
        data() {
            return {
                summary: null,
                status: null
            }
        },
        computed: {
            chartOptions() {
                if (!this.status) {
                    return null;
                }

                let xAxisData = [];
                let totalData = [];
                let successData = [];
                let failedData = [];
                for (let dt in this.status) {
                    if (this.status.hasOwnProperty(dt)) {
                        let item = this.status[dt];
                        xAxisData.push(dt);
                        totalData.push(item['total_count']);
                        successData.push(item['success_count']);
                        failedData.push(item['failed_count']);
                    }
                }
                return {
                    title: {
                        text: '任务运行情况'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: ['全部', '成功', '失败']
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            magicType: {show: true, type: ['stack', 'tiled']},
                            saveAsImage: {show: true}
                        }
                    },
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: xAxisData
                    },
                    yAxis: {
                        type: 'value',
                        min: -2
                    },
                    series: [
                        {
                            name: '失败',
                            type: 'line',
                            smooth: true,
                            data: failedData,
                            lineStyle: {
                                normal: {
                                    color:'#ff4949'
                                }
                            }
                        },
                        {
                            name: '成功',
                            type: 'line',
                            smooth: true,
                            data: successData,
                            lineStyle: {
                                normal: {
                                    color:'#13ce66'
                                }
                            }
                        },
                        {
                            name: '全部',
                            type: 'line',
                            smooth: true,
                            data: totalData,
                            lineStyle: {
                                normal: {
                                    color:'#20a0ff'
                                }
                            }
                        }
                    ]
                };
            }
        },
        methods: {
            getSummary() {
                const that = this;
                axios.get('/api/task/summary').then((response) => {
                    that.summary = response.data;
                }).catch(() => {
                    that.$message.error('数据获取失败');
                });
            },
            getStatus() {
                const that = this;
                axios.get('/api/task/status').then((response) => {
                    that.status = response.data;
                }).catch(() => {
                    that.$message.error('数据获取失败');
                });
            }
        },
        created() {
            this.getSummary();
            this.getStatus();
        }
    }
</script>

<style type="text/scss" lang="scss" scoped>
    .summary-details {
        .box-card {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 200px;
            h4 {
                margin-bottom: 20px;
                font-size: 20px;
            }
            h3 {
                font-size: 28px;
            }
        }
    }

    .count-ok {
        border: 2px solid #1d8ce0;
        background: lighten(#1d8ce0, 30%)
    }

    .count-bad {
        border: 2px solid #ff4949;
        background: lighten(#ff4949, 30%)
    }

    .echarts {
        margin: 50px auto;
        width: 100%;
        height: 400px;
    }
</style>