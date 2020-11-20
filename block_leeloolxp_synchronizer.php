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
 * Renderer for block leeloolxp_synchronizer
 *
 * @package    block_leeloolxp_synchronizer
 * @copyright  2020 @ leelolxp.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;
require_once( $CFG->dirroot.'/course/lib.php' );

/**
 * Block sync info
 *
 * @copyright  2020 Leeloo LXP (https://leeloolxp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_leeloolxp_synchronizer extends block_base {
    /**
     * Show attendance information of user.
     */

    /**
     * Block initialization
     */
    public function init() {
        $this->title = get_string( 'pluginname', 'block_leeloolxp_synchronizer' );

    }

    /**
     * Return contents of block_leeloolxp_synchronizer block
     *
     * @return string of block
     */
    public function  get_content() {

        if ( $this->content !== null ) {

            return $this->content;

        }

        if ( empty( $this->instance ) ) {

            $this->content = '';

            return $this->content;

        }
        global $DB;
        global $CFG;
        if ( $this->page->pagetype == 'course-view-topics' ) {
            $liacencekey = get_config( 'block_leeloolxp_synchronizer' )
            ->licensekey;
            $courseid  = $_REQUEST['id'];
            $alreadysync = false;
            $baseurl = $CFG->wwwroot;
            $coursesyncedquery = $DB->get_records( 'tool_leeloolxp_sync',
            array( 'courseid' => $courseid ) );

            if ( empty( $coursesyncedquery ) ) {
                $html = '<div id="dialog-modal-course-synchronizer"
                class="dialog-modal dialog-modal-course " style="display: none;">
                            <div class="dialog-modal-inn">
                                <div id="dialog" >
                                    <h4>Are you sure you want to sync all the activities
                                    and resources of this course to Leeloo LXP?</h4>
                                    <div class="sure-btn">
                                        <button data_id = "" data_name=""
                                        onclick="yescourseunsync('.$courseid.');"
                                        class="btn btn_yes_courseunsync" >Yes, I’m sure</button>
                                        <button  onclick="course_cls_popup();" class="btn course_cls_popup" >Cancel</button>
                                    </div>
                                    </div>
                            </div>
                        </div>';
            } else {
                $html = '<div id="dialog-modal-course-synchronizer"
                class="dialog-modal dialog-modal-course " style="display: none;">
                            <div class="dialog-modal-inn">
                                <div id="dialog" >
                                    <h4>Are you sure you want to RE-sync all the activities
                                    and resources of this course to Leeloo LXP?</h4>
                                    <div class="sure-btn">
                                        <button data_id = "" data_name="" onclick="resync('.$courseid.');"
                                        class="btn btn_yes_courseunsync" >Yes, I’m sure</button>
                                        <button  onclick="course_cls_popup();" class="btn course_cls_popup" >Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
            if ( isset( $_REQUEST['sync'] ) ) {
                $html .= '<p style="color:green;">Sychronizationed successfully.</p>';

            }
            $html .= '<h2>Synchronizer To leeloolxp</h2>';
            $html .= '<hr>';
            $html .= "<a href='#' onclick='show_popup();'>Sync Course </a><br>";
            $html .= "<a href='#' onclick='single_activity(".$courseid.");'>Sync Single Activity</a>";
            $html .= '<script> function show_popup() {
                        document.getElementById("dialog-modal-course-synchronizer").style.display = "block";
                    }
                    function course_cls_popup() {
                    document.getElementById("dialog-modal-course-synchronizer").style.display = "none";
                }

                function yescourseunsync(courseid) {
                    var url = "'.$baseurl.'/admin/tool/leeloolxp_sync/
                    ?action=coursesyncfrmblock&redirect=couseview&courseid="+courseid;
                    window.location = url;
                }
                function resync(courseid) {
                    var url = "'.$baseurl.'/admin/tool/leeloolxp_sync/
                    ?resync=1&redirect=courseview&courseid_resync="+courseid;
                    window.location = url;
                }
                function single_activity(courseid) {
                    var url = "'.$baseurl.'/admin/tool/leeloolxp_sync/
                    ?action=add&redirect=couseview&courseid="+courseid;
                    window.location = url;
                }
                </script>';
        }
        $this->content->text = $html;
        $this->content->footer = '';
        return $this->content;

    }

    /**
     * Allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }
}
