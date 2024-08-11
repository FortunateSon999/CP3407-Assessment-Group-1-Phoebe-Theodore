<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Assuming customer_id is stored in the session after login
include 'login_restriction.php';

$customer_id = $_SESSION['customer_id'];

// Fetch all cars
$cars = $pdo->query('SELECT car_id, brand, model FROM Car')->fetchAll(PDO::FETCH_ASSOC);

// Fetch reviews and calculate ratings
$query = "
SELECT r.customer_id, r.car_id, r.rating, r.comment, c.brand, c.model 
FROM review r
JOIN Car c ON r.car_id = c.car_id
ORDER BY r.created_at DESC
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate average rating and star counts
$average_rating = 0;
$review_count = count($reviews);
$star_count = array_fill(1, 5, 0); // Initialize star counts from 1 to 5 stars

if ($review_count > 0) {
    foreach ($reviews as $review) {
        if (isset($review['rating']) && !empty($review['rating'])) {
            $star_count[$review['rating']]++;
            $average_rating += $review['rating'];
        } else {
            // Handle the case where rating is missing or invalid
            error_log("Invalid or missing rating for review: " . print_r($review, true));
        }
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Review & Rating System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Including Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   
    <!-- Including FontAwesome for star icons -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


    <!-- Including jQuery for AJAX and DOM manipulation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <!-- Including Popper.js for Bootstrap tooltips and popovers -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>


    <!-- Including Bootstrap JS for interactive components -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="stylesheet.css">
    
</head>
<body>
<div class="container">
    <h1 class="mt-5 mb-5">Review & Rating System</h1>
    <div class="card">
        <div class="card-header" style="color:#000000;">Car Reviews</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <h1 class="text-warning mt-4 mb-4">
                        <b><span id="average_rating"><?php echo number_format($average_rating, 1); ?></span> / 5</b>
                    </h1>
                    <div class="mb-3">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <i class="fas fa-star <?php echo ($i <= round($average_rating)) ? 'text-warning' : 'star-light'; ?> mr-1 main_star"></i>
                        <?php endfor; ?>
                    </div>
                    <h3 style="color:#000000;"><span id="total_review"><?php echo $review_count; ?></span> Review(s)</h3>
                </div>
                <div class="col-sm-4" style="color:#000000;">
                    <?php foreach ($star_count as $star => $count) : ?>
                        <p>
                            <div class="progress-label-left"><b><?php echo $star; ?></b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_<?php echo $star; ?>_star_review"><?php echo $count; ?></span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo $count; ?>" aria-valuemin="0" aria-valuemax="<?php echo $review_count; ?>" style="width:<?php echo $review_count ? ($count / $review_count) * 100 : 0; ?>%"></div>
                            </div>
                        </p>
                    <?php endforeach; ?>
                </div>
                <div class="col-sm-4 text-center">
                    <h3 class="mt-4 mb-3" style="color:#000000;">Write Review Here</h3>
                    <button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5" id="review_content" style="color:#000000;">
        <?php foreach ($reviews as $review) : ?>
            <div class="card mt-3">
                <div class="card-header"><b><?php echo htmlspecialchars($review['customer_id']); ?></b></div>
                <div class="card-body">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-warning' : 'star-light'; ?>"></i>
                    <?php endfor; ?>
                    <p class="mt-3"><?php echo htmlspecialchars($review['comment']); ?></p>
                    <p><strong>Car:</strong> <?php echo htmlspecialchars($review['brand'] . ' ' . $review['model']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Review Modal -->
<div id="review_modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:#000000;">Submit Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="text-center mt-2 mb-4">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_<?php echo $i; ?>" data-rating="<?php echo $i; ?>"></i>
                    <?php endfor; ?>
                </h4>
                <div class="form-group">
                    <select name="car_id" id="car_id" class="form-control">
                        <option value="">Select Car</option>
                        <?php foreach ($cars as $car) : ?>
                            <option value="<?php echo htmlspecialchars($car['car_id']); ?>">
                                <?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="review" id="review" class="form-control" placeholder="Type Review Here"></textarea>
                </div>
                <div class="form-group text-center mt-4">
                    <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="back-to-cars">
    <a href="car_details.php?car_id=<?php echo htmlspecialchars($review['car_id']); ?>" class="button">Back</a>
</div>

<script>
    var rating_data = 0;

    $(document).on('mouseenter', '.submit_star', function(){
        var rating = $(this).data('rating');
        reset_background();
        for(var count = 1; count <= rating; count++) {
            $('#submit_star_' + count).addClass('text-warning');
        }
    });

    function reset_background() {
        for(var count = 1; count <= 5; count++) {
            $('#submit_star_' + count).addClass('star-light');
            $('#submit_star_' + count).removeClass('text-warning');
        }
    }

    $(document).on('mouseleave', '.submit_star', function(){
        reset_background();
        for(var count = 1; count <= rating_data; count++) {
            $('#submit_star_' + count).removeClass('star-light');
            $('#submit_star_' + count).addClass('text-warning');
        }
    });

    $(document).on('click', '.submit_star', function(){
        rating_data = $(this).data('rating');
    });

    $('#add_review').click(function(){
        $('#review_modal').modal('show');
    });

    $('#save_review').click(function(){
        var car_id = $('#car_id').val();
        var review = $('#review').val();

        if(car_id == '' || review == '') {
            alert("Please Fill Both Fields");
            return false;
        } else {
            $.ajax({
                url:"submit_review.php",
                method:"POST",
                data:{rating_data:rating_data, car_id:car_id, review:review},
                success:function(data){
                    $('#review_modal').modal('hide');
                    load_review_data(); // Ensure function to refresh the review section
                }
            });
        }
    });
</script>
</body>
</html>
