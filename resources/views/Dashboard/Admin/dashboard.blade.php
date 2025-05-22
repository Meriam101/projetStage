@extends('Dashboard.layouts.master')
@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('Dashboard/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('Dashboard/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
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
<!-- /breadcrumb -->
@endsection

@section('content')
<div class="row row-sm">
						<div class="col-xl-12">
							<div class="card">
								<div class="card-header pb-0">
									<div class="d-flex justify-content-between">
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Ajouter</button>
									</div>
																</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table text-md-nowrap" id="example1">
											<thead>
												<tr>
													<th class="wd-15p border-bottom-0">N°</th>
													<th class="wd-15p border-bottom-0">Nom employée</th>
													<th class="wd-20p border-bottom-0">Post</th>
													<th class="wd-20p border-bottom-0">les tache de l'employé</th>	
	
												</tr>
											</thead>
			
<tbody>
											@foreach ($users as $user)
											<tr>
												  <td>{{$user->id}}</td>
												  <td>{{$user->name}}</td>
												  <td>{{$user->post}}</td>
												  <td>
													<a href="{{ route('employee.tasks', $user->id) }}">
					<button type="button" class="btn btn-primary" >
						List des taches</button></a>
												  </td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>
@endsection
