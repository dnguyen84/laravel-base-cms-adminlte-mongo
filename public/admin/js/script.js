/**
 * extend js
 */

var ui = ui || {};

/**
 * Build notify option with message type
 */
ui.notifyOption = function(type) {
	return {
        type: type,
        placement: {
            from: "bottom",
            align: "right"
        },
        animate: {
            enter: 'animated fadeInUp',
            exit: 'animated fadeOutDown'
        },
    };
};

/**
 * Override $.notify alert message
 */
ui.alert = function(m) {
	$.notify({ message: m }, ui.notifyOption('danger'));
};

/**
 * Override $.notify success message
 */
ui.message = function(m) {
	$.notify({ message: m }, ui.notifyOption('success'));
};

