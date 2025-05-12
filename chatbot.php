<?php
// chatbot.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = strtolower(trim($_POST['message']));

    $response = "I'm sorry, I didn't understand that. Can you rephrase your question?";

    if (strpos($input, 'disbursement') !== false || strpos($input, 'add disbursement') !== false) {
        $response = "To view disbursements, go to 'Finance' in the navigation bar and click on 'Disbursements'.";
    } elseif (strpos($input, 'fees') !== false) {
        $response = "You can view fee information under the 'Finance' section of the navigation menu.";
    } elseif (strpos($input, 'login') !== false) {
        $response = "You can log in by clicking the User logo in the navigation bar and click on 'Login'";
    } elseif (strpos($input, 'register') !== false) {
        $response = "You can register by clicking the User logo in the navigation bar that will lead you to the login page. Look for the 'Register' link and click.";
    } elseif (strpos($input, 'announcements') !== false || strpos($input, 'account') !== false) {
        $response = "Click on 'Operations' in the navigation bar and select 'Announcements' in the dropdown menu.";
    } elseif (strpos($input, 'officers') !== false || strpos($input, 'account') !== false) {
        $response = "Click on 'Organization' in the navigation bar.";
    }

    echo json_encode(['reply' => $response]);
}
?>