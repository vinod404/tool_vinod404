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

/**
 * Class vinod404
 *
 * @package    tool_vinod404
 * @copyright  2025 Aleti Vinod Kumar <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class vinod404 {
    /**
     * table
     * @var string
     */
    protected static $table = 'tool_vinod404';

    /**
     * add_entry in the table
     * @param mixed $dataobject
     * @return int of a new entry
     */
    public static function add_entry($dataobject) {
        global $DB;
        $context = \context_course::instance($dataobject->courseid);
        $dataobject->timecreated = time();
        $dataobject->timemodified = time();
        $dataobject->id = $DB->insert_record(self::$table, $dataobject);
        $dataobject = file_postupdate_standard_editor(
            $dataobject,
            'description',
            self::editor_options($dataobject->courseid),
            \context_course::instance($dataobject->courseid),
            'tool_vinod404',
            'vinod',
            $dataobject->id,
        );
        $DB->update_record(self::$table, $dataobject);

        // Trigger entry_created event.
        $event = \tool_vinod404\event\entry_created::create([
            'context' => $context,
            'objectid' => $dataobject->id,
        ]);
        $event->trigger();

        return $dataobject->id;
    }

    /**
     * update_entry
     * @param mixed $dataobject
     * @return bool
     */
    public static function update_entry($dataobject) {
        global $DB;
        $dataobject->timemodified = time();
        $dataobject = file_postupdate_standard_editor(
            $dataobject,
            'description',
            self::editor_options($dataobject->courseid),
            \context_course::instance($dataobject->courseid),
            'tool_vinod404',
            'vinod',
            $dataobject->id,
        );

        $id = $DB->update_record(self::$table, $dataobject);
        // Trigger event.
        $event = \tool_vinod404\event\entry_updated::create([
            'context' => \context_course::instance($dataobject->courseid),
            'objectid' => $dataobject->id,
        ]);
        $event->trigger();

        return $id;
    }

    /**
     * delete_entry
     * @param int $id
     * @return bool
     */
    public static function delete_entry($id) {
        global $DB;
        $data = self::get_entry($id);
        $status = $DB->delete_records(self::$table, ['id' => $id]);

        // Trigger event.
        $event = \tool_vinod404\event\entry_deleted::create([
            'context' => \context_course::instance($data->courseid),
            'objectid' => $data->id,
        ]);
        $event->trigger();

        return $status;
    }

    /**
     * fetch the record from table
     * @param int $id
     * @return \stdClass
     */
    public static function get_entry($id) {
        global $DB;
        return $DB->get_record(self::$table, ['id' => $id]);
    }

    /**
     * Summary of editor_options
     * @param mixed $courseid
     * @return array
     */
    public static function editor_options($courseid) {
        return [
            'trusttext' => true,
            'subdirs' => true,
            'maxfiles' => 0,
            'maxbytes' => 0,
            'context' => \context_course::instance($courseid),
        ];
    }
}
