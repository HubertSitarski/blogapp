export const strings = {
    methods: {
        limitStr (string, limit = 50) {
            let str = string;

            if (typeof str === 'string' && str.length > limit) {
                str = str.slice(0, limit) + '...';
            }

            return str;
        }
    }
};