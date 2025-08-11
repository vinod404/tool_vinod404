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
 * Upgrade code for install
 *
 * @package   tool_vinod404
 * @copyright 2025 Vinod Kumar Aleti <vinod.aleti@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade the vinod404 plugin.
 * @param int $oldversion The version we are upgrading from
 */
function xmldb_tool_vinod404_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2025080703) {

        // Define table tool_vinod404 to be created.
        $table = new xmldb_table('tool_vinod404');

        // Adding fields to table tool_vinod404.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('completed', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('priority', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table tool_vinod404.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for tool_vinod404.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Conditionally launch create table for tool_vinod404.
        upgrade_plugin_savepoint(true, 2025080703, 'tool', 'vinod404');
    }

    if ($oldversion < 2025080704) {
        // Define key courseid (foreign) to be added to tool_vinod404.
        $table = new xmldb_table('tool_vinod404');
        $key = new xmldb_key('courseid', XMLDB_KEY_FOREIGN, ['courseid'], 'course', ['id']);

        // Launch add key courseid.
        $dbman->add_key($table, $key);

        $index = new xmldb_index('courseid_name', XMLDB_INDEX_UNIQUE, ['courseid', 'name']);

        // Conditionally launch add index courseid_name.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Vinod404 savepoint reached.
        upgrade_plugin_savepoint(true, 2025080704, 'tool', 'vinod404');
    }

    if ($oldversion < 2025081100.01) {
        $table = new xmldb_table('tool_vinod404');
        $field1 = new xmldb_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null, 'priority');
        // Conditionally launch add field description.
        if (!$dbman->field_exists($table, $field1)) {
            $dbman->add_field($table, $field1);
        }
        $field2 = new xmldb_field('descriptionformat', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'description');
        // Conditionally launch add field descriptionformat.
        if (!$dbman->field_exists($table, $field2)) {
            $dbman->add_field($table, $field2);
        }
        // Vinod404 savepoint reached.
        upgrade_plugin_savepoint(true, 2025081100.01, 'tool', 'vinod404');
    }
    return true;
}

