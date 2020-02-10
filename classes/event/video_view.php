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
 * The video_view event.
 *
 * @package    block_videodirectory
 * @copyright  2020 Tovi Kurztag <tovi@openapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_videodirectory\event;
defined('MOODLE_INTERNAL') || die();
/**
 * The video_view event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - PUT INFO HERE
 * }
 *
 * @since     Moodle MOODLEVERSION
 * @copyright 2017 Yedidia@openapp.co.il
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 **/
class video_view extends \core\event\base {
    protected function init() {
        global $COURSE;
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'local_video_directory';
    }
    public static function get_name() {
            return get_string('eventvideo_view', 'videostream');
    }
    public function get_description() {
        global $USER;
        if ($this->other != "") {
            return "The user with id {$USER->id} Did this action : <b>{$this->other}</b> on video id {$this->objectid}.";
        } else {
            $id = $_SESSION['videoid'];
            return "The user with id {$USER->id} viewed video id {$id}.";
        }
    }
    public function get_url() {
        $id = $_SESSION['videoid'];
        return new \moodle_url('/blocks/videodirectory/view.php', array('id' => $id , 'courseid' => $this->courseid));
    }
    public function get_legacy_logdata() {
        // Override if you are migrating an add_to_log() call.
        return array($this->courseid, 'videodirectory', 'LOGACTION',
            '...........',
            $this->objectid, $this->contextinstanceid);
    }
    public static function get_legacy_eventname() {
        // Override ONLY if you are migrating events_trigger() call.
        return 'MYPLUGIN_OLD_EVENT_NAME';
    }
    protected function get_legacy_eventdata() {
        // Override if you migrating events_trigger() call.
        $data = new \stdClass();
        $data->id = $this->objectid;
        $data->userid = $this->relateduserid;
        return $data;
    }
}