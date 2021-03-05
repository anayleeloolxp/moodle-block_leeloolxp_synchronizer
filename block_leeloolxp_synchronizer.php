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
 * class block_leeloolxp_tracking
 *
 * @package    block_leeloolxp_synchronizer
 * @copyright  2020 leeloolxp.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/course/lib.php');

/**

 * class block_leeloolxp_synchronizer

 *

 * @package    block_leeloolxp_synchronizer
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_leeloolxp_synchronizer extends block_base {

    /**
     * Initialises the block
     */
    public function init() {
        // Commented dynamic call for now.
        $this->title = get_string('pluginname', 'block_leeloolxp_synchronizer');
    }

    /**
     * Get content of the block
     */
    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        global $DB;

        global $CFG;

        global $USER;

        $this->content = new stdClass();

        $html = '';

        if ($this->page->pagetype == 'course-view-topics') {
            $courseid = optional_param('id', null, PARAM_RAW);

            $cContext = context_course::instance($courseid);

            $isStudent = !has_capability('moodle/course:update', $cContext) ? 'student' : 'admin';

            if ($isStudent == 'student') {
                $this->content->text = get_string('nopremission', 'block_leeloolxp_synchronizer');

                $this->content->footer = '';

                return $this->content;
            }

            $baseurl = $CFG->wwwroot;

            $coursesyncedquery = $DB->get_records('tool_leeloolxp_sync',

                array('courseid' => $courseid));

            $html = '<style type="text/css">
                    .dialog-modal {
                        align-self: center;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        z-index: 9999;
                        background: rgba(0,0,0,0.7);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .dialog-modal-inn {
                        background: #fff;
                        max-width: 750px;
                        padding: 50px;
                        text-align: center;
                        width: 100%;
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                    }
                    .dialog-modal-inn div#dialog {
                        font-size: 17px;
                    }
                    .dialog-modal-inn h4 {
                        font-weight: 400;
                        margin: 0 0 25px;
                        font-size: 25px;
                    }
                    .sure-btn {
                        margin: 50px 0 0;
                    }
                    .dialog-modal-inn .sure-btn button {
                        font-size: 20px;
                        padding: .5rem 3rem;
                        color: #fff;
                        background-color: #74cfd0;
                        border: none;
                        display: inline-block;
                        text-decoration: none;
                        outline: 0;
                        box-shadow: none;
                        margin: 10px 0;
                    }
                    </style>';

            if (empty($coursesyncedquery)) {
                $html .= '<div id="dialog-modal-course-synchronizer" class="dialog-modal dialog-modal-course " style="display: none;">

                            <div class="dialog-modal-inn">

                                <div id="dialog" >

                                    <h4>' . get_string('are_you_sure_sunc_all', 'block_leeloolxp_synchronizer') . '</h4>

                                    <div class="sure-btn">

                                        <button data_id = "" data_name="" onclick="yescourseunsync(' . $courseid . ');"

                                        class="btn btn_yes_courseunsync" >' . get_string('yes_sure', 'block_leeloolxp_synchronizer') . '</button>

                                        <button  onclick="course_cls_popup();" class="btn course_cls_popup" >' . get_string('cancel', 'block_leeloolxp_synchronizer') . '</button>

                                    </div>



                                </div>

                            </div>

                        </div>';
            } else {

                $html .= '<div id="dialog-modal-course-synchronizer" class="dialog-modal dialog-modal-course " style="display: none;">

                            <div class="dialog-modal-inn">

                                <div id="dialog" >

                                    <h4>' . get_string('are_you_sure_re_sunc_all', 'block_leeloolxp_synchronizer') . '</h4>

                                    <div class="sure-btn">

                                        <button data_id = "" data_name="" onclick="resync(' . $courseid . ');"

                                        class="btn btn_yes_courseunsync" >' . get_string('yes_sure', 'block_leeloolxp_synchronizer') . '</button>

                                        <button  onclick="course_cls_popup();" class="btn course_cls_popup" >' . get_string('cancel', 'block_leeloolxp_synchronizer') . '</button>

                                    </div>



                                </div>

                            </div>

                        </div>';
            }

            $reqsync = optional_param('sync', null, PARAM_RAW);
            if (isset($reqsync)) {
                $html .= '<p style="color:green;">' . get_string('sync_done', 'block_leeloolxp_synchronizer') . '</p>';
            }

            $html .= "<h2>" . get_string('sync_title', 'block_leeloolxp_synchronizer') . "</h2>";

            $html .= "<hr>";

            $html .= "<a href='#' onclick='show_popup();'>" . get_string('sync_course', 'block_leeloolxp_synchronizer') . "</a><br>";

            $html .= "<a href='#' onclick='single_activity(" . $courseid . ");'>" . get_string('sync_activity', 'block_leeloolxp_synchronizer') . "</a><br>";

            $html .= "<a href='#' onclick='sync_categories(" . $courseid . ");'>" . get_string('sync_cat', 'block_leeloolxp_synchronizer') . "</a><br>";

            $html .= "<a href='" . $baseurl . "/admin/tool/leeloolxp_sync/index.php'>" . get_string('sync_panel', 'block_leeloolxp_synchronizer') . "</a>";

            $html .= '<script> function show_popup() {

                        document.getElementById("dialog-modal-course-synchronizer").style.display = "block";

                    }



                function course_cls_popup() {

                    document.getElementById("dialog-modal-course-synchronizer").style.display = "none";

                }
                function yescourseunsync(courseid) {

                    var url = "' . $baseurl . '/admin/tool/leeloolxp_sync/?action=coursesyncfrmblock&redirect=couseview&courseid="+courseid;

                    window.location = url;

                }

                function resync(courseid) {



                    var url = "' . $baseurl . '/admin/tool/leeloolxp_sync/?resync=1&redirect=courseview&courseid_resync="+courseid;

                    window.location = url;

                }

                function single_activity(courseid) {

                    var url = "' . $baseurl . '/admin/tool/leeloolxp_sync/?action=add&redirect=couseview&courseid="+courseid;

                    window.location = url;

                }

                function sync_categories(courseid) {
                    var url = "' . $baseurl . '/admin/tool/leeloolxp_sync/?syncategory=1&redirect=couseview&courseid="+courseid;
                    window.location = url;
                }

                </script>';
        }

        $this->content->text = $html;

        $this->content->footer = '';

        return $this->content;
    }

    /**
     * Define if block has config
     */
    public function has_config() {

        return true;
    }
}