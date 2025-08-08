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
 * Basic information displayed on the plugin's index page.
 *
 * @package   tool_vinod404
 * @copyright 2025, Vinod Kumar Aleti <vinod.aleti@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
$courseid = required_param('courseid', PARAM_INT);
$url = new \moodle_url('/admin/tool/vinod404/index.php', ['courseid' => $courseid]);
$course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
require_course_login($course);

$context = context_course::instance($course->id);
require_capability('tool/vinod404:view', $context);

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('incourse');
$PAGE->set_title(get_string('vinod404', 'tool_vinod404'));
$PAGE->set_heading(get_string('pluginname', 'tool_vinod404'));
$PAGE->navbar->add(get_string('pluginname', 'tool_vinod404'), $url);

$table = new \tool_vinod404_table('vinod404table', $courseid);
$table->define_baseurl($url);

$addurl = new moodle_url('/admin/tool/vinod404/edit.php', ['courseid' => $courseid]);
$addlink = html_writer::link($addurl, get_string('addform', 'tool_vinod404'), []);
echo $OUTPUT->header();
echo $addlink;
$table->out(10, true);
echo $OUTPUT->footer();
