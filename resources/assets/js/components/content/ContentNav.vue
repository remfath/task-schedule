<template>
    <container>
        <div class="content-nav">
            <router-link to="/summary" class="nav-item"><i class="fa fa-info-circle"></i> 系统概览</router-link>
            <router-link to="/live" class="nav-item"><i class="fa fa-tasks"></i> 定时任务</router-link>
            <router-link to="/log" class="nav-item"><i class="fa fa-comments"></i> 今日日志</router-link>
            <router-link to="/group" class="nav-item"><i class="fa fa-users"></i> 任务组</router-link>
            <router-link to="/server" class="nav-item"><i class="fa fa-users"></i> 服务器</router-link>
            <router-link to="/deleted" class="nav-item"><i class="fa el-icon-delete"></i> 任务回收站</router-link>
        </div>
    </container>
</template>

<script>

    export default {
        data() {
            return {}
        }
    }
</script>

<style type="text/scss" lang="scss" scoped>
    @import "../../../sass/lib";

    .content-nav {
        display: flex;
        align-items: center;
        height: 60px;
        background: #fff;
        border-bottom: 1px solid #d6d6d6;
    }

    .nav-item {
        @include flex-col-center;
        text-decoration: none;
        color: #b2afaa;
        width: 100px;
        height: 60px;
        border-left: 1px solid #d6d6d6;
        font-size: 13px;
        box-sizing: border-box;
        &:last-child {
            border-right: 1px solid #d6d6d6;
        }
    }

    .fa {
        font-size: 25px !important;
    }

    .router-link-active {
        border-bottom: 2px solid red;
        color: #000;
    }
</style>
