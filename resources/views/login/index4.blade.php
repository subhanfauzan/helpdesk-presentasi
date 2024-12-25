<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Helpdesk | {{ $judul }}</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('public/assets/css/dashlite.css?ver=2.9.0')}}">
    <!-- <link id="skin-default" rel="stylesheet" href="{{asset('public/assets/css/theme.css?ver=2.9.0')}}"> -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
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

        .card {
            background-color: rgba(255, 255, 255, 0.75)
        }

        .card.Lo {
            height: 0%;
            z-index: 3;
        }

        .wrapper {
            /* background: #ffffff; */
            /* background: linear-gradient(top left, #31baff 0%, #d6ffd6 100%);
            background: linear-gradient(to bottom right, #d6ffd6 0%, #31baff 100%); */
            background-color: #f3f5f750;
            /* background-image: linear-gradient(#f0f2f5, rgb(222, 222, 222)); */
            color: black;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .container1 {
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
            margin-bottom: auto;
            height: 90vh;
            text-align: center;
            z-index: 3;
        }

        .logos {
            max-height: 6vh;
            height: 6vh;
            margin-right: 1%;
            z-index: 2;
        }

        .logos>img {
            max-width: 20%;
            max-height: 5vh;
            margin-right: 1%;
        }

        form {
            position: relative;
            z-index: 3;
            max-height: 95vh;
        }

        .partner>img {
            width: 20%;
            margin-right: 5px;
        }

        .bg-bubbles {
            position: absolute;
            top: 35px;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            padding-left: 0px;
        }

        .bg-bubbles li {
            position: absolute;
            list-style: none;
            display: block;
            width: 2%;
            /* height: 10%; */
            background-color: rgb(245, 245, 245);
            bottom: -20vh;
            animation: square 15s infinite;
            transition-timing-function: linear;
            overflow: hidden;
            margin: auto;
            aspect-ratio: 1 / 1;
        }

        .bg-bubbles li:nth-child(1) {
            left: 1%;
            animation-duration: 40s;
            width: 4%;
            background-color: rgba(255, 255, 255, 0.6);
        }

        .bg-bubbles li:nth-child(2) {
            left: 5%;
            width: 5%;
            animation-delay: 3s;
            animation-duration: 20s;
        }

        .bg-bubbles li:nth-child(3) {
            left: 25%;
            width: 4%;
            animation-delay: 3s;
            background-color: rgba(255, 255, 255, 0.4);
        }

        .bg-bubbles li:nth-child(4) {
            left: 15%;
            width: 8%;
            animation-duration: 10s;
            background-color: rgba(255, 255, 255, 0.6);
        }

        .bg-bubbles li:nth-child(5) {
            left: 23%;
            animation-duration: 40s;
        }

        .bg-bubbles li:nth-child(6) {
            left: 82%;
            width: 1%;
            animation-duration: 30s;
            animation-delay: 5s;
            background-color: rgba(255, 255, 255, 0.6);
        }

        .bg-bubbles li:nth-child(7) {
            left: 75%;
            width: 8%;
            animation-delay: 2s;
            animation-duration: 11s;
        }

        .bg-bubbles li:nth-child(8) {
            left: 66%;
            width: 3%;
            animation-delay: 8s;
            animation-duration: 27s;
            background-color: rgb(255, 255, 255, 0.5);
        }

        .bg-bubbles li:nth-child(9) {
            left: 85%;
            width: 6%;
            animation-delay: 2s;
            animation-duration: 30s;
        }

        .bg-bubbles li:nth-child(10) {
            left: 92%;
            width: 6%;
            animation-direction: 17s;
            animation-delay: 5s;
            background-color: rgba(255, 255, 255, 1);
        }

        .bg-bubbles li:nth-child(11) {
            left: 30%;
            animation-delay: 1s;
            animation-duration: 27s;
            background-color: rgba(255, 255, 255, 0.4);

        }

        .bg-bubbles li:nth-child(12) {
            left: 60%;
            animation-delay: 2s;
            animation-duration: 15s;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .bg-bubbles li:nth-child(13) {
            left: 70%;
            animation-delay: 3s;
            animation-duration: 11s;
            background-color: rgba(255, 255, 255, 0.3);
        }

        .bg-bubbles li:nth-child(13) {
            left: 78%;
            width: 3%;
            animation-duration: 33s;
            animation-delay: 1s;
            background-color: rgba(255, 255, 255, 0.3);
        }

        @keyframes square {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-90vh) rotate(600deg);
            }
        }

        @keyframes square {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-90vh) rotate(600deg);
            }
        }

        @media only screen and (min-width: 1200px) {
            .card.Lo {
                margin-right: 7% !important;
                margin-left:  7% !important;
            }
        }

        @media only screen and (min-width: 2400px) {
            .card.Lo {
                height: 60vh !important;
            }
            p {
                font-size: 20pt !important;
            }
            input{ 
                padding: 50px 30px !important; 
                line-height: 40px !important; 
            }

            em>i{ 
                margin-top: 50px !important;
                width: 50px
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="logos text-center d-flex justify-content-end align-items-center">
            <img src="{{asset('public/image/bumn.png')}}" alt="">
            <img src="{{asset('public/image/petro_logo_bubble.png')}}" alt="">
            <img src="{{asset('public/image/pi.png')}}" alt="">
        </div>
        <div class="container1 d-flex align-items-center justify-content-center" style="overflow: auto;">
            <div class="col-md-5 col-sm-8 col-xl-4 col-lg-4">
            <div class="brand-logo pb-1 text-center">
               
                    <img style="max-width: 70%; max-height: 15vh;" src="{{ asset('public/image/Helpdesk_logo_login_2.png') }}"
                        alt="description of myimage">
                
            </div>
            <div class="card Lo">
                <div class="card-body ">
                    <div class="card-title">
                        <h3>Sign In</h3>
                    </div>
                    <form action="javascript:;" name="formLogin" id="formLogin" enctype="multipart/form-data"
                        style="display: none">
                        <div class="form-group">
                            <div class="form-label-group">
                                <label class="form-label" for="default-01"><p>Username</p> </label>
                            </div>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control form-control-lg" name="username" id="username"
                                    placeholder="Enter your email address or username">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label class="form-label" for="password"><p>Password</p> </label>
                            </div>
                            <div class="form-control-wrap">
                                <a href="#" class="form-icon form-icon-right passcode-switch xl" data-target="password">
                                    <em class="passcode-icon icon-show "><i class='bx bx-show bx-xs'></i></em>
                                    <em class="passcode-icon icon-hide "><i class='bx bxs-hide bx-xs'></i></em>
                                </a>
                                <input type="password" class="form-control form-control-lg" name="password"
                                    id="password" placeholder="Enter your passcode">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <button id="btnLogin" name="btnLogin" type="submit"
                                    class="btn btn-primary waves-effect waves-light col-12"><p><i
                                        class='bx bx-log-in-circle'></i> Login</p> </button>
                                <button id="btnModalPencarianTiket" name="btnModalPencarianTiket" type="button"
                                    class="col-12 btn btn-outline-info mt-2"
                                    data-bs-toggle="modal" data-bs-target="#modalPencarianTiket"><p> <i
                                        class='bx bx-search'></i> Cari Tiket Isu</p> </button>
                            </div>
                            </div>
                        <p>Partner App:</p>
                        <div class="d-flex justify-content-center partner">
                            <img src="{{asset('public/image/simasti_logo.png')}}" alt="">
                            <img src="{{asset('public/image/logo_dof.jpeg')}}" alt="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <ul class="bg-bubbles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <div class="modal fade" id="modalPencarianTiket">
        <div class="modal-dialog modal-dialog-top modal-md" style="min-width: 35%" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pencarian Tiket Isu </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <button style="width: 49%" id="btnModalScanQRCodeTiketIssues"
                            name="btnModalScanQRCodeTiketIssues" type="button"
                            class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#modalScanQRCodeTiketIssues">Pencarian dengan QR Code</button>
                        <button style="width: 49%" id="btnModalPencarianTiketIsuText"
                            name="btnModalPencarianTiketIsuText" type="button"
                            class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#modalPencarianTiketIsuText">Pencarian dengan Text</button>

                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalScanQRCodeTiketIssues">
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
                        <video id="camera"></video>
                        <div id="qrcode"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <button type="button" id="kembali" namme="kembali" class="btn btn-md btn-primary">
                        Kembali</button>
                    <button type="button" id="kamera_depan" namme="kamera_depan" class="btn btn-md btn-primary">Kamera
                        Depan</button>
                    <button type="button" id="kamera_belakang" namme="kamera_belakang"
                        class="btn btn-md btn-primary">Kamera Belakang</button>
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
                        <input type="text" class="form-control form-control-lg" name="tiket_issue_text_cari"
                            id="tiket_issue_text_cari">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <button type="button" id="button_cari" namme="button_cari" class="btn btn-md btn-primary">Cari
                        Tiket</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalIssuesDetail" data-bs-focus="false" style="font-size: 14pt">

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
                                                    <input type="text" readonly name="username_sap_issues_detail"
                                                        id="username_sap_issues_detail" class="form-control"
                                                        placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Telp
                                                        (Extension) :</label>
                                                    <input type="text" readonly name="telp_issues_detail"
                                                        id="telp_issues_detail" class="form-control"
                                                        placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Kategori :</label>
                                                    <input type="text" readonly name="kategori_nama_detail"
                                                        id="kategori_nama_detail" class="form-control"
                                                        placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Pilih Layanan :</label>
                                                    <input type="text" readonly name="layanan_nama_detail"
                                                        id="layanan_nama_detail" class="form-control"
                                                        placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Subjeck : <span
                                                            id="jumlah_data_simasti">coba</span> </label>
                                                    <input type="text" readonly name="subject_nama_detail"
                                                        id="subject_nama_detail" class="form-control"
                                                        placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Priority :</label>
                                                    <input type="text" readonly name="priority_nama_detail"
                                                        id="priority_nama_detail" class="form-control"
                                                        placeholder="Enter First Name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Due Date
                                                        Probability :</label>
                                                    <input type="text" readonly name="perkiraan_selesai_y_m_d_detail"
                                                        id="perkiraan_selesai_y_m_d_detail" class="form-control"
                                                        placeholder="perkiraan selesai" readonly>
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

                                                    <div name="description_issues_detail" id="description_issues_detail"
                                                        class="description_issues_detail"
                                                        style="height: 412px; max-height: 412px;">

                                                    </div>
                                                    <!-- <div id="editor">This is some sample content.</div> -->
                                                    <!-- end Snow-editor-->
                                                    <!-- </div>  -->
                                                    <!-- end card-body-->
                                                    <!-- </div>  -->
                                                    <!-- end card-->
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Attachment
                                                        File :</label>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mt-4 mt-xl-0 append_div_file_detail"
                                                                style="height: 132px; overflow-y: auto;">
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
                                                            <table class='table' id='tb_detail_status'
                                                                style='width: 100%;'>
                                                                <thead>
                                                                    <tr style="display: none;">
                                                                        <th style="width: 10% !important;">No</th>
                                                                        <th style="width: 10% !important;">Status</th>
                                                                        <th style="width: 40% !important;">Catatan</th>
                                                                        <th style="width: 20% !important;">Created By
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
                                    <!-- </div> -->
                                    <!-- </div> -->
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

    <script>
        $('#formLogin').submit(function (event) {
            console.log('coba');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formLogin').serialize(),
                url: "{{url('login')}}",
                type: "GET",
                dataType: 'json',
                success: function (data) {
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
                        setTimeout(function () {
                            Swal.fire({
                                position: "top",
                                icon: "success",
                                title: "Anda Berhasil Login",
                                showConfirmButton: !1,
                            })
                            document.location = "{{ url('/home/index') }}"
                        }, 1000);

                    } else if (data.kode == 401) {
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
                error: function (data) {
                    console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            // $("#edit").click(function() {
            $(".card.Lo").css('height', '100%');
            // $(".card.Lo").animate({
            //     height: '100%'
            // }, 500);
            setTimeout(function () {
                $('#formLogin').show(800);
            }, 500);
            var quill_description_issues_detail = new Quill("#description_issues_detail", {
                theme: "snow",
                modules: {
                    "toolbar": false
                },
                disabled: true,
            });
            $('#description_issues_detail').on('keydown', function () {
                // alert('key up');
                return false;
            });

            $('#modalScanQRCodeTiketIssues').modal({
                backdrop: 'static',
                keyboard: false
            });

            $(document).on('click', '#kembali', function () {
                $('#modalScanQRCodeTiketIssues').modal('hide');
                scanner.stop();
            });

            let scanner = new Instascan.Scanner({
                video: document.getElementById("camera"),
                // mirror: false
            });
            let resultado = document.getElementById("qrcode");
            $(document).on('click', '#btnModalScanQRCodeTiketIssues', function () {
                scanner.stop();
                scanner.addListener("scan", function (content) {
                    // resultado.innerText = content;
                    // console.log(content);
                    getDetailIssues(content);
                    scanner.stop();
                });
                Instascan.Camera.getCameras()
                    .then(function (cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            resultado.innerText = "No cameras found.";
                        }
                    })
                    .catch(function (e) {
                        resultado.innerText = e;
                    });
            });

            $(document).on('click', '#kamera_depan', function () {
                scanner.stop();
                scanner.addListener("scan", function (content) {
                    // resultado.innerText = content;
                    // console.log(content);
                    getDetailIssues(content);
                    scanner.stop();
                });
                Instascan.Camera.getCameras()
                    .then(function (cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            resultado.innerText = "No cameras found.";
                        }
                    })
                    .catch(function (e) {
                        resultado.innerText = e;
                    });
            });

            $(document).on('click', '#kamera_belakang', function () {
                scanner.stop();
                scanner.addListener("scan", function (content) {
                    // resultado.innerText = content;
                    // console.log(content);
                    getDetailIssues(content);
                    scanner.stop();
                });
                Instascan.Camera.getCameras()
                    .then(function (cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[1]);
                        } else {
                            resultado.innerText = "No cameras found.";
                        }
                    })
                    .catch(function (e) {
                        resultado.innerText = e;
                    });
            });

            function getDetailIssues(tiket_issues) {
                // return p1 * p2;
                // console.log(tiket_issues);

                var tiket_enc = bcrypt(tiket_issues);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#formTambahIssues').serialize(),
                    url: "{{url('getDetailDataIssues')}}" + '/' + tiket_enc,
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {

                        if (data.kode == "401") {

                            Swal.fire(
                                'Data Tidak Ditemukan',
                                'Data Dengan Tiket Issues ( ' + tiket_issue_text_cari +
                                ' ) Tidak Ditemukan',
                                'error'
                            )

                        } else {
                            if (data.data) {

                                $('#modalScanQRCodeTiketIssues').modal('hide');
                                $('#modalIssuesDetail').modal('show');

                                $(".modal_judul_issues_detail").html('Detail Issues ' + '( ' +
                                    tiket_issues + ' )');

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
                                            '/' + tiket_issues,
                                        type: "GET",
                                        dataType: 'json',
                                        success: function (data) {
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
                                        error: function (data) {
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
                                    success: function (data) {
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
                                    error: function (data) {
                                        console.log('Error:', data);
                                        //$('#modalPenghargaan').modal('show');
                                    }
                                });

                            } else {

                                $('#modalScanQRCodeTiketIssues').modal('hide');
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
                    error: function (data) {
                        console.log('Error:', data);
                        //$('#modalPenghargaan').modal('show');
                    }
                });
            }
        });

    </script>

    <script>
        $(document).on('click', '#button_cari', function () {
            // $('#modalScanQRCodeTiketIssues').modal('hide');
            // scanner.stop();

            var tiket_issue_text_cari = $("#tiket_issue_text_cari").val();
            // console.log('coba');
            var tiket_enc = bcrypt(tiket_issue_text_cari);
            console.log(tiket_enc);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('getDetailDataIssues')}}" + '/' + tiket_enc,
                type: "GET",
                dataType: 'json',
                success: function (data) {

                    if (data.kode == "401") {

                        Swal.fire(
                            'Data Tidak Ditemukan',
                            'Data Dengan Tiket Issues ( ' + tiket_issue_text_cari +
                            ' ) Tidak Ditemukan',
                            'error'
                        )

                    } else {
                        if (data.data) {

                            $('#modalScanQRCodeTiketIssues').modal('hide');
                            $('#modalIssuesDetail').modal('show');

                            $(".modal_judul_issues_detail").html('Detail Issues ' + '( ' +
                                tiket_issue_text_cari + ' )');

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
                                        '/' + tiket_issue_text_cari,
                                    type: "GET",
                                    dataType: 'json',
                                    success: function (data) {
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
                                    error: function (data) {
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
                                success: function (data) {
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
                                error: function (data) {
                                    console.log('Error:', data);
                                    //$('#modalPenghargaan').modal('show');
                                }
                            });

                        } else {

                            $('#modalScanQRCodeTiketIssues').modal('hide');
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
                error: function (data) {
                    console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });
        });

    </script>

</body>

</html>
