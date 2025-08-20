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

namespace tool_vinod404\event;

/**
 * Event entry_deleted
 *
 * @package    tool_vinod404
 * @copyright  2025 Aleti Vinod Kumar <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class entry_deleted extends \core\event\base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'tool_vinod404';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Event description
     * @return string
     */
    public function get_description() {
        return get_string('event_entry_deleted', 'tool_vinod404', $this->get_legacy_data());
    }

    /**
     * URL of the event
     * @return \core\url
     */
    public function get_url() {
        return new \moodle_url('/admin/tool/vinod404/index.php', ['courseid' => $this->courseid]);
    }

    /**
     * Summary of get_legacy_data
     * @return array
     */
    public function get_legacy_data() {
        return [
            'userid' => $this->userid,
            'courseid' => $this->courseid,
            'entryid' => $this->objectid,
        ];
    }

    /**
     * Summary of get_name
     * @return string
     */
    public static function get_name() {
        return get_string('entry_deleted', 'tool_vinod404');
    }
}
