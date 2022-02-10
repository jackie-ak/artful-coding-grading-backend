<?php
/**
 * artful coding grading backend
 *
 * Script to provide a grading breakdown based on a configuration in grades.php
 */

include 'grades.php';

// all messages and results will be returned as JSON, so we let the browser
// know through the Content-Type header, so it can display it nicely
header('Content-Type: application/json');
// also we want to allow access from frontends everywhere
header('Access-Control-Allow-Origin: *');

/**
 * Set an HTTP response code, print message and quit.
 *
 * @param int           $code     The HTTP status code
 * @param string|array  $message  A message to be output as JSON-encoded response body.
 */
function return_error_and_quit($code, $message) {
  http_response_code($code);
  echo(json_encode($message));
  die();
}

/**
 * Authorize and return user name, or false
 *
 * @param string  $id      The user ID to check
 * @param string  $key     The secret user key to authorize the user with ID $id agains.
 * @param array   $config  An array containing usernames as keys an another assoc. array
 *                         as value, which contains an "id", "key", and "fullname" key:
 *                         ["..." => ["id"=>"...",  $key=>"...", "fullname"=>"..."]],
 * @return bool|string Either false if not authorized or the user name
 */
function authorize_user($id, $key, $config) {
  $u = false;
  foreach ($config as $user => $params) {
    if ($params["id"] === $id) {
      $u = $user;
      break;
    }
  }
  if ($u && $config[$u]["key"] === $key) return $u;
  return false;
}

// check if all necessary data is set and if the user is authorized
// exit script if wrong parameters or invalid auth
if (!isset($_POST["id"]) or !isset($_POST["key"])) {
  return_error_and_quit(400, ["error" => "POST parameters have to be set: id, key"]);
}
$user = authorize_user($_POST["id"], $_POST["key"], $ids);
if (!$user) {
  return_error_and_quit(404, ["error" => "You are not authorized to collect these grades"]);
}

/**
 * Return the transformed grading breakdown for a single user and grading category
 *
 * @param array  $stats  The grading statistics from which to extract a users breakdown
 * @param string $user   The requested user name for this grading breakdown
 *
 * @return array The grading breakdown containing a total and comment
 */
function filter_and_transform_stats($stats, $user) {
  $ret = [
    "total" => 0,
    "breakdown" => [],
    "comment" => $stats[$user]["comment"],
  ];
  foreach ($stats["columns"] as $idx => $val) {
    $points = $stats[$user]["points"][$idx];
    $ret["breakdown"][] = [
      "points" => $points,
      "for" => $val,
    ];
    $ret["total"] += $points;  # if false also 0 points will be added
  }
  return $ret;
}

/**
 * Return the total number of points over an array of grading statistics
 *
 * @param string  $user  The requested user name
 * @param array   $breakdown  An array of grading statistics used for the overall grading
 *
 * @return int The total points of a user
 */
function get_total_points($user, $breakdown) {
  $total = 0;
  foreach ($breakdown as $stats) {
    foreach ($stats[$user]["points"] as $points) {
      $total += $points;
    }
  }
  return $total;
}

/**
 * Return a grade based on the total points
 *
 * @param int  $total  The total number of points
 *
 * @return int  A grade between 1 and 5, based on the total number of points
 */
function get_grade_from_total($total) {
  $grade = 5;
  if ($total >= 50) $grade--;
  if ($total >= 60) $grade--;
  if ($total >= 70) $grade--;
  if ($total >= 80) $grade--;
  return $grade;
}


// assemble all relevant data for the authorized user
$total = get_total_points($user, [$attendance, $exercises, $reviews, $final_project]);
$stats = [
  "id" => $ids[$user]["id"],
  "fullname" => $ids[$user]["fullname"],
  "total" => $total,
  "grade" => get_grade_from_total($total),
  "breakdown" => [
    "attendance" => filter_and_transform_stats($attendance, $user),
    "exercises" => filter_and_transform_stats($exercises, $user),
    "reviews" => filter_and_transform_stats($reviews, $user),
    "final_project" => filter_and_transform_stats($final_project, $user),
  ],
];

// send the data as JSON
echo(json_encode($stats));
