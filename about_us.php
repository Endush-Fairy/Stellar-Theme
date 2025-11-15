<?php
require_once(__DIR__ . '/../../config.php');

$PAGE->set_url(new moodle_url('/theme/stellar/about_us.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('About Us');
$PAGE->set_heading('About Stellar Career College');
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

echo $OUTPUT->footer();