<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['image_url'];

    // Validate URL
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        die('Invalid image URL.');
    }

    // Get image content from the URL
    $imageData = file_get_contents($url);
    if ($imageData === false) {
        die('Failed to download image.');
    }

    // Create image from the downloaded data (detects the image type automatically)
    $image = imagecreatefromstring($imageData);

    if ($image === false) {
        die('Failed to create image from string.');
    }

    // Generate a unique name for the file with a .png extension
    $fileName = 'downloaded_' . time() . '.png';

    // Define the relative path to the "generatedIMG" directory
    $savePath = __DIR__ . '/../../../data/generatedIMG/' . $fileName;

    // Ensure the "generatedIMG" directory exists
    if (!is_dir(__DIR__ . '/../../../data/generatedIMG')) {
        mkdir(__DIR__ . '/../../../data/generatedIMG', 0777, true);
    }

    // Save the image as a .png
    imagepng($image, $savePath); // Convert and save it as PNG

    // Free up memory
    imagedestroy($image);

    echo "Image saved as <strong>$fileName</strong> in the generatedIMG folder.";
}
?>
