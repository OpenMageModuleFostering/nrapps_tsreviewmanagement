/**
 * @category   NRApps
 * @package    NRApps_TSReviewManagement
 * @copyright  Copyright (c) 2014 integer_net GmbH (http://www.integer-net.de/)
 * @license    http://www.trustedshops.com/tsdocument/TS_EULA_en.pdf
 * @author     nr-apps.com (http://www.nr-apps.com/) powered by integer_net GmbH
 * @author     integer_net GmbH <info@integer-net.de>
 * @author     Viktor Franz <vf@integer-net.de>
 */


var NRAppsTSReview_Management = Class.create();

NRAppsTSReview_Management.prototype = {

    /**
     *
     */
    initialize: function () {

        window.setTimeout(this._removeMessage, 10000);

        /**
         *
         */
        Event.observe(window, 'load', function () {
            var headers = $$('.content-header-floating');
            if (headers.length) {
                headers[0].remove();
            }
        });
    },

    /**
     *
     * @param grid
     * @param event
     */
    unfoldToggle: function (grid, event) {

        var row = Event.findElement(event, 'tr');
        var actionUrl = row.title;

        if (actionUrl) {
            if (row.next() && row.next().hasClassName('sub-grid')) {
                row.next().remove();
            } else {

                new Ajax.Request(actionUrl, {
                    onComplete: function (response) {

                        if (response.responseText) {

                            $$('tr.sub-grid').each(function (subGrid) {
                                subGrid.remove();
                            });

                            this._addRow(row, response.responseText);
                        }
                    }.bind(this)
                });
            }
        }
    },

    /**
     *
     * @param sibling
     * @param row
     * @private
     */
    _addRow: function (sibling, row) {

        row = '<div style="margin: 25px;" >' + row + '</div>';

        var styleClasses = sibling.classNames();
        styleClasses = styleClasses + ' sub-grid';

        var td = new Element('td', {'colspan': 99, style: 'border-right: none;'}).update(row);
        var tr = new Element('tr', {'class': styleClasses}).update(td);

        sibling.insert({after: tr});
    },

    /**
     *
     * @private
     */
    _removeMessage: function () {
        if ($('messages').hasChildNodes()) {
            Effect.SlideUp('messages', { duration: 0.6 });
        }
    }
};

nrappstsreview_management = new NRAppsTSReview_Management();

/**
 * @param grid
 * @param event
 */
row_click_callback = function (grid, event) {
    if (['a', 'input', 'select', 'option'].indexOf(Event.element(event).tagName.toLowerCase()) != -1) {
        return;
    }

    nrappstsreview_management.unfoldToggle(grid, event);
}
