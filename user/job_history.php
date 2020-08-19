<?php
// This file is part of BOINC.
// http://boinc.berkeley.edu
// Copyright (C) 2016 University of California
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

//Added by Gerald Joshua

require_once("../inc/util.inc");


//Any website visitors who have not signed in yet will be
//redirected to the sign in page
/*$user = get_logged_in_user();
BoincForumPrefs::lookup($user);
*/
page_head(null, null, null, null, null, "Job History");
//Source for table styling (Carlos Redondo) https://www.w3schools.com/css/tryit.asp?filename=trycss_table_padding
if (!isset($_SESSION))
{
    session_start(); 
}

if(!isset($_SESSION['user'])){
        echo "<script>window.location.replace('./login_as_a_researcher.php');</s
cript>";
}
echo '<style>

table, td, th {
    border: 1px solid #7c7c7c;
    text-align: left;
}

th{
    background-color: #174b63;

    color: white;
}

table {
    border-collapse: collapse;
    width: 100%;
}

td {
    width=(100/5)%;
}

th, td {
    padding: 15px;
    border: 4px solid #7c7c7c;
}

</style>';

//Page Title
echo '<center><h1>Job History</h1></center><br />';
//Beginning of Thomas Johson's edit
//Beginning of Thomas Johnson's Edit
/*
https://stackoverflow.com/questions/15486988/how-to-use-curl-get-instead-of-post

$image = $_GET['Image'];
$command = $_GET['Command'];
$date_sub = $_GET['Date (Sub)'];
$date_run = $_GET['Date (Run)'];
$notified = $_GET['Notified'];

$ch = curl_init();

$query = '<Image="'.$image.'" Command="'.$command.'" Date (Sub)="'.$date_sub.'" Date (Run)="'.$date_run.'" Notified="'.$notified.'">';

$url = "http://SERVER_IP:5075/boincserver/v2/api/user_data/personal/TOKEN";

 $url_final = $url.''.$url_query;

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch, CURLOPT_GETFIELDS, $query);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$return = curl_exec($ch);
//$json = json_decode($return , true);
curl_close ($ch);

echo $return;
*/
$SERVER_IP="0.0.0.0";


/*
$ch2 = curl_init();

curl_setopt($ch2, CURLOPT_URL, "http://$SERVER_IP:5054/boincserver/v2/api/authorize_from_org");
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
//Gerald Joshua and Thomas Johnson joint edit
curl_setopt($ch2, CURLOPT_POSTFIELDS, "email=$user->email_addr&org_key=$TACC_org_key");
//End joint edit
curl_setopt($ch2, CURLOPT_POST, 1);

$headers = array();
$headers[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);

$TOKEN = curl_exec($ch2);
if (curl_errno($ch2)) {
echo 'Error:' . curl_error($ch2);
}
curl_close ($ch2);
*/
/*
https://stackoverflow.com/questions/22563996/displaying-json-from-an-api-in-and-html-table-using-php
Thomas Johnson and Carlos Redondo's edit
*/
// construct the query with our apikey and the query we want to make





//echo $SERVER_IP;
//exit();
//Need to modify code to allow for each user's/researcher's token to be collected for the purpose of
echo '<table>
      <tr>
      <th>Image</th>
      <th>Command</th>
      <th>CST Date (Sub)</th>
      <th>CST Date (Run)</th>
      <th>CST Date Notified</th>
      ';

// Obtains all the data for a researcher from the API
$endpoint = "http://$SERVER_IP:5092/boincserver/v2/api/user_data/personal/by_username/".$_SESSION['user'];

// setup curl to make a call to the endpoint
$session = curl_init($endpoint);
// indicates that we want the response back
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
// exec curl and get the data back
$data = curl_exec($session);
//print "\n$data\n";
// remember to close the curl session once we are finished retrieveing the data
curl_close($session);
// decode the json data to make it easier to parse the php
$search_results = json_decode($data, true);
if ($search_results === NULL) die('No Results.');
$search_results=$search_results['job data'];
//print_r($search_results);

foreach ($search_results as $coin) {
  /*
  $name = $coin["name"];
  $profit = $coin["profit"];
  */

  $image = $coin[0]['Image'];
  $command = $coin[0]['Command'];
  $date_sub = $coin[0]['Date (Sub)'];
  $date_run = $coin[0]['Date (Run)'];
  $notified = $coin[0]['Notified'];
  echo '<tr><td>' . $image . '</td>';
  echo '<td>' . $command . '</td>';
  echo '<td>' . $date_sub . '</td>';
  echo '<td>' . $date_run . '</td>';
  echo '<td>' . $notified . '</td></tr>';
  //End of Thomas Johnson and Carlos Redondo joint edit
}


echo '</table>';

//End of Thomas Johnson's edit

page_tail();
//End of Gerald Joshua's Edit

?>