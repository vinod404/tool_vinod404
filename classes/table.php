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

/**
 * extension of table_sql for the tool_vinod404 plugin
 */
class tool_vinod404_table extends table_sql {

    /**
     * constructor
     * @param mixed $uniqueid
     * @param mixed $courseid
     */
    public function __construct($uniqueid, $courseid) {
        parent::__construct($uniqueid);
        $this->define_columns([
            'name', 'courseid', 'completed', 'priority', 'description', 'timecreated', 'timemodified', 'action',
        ]);
        $this->define_headers([
            get_string('name', 'tool_vinod404'),
            get_string('courseid', 'tool_vinod404'),
            get_string('completed', 'tool_vinod404'),
            get_string('priority', 'tool_vinod404'),
            get_string('description', 'tool_vinod404'),
            get_string('timecreated', 'tool_vinod404'),
            get_string('timemodified', 'tool_vinod404'),
            get_string('action'),
        ]);
        $this->set_sql(
            'id, name, courseid, completed, priority, description, descriptionformat, timecreated, timemodified',
            '{tool_vinod404}',
            'courseid = :courseid',
            ['courseid' => $courseid],
        );

        $this->sortable(false);
        $this->collapsible(true);
        $this->is_downloadable(false);
        $this->pageable(true);
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
     * Summary of col_description
     * @param mixed $line
     * @return string
     */
    protected function col_description($line) {
        $context = context_course::instance($line->courseid);
        $description = file_rewrite_pluginfile_urls($line->description,
            'pluginfile.php',
            $context->id,
            'tool_vinod404',
            'vinod',
            $line->id,
        );
        return format_text($description, $line->descriptionformat, ['context' => $context]);
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
    /**
     * Summary of col_action
     * @param mixed $line
     * @return string
     */
    protected function col_action($line) {
        if (has_capability('tool/vinod404:edit', context_course::instance($line->courseid))) {
            $url = new moodle_url('/admin/tool/vinod404/edit.php', ['id' => $line->id, 'courseid' => $line->courseid]);
            $action = html_writer::link($url, get_string('edit'), ['class' => 'btn btn-secondary']);

            $url = new moodle_url('/admin/tool/vinod404/index.php',
                ['delete' => $line->id, 'courseid' => $line->courseid, 'sesskey' => sesskey()]);
            $action .= html_writer::link($url, get_string('delete'),
            ['class' => 'btn btn-danger', 'data-action' => 'delete', 'data-id' => $line->id, 'data-course-id' => $line->courseid]);
            return $action;
        }
        return '-';
    }

    /**
     * Summary of set_attribute
     * @param mixed $attribute
     * @param mixed $value
     * @return void
     */
    public function set_attribute($attribute, $value) {
        $this->attributes[$attribute] = $value;
    }
}
