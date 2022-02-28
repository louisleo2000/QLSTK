<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Đăng ký</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet"
        href="{{ asset('/step/fonts/material-design-iconic-font/css/material-design-iconic-font.css') }}">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('/step/css/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <form action="">
            <div id="wizard" >
                <!-- SECTION 1 -->
                <h4></h4>
                <section>
                    <div class="form-header">
                        <div style="width: 100%; margin-bottom: 10px">
                            <h1 style="text-align: center;">ĐĂNG KÝ</h1>
                        </div>
                    </div>
                    <form method="POST" action="http://127.0.0.1:8000/register">
                        @csrf
                        <div class="form-holder active">
                            <input type="text" placeholder="Tên gia phả" class="form-control" name="name"
                                :value="old('name')" required autofocus>
                        </div>

                    </form>

                </section>

                <!-- SECTION 2 -->
                <h4></h4>
                <section>
                    <div style="width: 100%; margin-bottom: 10px">
                        <h1 style="text-align: center;">THÊM TỔ TIÊN</h1>
                    </div>

                    <div class="form-row" style="width: 100%;">
                        <div class="form-col">
                            <h3>Ông tổ</h3>
                            <div class="form-holder" style="width: 100%;">
                                <input class="form-control" id="name" name="name" required autofocus
                                    placeholder="Họ và tên" type="text">
                            </div>
                            <div class="form-holder" style="width: 100%;">
                                <input class="form-control" placeholder="Ngày sinh" type="date" id="dob" name="dob"
                                    required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="dead" name="dead" type="checkbox" value="1">
                                    <label class="custom-control-label" for="dead">Đã mất</label>
                                </div>
                            </div>
                            <div class="form-holder" style="width: 100%;">
                                <input class="form-control" placeholder="Ngày mất" type="date" id="dod" name="dod">
                            </div>
                            <div class="form-group" style="margin-bottom: 10px">
                                <label for="img">Hình ảnh</label>
                                <div class="input-group input-group-alternative">
                                    <input type="file" accept="image/png,image/jpg,image/jpeg" id="img" name="img">
                                </div>
                            </div>
                        </div>
                        <div class="form-col" style="margin-left: 40px">
                            <h3>Bà tổ</h3>
                            <div class="form-holder" style="width: 100%;">
                                <input class="form-control" id="name1" name="name1" required autofocus
                                    placeholder="Họ và tên" type="text">
                            </div>
                            <div class="form-holder" style="width: 100%;">
                                <input class="form-control" placeholder="Ngày sinh" type="date" id="dob1" name="dob1"
                                    required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="dead1" name="dead1" type="checkbox" value="1">
                                    <label class="custom-control-label" for="dead1">Đã mất</label>
                                </div>
                            </div>
                            <div class="form-holder" style="width: 100%;">
                                <input class="form-control" placeholder="Ngày mất" type="date" id="dod1" name="dod1">
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 10px">
                                <label for="img1">Hình ảnh</label>
                                <div class="input-group input-group-alternative">
                                    <input type="file" accept="image/png,image/jpg,image/jpeg" id="img1" name="img1">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION 3 -->
                <h4></h4>
                <section>


                </section>
            </div>
        </form>
    </div>


    <script src="{{ asset('/step/js/jquery-3.3.1.min.js') }}"></script>

    <!-- JQUERY STEP -->
    <script src="{{ asset('/step/js/jquery.steps.js') }}"></script>

    <script src="{{ asset('/step/js/main.js') }}"></script>
    <!-- Template created and distributed by Colorlib -->
</body>

</html>
