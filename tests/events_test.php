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
use advanced_testcase;
use tool_vinod404\vinod404;

/**
 * Tests for Events handling in Vinod Learning plugin
 *
 * @package    tool_vinod404
 * @category   test
 * @copyright  2025 Aleti Vinod Kumar <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class events_test extends advanced_testcase {

    /**
     * Sets up the environment before each test.
     */
    public function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
    }

    /**
     * Test for event entry_created
     * @covers \tool_vinod404\event\entry_created
     */
    public function test_entry_created(): void {
        // Create a user and log them in.
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $course = $this->getDataGenerator()->create_course();
        // Trigger Event.
        $sink = $this->redirectEvents();
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
        $id = vinod404::add_entry($data);
        $events = $sink->get_events();
        $event = reset($events);

        // Assert that the event is of the expected type and contains the correct data.
        $this->assertInstanceOf('\\tool_vinod404\\event\\entry_created', $event);
        $this->assertEquals(\context_course::instance($course->id), $event->get_context());
        $this->assertEquals($id, $event->objectid);
    }

    /**
     * Test for event entry_updated
     *
     * @covers \tool_vinod404\event\entry_updated
     */
    public function test_entry_updated(): void {
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
        $id = vinod404::add_entry($data);
        // Trigger Event.
        $sink = $this->redirectEvents();
        $data->id = $id;
        $data->name = 'Updated Entry';
        $data->description_editor['text'] = 'Update Test Description';
        vinod404::update_entry($data);

        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Assert that the event is of the expected type and contains the correct data.
        $this->assertInstanceOf('\tool_vinod404\event\entry_updated', $event);
        $this->assertEquals(\context_course::instance($course->id), $event->get_context());
        $this->assertEquals($data->id, $event->objectid);
    }

    /**
     * Test for event entry_deleted
     *
     * @covers \tool_vinod404\event\entry_deleted
     */
    public function test_entry_deleted(): void {
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
        $id = vinod404::add_entry($data);
        // Trigger Event.
        $sink = $this->redirectEvents();
        vinod404::delete_entry($id);
        $events = $sink->get_events();

        $event = reset($events);

        // Assert that the event is of the expected type and contains the correct data.
        $this->assertInstanceOf('\tool_vinod404\event\entry_deleted', $event);
        $this->assertEquals(\context_course::instance($course->id), $event->get_context());
        $this->assertEquals($id, $event->objectid);
    }
}
