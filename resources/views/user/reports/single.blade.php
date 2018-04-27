@extends('layouts.layout')

@section('styles')
	<link rel="stylesheet" href="{{ asset('css/calendar.min.css') }}">
@endsection

@section('content')
	<div class="container">
		<h4 class="text-center">Individual Attendance</h4>
		<hr>
		<form action="#" class="form-inline">
			<div class="form-group mr-3 text-info">
				&nbsp;&nbsp;Course: {{ auth()->user()->courses->name }}
			</div>
			<div class="form-group mr-3">
				Batch:&nbsp;&nbsp;
				<select name="subject" id="singleBatch" class="form-control changer">
					@for($i=0;$i<4;$i++){
						<option value="{{ $year-$i }}">{{ $year-$i }}</option>
					@endfor
				</select>	
			</div>
			<div class="form-group mr-3">
				Subject:&nbsp;&nbsp;
				<select name="subject" id="singleSubject" class="form-control changer">
					@foreach(auth()->user()->subjects as $subject)
						<option value="{{ $subject->id }}">{{ $subject->name }}</option>
					@endforeach
				</select>	
			</div>
			<div class="form-group mr-3">
				Semester:&nbsp;&nbsp;
				<select name="subject" id="singleSemester" class="form-control changer">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>	
			</div>
			<div class="form-group mr-3">
				Section:&nbsp;&nbsp;
				<select name="subject" id="singleSection" class="form-control changer">
					<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
				</select>	
			</div>
			<div class="form-group">
				Regno:&nbsp;&nbsp;
				<input type="text" name="singleRegno" class="form-control changer" id="singleRegno">
			</div>
		</form>
	</div>
	<hr>
	<div class="container">
		<div class="col-md-11 ml-5">
			<div class="hero-unit">
					<h1>Attendance Calendar </h1>
				</div>

				<div class="page-header">

					<div class="pull-right form-inline">
						<div class="btn-group">
							<button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
							<button class="btn" data-calendar-nav="today">Today</button>
							<button class="btn btn-primary" data-calendar-nav="next">Next >></button>
						</div>
					</div>

					<h3 id="monthName"></h3>
				</div>
			<div id="calendar"></div>
		</div>
	</div>
@endsection

@section('js')
	<script script="text/javascript">
		var tmpls_path = "{!! asset('tmpls') !!}/";
		var src_file = "{{ asset('temp.json') }}";
	</script>
	<script type="text/javascript" src="{{ asset('js/user-student.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/underscore.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/calendar.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/user-report.js') }}"></script>

@endsection