@extends('layouts.main')

@section('title')
	Students Services
@endsection

@section('content')
	<div class="global-header" style="background-image: url('{{ asset('img/intro-banner/1.jpg') }}');">
		<div class="global-header__block">
			<div class="va-block">
				<div class="va-middle text-center">
					<h1>Students Services</h1>
				</div>
			</div>
		</div>
	</div>
    <main id="main">
		<div class="row">
			<div class="col-md-8">
				<div class="row mt-2">
					<div class="col-md-12">
						<img src="{{ asset('img/website/chart.jpg') }}" alt="" class="img-fluid">
					</div>												
				</div>
			</div>
			
				<div class="col-md-4">
					@include('pages.students.partials.sidebar')
				</div>
			
		</div>
		
    </main>
@endsection