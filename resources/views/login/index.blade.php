<!DOCTYPE html>
<html lang="id" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Fav Icon  -->
    <link rel="icon" type="image/x-icon" href="{{ asset('public/image/favicon.ico') }}">

    <!-- Page Title  -->
    <title>Helpdesk | Sign in</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('public/assets/css/dashlite.css?ver=2.9.0')}}">
    <!-- <link id="skin-default" rel="stylesheet" href="{{asset('public/assets/css/theme.css?ver=2.9.0')}}"> -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-weight: 300;
        }

        body {}

        .card {
            background-color: rgba(255, 255, 255, 1)
        }

        .card.Lo {
            height: 0%;
            z-index: 2;
        }

        .wrapper {
            /* background: #ffffff;
            background: linear-gradient(top left, #31baff 0%, #d6ffd6 100%);
            background: linear-gradient(to bottom right, #d6ffd6 0%, #31baff 100%); */
            background-image: url("{{ asset('public/image/bg-login.jpg') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .container1 {
            /* max-width: 30%; */
            /* margin-left: auto;
            margin-right: auto;
            margin-top: 6vh;
            margin-bottom: auto; */
            height: 80%;
            text-align: center;
            z-index: 1;
        }

        form {
            position: relative;
            z-index: 2;
        }

        .partner>img {
            max-width: 20%;
            margin-right: 5px;
        }

        .logos {
            background-color: white;
            border-radius: 50px;
            padding-right: 2%;
            padding-left: 2%;
            margin-left: 2%;
            margin-right: 2%;
        }

        .logos>img {
            max-width: 95%;
            margin: 3px;
        }
        @media only screen and (min-width: 1200px) {
            #banner {
                margin-top: 8vh !important;
            }
        }
        @media only screen and (min-width: 2200px) {
            .container1>div  {
                max-width: 20% !important;
            }
            /* .logo-link>img {
                max-width: 50% !important;
            } */
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="row g-0">
            <div class="col-md-4 mt-2">
                <div class="logos d-flex justify-content-center">
                    <img src="{{asset('public/image/logos.png')}}" alt="">
                </div>
            </div>
            {{-- <div class="text-center col-md-4 mt-2" id="banner">

            </div> --}}
        </div>
        <div class="container1 d-flex align-items-center justify-content-center align-self-center mt-3">
            <div class="col-md-4">
                <a class="logo-link " style="z-index: 2;">
                    <img style="width: 70%;" src="{{ asset('public/image/Helpdesk_logo_login_2.png') }}" alt="description of myimage">
                </a>
                <div class="col-md-12" >
                    <div class="card Lo">
                        <div class="card-body">
                            <div class="card-title">
                                <h4>Sign In</h4>
                            </div>
                            <form action="javascript:;" name="formLogin" id="formLogin" style="display:none" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="default-01">Username</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control form-control" name="username" id="username" placeholder="Enter your username or nik">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="password">Password</label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                            <em class="passcode-icon icon-show "><i class='bx bx-show bx-xs'></i></em>
                                            <em class="passcode-icon icon-hide "><i class='bx bxs-hide bx-xs'></i></em>
                                        </a>
                                        <input type="password" class="form-control form-control" name="password" id="password" placeholder="Enter your password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <!-- <button class="btn btn-lg btn-primary btn-block">Sign in</button> -->
                                    <button id="btnLogin" name="btnLogin" type="submit" class="btn btn-primary waves-effect waves-light col-sm-8 offset-sm-2 mb-1"><i class='bx bx-log-in-circle'></i> Login </button>
                                    <button id="btnModalPencarianTiket" name="btnModalPencarianTiket" type="button" class="col-sm-8 offset-sm-2 mb-1 btn btn-outline-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalPencarianTiket"> <i class='bx bx-search'></i> Cari Tiket Isu
                                    </button>
                                    <!-- <button id="btnModalScanQRCodeTiketIssuesKamera" name="btnModalScanQRCodeTiketIssuesKamera" type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalScanQRCodeTiketIssuesKamera">ScanQRCode</button> -->
                                </div>
                            </form>
                            <p class="mt-1" style="font-size: 12px;">Partner App:</p>
                            <div class="d-flex justify-content-center partner">
                                <img src="{{asset('public/image/simasti_logo.png')}}" alt="">
                                <img src="{{asset('public/image/logo_dof.jpeg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPencarianTiket">
        <div class="modal-dialog modal-dialog-top modal-md" style="min-width: 70%" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pencarian Tiket Isu</h5>
                    <!-- <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a> -->
                </div>
                <div class="modal-body">
                    <div class="form-group">


                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-4">
                                    <button style="width: 100%" id="btnModalScanQRCodeTiketIssuesKamera" name="btnModalScanQRCodeTiketIssuesKamera" type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalScanQRCodeTiketIssuesKamera">Pencarian dengan QR Code (Kamera)</button>
                                </div>
                                <div class="col-xl-5">
                                    <button style="width: 100%" id="btnModalScanQRCodeTiketIssuesImage" name="btnModalScanQRCodeTiketIssuesImage" type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalScanQRCodeTiketIssuesImage">Pencarian dengan QR Code (Image File)</button>
                                </div>
                                <div class="col-xl-3">
                                    <button style="width: 100%" id="btnModalPencarianTiketIsuText" name="btnModalPencarianTiketIsuText" type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalPencarianTiketIsuText">Pencarian dengan Text</button>
                                </div>
                            </div>
                        </div>                        

                        <!-- <input type="file" id="qr-input-file" accept="image/*" capture> -->

                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalScanQRCodeTiketIssuesKamera">
        <div class="modal-dialog modal-dialog-top modal-md" style="min-width: 35%" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Scan QR Code</h5>
                    <!-- <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a> -->
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <video id="camera" style="width: 100%"></video>
                        <div id="qrcode"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <button type="button" id="kembali" namme="kembali" class="btn btn-md btn-primary">
                        Kembali</button>
                    <button type="button" id="kamera_depan" namme="kamera_depan" class="btn btn-md btn-primary">Kamera
                        Depan</button>
                    <button type="button" id="kamera_belakang" namme="kamera_belakang" class="btn btn-md btn-primary">Kamera Belakang</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalScanQRCodeTiketIssuesImage">
        <div class="modal-dialog modal-dialog-top modal-md" style="min-width: 35%" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Masukan Gambar QR Code</h5>
                    <!-- <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a> -->
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <!-- <div id="qr-reader" style="width: 600px"></div> -->

                        <input type="file" id="qr-input-file" accept="image/*">

                        <div id="reader"></div>

                        <p style="text-align: center;" id="hasil_scan_qr_code_image"></p>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <button type="button" id="kembali_qr_code_image" namme="kembali_qr_code_image" class="btn btn-md btn-primary">
                        Kembali</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPencarianTiketIsuText">
        <div class="modal-dialog modal-dialog-top modal-md" style="min-width: 35%" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Masukan Tiket Isu</h5>
                    <!-- <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a> -->
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control" name="tiket_issues_duplikat_text_cari" id="tiket_issues_duplikat_text_cari">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <button type="button" id="button_cari" name="button_cari" class="btn btn-md btn-primary">Cari
                        Tiket</button>
                    <button type="button" id="kembali_pencarian_isu_text" namme="kembali_pencarian_isu_text" class="btn btn-md btn-primary">
                        Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalIssuesDetail" data-bs-focus="false" style="font-size: 16pt">

        <div class="modal-dialog modal-dialog-top modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title modal_judul_issues_detail">Detail Issues</h5>
                    </div>
                    &nbsp;
                    <div class="modal-title modal_judul_issues_detail_status"></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">

                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <!-- <div class="card"> -->
                                    <!-- <div class="card-body"> -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mt-4 mt-xl-0">
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Username SAP
                                                        :</label>
                                                    <input type="text" readonly name="username_sap_issues_detail" id="username_sap_issues_detail" class="form-control" placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Telp
                                                        (Extension) :</label>
                                                    <input type="text" readonly name="telp_issues_detail" id="telp_issues_detail" class="form-control" placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Kategori :</label>
                                                    <input type="text" readonly name="kategori_nama_detail" id="kategori_nama_detail" class="form-control" placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Pilih Layanan :</label>
                                                    <input type="text" readonly name="layanan_nama_detail" id="layanan_nama_detail" class="form-control" placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Subject : <span id="jumlah_data_simasti">coba</span> </label>
                                                    <input type="text" readonly name="subject_nama_detail" id="subject_nama_detail" class="form-control" placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Priority :</label>
                                                    <input type="text" readonly name="priority_nama_detail" id="priority_nama_detail" class="form-control" placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Due Date
                                                        Probability :</label>
                                                    <input type="text" readonly name="perkiraan_selesai_y_m_d_detail" id="perkiraan_selesai_y_m_d_detail" class="form-control" placeholder="perkiraan selesai" readonly>
                                                </div>
                                                <!-- <div class="mt-4">
                                                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                                                        </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                    <!-- </div> -->
                                </div>
                                <div class="col-xl-8">
                                    <!-- <div class="card"> -->
                                    <!-- <div class="card-body"> -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mt-4 mt-xl-0">
                                                <!-- <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Form groups
                                                    </h5> -->

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Description :</label>
                                                    <!-- <div class="card"> -->
                                                    <!-- <div class="card-header">
                                                                    <h4 class="card-title mb-0">Snow Editor</h4>
                                                                </div> -->
                                                    <!-- <div class="card-body"> -->

                                                    <div name="description_issues_detail" id="description_issues_detail" class="description_issues_detail" style="height: 412px; max-height: 412px;">

                                                    </div>
                                                    <!-- <div id="editor">This is some sample content.</div> -->
                                                    <!-- end Snow-editor-->
                                                    <!-- </div>  -->
                                                    <!-- end card-body-->
                                                    <!-- </div>  -->
                                                    <!-- end card-->
                                                </div>
                                                <div class="mb-3" style="display:none">
                                                    <label class="form-label" for="formrow-firstname-input">Attachment
                                                        File :</label>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mt-4 mt-xl-0 append_div_file_detail" style="height: 132px; overflow-y: auto;">
                                                                <!-- <input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" placeholder="Enter First Name"> -->
                                                                <!-- <input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" placeholder="Enter First Name"> -->
                                                                coba
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <!-- <label class="form-label" for="formrow-firstname-input">Attachment File :</label> -->
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <!-- <div class="mt-4 mt-xl-0" style="height: 140px; overflow: auto;"> -->
                                                            <!-- <input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" placeholder="Enter First Name"> -->
                                                            <!-- <input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" placeholder="Enter First Name"> -->
                                                            <table class='table' id='tb_detail_status' style='width: 100%;'>
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 10% !important;">No</th>
                                                                        <th style="width: 10% !important;">Status</th>
                                                                        <th style="width: 40% !important;">Catatan</th>
                                                                        <!-- <th style="width: 20% !important;">Created By -->
                                                                        </th>
                                                                        <th style="width: 20% !important;">Created At
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                            <!-- </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="mt-4">
                                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                                    </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{asset('public/assets/js/bundle.js?ver=2.9.0')}}"></script>
    <script src="{{asset('public/assets/js/scripts.js?ver=2.9.0')}}"></script>
    <script src="{{asset('public/assets/libs/quill/quill.min.js')}}"></script>
    <script src="{{asset('public/assets/libs/quill/image-resize.min.js')}}"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="{{asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <!-- select region modal -->
    <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
    <script src="{{asset('public/assets/libs/quill/dataTables.fixedHeader.min.js')}}"></script>
    <script>
        $('#formLogin').submit(function(event) {
            console.log('coba');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formLogin').serialize(),
                url: "{{url('login')}}",
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    console.log(data.kode);
                    if (data.kode == 200) {
                        // toastr.clear();
                        // toastr.success('Anda Berhasil Login');
                        $('#formLogin').hide('slow', 'linear')
                        // $(".card.Lo").animate({
                        //     height: '-=100%'
                        // },500, function (){
                        //     $('#formLogin').hide()
                        // });
                        // $('form').css('display', 'none');
                        setTimeout(function() {
                            Swal.fire({
                                position: "top",
                                icon: "success",
                                title: "Anda Berhasil Login",
                                showConfirmButton: !1,
                            })
                            document.location = "{{ url('/home/index') }}"
                        }, 1000);

                    } else if (data.kode == 401) {
                        // $('#formLogin').trigger('reset');
                        // toastr.warning('adf');
                        // console.log(toastr.warning('adf'));
                        // console.log('salah');
                        // toastr.clear();
                        // toastr.error('Username Atau Password Anda Salah');
                        // toastr.error('Anda Berhasil Login');
                        Swal.fire({
                            position: "top",
                            icon: "error",
                            title: "Username Atau Password Anda Salah",
                            showConfirmButton: !1,
                            timer: 1500
                        });
                    } else {

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // $("#edit").click(function() {
            $(".card.Lo").css('height', '100%');
            // $(".card.Lo").animate({
            //     height: '100%'
            // }, 500);
            setTimeout(function() {
                $('#formLogin').show(800);
            }, 500);
            var quill_description_issues_detail = new Quill("#description_issues_detail", {
                theme: "snow",
                modules: {
                    "toolbar": false
                },
                disabled: true,
            });
            $('#description_issues_detail').on('keydown', function() {
                // alert('key up');
                return false;
            });

            $('#modalScanQRCodeTiketIssuesKamera').modal({
                backdrop: 'static',
                keyboard: false
            });

            $(document).on('click', '#kembali', function() {
                $('#modalScanQRCodeTiketIssuesKamera').modal('hide');
                scanner.stop();
            });

            let scanner = new Instascan.Scanner({
                video: document.getElementById("camera"),
                // mirror: false
            });
            let resultado = document.getElementById("qrcode");
            $(document).on('click', '#btnModalScanQRCodeTiketIssuesKamera', function() {
                scanner.stop();
                scanner.addListener("scan", function(content) {
                    // resultado.innerText = content;
                    // console.log(content);
                    getDetailIssues(content);
                    scanner.stop();
                });
                Instascan.Camera.getCameras()
                    .then(function(cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            resultado.innerText = "No cameras found.";
                        }
                    })
                    .catch(function(e) {
                        resultado.innerText = e;
                    });
            });

            $(document).on('click', '#kamera_depan', function() {
                scanner.stop();
                scanner.addListener("scan", function(content) {
                    // resultado.innerText = content;
                    // console.log(content);
                    getDetailIssues(content);
                    scanner.stop();
                });
                Instascan.Camera.getCameras()
                    .then(function(cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            resultado.innerText = "No cameras found.";
                        }
                    })
                    .catch(function(e) {
                        resultado.innerText = e;
                    });
            });

            $(document).on('click', '#kamera_belakang', function() {
                scanner.stop();
                scanner.addListener("scan", function(content) {
                    // resultado.innerText = content;
                    // console.log(content);
                    getDetailIssues(content);
                    scanner.stop();
                });
                Instascan.Camera.getCameras()
                    .then(function(cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[1]);
                        } else {
                            resultado.innerText = "No cameras found.";
                        }
                    })
                    .catch(function(e) {
                        resultado.innerText = e;
                    });
            });

            function getDetailIssues(tiket_issues_duplikat) {
                // return p1 * p2;
                // console.log(tiket_issues);

                var tiket_enc = bcrypt(tiket_issues_duplikat);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#formTambahIssues').serialize(),
                    url: "{{url('getDetailDataIssues')}}" + '/' + tiket_enc,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {

                        console.log(data);

                        if (data.kode == "401") {

                            Swal.fire(
                                'Data Tidak Ditemukan',
                                'Data Dengan Tiket Issues ( ' + tiket_issues_duplikat_text_cari +
                                ' ) Tidak Ditemukan',
                                'error'
                            )

                        } else {
                            if (data.data) {

                                $('#modalScanQRCodeTiketIssuesKamera').modal('hide');
                                $('#modalIssuesDetail').modal('show');

                                $(".modal_judul_issues_detail").html('Detail Issues ' + '( ' +
                                    data.data.tiket_issues + ' )');

                                console.log(data);
                                // console.log(data['username_sap_issues']);
                                var username_sap_issues = data.data.username_sap_issues;
                                var nama_pegawai = data.data.nama_pegawai;
                                var created_by = data.data.created_by;
                                var telp_issues = data.data.telp_issues;
                                var nama_kategori = data.data.nama_kategori;
                                var nama_layanan = data.data.nama_layanan;
                                var nama_subject = data.data.nama_subject;
                                var nama_priority = data.data.nama_priority;
                                var tanggal_pembuatan_issues = data.data.tanggal_pembuatan_issues;
                                var tanggal_batas_issues = data.data.tanggal_batas_issues;
                                var issues_link_file_array = data.issues_link_file_array;
                                var tiket_simasti = data.data.tiket_simasti;
                                var m_layanan_id = data.data.layanan_id;
                                // var issues_status_html = $(this).attr("data-issues_status_html");
                                console.log(issues_link_file_array);

                                if (m_layanan_id == 'L042') {

                                    const tiket_simasti_array = tiket_simasti.split("~");
                                    console.log(tiket_simasti_array);
                                    console.log(tiket_simasti_array.length);

                                    var subject_gabungan = '';

                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                                .attr(
                                                    'content')
                                        },
                                        // data: $('#formTambahIssues').serialize(),
                                        url: "{{url('api/getListDataAssetSimastiDenganTiketSismatiByTiketIssuesHelpdesk')}}" +
                                            '/' + data.data.tiket_issues,
                                        type: "GET",
                                        dataType: 'json',
                                        success: function(data) {
                                            console.log('ini asset dari simasti');
                                            console.log(data);
                                            $('#subject_nama_detail').val(' ');
                                            $('#subject_nama_detail').val(data.data);
                                            $('#jumlah_data_simasti').html(data
                                                .jumlah_data_sudah_selesai + ' / ' +
                                                (
                                                    data.jumlah_data_sudah_selesai +
                                                    data.jumlah_data_belum_selesai));
                                        },
                                        error: function(data) {
                                            console.log('Error:', data);
                                            //$('#modalPenghargaan').modal('show');
                                        }
                                    });
                                    console.log(subject_gabungan);
                                } else {
                                    var nama_subject_final = nama_subject;
                                    $('#subject_nama_detail').val(nama_subject_final);
                                    $('#jumlah_data_simasti').html('');
                                }
                                $('#username_sap_issues_detail').val(username_sap_issues);
                                $('#nama_pegawai_detail').val(nama_pegawai);
                                $('#created_by_detail').val(created_by);
                                $('#telp_issues_detail').val(telp_issues);
                                $('#kategori_nama_detail').val(nama_kategori);
                                $('#layanan_nama_detail').val(nama_layanan);
                                // $('#subject_nama_detail').val(nama_subject);
                                $('#priority_nama_detail').val(nama_priority);
                                $('#perkiraan_selesai_y_m_d_detail').val(tanggal_batas_issues);
                                // $('#tanggal_batas_issues_detail').val(tanggal_batas_issues);

                                $(".append_div_file_detail").html(issues_link_file_array);

                                // $("#description_issues_detail").html('');

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    // data: $('#formTambahIssues').serialize(),
                                    url: "{{url('getDescriptionIssues')}}" + '/' +
                                        tiket_enc,
                                    type: "GET",
                                    dataType: 'json',
                                    success: function(data) {
                                        console.log(data.description_issues);
                                        var get_description_issues = data
                                            .description_issues;
                                        var get_status_issues_html = data
                                            .status_issues_html;

                                        console.log('coba coba coba');
                                        console.log(get_status_issues_html);

                                        $("#description_issues_detail").html(
                                            get_description_issues);
                                        $(".modal_judul_issues_detail_status").html(
                                            get_status_issues_html);

                                        // $('#layanan_id').select2({data: [{id: '', text: ''}]});

                                        // $("#subject_id").empty().append(data.data);

                                    },
                                    error: function(data) {
                                        console.log('Error:', data);
                                        //$('#modalPenghargaan').modal('show');
                                    }
                                });

                                $('#tb_detail_status').DataTable().destroy();

                                var tb_detail_status = $('#tb_detail_status').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    searching: true,
                                    scrollX: "true",
                                    scrollY: "130px",
                                    sDom: 'lrtip', // untuk hidden search box di datatable
                                    autoWidth: 'false',
                                    bPaginate: false,
                                    bInfo: false,
                                    oLanguage: {
                                        sEmptyTable: "No Comment"
                                    },
                                    // language: {
                                    // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
                                    // },
                                    ajax: {
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "{{ url('getListDataRiwayatStatusIssues') }}" + "/" + data.data.tiket_issues,
                                        type: 'GET',
                                    },
                                    columns: [{
                                            data: 'no',
                                            name: 'no',
                                            className: 'text-center',
                                            // width: "10%",
                                        },
                                        {
                                            data: 'status',
                                            name: 'status',
                                            className: 'text-center',
                                            // width: "10%",
                                        },
                                        {
                                            data: 'catatan',
                                            name: 'catatan',
                                            className: 'text-center',
                                            // width: "20px",
                                        },
                                        // {
                                        //     data: 'created_by',
                                        //     name: 'created_by',
                                        //     className: 'text-center',
                                        //     // width: "20%",
                                        // },
                                        {
                                            data: 'created_at',
                                            name: 'created_at',
                                            className: 'text-center',
                                            // width: "20%",
                                        },
                                    ],
                                    drawCallback: function(settings) {
                                        // alert('DataTables has redrawn the table');
                                        // alert(settings);
                                        // class catatan_status_keydown_false adalah class dari isi kolom catatan pada tabel issues_status
                                        // $('.catatan_status_keydown_false').on('keydown', function() {
                                        //     // alert('key up');
                                        //     return false;
                                        // });
                                        console.log(' anti rewel coba');

                                        var api = this.api();
                                        var api_lenght = api.rows({
                                            page: 'current'
                                        }).data().length;
                                        // console.log( api.rows( {page:'current'} ).data().length );
                                        // console.log(settings);
                                        for (var i = 0; i < api_lenght; i++) {
                                            var quill_catatan_status_list_ckeditor = new Quill(".catatan_status_list_ckeditor" + i, {
                                                theme: "snow",
                                                modules: {
                                                    "toolbar": false
                                                },
                                                disabled: true,
                                            });

                                            $('#catatan_status_list_ckeditor' + i).on('keydown', function() {
                                                // alert('key up');
                                                return false;
                                            });
                                        }

                                    },
                                    error: function(xhr, error, code) {
                                        // console.log(xhr, code);
                                        $('#tb_detail_status').DataTable().ajax.reload(null, false);
                                    }
                                })

                            } else {

                                $('#modalScanQRCodeTiketIssuesKamera').modal('hide');
                                $('#modalIssuesDetail').modal('hide');

                                Swal.fire(
                                    'Data Tidak Ditemukan',
                                    'Data Dengan Tiket Issues ( ' + tiket_issues +
                                    ' ) Tidak Ditemukan',
                                    'error'
                                )
                            }
                        }


                    },
                    error: function(data) {
                        console.log('Error:', data);
                        //$('#modalPenghargaan').modal('show');
                    }
                });
            }
        });
    </script>

    <script>
        $(document).on('click', '#button_cari', function() {
            // $('#modalScanQRCodeTiketIssuesKamera').modal('hide');
            // scanner.stop();

            var tiket_issues_duplikat_text_cari = $("#tiket_issues_duplikat_text_cari").val();
            // console.log('coba');
            var tiket_enc = bcrypt(tiket_issues_duplikat_text_cari);
            console.log(tiket_enc);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('getDetailDataIssues')}}" + '/' + tiket_enc,
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    if (data.kode == "401") {

                        Swal.fire(
                            'Data Tidak Ditemukan',
                            'Data Dengan Tiket Issues ( ' + tiket_issues_duplikat_text_cari +
                            ' ) Tidak Ditemukan',
                            'error'
                        )

                    } else {
                        if (data.data) {

                            $('#modalScanQRCodeTiketIssuesKamera').modal('hide');
                            $('#modalIssuesDetail').modal('show');

                            $(".modal_judul_issues_detail").html('Detail Issues ' + '( ' +
                                tiket_issues_duplikat_text_cari + ' )');

                            console.log(data);
                            // console.log(data['username_sap_issues']);
                            var username_sap_issues = data.data.username_sap_issues;
                            var nama_pegawai = data.data.nama_pegawai;
                            var created_by = data.data.created_by;
                            var telp_issues = data.data.telp_issues;
                            var nama_kategori = data.data.nama_kategori;
                            var nama_layanan = data.data.nama_layanan;
                            var nama_subject = data.data.nama_subject;
                            var nama_priority = data.data.nama_priority;
                            var tanggal_pembuatan_issues = data.data.tanggal_pembuatan_issues;
                            var tanggal_batas_issues = data.data.tanggal_batas_issues;
                            var issues_link_file_array = data.issues_link_file_array;
                            var tiket_simasti = data.data.tiket_simasti;
                            var m_layanan_id = data.data.layanan_id;
                            // var issues_status_html = $(this).attr("data-issues_status_html");
                            console.log(m_layanan_id);

                            if (m_layanan_id == 'L042') {

                                const tiket_simasti_array = tiket_simasti.split("~");
                                console.log(tiket_simasti_array);
                                console.log(tiket_simasti_array.length);

                                var subject_gabungan = '';

                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    // data: $('#formTambahIssues').serialize(),
                                    url: "{{url('api/getListDataAssetSimastiDenganTiketSismatiByTiketIssuesHelpdesk')}}" +
                                        '/' + data.data.tiket_issues,
                                    type: "GET",
                                    dataType: 'json',
                                    success: function(data) {
                                        console.log('ini asset dari simasti');
                                        console.log(data);
                                        $('#subject_nama_detail').val(' ');
                                        $('#subject_nama_detail').val(data.data);
                                        $('#jumlah_data_simasti').html(data
                                            .jumlah_data_sudah_selesai + ' / ' + (
                                                data
                                                .jumlah_data_sudah_selesai + data
                                                .jumlah_data_belum_selesai));

                                    },
                                    error: function(data) {
                                        console.log('Error:', data);
                                        //$('#modalPenghargaan').modal('show');
                                    }
                                });


                                console.log(subject_gabungan);


                            } else {
                                var nama_subject_final = nama_subject;

                                $('#subject_nama_detail').val(nama_subject_final);
                                $('#jumlah_data_simasti').html('');
                            }

                            $('#username_sap_issues_detail').val(username_sap_issues);
                            $('#nama_pegawai_detail').val(nama_pegawai);
                            $('#created_by_detail').val(created_by);
                            $('#telp_issues_detail').val(telp_issues);
                            $('#kategori_nama_detail').val(nama_kategori);
                            $('#layanan_nama_detail').val(nama_layanan);
                            // $('#subject_nama_detail').val(nama_subject);
                            $('#priority_nama_detail').val(nama_priority);
                            $('#perkiraan_selesai_y_m_d_detail').val(tanggal_batas_issues);
                            // $('#tanggal_batas_issues_detail').val(tanggal_batas_issues);

                            $(".append_div_file_detail").html(issues_link_file_array);

                            // $("#description_issues_detail").html('');

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                // data: $('#formTambahIssues').serialize(),
                                url: "{{url('getDescriptionIssues')}}" + '/' +
                                    tiket_enc,
                                type: "GET",
                                dataType: 'json',
                                success: function(data) {
                                    console.log(data.description_issues);
                                    var get_description_issues = data
                                        .description_issues;
                                    var get_status_issues_html = data
                                        .status_issues_html;

                                    $("#description_issues_detail").html(
                                        get_description_issues);
                                    $(".modal_judul_issues_detail_status").html(
                                        get_status_issues_html);

                                    // $('#layanan_id').select2({data: [{id: '', text: ''}]});

                                    // $("#subject_id").empty().append(data.data);

                                },
                                error: function(data) {
                                    console.log('Error:', data);
                                    //$('#modalPenghargaan').modal('show');
                                }
                            });

                            $('#tb_detail_status').DataTable().destroy();

                            var tb_detail_status = $('#tb_detail_status').DataTable({
                                processing: true,
                                serverSide: true,
                                searching: true,
                                scrollX: "true",
                                scrollY: "130px",
                                sDom: 'lrtip', // untuk hidden search box di datatable
                                autoWidth: 'false',
                                bPaginate: false,
                                bInfo: false,
                                oLanguage: {
                                    sEmptyTable: "No Comment"
                                },
                                // language: {
                                // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
                                // },
                                ajax: {
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ url('getListDataRiwayatStatusIssues') }}" + "/" + data.data.tiket_issues,
                                    type: 'GET',
                                },
                                columns: [{
                                        data: 'no',
                                        name: 'no',
                                        className: 'text-center',
                                        // width: "10%",
                                    },
                                    {
                                        data: 'status',
                                        name: 'status',
                                        className: 'text-center',
                                        // width: "10%",
                                    },
                                    {
                                        data: 'catatan',
                                        name: 'catatan',
                                        className: 'text-center',
                                        // width: "20px",
                                    },
                                    // {
                                    //     data: 'created_by',
                                    //     name: 'created_by',
                                    //     className: 'text-center',
                                    //     // width: "20%",
                                    // },
                                    {
                                        data: 'created_at',
                                        name: 'created_at',
                                        className: 'text-center',
                                        // width: "20%",
                                    },
                                ],
                                drawCallback: function(settings) {
                                    // alert('DataTables has redrawn the table');
                                    // alert(settings);
                                    // class catatan_status_keydown_false adalah class dari isi kolom catatan pada tabel issues_status
                                    // $('.catatan_status_keydown_false').on('keydown', function() {
                                    //     // alert('key up');
                                    //     return false;
                                    // });
                                    console.log(' anti rewel coba');

                                    var api = this.api();
                                    var api_lenght = api.rows({
                                        page: 'current'
                                    }).data().length;
                                    // console.log( api.rows( {page:'current'} ).data().length );
                                    // console.log(settings);
                                    for (var i = 0; i < api_lenght; i++) {
                                        var quill_catatan_status_list_ckeditor = new Quill(".catatan_status_list_ckeditor" + i, {
                                            theme: "snow",
                                            modules: {
                                                "toolbar": false
                                            },
                                            disabled: true,
                                        });

                                        $('#catatan_status_list_ckeditor' + i).on('keydown', function() {
                                            // alert('key up');
                                            return false;
                                        });
                                    }

                                },
                                error: function(xhr, error, code) {
                                    // console.log(xhr, code);
                                    $('#tb_detail_status').DataTable().ajax.reload(null, false);
                                }
                            })

                        } else {

                            $('#modalScanQRCodeTiketIssuesKamera').modal('hide');
                            $('#modalIssuesDetail').modal('hide');

                            Swal.fire(
                                'Data Tidak Ditemukan',
                                'Data Dengan Tiket Issues ( ' + tiket_issues +
                                ' ) Tidak Ditemukan',
                                'error'
                            )
                        }
                    }




                },
                error: function(data) {
                    console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });
        });

        $(document).on('click', '#kembali_pencarian_isu_text', function() {
            $('#modalPencarianTiketIsuText').modal('hide');
        });
    </script>

    <script>
        $(document).ready(function() {

            // function onScanSuccess(decodedText, decodedResult) {
            //     console.log(`Code scanned = ${decodedText}`, decodedResult);
            // }
            // var html5QrcodeScanner = new Html5QrcodeScanner(
            //     "qr-reader", {
            //         // fps: 10,
            //         qrbox: 250
            //     });
            // html5QrcodeScanner.render(onScanSuccess);

            // $("#qr-reader__dashboard_section_swaplink").removeAttr("href");
            // $("#qr-reader__dashboard_section_swaplink").css("display", "none");
            // $("#qr-reader__dashboard_section_csr").css("display", "none");
            // $("#qr-reader__dashboard_section_fsr").css("display", "block");

            const html5QrCode = new Html5Qrcode( /* element id */ "reader");

            // File based scanning
            const fileinput = document.getElementById('qr-input-file');
            fileinput.addEventListener('change', e => {
                if (e.target.files.length == 0) {
                    // No file selected, ignore 
                    return;
                }

                // Use the first item in the list
                const imageFile = e.target.files[0];
                html5QrCode.scanFile(imageFile, /* showImage= */ true)
                    .then(qrCodeMessage => {
                        // success, use qrCodeMessage
                        console.log(qrCodeMessage);
                        $("#hasil_scan_qr_code_image").html(qrCodeMessage);
                        var tiket_enc = bcrypt(qrCodeMessage);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            // data: $('#formTambahIssues').serialize(),
                            url: "{{url('getDetailDataIssues')}}" + '/' + tiket_enc,
                            type: "GET",
                            dataType: 'json',
                            success: function(data) {

                                console.log(data);

                                if (data.kode == "401") {

                                    Swal.fire(
                                        'Data Tidak Ditemukan',
                                        'Data Dengan Tiket Issues ( ' + qrCodeMessage +
                                        ' ) Tidak Ditemukan',
                                        'error'
                                    )

                                } else {
                                    if (data.data) {

                                        $('#modalScanQRCodeTiketIssuesKamera').modal('hide');
                                        $('#modalIssuesDetail').modal('show');

                                        $(".modal_judul_issues_detail").html('Detail Issues ' + '( ' +
                                            data.data.tiket_issues + ' )');

                                        console.log(data);
                                        // console.log(data['username_sap_issues']);
                                        var username_sap_issues = data.data.username_sap_issues;
                                        var nama_pegawai = data.data.nama_pegawai;
                                        var created_by = data.data.created_by;
                                        var telp_issues = data.data.telp_issues;
                                        var nama_kategori = data.data.nama_kategori;
                                        var nama_layanan = data.data.nama_layanan;
                                        var nama_subject = data.data.nama_subject;
                                        var nama_priority = data.data.nama_priority;
                                        var tanggal_pembuatan_issues = data.data.tanggal_pembuatan_issues;
                                        var tanggal_batas_issues = data.data.tanggal_batas_issues;
                                        var issues_link_file_array = data.issues_link_file_array;
                                        var tiket_simasti = data.data.tiket_simasti;
                                        var m_layanan_id = data.data.layanan_id;
                                        // var issues_status_html = $(this).attr("data-issues_status_html");
                                        console.log(issues_link_file_array);

                                        if (m_layanan_id == 'L042') {

                                            const tiket_simasti_array = tiket_simasti.split("~");
                                            console.log(tiket_simasti_array);
                                            console.log(tiket_simasti_array.length);

                                            var subject_gabungan = '';

                                            $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                                        .attr(
                                                            'content')
                                                },
                                                // data: $('#formTambahIssues').serialize(),
                                                url: "{{url('api/getListDataAssetSimastiDenganTiketSismatiByTiketIssuesHelpdesk')}}" +
                                                    '/' + data.data.tiket_issues,
                                                type: "GET",
                                                dataType: 'json',
                                                success: function(data) {
                                                    console.log('ini asset dari simasti');
                                                    console.log(data);
                                                    $('#subject_nama_detail').val(' ');
                                                    $('#subject_nama_detail').val(data.data);
                                                    $('#jumlah_data_simasti').html(data
                                                        .jumlah_data_sudah_selesai + ' / ' +
                                                        (
                                                            data.jumlah_data_sudah_selesai +
                                                            data.jumlah_data_belum_selesai));
                                                },
                                                error: function(data) {
                                                    console.log('Error:', data);
                                                    //$('#modalPenghargaan').modal('show');
                                                }
                                            });
                                            console.log(subject_gabungan);
                                        } else {
                                            var nama_subject_final = nama_subject;
                                            $('#subject_nama_detail').val(nama_subject_final);
                                            $('#jumlah_data_simasti').html('');
                                        }
                                        $('#username_sap_issues_detail').val(username_sap_issues);
                                        $('#nama_pegawai_detail').val(nama_pegawai);
                                        $('#created_by_detail').val(created_by);
                                        $('#telp_issues_detail').val(telp_issues);
                                        $('#kategori_nama_detail').val(nama_kategori);
                                        $('#layanan_nama_detail').val(nama_layanan);
                                        // $('#subject_nama_detail').val(nama_subject);
                                        $('#priority_nama_detail').val(nama_priority);
                                        $('#perkiraan_selesai_y_m_d_detail').val(tanggal_batas_issues);
                                        // $('#tanggal_batas_issues_detail').val(tanggal_batas_issues);

                                        $(".append_div_file_detail").html(issues_link_file_array);

                                        // $("#description_issues_detail").html('');

                                        $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                                    'content')
                                            },
                                            // data: $('#formTambahIssues').serialize(),
                                            url: "{{url('getDescriptionIssues')}}" + '/' +
                                                tiket_enc,
                                            type: "GET",
                                            dataType: 'json',
                                            success: function(data) {
                                                console.log(data.description_issues);
                                                var get_description_issues = data
                                                    .description_issues;
                                                var get_status_issues_html = data
                                                    .status_issues_html;

                                                console.log('coba coba coba');
                                                console.log(get_status_issues_html);

                                                $("#description_issues_detail").html(
                                                    get_description_issues);
                                                $(".modal_judul_issues_detail_status").html(
                                                    get_status_issues_html);

                                                // $('#layanan_id').select2({data: [{id: '', text: ''}]});

                                                // $("#subject_id").empty().append(data.data);

                                            },
                                            error: function(data) {
                                                console.log('Error:', data);
                                                //$('#modalPenghargaan').modal('show');
                                            }
                                        });

                                        $('#tb_detail_status').DataTable().destroy();

                                        var tb_detail_status = $('#tb_detail_status').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            searching: true,
                                            scrollX: "true",
                                            scrollY: "130px",
                                            sDom: 'lrtip', // untuk hidden search box di datatable
                                            autoWidth: 'false',
                                            bPaginate: false,
                                            bInfo: false,
                                            oLanguage: {
                                                sEmptyTable: "No Comment"
                                            },
                                            // language: {
                                            // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
                                            // },
                                            ajax: {
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                url: "{{ url('getListDataRiwayatStatusIssues') }}" + "/" + data.data.tiket_issues,
                                                type: 'GET',
                                            },
                                            columns: [{
                                                    data: 'no',
                                                    name: 'no',
                                                    className: 'text-center',
                                                    // width: "10%",
                                                },
                                                {
                                                    data: 'status',
                                                    name: 'status',
                                                    className: 'text-center',
                                                    // width: "10%",
                                                },
                                                {
                                                    data: 'catatan',
                                                    name: 'catatan',
                                                    className: 'text-center',
                                                    // width: "20px",
                                                },
                                                // {
                                                //     data: 'created_by',
                                                //     name: 'created_by',
                                                //     className: 'text-center',
                                                //     // width: "20%",
                                                // },
                                                {
                                                    data: 'created_at',
                                                    name: 'created_at',
                                                    className: 'text-center',
                                                    // width: "20%",
                                                },
                                            ],
                                            drawCallback: function(settings) {
                                                // alert('DataTables has redrawn the table');
                                                // alert(settings);
                                                // class catatan_status_keydown_false adalah class dari isi kolom catatan pada tabel issues_status
                                                // $('.catatan_status_keydown_false').on('keydown', function() {
                                                //     // alert('key up');
                                                //     return false;
                                                // });
                                                console.log(' anti rewel coba');

                                                var api = this.api();
                                                var api_lenght = api.rows({
                                                    page: 'current'
                                                }).data().length;
                                                // console.log( api.rows( {page:'current'} ).data().length );
                                                // console.log(settings);
                                                for (var i = 0; i < api_lenght; i++) {
                                                    var quill_catatan_status_list_ckeditor = new Quill(".catatan_status_list_ckeditor" + i, {
                                                        theme: "snow",
                                                        modules: {
                                                            "toolbar": false
                                                        },
                                                        disabled: true,
                                                    });

                                                    $('#catatan_status_list_ckeditor' + i).on('keydown', function() {
                                                        // alert('key up');
                                                        return false;
                                                    });
                                                }

                                            },
                                            error: function(xhr, error, code) {
                                                // console.log(xhr, code);
                                                $('#tb_detail_status').DataTable().ajax.reload(null, false);
                                            }
                                        })

                                    } else {

                                        $('#modalScanQRCodeTiketIssuesKamera').modal('hide');
                                        $('#modalIssuesDetail').modal('hide');

                                        Swal.fire(
                                            'Data Tidak Ditemukan',
                                            'Data Dengan Tiket Issues ( ' + tiket_issues +
                                            ' ) Tidak Ditemukan',
                                            'error'
                                        )
                                    }
                                }


                            },
                            error: function(data) {
                                console.log('Error:', data);
                                //$('#modalPenghargaan').modal('show');
                            }
                        });
                    })
                    .catch(err => {
                        // failure, handle it.
                        console.log(`Error scanning file. Reason: ${err}`)
                        Swal.fire(
                            'Gambar QR Code tidak sesuai ketentuan',
                            'Data Tidak Ditemukan',
                            'error'
                        )
                    });

                html5QrCode.clear();
            });

        });

        $(document).on('click', '#kembali_qr_code_image', function() {
            $('#modalScanQRCodeTiketIssuesImage').modal('hide');
            html5QrCode.clear();
        });
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WTPYJN1KMH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-WTPYJN1KMH');
    </script>

</body>

</html>