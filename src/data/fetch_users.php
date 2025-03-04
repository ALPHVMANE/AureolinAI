<?php
$labelsDir = 'labels/';
$usernames = [];

if (is_dir($labelsDir)) {
    foreach (scandir($labelsDir) as $folder) {
        if ($folder === '.' || $folder === '..') continue;
        
        $userFolder = $labelsDir . $folder;
        if (is_dir($userFolder)) {
            // Check if folder contains at least one image
            $images = glob("$userFolder/*.png");
            if (!empty($images)) {
                $usernames[] = $folder; // Add user if images exist
            }
        }
    }
}
header('Content-Type: application/json');
echo json_encode($usernames); // return a list of usernames
?>
