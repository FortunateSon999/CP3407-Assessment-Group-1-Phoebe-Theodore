<?php

header('Content-Type: application/json'); // Ensure the content type is JSON

include 'db_connection.php';

// Create connection
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch reviews and calculate ratings
    $review_data = $pdo->query('SELECT * FROM Review ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
    $review_count = count($review_data);
    $average_rating = 0;

    if ($review_count > 0) {
        $sum_rating = array_sum(array_column($review_data, 'rating'));
        $average_rating = $sum_rating / $review_count;
    }

    // Fetch star count
    $star_count = [
        '5' => 0,
        '4' => 0,
        '3' => 0,
        '2' => 0,
        '1' => 0
    ];

    foreach ($review_data as $review) {
        $star_count[$review['rating']]++;
    }

    // Prepare reviews for display
    $review_content = '';
    foreach ($review_data as $review) {
        $review_content .= '
        <div class="card mt-3">
            <div class="card-header"><b>' . htmlspecialchars($review['customer_id']) . '</b></div>
            <div class="card-body">';
        for ($i = 1; $i <= 5; $i++) {
            $review_content .= '<i class="fas fa-star ' . ($i <= $review['rating'] ? 'text-warning' : 'star-light') . '"></i>';
        }
        $review_content .= '<p class="mt-3">' . htmlspecialchars($review['comment']) . '</p></div></div>';
    }

    $response = [
        'average_rating' => number_format($average_rating, 1),
        'total_review' => $review_count,
        'star_count' => $star_count,
        'review_content' => $review_content
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

