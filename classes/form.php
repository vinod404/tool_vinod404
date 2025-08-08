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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
/**
 * Class form
 *
 * @package    tool_vinod404
 * @copyright  2025 Vinod Kumar Aleti <vinod.aleti@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_vinod404_form extends \moodleform {

    /**
     * Form definition
     */
    public function definition() {
        $mform = $this->_form;
        $mform->addElement("header", "header", get_string("formheader", 'tool_vinod404'));
        $mform->addElement('text', 'name', get_string('name', 'tool_vinod404'));
        $mform->setType('name', PARAM_ALPHANUM);

        $mform->addElement('advcheckbox', 'completed', get_string('completed', 'tool_vinod404'));

        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $this->add_action_buttons();
    }

    /**
     * Form validation
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        global $DB;
        if (empty($data['name'])) {
            $errors['name'] = get_string('required');
        }

        $exist = $DB->record_exists_select('tool_vinod404',
        'name = :name AND courseid = :courseid AND id != :id',
        ['name' => $data['name'], 'courseid' => $data['courseid'], 'id' => $data['id']]);
        if ($exist) {
            $errors['name'] = get_string('nameduplicate', 'tool_vinod404');
        }
        return $errors;
    }
}
