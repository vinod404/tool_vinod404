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
        $dataobject->timecreated = time();
        $dataobject->timemodified = time();
        return $DB->insert_record(self::$table, $dataobject);
    }

    /**
     * update_entry
     * @param mixed $dataobject
     * @return bool
     */
    public static function update_entry($dataobject) {
        global $DB;
        $dataobject->timemodified = time();
        return $DB->update_record(self::$table, $dataobject);
    }

    /**
     * delete_entry
     * @param int $id
     * @return bool
     */
    public static function delete_entry($id) {
        global $DB;
        return $DB->delete_records(self::$table, ['id' => $id]);
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
}
