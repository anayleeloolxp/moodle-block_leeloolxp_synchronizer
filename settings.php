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
 *  leeloolxp_synchronizer block settings
 *
 * @package    block_leeloolxp_synchronizer
 * @copyright  2020 leelolxp.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined( 'MOODLE_INTERNAL' ) || die;
if ( $ADMIN->fulltree ) {
    $name = 'block_leeloolxp_synchronizer/licensekey';
    $title = get_string( 'licensekey', 'block_leeloolxp_synchronizer' );
    $description = get_string( 'licensekey_desc', 'block_leeloolxp_synchronizer' );
    $setting = new admin_setting_configtext( $name, $title, $description, 0, PARAM_TEXT );
    $settings->add( $setting );
}
