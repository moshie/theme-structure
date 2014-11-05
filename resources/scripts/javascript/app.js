;(function($, window, document, undefined) {
    var settings, functions = {
        init: function (){

        }
    };
    $.fn.ltTheme = function(options) {
        var element = this;
        settings = $.extend({}, $.fn.ltTheme.options, options);
        functions.init(element);
        return this;
    };
    $.fn.ltTheme.options = {

    };

})(jQuery, window, document);
