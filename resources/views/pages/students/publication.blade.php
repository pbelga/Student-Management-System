@extends('layouts.main')

@section('title')
	Publication
@endsection

@section('content')
	<div class="global-header" style="background-image: url('{{ asset('img/intro-banner/1.jpg') }}');">
		<div class="global-header__block">
			<div class="va-block">
				<div class="va-middle text-center">
					<h1>Publication</h1>
				</div>
			</div>
		</div>
	</div>
    <main id="main">
		<div class="container">
			<div class="row mb-5 " align="center">
				<div class="col-md-12">
					<img src="{{ asset('img/website/publication.jpg') }}" alt="" class="img-fluid">
				</div>
			</div>
		</div>
    </main>
@endsection