let Auth = {
    module: () => {
        return 'auth';
    },

    moduleApi: () => {
        return 'api/' + Auth.module();
    },


};

$(function () {

});
