@extends('Dashboard.layouts.master')

@section('css')
    <!-- Owl-carousel css -->
    <link href="{{ URL::asset('Dashboard/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('Dashboard/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome User</h2>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection

@section('content')
    {{-- 🔥 Intégration du composant React ici --}}
    <div id="react-index">
	</div>
@endsection
<br><br>
@section('js')
<script>
    window.user = @json(auth()->user());
</script>

@viteReactRefresh
@vite('resources/js/app.jsx')



@endsection

<!-- CSS -->

<!-- etc... -->
