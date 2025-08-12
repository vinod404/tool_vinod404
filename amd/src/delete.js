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

export const init = (selector) => {
    var elements = document.querySelectorAll(selector);

    elements.forEach((element) => {
        element.addEventListener("click", (e) => {
            e.preventDefault();
            const deleteurl = element.getAttribute("href");
            str.get_strings([
                {'key': 'delete'},
                {'key': 'deleteconfirm', component: 'tool_vinod404'},
                {'key': 'yes'},
                {'key': 'no'},
            ]).done(function(s) {
                notification.confirm(s[0], s[1], s[2], s[3], function() {
                    window.location.href = deleteurl;
                });
            }).fail(notification.exception);
        });
    });
};