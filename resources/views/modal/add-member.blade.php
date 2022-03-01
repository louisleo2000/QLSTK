<style>
    .modal-open .select2-container {
        z-index: 9999;
        width: 100% !important;
    }

</style>
<div class="modal" id="addMemberModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Thêm thành viên</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            {{-- form upload img --}}
            <form id="addMember">
                <label id="id"></label>
                <label id="action"></label>
                {{-- <form action="{{ route('add-member') }}" method="post" enctype="multipart/form-data"> --}}
                <!-- Modal body -->
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Họ và tên</label>
                        <div class="input-group input-group-alternative">
                            <input class="form-control" id="name" name="name" required
                                placeholder="Vd: Nguyễn Văn A (Ông Cả)" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dob">Ngày sinh</label>
                        <div class="input-group input-group-alternative">
                            <input class="form-control" placeholder="Ngày sinh" type="date" id="dob" name="dob"
                                required>
                        </div>
                    </div>
                    {{-- checkbox --}}
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="dead" name="dead" type="checkbox" value="1">
                            <label class="custom-control-label" for="dead">Đã mất</label>
                        </div>
                    </div>
                    <div class="form-group" id="doditem" style="display: none;">
                        <label for="dod">Ngày Mất</label>
                        <div class="input-group input-group-alternative">
                            <input class="form-control" placeholder="Ngày mất" type="date" id="dod" name="dod">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính</label>
                        <div>
                            <input type="radio" id="male" name="gender" value="male" checked required>
                            <label for="male">Nam</label>
                            <input style="margin-left: 20px" type="radio" id="female" name="gender" value="female"
                                required>
                            <label for="female">Nữ</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="img">Hình ảnh</label>
                        <div class="input-group input-group-alternative">
                            <input class="form-control" type="file" accept="image/png,image/jpg,image/jpeg" id="img"
                                name="img">
                        </div>
                    </div>

                    {{-- select father --}}
                    <div class="form-group">
                        <label for="father">Cha</label>
                        <div class="input-group input-group-alternative">
                            <select class="form-control js-select" id="father_id" name="father_id">
                                <option value=0>Không có</option>
                                {{-- check male not undifined --}}
                                @if (isset($male))
                                    @foreach ($male as $father)
                                        <option value="{{ $father->id }}">{{ $father->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>

                    {{-- select mother --}}
                    <div class="form-group">
                        <label for="mother">Mẹ</label>
                        <div class="input-group input-group-alternative">
                            <select class="form-control js-select" id="mother_id" name="mother_id">
                                <option value=0>Không có</option>
                                @if (isset($female))
                                    @foreach ($female as $mother)
                                        <option value="{{ $mother->id }}">{{ $mother->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    {{-- select couple --}}
                    <div class="form-group">
                        <label for="couple">Vợ/Chồng</label>
                        <div class="input-group input-group-alternative">
                            <select class="form-control js-select" id="couple_id" name="couple_id[]"
                                multiple="multiple">
                                <option value=0>Không có</option>
                                @if (isset($couples))
                                    @foreach ($couples as $couple)
                                        <option value="{{ $couple->id }}">{{ $couple->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
            </form>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button onclick="addOrUpdateMember()" class="btn btn-primary my-4">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-select').select2();
        $('#couple_id').val(["0"]).change();
    })
    
    $(document).ready(function() {
        $('#dead').change(function() {
            if ($(this).is(":checked")) {
                document.getElementById('doditem').style.display = "block";
                $('#dod').prop('required', true);
            } else {
                document.getElementById('doditem').style.display = "none";
                $('#dod').prop('required', false);
            }
        });
    });

    dob.max = new Date().toISOString().split("T")[0];
    dod.max = new Date().toISOString().split("T")[0];

    // dob must < dod
    dod.min = dob.value;
    dob.onchange = function() {
        dod.min = this.value;
    };

    //up load image by ajax 
    function addOrUpdateMember(action) {
        var formData = new FormData($('#addMember')[0]);

        if ($('#dead').is(":checked")) {
            formData.append('dod', $('#dod').val());
        } else {
            formData.delete('dod');
        }

        if (document.getElementById("img").files.length == 0) {
            formData.delete('img');
        }

        if ($('#father_id').val() == 0) {
            formData.delete('father_id');
        }
        if ($('#mother_id').val() == 0) {
            formData.delete('mother_id');
        }
        if ($('#couple_id').val() == ["0" || null]) {
            formData.delete('couple_id[]');
        }

        var check = true;
        for (var value of formData.values()) {
            if (value == "") {
                check = false;
            }
            console.log(formData)
        }
        if (check) {
            let url = ""
            let action = $('#action').val();
            console.log(action);
            switch (action) {
                case "add":
                    url = "{{ route('add-member') }}";
                    break;
                case "update":
                    url = "{{ route('members') }}-edit" + "/" + $('#id').val();
                    break;
                default:
                    break;
            }
            console.log($('#couple_id').val())



            //add member by ajax
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        $('#addMember')[0].reset();
                        $('#addMemberModal').modal('hide');
                        tableMembers.ajax.reload();
                        demo.showNotification('top', 'center', 2, 'Thao tác thành công!');
                    } else if (data.error) {
                        alert(data.error);
                        console.log(data.error);
                    } else {
                        console.log("ERROR:" + data);
                    }
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            alert(value);
                        });
                    }
                    console.log(data)

                }
            })
        } else {
            demo.showNotification('bottom', 'right', 3, 'Vui lòng nhập đầy đủ thông tin');
            // alert("Vui lòng nhập đầy đủ thông tin");
        }
    }
</script>
