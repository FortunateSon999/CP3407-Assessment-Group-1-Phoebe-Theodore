$(document).ready(function() {
    var rating_data = 0; 
    
    // Event listener for opening review modal
    $('#add_review').click(function(){
        $('#review_modal').modal('show');
    });

    // Event listener for star rating hover
    var rating_data = 0;
    $('.submit_star').mouseenter(function(){
        var rating = $(this).data('rating');
        reset_star();
        for(var count = 1; count <= rating; count++){
            $('#submit_star_' + count).addClass('text-warning');
        }
    });

    // Event listener for star rating mouse leave
    $('.submit_star').mouseleave(function(){
        reset_star();
        for(var count = 1; count <= rating_data; count++){
            $('#submit_star_' + count).addClass('text-warning');
        }
    });

    // Event listener for star rating click
    $('.submit_star').click(function(){
        rating_data = $(this).data('rating');
    });

    // Function to reset star rating
    function reset_star(){
        for(var count = 1; count <= 5; count++){
            $('#submit_star_' + count).removeClass('text-warning');
        }
    }

    // Event listener for save review button click
    $('#save_review').click(function(){
        var user_name = $('#user_name').val();
        var user_review = $('#user_review').val();
        var car_id = $('#car_id').val();
        
        if(user_name == '' || user_review == '' || car_id == ''){
            alert("Please Fill All Fields");
            return false;
        } else {
            $.ajax({
                url: "submit_review.php",
                method: "POST",
                data: {user_name: user_name, rating: rating_data, user_review: user_review, car_id: car_id},
                success: function(data){
                    $('#review_modal').modal('hide');
                    load_rating_data();
                    alert(data);
                }
            });
        }
    });

    // Function to load rating data
    function load_rating_data(){
        $.ajax({
            url: "fetch_review.php",
            method: "GET",
            success: function(data){
                console.log(data);  // Add this line to log the response
                var parsedData = JSON.parse(data);
                if (parsedData.error) {
                    console.error(parsedData.error);
                    return;
                }
                $('#average_rating').text(parsedData.average_rating || 'N/A');
                $('#total_review').text(parsedData.total_review || '0');

                for(var star in parsedData.star_count){
                    $('#total_' + star + '_star_review').text(parsedData.star_count[star] || '0');
                    $('#' + star + '_star_progress').css('width', (parsedData.star_count[star] / parsedData.total_review) * 100 + '%');
                }

                $('#review_content').html(parsedData.review_content || '');
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.error("AJAX error: ", textStatus, errorThrown);
            }
        });
    }

    // Load rating data when the document is ready
    load_rating_data();
});

