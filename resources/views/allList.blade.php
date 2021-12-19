@extends('layouts.layout')
@section('content')
    <div class="col-md-12 text-center ">
        <a class="btn btn-outline-dark disabled"  href="{{ url('/AllList') }}">All Bucket List</a>
        <a class="btn btn-dark"  href="{{ url('/MyList') }}">My Bucket List</a>
    </div>
  

    <div class="card mt-3"  style="width: 100%; margin-bottom: 20px;"> 
        <div class="container-fluid" style="margin-top: 10px;margin-bottom: 20px;">
            <div class="row" >
                <div class="col-md-2">
                    <p class="card-text font-weight-bold">Posted By</p>
                </div>
                <div class="col-md-6">
                    <p class="card-text font-weight-bold">Bucket List Item</p>
                </div>

                <div class="col-md-3">
                    <p class="card-text font-weight-bold">Posted At</p>
                </div>
            </div>
        </div> 
    </div>
    @foreach($responseAll as $res)
        @if(!empty($res->bucketItems))
            @foreach($res->bucketItems as $res2)
                @if(!empty($res2->items))
                    <div class="card mt-3"  style="width: 100%; margin-bottom: 20px;"> 
                        <div class="container-fluid" style="margin-top: 10px;margin-bottom: 20px;">
                            <div class="row" >
                                <div class="col-md-2">
                                    <p class="card-text">
                                        @if($res->email  == 'anonymous')
                                            {{$res->email}} #{{$res->id}}
                                        @else
                                            {{$res->email}}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">

                                    <p class="card-text">{{ $res2->items }}</p>

                                </div>

                                <div class="col-md-3">
                                    <?php
                                        $datetime=$res->published_at;
                                        $timezone ='Asia/Singapore';
                                        $date = new DateTime( $datetime, new DateTimeZone( 'UTC' ) );
                                        $date->setTimezone( new DateTimeZone( $timezone ) );
                                        $date=$date->format('d/m/Y h:m:s a');
                                        ?>
                                    <p class="card-text">{{ $date }}</p>
                                </div>

                            </div>
                        </div> 
                    </div>
                @endif
            @endforeach
        @endif
    @endforeach <br>
@endsection
