<?php

require_once 'vendor/TimelineAPI/Timeline.php';

use TimelineAPI\Pin;
use TimelineAPI\PinLayout;
use TimelineAPI\PinLayoutType;
use TimelineAPI\PinIcon;
use TimelineAPI\PinReminder;
use TimelineAPI\Timeline;
use TimelineAPI\PebbleColour;

$params = null;
if (count($_POST) == 0) {
    $params = json_decode(file_get_contents('php://input'), true);
} else {
    $params = $_POST;
}

if ($params !== null) {
    pushReminderPin($params['app'], $params['usertoken']);
    echo json_encode(['status' => 0, 'message' => 'Reminder sent successfully!']);
} else {
    echo json_encode(['status' => 1, 'message' => 'Invalid request.']);
}

function pushReminderPin($appname, $usertoken) {
    date_default_timezone_set('UTC');
    $reminderlayout = new PinLayout(PinLayoutType::GENERIC_REMINDER, $appname, null, null, 'Please give ' . $appname . ' a heart if you like it! Thanks', PinIcon::NOTIFICATION_FLAG);
    $pinLayout = new PinLayout(PinLayoutType::GENERIC_PIN, $appname, null, null, 'Like ' . $appname . '? Please give it a heart if you do!', PinIcon::GENERIC_CONFIRMATION, PinIcon::GENERIC_CONFIRMATION, PinIcon:: GENERIC_CONFIRMATION, PebbleColour::WHITE, PebbleColour::ORANGE);
    $reminder = new PinReminder($reminderlayout, (new DateTime('now')) -> add(new DateInterval('P1D')));
    $pin = new Pin('reminder-'. $usertoken, (new DateTime('now')) -> add(new DateInterval('P1DPT10M')), $pinLayout);
    $pin -> addReminder($reminder);
    Timeline::pushPin($usertoken, $pin);
}