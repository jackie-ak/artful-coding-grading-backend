<?php

$s = "Session";
$r = "Review for exercise";

$ids = [
  "jane" => ["id" => "0123", "key" => "6QoVgiaP1NCoMj9b", "fullname" => "Jane Doe"],
  "luz" =>  ["id" => "0246", "key" => "PKCm89C1c0s6BpG3", "fullname" => "Luziente"],
];

$attendance = [
  "columns" => ["$s 1", "$s 2", "$s 3", "$s 4", "$s 5", "$s 6", "$s 7", "attended 5 or more sessions"],
  "jane" => ["points" => [3, 3, 0, 3, false, false, false, false], "comment" => "awesome!"],
  "luz" => ["points" => [false, false, false, false, false, false, false, false], "comment" => ""],
];

$exercises = [
  "columns" => ["000 extra challenge", "ex2", "ex3", "ex4", "ex5", "ex6"],
  "jane" =>    ["points" => [      10,     5,     3,     0, false, false], "comment" => ""],
  "luz" =>     ["points" => [   false, false, false, false, false, false], "comment" => ""],
];

$reviews = [
  "columns" => ["$r 2", "$r 3", "$r 4", "$r 5", "$r 6"],
  "jane" =>    ["points" => [ 5, 5, 3, 0, false, false], "comment" => ""],
  "luz" =>     ["points" => [false, false, false, false, false, false], "comment" => ""],
];

$final_project = [
  "columns" => ["Minimum requirement (9p)", "Logic change/extension (8p)", "Creative change/extension (8p)"],
  "jane" =>    ["points" => [ 9, 0, 8], "comment" => ""],
  "luz" =>     ["points" => [false, false, false], "comment" => ""],
];
