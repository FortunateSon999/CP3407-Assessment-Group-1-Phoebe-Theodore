<?php
// Test case for valid discount code 'Green'
$tests = [
    [
        'description' => 'Test with discount_code = Green and discount_id = 1',
        'postData' => ['discount_code' => 'Green', 'discount_id' => 1],
        'expected' => ['success' => true, 'discount_percent' => 50.00]
    ],
    [
        'description' => 'Test with discount_code = Purple and discount_id = 2',
        'postData' => ['discount_code' => 'Purple', 'discount_id' => 2],
        'expected' => ['success' => true, 'discount_percent' => 15.00]
    ],
    [
        'description' => 'Test with invalid discount_code = INVALID2024 and discount_id = 1',
        'postData' => ['discount_code' => 'INVALID2024', 'discount_id' => 1],
        'expected' => ['success' => false, 'message' => 'Invalid or expired discount code.']
    ]
];

foreach ($tests as $test) {
    echo "<h2>{$test['description']}</h2>";
    $url = 'http://localhost/ass1/CP3407-Assessment-Group-1-Phoebe-Theodore/validate_discount.php'; // Update to the correct URL
    $postData = http_build_query($test['postData']);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    
    echo "<pre>";
    echo "Response: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
    echo "Expected: " . json_encode($test['expected'], JSON_PRETTY_PRINT) . "\n";
    echo "</pre>";

    $pass = ($result == $test['expected']) ? 'PASS' : 'FAIL';
    echo "<p>Status: $pass</p><hr />";
}
?>

