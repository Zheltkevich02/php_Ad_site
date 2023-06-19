$(document).ready(function() {
    // Handle form submission to add a new ad
    $("#add-ad-form").submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get form data
        var formData = $(this).serialize();

        // Send AJAX request to add the ad
        $.ajax({
            type: "POST",
            url: "ad.php",
            data: formData,
            success: function(response) {
                // Display success or error message
                $("#add-ad-form").prepend("<p class='message'>" + response + "</p>");

                // Clear form inputs
                $("#title").val("");
                $("#description").val("");

                // Refresh the ad list
                updateAdList();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    // Update the ad list
    function updateAdList() {
        $.ajax({
            type: "GET",
            url: "ad_list.php",
            success: function(response) {
                $(".ad-list").html(response);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    // Load the initial ad list
    updateAdList();
});
