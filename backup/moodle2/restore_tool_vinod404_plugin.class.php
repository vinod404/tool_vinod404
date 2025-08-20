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
 * TODO describe file restore_tool_vinod404_plugin.class
 *
 * @package    tool_vinod404
 * @copyright  2025 Aleti Vinod Kumar <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
use tool_vinod404\vinod404;
require_once($CFG->dirroot . '/backup/moodle2/restore_tool_plugin.class.php');

/**
 * Restore plugin for the tool_vinod404.
 *
 * @package    tool_vinod404
 */
class restore_tool_vinod404_plugin extends restore_tool_plugin {

    /**
     * Define the restore structure for the tool_vinod404 plugin.
     *
     * @return array of restore_path_element
     */
    protected function define_course_plugin_structure() {
        $paths = [];

        // The path must match the XML structure in the backup.
        $paths[] = new restore_path_element(
            'vinod404_data',
            $this->get_pathfor('/vinod404_data')
        );

        return $paths;
    }

    /**
     * Process each vinod404_data entry from the backup file.
     *
     * @param array $data The data for the record from the backup XML.
     */
    public function process_vinod404_data($data) {
        global $DB;

        $data = (object)$data;
        // Make sure courseid maps to the restored course.
        $data->courseid = $this->task->get_courseid();
        // Insert into the tool_vinod404 table.
        vinod404::add_entry($data);
    }
}
