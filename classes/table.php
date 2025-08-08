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
 * Custom class for the table_sql
 *
 * @package   tool_vinod404
 * @copyright 2025, Vinod Kumar Aleti <vinod.aleti@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * extension of table_sql for the tool_vinod404 plugin
 */
class tool_vinod404_table extends table_sql {

    /**
     * constructor
     * @param mixed $uniqueid
     * @param mixed $courseid
     */
    function __construct($uniqueid, $courseid) {
        parent::__construct($uniqueid);
        $this->define_columns(['name', 'courseid', 'completed', 'priority', 'timecreated', 'timemodified']);
        $this->define_headers([
            get_string('name', 'tool_vinod404'),
            get_string('courseid', 'tool_vinod404'),
            get_string('completed', 'tool_vinod404'),
            get_string('priority', 'tool_vinod404'),
            get_string('timecreated', 'tool_vinod404'),
            get_string('timemodified', 'tool_vinod404')
        ]);
        $this->set_sql(
            'id, name, courseid, completed, priority, timecreated, timemodified',
            '{tool_vinod404}',
            'courseid = :courseid',
            ['courseid' => $courseid]
        );

        $this->sortable(false);
        $this->collapsible(true);
        $this->is_downloadable(false);
        $this->pageable(true);
        // Additional initialization code can go here
    }

    /**
     * Summary of col_completed
     * @param mixed $line
     * @return string
     */
    protected function col_completed($line) {
        return $line->completed ? get_string('yes') : get_string('no');
    }

    /**
     * Summary of col_priority
     * @param mixed $line
     * @return string
     */
    protected function col_priority($line) {
        return $line->priority ? get_string('yes') : get_string('no');
    }

    /**
     * Summary of col_name
     * @param mixed $line
     * @return string
     */    
    protected function col_name($line) {
        return format_string($line->name);
    }
    /**
     * Summary of col_timecreated
     * @param mixed $line
     * @return string
     */    
    protected function col_timecreated($line) {
        return userdate($line->timecreated);
    }

    /**
     * Summary of col_timemodified
     * @param mixed $line
     * @return string
     */
    protected function col_timemodified($line) {
        return userdate($line->timemodified);
    }
    // Table definition and methods go here
}
