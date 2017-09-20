import LiveTasks from './components/content/LiveTasks.vue';
import SystemSummary from './components/content/SystemSummary.vue';
import TaskLog from './components/content/TaskLog.vue';
import DeletedTasks from './components/content/DeletedTasks.vue';
import TaskGroup from './components/content/TaskGroup.vue';

export default [
    {
        path: '/',
        redirect: '/summary'
    },
    {
        path: '/summary',
        component: SystemSummary
    },
    {
        path: '/live',
        component: LiveTasks
    },
    {
        path: '/log',
        component: TaskLog
    },
    {
        path: '/deleted',
        component: DeletedTasks
    },
    {
        path: '/group',
        component: TaskGroup
    },
    {
        path: '*',
        redirect: '/'
    }
]
