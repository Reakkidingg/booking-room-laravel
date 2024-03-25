@extends('backend.layouts.master')
@section('title', 'Room Info')
@section('roomList', 'show')
@section('roomList', 'hover')
@section('roomListActive', 'active')
@section('addNewRoomActive', 'active')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Room Info</h1>
    <!-- Message Success -->
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Success:">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM6.354 11.646a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L6 10.293l5.646-5.647a.5.5 0 1 1 .708.708l-6 6z" />
        </svg>
        <strong>Success:</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Room Lists</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr style="background: #4e73dffa; color: #ffffff;">
                            <th>No.</th>
                            <th>Room Image</th>
                            <th>Room Name</th>
                            <th>Room Status</th>
                            <th>Room Description</th>
                            <th>Room Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $page = @$_GET['page'];
                        if (!$page) {
                            $page = 1;
                        }
                        $i = config('app.row') * ($page - 1) + 1;

                        ?>

                        @foreach ($rooms as $item)
                        <tr>
                            <td>{{$i++}}</td>
                            <td><img src="{{asset($item->room_photo)}}" alt="" width="70"></td>
                            <td>{{$item->room_name}}</td>
                            <td>{{($item->room_status) == 1 ? 'Available' : 'Unavailable'}}</td>
                            <td>{{$item->room_desc}}</td>
                            <td>{{$item->room_type_name}}</td>
                            <td>
                                <!-- <a href="" class="btn btn-primary"><i class="fas fa-edit"></i></a>&nbsp; -->
                                <!-- <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1"><i class="fas fa-edit"></i></a> -->
                                <a href="{{url('room/edit/'.$item->room_id)}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                <a href="" class="btn btn-info"><i class="fas fa-eye"></i></a>&nbsp;
                                <!-- <a href="{{route('room.delete', $item->room_id)}}" class="btn btn-danger"></a> -->

                                <!-- Delete Modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                {{$rooms->links('vendor\pagination\bootstrap-5')}}
            </div>
        </div>
    </div>
</div>


<!-- Modal Delete-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deletion Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-danger">
                Are you sure for delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{route('room.delete', $item->room_id)}}" class="btn btn-primary">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Updation Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include link edit here -->
                <
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>


<!-- /.container-fluid -->
@endsection