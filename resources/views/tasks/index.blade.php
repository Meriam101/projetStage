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
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hi, welcome Admin</h2>
        </div>
    </div>
</div>

@endsection

@section('content')
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <style>
                        .task-container {
                            max-width: 800px;
                            margin: 20px auto;
                            padding: 15px;
                        }

                        .task-title {
                            font-size: 28px;
                            font-weight: 700;
                            color: #2c3e50;
                            margin-bottom: 30px;
                            border-bottom: 2px solid #3498db;
                            padding-bottom: 10px;
                        }

                        .task-list {
                            list-style: none;
                            padding: 0;
                            margin: 0;
                        }

                        .task-item {
                            background-color: #ffffff;
                            border: 1px solid #ddd;
                            border-left: 5px solid #3498db;
                            border-radius: 6px;
                            padding: 20px;
                            margin-bottom: 15px;
                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                            transition: all 0.2s ease-in-out;
                        }

                        .task-item:hover {
                            transform: scale(1.01);
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        }

                        .task-item h3 {
                            margin: 0 0 10px;
                            font-size: 20px;
                            color: #333;
                        }

                        .task-item p {
                            margin: 5px 0;
                            font-size: 16px;
                            color: #555;
                        }

                        .status {
                            display: inline-block;
                            margin-top: 10px;
                            padding: 5px 10px;
                            border-radius: 20px;
                            font-size: 14px;
                            font-weight: 600;
                        }

                        .completed {
                            background-color: #2ecc71;
                            color: white;
                        }

                        .in-progress {
                            background-color: #f1c40f;
                            color: white;
                        }
                    </style>

                    <div class="task-container">
                        <h2 class="task-title">🧾 Liste des tâches de <span style="color:#3498db;">{{ $user->name }}</span></h2>
                        <ul class="task-list">
                            @forelse ($tasks as $task)
                                <li class="task-item">
                                    <h3>📌 Titre : {{ $task->title }}</h3>
                                    <p><strong>Description :</strong> {{ $task->description }}</p>
                                    <span class="status {{ $task->is_completed ? 'completed' : 'in-progress' }}">
                                        {{ $task->is_completed ? 'Complétée ✅' : 'En cours ⏳' }}
                                    </span>
                                </li>
                            @empty
                                <li class="task-item">
                                    <p>Aucune tâche assignée à cet employé pour le moment.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{ URL::asset('Dashboard/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<!-- Moment js -->
<script src="{{ URL::asset('Dashboard/plugins/raphael/raphael.min.js') }}"></script>
<!-- Flot js -->
<script src="{{ URL::asset('Dashboard/plugins/jquery.flot/jquery.flot.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/dashboard.sampledata.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/chart.flot.sampledata.js') }}"></script>
<!-- Apexchart js -->
<script src="{{ URL::asset('Dashboard/js/apexcharts.js') }}"></script>
<!-- Map -->
<script src="{{ URL::asset('Dashboard/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ URL::asset('Dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/modal-popup.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/index.js') }}"></script>
<script src="{{ URL::asset('Dashboard/js/jquery.vmap.sampledata.js') }}"></script>
@endsection
