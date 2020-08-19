<?php
// This file is part of BOINC.
// http://boinc.berkeley.edu
// Copyright (C) 2008 University of California
//
// BOINC is free software; you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License
// as published by the Free Software Foundation,
// either version 3 of the License, or (at your option) any later version.
//
// BOINC is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with BOINC.  If not, see <http://www.gnu.org/licenses/>.

//Edited by Thomas Johnson III

require_once("../inc/util.inc");
require_once("../inc/user.inc");
require_once("../inc/boinc_db.inc");
require_once("../inc/deanonymize_user.inc");
require_once("../inc/forum.inc");



check_get_args(array());

// show the home page of logged-in user

$user = get_logged_in_user();
BoincForumPrefs::lookup($user);
$user = get_other_projects($user);

$init = isset($_COOKIE['init']);
$via_web = isset($_COOKIE['via_web']);
if ($via_web) {
    clear_cookie('via_web');
}

$cache_control_extra = "no-store,";

if ($init) {
    clear_cookie('init');
    page_head(tra("Welcome to %1", PROJECT));
    echo "<p>".tra("View and edit your account preferences using the links below.")."</p>\n";
    if ($via_web) {
        echo "<p> "
        .tra("If you have not already done so, %1 download BOINC client software %2.", "<a href=\"https://boinc.berkeley.edu/download.php\">", "</a>")."</p>";
    }
} else {
    page_head(
        null, null, null, null, null, "Your Account"//Keeps the tab title as Create Account without making the tab title subject to changes in the <body>
    );
}
echo'<br><br>';
echo '<font size=+3 style ="position:relative; left:36%;">'.tra("Your Account").'</font>';//Repositions the `Your Account` (user) text on the webpage


$real_username = $user->name;


// If the user is currently using an anonymous username
if (using_anonymous_username($real_username)){
    echo "<form action=\"deanonymize_action.php\" method=\"post\">";
    echo '<input type="hidden" name="action" value="change"><label for "action"> Click the following button to display your real username on the public profile: </label>';
    echo "<input style=\"background-color: #DCDCDC; margin-left: 20px\" type=\"submit\"  value=\"show real username\" name=\"show_real_username\"></form>";


} else {

    echo "<form action=\"deanonymize_action.php\" method=\"post\">";
    echo '<input type="hidden" name="action" value="change"><label for "action"> Click the following button to display an anonymous username on the public profile: </label>';
    echo "<input style=\"background-color: #DCDCDC; margin-left: 20px\" type=\"submit\" value=\"show anonymous username\" name=\"show_anonymous_username\"></form>";
}

echo "<br><br>";

// Allows to change preferences for exporting data
// echo "<form action=\"deanonymize_action.php\" method=\"post\">";
// echo '<input type="hidden" name="action" value="change">';
// echo "<input type=\"submit\" value=\"export BOINC statistics\" name=\"export_stats\"></form>";
// echo '</td></tr>';

show_account_private($user);



page_tail();

?>
