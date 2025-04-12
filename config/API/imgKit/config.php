<?php 
// Import autoloader from vendor
// If not using PSR-4 is not configured in composer.json file for your project
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . 'env.php';

use ImageKit\ImageKit;  
  
// For demonstration purposes, the documentation would use https://ik.imagekit.io/demo as urlEndpoint

$sample_file_path = "/img".createID().".jpg";
$imageKit = new ImageKit(
    "UPLOAD_PubK",
    "UPLOAD_PrivK",
    "UPLOAD_URL"
);

// Upload Image - URL
$uploadFile = $imageKit->uploadFile([
    "file" => "https://imagekit.io/image.jpg",
    "fileName" => "my_file_name.jpg"
]);

echo ("Upload URL" . json_encode($uploadFile));


function createID($file = 'imgName.txt') {
    // If the file doesn't exist, create it with initial ID of 1
    if (!file_exists($file)) {
        file_put_contents($file, 1);
        return 1;
    }

    // Get the last ID
    $lastId = (int) file_get_contents($file);

    // Increment the ID
    $newId = $lastId + 1;

    // Save the new ID back to the file
    file_put_contents($file, $newId);

    return $newId;
}
