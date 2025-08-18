@tool @tool_vinod404
Feature: Teacher can manage Vinod404 entries
  In order to manage entries in the Vinod404 tool
  As a teacher
  I need to be able to create, edit, and delete entries

  Background: Background name
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | One      | teacher1@example.com |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And I log in as "teacher1"
    And I am on "Course 1" course homepage
    And I navigate to "Vinod Learning plugin" in current page administration

  Scenario: Create a new entry
    Given I click on "Add" "link"
    And I set the following fields to these values:
      | Name        | Entry 1             |
      | Completed   | 1                   |
      | Description | This is a new entry |
    And I press "Save changes"
    Then the following should exist in the "vinod404table" table:
      | Name    | Completed | Description         |
      | Entry 1 | Yes       | This is a new entry |

  Scenario: Update the existing entry
    Given I am on "Course 1" course homepage
    When I navigate to "Vinod Learning plugin" in current page administration
    And I click on "Add" "link"
    And I set the following fields to these values:
      | Name        | Entry 1             |
      | Completed   | 1                   |
      | Description | This is a new entry |
    And I press "Save changes"
    And I click on "Edit" "link" in the "Entry 1" "table_row"
    And I set the following fields to these values:
      | Name        | Entry 1 Updated          |
      | Completed   | 0                        |
      | Description | This is an updated entry |
    And I press "Save changes"
    #Then the table "vinod404table" should contain a row with the following data:
    #  | Name            | Completed | Description               |
    #  | Entry 1 Updated | No        | This is an updated entry  |
    #Then the table "vinod404table" should contain row with Name "Entry 1 Updated", Completed "No", Description "This is an updated entry"
    #Then "vinod404table_r0_c0" row "Name" column of "vinod404table" table should contain "Entry 1 Updated"

    Then the following should exist in the "vinod404table" table:
      | Name            | Completed | Description              |
      | Entry 1 Updated | No        | This is an updated entry |

  @javascript
  Scenario: Deleting the entry with javascript
    Given I am on "Course 1" course homepage
    When I navigate to "Vinod Learning plugin" in current page administration
    And I click on "Add" "link"
    And I set the following fields to these values:
      | Name        | Delete Entry 1         |
      | Completed   | 1                      |
      | Description | This is a Delete entry |
    And I press "Save changes"
    And I click on "Delete" "link" in the "Delete Entry 1" "table_row"
    And I press "Yes"
    Then I should not see "Delete Entry 1"
