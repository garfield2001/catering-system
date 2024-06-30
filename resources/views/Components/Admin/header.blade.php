<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $title !== 'Dashboard' ? $title . ' Table' : $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if ($title !== 'Dashboard')
                        <!-- Check if not on the dashboard -->
                        <li class="breadcrumb-item"><a data-page='dashboard' class="link"
                                href="{{ route('dashboard.index') }}">Home</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>
