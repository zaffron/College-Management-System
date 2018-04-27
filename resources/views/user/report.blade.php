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
				Subject:&nbsp;&nbsp;
				<select name="subject" id="totalSubject" class="form-control">
					@foreach(auth()->user()->subjects as $subject)
						<option value="{{ $subject->id }}">{{ $subject->name }}</option>
					@endforeach
				</select>	
			</div>
			<div class="form-group">
				Section:&nbsp;&nbsp;
				<select name="subject" id="subject" class="form-control">
					<option value="A">A</option>
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="D">D</option>
				</select>	
			</div>
		</form>
	</div>
	<hr>
	<div class="container">
		<table class="table table-bordered">
			<tr>
				<th>Regno</th>
				<th>Name</th>
				<th>Semester</th>
				<th>Section</th>
				<th>Attendance</th>
				<th>%</th>
			</tr>

		</table>
	</div>
@endsection

@section('js')
	<script type="text/javascript" src="{{ asset('js/user-search-student.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/user-report.js') }}"></script>
@endsection