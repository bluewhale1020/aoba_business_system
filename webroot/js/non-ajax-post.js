/**
 * @author Mark B
 * @url https://stackoverflow.com/questions/5524045/jquery-non-ajax-post
 */

function jqueryPost(action, method, input) {
    "use strict";
    var form;
    form = $('<form />', {
        action: action,
        method: method,
        style: 'display: none;'
    });
    if (typeof input !== 'undefined') {

        $.each(input, function (name, value) {

            if( typeof value === 'object' ) {

                $.each(value, function(objName, objValue) { 

                    $('<input />', {
                        type: 'hidden',
                        name: name + '[]',
                        value: objValue
                    }).appendTo(form);
                } );      
            }
            else {

                $('<input />', {
                    type: 'hidden',
                    name: name,
                    value: value
                }).appendTo(form);
            }
        });
    }
    form.appendTo('body').submit();
}