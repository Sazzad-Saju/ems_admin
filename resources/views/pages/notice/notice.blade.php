@extends('layouts.app')
@section('content')
<div class="container text-center pt-5">
    <div class="row">
      <div class="col-md-12 mb-5">
        <div class="title">Add a Notice</div>
      </div>
    </div>
    <!-- Start Form -->
    <form method="POST" action="{{route('notices.store')}}">
        @csrf
    <div class="row mb-5">

        <div class="col-xl-12 col-lg-12 mt-3">
          <div class="textareafield mb-3">
            <textarea id="editor" placeholder="Message" rows="5" name="message"> </textarea>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <button type="submit" class="btn btn-sm defaultBtn">Submit</button>
        </div>
    </div>
    </form>
    <!-- End Form -->
  </div>
@endsection
