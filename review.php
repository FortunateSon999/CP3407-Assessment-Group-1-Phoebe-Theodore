<?php
session_start();

// Assuming customer_id is stored in the session after login
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rent";

// Create connection
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch all cars
$cars = $pdo->query('SELECT car_id, brand, model FROM Car')->fetchAll();

// Fetch reviews and calculate ratings
$review_data = $pdo->query('SELECT * FROM Review')->fetchAll();
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
    if (isset($review['rating']) && array_key_exists($review['rating'], $star_count)) {
        $star_count[$review['rating']]++;
    } else {
        error_log("Invalid rating found: " . print_r($review, true)); // Log the invalid rating for debugging
    }
}

// Fetch reviews for display
$reviews = $pdo->query('SELECT * FROM Review ORDER BY created_at DESC')->fetchAll();
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
            <div class="card-header" style="color:#000000;">Product</div>
            <div class="card-body">
                <div class="row">
                    <!-- Fix me!!! -->
                    <!-- Section for displaying average rating and total reviews -->
                    <div class="col-sm-4 text-center">
                        <h1 class="text-warning mt-4 mb-4">
                            <b><span id="average_rating"><?php echo number_format($average_rating, 1); ?></span> / 5</b>
                        </h1>
                        <div class="mb-3" style="color:#808080;">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <i class="fas fa-star star-light mr-1 main_star"></i>
                            <?php endfor; ?>
                        </div>
                        <h3 style="color:#000000;"><span id="total_review" style="color:#000000;"><?php echo $review_count; ?></span> Review(s)</h3>
                    </div>
                    <!-- Displaying rating -->
                    <div class="col-sm-4" style="color:#000000;">
                        <?php foreach ($star_count as $star => $count) : ?>
                            <p>
                                <div class="progress-label-left"><b><?php echo $star; ?></b> <i class="fas fa-star text-warning"></i></div>
                                <div class="progress-label-right">(<span id="total_<?php echo $star; ?>_star_review"><?php echo $count; ?></span>)</div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo $count; ?>" aria-valuemin="0" aria-valuemax="<?php echo $review_count; ?>" id="<?php echo $star; ?>_star_progress" style="width:<?php echo $review_count ? ($count / $review_count) * 100 : 0; ?>%"></div>
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
        <!-- Fix me!! -->
        <div class="mt-5" id="review_content" style="color:#000000;">
            <?php foreach ($reviews as $review) : ?>
                <div class="card mt-3">
                    <div class="card-header"><b><?php echo htmlspecialchars($review['customer_id']); ?></b></div>
                    <div class="card-body">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-warning' : 'star-light'; ?>"></i>
                        <?php endfor; ?>
                        <p class="mt-3"><?php echo htmlspecialchars($review['comment']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal for submitting a review -->
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
                    <h4 class="text-center mt-2 mb-4" style="color:#808080;">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_<?php echo $i; ?>" data-rating="<?php echo $i; ?>"></i>
                        <?php endfor; ?>
                    </h4>
                    <div class="form-group">
                        <select name="car_id" id="car_id" class="form-control">
                            <option value="">Select Car</option>
                            <?php foreach ($cars as $car) : ?>
                                <option value="<?php echo $car['car_id']; ?>"><?php echo $car['brand'] . ' ' . $car['model']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Your Name" />
                    </div>
                    <div class="form-group">
                        <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="animator_stars.js"></script>
    <script>
        $(document).ready(function() {
            // Rating stars click event
            var rating_data = 0;
            $(document).on('mouseenter', '.submit_star', function() {
                var rating = $(this).data('rating');
                reset_background();
                for (var count = 1; count <= rating; count++) {
                    $('#submit_star_' + count).addClass('text-warning');
                }
            });

            function reset_background() {
                for (var count = 1; count <= 5; count++) {
                    $('#submit_star_' + count).addClass('star-light');
                    $('#submit_star_' + count).removeClass('text-warning');
                }
            }

            $(document).on('mouseleave', '.submit_star', function() {
                reset_background();
                for (var count = 1; count <= rating_data; count++) {
                    $('#submit_star_' + count).removeClass('star-light');
                    $('#submit_star_' + count).addClass('text-warning');
                }
            });

            $(document).on('click', '.submit_star', function() {
                rating_data = $(this).data('rating');
            });

            $('#save_review').click(function() {
                var user_name = $('#user_name').val();
                var user_review = $('#user_review').val();
                var car_id = $('#car_id').val();
                if (user_name == '' || user_review == '' || car_id == '') {
                    alert('Please Fill All The Fields');
                    return false;
                } else {
                    $.ajax({
                        url: "submit_review.php",
                        method: "POST",
                        data: {
                            rating: rating_data,
                            user_name: user_name,
                            user_review: user_review,
                            car_id: car_id,
                            customer_id: <?php echo $customer_id; ?>
                        },
                        success: function(data) {
                            $('#review_modal').modal('hide');
                            alert(data);
                            location.reload();
                        }
                    })
                }
            });

            $('#add_review').click(function() {
                $('#review_modal').modal('show');
            });
        });
    </script>
</body>
</html>

<!-- the comment didnt save it in the db -->