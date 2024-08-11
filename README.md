# cp3407-project template 

This a project assignment template for CP3407. 
The following is the list of items, which are required to be completed.

## Team (Group 1)

It is recommended to complete this assignment in a group of maximum 3 students.
1. Chung Sheng Ni Phoebe [14351028]
2. Theodore Lee Qi [14341943] 

## File Discription
1. aboutus.php: Displays detailed information about the company, including its history, mission, and values.
2. account_checking.php: Ensures that users are logged in before accessing specific features, verifying their session status.
3. booking_confirm.php: Manages the booking confirmation process, calculating the total price, applying discounts, saving the final price to the Rentals table, and handling payment methods and details.
4. booking.php: Allows customers to enter booking information, selecting car preferences, dates, and other relevant details.
5. cancle_booking.php: Handles booking cancellations by updating the booking status to 'cancelled,' retrieving the associated car ID, marking the car as available again, and redirecting to a cancellation confirmation page or displaying a message.
6. car_details.php: Displays detailed information about a specific car, including its features, availability, and pricing.
7. cars.php: Lists all available cars in the inventory, allowing users to browse and select cars for booking.
8. chatbot_backend.php: Implements basic chatbot logic, including keyword-based responses, handling common questions, and logging unanswered queries to a separate table.
9. chatbot.php:  Provides the user interface for the chatbot, showing typing indicators, handling user input, and triggering responses when buttons are clicked or the "Enter" key is pressed.
10. db_connection: Establishes and manages the connection to the database, ensuring secure and efficient data access.
11. forgot-password.php: Allows users to initiate the password reset process by entering their email address. If the email is found in the system, a password reset code is generated and sent to the user’s email.
12. homepage.php: Serves as the main landing page, displaying discounts, enabling car searches, and allowing customers to book cars directly from the homepage.
13. login.php: Handles user authentication by checking the provided credentials against the database. It supports both customer and employee logins, and upon successful authentication, it redirects the user to the appropriate page.
14. logout.php: Logs the user out by ending their session, ensuring that they are redirected to a secure page afterward.
15. mybooking.php: Displays the customer's current and past bookings, providing details about each booking.
16. new-password.php: Enables users to set a new password after successfully verifying their identity with a reset code. The new password is then securely stored in the database.
17. password-changed.php: Confirms to the user that their password has been successfully changed and provides a link to log in with the new credentials.
18. profile.php: Allows customers to view and update their personal information, such as contact details and preferences.
19. register.php: Handles the registration process for new customers, adding their details to the database.
20. reset-code.php: Generates a one-time password (OTP) code for secure account verification or password reset.
21. stylesheet.css: Defines the visual style of the website, including layout, colors, fonts, and other design elements.
22. submit_booking.php: Processes and saves booking information to the database, confirming the booking details.
23. submit_review.php: Handles the submission of customer reviews, saving them to the database for future reference.
24. validate_discount.php: Verifies the validity of discount codes, checking expiration dates and applying discounts if applicable.
25. login_restriction.php: Ensures that customers are logged in before accessing certain features, protecting sensitive areas of the site.




# *General* project planning BEFORE iteration-1, (see chapters 1 and 2)

Checklist: 
1. github entry timestamp is BEFORE the iteration-1
2. User stories are correct: see p39
3. Must have more user stories than fits into iterations 1 and 2. To practice the priority.

### Iteration 1 [27/6/24 - 14/7/24]

1. Homepage Interface (Priority: 10, Effort Estimate: 1 day)

2. About Us Interface (Priority: 30, Effort Estimate: 1 day)

3. Booking Interface (Priority: 10, Effort Estimate: 3 days)

4. Login Interface (Priority: 20, Effort Estimate: 2 days)

5. Database Design (Priority: 10, Effort Estimate: 2 days)

6. Car Interface (Priority: 20, Effort Estimate: 4 days)

7. Car informaation pop-up interface (Priority: 20, Effort Estimate: 2 days)

8. Customer Registration Interface (Priority: 10, Effort Estimate: 2 days)
    
9. Login and Logout Functionality (Priority: 20, Effort Estimate: 2 days)
    
10. Booking system (Priority: 10, Effort Estimate: 3 days)

11. Bill interface (Priority: 30, Effort Estimate: 2 days)

12. Review System (Priority: 20, Effort Estimate: 10 days)

13. User Account Management (Priority: 20, Effort Estimate: 2 days)
   

Total: 36 days


### Iteration 2 [15/7/24 - 31/7/24]
1. Homepage Enhancements (Priority: 30, Effort Estimate: 3 days)
   
2. User Profile Funtionality (Priority: 30, Effort Estimate: 3 days)
    
3. Booking system update (Priority: 10, Effort Estimate: 3 days)

4. Password management (Priority: 30, Effort Estimate: 3 days)

5. AI Chatbot and Live Chat (Priority: 40, Effort Estimate: 11 days)

6. Payment Gatway Integration (Priority: 10, Effort Estimate: 11 days)


Total: 34 days


### Iteration 3 [1/8/24 - 11/8/24]
1. AI Chatbot and Live Chat (Priority: 40, Effort Estimate: 6 days)

2. Discount Integration (Priority: 30, Effort Estimate: 4 days)

3. Stars Animation Fix (Priority: 20, Effort Estimate: 2 days)

4. Design Improvements (Priority: 30, Effort Estimate: 4 days)

5. Unit Testing for Critical Functionalities (Priority: 30, Effort Estimate: 6 days)

Total: 22 days


Total effort time: 92 days
