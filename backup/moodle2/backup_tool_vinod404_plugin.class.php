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
 * TODO describe file backup_tool_vinod404_plugin.class
 *
 * @package    tool_vinod404
 * @copyright  2025 Aleti Vinod Kumar <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/backup/moodle2/backup_tool_plugin.class.php');

/**
 * Backup plugin for the tool_vinod404.
 */
class backup_tool_vinod404_plugin extends backup_tool_plugin {

    /**
     * Defines the course-level backup structure for the tool_vinod404 plugin.
     * @return backup_plugin_element
     */
    protected function define_course_plugin_structure() {
        $plugin = $this->get_plugin_element();
        // Create a virtual container to hold data.
        $wrapper = new backup_nested_element($this->get_recommended_name());

        // Example table: tool_vinod404_data.
        $data = new backup_nested_element('vinod404_data', ['id'], [
            'name', 'courseid', 'description', 'descriptionformat', 'completed', 'priority', 'timecreated', 'timemodified',
        ]);

        // Build the tree.
        $plugin->add_child($wrapper);
        $wrapper->add_child($data);

        // Data source from DB.
        $data->set_source_table('tool_vinod404', ['courseid' => backup::VAR_COURSEID]);

        return $plugin;
    }
}
