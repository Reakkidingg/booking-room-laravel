@extends('backend.layouts.master')
@section('title', 'Room Info')
@section('roomList', 'show')
@section('roomListActive', 'active')
@section('addNewRoomActive', 'active')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Room</h1>

    <!-- Message Error -->
    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <strong>Error:</strong> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Message Duplication Data -->
    @if(session()->has('duplicate'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Info:">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM7 3.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-6zM8 11a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </svg>
        <strong>Info:</strong> {{ session('duplicate') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <form action="{{url('room/save')}}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <!-- Overflow Hidden -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Fill room info</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="room_name" class="col-sm-2 col-form-label">Room Name <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="room_name" id="room_name" value="{{old('room_name', request()->input('room_name'))}}" autofocus>
                                @error('room_name')
                                <div class="text-sm text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="room_desc" class="col-sm-2 col-form-label">Room Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="room_desc" id="room_desc">{{old('room_desc', request()->input('room_desc'))}}</textarea>
                                @error('room_desc')
                                <div class="text-sm text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="room_status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-select form-control" id="room_status" name="room_status">
                                    <option value="1">Aailable</option>
                                    <option value="0">Unavilable</option>
                                </select>
                            </div>
                            <!-- @error('room_status')
                            <div class="text-sm text-danger">{{$message}}</div>
                            @enderror -->
                        </div>

                        <div class="form-group row">
                            <label for="room_type_id" class="col-sm-2 col-form-label">Room Type</label>
                            <div class="col-sm-9">
                                <select class="form-select form-control" id="room_type_id" name="room_type_id">
                                    <option value="">---Choose RoomType---</option>
                                    @foreach($room_types as $rt)
                                    <option value="{{$rt->room_type_id}}">{{$rt->room_type_name}}</option>
                                    @endforeach
                                </select>
                                @error('room_type_id')
                                <div class="text-sm text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Roitation Utilities -->
                <div class="card" style="min-height: 335px;height: auto;">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Attachment (Select file image below 2 MB)</h6>
                    </div>
                    <div class="card-body text-center">

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <div>
                                    <input class="form-control form-control-lg" name="room_photo" id="room_photo" type="file" accept="image/*" onchange="previewImg(event)">
                                </div>
                                <div>
                                    <img src="" alt="" id="img" name="img" width="250">
                                </div>
                                @error('room_photo')
                                <div class="text-sm text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-11"></div>
            <div class="col-sm-1">
                {{-- <button class="btn btn-success">Save</button> --}}

                <button class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Save</span>
                </button>

            </div>
        </div>
    </form>


</div>
<!-- /.container-fluid -->
@endsection

@section('myjs')
<script type="text/javascript">
    function previewImg(evt) {
        let img = document.getElementById("img");
        img.src = URL.createObjectURL(evt.target.files[0]);
    }
</script>
@endsection