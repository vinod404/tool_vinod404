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
 * External functions and service declaration for Vinod Learning plugin
 *
 * Documentation: {@link https://moodledev.io/docs/apis/subsystems/external/description}
 *
 * @package    tool_vinod404
 * @category   webservice
 * @copyright  2025 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'tool_vinod404_delete_entry' => [
        'classname'   => 'tool_vinod404\external\delete_entry',
        'description' => 'Delete a specific entry',
        'type'        => 'write',
        'capabilities' => 'tool/vinod404:edit',
        'ajax'        => true,
    ],
    'tool_vinod404_get_entries' => [
        'classname'   => 'tool_vinod404\external\get_entries',
        'description' => 'Get all entries',
        'type'        => 'read',
        'capabilities' => 'tool/vinod404:view',
        'ajax'        => true,
    ],
];
