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
                        <div class="col-2">
                            <button id="btnAdd" class="btn btn-primary mb-0" type="button" data-toggle="modal"
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
    <script>
        //btnAdd click set value for action to add
        $('#btnAdd').click(function() {
            $('#action').val('add');
            
            //set tile for modal
            $('#modalTitle').text('Thêm thành viên');
            $('#addMember')[0].reset();
            $('#couple_id').val(["0"]).change();

        });


        dob.max = new Date().toISOString().split("T")[0];
        dod.max = new Date().toISOString().split("T")[0];

        // dob must < dod
        dod.min = dob.value;
        dob.onchange = function() {
            dod.min = this.value;
        };

        //delete member
        function deleteMember(id) {
            if (id != null) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('members') }}-del/" + id,
                    type: 'DELETE',
                    success: function(result) {
                        console.log(result);
                        //reload table
                        $('#members-table').DataTable().ajax.reload();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        }

        //get member by ajax with id
        function getMember(id) {
            $('#action').val('update');
            $('#modalTitle').text('Cập nhật thành viên');
            $('#addMember')[0].reset();
            $('#couple_id').val(["0"]).change();
            $.ajax({
                url: "{{ route('members') }}/" + id,
                type: 'GET',
                success: function(result) {
                    $('#id').val(result.id);
                    $('#name').val(result.name);
                    $('#dob').val(result.dob).change();


                    //check dead  if have dod
                    if (result.dod != null) {
                        $('#dod').val(result.dod);
                        $('#dead').prop('checked', true);
                        //show dod
                        document.getElementById('doditem').style.display = "block";
                    } else {
                        $('#dod').val('');
                        $('#dead').prop('checked', false);
                    }
                    $('#male').prop('checked', true);
                    if (result.gender == 'female') {
                        $('#female').prop('checked', true);
                    }


                    //check father if have father
                    if (result.father != null) {
                        $('#father_id').val(result.father_id).change();;
                    } else {
                        $('#father').val(0);
                    }
                    //check mother if have mother
                    if (result.mother != null) {
                        $('#mother_id').val(result.mother_id).change();;
                    } else {
                        $('#mother').val(0);
                    }

                    //check if have couple_id and split to array and set to select
                    if (result.couple_id != null) {
                        var couple_id = result.couple_id.split(',');
                        $('#couple_id').val(couple_id).change();
                    } else {
                        $('#couple_id').val(["0"]).change();
                    }

                    $('#addMemberModal').modal('show');

                },
                error: function(err) {
                    console.log(err);
                }
            });

        }
    </script>
@endsection
