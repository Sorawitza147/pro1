$(document).ready(function () {
    // When typing in the input
    $('#search').keyup(function () {
        var query = $(this).val();
        if (query != '') {
            // Send a request to search.php with the input letter
            $.ajax({
                url: 'search.php',
                method: 'POST',
                data: { query: query },
                success: function (data) {
                    // Show the results from the search
                    $('#show-list').fadeIn();
                    $('#show-list').html(data);
                }
            });
        } else {
            // If there is no input, hide the list
            $('#show-list').fadeOut();
            $('#show-list').html('');
        }
    });

    // When clicking on a displayed item
    $(document).on('click', 'a', function () {
        // Put the clicked item's text into the input
        $('#search').val($(this).text());
        // Hide the list
        $('#show-list').fadeOut();
    });
});