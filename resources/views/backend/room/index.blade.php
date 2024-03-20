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
                        if(!$page) {
                            $page = 1;
                        }
                        $i = config('app.row') * ($page -1) + 1;

                        ?>

                    @foreach ($rooms as $item)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$item->room_name}}</td>
                        <td>{{($item->room_status) == 1 ? 'Available' : 'Unavailable'}}</td>
                        <td>{{$item->room_desc}}</td>
                        <td>{{$item->room_type_name}}</td>
                        <td>
                            <button type="button" class="btn btn-primary"><i class="fas fa-edit"></i></button>&nbsp;
                            <button type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>&nbsp;
                            <button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
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
<!-- /.container-fluid -->
@endsection