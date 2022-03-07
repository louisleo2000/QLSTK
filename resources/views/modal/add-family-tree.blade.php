<div class="modal" id="addFamilyTree">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tạo cây gia phả</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="addTree" url="{{ route('add-tree') }}">
                <!-- Modal body -->
                @csrf
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label for="name">Tên Gia Phả</label>
                        <div class="input-group input-group-alternative">
                            <input class="form-control" id="name" name="name" value="{{ old('email') }}" required
                                autofocus placeholder="Họ và tên" type="text">
                        </div>
                    </div>

                </div>
            </form>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button onclick="addTree()" class="btn btn-primary my-4">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>
<script>
    function addTree() {
        var form = $("#addTree");
        console.log(form)
        var actionUrl = form.attr('url');
        console.log(actionUrl)
        $.ajax({
                url: actionUrl,
                type: "POST",
                dataType: "text",
                data: form.serialize(),
            })
            .done(function(response) {
                console.log(response)
                $("#addTree")[0].reset();
                $('#addFamilyTree').modal('hide');
                if (response) {
                    document.getElementById('btnAdd').style.display = "none"
                    alert('Tạo gia phả thành công!');
                    location.reload();
                }
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Máy chủ không phản hồi...');
            });
    }
</script>
