@extends('layouts.dashboard.layout')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-10">
                            <h3 class="mb-0">Cây gia phả </h3>

                        </div>
                        @if (count(Auth::user()->familyTree) < 1)
                            <div id="btnAdd" class="col-2">
                                <button class="btn btn-primary mb-0" type="button" data-toggle="modal"
                                    data-target="#addFamilyTree">
                                    Thêm <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
                <div class="card-body ">
                    <livewire:family-tree />
                    
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            demo.showNotification('top','center',1,'Chào mừng bạn đã đến với trang quản lý gia phả');
        });
      </script>
    @include('modal.add-family-tree')
@endsection
