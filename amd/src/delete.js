/* eslint-disable no-console */
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

import * as str from 'core/str';
import * as notification from 'core/notification';
import * as templates from 'core/templates';
import * as ajax from 'core/ajax';

let initialized = false;

export const init = (selector) => {
    if (initialized) {
        return; // Already bound, no need to reattach
    }
    initialized = true;
    document.addEventListener('click', (e) => {
        const target = e.target.closest(selector);

        if (!target) {
            return;
        }

        e.preventDefault();

        const entryId = target.dataset.id;
        const courseId = target.dataset.courseId;
        const tableElement = target.closest(".vinod404table");

        if (!entryId || !courseId) {
            console.error('Missing entryId or courseId in dataset', target);
            return;
        }

        str.get_strings([
            {key: 'delete'},
            {key: 'deleteconfirm', component: 'tool_vinod404'},
            {key: 'yes'},
            {key: 'no'}
        ]).then(([deleteLabel, confirmMessage, yesLabel, noLabel]) => {
            return notification.confirm(
                deleteLabel,
                confirmMessage,
                yesLabel,
                noLabel,
                () => {
                    // 1. Delete entry
                    // eslint-disable-next-line promise/no-nesting
                    ajax.call([{
                        methodname: "tool_vinod404_delete_entry",
                        args: {id: entryId},
                    }])[0]

                    // 2. Then fetch updated entries
                    .then(() => ajax.call([{
                        methodname: "tool_vinod404_get_entries",
                        args: {id: courseId},
                    }])[0])

                    // 3. Then render template
                    // eslint-disable-next-line promise/no-nesting
                    .then((entryData) => templates.renderForPromise('tool_vinod404/entries', entryData)
                        .then((result) => {
                            console.log(result);
                            const html = result.html || '';
                            // eslint-disable-next-line promise/always-return
                            const js = result.js || '';
                            templates.replaceNodeContents(tableElement, html, js);
                        })
                    )
                    // Handle any error in the chain
                    .catch(notification.exception);
                }
            );
        }).catch(notification.exception);
    });
};
