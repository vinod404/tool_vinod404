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

namespace tool_vinod404\output;

use stdClass;

/**
 * Class entries
 *
 * @package    tool_vinod404
 * @copyright  2025 Aleti Vinod Kumar <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class entries implements \renderable, \templatable {

    /**
     * courseid
     * @var int
     */
    protected $courseid;

    /**
     * url
     * @var url
     */
    protected $url;

    /**
     * __construct
     * @param int $courseid
     * @param \moodle_url $url
     */
    public function __construct($courseid, $url) {
        $this->courseid = $courseid;
        $this->url = $url;
    }

    /**
     * Export the data for the template.
     *
     * @param \renderer_base $output
     * @return array
     */
    public function export_for_template(\renderer_base $output): array {

        $course = get_course($this->courseid);
        $context = \context_course::instance($this->courseid);
        $data = new stdClass();
        $data->coursename = $course->fullname;

        ob_start();
        $table = new \tool_vinod404_table('vinod404table', $this->courseid);
        $table->set_attribute('id', 'vinod404table');
        $table->define_baseurl($this->url);
        $table->out(0, true);
        $data->table = ob_get_clean();

        $data->canadd = false;
        $data->addlink = '';
        if (has_capability('tool/vinod404:edit', $context)) {
            $data->canadd = true;
            $addurl = new \moodle_url('/admin/tool/vinod404/edit.php', ['courseid' => $this->courseid]);
            $addlink = \html_writer::link($addurl, get_string('addform', 'tool_vinod404'), []);
            $data->addlink = $addlink;
        }
        return (array) $data;
    }
}
