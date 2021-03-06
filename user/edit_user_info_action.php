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

require_once("../inc/boinc_db.inc");
require_once("../inc/user.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");

check_get_args(array("tnow", "ttok"));

$user = get_logged_in_user();
check_tokens($user->authenticator);


/*
$name = trim(post_str("user_name"));
if ($name != sanitize_tags($name)) {
    error_page(tra("HTML tags are not allowed in your name."));
}
if (strlen($name) == 0) {
    error_page(tra("You must supply a name for your account."));
}
*/



$url = post_str("url", true);
$url = sanitize_tags($url);
$country = post_str("country");
if ($country == "") {
    $country = "International";
}
if (!is_valid_country($country)) {
    error_page("bad country");
}
$country = BoincDb::escape_string($country);
if (POSTAL_CODE) {
    $postal_code = BoincDb::escape_string(sanitize_tags(post_str("postal_code", true)));
} else {
    $postal_code = '';
}



$url = BoincDb::escape_string($url);
$result = $user->update(
    "url='$url', country='$country', postal_code='$postal_code'"
);


/*
// Updating usernames is no longer allowed


$name = BoincDb::escape_string($name);
$url = BoincDb::escape_string($url);


$user_already_exists = BoincUser::lookup("name='$name'");
if ($user_already_exists) {
    error_page(tra("There's already an account with that name."));
    exit();
}


$result = $user->update(
    "name='$name', url='$url', country='$country', postal_code='$postal_code'"
);

$original_name = $user->name;

//Added by Gerald Joshua: Update the screen_name_anonymization table as well
$set_clause = "name = '$name'";
$where_clause = "name = '$original_name'";
BoincUser::screen_name_update($set_clause, $where_clause);

*/


if ($result) {
    Header("Location: ".USER_HOME);
} else {
    error_page(tra("Couldn't update user info."));
}

?>