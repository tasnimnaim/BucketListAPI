@extends('layouts.layout')
@section('content')

    <div class="col-md-12 text-center ">
        <a class="btn btn-dark "  href="{{ url('/AllList') }}">All Bucket List</a>
        <a class="btn btn-outline-dark disabled"  href="{{ url('/MyList') }}">My Bucket List</a>
    </div>
    @if(session('status'))
    <br>
        <div class="alert alert-success" role="alert">
            <i class="fa fa-check-circle-o fa-lg" aria-hidden="true"></i> {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <?php $index1 =0;$index2 =0; ?>
    <div class="col-md-12 text-right">

        @if(!empty($responseMine))
            <form  name = "formUpdate" method="post" action="{{ route('myList.delete')}}">
                @csrf
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditModal{{ $index1 }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Add / Edit My List
                </button>
                <button type="submit" class="btn btn-danger"  >
                    <i class="fa-solid fa-trash-can"></i>
                    Delete All
                </button>          
            </form>  
        @else
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddNewModal">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Add New List 
            </button>
        @endif
    </div>
    <div class="card mt-3"  style="width: 100%; margin-bottom: 20px;"> 
        <div class="container-fluid" style="margin-top: 10px;margin-bottom: 20px;">
            <div class="row" >
            <div class="col-md-2">
                    <p class="card-text font-weight-bold">
                        Posted By
                    </p>
                </div>
                <div class="col-md-5">
                    <p class="card-text font-weight-bold">Bucket List Item</p>
                </div>

                <div class="col-md-2">
                    <p class="card-text font-weight-bold">Posted At</p>
                </div>
                <div class="col-md-3">
                    <p class="card-text font-weight-bold">Action</p>
                </div>
            </div>
        </div> 
    </div>
   
    @if(empty($responseMine))
        <div class="alert alert-primary text-center" role="alert">
            <i> No Bucket List Item Found!<br> </i>
        </div>
    @else
    @foreach($responseMine as $res)
        @if(!empty($res->bucketItems))
            @foreach($res->bucketItems as $res2)
                @if(!empty($res2->items))
                    <div class="card mt-3"  style="width: 100%; margin-bottom: 20px;"> 
                        <div class="container-fluid" style="margin-top: 10px;margin-bottom: 20px;">
                            <div class="row" >
                                <div class="col-md-2">
                                    <p class="card-text">
                                        {{$res->email}}
                                    </p>
                                </div>
                                <div class="col-md-5">
                                    <p class="card-text">{{ $res2->items }}</p> 
                                </div>
                                <div class="col-md-2">
                                    <?php
                                        $datetime=$res->published_at;
                                       $timezone ='Asia/Singapore';
                                       $date = new DateTime( $datetime, new DateTimeZone( 'UTC' ) );
                                       $date->setTimezone( new DateTimeZone( $timezone ) );
                                       $date=$date->format('d/m/Y h:m:s a');
                                    ?>

                                    <p class="card-text">{{ $date }}</p>
                                </div>
                                <div class="col-md-3">
                                    <form  name = "deleteItem" method="post" action="/MyList/DeletedItem/{{ $res2->id }}">
                                        @csrf
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditItemModal{{ $index2 }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Edit
                                        </button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa-solid fa-circle-minus"></i>
                                            Delete
                                        </button>         
                                    </form>                     
                                </div>         
                                    <div class="modal fade" id="EditItemModal{{ $index2 }}" tabindex="-1" role="dialog" aria-labelledby="EditItemModal{{ $index2 }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="EditItemModal{{ $index2 }}">Edit My Bucket Item</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form  name = "formEditItem" method="post" action="/MyList/Edited/{{ $res2->id }}">
                                                    @csrf
                                                    <div class="modal-body"> 
                                                        <div class="form-group">
                                                            <label for="InputBucket1">Edit Existing Bucket List Item</label>
                                                            <input type="text" class="form-control" id="InputBucket1" name = 'inputBucket' value="{{ $res2->items }}" autocomplete="off" required><br>
                                                        </div>
                                                    </div>        
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>                                                   
                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>                                                                  
                            </div>
                        </div> 
                    </div>
                    <?php $index2++ ?>
                @endif 
            @endforeach
        @endif
    @endforeach <br>
        @foreach($responseMine as $res)
            @if(!empty($res->bucketItems))
                @foreach($res->bucketItems as $res2)
                    @if(!empty($res2->items))
                        <div class="modal fade" id="EditModal{{ $index1 }}" tabindex="-1" role="dialog" aria-labelledby="EditModal{{ $index1 }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="EditModal{{ $index1 }}">Edit My Bucket List</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form  name = "formUpdate" method="post" action="{{ route('myList.update',$res2->id) }}">
                                    @csrf
                                    <div class="modal-body"> 
                                        <div class="form-group">
                                            <label for="InputEmail1">My Email</label>
                                            <input type="email" class="form-control" id="InputEmail1" name = 'myEmail'  value="{{ $myEmail }}" placeholder = 'test' disabled>
                                            </div>
                                        <div class="form-group">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <label for="InputBucket1">Edit Existing Bucket List Item</label>
                                        @foreach($res->bucketItems as $res2)
                                            <input type="text" class="form-control" id="InputBucket1" name = 'inputBucket[]' value="{{ $res2->items }}" autocomplete="off" required><br>
                                        @endforeach
                                            
                                        <div class="form-group" id="bucketList1">
                                            <i class="fa-solid fa-circle-plus"></i>
                                            <label for="InputBucket1">Add New Bucket List Item</label>
                                        </div>
                                        <div class="col text-right">
                                            <a onclick="updateBucketList()" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Add New Item</a>
                                        </div>
                                    </div>        
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>                                                   
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        <?php $index1++ ?>
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif

    <div class="modal fade" id="AddNewModal" tabindex="-1" role="dialog" aria-labelledby="AddNewModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddNewModal">Add to The Bucket List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  name = "formAdd" method="post" action="{{ route('myList.add') }}">
                @csrf
                <div class="modal-body mb-4">  
                    <div class="form-group">
                        <label for="InputEmail2">My Email</label>
                        <input type="email" class="form-control" id="InputEmail2" name = 'myEmail' value = '{{ $myEmail }}' disabled>
                    </div>

                    <label for="InputBucket2">Bucket List Item</label>
                    <div class="form-group row"  >
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="InputBucket2" name = 'inputBucket[]' placeholder="Your New Bucket Item" autocomplete="off" required><br>
                        </div>
                        <div class="form-group" id="bucketList2">
                        </div>
                        <div class="col">
                            <a onclick="addBucketList()" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Add</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button input type="submit" class="btn btn-primary" value="Submit" >Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function addBucketList()
    {
        $('#bucketList2').after("<div class='col-md-8'><input type='text' class='form-control' id='InputBucket2' name = 'inputBucket[]' placeholder='Your New Bucket Item' autocomplete='off' required><br></div>");
    }
    function updateBucketList()
    {
        $('#bucketList1').after("<div class='form-group'><input type='text' class='form-control' id='InputBucket1' name = 'inputBucket[]' placeholder='Your New Bucket Item' autocomplete='off' required></div>");

    }
</script>
@endsection