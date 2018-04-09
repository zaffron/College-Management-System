@extends('layouts.admin')

@section('styles')
  <!-- toastr notifications -->
  <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
@endsection

@section('content')
    <div class="container">
       <div class="row">
            <div class="card col-md-12 text-danger o-hidden h-10">
                <div class="card-body">
                    <div class="text-center text-danger"><h3>Send Alert!</h3></div>
                    <hr style="border:3px solid #db3444;">
                    <div class="col-md-12">
                      <form>
                        <input type="number" name="id" id="user_id" value="{{ Auth::user()->id }}" hidden="hidden">
                        <label class="h4">Message</label>
                        <textarea class="form-control" id="message"></textarea><br>
                      </form>
                      <button class="btn btn-outline-danger btn-lg announce">Announce</button>                  
                    </div>   
                </div>
            </div>
           <div class="card col-md-12 text-danger o-hidden h-10">
                <div class="card-body">
                   <div class="text-center text-danger"><h3>Announce Semester End</h3></div>
                   <hr style="border:3px solid #db3444;">
                   <p class="text-danger text-center"><strong>*Once the semester end is announced it can't be reverted back</strong></p>
                   <div class="col-md-12 text-center">
                       <div class="form-inline" >
                           <div class="form-group col-md-8">
                               <label class="form-control-label col-md-6">Choose to end semester | Course:</label>
                               <select id="sem_end_course" class="form-control col-md-6">
                                   @forelse($courses as $course)
                                        <option value="{{ $course->id}}">{{ $course->name }}</option>
                                    @empty
                                        <option disabled="disabled">Nothing</option>
                                    @endforelse
                               </select>
                           </div>
                           <div class="form-group">
                               <button class="btn btn-danger announce_semester_end">End semester</button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>
@endsection

@section('js')
  {{--For toaster notification--}}
  <script type="text/javascript" src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/announcement.js') }}"></script>

@endsection