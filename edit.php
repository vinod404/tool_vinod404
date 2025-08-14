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
 * TODO describe file edit
 *
 * @package    tool_vinod404
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../../config.php');
require_once($CFG->dirroot .'/admin/tool/vinod404/lib.php');
global $DB;
$id = optional_param('id', 0, PARAM_INT);

if ($id > 0) {
    $record = tool_vinod404\vinod404::get_entry($id);
    $title = get_string('editform', 'tool_vinod404');
    $courseid = $record->courseid;
} else {
    $record = new stdClass();
    $record->id = -1;
    $courseid = required_param('courseid', PARAM_INT);
    $title = get_string('addform', 'tool_vinod404');
    $record->courseid = $courseid;
    $record->descriptionformat = FORMAT_HTML;
    $record->description = '';
}
$returnurl = new moodle_url('/admin/tool/vinod404/index.php', ['courseid' => $courseid]);
if (!$enable = get_config('tool_vinod404', 'enable')) {
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]), get_string('plugin_disabled', 'tool_vinod404'));
}
require_course_login($courseid);
$context = context_course::instance($courseid);
require_capability('tool/vinod404:edit', $context);

$url = new moodle_url('/admin/tool/vinod404/edit.php', ['id' => $id]);
;
$PAGE->set_url($url);
$PAGE->set_context($context);

$PAGE->set_heading(get_string('pluginname', 'tool_vinod404'));
$form = new tool_vinod404_form(null, ['courseid' => $courseid]);

$editoroptions = tool_vinod404\vinod404::editor_options($courseid);

$record = file_prepare_standard_editor(
    $record,
    'description',
    $editoroptions,
    $context,
    'tool_vinod404',
    'vinod',
    $record->id
);
$form->set_data($record);


if ($form->is_cancelled()) {
    redirect($returnurl);
} else if ($data = $form->get_data()) {
    // If the form is submitted, process the data.
    $data->timemodified = time();
    if ($data->id > 0) {
        tool_vinod404\vinod404::update_entry($data);
        $message = get_string('updated', 'tool_vinod404');
    } else {
        $id = tool_vinod404\vinod404::add_entry($data);
        $message = get_string('created', 'tool_vinod404');
    }
    redirect($returnurl, $message);

}
echo $OUTPUT->header();
echo $OUTPUT->heading($title);
$form->display();

echo $OUTPUT->footer();
