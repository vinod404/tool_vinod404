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

namespace tool_vinod404;
class vinod404 {
    /**
     * table
     * @var string
     */
    protected $table = 'tool_vinod404';
    
    /**
     * add_entry in the table
     * @param mixed $dataobject
     * @return int of a new entry
     */
    public function add_entry($dataobject) {
        global $DB;
        $dataobject->timecreated = time();
        $dataobject->timemodified = time();
        return $DB->insert_record($this->table, $dataobject);
    }

    /**
     * update_entry
     * @param mixed $dataobject
     * @return bool
     */
    public function update_entry($dataobject) {
        global $DB;
        $dataobject->timemodified = time();        
        return $DB->update_record($this->table, $dataobject);
    }
    /**
     * delete_entry
     * @param int $id
     * @return bool
     */
    public function delete_entry($id) {
        global $DB;
        return $DB->delete_records($this->table, ['id' => $id]);
    }

    /**
     * fetch the record from table
     * @param int $id
     * @return \stdClass
     */
    public function get_entry($id) {
        global $DB;
        return $DB->get_record($this->table, ['id' => $id]);
    }
}
