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
 * Tests for Vinod Learning plugin
 *
 * @package    tool_vinod404
 * @category   test
 * @copyright  2025 Aleti Vinod Kumar <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class vinod404_test extends \advanced_testcase {

    /**
     * tests the add and get entries
     * @covers \tool_vinod404\vinod404::add_entry
     * @covers \tool_vinod404\vinod404::get_entry
     */
    public function test_add_entry(): void {
        $this->resetAfterTest();
        // Create a user and log them in.
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $course = $this->getDataGenerator()->create_course();
        $data = (object) [
            'name' => 'Test Entry',
            'courseid' => $course->id,
            'completed' => 0,
            'description_editor' => [
                'text' => 'Add Test Description',
                'format' => FORMAT_HTML,
                'itemid' => file_get_unused_draft_itemid(),
            ],
        ];
        $id = \tool_vinod404\vinod404::add_entry($data);
        $record = \tool_vinod404\vinod404::get_entry($id);
        $this->assertEquals($data->name, $record->name);
        $this->assertEquals($course->id, $record->courseid);
        $this->assertEquals($data->description_editor['text'], $record->description);
    }

    /**
     * Test updating an entry
     * @covers \tool_vinod404\vinod404::update_entry
     */
    public function test_update_entry(): void {
        $this->resetAfterTest();
        // Create a user and log them in.
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $course = $this->getDataGenerator()->create_course();
        $data = (object) [
            'name' => 'Test Entry',
            'courseid' => $course->id,
            'completed' => 0,
            'description_editor' => [
                'text' => 'Add Test Description',
                'format' => FORMAT_HTML,
                'itemid' => file_get_unused_draft_itemid(),
            ],
        ];
        $id = \tool_vinod404\vinod404::add_entry($data);
        $data->id = $id;
        $data->name = 'Updated Entry';
        $data->description_editor['text'] = 'Update Test Description';
        \tool_vinod404\vinod404::update_entry($data);
        $record = \tool_vinod404\vinod404::get_entry($id);
        $this->assertEquals($data->name, $record->name);
        $this->assertEquals($data->description_editor['text'], $record->description);
    }

    /**
     * tests the delete entry
     * @covers \tool_vinod404\vinod404::delete_entry
     */
    public function test_delete_entry(): void {
        $this->resetAfterTest();
        // Create a user and log them in.
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $course = $this->getDataGenerator()->create_course();
        $data = (object) [
            'name' => 'Test Entry',
            'courseid' => $course->id,
            'completed' => 0,
            'description_editor' => [
                'text' => 'Add Test Description',
                'format' => FORMAT_HTML,
                'itemid' => file_get_unused_draft_itemid(),
            ],
        ];
        $id = \tool_vinod404\vinod404::add_entry($data);
        $record = \tool_vinod404\vinod404::get_entry($id);
        $this->assertEquals($data->name, $record->name);
        \tool_vinod404\vinod404::delete_entry($id);
        $record = \tool_vinod404\vinod404::get_entry($id);
        $this->assertFalse($record);
    }
}
