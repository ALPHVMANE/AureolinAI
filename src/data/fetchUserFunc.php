<?php
function getUsernamesWithImages($labelsDir = 'labels/') {
    $usernames = [];

    if (is_dir($labelsDir)) {
        foreach (scandir($labelsDir) as $folder) {
            if ($folder === '.' || $folder === '..') continue;
            $userFolder = $labelsDir . $folder;
            if (is_dir($userFolder)) {
                $images = glob("$userFolder/*.png");
                if (!empty($images)) {
                    $usernames[] = $folder;
                }
            }
        }
    }

    return $usernames;
}
header('Content-Type: application/json');
echo json_encode(getUsernamesWithImages());
?>
