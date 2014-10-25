/*
 *    jQuery Prefinator v2.5
 *
 *	Description: The Prefintator is a Plugin specificly
 *	designed for kinetic solutions to enable students
 *	to select room preferences.
 *
 *	Author: David Hewitt
 *
 *	Website: www.kinetic-solutions.co.uk
 *
 */
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