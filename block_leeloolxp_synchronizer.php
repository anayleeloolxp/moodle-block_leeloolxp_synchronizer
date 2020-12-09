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

require_once($CFG->dirroot.'/course/lib.php');

/**

 * class block_leeloolxp_synchronizer

 *

 * @package    block_leeloolxp_synchronizer
 * 
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_leeloolxp_synchronizer extends block_base {

   
    protected $timestart = null;

    /**
     * Initialises the block
     */
    function init() {
        // Commented dynamic call for now.
        $this->title = get_string('pluginname', 'block_leeloolxp_synchronizer');
    }

  

    function get_content() {
        if ($this->content !== NULL) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

            global $PAGE;

            global $DB;

            global $CFG;

            if($PAGE->pagetype=='course-view-topics') {

                $liacencekey = get_config('block_leeloolxp_synchronizer')->leeloolxp_block_synchronizer_licensekey;

                $courseid  = $_REQUEST['id'];

                $alreadysync = false;

                $baseurl = $CFG->wwwroot;

                $coursesyncedquery = $DB->get_records('tool_leeloolxp_sync',

                array('courseid' => $courseid));

                ?><style type="text/css">
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
                    </style> <?php

                if (empty($coursesyncedquery)) {

                    $html = '<div id="dialog-modal-course-synchronizer" class="dialog-modal dialog-modal-course " style="display: none;">

                            <div class="dialog-modal-inn">

                                <div id="dialog" >

                                    <h4>Are you sure you want to sync all the activities and resources of this course to Leeloo LXP?</h4>

                                    <div class="sure-btn">

                                        <button data_id = "" data_name="" onclick="yescourseunsync('.$courseid.');" 

                                        class="btn btn_yes_courseunsync" >Yes, I’m sure</button>

                                        <button  onclick="course_cls_popup();" class="btn course_cls_popup" >Cancel</button>

                                    </div>

                                    

                                </div>

                            </div>

                        </div>';

                } else {

                    $html = '<div id="dialog-modal-course-synchronizer" class="dialog-modal dialog-modal-course " style="display: none;">

                            <div class="dialog-modal-inn">

                                <div id="dialog" >

                                    <h4>Are you sure you want to RE-sync all the activities and resources of this course to Leeloo LXP?</h4>

                                    <div class="sure-btn">

                                        <button data_id = "" data_name="" onclick="resync('.$courseid.');" 

                                        class="btn btn_yes_courseunsync" >Yes, I’m sure</button>

                                        <button  onclick="course_cls_popup();" class="btn course_cls_popup" >Cancel</button>

                                    </div>

                                   

                                </div>

                            </div>

                        </div>';

                }

                if(isset($_REQUEST['sync'])) {

                    $html .= '<p style="color:green;">Sychronizationed successfully.</p>';    

                }

                $html .= "<h2>Synchronizer To leeloolxp</h2>";

                $html .= "<hr>";

                $html .= "<a href='#' onclick='show_popup();'>Sync Course </a><br>";

                $html .= "<a href='#' onclick='single_activity(".$courseid.");'>Sync Single Activity</a><br>";

                $html .= "<a href='#' onclick='sync_categories(".$courseid.");'>Sync Categories</a>";
                
                $html .= '<script> function show_popup() {

                        document.getElementById("dialog-modal-course-synchronizer").style.display = "block";

                    } 

                

                function course_cls_popup() {

                    document.getElementById("dialog-modal-course-synchronizer").style.display = "none";

                }
                function yescourseunsync(courseid) {

                    var url = "'.$baseurl.'/admin/tool/leeloolxp_sync/?action=coursesyncfrmblock&redirect=couseview&courseid="+courseid;

                    window.location = url;

                }

                function resync(courseid) {

                    

                    var url = "'.$baseurl.'/admin/tool/leeloolxp_sync/?resync=1&redirect=courseview&courseid_resync="+courseid;

                    window.location = url;

                }

                function single_activity(courseid) {

                    var url = "'.$baseurl.'/admin/tool/leeloolxp_sync/?action=add&redirect=couseview&courseid="+courseid;

                    window.location = url;

                }

                function sync_categories(courseid) {
                    var url = "'.$baseurl.'/admin/tool/leeloolxp_sync/?syncategory=1&redirect=couseview&courseid="+courseid;
                    window.location = url;
                }

                </script>';

            }

            $this->content->text = $html;

            $this->content->footer = '';

            return $this->content;
    }

   

    function has_config() {

        return true;

    }

}