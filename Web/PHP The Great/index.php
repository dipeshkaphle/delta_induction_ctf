<?php
include 'constants.php';
error_reporting(0);

$part1 = $_GET['part1'];
$part2 = $_POST['part2'];
$part3 = $_COOKIE['part3'];
$part4 = $_GET['part4'];

if (isset($_GET['part1'])) {
  if (strcmp($part1, CONSTANT_1) == 0) {
    echo FLAG_1 . "\n";
    die();
  }
}

if (isset($_POST['part2'])) {
  $part2 = trim($part2);
  if ($part2 == '5.5e5' && $part2 !== '5.5e5') {
    echo FLAG_2 . "\n";
    die();
  }
}

if (isset($_COOKIE['part3'])) {
  if ($part3 == 42 && $part3 !== '42' && $part3 !== 42 && strlen(trim($part3)) == 2) {
    echo FLAG_3 . "\n";
    die();
  }
}

if (isset($_GET['part4'])) {
  # Magic
  if (hash('md4', $part4) == 0) {
    echo FLAG_4 . "\n";
    die();
  }
}

highlight_file(__FILE__);
