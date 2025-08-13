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

namespace tool_vinod404;

use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_api;
use core_external\external_value;

/**
 * Class external
 *
 * @package    tool_vinod404
 * @copyright  2025 Aleti Vinod Kumar <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external extends external_api {

    /**
     * delete_entry_parameters
     * @return external_function_parameters
     */
    public static function delete_entry_parameters() {
        return new external_function_parameters([
            'id' => new external_value(PARAM_INT, 'The ID of the entry to delete'),
        ]);
    }

    /**
     * Delete a specific entry
     *
     * @param int $id The ID of the entry to delete
     * @return array
     * @throws \invalid_parameter_exception
     */
    public static function delete_entry($id) {
        global $DB;

        // Validate parameters.
        $params = self::validate_parameters(self::delete_entry_parameters(), ['id' => $id]);
        $entry = vinod404::get_entry($params['id']);
        self::validate_context(\context_course::instance($entry->courseid));
        vinod404::delete_entry($id);
        return ['status' => 'success'];
    }

    /**
     * Summary of delete_entry_returns
     * @return external_single_structure
     */
    public static function delete_entry_returns() {
        return new external_single_structure([
            'status' => new external_value(PARAM_TEXT, 'The status of the delete operation'),
        ]);
    }

    /**
     * Summary of get_entries_parameters
     * @return external_function_parameters
     */
    public static function get_entries_parameters() {
        return new external_function_parameters([
            'id' => new external_value(PARAM_INT, 'The ID of the course to retrieve entries for'),
        ]);
    }

    /**
     * Get all entries for a course
     * @param int $courseid The ID of the course to retrieve entries for
     * @return array
     */
    public static function get_entries($courseid): array {
        global $PAGE;

        $params = self::validate_parameters(self::get_entries_parameters(), ['id' => $courseid]);
        self::validate_context(\context_course::instance($params['id']));

        $output = $PAGE->get_renderer('tool_vinod404');
        $outputdata = new \tool_vinod404\output\entries($courseid, $PAGE->url);
        return $outputdata->export_for_template($output);
    }

    /**
     * Summary of get_entries_returns
     * @return \core_external\external_single_structure
     */
    public static function get_entries_returns() {
        return new external_single_structure([
            'coursename' => new external_value(PARAM_NOTAGS, 'The name of the course'),
            'table' => new external_value(PARAM_RAW, 'The HTML for the entries table'),
            'canadd' => new external_value(PARAM_BOOL, 'Can add entries'),
            'addlink' => new external_value(PARAM_RAW, 'Link to add a new entry'),
        ]);
    }
}
