// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * JS module to delete entries from tool_vinod404.
 *
 * @module     tool_vinod404/delete
 * @copyright  2025 Aleti Vinod Kumar <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import * as str from "core/str";
import * as notification from 'core/notification';
import * as templates from 'core/templates';
import * as ajax from 'core/ajax';

export const init = (selector) => {
    const elements = document.querySelectorAll(selector);

    elements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();

            const entryId = element.getAttribute("data-id");
            const courseId = element.getAttribute("data-course-id");
            const tableElement = element.closest(".vinod404table");

            str.get_strings([
                {key: 'delete'},
                {key: 'deleteconfirm', component: 'tool_vinod404'},
                {key: 'yes'},
                {key: 'no'},
            ])
            .done(function(s) {
                notification.confirm(
                    s[0], // title
                    s[1], // question
                    s[2], // yes label
                    s[3], // no label
                    function() {
                        // 1. Call WS to delete entry
                        ajax.call([{
                            methodname: "tool_vinod404_delete_entry",
                            args: {id: entryId}
                        }])[0]
                        .then(() => {
                            // 2. Fetch updated templatable object
                            return ajax.call([{
                                methodname: "tool_vinod404_get_entries",
                                args: {id: courseId}
                            }])[0];
                        })
                        // eslint-disable-next-line promise/always-return
                        .then((entryData) => {
                            // 3. Render the template and update the DOM
                            templates.render('tool_vinod404/entries', entryData)
                                // eslint-disable-next-line max-nested-callbacks
                                .done(function(html, js) {
                                    templates.replaceNodeContents(tableElement, html, js);
                                })
                                .fail(notification.exception);
                        })
                        .catch(notification.exception);
                    },
                    function() {
                        // No button clicked — do nothing
                    }
                );
            })
            .fail(notification.exception);
        });
    });
};
