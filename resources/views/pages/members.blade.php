@extends('layouts.dashboard.layout')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-0">Thành viên</h3>
                        </div>
                        <div id="btnAdd" class="col-2">
                            <button class="btn btn-primary mb-0" type="button" data-toggle="modal"
                                data-target="#addMemberModal">
                                Thêm <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush " style="width: 100%;" id="members-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col"></th>
                                        <th scope="col">Họ và Tên</th>
                                        <th scope="col">Ngày sinh</th>
                                        <th scope="col">Ngày mất</th>
                                        <th scope="col">Giới tính</th>
                                        <th scope="col"></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modal.add-member')
@endsection
