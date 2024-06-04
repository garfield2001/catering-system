<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="@yield('body-class')">
    @yield('content')
    
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script>
        function loadContent(url) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // Update content area with the HTML content received from the AJAX response
                    $('.content').html(DOMPurify.sanitize($(data).find('.content').html()));

                    // Filter and append the specific script element with the ID 'custom-script'
                    /* $('body').append($(data).filter('#custom-script')); */

                    // Update document title based on the title received from the AJAX response
                    var newTitle = $(data).filter('title').text();
                    if (newTitle) {
                        $('head title').text(newTitle);
                    }
                }
            });
        }

        $(document).ready(function() {
            // Handler for navigation links click event
            $(document).on('click', 'a.link', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                loadContent(url);
                window.history.pushState({
                    path: url
                }, '', url); // Update browser history
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
