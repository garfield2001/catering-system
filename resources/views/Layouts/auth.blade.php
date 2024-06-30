<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="@yield('body-class')">
    <div class="content">
        @yield('content')
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.8/purify.min.js"></script>
    <script>
        function loadContent(url) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // Sanitize and update the content area with the HTML content received from the AJAX response
                    var newContent = DOMPurify.sanitize($(data).find('.content').html());
                    $('.content').html(newContent);

                    // Update document title based on the title received from the AJAX response
                    var newTitle = $(data).filter('title').text();
                    if (newTitle) {
                        $('head title').text(newTitle);
                    }
                },
                error: function() {
                    alert('An error occurred while loading the page.');
                }
            });
        } 
        /* FIX ME 04/06/2024 */ 
        $(document).ready(function() {
            // Handler for navigation links click event
            $(document).on('click', 'a.ajax-link', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                loadContent(url);
                window.history.pushState({ path: url }, '', url); // Update browser history
            });

            // Handler for browser back/forward button click event
            window.onpopstate = function(event) {
                if (event.state) {
                    loadContent(event.state.path);
                }
            };

            // Initial check for active link on page load
            var initialTitle = $('head title').text();
            var initialPage = $('a[data-page="' + initialTitle.toLowerCase() + '"]');
            initialPage.addClass('active'); // Add 'active' class to current page link
        });
    </script>
</body>

</html>
