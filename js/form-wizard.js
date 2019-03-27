var FormWizard = function () {
    var wizardContent = $('#wizard');
    var wizardForm = $('#form');
    var selecionado = 1;
    var initWizard = function () {
        // function to initiate Wizard Form
        wizardContent.smartWizard({
            selected: 0,
            keyNavigation: false,
            onLeaveStep: leaveAStepCallback,
            onShowStep: onShowStep
        });
        var numberOfSteps = 0;
        animateBar();
    };
    var animateBar = function (val) {
        if ((typeof val == 'undefined') || val == "") {
            val = 1;
        }
        numberOfSteps = $('.swMain > ul > li').length;
        var valueNow = Math.floor(100 / numberOfSteps * val);
        $('.step-bar').css('width', valueNow + '%');
    };
    var onShowStep = function (obj, context) {
        $(".next-step").unbind("click").click(function (e) {
            e.preventDefault();
            wizardContent.smartWizard("goForward");
            selecionado = selecionado + 1;
            animateBar(selecionado);
        });
        $(".back-step").unbind("click").click(function (e) {
            e.preventDefault();
            wizardContent.smartWizard("goBackward");
            selecionado = selecionado - 1;
            animateBar(selecionado);
        });
        $(".finish-step").unbind("click").click(function (e) {
            e.preventDefault();
            onFinish(obj, context);
        });
    };
    var leaveAStepCallback = function (obj, context) {
        return true;
        // return validateSteps(context.fromStep, context.toStep);
        // return false to stay on step and true to continue navigation
    };
    var onFinish = function (obj, context) {
        alert('form submit function');
        $('.anchor').children("li").last().children("a").removeClass('wait').removeClass('selected').addClass('done');
        //wizardForm.submit();
    };
    return {
        init: function () {
            initWizard();
        }
    };
}();