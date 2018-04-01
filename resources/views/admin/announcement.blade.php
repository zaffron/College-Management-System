@extends('layouts.admin')

@section('content')
    <div class="container">
       <div class="row">
            <div class="card col-md-12 text-danger o-hidden h-10">
                <div class="card-body">
                    <div class="text-center text-danger"><h3>Send Alert!</h3></div>
                    <hr style="border:3px solid #db3444;">
                    <div class="col-md-12">
                        <label class="h4">Message</label>
                        <textarea class="form-control"></textarea><br>
                        <button class="btn btn-outline-danger btn-lg">Announce</button>                      
                    </div>   
                </div>
            </div>
           <div class="card col-md-12 text-danger o-hidden h-10">
                <div class="card-body">
                   <div class="text-center text-danger"><h3>Announce Semester End</h3></div>
                   <hr style="border:3px solid #db3444;">
                   <p class="text-danger text-center"><strong>*Once the semester end is announced it can't be reverted back</strong></p>
                   <div class="col-md-12 text-center">
                       <form class="form-inline">
                           <div class="form-group col-md-10">
                               <label class="form-control-label col-md-5">Choose to end semester | Course:</label>
                               <select id="annouce_course" class="form-control col-md-6">
                                   @forelse($courses as $course)
                                        <option value="{{ $course->id}}">{{ $course->name }}</option>
                                    @empty
                                        <option disabled="disabled">Nothing</option>
                                    @endforelse
                               </select>
                           </div>
                           <div class="form-group">
                               <button class="btn btn-danger">End semester</button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>
    </div>
@endsection