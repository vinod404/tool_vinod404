<?php
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
 * Callback implementations for tool_vinod404
 *
 * @package   tool_vinod404
 * @copyright 2025, Vinod Kumar Aleti <vinod.aleti@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * This function adds a link to the plugin in the course navigation menu.
 * @param navigation_node $parentnode
 * @param stdClass $course
 * @param context_course $context
 * @return void
 */
function tool_vinod404_extend_navigation_course(navigation_node $parentnode, stdClass $course, context_course $context) {
    $url = new moodle_url('/admin/tool/vinod404/index.php', ['id' => $course->id]);
    $parentnode->add(
        get_string('pluginname', 'tool_vinod404'),
        $url,
        navigation_node::TYPE_SETTING,
        get_string('pluginname', 'tool_vinod404'),
        'vinod404',
        new pix_icon('icon', '', 'tool_vinod404')
    );
}
