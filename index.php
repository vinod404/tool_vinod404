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
$id = optional_param('id', 0, PARAM_INT);
require_login();
$url = new \moodle_url('/admin/tool/vinod404/index.php', 'id' => $id);
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('vinod404', 'tool_vinod404'));
$PAGE->set_heading(get_string('pluginname', 'tool_vinod404'));
echo $OUTPUT->header();
$userinput1 = 'no <b>tags</b> allowed in strings';
$userinput2 = '<span class="multilang" lang="en">RIGHT</span><span class="multilang" lang="fr">WRONG</span>';
$userinput3 = 'a" onmouseover=”alert(\'XSS\')" asdf="';
$userinput4 = "3>2";
$userinput5 = "2<3"; // Interesting effect, huh?

echo html_writer::div(s($userinput1)); // Used when you want to escape the value.
echo html_writer::div(s($userinput2));
echo html_writer::div(s($userinput3));
echo html_writer::div(s($userinput4));
echo html_writer::div(s($userinput5));
echo html_writer::div(format_string($userinput1)); // Used for one-line strings, such as forum post subject.
echo html_writer::div(format_string($userinput2));
echo html_writer::div(format_string($userinput3));
echo html_writer::div(format_string($userinput4));
echo html_writer::div(format_string($userinput5));
echo html_writer::div(format_text($userinput1)); // Used for multil-line rich-text contents such as forum post body.
echo html_writer::div(format_text($userinput2));
echo html_writer::div(format_text($userinput3));
echo html_writer::div(format_text($userinput4));
echo html_writer::div(format_text($userinput5));
echo html_writer::tag('p', get_string('helloworld', 'tool_vinod404'));
echo $OUTPUT->footer();
