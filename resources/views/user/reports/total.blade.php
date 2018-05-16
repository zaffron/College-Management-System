@extends('layouts.layout')

@section('content')
	<div class="container">
		<h4 class="text-center">Total Attendance</h4>
		<hr>
		<form action="#" class="form-inline">
			<div class="form-group mr-3 text-info">
				&nbsp;&nbsp;Course: {{ auth()->user()->courses->name }}
			</div>
			<div class="form-group mr-3">
				Batch:&nbsp;&nbsp;
				<select name="subject" id="totalBatch" class="form-control totalController">
					@for($i=0;$i<4;$i++){
						<option value="{{ $year-$i }}">{{ $year-$i }}</option>
					@endfor
				</select>	
			</div>
			<div class="form-group mr-3">
				Subject:&nbsp;&nbsp;
				<select name="subject" id="totalSubject" class="form-control totalController ">
					@foreach(auth()->user()->subjects as $subject)
						<option value="{{ $subject->id }}">{{ $subject->name }}</option>
					@endforeach
				</select>	
			</div>
			<div class="form-group mr-3">
				Semester:&nbsp;&nbsp;
				<select name="subject" id="totalSemester" class="form-control totalController">
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
			<div class="form-group">
				Section:&nbsp;&nbsp;
				<select name="subject" id="totalSection" class="form-control totalController">
					<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
				</select>	
			</div>
		</form>
	</div>
	<hr>
	<div class="container" id="attendanceTableHolder">
		{{--<button class="btn btn-md btn-primary pull-right mb-2">Download <span class="fa fa-arrow-down"></span></button>--}}
		<table class="table table-bordered" id="attendanceTable">
			<tr>
				<th>Regno</th>
				<th>Name</th>
				<th>Attendance</th>
				<th>%</th>
				<th>Operation</th>
			</tr>
		</table>
	</div>
@endsection

@section('js')
	<script type="text/javascript" src="{{ asset('js/user-search-student.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/user-report.js') }}"></script>
@endsection