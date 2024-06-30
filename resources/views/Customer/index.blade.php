@extends('layouts.app')

@section('title', $title)

@section('content')
    <section class="content">
        <div class="container-fluid">
            <h1>Front Page</h1>
            <button onclick="location.href='{{ route('reservations.index') }}';">Create A Reservation?</button>

            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloremque magni aliquam hic, asperiores omnis ut,
                sequi nam rem culpa at minima aperiam a, quos harum nulla distinctio tempora quam animi.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque ex id delectus ipsum nam, nostrum reiciendis
                ducimus, sequi sapiente ut repellendus itaque at aspernatur eum labore in recusandae quasi dicta.</p>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
