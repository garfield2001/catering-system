<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite('resources/css/dashboard.css')
</head>

<body class='hold-transition sidebar-mini layout-fixed'>
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        @include('components.navbar')
        @include('components.sidebar');

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('components.header')
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>

    <!-- Common JS -->
    <!-- jQuery -->
    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('AdminLTE/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('AdminLTE/plugins/toastr/toastr.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/9d3634a4ff.js" crossorigin="anonymous"></script>

    <script>
        function loadContent(url) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // Update content area with the HTML content received from the AJAX response
                    $('.content-wrapper').html($(data).find('.content-wrapper').html());

                    // Filter and append the specific script element with the ID 'custom-script'
                    $('body').append($(data).filter('#custom-script'));

                    // Update document title based on the title received from the AJAX response
                    var newTitle = $(data).filter('title').text();
                    if (newTitle) {
                        $('head title').text(newTitle);
                    }

                    // Update the active state of navigation links based on the new title
                    var currentPage = $('a[data-page="' + newTitle.toLowerCase() + '"]');
                    $('.link').removeClass('active');
                    currentPage.addClass('active');
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

            // Handler for breadcrumb links click event
            $(document).on('click', '.breadcrumb-item a', function(e) {
                e.preventDefault(); // Prevent default behavior of anchor tag
                var url = $(this).attr('href'); // Get the URL from the anchor tag
                loadContent(url); // Load content via AJAX
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
    @stack('scripts')
</body>

</html>
