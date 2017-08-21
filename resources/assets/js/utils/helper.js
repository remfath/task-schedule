export default {
    formatObjectFieldToArray(obj, field) {
        if (obj && field in obj) {
            return obj[field].split(',');
        }
        return [];
    },
    getObjectFieldCount(obj, field) {
        return formatObjectFieldToArray(obj, field).length;
    }
};