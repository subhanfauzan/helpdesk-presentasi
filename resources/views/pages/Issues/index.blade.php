@extends('layouts.app')

@section('content')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Rekap Table Issue</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Issues</a></li>
                            <li class="breadcrumb-item active">Issues</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <h4 class="card-title">Justify Tabs</h4>
                        <p class="card-title-desc"></p>
                    </div> -->
                    <!-- end card header -->

                    <div class="card-body">
                        <button type="button" id="buttonModalFormTambahIssues" class="btn btn-primary waves-effect waves-light addButton" data-bs-toggle="modal" data-bs-target="#modalFormTambahIssues">Tambah Issue</button>
                        <br><br>
                        <!-- <iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="http://localhost/ruang_tutor/home_surat_perjanjian/surat_perjanjian" title="W3Schools Free Online Web Tutorials" style="width: 100%;" height="450px">
                        </iframe>
                        <canvas id="sig-canvas" style="border: 1px solid black; width:'100%' height='100%'">
                        </canvas> -->
                        <!-- Nav tabs -->
                        <?php
                        if (Session::get('user_app')['flag'] == "AS" || Session::get('user_app')['flag'] == "AU" || Session::get('user_app')['flag'] == "AL") {
                            $display = "style='display:none'";
                        } else {
                            $display = '';
                        }

                        ?>

                        <?php
                        if (Session::get('user_app')['unitId'] == "PBD200") {
                            $display_per_tab = '';
                        } else {
                            $display_per_tab = "style='display:none'";
                        }

                        ?>
                        <ul class="nav nav-pills nav-justified" role="tablist" <?php echo $display; ?>>
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link active tab_tabel_issues" data-bs-toggle="tab" href="#tab_tabel_issues" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">My Issues</span>
                                </a>
                            </li>
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link tab_tabel_issues_unit_kerja" data-bs-toggle="tab" href="#tab_tabel_issues_unit_kerja" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Work Unit Issues</span>
                                </a>
                            </li>
                            <li class="nav-item waves-effect waves-light" <?php echo $display_per_tab; ?>>
                                <a class="nav-link tab_tabel_issues_forward" data-bs-toggle="tab" href="#tab_tabel_issues_forward" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Forward Issues</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="tab_tabel_issues" role="tabpanel">
                                <p class="mb-0">
                                    <!-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                                    ->merge(public_path('image/Petro_logo.png'), 0.3, true)
                                    ->size(110)->errorCorrection('H')
                                    ->generate('http://simpeg.kedirikota.go.id/arsipdigital/index.php/Login')) !!} "> -->
                                    <table class="table display select" id="tb_issues" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tiket Issues</th>
                                                <!-- <th>Qr Code</th> -->
                                                <th>Nama Pegawai</th>
                                                <!-- <th>Created By</th> -->
                                                <th>Layanan</th>
                                                <th>Subject</th>
                                                <th>Priority</th>
                                                <th>Tanggal Pembuatan</th>
                                                <th>Tanggal Batas</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>

                                            <tr>
                                                <th>No</th>
                                                <th>Tiket Issues</th>
                                                <!-- <th>QR Code</th> -->
                                                <th>Nama Pegawai</th>
                                                <!-- <th>Created By</th> -->
                                                <th>Layanan</th>
                                                <th>Subject</th>
                                                <th>Priority</th>
                                                <th>Tanggal Pembuatan</th>
                                                <th>Tanggal Batas</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </p>
                            </div>
                            <div class="tab-pane" id="tab_tabel_issues_unit_kerja" role="tabpanel">
                                <p class="mb-0">
                                    <!-- <div class="col-xl-12"> -->
                                    <table class="table display select" id="tb_issues_unit_kerja" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tiket Issues</th>
                                                <!-- <th>QR Code</th> -->
                                                <th>Nama Pegawai</th>
                                                <th>Created By</th>
                                                <th>Layanan</th>
                                                <th>Subject</th>
                                                <th>Priority</th>
                                                <th>Tanggal Pembuatan</th>
                                                <th>Tanggal Batas</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>

                                            <tr>
                                                <th>No 2</th>
                                                <th>Tiket Issues 2</th>
                                                <!-- <th>QR Code</th> -->
                                                <th>Nama Pegawai 2</th>
                                                <th>Created By 2</th>
                                                <th>Layanan 2</th>
                                                <th>Subject 2</th>
                                                <th>Priority 2</th>
                                                <th>Tanggal Pembuatan 2</th>
                                                <th>Tanggal Batas 2</th>
                                                <th>Status 2</th>
                                                <th>Aksi 2</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <!-- </div> -->

                                </p>
                            </div>
                            <div class="tab-pane" id="tab_tabel_issues_forward" role="tabpanel">
                                <p class="mb-0">
                                    <!-- <div class="col-xl-12"> -->
                                    <table class="table" id="tb_issues_forward" style="width: 100%;">
                                        <thead>
                                        <tr>
                                                <th>No</th>
                                                <th>Tiket Issues</th>
                                                <!-- <th>Qr Code</th> -->
                                                <th>Nama Pegawai</th>
                                                <!-- <th>Created By</th> -->
                                                <th>Layanan</th>
                                                <th>Subject</th>
                                                <th>Priority</th>
                                                <th>Tanggal Pembuatan</th>
                                                <th>Tanggal Batas</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>

                                            <tr>
                                                <th>No 3</th>
                                                <th>Tiket Issues 3</th>
                                                <!-- <th>QR Code 3</th> -->
                                                <th>Nama Pegawai 3</th>
                                                <!-- <th>Created By 3</th> -->
                                                <th>Layanan 3</th>
                                                <th>Subject 3</th>
                                                <th>Priority 3</th>
                                                <th>Tanggal Pembuatan 3</th>
                                                <th>Tanggal Batas 3</th>
                                                <th>Status 3</th>
                                                <th>Keterangan 3</th>
                                                <th>Aksi 3</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <!-- </div> -->

                                </p>
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-12">
                <div class="row">

                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>

<div class="modal fade" id="modalFormTambahIssues" style="font-size: 14pt; margin-top: -15px; max-height: 100%">
    <form action="javascript:;" class="form-validate is-alter formTambahIssues" enctype="multipart/form-data">
        <div class="modal-dialog modal-dialog-top modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="margin-top: -40px">
                    <h4 class="modal-title">Tambah Issue</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-top: 30px"></button>
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
                                                <!-- <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Form groups
                                                    </h5> -->
                                                @if($user_app['role'] == 'R003' || $user_app['role'] == 'R004')
                                                @php
                                                $nik = $user_app['nik'];
                                                @endphp
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Username SAP : </label>
                                                    <input type="text" readonly name="username_sap_issues" id="username_sap_issues" class="form-control"  value="{{Session::get('user_app')['username']}}">
                                                </div>
                                                @else
                                                @php
                                                $nik = "";
                                                @endphp
                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Username SAP :</label>
                                                    <div class="form-control-wrap">
                                                        <select name="username_sap_issues" id="username_sap_issues" class="username_sap_issues_select2">
                                                            <option value=""></option>
                                                            <!-- @foreach($array_pegawai_semua as $data)
                                                            <option value="{{$data->nik}}">{{$data->nama}}</option>
                                                            @endforeach -->
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Telp/Ext :</label>
                                                    <input type="text" name="telp_issues" id="telp_issues" class="form-control" placeholder="Ex: 08xxxxxxxxx">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Nomor Whatsapp <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover focus" data-bs-content="No Whatsapp diperuntukan untuk kebutuhan informasi jika isu sudah terselesaikan"><i class="fas fa-exclamation"></i></button> :</label>
                                                    <input type="text" name="no_wa" id="no_wa" class="form-control" placeholder="Ex: 628xxxxxxxx">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Pilih Kategori :</label>
                                                    <div class="form-control-wrap">
                                                        <select name="kategori_id" id="kategori_id">
                                                            <option value=""></option>
                                                            @foreach($m_kategori as $data)
                                                            <option value="{{$data->id}}">{{$data->nama_kategori}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Pilih Layanan :</label>
                                                    <div class="form-control-wrap">
                                                        <select name="layanan_id" id="layanan_id">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3" id="subject_helpdesk">
                                                    <label class="form-label" for="full-name">Subject Helpdesk :</label>
                                                    <div class="form-control-wrap">
                                                        <select name="subject_id" id="subject_id">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- <div class="mb-3">
                                                    <label class="form-label" for="full-name">Subject Simasti :</label>
                                                    <div class="form-control-wrap">
                                                        <select name="subject_id_2" id="subject_id_2" style="width: 100%">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div> -->

                                                <div class="mb-3" id="subject_simasti" style="display: none">
                                                    <label class="form-label" for="formrow-firstname-input">Subject Simasti :</label>
                                                    <div id="append_div_subject_simasti">
                                                        <div class="row">
                                                            <div class="col-lg-10">
                                                                <div class="mt-4 mt-xl-0">
                                                                    <div class="row" id="append_div_subject_simasti_delete">
                                                                        <div class="col-lg-7">
                                                                            <select name="subject_id_2[]" id="subject_id_2" class="subject_id_2" style="width: 100%">
                                                                                <option value=""></option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-5">
                                                                            <input type="text" name="keluhan[]" id="keluhan" class="form-control" placeholder="Keluhan" style="width: 100%">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <div class="mt-4 mt-xl-0">
                                                                    <button type="button" name="plus_append_subject_simasti" id="plus_append_subject_simasti" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="full-name">Priority :</label>
                                                    <div class="form-control-wrap">
                                                        <select name="priority_id" id="priority_id">
                                                            <option value=""></option>
                                                            @foreach($m_priority as $data)
                                                            <option id="{{$data->id}}" value="{{$data->id}}">{{$data->nama_priority}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Due Date Probability:</label>


                                                    <!-- <div class="set_text_perkiraan_selesai" style="font-size: 12px"> -->

                                                    <!-- </div> -->
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <input type="text" name="perkiraan_selesai" id="perkiraan_selesai" class="form-control" placeholder="Perkiraan selesai" readonly>
                                                            <input type="hidden" name="perkiraan_selesai_y_m_d" id="perkiraan_selesai_y_m_d" class="form-control" placeholder="Perkiraan selesai" data-toggle="popover">
                                                        </div>
                                                        <!-- <div class="col-xl-1"> -->
                                                        <!-- <button type="button" id="popover_info_tanggal_perkiraan_selesai" class="btn btn-info" data-bs-toggle="popover" data-bs-placement="right" title="Info Tanggal" data-bs-content="Some content <br> inside the popover"><i class="mdi mdi-alert"></i></button> -->
                                                        <!-- <button type="button" class="btn btn-info" id="popover_info_tanggal_perkiraan_selesai" data-toggle="popover"><i class="mdi mdi-alert"></i></button> -->
                                                        <!-- </div> -->
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

                                                    <div name="description_issues" id="description_issues" class="description_issues" style="height: 440px;">

                                                    </div>
                                                    <div style="height: 22px; font-size: 12px">
                                                        <span id="description_issues_lenght" class="description_issues_lenght" style="background-color:#00FF00"> 0 </span> / 1000
                                                    </div>
                                                    <!-- <div id="editor">This is some sample content.</div> -->
                                                    <!-- end Snow-editor-->
                                                    <!-- </div>  -->
                                                    <!-- end card-body-->
                                                    <!-- </div>  -->
                                                    <!-- end card-->
                                                </div>
                                                @php
                                                    if($user_app['role'] == "R001") {
                                                @endphp
                                                            <div class="form-check" style="font-size: 14px;">
                                                                <input class="form-check-input" type="checkbox" value="true" id="security_incident" name="security">
                                                                <label class="form-check-label" for="security">
                                                                    Security Incident
                                                                </label>
                                                            </div>
                                                            <div class="form-check" style="font-size: 14px;">
                                                                <input class="form-check-input" type="checkbox" value="true" id="major_incident" name="major" >
                                                                <label class="form-check-label" for="flexCheckChecked">
                                                                    Major Incident
                                                                </label>
                                                            </div>
                                                @php
                                                    } else {
                                                @endphp
                                                        <div class="form-group" style="visibility: hidden;">
                                                            <div class="form-check" style="font-size: 14px;">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" disabled>
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    Security Incident
                                                                </label>
                                                            </div>
                                                            <div class="form-check" style="font-size: 14px;">
                                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" disabled>
                                                                <label class="form-check-label" for="flexCheckChecked">
                                                                    Major Incident
                                                                </label>
                                                            </div>
                                                        </div>
                                                @php
                                                    }
                                                @endphp
                                                <div class="mb-3 pt-2">
                                                    <label class="form-label" for="formrow-firstname-input">Attachment File :</label>
                                                    <small style="font-size: 8pt; display:block; margin-top:-10px; margin-bottom:2px;">File yang didukung: doc,xls,docx,xlsx,pdf,mp3,aav,mp4,mkv,jpg,jpeg,png,svg,zip</small>

                                                    <!-- <div class="row">
                                                        <div class="col-lg-11">
                                                            <div class="mt-4 mt-xl-0" id="append_div">
                                                                <input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" >
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <div class="mt-4 mt-xl-0">
                                                                <button type="button" name="plus_append_file" id="plus_append_file" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div id="append_div">
                                                        <div class="row">
                                                            <div class="col-lg-11">
                                                                <div class="mt-4 mt-xl-0">
                                                                    <input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" accept=".doc,.xls,.docx,.xlsx,.pdf,.mp3,.aav,.mp4,.mkv,.jpg,.jpeg,.png,.svg" >
                                                                    <!-- <input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" > -->
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <div class="mt-4 mt-xl-0">
                                                                    <button type="button" name="plus_append_file" id="plus_append_file" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus"></i></button>
                                                                </div>
                                                            </div>
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
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <!-- <button type="button" id="tambah" namme="tambah" class="btn btn-md btn-primary">Simpan</button> -->
                    <button type="submit" class="btn btn-md btn-primary simpan_form_tambah_issue_disabled_enabled">Simpan</button>
                    <!-- <button type="submit" class="btn bg-pink-a400 text-white mr-1"><i class="md md-floppy"></i> Simpan</button> -->
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modalIssuesDetail" data-bs-focus="false" style="font-size: 14pt">

    <div class="modal-dialog modal-dialog-top modal-xl" role="document" style="max-width: 92%; margin-bottom: -10px;">
        <div class="modal-content" style="margin-bottom: -20px; margin-top: -20px;">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title modal_judul_issues_detail">Detail Issues</h5>
                </div>
                &nbsp;
                <div class="modal-title modal_judul_issues_detail_status"></div>
                &nbsp;
                <div class="modal-title modal_qr_code_issues_detail">

                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body" style="margin-bottom: -30px; margin-top: -20px;">

                {{ csrf_field() }}
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-xl-3">
                                <!-- <div class="card"> -->
                                <!-- <div class="card-body"> -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mt-4 mt-xl-0">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Username SAP :</label>
                                                <input type="text" readonly name="username_sap_issues_detail" id="username_sap_issues_detail" class="form-control" >
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Telp/Ext :</label>
                                                <input type="text" readonly name="telp_issues_detail" id="telp_issues_detail" class="form-control" placeholder="Ex: 08xxxxxxxxx">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Nomor Whatsapp <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover focus" data-bs-content="No Whatsapp diperuntukan untuk kebutuhan informasi jika isu sudah terselesaikan"><i class="fas fa-exclamation"></i></button> :</label>
                                                <input type="text" readonly name="no_wa_detail" id="no_wa_detail" class="form-control" placeholder="Ex: 08xxxxxxxxx">
                                            </div>

                                            @php
                                            if($user_app['role'] == "R001"){
                                            @endphp
                                            <div class="mb-3">
                                                <label class="form-label" for="full-name">Kategori :</label>
                                                <div class="form-control-wrap">
                                                    <select name="kategori_id_edit" id="kategori_id_edit">
                                                        <option value=""></option>
                                                        @foreach($m_kategori as $data)
                                                        <option value="{{$data->id}}">{{$data->nama_kategori}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="full-name">Pilih Layanan :</label>
                                                <div class="form-control-wrap">
                                                    <select name="layanan_id_edit" id="layanan_id_edit">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3" id="div_subject_helpdesk_edit">
                                                <label class="form-label" for="full-name">Subject Helpdesk :</label>
                                                <div class="input-group">
                                                    <div class="form-control-wrap" style="width: 70%">
                                                        <select name="subject_id_edit" id="subject_id_edit">
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                    <button style="width: 12%; margin-top:-1px !important; background-color:mediumslateblue; color:white" type="submit" id="button_subject_id_update" name="button_subject_id_update" class="btn btn-md m-1"><i class="mdi mdi-pencil"></i></button>
                                                    <button style="width: 12%; margin-top:-1px !important; background-color:mediumturquoise; color:white" type="submit" id="button_subject_id_refresh_kembali" name="button_subject_id_refresh_kembali" class="btn btn-md m-1"><i class="mdi mdi-replay"></i></button>
                                                </div>
                                            </div>
                                            <div class="mb-3" id="div_subject_simasiti_edit">
                                                <label class="form-label" for="full-name">Subject Helpdesk : <span id="jumlah_data_simasti">coba</span> </label>
                                                <input type="text" readonly name="subject_nama_detail" id="subject_nama_detail" class="form-control" >
                                            </div>
                                            @php
                                            } else {
                                            @endphp
                                            <div class="mb-3">
                                                <label class="form-label" for="full-name">Kategori :</label>
                                                <input type="text" readonly name="kategori_nama_detail" id="kategori_nama_detail" class="form-control" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="full-name">Pilih Layanan :</label>
                                                <input type="text" readonly name="layanan_nama_detail" id="layanan_nama_detail" class="form-control" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="full-name">Subject Helpdesk : <span id="jumlah_data_simasti">coba</span> </label>
                                                <input type="text" readonly name="subject_nama_detail" id="subject_nama_detail" class="form-control" >
                                            </div>
                                            @php
                                            }
                                            @endphp

                                            @php
                                            if($user_app['role'] == "R001"){
                                            @endphp
                                            <div class="mb-3">
                                                <label class="form-label" for="full-name">Priority : <span class="append_html_priority_batas_mengganti" style="font-size: 12px">  ( kesempatan mengganti 1 x )</span></label>
                                                <div class="input-group">
                                                    <div class="form-control-wrap" style="width: 70%">
                                                        <select name="priority_id_update" id="priority_id_update">
                                                            <option value=""></option>
                                                            @foreach($m_priority as $data)
                                                            <option id="{{$data->id}}" value="{{$data->id}}">{{$data->nama_priority}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button style="width: 12%; margin-top:-1px !important; background-color:mediumslateblue; color:white" type="submit" id="button_priority_id_update" name="button_priority_id_update" class="btn btn-md m-1"><i class="mdi mdi-pencil"></i></button>
                                                    <button style="width: 12%; margin-top:-1px !important; background-color:mediumturquoise; color:white" type="submit" id="button_priority_id_refresh_kembali" name="button_priority_id_refresh_kembali" class="btn btn-md m-1"><i class="mdi mdi-replay"></i></button>
                                                </div>
                                            </div>
                                            @php
                                            }else{
                                            @endphp
                                            <div class="mb-3">
                                                <label class="form-label" for="full-name">Priority :</label>
                                                <input type="text" readonly name="priority_nama_detail" id="priority_nama_detail" class="form-control" >
                                            </div>
                                            @php
                                            }
                                            @endphp

                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Due Date Probability :</label>
                                                <input type="text" readonly name="perkiraan_selesai_y_m_d_detail" id="perkiraan_selesai_y_m_d_detail" class="form-control" placeholder="Perkiraan selesai" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Status :</label>
                                                <!-- <button type="button" class="btn btn-danger info_status_detail" id="info_status_detail"><i class="mdi mdi-alert-circle-outline"></i></button> -->
                                                <br>

                                                <div class="div_visible_invisible_status_semua_1">
                                                    <h5> Tike Isu berstatus On Hold ( Silahkan Hubungi Admin Helpdesk ) </h5>
                                                </div>

                                                <div class="div_visible_invisible_status_semua_2">
                                                    @if($user_app['role'] == "R001")
                                                    <button type="submit" id="status_open" name="status_open" class="btn btn-md btn-warning m-1 status_change" data-status_change="status_open">Change Open</button>
                                                    <button type="submit" id="status_progress" name="status_progress" class="btn btn-md btn-info m-1 status_change" data-status_change="status_progress">Change Progress</button>
                                                    <button type="submit" id="status_on_hold" name="status_on_hold" class="btn btn-md btn-danger m-1 status_change" data-status_change="status_on_hold">Change On Hold</button>
                                                    <button type="submit" id="status_done" name="status_done" class="btn btn-md btn-success m-1 status_change" data-status_change="status_done">Change Done</button>
                                                    <button type="submit" id="status_closed" name="status_closed" class="btn btn-md btn-primary m-1 status_change" data-status_change="status_closed">Change Closed</button>
                                                    @elseif($user_app['role'] == "R003")

                                                    @if($user_app['unitId'] == "PBD200")
                                                    <button type="submit" id="status_open" name="status_open" class="btn btn-md btn-warning m-1 status_change" data-status_change="status_open">Change Open</button>
                                                    <button type="submit" id="status_progress" name="status_progress" class="btn btn-md btn-info m-1 status_change" data-status_change="status_progress">Change Progress</button>
                                                    <button type="submit" id="status_on_hold" name="status_on_hold" class="btn btn-md btn-danger m-1 status_change" data-status_change="status_on_hold">Change On Hold</button>
                                                    <button type="submit" id="status_done" name="status_done" class="btn btn-md btn-success m-1 status_change" data-status_change="status_done">Change Done</button>
                                                    <button type="submit" id="status_closed" name="status_closed" class="btn btn-md btn-primary m-1 status_change" data-status_change="status_closed">Change Closed</button>
                                                    @else
                                                    <!-- <button type="submit" id="status_open" name="status_open" class="btn btn-md btn-warning m-1 status_change" data-status_change="status_open">Change Open</button> -->
                                                    <!-- <button type="submit" id="status_progress" name="status_progress" class="btn btn-md btn-info m-1 status_change" data-status_change="status_progress">Change Progress</button> -->
                                                    <button type="submit" id="status_closed" name="status_closed" class="btn btn-md btn-primary m-1 status_change" data-status_change="status_closed">Change Closed</button>
                                                    <!-- <button type="submit" id="status_done" name="status_done" class="btn btn-md btn-success m-1 status_change" data-status_change="status_done">Change Done</button> -->
                                                    @endif


                                                    @elseif($user_app['role'] == "R004")
                                                    <button type="submit" id="status_open" name="status_open" class="btn btn-md btn-warning m-1 status_change" data-status_change="status_open">Change Open</button>
                                                    <button type="submit" id="status_progress" name="status_progress" class="btn btn-md btn-info m-1 status_change" data-status_change="status_progress">Change Progress</button>
                                                    <button type="submit" id="status_closed" name="status_closed" class="btn btn-md btn-primary m-1 status_change" data-status_change="status_closed">Change Closed</button>
                                                    <!-- <button type="submit" id="status_done" name="status_done" class="btn btn-md btn-success m-1 status_change" data-status_change="status_done">Change Done</button> -->
                                                    @elseif($user_app['role'] == "R005")
                                                    <button type="submit" id="status_open" name="status_open" class="btn btn-md btn-warning m-1 status_change" data-status_change="status_open">Change Open</button>
                                                    <button type="submit" id="status_progress" name="status_progress" class="btn btn-md btn-info m-1 status_change" data-status_change="status_progress">Change Progress</button>
                                                    <button type="submit" id="status_done" name="status_done" class="btn btn-md btn-success m-1 status_change" data-status_change="status_done">Change Done</button>
                                                    <button type="submit" id="status_closed" name="status_closed" class="btn btn-md btn-primary m-1 status_change" data-status_change="status_closed">Change Closed</button>
                                                    @else
                                                    <button type="submit" id="status_open" name="status_open" class="btn btn-md btn-warning m-1 status_change" data-status_change="status_open">Change Open</button>
                                                    <button type="submit" id="status_progress" name="status_progress" class="btn btn-md btn-info m-1 status_change" data-status_change="status_progress">Change Progress</button>
                                                    <button type="submit" id="status_done" name="status_done" class="btn btn-md btn-success m-1 status_change" data-status_change="status_done">Change Done</button>
                                                    <button type="submit" id="status_closed" name="status_closed" class="btn btn-md btn-primary m-1 status_change" data-status_change="status_closed">Change Closed</button>
                                                    @endif
                                                </div>



                                                <!-- <button type="submit" id="status_close" namme="status_close" class="btn btn-md btn-secondary m-1 status_change" data-status_change="status_close">Change Close</button> -->
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

                            <div class="col-xl-5">
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

                                                <div name="description_issues_detail" id="description_issues_detail" class="description_issues_detail" style="height: 452px; max-height: 512px;">

                                                </div>
                                                <!-- <div id="editor">This is some sample content.</div> -->
                                                <!-- end Snow-editor-->
                                                <!-- </div>  -->
                                                <!-- end card-body-->
                                                <!-- </div>  -->
                                                <!-- end card-->
                                            </div>

                                            @php
                                                $visibility_div_incident = '';
                                                if ($user_app['role'] == "R001") {
                                                    $visibility_div_incident = '';
                                            @endphp
                                            @php
                                                } else {
                                                    $visibility_div_incident = "style='visibility: hidden;'";
                                            @endphp
                                            @php
                                                }
                                            @endphp

                                            <div <?php echo $visibility_div_incident; ?>>
                                                <div class="form-check" style="font-size: 14px;">
                                                    <input class="form-check-input" type="checkbox" value="Security Incident" id="security_incident_detail" name="security_incident">
                                                    <label class="form-check-label" >
                                                        Security Incident
                                                    </label>
                                                </div>
                                                <div class="form-check" style="font-size: 14px;">
                                                    <input class="form-check-input" type="checkbox" value="Major Incident" id="major_incident_detail" name="major_incident" >
                                                    <label class="form-check-label" >
                                                        Major Incident
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Attachment File :</label>
                                                @if($user_app['role'] == "R001")
                                                <button type="button" id="tambah_file_issues_modal" name="tambah_file_issues_modal" class="btn btn-md btn-success m-1 tambah_file_issues_modal float-right"><i class="mdi mdi-plus"></i></button>
                                                @else
                                                @endif

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="mt-4 mt-xl-0 append_div_file_detail" style="height: 132px; overflow-y: auto;">
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
                                                        <!-- <input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" > -->
                                                        <!-- <input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" > -->
                                                        <table class='table' id='tb_detail_status' style='width: 100%;'>
                                                            <thead>
                                                                <tr style="display: none;">
                                                                    <!-- <th style="width: 1px !important;">No</th>
                                                                    <th style="width: 10% !important;">Status</th>
                                                                    <th style="width: 48% !important;">Catatan</th>
                                                                    <th style="width: 20% !important;">Created By</th>
                                                                    <th style="width: 20% !important;">Created At</th> -->
                                                                    <th style="min-width: 100px !important;">No</th>
                                                                    <th style="min-width: 100px !important;">Status</th>
                                                                    <th style="min-width: 100px !important;">Catatan</th>
                                                                    <th style="min-width: 100px !important;">Created By</th>
                                                                    <th style="min-width: 100px !important;">Created At</th>
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

                            <div class="col-xl-4">
                                <!-- <div class="card"> -->
                                <!-- <div class="card-body"> -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mt-4 mt-xl-0">
                                            <div class="mb-3 float-right">
                                                <form action="javascript:;" class="form-validate is-alter formKirimKomentarIssues" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <label class="form-label" for="formrow-firstname-input">Comment : </label>
                                                    <div name="komentar_issues_detail" id="komentar_issues_detail" class="komentar_issues_detail" style="height: 404px; max-height: 404px;">

                                                    </div>
                                                    <!-- <br> -->
                                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-top: 10px; margin-bottom: -14px">
                                                        <button type="submit" id="send_comment" namme="send_comment" class="btn btn-md btn-primary float-right">SEND</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="mb-3">
                                                <!-- <label class="form-label" for="formrow-firstname-input">Telp/Ext :</label> -->
                                                <!-- <input type="text" readonly name="telp_issues_detail" id="telp_issues_detail" class="form-control" > -->
                                                <div class="card">
                                                    <table class="table" id="tb_komentar" style="width: 100%;">
                                                        <thead>
                                                            <tr style="display: none;">
                                                                <th style="width: 20% !important;">Photo</th>
                                                                <th style="width: 80% !important;">Komentar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                            <!-- <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Status :</label>
                                                    <input type="text" readonly name="perkiraan_selesai_y_m_d_detail" id="perkiraan_selesai_y_m_d_detail" class="form-control" placeholder="perkiraan selesai" readonly>
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
            <!-- <div class="modal-footer bg-light"> -->
            <!-- <span class="sub-text">Modal Footer Text</span> -->
            <!-- <button type="button" id="tambah" namme="tambah" class="btn btn-md btn-primary">Simpan</button> -->
            <!-- <button type="submit" class="btn btn-md btn-primary">Simpan</button> -->
            <!-- <button type="submit" class="btn bg-pink-a400 text-white mr-1"><i class="md md-floppy"></i> Simpan</button> -->
            <!-- </div> -->
        </div>
    </div>

</div>

<div class="modal fade" id="modalIssuesForward" data-bs-focus="false" style="font-size: 14pt">
    <form action="javascript:;" class="form-validate is-alter formIssuesForward" enctype="multipart/form-data" name="formIssuesForward" id="formIssuesForward">
        <div class="modal-dialog modal-dialog-top modal-md" role="document" style="max-width: 80%; margin-bottom: -5px;">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title modal_judul_issues_detail_forward">Forward Issues</h5>
                    </div>
                    &nbsp;
                    <div class="modal-title"></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">

                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-body">

                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="row">

                                            <?php

                                            $jumlah = count($array_pegawai);
                                            // echo $jumlah % ($jumlah / 2);
                                            $i = 0;

                                            ?>

                                            <div class="col-xl-6">
                                                <div class="row">
                                                    <?php
                                                    // $session_username = Session::get('user_app')['username'];
                                                    // $session_role = Session::get('user_app')['role'];
                                                    for ($i; $i < round($jumlah / 2); $i++) {
                                                        // $disabled_enabled = '';
                                                        // if ($session_role == "R003") {
                                                        //     if ($array_pegawai[$i]['pegawai_nik'] == $session_username) {
                                                        //         $disabled_enabled = "";
                                                        //     } else {
                                                        //         $disabled_enabled = "disabled";
                                                        //     }
                                                        // } else {
                                                        // }



                                                    ?>

                                                        <div class="col-lg-12">
                                                            <div class="mt-4 mt-xl-0">
                                                                <div class="mb-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input <?php echo is_null($array_pegawai) || $array_pegawai == 0  ? '' : $array_pegawai[$i]['pegawai_nik']; ?>" type="checkbox" value="<?php echo is_null($array_pegawai) || $array_pegawai == 0  ? '' : $array_pegawai[$i]['pegawai_nik']; ?>" id="pegawai_it_nik" name="pegawai_it_nik[]">
                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                            <?php echo is_null($array_pegawai) || $array_pegawai == 0  ? '' : $array_pegawai[$i]['pegawai_nama']; ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }

                                                    ?>

                                                    @if($user_app['role'] == 'R001')

                                                    <div class="col-lg-12">
                                                        <div class="mt-4 mt-xl-0">
                                                            <div class="mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input tiket_cares_chekbox" type="checkbox" id="pegawai_it_nik" name="pegawai_it_nik[]">
                                                                    <label class="form-check-label" for="flexCheckDefault">
                                                                        Tiket Cares PI
                                                                        <div class="tiket_cares_display" style="display: none;">
                                                                            <small style="font-size: 8pt; display:block; margin-top:-2px;">
                                                                                Masukan Nomor Cares PI :
                                                                            </small>
                                                                            <input type="text" class="form-control tiket_cares" id="tiket_cares" name="tiket_cares">
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @endif

                                                </div>
                                            </div>

                                            <?php

                                            // $jumlah = 14;
                                            // echo $jumlah % 7;
                                            // $j = 0;
                                            // echo $jumlah % 7;
                                            ?>

                                            <div class="col-xl-5">
                                                <div class="row">
                                                    <?php
                                                    for ($i; $i < $jumlah; $i++) {
                                                    ?>

                                                        <div class="col-lg-12">
                                                            <div class="mt-4 mt-xl-0">
                                                                <div class="mb-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input <?php echo is_null($array_pegawai) || $array_pegawai == 0  ? '' : $array_pegawai[$i]['pegawai_nik']; ?>" type="checkbox" value="<?php echo is_null($array_pegawai) || $array_pegawai == 0  ? '' : $array_pegawai[$i]['pegawai_nik']; ?>" id="pegawai_it_nik" name="pegawai_it_nik[]">
                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                            <?php echo is_null($array_pegawai) || $array_pegawai == 0  ? '' : $array_pegawai[$i]['pegawai_nama']; ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }

                                                    ?>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="col-xl-6" style="overflow-y:scroll; max-height: 300px">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="main-timeline7" id="append_riwayat_forward_issues">
                                                        <div class="timeline">
                                                            <div class="timeline-icon"><i class="fa fa-globe"></i></div>
                                                            <span class="year">2018</span>
                                                            <div class="timeline-content">
                                                                <h5 class="title">Web Desginer</h5>
                                                                <p class="description">
                                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum mattis felis vitae risus pulvinar tincidunt. Nam ac venenatis enim. Aenean hendrerit justo sed.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="timeline">
                                                            <div class="timeline-icon"><i class="fa fa-globe"></i></div>
                                                            <span class="year">2018</span>
                                                            <div class="timeline-content">
                                                                <h5 class="title">Web Desginer</h5>
                                                                <p class="description">
                                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum mattis felis vitae risus pulvinar tincidunt. Nam ac venenatis enim. Aenean hendrerit justo sed.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="timeline">
                                                            <div class="timeline-icon"><i class="fa fa-rocket"></i></div>
                                                            <span class="year">2017</span>
                                                            <div class="timeline-content">
                                                                <h5 class="title">Web Developer</h5>
                                                                <p class="description">
                                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum mattis felis vitae risus pulvinar tincidunt. Nam ac venenatis enim. Aenean hendrerit justo sed.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="timeline">
                                                            <div class="timeline-icon"><i class="fa fa-briefcase"></i></div>
                                                            <span class="year">2016</span>
                                                            <div class="timeline-content">
                                                                <h5 class="title">Web Desginer</h5>
                                                                <p class="description">
                                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum mattis felis vitae risus pulvinar tincidunt. Nam ac venenatis enim. Aenean hendrerit justo sed.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="timeline">
                                                            <div class="timeline-icon"><i class="fa fa-mobile"></i></div>
                                                            <span class="year">2015</span>
                                                            <div class="timeline-content">
                                                                <h5 class="title">Web Developer</h5>
                                                                <p class="description">
                                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum mattis felis vitae risus pulvinar tincidunt. Nam ac venenatis enim. Aenean hendrerit justo sed.
                                                                </p>
                                                            </div>
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
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <!-- <button type="button" id="tambah" namme="tambah" class="btn btn-md btn-primary">Simpan</button> -->
                    <!-- <button type="button" id="forward_issues_simpan" name="forward_issues_simpan" class="btn btn-md btn-primary forward_issues_simpan">Simpan</button> -->
                    <button type="submit" class="btn btn-md btn-primary forward_issues_simpan">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modalScanQRCodeTiketIssues">
    <div class="modal-dialog modal-dialog-top modal-md" style="min-width: 35%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <video id="camera" style="width: 100%"></video>
                    <div id="qrcode"></div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <!-- <span class="sub-text">Modal Footer Text</span> -->
                <button type="button" id="kembali" namme="kembali" class="btn btn-md btn-secondary">Kembali</button>
                <button type="button" id="kamera_depan" namme="kamera_depan" class="btn btn-md btn-success">Kamera Depan</button>
                <button type="button" id="kamera_belakang" namme="kamera_belakang" class="btn btn-md btn-primary">Kamera Belakang</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalScanQRCodeTiketIssues_2">
    <div class="modal-dialog modal-dialog-top modal-md" style="min-width: 35%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <video id="camera_2"></video>
                    <div id="qrcode_2"></div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <!-- <span class="sub-text">Modal Footer Text</span> -->
                <button type="button" id="kembali_2" namme="kembali_2" class="btn btn-md btn-primary">kembali</button>
                <button type="button" id="kamera_depan_2" namme="kamera_depan_2" class="btn btn-md btn-primary">Kamera Depan</button>
                <button type="button" id="kamera_belakang_2" namme="kamera_belakang_2" class="btn btn-md btn-primary">Kamera Belakang</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalScanQRCodeTiketIssues_3">
    <div class="modal-dialog modal-dialog-top modal-md" style="min-width: 35%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <video id="camera_3"></video>
                    <div id="qrcode_3"></div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <!-- <span class="sub-text">Modal Footer Text</span> -->
                <button type="button" id="kembali_3" namme="kembali_3" class="btn btn-md btn-primary">kembali</button>
                <button type="button" id="kamera_depan_3" namme="kamera_depan_3" class="btn btn-md btn-primary">Kamera Depan</button>
                <button type="button" id="kamera_belakang_3" namme="kamera_belakang_3" class="btn btn-md btn-primary">Kamera Belakang</button>
            </div>
        </div>
    </div>
</div>


<!-- <div class="modal fade" id="modalTandaTanganStaff">
    <div class="modal-dialog modal-dialog-top modal-xl" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">description Issues</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{ csrf_field() }}
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mt-4 mt-xl-0">

                                            <div class="mb-3">
                                                <label class="form-label" for="full-name">Description :</label>

                                                <div name="tanda_tangan_html_append" id="tanda_tangan_html_append" class="tanda_tangan_html_append" style="height: 310px;">

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
    </div>
</div> -->

<div class="modal" id="modalTandaTanganStaff" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">2nd Modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                Content for the dialog / modal goes here.
                Content for the dialog / modal goes here.
                Content for the dialog / modal goes here.
                Content for the dialog / modal goes here.
                Content for the dialog / modal goes here.
            </div>
            <div class="modal-footer">
                <a href="#" data-dismiss="modal" class="btn">Close</a>
                <a href="#" class="btn btn-primary">Save changes</a>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script>
    $(document).ready(function() {

        // document.getElementById("body_overflow").style.overflow = "hidden";

        $('.tab_tabel_issues').click(function() {
            $('#tb_issues').DataTable().ajax.reload(null, false);
            $('#tb_issues').DataTable().fixedHeader.enable();
            $('#tb_issues_unit_kerja').DataTable().fixedHeader.disable();
            $('#tb_issues_forward').DataTable().fixedHeader.disable();
        });

        $('.tab_tabel_issues_unit_kerja').click(function() {
            $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
            $('#tb_issues_unit_kerja').DataTable().fixedHeader.enable();
            $('#tb_issues').DataTable().fixedHeader.disable();
            $('#tb_issues_forward').DataTable().fixedHeader.disable();
        });

        $('.tab_tabel_issues_forward').click(function() {
            $('#tb_issues_forward').DataTable().ajax.reload(null, false);
            $('#tb_issues_forward').DataTable().fixedHeader.enable();
            $('#tb_issues').DataTable().fixedHeader.disable();
            $('#tb_issues_unit_kerja').DataTable().fixedHeader.disable();
        });
    });
</script>

<script>
    $(document).ready(function() {

        $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
            // console.log(message);
        };

    });
</script>

<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            html: true
        })
    })
</script>

<script>
    var quill_description_issues;
    $(document).ready(function() {

        quill_description_issues = new Quill("#description_issues", {
            theme: "snow",
            imageResize: {
                displaySize: true
            },
            modules: {
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: "super"
                    }, {
                        script: "sub"
                    }],
                    [{
                        header: [!1, 1, 2, 3, 4, 5, 6]
                    }, "blockquote", "code-block"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }, {
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }],
                    ["direction", {
                        align: []
                    }],
                    ["link", "image", "video"],
                    ["clean"],
                ]
            }
        })
        var editor_content = "";
        // $('#description_issues').on('keyup', function() {
        $(document).on('keyup', '#description_issues', function(e) {
            // console.log('coba');
            // alert('key up');
            // return false;
            // var get_description_issues = $('#description_issues').html();
            // // const sanitizer = new Sanitizer();
            // var get_description_issues_split = get_description_issues.replace(/<font[^>]*>/g,'<p>').replace(/<\/font>/g,'</p>');
            editor_content = quill_description_issues.root.innerHTML
            editor_content = editor_content.replace(/\s/g, '');
            // editor_content = editor_content.replace('<br>', '');
            // editor_content = editor_content.replace('<p>', '');
            // editor_content = editor_content.replace('</p>', '');
            editor_content = editor_content.replace(/<[^>]*>?/gm, '')
            // console.log(editor_content.length);
            $("#description_issues_lenght").html(editor_content.length);
            if (editor_content.length <= 1000) {
                $("#description_issues_lenght").css("background-color", "#00FF00");
            } else {
                $("#description_issues_lenght").css("background-color", "#FF0000");
            }

        });

    });
</script>

<script>
    $(document).ready(function() {

        var quill_komentar_issues_detail = new Quill("#komentar_issues_detail", {
            theme: "snow",
            modules: {
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: "super"
                    }, {
                        script: "sub"
                    }],
                    [{
                        header: [!1, 1, 2, 3, 4, 5, 6]
                    }, "blockquote", "code-block"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }, {
                        indent: "-1"
                    }, {
                        indent: "+1"
                    }],
                    ["direction", {
                        align: []
                    }],
                    ["link", "image", "video"],
                    ["clean"]
                ]
            }
        })

    });
</script>

<script>
    $(document).ready(function() {

        $('#buttonModalFormTambahIssues').on('click', function() {

            // var tanggal_sekarang = moment("02/09/2022", "DD/MM/YYYY").day();
            // var time = moment('13:00:00', 'h:mm:ss');

            // var tanggal_sekarang = moment("29/08/2022", "DD/MM/YYYY").day();
            // var time = moment('06:59:59', 'h:mm:ss');

            // var tanggal_sekarang = moment("05/09/2022", "DD/MM/YYYY").day();
            // var time = moment('07:00:01', 'h:mm:ss');
            $("#priority_id").select2("destroy");

            $("#priority_id").select2({
                theme: "bootstrap-5",
                placeholder: "Pilih Priority",
                dropdownParent: $('#modalFormTambahIssues'),
            });

            var tanggal_sekarang = moment().day();
            var time = moment().format('h:mm:ss');

            // console.log('coba coba sekarang 2 = ' + tanggal_sekarang);

            var enabled_disabled = '';

            if (tanggal_sekarang == 5) {

                var beforeTime = moment('17:00:00', 'h:mm:ss');
                var afterTime = moment('23:59:59', 'h:mm:ss');

                if (time.isBetween(beforeTime, afterTime)) {
                    // // console.log('is between');
                    enabled_disabled = 'disabled';
                } else {
                    // // console.log('is not between');
                    enabled_disabled = 'enabled';
                }

            } else if (tanggal_sekarang == 6) {

                enabled_disabled = 'disabled';

            } else if (tanggal_sekarang == 0) {

                enabled_disabled = 'disabled';

            } else if (tanggal_sekarang == 1) {

                var beforeTime = moment('00:00:01', 'h:mm:ss');
                var afterTime = moment('07:00:00', 'h:mm:ss');

                if (time.isBetween(beforeTime, afterTime)) {
                    // // console.log('is between');\
                    enabled_disabled = 'disabled';
                } else {
                    // // console.log('is not between');
                    enabled_disabled = 'enabled';
                }

            } else {
                enabled_disabled = 'enabled';
            }

            // console.log(enabled_disabled);

            $('#P001').prop(enabled_disabled, !$('#P001').prop(enabled_disabled));
            $('#P002').prop(enabled_disabled, !$('#P002').prop(enabled_disabled));
        });

    });
</script>

<script>
    $(document).ready(function() {
        $("#kategori_id").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Kategori",
            dropdownParent: $('#modalFormTambahIssues'),
        });
    });

    $(document).ready(function() {
        $("#kategori_id_edit").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Kategori",
            dropdownParent: $('#modalIssuesDetail'),
        });
    });

    $(document).ready(function() {
        $("#layanan_id").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Layanan",
            dropdownParent: $('#modalFormTambahIssues'),
        });
    });

    $(document).ready(function() {
        $("#layanan_id_edit").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Layanan",
            dropdownParent: $('#modalIssuesDetail'),
        });
    });

    $(document).ready(function() {
        $("#subject_id").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Subject Helpdesk",
            dropdownParent: $('#modalFormTambahIssues'),
        });
    });

    $(document).ready(function() {
        $("#subject_id_edit").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Subject Helpdesk",
            dropdownParent: $('#modalIssuesDetail'),
        });
    });

    // $(document).ready(function() {
    //     $("#subject_id_2").select2({
    //         theme: "bootstrap-5",
    //         placeholder: "Pilih Subject",
    //         dropdownParent: $('#modalFormTambahIssues'),
    //     });
    // });

    $(document).ready(function() {
        $("#priority_id").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Priority",
            dropdownParent: $('#modalFormTambahIssues'),
        });
    });

    $(document).ready(function() {
        $("#priority_id_update").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Priority",
            dropdownParent: $('#modalIssuesDetail'),
        });
    });

    $(document).ready(function() {
        $(".username_sap_issues_select2").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Pegawai",
            dropdownParent: $('#modalFormTambahIssues'),
            // minimumInputLength: 2,
            // allowClear: true,
            temlateResult: format,
            templateSelection: formatSelection,
            ajax: {
                url: "{{url('issues/getPegawaiSemuaSelect2')}}",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    // Query parameters will be ?search=[term]&type=public
                    // console.log(query);
                    return query;
                },
                cache: true,
                delay: 250,
                processResults: function(data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    // console.log(data);
                    return {
                        results: data.results,
                        pagination: {
                            more: data.results_count
                        },
                    };
                }
            },

        });

        function format(repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").text(repo.text);

            return $container;
        }

        function formatSelection(repo) {
            return repo.text;
        }
    });
</script>

<script>
    $(document).ready(function() {

        $('#kategori_id').on("select2:select", function(e) {
            // what you would like to happen
            // // console.log(e);
            // $("#eselon_id_selected_input").val(eselon_id).select2();
            var kategori_id = $("#kategori_id option:selected").val();
            // // console.log(value);
            $("#subject_helpdesk").css("display", "block");
            $("#subject_simasti").css("display", "none");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getListLayanan')}}" + '/' + kategori_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    // console.log(data.data);

                    // $('#layanan_id').select2({data: [{id: '', text: ''}]});
                    $("#subject_id").empty();
                    $("#subject_id_2").empty();
                    $("#layanan_id").empty().append(data.data);

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });

        });
    });
</script>

<script>
    $(document).ready(function() {

        $('#layanan_id').on("select2:select", function(e) {
            // what you would like to happen
            // // console.log(e);
            // $("#eselon_id_selected_input").val(eselon_id).select2();
            $("#subject_id_2").empty();
            var layanan_id = $("#layanan_id option:selected").val();
            // console.log('layanan_id ' + layanan_id);

            if (layanan_id == 'L042') {
                // console.log('layanan_id_2 ' + layanan_id);
                $("#subject_helpdesk").css("display", "none");
                $("#subject_simasti").css("display", "block");

                $(".subject_id_2").select2({
                    theme: "bootstrap-5",
                    placeholder: "Pilih Subject Simasti",
                    dropdownParent: $('#modalFormTambahIssues'),
                    // minimumInputLength: 2,
                    // allowClear: true,
                    temlateResult: format_2,
                    // tags: true,
                    // multiple: true,
                    allowClear: false,
                    templateSelection: formatSelection_2,
                    ajax: {
                        url: "{{url('api/getListDataAssetSimasti')}}",
                        dataType: 'json',
                        data: function(params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1
                            }
                            // Query parameters will be ?search=[term]&type=public
                            // console.log(query);
                            return query;
                        },
                        cache: true,
                        delay: 250,
                        processResults: function(data) {
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            // console.log(data);
                            return {
                                results: data.results,
                                pagination: {
                                    more: data.results_count
                                },
                            };
                        }
                    },
                    createTag: function(params) {
                        var term = $.trim(params.term);

                        if (term === '') {
                            return null;
                        }

                        return {
                            id: term,
                            text: term,
                            newTag: true // add additional parameters
                        }

                        // console.log(term);
                    }

                });

                function format_2(repo) {
                    if (repo.loading) {
                        return repo.text;
                    }

                    var $container = $(
                        "<div class='select2-result-repository clearfix'>" +
                        "<div class='select2-result-repository__title'></div>" +
                        "</div>"
                    );

                    $container.find(".select2-result-repository__title").text(repo.text);

                    return $container;
                }

                function formatSelection_2(repo) {
                    return repo.text;
                }

            } else {
                // console.log('layanan_id ' + layanan_id);
                $("#subject_helpdesk").css("display", "block");
                $("#subject_simasti").css("display", "none");

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#formTambahIssues').serialize(),
                    url: "{{url('issues/getListSubject')}}" + '/' + layanan_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data.data);

                        // $('#layanan_id').select2({data: [{id: '', text: ''}]});

                        $("#subject_id").empty().append(data.data);

                    },
                    error: function(data) {
                        // console.log('Error:', data);
                        //$('#modalPenghargaan').modal('show');
                    }
                });

            }



        });
    });
</script>

<script>
    $(document).ready(function() {

        // var tanggal_sekarang = moment("02/09/2022", "DD/MM/YYYY").day();
        // var time = moment('17:00:01', 'h:mm:ss');

        // var tanggal_sekarang = moment("29/08/2022", "DD/MM/YYYY").day();
        // var time = moment('06:59:59', 'h:mm:ss');

        // var tanggal_sekarang = moment("29/08/2022", "DD/MM/YYYY").day();
        // var time = moment('07:00:01', 'h:mm:ss');

        // var tanggal_sekarang = moment().day();
        // var time = moment().format('h:mm:ss');

        // // console.log('coba coba sekarang 2 = ' + tanggal_sekarang);

        // var enabled_disabled = '';

        // if (tanggal_sekarang == 5) {

        //     var beforeTime = moment('17:00:00', 'h:mm:ss');
        //     var afterTime = moment('23:59:59', 'h:mm:ss');

        //     if (time.isBetween(beforeTime, afterTime)) {
        //         // // console.log('is between');
        //         enabled_disabled = 'disabled';
        //     } else {
        //         // // console.log('is not between');
        //         enabled_disabled = 'enabled';
        //     }

        // } else if (tanggal_sekarang == 6) {

        //     enabled_disabled = 'disabled';

        // } else if (tanggal_sekarang == 0) {

        //     enabled_disabled = 'disabled';

        // } else if (tanggal_sekarang == 1) {

        //     var beforeTime = moment('00:00:01', 'h:mm:ss');
        //     var afterTime = moment('07:00:00', 'h:mm:ss');

        //     if (time.isBetween(beforeTime, afterTime)) {
        //         // // console.log('is between');\
        //         enabled_disabled = 'disabled';
        //     } else {
        //         // // console.log('is not between');
        //         enabled_disabled = 'enabled';
        //     }

        // } else {
        //     enabled_disabled = 'enabled';
        // }

        // // console.log(enabled_disabled);

        // $('#P001').prop(enabled_disabled, !$('#P001').prop(enabled_disabled));
        // $('#P002').prop(enabled_disabled, !$('#P002').prop(enabled_disabled));


        $('#priority_id').on("select2:select", function(e) {
            // what you would like to happen
            // // console.log(e);
            // $("#eselon_id_selected_input").val(eselon_id).select2();
            // https://javascript.tutorialink.com/calculate-dates-considering-public-holidays-and-weekends-with-moment-js-and-moment-business-days/
            // console.log('ccccccccccccccccccccccccccccccccccccccccccccccccc');
            // var priority_id = $("#priority_id").val();
            // var select_val = $(e.currentTarget).val();
            // var priority_id_coba = $('#priority_id').select2("val");;
            // // console.log(priority_id);
            // // console.log('select_val ========= ' + select_val);
            // // console.log('priority_id_coba ========= ' + priority_id_coba);
            // // console.log(e.params.data.id);

            var priority_id = e.params.data.id;
            $("#priority_id").val(priority_id).trigger('change');

            var perkiraan_selesai;
            var perkiraan_selesai_y_m_d;
            var info_perkiraan_selesai_text;
            let start = "";
            let end = "";

            if (priority_id == "P001") {
                // console.log(1);

                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours'));

                perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);

                var format = 'hh:mm:ss';

                var time = moment();
                // var time = moment('18:30:00', format);
                var jam_berangkat = moment('07:00:00', format);
                var jam_pulang = moment('16:00:00', format);
                // console.log('jam_pulang' + jam_pulang);

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;
                    end = moment(start).businessAdd(4, 'hours');
                    // console.log('end' + moment(end).format("YYYY-MM-DD HH:mm:ss"));

                    if (end > jam_pulang) {
                        // // console.log(end.diff(jam_pulang, "hours"));
                        // // console.log(end.diff(jam_pulang, "seconds"));
                        // console.log('end > jam_pulang');
                        var selisi_end_jam_pulang = end.diff(jam_pulang, "seconds");
                        // console.log('end' + end);
                        // console.log('start' + start);
                        // console.log('selisi_end_jam_pulang' + selisi_end_jam_pulang);
                        end = moment(new Date(
                                new Date().getFullYear(),
                                new Date().getMonth(),
                                new Date().getDate(),
                                7,
                                0,
                                0,
                                0
                            ))
                            .businessAdd(1, 'days')
                            .businessAdd(selisi_end_jam_pulang, 'seconds');

                        // console.log('end 1' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    } else {
                        // console.log('end < jam_pulang');
                        end = end;

                        // console.log('end 2' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    }

                    // // console.log(getSabtuMingguDays(start, end)[1]);

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');
                    end = moment(start).businessAdd(4, 'hours');

                }

                // start = start;
                // // console.log('ini start = ' + start);

                // // console.log('end' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                // // console.log('jam_pulang' + moment(jam_pulang).format("YYYY-MM-DD HH:mm:ss"));


                // // console.log(getSabtuMingguDays(start, end)[0][0]);
                // info_perkiraan_selesai_text = getSabtuMingguDays(start, end)[1];

            } else if (priority_id == "P002") {
                // console.log(2);

                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(8, 'hours'));

                perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);

                var format = 'hh:mm:ss';

                var time = moment();
                // var time = moment('13:30:00', format);
                var jam_berangkat = moment('07:00:00', format);
                var jam_pulang = moment('16:00:00', format);
                // console.log('jam_pulang' + jam_pulang);

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;
                    end = moment(start).businessAdd(8, 'hours');
                    // console.log('end' + moment(end).format("YYYY-MM-DD HH:mm:ss"));

                    if (end > jam_pulang) {
                        // // console.log(end.diff(jam_pulang, "hours"));
                        // // console.log(end.diff(jam_pulang, "seconds"));
                        // console.log('end > jam_pulang');
                        var selisi_end_jam_pulang = end.diff(jam_pulang, "seconds");
                        // console.log('end' + end);
                        // console.log('start' + start);
                        // console.log('selisi_end_jam_pulang' + selisi_end_jam_pulang);
                        end = moment(new Date(
                                new Date().getFullYear(),
                                new Date().getMonth(),
                                new Date().getDate(),
                                7,
                                0,
                                0,
                                0
                            ))
                            .businessAdd(1, 'days')
                            .businessAdd(selisi_end_jam_pulang, 'seconds');

                        // console.log('end 1' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    } else {
                        // console.log('end < jam_pulang');
                        end = end;

                        // console.log('end 2' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    }

                    // // console.log(getSabtuMingguDays(start, end)[1]);

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');
                    end = moment(start).businessAdd(8, 'hours');

                }

                // // console.log(getSabtuMingguDays(start, end)[1]);
                // // console.log(getSabtuMingguDays(start, end)[0][0]);
                // info_perkiraan_selesai_text = getSabtuMingguDays(start, end)[1];

            } else if (priority_id == "P003") {
                // console.log(3);
                // // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2)._d);
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days'));
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days').format("YYYY-MM-DD HH:mm:ss"));
                // // console.log(moment('2022-07-15T10:00:00Z', 'YYYY-MM-DD HH:mm:ss').addWorkingTime(5, 'hours'));
                // // console.log(moment().format());
                // $('#perkiraan_selesai').val();
                // perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);
                perkiraan_selesai_y_m_d = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days').format("YYYY-MM-DD HH:mm:ss");

                var format = 'hh:mm:ss';

                var time = moment();
                // var time = moment('17:30:00', format);
                var jam_berangkat = moment('07:00:00', format);
                var jam_pulang = moment('16:00:00', format);
                // console.log('jam_pulang' + jam_pulang);

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');

                    // // console.log(start);
                    // console.log('start' + moment(start).format("YYYY-MM-DD HH:mm:ss"));

                }


                // start = time;
                end = moment(start).businessAdd(2, 'days');

                // console.log(getSabtuMingguDays(start, end)[1]);
                // // console.log(getSabtuMingguDays(start, end)[0][0]);
                // info_perkiraan_selesai_text = getSabtuMingguDays(start, end)[1];

            } else if (priority_id == "P004") {
                // console.log(4);
                // // console.log(moment(moment().format(), 'YYYY-MM-DD HH').businessAdd(7));
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7, 'days'));
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7, 'days').format("YYYY-MM-DD HH:mm:ss"));
                // console.log(moment().isoWeekday());
                // // console.log(moment('2022-07-15T10:00:00Z', 'YYYY-MM-DD HH:mm:ss').addWorkingTime(5, 'hours'));
                // // console.log(moment().format());
                // perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7)._d;
                // perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7, 'days');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);
                perkiraan_selesai_y_m_d = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days').format("YYYY-MM-DD HH:mm:ss");

                var format = 'hh:mm:ss';

                var time = moment();
                // var time = moment('17:30:00', format);
                var jam_berangkat = moment('07:00:00', format);
                var jam_pulang = moment('16:00:00', format);
                // console.log('jam_pulang' + jam_pulang);

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');

                    // // console.log(start);
                    // console.log('start' + moment(start).format("YYYY-MM-DD HH:mm:ss"));

                }


                // start = time;
                end = moment(start).businessAdd(7, 'days');

                // console.log(getSabtuMingguDays(start, end)[1]);
                // // console.log(getSabtuMingguDays(start, end)[0][0]);
                // info_perkiraan_selesai_text = getSabtuMingguDays(start, end)[1];

            }

            // console.log('iki lo bro');
            // var tanggal_awal_ymd = moment().format("YYYY-MM-DD HH:mm:ss");
            var tanggal_awal_ymd = moment(start).format("YYYY-MM-DD HH:mm:ss");
            var tanggal_akhir_ymd = moment(end).format("YYYY-MM-DD HH:mm:ss");
            // console.log(tanggal_awal_ymd);
            // console.log(tanggal_akhir_ymd);
            // // console.log(getLiburNasionalPerTahun());
            // // console.log(getLiburNasionalPerTahun().length);

            // for (var p = 0; p < getLiburNasionalPerTahun().length; p++) {

            // }

            // var perkiraan_selesai_y_m_d_final = getLiburNasionalPerTahun(perkiraan_selesai_y_m_d);
            // // console.log('ini tanggal per tahun ' + getLiburNasionalPerTahun(perkiraan_selesai_y_m_d));
            // var perkiraan_selesai_final = "";
            // var perkiraan_selesai_y_m_d_final = "";
            // console.log('ini apalah itu' + perkiraan_selesai_y_m_d);
            var d = new Date();
            var year = d.getFullYear();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getDataLiburNasionalPerTahunBetween')}}" + '/' + tanggal_awal_ymd + '/' + tanggal_akhir_ymd,
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    var libur_between_1 = data.data.length;

                    // console.log('libur_between_1 = ' + libur_between_1);
                    // console.log('sebelum di tambah libur nasional tahap 1 ' + tanggal_akhir_ymd);
                    var sebelum_di_tambah_libur_nasional_tahap_1 = tanggal_akhir_ymd;
                    tanggal_akhir_ymd = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(libur_between_1, 'days').format("YYYY-MM-DD HH:mm:ss");
                    // console.log('sesudah di tambah libur nasional tahap 1 ' + tanggal_akhir_ymd);
                    // var sesudah_di_tambah_libur_nasional_tahap_1 = tanggal_akhir_ymd;
                    var sebelum_di_tambah_libur_nasional_tahap_1_plus_1 = moment(moment(end).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(1, 'days').format("YYYY-MM-DD HH:mm:ss");
                    var sesudah_di_tambah_libur_nasional_tahap_1_kurang_1 = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(-1, 'days').format("YYYY-MM-DD HH:mm:ss");

                    // console.log('sebelum_di_tambah_libur_nasional_tahap_1_plus_1 ' + sebelum_di_tambah_libur_nasional_tahap_1_plus_1);
                    // console.log('sesudah_di_tambah_libur_nasional_tahap_1_kurang_1 ' + sesudah_di_tambah_libur_nasional_tahap_1_kurang_1);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        // data: $('#formTambahIssues').serialize(),
                        url: "{{url('issues/getDataLiburNasionalPerTahunDistinctTanggal')}}" + '/' + year,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data.data);
                            // // console.log(moment(date1).format(format1));
                            var libur_tanggal_libur_nasional_array = [];
                            // // console.log('perkiraan_selesai_y_m_d_libur_nasional' + perkiraan_selesai_y_m_d_libur_nasional);
                            // console.log('coba' + data.data.length);

                            var hari_libur_next = 0;

                            for (var s = 0; s < 10; s++) {

                                for (var r = 0; r < data.data.length; r++) {
                                    // console.log('tanggal_akhir_ymd ' + tanggal_akhir_ymd);
                                    // console.log('tgl_libur_nasional ' + data.data[r].tgl_libur_nasional);

                                    if (tanggal_akhir_ymd.substr(0, 10) == data.data[r].tgl_libur_nasional) {
                                        // console.log('ini cocok ' + tanggal_akhir_ymd)
                                        // hari_libur_next = hari_libur_next + 1;
                                        // console.log('hari_libur_next ' + hari_libur_next);
                                        // console.log('sebelum di tambah libur nasional tahap 2 ' + tanggal_akhir_ymd);
                                        tanggal_akhir_ymd = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(hari_libur_next + 1, 'days').format("YYYY-MM-DD HH:mm:ss");
                                        // console.log('sesudah di tambah libur nasional tahap 2 ' + tanggal_akhir_ymd);
                                    } else {

                                    }

                                }

                            }

                            // var popover_final = info_perkiraan_selesai_text + '<br> Hari Libur Nasional <br>' + libur_tanggal_libur_nasional_text;
                            var popover_final = "";
                            popover_final += "<div id='calendar'></div>";

                            // $("#perkiraan_selesai").popover({
                            //     title: 'Due Date Info',
                            //     content: popover_final,
                            //     html: true,
                            //     placement: 'left',
                            //     height: 1000,
                            //     width: 6000,
                            //     aspectRatio: 2,
                            //     title: 'User Info <a href="#" class="close" data-dismiss="alert">X</a>',
                            //     windowResize: function(arg) {
                            //         alert('The calendar has adjusted to a window resize. Current view: ' + arg.view.type);
                            //     }
                            // }).popover('show');

                            $(document).on("click", ".popover .close", function() {
                                $(this).parents(".popover").popover('hide');
                            });


                            // console.log('cobaan telo ' + tanggal_akhir_ymd);
                            var sebelum_di_tambah_libur_nasional_tahap_2_plus_1 = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(1, 'days').format("YYYY-MM-DD HH:mm:ss");
                            // console.log('sebelum_di_tambah_libur_nasional_tahap_2_plus_1' + sebelum_di_tambah_libur_nasional_tahap_2_plus_1);


                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                // data: $('#formTambahIssues').serialize(),
                                url: "{{url('issues/getDataLiburNasionalPerTahunBetween')}}" + '/' + sebelum_di_tambah_libur_nasional_tahap_1_plus_1.substr(0, 10) + '/' + sesudah_di_tambah_libur_nasional_tahap_1_kurang_1.substr(0, 10),
                                type: "GET",
                                dataType: 'json',
                                success: function(data) {

                                    // console.log('coba coba coba coba');
                                    // // console.log(data.data);
                                    // console.log(data.data.length);
                                    // var libur_between_2 = data.data.length;
                                    // // console.log('libur_between_1 ' + libur_between_1);
                                    // // console.log('libur_between_2 ' + libur_between_2);
                                    // // console.log('between' = data.data.length);
                                    var libur_between_2 = data.data.length;

                                    var calendarEl = document.getElementById('calendar');
                                    var events = [];

                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        // data: $('#formTambahIssues').serialize(),
                                        url: "{{url('issues/getLiburNasional')}}",
                                        type: "GET",
                                        dataType: 'json',
                                        success: function(data) {

                                            // // console.log(data.data.length);

                                            for (var i = 0; i < data.data.length; i++) {
                                                // console.log(data.data[i].nama_libur_nasional);

                                                events.push({
                                                    id: data.data[i].id,
                                                    title: data.data[i].nama_libur_nasional,
                                                    start: data.data[i].tgl_libur_nasional,
                                                    color: 'red'
                                                }, );
                                            }


                                            // var tanggal_akhir_ymdhms = moment(tanggal_akhir_ymd).format("YYYY-MM-DD HH:mm:ss");
                                            tanggal_akhir_ymd = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(libur_between_2, 'days').format("YYYY-MM-DD HH:mm:ss");

                                            // // console.log('tanggal_awal_ymdhms ' + tanggal_awal_ymdhms);
                                            // // console.log('tanggal_akhir_ymdhms ' + tanggal_akhir_ymdhms);



                                            var sesudah_di_tambah_libur_nasional_tahap_2_kurang_1 = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(-1, 'days').format("YYYY-MM-DD HH:mm:ss");
                                            // console.log('sesudah_di_tambah_libur_nasional_tahap_2_kurang_1' + sesudah_di_tambah_libur_nasional_tahap_2_kurang_1);
                                            $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                // data: $('#formTambahIssues').serialize(),
                                                url: "{{url('issues/getDataLiburNasionalPerTahunBetween')}}" + '/' + sebelum_di_tambah_libur_nasional_tahap_2_plus_1.substr(0, 10) + '/' + sesudah_di_tambah_libur_nasional_tahap_2_kurang_1.substr(0, 10),
                                                type: "GET",
                                                dataType: 'json',
                                                success: function(data) {

                                                    var libur_between_2 = data.data.length;

                                                    var tanggal_awal_ymdhms = moment(tanggal_awal_ymd).format("YYYY-MM-DD HH:mm:ss");
                                                    var tanggal_akhir_ymdhms = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(libur_between_2, 'days').format("YYYY-MM-DD HH:mm:ss");

                                                    $('#perkiraan_selesai').val(tanggal_akhir_ymdhms);
                                                    $('#perkiraan_selesai_y_m_d').val(tanggal_akhir_ymdhms.substr(0, 10));

                                                    events.push({
                                                        title: 'issues',
                                                        start: tanggal_awal_ymdhms,
                                                        end: tanggal_akhir_ymdhms,
                                                        color: 'black'
                                                    }, );

                                                    // console.log('ini itu apalah coba');
                                                    // console.log(events);

                                                    calendar = new FullCalendar.Calendar(calendarEl, {
                                                        initialView: 'dayGridMonth',
                                                        // selectable: true,
                                                        // dayMaxEventRows: true,
                                                        // views: {
                                                        //     timeGrid: {
                                                        //         dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
                                                        //     }
                                                        // },
                                                        events: events,
                                                        eventClick: function(info) {
                                                            // console.log(info.event);
                                                            // // console.log(info.event._def.publicId);
                                                            // // console.log(info.event._def.extendedProps);
                                                            // // console.log(info.event._def.extendedProps.data);

                                                        }
                                                    });
                                                    // calendar.render();


                                                },
                                                error: function(data) {
                                                    // console.log('Error:', data);
                                                    //$('#modalPenghargaan').modal('show');
                                                }
                                            })

                                        },
                                        error: function(data) {
                                            // console.log('Error:', data);
                                            //$('#modalPenghargaan').modal('show');
                                        }
                                    })


                                },
                                error: function(data) {
                                    // console.log('Error:', data);
                                    //$('#modalPenghargaan').modal('show');
                                }
                            })

                        },
                        error: function(data) {
                            // console.log('Error:', data);
                            //$('#modalPenghargaan').modal('show');
                        }
                    })

                    // $.ajax({
                    //     headers: {
                    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    //     },
                    //     // data: $('#formTambahIssues').serialize(),
                    //     url: "{{url('issues/getLiburNasional')}}",
                    //     type: "GET",
                    //     dataType: 'json',
                    //     success: function(data) {

                    //         // // console.log(data.data.length);

                    //         for (var i = 0; i < data.data.length; i++) {
                    //             // console.log(data.data[i].nama_libur_nasional);

                    //             events.push({
                    //                 id: data.data[i].id,
                    //                 title: data.data[i].nama_libur_nasional,
                    //                 start: data.data[i].tgl_libur_nasional,
                    //                 color: 'red'
                    //             }, );
                    //         }

                    //         events.push({
                    //             title: 'issues',
                    //             start: moment(new Date()).format('YYYY-MM-DD'),
                    //             end: moment(perkiraan_selesai_y_m_d).format('YYYY-MM-DD HH:mm:ss'),
                    //             color: 'black'
                    //         }, );

                    //         // console.log('ini itu apalah coba');
                    //         // console.log(events);

                    //         calendar = new FullCalendar.Calendar(calendarEl, {
                    //             initialView: 'dayGridMonth',
                    //             // selectable: true,
                    //             // dayMaxEventRows: true,
                    //             // views: {
                    //             //     timeGrid: {
                    //             //         dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
                    //             //     }
                    //             // },
                    //             events: events,
                    //             eventClick: function(info) {
                    //                 // console.log(info.event);
                    //                 // // console.log(info.event._def.publicId);
                    //                 // // console.log(info.event._def.extendedProps);
                    //                 // // console.log(info.event._def.extendedProps.data);

                    //             }
                    //         });
                    //         calendar.render();

                    //     },
                    //     error: function(data) {
                    //         // console.log('Error:', data);
                    //         //$('#modalPenghargaan').modal('show');
                    //     }
                    // })




                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            })




        });
    });
</script>

<script>

</script>

<script>
    $(document).ready(function() {
        var calendar;
        document.addEventListener('DOMContentLoaded', function() {
            // var calendarEl = document.getElementById('calendar');
            // // calendarEl.remove();
            // var events = [];
            // $.ajax({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     // data: $('#formTambahIssues').serialize(),
            //     url: "{{url('issues/getLiburNasional')}}",
            //     type: "GET",
            //     dataType: 'json',
            //     success: function(data) {

            //         // // console.log(data.data.length);

            //         for (var i = 0; i < data.data.length; i++) {
            //             // console.log(data.data[i].nama_libur_nasional);

            //             events.push({
            //                 id: data.data[i].id,
            //                 title: data.data[i].nama_libur_nasional,
            //                 start: data.data[i].tgl_libur_nasional
            //             }, );
            //         }

            //         calendar = new FullCalendar.Calendar(calendarEl, {
            //             initialView: 'dayGridMonth',
            //             selectable: true,
            //             dayMaxEventRows: true,
            //             views: {
            //                 timeGrid: {
            //                     dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
            //                 }
            //             },
            //             dateClick: function(info) {
            //                 $('#modalTambahLiburNasional').modal('toggle');
            //                 $('#modalTambahLiburNasional').modal('show');
            //                 $("#tanggal_libur_nasional").val(info.dateStr);
            //             },
            //             events: events,
            //             eventClick: function(info) {
            //                 // console.log(info.event);
            //                 // // console.log(info.event._def.publicId);
            //                 // // console.log(info.event._def.extendedProps);
            //                 // // console.log(info.event._def.extendedProps.data);

            //                 var m_libur_nasional_id = info.event._def.publicId;
            //                 var title = info.event._def.title;

            //                 Swal.fire({
            //                     title: 'Are you sure?',
            //                     text: "Delete National Holiday " + title,
            //                     icon: 'warning',
            //                     showCancelButton: true,
            //                     confirmButtonText: 'Yes, delete it!'
            //                 }).then(function(result) {
            //                     if (result.value) {
            //                         $.ajax({
            //                             headers: {
            //                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                             },
            //                             // data: $('#FormEditUser').serialize(),
            //                             url: "{{url('libur_nasional/delete')}}" + '/' + m_libur_nasional_id,
            //                             type: "GET",
            //                             dataType: 'json',
            //                             success: function(data) {
            //                                 // console.log(data);
            //                                 // console.log(data.kode);
            //                                 if (data.kode == 201) {
            //                                     toastr.clear();
            //                                     toastr.success(data.success);
            //                                     // document.location = "{{ url('/home/index') }}";
            //                                     // $("#modalFormEditUser").modal('hide');
            //                                     // Swal.fire('Deleted!', 'Berhasil Di Delete.', 'success');
            //                                     // $('#tb_kategori').DataTable().ajax.reload(null, false);
            //                                     var eventSources = calendar.getEventSources();
            //                                     // console.log(eventSources[0]);
            //                                     var len = eventSources.length;
            //                                     for (var i = 0; i < len; i++) {
            //                                         eventSources[i].remove();
            //                                     }

            //                                     //add events calendar
            //                                     var events = [];

            //                                     for (var i = 0; i < data.data.length; i++) {
            //                                         // console.log(data.data[i].nama_libur_nasional);
            //                                         // json_text += "{" +
            //                                         //     "title:" + "'" + data.data[i].nama_libur_nasional + "'" + "," +
            //                                         //     "start:" + "'" + data.data[i].tgl_libur_nasional + "'" + "" +
            //                                         //     "},"
            //                                         events.push({
            //                                             id: data.data[i].id,
            //                                             title: data.data[i].nama_libur_nasional,
            //                                             start: data.data[i].tgl_libur_nasional
            //                                         }, );
            //                                     }


            //                                     calendar.addEventSource(events);
            //                                 } else {
            //                                     toastr.clear();
            //                                     toastr.error(data.success);
            //                                     // Swal.fire('Deleted!', 'Gagal Di Delete.', 'error');
            //                                 }
            //                             },
            //                             error: function(data) {
            //                                 // console.log('Error:', data);
            //                                 //$('#modalPenghargaan').modal('show');
            //                             }
            //                         });

            //                     }
            //                 });

            //             }
            //         });
            //         calendar.render();

            //     },
            //     error: function(data) {
            //         // console.log('Error:', data);
            //         //$('#modalPenghargaan').modal('show');
            //     }
            // })


        });
    });
</script>

<script>
    function getSabtuMingguDays(start, end) {
        // let start = moment();
        // let end = moment().businessAdd(7, 'days');

        var arr_sabtu = [];
        var arr_sabtu_final;
        // Get "next" sunday
        let tmp_sabtu = start.clone().day(6);
        if (tmp_sabtu.isAfter(start, 'd')) {
            arr_sabtu.push(tmp_sabtu.format('YYYY-MM-DD'));
        }
        while (tmp_sabtu.isBefore(end)) {
            tmp_sabtu.add(7, 'days');
            arr_sabtu.push(tmp_sabtu.format('YYYY-MM-DD'));
        }
        // // console.log(arr_sabtu);
        arr_sabtu_final = arr_sabtu.slice(0, -1);
        // console.log(arr_sabtu_final);

        var sabtu_text = "Sabtu <br> ";
        for (var i = 0; i < arr_sabtu_final.length; i++) {
            sabtu_text += arr_sabtu_final[i] + ' <br> ';
        }

        // console.log(sabtu_text);

        var arr_minggu = [];
        var arr_minggu_final;
        // Get "next" sunday
        let tmp_minggu = start.clone().day(0);
        if (tmp_minggu.isAfter(start, 'd')) {
            arr_minggu.push(tmp_minggu.format('YYYY-MM-DD'));
        }
        while (tmp_minggu.isBefore(end)) {
            tmp_minggu.add(7, 'days');
            arr_minggu.push(tmp_minggu.format('YYYY-MM-DD'));
        }

        arr_minggu_final = arr_minggu.slice(0, -1);
        // console.log(arr_minggu_final);

        var minggu_text = "Minggu <br> ";
        for (var j = 0; j < arr_minggu_final.length; j++) {
            minggu_text += arr_minggu_final[j] + ' <br> ';
        }

        // console.log(minggu_text);

        var text_sabtu_minggu_final = sabtu_text + '<br>' + minggu_text;

        var arr_sabtu_minggu_final = [
            arr_sabtu_final, arr_minggu_final
        ];

        var arr_text_sabtu_minggu_final = [
            arr_sabtu_minggu_final, text_sabtu_minggu_final
        ];

        // // console.log(arr_text_sabtu_minggu_final);
        return arr_text_sabtu_minggu_final;

    }
</script>

<script>
    // console.log('coba inidfha');
    // getLiburNasionalPerTahun("2022-08-03");

    function getLiburNasionalPerTahun(hari) {
        var d = new Date();
        var year = d.getFullYear();
        // var libur_nasional = [];
        var hari_berikutnya = "";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // data: $('#formTambahIssues').serialize(),
            url: "{{url('issues/getDataLiburNasionalPerTahun')}}" + '/' + year,
            type: "GET",
            dataType: 'json',
            success: function(data) {
                hari_berikutnya = moment(moment(hari), 'YYYY-MM-DD').businessAdd(1, 'days').format("YYYY-MM-DD");
                // // console.log(moment(date1).format(format1));
                // console.log(hari_berikutnya);
                // console.log('coba' + data.data.length);
                for (var q = 0; q < 20; q++) {
                    for (var i = 0; i < data.data.length; i++) {
                        if (hari_berikutnya == data.data[i]['tgl_libur_nasional']) {
                            // // console.log(q);
                            hari_berikutnya = moment(moment(hari_berikutnya), 'YYYY-MM-DD').businessAdd(q, 'days').format("YYYY-MM-DD");
                            // console.log(hari_berikutnya);
                        } else {
                            // break;
                        }
                    }
                }
                // console.log('ini harine bos' + hari_berikutnya);
                return hari_berikutnya;


            },
            error: function(data) {
                // console.log('Error:', data);
                //$('#modalPenghargaan').modal('show');
            }
        })



    }
</script>

<script type="text/javascript">
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {
        // function scanner_qr_code() {
        var no_kolom = 0;
        var kolom_search_gabung = '';
        var kolom_title = '';
        var value_kolom = '';
        var tabel_search_qr_code_val = '';
        $('#modalScanQRCodeTiketIssues').modal({
            backdrop: 'static',
            keyboard: false
        });

        $(document).on('click', '#kembali', function() {
            $('#modalScanQRCodeTiketIssues').modal('hide');
            scanner.stop();
        });

        let scanner = new Instascan.Scanner({
            video: document.getElementById("camera"),
            // mirror: false
        });
        let resultado = document.getElementById("qrcode");
        $(document).on('click', '.btnModalScanQRCodeTiketIssues', function() {
            tabel_search_qr_code_val = $(this).attr("data-tabel_search_qr_code");
            // console.log(tabel_search_qr_code_val);
            scanner.stop();
            scanner.addListener("scan", function(content) {
                // resultado.innerText = content;
                // // console.log(content);
                // $('.tiket_issues_search').val(content);
                // $("#Tiket_Issues_Search").val("Glenn Quagmire");

                // kolom_gabung = '';
                // $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}"+'?').load();
                if (tabel_search_qr_code_val == 'tb_issues') {
                    var tiket_issues_duplikat = '&' + 'tiket_issues_duplikat' + '=' + content;
                    const myArray = kolom_search_gabung.split("&");
                    // console.log(tiket_issues_duplikat);
                    // console.log(myArray);
                    // console.log('coba');
                    $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + tiket_issues_duplikat).load();
                    $('#modalScanQRCodeTiketIssues').modal('hide');
                    scanner.stop();
                } else if (tabel_search_qr_code_val == 'tb_issues_unit_kerja') {
                    var tiket_issues_duplikat_2 = '&' + 'tiket_issues_duplikat_2' + '=' + content;
                    const myArray_2 = kolom_search_gabung.split("&");
                    // console.log(tiket_issues_duplikat_2);
                    // console.log(myArray_2);
                    // console.log('coba');
                    $('#tb_issues_unit_kerja').DataTable().ajax.url("{{ url('issues/getDataIssuesUnitKerja') }}" + '?' + tiket_issues_duplikat_2).load();
                    $('#modalScanQRCodeTiketIssues').modal('hide');
                    scanner.stop();
                } else if (tabel_search_qr_code_val == 'tb_issues_forward') {
                    var tiket_issues_duplikat_3 = '&' + 'tiket_issues_duplikat_3' + '=' + content;
                    const myArray_3 = kolom_search_gabung.split("&");
                    // console.log(tiket_issues_duplikat_3);
                    // console.log(myArray_3);
                    // console.log('coba');
                    $('#tb_issues_forward').DataTable().ajax.url("{{ url('issues/getDataIssuesForward') }}" + '?' + tiket_issues_duplikat_3).load();
                    $('#modalScanQRCodeTiketIssues').modal('hide');
                    scanner.stop();
                } else {
                    scanner.stop();
                }

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
                // // console.log(content);
                var tiket_issues_duplikat = '&' + 'tiket_issues_duplikat' + '=' + content;
                const myArray = kolom_search_gabung.split("&");
                // console.log(tiket_issues_duplikat);
                // console.log(myArray);
                // console.log('coba');
                // kolom_gabung = '';
                // $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}"+'?').load();
                $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + tiket_issues_duplikat).load();
                $('#modalScanQRCodeTiketIssues').modal('hide');
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
                var tiket_issues_duplikat = '&' + 'tiket_issues_duplikat' + '=' + content;
                const myArray = kolom_search_gabung.split("&");
                // console.log(tiket_issues_duplikat);
                // console.log(myArray);
                // console.log('coba');
                // kolom_gabung = '';
                // $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}"+'?').load();
                $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + tiket_issues_duplikat).load();
                $('#modalScanQRCodeTiketIssues').modal('hide');
                // console.log(content);
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
        // }
    });
</script>

<script type="text/javascript">
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {

        var no_kolom = 0;
        var kolom_search_gabung = '';
        var kolom_title = '';
        var value_kolom = '';
        var searchTimeout;
        $('#tb_issues thead tr:eq(1) th').each(function(i) {


            // // console.log(no_kolom);

            if (no_kolom == 0 || no_kolom == 10) {
                $(this).html('');
            } else if (no_kolom == 8) {
                var title = $(this).text();
                // // console.log(title.toLowerCase());
                $(this).html('<select id="status_search" name="status_search" style="width:100%;">' +
                    '<option value=" ">Semua</option>' +
                    '<option value="1"> Open </option>' +
                    '<option value="2"> Progress </option>' +
                    '<option value="3"> Done </option>' +
                    '<option value="4"> Closed </option>' +
                    '<option value="6"> On Hold </option>' +
                    '</select>');

                // console.log($(this).parent().next('span'));

                $("#status_search").select2({
                    theme: "bootstrap-5",
                    placeholder: "Search Status",
                });

                var status_search_select2Id = $("#status_search").next()[0].dataset.select2Id;
                console.log($("#status_search").next());
                console.log($("#status_search").next()[0].children[0].children[0]);

                $("#status_search").next()[0].children[0].children[0].setAttribute("style", "height:48px !important; padding-top:10px !important;")

                $("#status_search").on("select2:select", function(e) {
                    // what you would like to happen
                    // // console.log(this.value);
                    // $("#eselon_id_selected_input").val(eselon_id).select2();
                    var status_search = this.value;
                    kolom_search_gabung += '&status=' + status_search;
                    const myArray = kolom_search_gabung.split("&");
                    // console.log(kolom_search_gabung);
                    // console.log(myArray);
                    // console.log('coba');
                    // kolom_gabung = '';
                    // $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}"+'?').load();
                    $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + kolom_search_gabung).load();
                    // // console.log(status_search);
                });

            } else if (no_kolom == 9) {

                var title = $(this).text();
                title = title.toLowerCase().toLowerCase().replace(" ", "_") + "_search";
                // // console.log(title.toLowerCase());
                $(this).html('<input type="text" class="search_text_tb_issues form-control" style="width:100%; line-height: 28px; padding: 2px 10px;" placeholder="Cari.."></i>' +
                    '<div style="font-size: 11px; display: flex; justify-content: left;">'+
                        '<input class="form-check-input" type="checkbox" value="true" id="security_incident_search" name="security_incident_search">'+
                        '<label class="form-check-label" style="margin-left:2px;">'+
                            'Security'+
                        '</label>'+
                        '<input class="form-check-input" type="checkbox" value="true" id="major_incident_search" name="major_incident_search" style="margin-left:12px;">'+
                        '<label class="form-check-label" style="margin-left:2px;">'+
                            'Major'+
                        '</label>'+
                    '</div>'
                );

                $('#security_incident_search').change(function() {
                    var status_security_incident_search = '';
                    if ($('#security_incident_search').prop('checked')) {
                        status_security_incident_search = true;

                        kolom_search_gabung += '&security_incident_search=' + status_security_incident_search;
                        const myArray = kolom_search_gabung.split("&");
                        $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + kolom_search_gabung).load();
                    }else{
                        status_security_incident_search = false;

                        kolom_search_gabung += '&security_incident_search=' + status_security_incident_search;
                        const myArray = kolom_search_gabung.split("&");
                        $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + kolom_search_gabung).load();
                    }
                })

                $('#major_incident_search').change(function() {
                    var status_major_incident_search = '';
                    if ($('#major_incident_search').prop('checked')) {
                        status_major_incident_search = true;

                        kolom_search_gabung += '&major_incident_search=' + status_major_incident_search;
                        const myArray = kolom_search_gabung.split("&");
                        $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + kolom_search_gabung).load();
                    }else{
                        status_major_incident_search = false;

                        kolom_search_gabung += '&major_incident_search=' + status_major_incident_search;
                        const myArray = kolom_search_gabung.split("&");
                        $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + kolom_search_gabung).load();
                    }
                })

            }
            // else if (no_kolom == 2) {
            //     // scanner_qr_code();

            //     $(this).html('<button id="btnModalScanQRCodeTiketIssues" name="btnModalScanQRCodeTiketIssues" type="button" class="btn btn-primary waves-effect waves-light btnModalScanQRCodeTiketIssues" data-bs-toggle="modal" data-bs-target="#modalScanQRCodeTiketIssues" data-tabel_search_qr_code="tb_issues" style="min-width:100%">ScanQRCode</button>');

            // }
            else if (no_kolom == 1) {
                // scanner_qr_code();

                var title = $(this).text();
                title = title.toLowerCase().toLowerCase().replace(" ", "_") + "_search";
                // // console.log(title.toLowerCase());
                $(this).html('<input type="text" class="search_text_tb_issues tiket_issues_search form-control" style="width:100%; line-height: 32px;" placeholder="Cari.."></i>');

            } else {
                var title = $(this).text();
                title = title.toLowerCase().toLowerCase().replace(" ", "_") + "_search";
                // // console.log(title.toLowerCase());
                $(this).html('<input type="text" class="search_text_tb_issues form-control" style="width:100%; line-height: 32px;" placeholder="Cari.."></i>');
            }

            $('input', this).on('keyup', function() {
                // // console.log('&' + title + '=' + this.value);
                // if (table.column(i).search() !== this.value) {
                //     table
                //         .column(i)
                //         .search(this.value)
                //         .draw();
                // }
                // kolom_gabung = '';
                kolom_search_gabung += '&' + title + '=' + this.value;
                const myArray = kolom_search_gabung.split("&");
                // console.log(kolom_search_gabung);
                // console.log(myArray);
                // console.log('coba');
                // kolom_gabung = '';
                // $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}"+'?').load();
                // $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + kolom_search_gabung).load();
                // $('#tb_pegawai').DataTable().ajax.reload(null, false);
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}" + '?' + kolom_search_gabung).load();
                }, 700);
            });

            // kolom_gabung = '';

            // // console.log('coba = ' + kolom_gabung);
            no_kolom++;

        });

        // NioApp.DataTable.init = function() {
        // NioApp.DataTable('#tb_user', {

        function getParameterByName(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        var tiket = getParameterByName('tiket');
        // console.log(tiket);
        // $(".tiket_issues_search").val(tiket);

        var get_tiket_issues_search_sesion = "{{ Session::get('tiket_issues_search')}}";
        console.log(get_tiket_issues_search_sesion);
        $(".tiket_issues_search").val(get_tiket_issues_search_sesion);

        var tb_issues = $('#tb_issues').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            scrollX: true,
            // sDom: 'lrtip', // untuk hidden search box di datatable
            // language: {
            // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
            // },
            fixedHeader: {
                header: true,
                footer: true,
                headerOffset: $('#page-topbar').height()
            },
            // fixedColumns: true,
            orderCellsTop: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('issues/getDataIssues') }}" + '?tiket_issues_search=' + get_tiket_issues_search_sesion,
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'tiket_issues_duplikat',
                    name: 'tiket_issues_duplikat',
                    className: 'text-center'
                },
                // {
                //     data: 'tiket_issues_qrcode',
                //     name: 'tiket_issues_qrcode',
                //     className: 'text-center',
                //     render: function(data, type, row) {
                //         // if (type === 'display') {
                //         // return row.tiket_issues_qrcode;
                //         // console.log(row.tiket_issues_duplikat);
                //         // return '<img src"public_path('+'\''+'image/Petro_logo.png'+'\''+')">';
                //         return '<img style="width:100px; height:100px;" src="data:image/png;base64,' + row.tiket_issues_qrcode + '" />' +
                //             // '<br>' +
                //             // '<a href="{{ url("issues/download_qr_code_issues") }}/' + row.tiket_issues + '" target="_blank" style="width: 100%; font-size:12px" type="button" class="btn btn-primary waves-effect waves-light mt-1">Download QRCode</a>';

                //             '<a href="data:image/png;base64,' + row.tiket_issues_qrcode + '" download="' + row.tiket_issues_duplikat + '.png" target="_blank" style="width: 100%;" type="button" class="btn mt-1 btn-primary waves-effect waves-light"><i class="bx bx-download"></i> Download</a>';
                //         // return 'coba';
                //         // // console.log(row.tiket_issues);
                //         // return row.tiket_issues_qrcode;
                //         // return '';
                //         // } else if (type === 'sort') {
                //         //     return data.LastName;
                //         // } else {
                //         //     return data;
                //         // }
                //     }
                // },
                // {
                //     data: 'username_sap_issues',
                //     name: 'username_sap_issues',
                //     className: 'text-center'
                // },
                {
                    data: 'nama_pegawai',
                    name: 'nama_pegawai',
                    className: 'text-center'
                },
                // {
                //     data: 'created_by',
                //     name: 'created_by',
                //     className: 'text-center'
                // },
                // {
                //     data: 'telp_issues',
                //     name: 'telp_issues',
                //     className: 'text-center'
                // },
                // {
                //     data: 'nama_kategori',
                //     name: 'nama_kategori',
                //     className: 'text-center'
                // },
                {
                    data: 'nama_layanan',
                    name: 'nama_layanan',
                    className: 'text-center'
                },
                {
                    data: 'nama_subject',
                    name: 'nama_subject',
                    className: 'text-center'
                },
                {
                    data: 'nama_priority',
                    name: 'nama_priority',
                    className: 'text-center'
                },
                // {
                //     data: 'description_issues',
                //     name: 'description_issues',
                //     className: 'text-center'
                // },
                // {
                //     data: 'file_issues',
                //     name: 'file_issues',
                //     className: 'text-center'
                // },
                {
                    data: 'tanggal_pembuatan_issues',
                    name: 'tanggal_pembuatan_issues',
                    className: 'text-center'
                },
                {
                    data: 'tanggal_batas_issues',
                    name: 'tanggal_batas_issues',
                    className: 'text-center'
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-center'
                },

            ],
            error: function(xhr, error, code) {
                // console.log(xhr, code);
                // $('#tb_issues').DataTable().ajax.reload(null, false);
            },
            searching: false,
            // dom: 'lBfrtip',
            dom: "<'row mb-3 align-items-center'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 text-right'B>><'wrapper1'<'div1'>><'row mb-3'<'col-lg-12'<'wrapper2'tr>>><'row align-items-center'<'col-lg-5 col-md-5'i><'col-lg-7 col-md-7'p>>",
            buttons: [
                {
                    text: '<span class=\"fas fa-sync mr-1\"></span> RELOAD',
                    className: "btn btn-secondary btn-sm float-end",
                    action: function ( e, dt, node, config ) {
                        // dt.ajax.reload();
                        $(".tiket_issues_search").val('');
                        $(".search_text_tb_issues").val('');

                        $("#status_search").val(" ").change();
                        // $('#tb_issues').DataTable().ajax.reload(null, false);
                        $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}").load();
                    }
                }
            ],
            drawCallback: function(settings) {
                // var api = this.api();

                // // Output the data for the visible rows to the browser's console
                // // console.log(api.rows({
                //     page: 'current'
                // }).data());

                // $(".tiket_issues_search").val(tiket);
                // $('#tb_issues').DataTable().ajax.reload(null, false);
            },
            initComplete: function(settings, json) {
                // $("#tb_preview").wrap(
                //     "<div style='overflow-x:auto; width:100%; position:relative;'></div>");
                $('#tb_issues').DataTable().ajax.reload(null, false);
                <?php Session::forget('tiket_issues_search'); ?>
                $('.dataTables_scrollHead').css({
                    'overflow-x': 'scroll'
                }).on('scroll', function(e) {
                    var scrollBody = $(this).parent().find('.dataTables_scrollBody').get(0);
                    scrollBody.scrollLeft = this.scrollLeft;
                    // $(scrollBody).trigger('scroll');
                });

                $(document).on('scroll', function() {
                    $('.dtfh-floatingparenthead').on('scroll', function() {
                        // // console.log('data')
                        $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
                    });
                })
            },
        })
        // };
    });
</script>

<!-- <script>
    $('#tb_issues').on('click', 'tbody tr', function() {
        // console.log('API row values : ', $('#tb_issues').DataTable().row(this).data());
    })
</script> -->

<script type="text/javascript">
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {
        // NioApp.DataTable.init = function() {
        // NioApp.DataTable('#tb_user', {

        var no_kolom = 0;
        var kolom_search_gabung = '';
        var kolom_title = '';
        var value_kolom = '';

        $('#tb_issues_unit_kerja thead tr:eq(1) th').each(function(i) {


            // // console.log(no_kolom);

            if (no_kolom == 0 || no_kolom == 11) {
                $(this).html('');
            } else if (no_kolom == 10) {
                var title = $(this).text();
                // // console.log(title.toLowerCase());
                $(this).html('<select id="status_search_2" name="status_search_2" style="width:100%">' +
                    '<option value=" ">Semua</option>' +
                    '<option value="1"> Open </option>' +
                    '<option value="2"> Progress </option>' +
                    '<option value="3"> Done </option>' +
                    '<option value="4"> Closed </option>' +
                    '<option value="6"> On Hold </option>' +
                    '</select>');

                $("#status_search_2").select2({
                    theme: "bootstrap-5",
                    placeholder: "Search Status",
                });

                $("#status_search_2").on("select2:select", function(e) {
                    // what you would like to happen
                    // // console.log(this.value);
                    // $("#eselon_id_selected_input").val(eselon_id).select2();
                    var status_search = this.value;
                    kolom_search_gabung += '&status_search_2=' + status_search;
                    const myArray = kolom_search_gabung.split("&");
                    // console.log(kolom_search_gabung);
                    // console.log(myArray);
                    // console.log('coba');
                    // kolom_gabung = '';
                    // $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}"+'?').load();
                    $('#tb_issues_unit_kerja').DataTable().ajax.url("{{ url('issues/getDataIssuesUnitKerja') }}" + '?' + kolom_search_gabung).load();
                    // // console.log(status_search);
                });

            } else if (no_kolom == 2) {

                $(this).html('<button type="button" class="btn btn-primary waves-effect waves-light btnModalScanQRCodeTiketIssues" data-bs-toggle="modal" data-bs-target="#modalScanQRCodeTiketIssues" data-tabel_search_qr_code="tb_issues_unit_kerja" style="min-width:100%">ScanQRCode</button>');

            } else {
                var title = $(this).text();
                title = title.toLowerCase().toLowerCase().replace(" ", "_") + "_search";
                // // console.log(title.toLowerCase());
                $(this).html('<input type="text" style="width:100%;" placeholder="Cari.."/>');
            }

            $('input', this).on('keyup', function() {
                // // console.log('&' + title + '=' + this.value);
                // if (table.column(i).search() !== this.value) {
                //     table
                //         .column(i)
                //         .search(this.value)
                //         .draw();
                // }
                // kolom_gabung = '';
                kolom_search_gabung += '&' + title + '=' + this.value;
                const myArray = kolom_search_gabung.split("&");
                // console.log(kolom_search_gabung);
                // console.log(myArray);
                // console.log('coba');
                // kolom_gabung = '';
                // $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}"+'?').load();
                $('#tb_issues_unit_kerja').DataTable().ajax.url("{{ url('issues/getDataIssuesUnitKerja') }}" + '?' + kolom_search_gabung).load();
                // $('#tb_pegawai').DataTable().ajax.reload(null, false);
            });

            // kolom_gabung = '';

            // // console.log('coba = ' + kolom_gabung);
            no_kolom++;

        });

        var tb_issues_unit_kerja = $('#tb_issues_unit_kerja').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            scrollX: true,
            sDom: 'lrtip', // untuk hidden search box di datatable
            autoWidth: 'false',
            fixedHeader: {
                header: true,
                footer: true,
                headerOffset: $('#page-topbar').height()
            },
            // fixedColumns: true,
            orderCellsTop: true,
            // language: {
            // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
            // },
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('issues/getDataIssuesUnitKerja') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'tiket_issues',
                    name: 'tiket_issues',
                    className: 'text-center'
                },
                // {
                //     data: 'tiket_issues_qrcode',
                //     name: 'tiket_issues_qrcode',
                //     className: 'text-center',
                //     render: function(data, type, row) {
                //         // if (type === 'display') {
                //         // return row.tiket_issues_qrcode;

                //         // return '<img src"public_path('+'\''+'image/Petro_logo.png'+'\''+')">';
                //         return '<img src="data:image/png;base64,' + row.tiket_issues_qrcode + '" />';
                //         // return 'coba';
                //         // // console.log(row.tiket_issues);
                //         // return row.tiket_issues_qrcode;
                //         // return '';
                //         // } else if (type === 'sort') {
                //         //     return data.LastName;
                //         // } else {
                //         //     return data;
                //         // }
                //     }
                // },
                // {
                //     data: 'username_sap_issues',
                //     name: 'username_sap_issues',
                //     className: 'text-center'
                // },
                {
                    data: 'nama_pegawai',
                    name: 'nama_pegawai',
                    className: 'text-center'
                },
                {
                    data: 'created_by',
                    name: 'created_by',
                    className: 'text-center'
                },
                // {
                //     data: 'telp_issues',
                //     name: 'telp_issues',
                //     className: 'text-center'
                // },
                // {
                //     data: 'nama_kategori',
                //     name: 'nama_kategori',
                //     className: 'text-center'
                // },
                {
                    data: 'nama_layanan',
                    name: 'nama_layanan',
                    className: 'text-center'
                },
                {
                    data: 'nama_subject',
                    name: 'nama_subject',
                    className: 'text-center'
                },
                {
                    data: 'nama_priority',
                    name: 'nama_priority',
                    className: 'text-center'
                },
                // {
                //     data: 'description_issues',
                //     name: 'description_issues',
                //     className: 'text-center'
                // },
                // {
                //     data: 'file_issues',
                //     name: 'file_issues',
                //     className: 'text-center'
                // },
                {
                    data: 'tanggal_pembuatan_issues',
                    name: 'tanggal_pembuatan_issues',
                    className: 'text-center'
                },
                {
                    data: 'tanggal_batas_issues',
                    name: 'tanggal_batas_issues',
                    className: 'text-center'
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-center'
                },

            ],
            error: function(xhr, error, code) {
                // // console.log(xhr, code);
                $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
            },
            initComplete: function(settings, json) {
                // $("#tb_preview").wrap(
                //     "<div style='overflow-x:auto; width:100%; position:relative;'></div>");
                $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                $('.dataTables_scrollHead').css({
                    'overflow-x': 'scroll'
                }).on('scroll', function(e) {
                    var scrollBody = $(this).parent().find('.dataTables_scrollBody').get(0);
                    scrollBody.scrollLeft = this.scrollLeft;
                    // $(scrollBody).trigger('scroll');
                });

                $(document).on('scroll', function() {
                    $('.dtfh-floatingparenthead').on('scroll', function() {
                        // // console.log('data')
                        $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
                    });
                })
            },
        })
        // };

        // $('#tb_issues_unit_kerja').DataTable().ajax.reload();
    });
</script>


<script type="text/javascript">
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {
        // NioApp.DataTable.init = function() {
        // NioApp.DataTable('#tb_user', {

        var no_kolom = 0;
        var kolom_search_gabung = '';
        var kolom_title = '';
        var value_kolom = '';

        $('#tb_issues_forward thead tr:eq(1) th').each(function(i) {


            // // console.log(no_kolom);

            if (no_kolom == 0 || no_kolom == 10) {
                $(this).html('');
            } else if (no_kolom == 8) {
                var title = $(this).text();
                // // console.log(title.toLowerCase());
                $(this).html('<select id="status_3_search" name="status_3_search" style="width:100%;">' +
                    '<option value=" ">Semua</option>' +
                    '<option value="1"> Open </option>' +
                    '<option value="2"> Progress </option>' +
                    '<option value="3"> Done </option>' +
                    '<option value="4"> Closed </option>' +
                    '<option value="6"> On Hold </option>' +
                    '</select>');

                // console.log($(this).parent().next('span'));

                $("#status_3_search").select2({
                    theme: "bootstrap-5",
                    placeholder: "Search Status",
                });

                var status_search_select2Id = $("#status_3_search").next()[0].dataset.select2Id;
                console.log($("#status_3_search").next());
                console.log($("#status_3_search").next()[0].children[0].children[0]);

                $("#status_3_search").next()[0].children[0].children[0].setAttribute("style", "height:48px !important; padding-top:10px !important;")

                $("#status_3_search").on("select2:select", function(e) {
                    // what you would like to happen
                    // // console.log(this.value);
                    // $("#eselon_id_selected_input").val(eselon_id).select2();
                    var status_search = this.value;
                    kolom_search_gabung += '&status_3_search=' + status_search;
                    const myArray = kolom_search_gabung.split("&");
                    // console.log(kolom_search_gabung);
                    // console.log(myArray);
                    // console.log('coba');
                    // kolom_gabung = '';
                    // $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}"+'?').load();
                    $('#tb_issues_forward').DataTable().ajax.url("{{ url('issues/getDataIssuesForward') }}" + '?' + kolom_search_gabung).load();
                    // // console.log(status_search);
                });

            } else if (no_kolom == 9) {

                var title = $(this).text();
                title = title.toLowerCase().toLowerCase().replace(" ", "_") + "_search";
                // // console.log(title.toLowerCase());
                $(this).html('<input type="text" class="search_text_tb_issues form-control" style="width:100%; line-height: 28px; padding: 2px 10px;" placeholder="Cari.."></i>' +
                    '<div style="font-size: 11px; display: flex; justify-content: left;">'+
                        '<input class="form-check-input" type="checkbox" value="true" id="security_incident_3_search" name="security_incident_3_search">'+
                        '<label class="form-check-label" style="margin-left:2px;">'+
                            'Security'+
                        '</label>'+
                        '<input class="form-check-input" type="checkbox" value="true" id="major_incident_3_search" name="major_incident_3_search" style="margin-left:12px;">'+
                        '<label class="form-check-label" style="margin-left:2px;">'+
                            'Major'+
                        '</label>'+
                    '</div>'
                );

                $('#security_incident_3_search').change(function() {
                    var status_security_incident_search = '';
                    if ($('#security_incident_3_search').prop('checked')) {
                        status_security_incident_search = true;

                        kolom_search_gabung += '&security_incident_3_search=' + status_security_incident_search;
                        const myArray = kolom_search_gabung.split("&");
                        $('#tb_issues_forward').DataTable().ajax.url("{{ url('issues/getDataIssuesForward') }}" + '?' + kolom_search_gabung).load();
                    }else{
                        status_security_incident_search = false;

                        kolom_search_gabung += '&security_incident_3_search=' + status_security_incident_search;
                        const myArray = kolom_search_gabung.split("&");
                        $('#tb_issues_forward').DataTable().ajax.url("{{ url('issues/getDataIssuesForward') }}" + '?' + kolom_search_gabung).load();
                    }
                })

                $('#major_incident_3_search').change(function() {
                    var status_major_incident_search = '';
                    if ($('#major_incident_3_search').prop('checked')) {
                        status_major_incident_search = true;

                        kolom_search_gabung += '&major_incident_3_search=' + status_major_incident_search;
                        const myArray = kolom_search_gabung.split("&");
                        $('#tb_issues_forward').DataTable().ajax.url("{{ url('issues/getDataIssuesForward') }}" + '?' + kolom_search_gabung).load();
                    }else{
                        status_major_incident_search = false;

                        kolom_search_gabung += '&major_incident_3_search=' + status_major_incident_search;
                        const myArray = kolom_search_gabung.split("&");
                        $('#tb_issues_forward').DataTable().ajax.url("{{ url('issues/getDataIssuesForward') }}" + '?' + kolom_search_gabung).load();
                    }
                })

            }
            // else if (no_kolom == 2) {
            //     // scanner_qr_code();

            //     $(this).html('<button id="btnModalScanQRCodeTiketIssues" name="btnModalScanQRCodeTiketIssues" type="button" class="btn btn-primary waves-effect waves-light btnModalScanQRCodeTiketIssues" data-bs-toggle="modal" data-bs-target="#modalScanQRCodeTiketIssues" data-tabel_search_qr_code="tb_issues" style="min-width:100%">ScanQRCode</button>');

            // }
            else if (no_kolom == 1) {
                // scanner_qr_code();

                var title = $(this).text();
                title = title.toLowerCase().toLowerCase().replace(" ", "_") + "_search";
                // // console.log(title.toLowerCase());
                $(this).html('<input type="text" class="search_text_tb_issues tiket_issues_search form-control" style="width:100%; line-height: 32px;" placeholder="Cari.."></i>');

            } else {
                var title = $(this).text();
                title = title.toLowerCase().toLowerCase().replace(" ", "_") + "_search";
                // // console.log(title.toLowerCase());
                $(this).html('<input type="text" class="search_text_tb_issues form-control" style="width:100%; line-height: 32px;" placeholder="Cari.."></i>');
            }

            $('input', this).on('keyup', function() {
                // // console.log('&' + title + '=' + this.value);
                // if (table.column(i).search() !== this.value) {
                //     table
                //         .column(i)
                //         .search(this.value)
                //         .draw();
                // }
                // kolom_gabung = '';
                kolom_search_gabung += '&' + title + '=' + this.value;
                const myArray = kolom_search_gabung.split("&");
                // console.log(kolom_search_gabung);
                // console.log(myArray);
                // console.log('coba');
                // kolom_gabung = '';
                // $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}"+'?').load();
                $('#tb_issues_forward').DataTable().ajax.url("{{ url('issues/getDataIssuesForward') }}" + '?' + kolom_search_gabung).load();
                // $('#tb_pegawai').DataTable().ajax.reload(null, false);
            });

            // kolom_gabung = '';

            // // console.log('coba = ' + kolom_gabung);
            no_kolom++;

        });

        var tb_issues_forward = $('#tb_issues_forward').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            scrollX: true,
            sDom: 'lrtip', // untuk hidden search box di datatable
            autoWidth: 'false',
            fixedHeader: {
                header: true,
                footer: true,
                headerOffset: $('#page-topbar').height()
            },
            // fixedColumns: true,
            orderCellsTop: true,
            // language: {
            // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
            // },
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('issues/getDataIssuesForward') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'tiket_issues_duplikat',
                    name: 'tiket_issues_duplikat',
                    className: 'text-center'
                },
                // {
                //     data: 'tiket_issues_qrcode',
                //     name: 'tiket_issues_qrcode',
                //     className: 'text-center',
                //     render: function(data, type, row) {
                //         // if (type === 'display') {
                //         // return row.tiket_issues_qrcode;
                //         // console.log(row.tiket_issues_duplikat);
                //         // return '<img src"public_path('+'\''+'image/Petro_logo.png'+'\''+')">';
                //         return '<img style="width:100px; height:100px;" src="data:image/png;base64,' + row.tiket_issues_qrcode + '" />' +
                //             // '<br>' +
                //             // '<a href="{{ url("issues/download_qr_code_issues") }}/' + row.tiket_issues + '" target="_blank" style="width: 100%; font-size:12px" type="button" class="btn btn-primary waves-effect waves-light mt-1">Download QRCode</a>';

                //             '<a href="data:image/png;base64,' + row.tiket_issues_qrcode + '" download="' + row.tiket_issues_duplikat + '.png" target="_blank" style="width: 100%;" type="button" class="btn mt-1 btn-primary waves-effect waves-light"><i class="bx bx-download"></i> Download</a>';
                //         // return 'coba';
                //         // // console.log(row.tiket_issues);
                //         // return row.tiket_issues_qrcode;
                //         // return '';
                //         // } else if (type === 'sort') {
                //         //     return data.LastName;
                //         // } else {
                //         //     return data;
                //         // }
                //     }
                // },
                // {
                //     data: 'username_sap_issues',
                //     name: 'username_sap_issues',
                //     className: 'text-center'
                // },
                {
                    data: 'nama_pegawai',
                    name: 'nama_pegawai',
                    className: 'text-center'
                },
                // {
                //     data: 'created_by',
                //     name: 'created_by',
                //     className: 'text-center'
                // },
                // {
                //     data: 'telp_issues',
                //     name: 'telp_issues',
                //     className: 'text-center'
                // },
                // {
                //     data: 'nama_kategori',
                //     name: 'nama_kategori',
                //     className: 'text-center'
                // },
                {
                    data: 'nama_layanan',
                    name: 'nama_layanan',
                    className: 'text-center'
                },
                {
                    data: 'nama_subject',
                    name: 'nama_subject',
                    className: 'text-center'
                },
                {
                    data: 'nama_priority',
                    name: 'nama_priority',
                    className: 'text-center'
                },
                // {
                //     data: 'description_issues',
                //     name: 'description_issues',
                //     className: 'text-center'
                // },
                // {
                //     data: 'file_issues',
                //     name: 'file_issues',
                //     className: 'text-center'
                // },
                {
                    data: 'tanggal_pembuatan_issues',
                    name: 'tanggal_pembuatan_issues',
                    className: 'text-center'
                },
                {
                    data: 'tanggal_batas_issues',
                    name: 'tanggal_batas_issues',
                    className: 'text-center'
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-center'
                },

            ],
            error: function(xhr, error, code) {
                // console.log(xhr, code);
                // $('#tb_issues').DataTable().ajax.reload(null, false);
            },
            searching: false,
            // dom: 'lBfrtip',
            dom: "<'row mb-3 align-items-center'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 text-right'B>><'wrapper1'<'div1'>><'row mb-3'<'col-lg-12'<'wrapper2'tr>>><'row align-items-center'<'col-lg-5 col-md-5'i><'col-lg-7 col-md-7'p>>",
            buttons: [
                {
                    text: '<span class=\"fas fa-sync mr-1\"></span> RELOAD',
                    className: "btn btn-secondary btn-sm float-end",
                    action: function ( e, dt, node, config ) {
                        // dt.ajax.reload();
                        $(".tiket_issues_search").val('');
                        $(".search_text_tb_issues").val('');

                        $("#status_search").val(" ").change();
                        // $('#tb_issues').DataTable().ajax.reload(null, false);
                        $('#tb_issues').DataTable().ajax.url("{{ url('issues/getDataIssues') }}").load();
                    }
                }
            ],
            drawCallback: function(settings) {
                // var api = this.api();

                // // Output the data for the visible rows to the browser's console
                // // console.log(api.rows({
                //     page: 'current'
                // }).data());

                // $(".tiket_issues_search").val(tiket);
                // $('#tb_issues').DataTable().ajax.reload(null, false);
            },
            initComplete: function(settings, json) {
                // $("#tb_preview").wrap(
                //     "<div style='overflow-x:auto; width:100%; position:relative;'></div>");
                $('#tb_issues').DataTable().ajax.reload(null, false);
                <?php Session::forget('tiket_issues_search'); ?>
                $('.dataTables_scrollHead').css({
                    'overflow-x': 'scroll'
                }).on('scroll', function(e) {
                    var scrollBody = $(this).parent().find('.dataTables_scrollBody').get(0);
                    scrollBody.scrollLeft = this.scrollLeft;
                    // $(scrollBody).trigger('scroll');
                });

                $(document).on('scroll', function() {
                    $('.dtfh-floatingparenthead').on('scroll', function() {
                        // // console.log('data')
                        $('.dataTables_scrollBody').scrollLeft($(this).scrollLeft());
                    });
                })
            },
        })
        // };

        // $('#tb_issues_unit_kerja').DataTable().ajax.reload();
    });
</script>

<!-- <script>
    $(document).on('click', '#tambah', function() {
        // console.log('tambah');
        // var coba = $('#description_issues').html('');

        // var desc = CKEDITOR.instances.DSC.getData();
        // var coba = ClassicEditor;

        // e.preventDefault();
        // var formData = new FormData($(this).parents('form')[0]);
        // // console.log(formData);

        var file_issues_arr = $(".file_issues_arr");
        // console.log(file_issues_arr);
        var i;
        var array_file_input = [];
        for (i = 0; i < file_issues_arr.length; i++) {
            array_file_input.push(file_issues_arr[i].files[0]);
            // array_file_input.push(file_issues_arr[i].mozFullPath);
        }

        // console.log(array_file_input);

        // for (var i = 0; i < files.length; i++) {
        //     alert(files[i].name);
        // }



        var get_description_issues = $('#description_issues').html();
        // console.log(get_description_issues);
        var file_issues = $('#file_issues').val();
        // console.log(file_issues);

        // console.log($('#formTambahIssues').serialize());
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#formTambahIssues').serialize() +
                '&description_issues=' + encodeURIComponent(get_description_issues.toString()) +
                '&file_issues=' + array_file_input,
            url: "{{url('issues/tambah')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalFormTambahIssues").modal('hide');
                    $('#tb_issues').DataTable().ajax.reload(null, false);
                } else {
                    toastr.clear();
                    toastr.error(data.success);
                }
            },
            error: function(data) {
                // console.log('Error:', data);
                //$('#modalPenghargaan').modal('show');
            }
        });
    });
</script> -->

<script type="text/javascript">
    $(document).ready(function() {
        // $(".formUploadFileLapiranKenaikanPangkatDetail").click(function() {
        $('.formTambahIssues').submit(function(event) {
            var formData = new FormData(this);
            $('.simpan_form_tambah_issue_disabled_enabled').prop('disabled', true);
            // alert($('#file_lampiran_kenaikan_pangkat').val());

            // var file_lampiran_kenaikan_pangkat = $('#file_lampiran_kenaikan_pangkat').val();

            var priority_id = $("#priority_id option:selected").val();
            // console.log(priority_id);

            var perkiraan_selesai;
            var perkiraan_selesai_y_m_d;
            var info_perkiraan_selesai_text;
            let start = "";
            let end = "";

            if (priority_id == "P001") {
                // console.log(1);

                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours'));

                // console.log(1);

                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours'));

                perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);

                var format = 'hh:mm:ss';

                var time = moment();
                // var time = moment('13:30:00', format);
                var jam_berangkat = moment('07:00:00', format);
                var jam_pulang = moment('16:00:00', format);
                // console.log('jam_pulang' + jam_pulang);

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;
                    end = moment(start).businessAdd(4, 'hours');
                    // console.log('end' + moment(end).format("YYYY-MM-DD HH:mm:ss"));

                    if (end > jam_pulang) {
                        // // console.log(end.diff(jam_pulang, "hours"));
                        // // console.log(end.diff(jam_pulang, "seconds"));
                        // console.log('end > jam_pulang');
                        var selisi_end_jam_pulang = end.diff(jam_pulang, "seconds");
                        // console.log('end' + end);
                        // console.log('start' + start);
                        // console.log('selisi_end_jam_pulang' + selisi_end_jam_pulang);
                        end = moment(new Date(
                                new Date().getFullYear(),
                                new Date().getMonth(),
                                new Date().getDate(),
                                7,
                                0,
                                0,
                                0
                            ))
                            .businessAdd(1, 'days')
                            .businessAdd(selisi_end_jam_pulang, 'seconds');

                        // console.log('end 1' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    } else {
                        // console.log('end < jam_pulang');
                        end = end;

                        // console.log('end 2' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    }

                    // // console.log(getSabtuMingguDays(start, end)[1]);

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');
                    end = moment(start).businessAdd(4, 'hours');

                }
                // // console.log(getSabtuMingguDays(start, end)[0][0]);
                // info_perkiraan_selesai_text = getSabtuMingguDays(start, end)[1];

            } else if (priority_id == "P002") {
                // console.log(2);

                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(8, 'hours'));

                perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);

                var format = 'hh:mm:ss';

                var time = moment();
                // var time = moment('13:30:00', format);
                var jam_berangkat = moment('07:00:00', format);
                var jam_pulang = moment('16:00:00', format);
                // console.log('jam_pulang' + jam_pulang);

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;
                    end = moment(start).businessAdd(8, 'hours');
                    // console.log('end' + moment(end).format("YYYY-MM-DD HH:mm:ss"));

                    if (end > jam_pulang) {
                        // // console.log(end.diff(jam_pulang, "hours"));
                        // // console.log(end.diff(jam_pulang, "seconds"));
                        // console.log('end > jam_pulang');
                        var selisi_end_jam_pulang = end.diff(jam_pulang, "seconds");
                        // console.log('end' + end);
                        // console.log('start' + start);
                        // console.log('selisi_end_jam_pulang' + selisi_end_jam_pulang);
                        end = moment(new Date(
                                new Date().getFullYear(),
                                new Date().getMonth(),
                                new Date().getDate(),
                                7,
                                0,
                                0,
                                0
                            ))
                            .businessAdd(1, 'days')
                            .businessAdd(selisi_end_jam_pulang, 'seconds');

                        // console.log('end 1' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    } else {
                        // console.log('end < jam_pulang');
                        end = end;

                        // console.log('end 2' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    }

                    // // console.log(getSabtuMingguDays(start, end)[1]);

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');
                    end = moment(start).businessAdd(8, 'hours');

                }

                // console.log(getSabtuMingguDays(start, end)[1]);

            } else if (priority_id == "P003") {
                // console.log(3);
                // // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2)._d);
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days'));
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days').format("YYYY-MM-DD HH:mm:ss"));

                perkiraan_selesai_y_m_d = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days').format("YYYY-MM-DD HH:mm:ss");

                var format = 'hh:mm:ss';

                var time = moment();
                // var time = moment('17:30:00', format);
                var jam_berangkat = moment('07:00:00', format);
                var jam_pulang = moment('16:00:00', format);
                // console.log('jam_pulang' + jam_pulang);

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');

                    // // console.log(start);
                    // console.log('start' + moment(start).format("YYYY-MM-DD HH:mm:ss"));

                }


                // start = time;
                end = moment(start).businessAdd(2, 'days');

                // console.log(getSabtuMingguDays(start, end)[1]);

            } else if (priority_id == "P004") {
                // console.log(4);
                // // console.log(moment(moment().format(), 'YYYY-MM-DD HH').businessAdd(7));
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7, 'days'));
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7, 'days').format("YYYY-MM-DD HH:mm:ss"));
                // console.log(moment().isoWeekday());

                perkiraan_selesai_y_m_d = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days').format("YYYY-MM-DD HH:mm:ss");

                var format = 'hh:mm:ss';

                var time = moment();
                // var time = moment('17:30:00', format);
                var jam_berangkat = moment('07:00:00', format);
                var jam_pulang = moment('16:00:00', format);
                // console.log('jam_pulang' + jam_pulang);

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');

                    // // console.log(start);
                    // console.log('start' + moment(start).format("YYYY-MM-DD HH:mm:ss"));

                }


                // start = time;
                end = moment(start).businessAdd(7, 'days');

                // console.log(getSabtuMingguDays(start, end)[1]);

            }

            // console.log('iki lo bro');
            var tanggal_awal_ymd = moment().format("YYYY-MM-DD HH:mm:ss");
            var tanggal_akhir_ymd = moment(end).format("YYYY-MM-DD HH:mm:ss");
            // console.log(tanggal_awal_ymd);
            // console.log(tanggal_akhir_ymd);


            // console.log('ini apalah itu' + perkiraan_selesai_y_m_d);
            var d = new Date();
            var year = d.getFullYear();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getDataLiburNasionalPerTahunBetween')}}" + '/' + tanggal_awal_ymd + '/' + tanggal_akhir_ymd,
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    var libur_between_1 = data.data.length;

                    // console.log('libur_between_1 = ' + libur_between_1);
                    // console.log('sebelum di tambah libur nasional tahap 1 ' + tanggal_akhir_ymd);
                    var sebelum_di_tambah_libur_nasional_tahap_1 = tanggal_akhir_ymd;
                    tanggal_akhir_ymd = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(libur_between_1, 'days').format("YYYY-MM-DD HH:mm:ss");
                    // console.log('sesudah di tambah libur nasional tahap 1 ' + tanggal_akhir_ymd);
                    // var sesudah_di_tambah_libur_nasional_tahap_1 = tanggal_akhir_ymd;
                    var sebelum_di_tambah_libur_nasional_tahap_1_plus_1 = moment(moment(end).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(1, 'days').format("YYYY-MM-DD HH:mm:ss");
                    var sesudah_di_tambah_libur_nasional_tahap_1_kurang_1 = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(-1, 'days').format("YYYY-MM-DD HH:mm:ss");

                    // console.log('sebelum_di_tambah_libur_nasional_tahap_1_plus_1 ' + sebelum_di_tambah_libur_nasional_tahap_1_plus_1);
                    // console.log('sesudah_di_tambah_libur_nasional_tahap_1_kurang_1 ' + sesudah_di_tambah_libur_nasional_tahap_1_kurang_1);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        // data: $('#formTambahIssues').serialize(),
                        url: "{{url('issues/getDataLiburNasionalPerTahunDistinctTanggal')}}" + '/' + year,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data.data);
                            // // console.log(moment(date1).format(format1));
                            var libur_tanggal_libur_nasional_array = [];
                            // // console.log('perkiraan_selesai_y_m_d_libur_nasional' + perkiraan_selesai_y_m_d_libur_nasional);
                            // console.log('coba' + data.data.length);

                            var hari_libur_next = 0;

                            for (var s = 0; s < 10; s++) {

                                for (var r = 0; r < data.data.length; r++) {
                                    // console.log('tanggal_akhir_ymd ' + tanggal_akhir_ymd);
                                    // console.log('tgl_libur_nasional ' + data.data[r].tgl_libur_nasional);

                                    if (tanggal_akhir_ymd.substr(0, 10) == data.data[r].tgl_libur_nasional) {
                                        // console.log('ini cocok ' + tanggal_akhir_ymd)
                                        // hari_libur_next = hari_libur_next + 1;
                                        // console.log('hari_libur_next ' + hari_libur_next);
                                        // console.log('sebelum di tambah libur nasional tahap 2 ' + tanggal_akhir_ymd);
                                        tanggal_akhir_ymd = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(hari_libur_next + 1, 'days').format("YYYY-MM-DD HH:mm:ss");
                                        // console.log('sesudah di tambah libur nasional tahap 2 ' + tanggal_akhir_ymd);
                                    } else {

                                    }

                                }

                            }

                            // var popover_final = info_perkiraan_selesai_text + '<br> Hari Libur Nasional <br>' + libur_tanggal_libur_nasional_text;
                            var popover_final = "";
                            popover_final += "<div id='calendar'></div>";

                            // $("#perkiraan_selesai").popover({
                            //     title: 'Due Date Info',
                            //     content: popover_final,
                            //     html: true,
                            //     placement: 'left',
                            //     height: 1000,
                            //     width: 6000,
                            //     aspectRatio: 2,
                            //     windowResize: function(arg) {
                            //         alert('The calendar has adjusted to a window resize. Current view: ' + arg.view.type);
                            //     }
                            // }).popover('show');


                            // console.log('cobaan telo ' + tanggal_akhir_ymd);


                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                // data: $('#formTambahIssues').serialize(),
                                url: "{{url('issues/getDataLiburNasionalPerTahunBetween')}}" + '/' + sebelum_di_tambah_libur_nasional_tahap_1_plus_1.substr(0, 10) + '/' + sesudah_di_tambah_libur_nasional_tahap_1_kurang_1.substr(0, 10),
                                type: "GET",
                                dataType: 'json',
                                success: function(data) {

                                    // console.log('coba coba coba coba');
                                    // console.log(data.data.length);
                                    var libur_between_2 = data.data.length;

                                    var calendarEl = document.getElementById('calendar');
                                    var events = [];


                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        // data: $('#formTambahIssues').serialize(),
                                        url: "{{url('issues/getLiburNasional')}}",
                                        type: "GET",
                                        dataType: 'json',
                                        success: function(data) {

                                            // // console.log(data.data.length);

                                            for (var i = 0; i < data.data.length; i++) {
                                                // console.log(data.data[i].nama_libur_nasional);

                                                events.push({
                                                    id: data.data[i].id,
                                                    title: data.data[i].nama_libur_nasional,
                                                    start: data.data[i].tgl_libur_nasional,
                                                    color: 'red'
                                                }, );
                                            }

                                            var tanggal_awal_ymdhms = moment(tanggal_awal_ymd).format("YYYY-MM-DD HH:mm:ss");
                                            // var tanggal_akhir_ymdhms = moment(tanggal_akhir_ymd).format("YYYY-MM-DD HH:mm:ss");
                                            var tanggal_akhir_ymdhms = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(libur_between_2, 'days').format("YYYY-MM-DD HH:mm:ss");

                                            // console.log('tanggal_awal_ymdhms ' + tanggal_awal_ymdhms);
                                            // console.log('tanggal_akhir_ymdhms ' + tanggal_akhir_ymdhms);

                                            $('#perkiraan_selesai').val(tanggal_akhir_ymdhms);
                                            $('#perkiraan_selesai_y_m_d').val(tanggal_akhir_ymdhms.substr(0, 10));

                                            events.push({
                                                title: 'issues',
                                                start: tanggal_awal_ymdhms,
                                                end: tanggal_akhir_ymdhms,
                                                color: 'black'
                                            }, );

                                            // console.log('ini itu apalah coba');
                                            // console.log(events);

                                            calendar = new FullCalendar.Calendar(calendarEl, {
                                                initialView: 'dayGridMonth',
                                                // selectable: true,
                                                // dayMaxEventRows: true,
                                                // views: {
                                                //     timeGrid: {
                                                //         dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
                                                //     }
                                                // },
                                                events: events,
                                                eventClick: function(info) {
                                                    // console.log(info.event);
                                                    // // console.log(info.event._def.publicId);
                                                    // // console.log(info.event._def.extendedProps);
                                                    // // console.log(info.event._def.extendedProps.data);

                                                }
                                            });
                                            // calendar.render();

                                            var get_description_issues = $('#description_issues').html();


                                            formData.append('description_issues', get_description_issues.replaceAll('type="text"', 'type="hidden"'));
                                            formData.append('tanggal_pembuatan_issues', moment().format('YYYY-MM-DD HH:mm:ss'));
                                            formData.append('tanggal_batas_issues', tanggal_akhir_ymdhms);

                                            // console.log(formData);

                                            $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                // contentType: 'multipart/form-data',
                                                data: formData,
                                                cache: false,
                                                processData: false,
                                                contentType: false,
                                                url: "{{url('issues/tambah')}}",
                                                type: "POST",
                                                dataType: 'json',
                                                success: function(data) {
                                                    // console.log(data);
                                                    // console.log(data.kode);
                                                    if (data.kode == 201) {
                                                        toastr.clear();
                                                        toastr.success(data.success);
                                                        // document.location = "{{ url('/home/index') }}";
                                                        // $("#kategori_id").empty();
                                                        $("#layanan_id").empty();
                                                        $("#subject_id").empty();
                                                        // $("#priority_id").empty();

                                                        $("#username_sap_issues").val("").trigger('change');
                                                        $("#kategori_id").val("").trigger('change');
                                                        $("#layanan_id").val("").trigger('change');
                                                        $("#subject_id").val("").trigger('change');
                                                        $("#priority_id").val("").trigger('change');

                                                        $("#telp_issues").val("");
                                                        $("#perkiraan_selesai").val("");
                                                        $("#no_wa").val("");

                                                        // $("#description_issues").html('<div class="ql-editor" data-gramm="false" contenteditable="true"></div>');
                                                        quill_description_issues.root.innerHTML = '<div class="ql-editor" data-gramm="false" contenteditable="true"></div>';
                                                        $("#append_div").html(
                                                            '<div class="row">'+
                                                                '<div class="col-lg-11">'+
                                                                    '<div class="mt-4 mt-xl-0">'+
                                                                        '<input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" accept=".doc,.xls,.docx,.xlsx,.pdf,.mp3,.aav,.mp4,.mkv,.jpg,.jpeg,.png,.svg" >'+
                                                                    '</div>'+
                                                                '</div>'+
                                                                '<div class="col-lg-1">'+
                                                                    '<div class="mt-4 mt-xl-0">'+
                                                                        '<button type="button" name="plus_append_file" id="plus_append_file" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus"></i></button>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                            '</div>'
                                                        );

                                                        $("#description_issues_lenght").html("0");

                                                        $("#modalFormTambahIssues").modal('hide');
                                                        $('#tb_issues').DataTable().ajax.reload(null, false);
                                                        $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);

                                                        $('.simpan_form_tambah_issue_disabled_enabled').prop('disabled', false);
                                                    } else {
                                                        toastr.clear();
                                                        toastr.info(data.success);

                                                        $("#perkiraan_selesai").popover('hide');

                                                        $('.simpan_form_tambah_issue_disabled_enabled').prop('disabled', false);
                                                        // $('#perkiraan_selesai').val('');
                                                    }

                                                },
                                                error: function(data) {
                                                    // console.log('Error:', data);
                                                    //$('#modalPenghargaan').modal('show');
                                                }
                                            });


                                        },
                                        error: function(data) {
                                            // console.log('Error:', data);
                                            //$('#modalPenghargaan').modal('show');
                                        }
                                    })


                                },
                                error: function(data) {
                                    // console.log('Error:', data);
                                    //$('#modalPenghargaan').modal('show');
                                }
                            })

                        },
                        error: function(data) {
                            // console.log('Error:', data);
                            //$('#modalPenghargaan').modal('show');
                        }
                    })

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            })





        });
    });
</script>

<script>
    $(document).ready(function() {
        // $("#edit").click(function() {

        var quill_description_issues_detail = new Quill("#description_issues_detail", {
            theme: "snow",
            modules: {
                "toolbar": false
            },
            // disabled: true,
            readOnly: true,
        });

        // quill_description_issues_detail.enable(false);

        $('#description_issues_detail').on('keydown', function(e) {
            // alert('key up');
            // console.log(e.keyCode);
            // return false;
            if (e.keyCode == 67) {

            } else if(e.keyCode == 65){

            } else {
                return false;
            }
        });

        var tiket_issues_detail = '';
        var tanggal_pembuatan_issues = '';
        var tanggal_batas_issues = '';
        var priority_id_update = '';
        var m_kategori_id = '';
        var m_subject_id = '';
        var m_layanan_id = '';

        $(document).on('click', '#description_detail', function() {
            // console.log('coba');
            tiket_issues_detail = $(this).attr("data-tiket_issues");
            var username_sap_issues = $(this).attr("data-username_sap_issues");
            var nama_pegawai = $(this).attr("data-nama_pegawai");
            var created_by = $(this).attr("data-created_by");
            var telp_issues = $(this).attr("data-telp_issues");
            var nama_kategori = $(this).attr("data-nama_kategori");
            var nama_layanan = $(this).attr("data-nama_layanan");
            var nama_subject = $(this).attr("data-nama_subject");
            m_kategori_id = $(this).attr("data-m_kategori_id");
            m_layanan_id = $(this).attr("data-m_layanan_id");
            m_subject_id = $(this).attr("data-m_subject_id");
            var nama_priority = $(this).attr("data-nama_priority");
            priority_id_update = $(this).attr("data-priority_id");
            tanggal_pembuatan_issues = $(this).attr("data-tanggal_pembuatan_issues");
            tanggal_batas_issues = $(this).attr("data-tanggal_batas_issues");
            var issues_link_file_array = $(this).attr("data-issues_link_array");
            var issues_status_html = $(this).attr("data-issues_status_html");
            var append_html_priority_batas_mengganti = $(this).attr("data-append_html_priority_batas_mengganti");
            var tiket_simasti = $(this).attr("data-tiket_simasti");
            var status_issues = $(this).attr("data-status_issues");
            var no_wa = $(this).attr("data-no_wa");
            var security_incident = $(this).attr("data-security_incident");
            var major_incident = $(this).attr("data-major_incident");
            var qrcode_description = $(this).attr("data-qrcode");
            var flag = "<?php echo Session::get('user_app')['flag'] ?>";
            var unitId = "<?php echo Session::get('user_app')['unitId'] ?>";
            // console.log('tiket_simasti = ' + tiket_simasti);
            // console.log('m_layanan_id = ' + m_layanan_id);
            // var nama_subject_final = '';

            // console.log(priority_id_update);
            console.log('qrcode_description = ' + qrcode_description);
            console.log(status_issues);

            qrcode_description_html =
            '<button type="button" class="btn btn-sm mt-1 btn-primary waves-effect waves-light download_qr_code_class" '+
            'data-qrcode_description="'+ qrcode_description +'"'+
            'data-tiket_issues="'+ tiket_issues_detail +'"'+
            '<i class="bx bx-download"></i> '+
            'Download QrCode '+
            '</button>' ;

            $(".modal_qr_code_issues_detail").html(qrcode_description_html);

            if (security_incident == 'true'){
                $("#security_incident_detail").prop('checked',true);
            }else{
                $("#security_incident_detail").prop('checked',false);
            }

            if (major_incident == 'true'){
                $("#major_incident_detail").prop('checked',true);
            }else{
                $("#major_incident_detail").prop('checked',false);
            }

            if(m_layanan_id == 'L042'){
                $("#div_subject_helpdesk_edit").css("display", "none");
                $("#div_subject_simasiti_edit").css("display", "block");
                $('#layanan_id_edit').prop('disabled', true);
                $('#kategori_id_edit').prop('disabled', true);
            }else{
                $("#div_subject_helpdesk_edit").css("display", "block");
                $("#div_subject_simasiti_edit").css("display", "none");
                $('#layanan_id_edit').prop('disabled', false);
                $('#kategori_id_edit').prop('disabled', false);
            }
            // if(status_issues == 6){
            //     $("#status_open").hide();
            //     // $("#status_progress").hide();
            //     $("#status_on_hold").hide();
            //     $("#status_done").hide();
            //     $("#status_closed").hide();
            // }else{
            //     $("#status_open").show();
            //     $("#status_progress").show();
            //     $("#status_on_hold").show();
            //     $("#status_done").show();
            //     $("#status_closed").show();
            // }
            console.log('flag coba coba = ' + flag);
            if(flag == 'AS' || unitId == 'PBD200'){
                $('.div_visible_invisible_status_semua_2').show();
                $('.div_visible_invisible_status_semua_1').hide();
            }else{
                if(status_issues == 6){
                    $('.div_visible_invisible_status_semua_2').hide();
                    $('.div_visible_invisible_status_semua_1').show();
                }else{
                    $('.div_visible_invisible_status_semua_2').show();
                    $('.div_visible_invisible_status_semua_1').hide();
                }
            }

            $("#kategori_id_edit").val(m_kategori_id).trigger('change');
            $("#priority_id_update").val(priority_id_update).trigger('change');
            $("#priority_id").val("").trigger('change');

            $(".append_html_priority_batas_mengganti").html(append_html_priority_batas_mengganti);

            // // console.log(value);
            $("#subject_helpdesk").css("display", "block");
            $("#subject_simasti").css("display", "none");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getListLayanan')}}" + '/' + m_kategori_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    $("#layanan_id_edit").empty().append(data.data);
                    $("#layanan_id_edit").val(m_layanan_id).trigger('change');

                },
                error: function(data) {

                }
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getListSubject')}}" + '/' + m_layanan_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    $("#subject_id_edit").empty().append(data.data);
                    $("#subject_id_edit").val(m_subject_id).trigger('change');

                },
                error: function(data) {
                }
            });

            $('#kategori_id_edit').on("select2:select", function(e) {

                var m_kategori_id_edit = $("#kategori_id_edit option:selected").val();
                console.log('m_kategori_id_edit' + m_kategori_id_edit);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#formTambahIssues').serialize(),
                    url: "{{url('issues/getListLayanan')}}" + '/' + m_kategori_id_edit,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {

                        $("#layanan_id_edit").empty();
                        $("#layanan_id_edit").empty().append(data.data);
                        $("#subject_id_edit").empty();

                    },
                    error: function(data) {
                    }
                });

            });

            $('#layanan_id_edit').on("select2:select", function(e) {

                var m_layanan_id_edit = $("#layanan_id_edit option:selected").val();
                console.log('m_layanan_id_edit' + m_layanan_id_edit);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#formTambahIssues').serialize(),
                    url: "{{url('issues/getListSubject')}}" + '/' + m_layanan_id_edit,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {

                        $("#subject_id_edit").empty().append(data.data);
                        $("#subject_id_edit").val(m_subject_id).trigger('change');

                    },
                    error: function(data) {
                    }
                });

            });


            if (m_layanan_id == 'L042') {

                const tiket_simasti_array = tiket_simasti.split("~");
                // console.log(tiket_simasti_array);
                // console.log(tiket_simasti_array.length);

                var subject_gabungan = '';

                // for (var s = 0; s < tiket_simasti_array.length; s++) {

                //     $.ajax({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //         },
                //         // data: $('#formTambahIssues').serialize(),
                //         url: "{{url('api/getListDataAssetSimastiDenganNomor')}}" + '/' + tiket_simasti_array[s],
                //         type: "GET",
                //         dataType: 'json',
                //         success: function(data) {
                //             // console.log('ini asset dari simasti');
                //             // console.log(data);
                //             if (data.data == 'Data Tidak Ditemukan') {

                //                 var nama_subject_final = '';
                //                 subject_gabungan += nama_subject_final;

                //                 // $('#subject_nama_detail').val(nama_subject_final + ' ( ' + 'Nomor Urut Di Aplikasi Simasti Tidak Ditemukan, Kemungkinan Nomor Urut Pada Aplikasi Simasti Di Hapus Setelah Issues Pada Aplikasi Hepldesk Dimasukan' + ' ) ');

                //             } else {

                //                 var no_aset = data.data.no_aset;
                //                 var model = data.data.model;
                //                 var nama_kategori = data.data.nama_kategori;
                //                 var nama_subject_final = nama_subject + ' ( ' + no_aset + ' - ' + model + ' - ' + nama_kategori + ' ) ';
                //                 subject_gabungan += nama_subject_final;

                //                 // $('#subject_nama_detail').val(nama_subject_final);

                //             }


                //             // var get_description_issues = data.description_issues;
                //             // var get_status_issues_html = data.status_issues_html;

                //             // $("#description_issues_detail").html(get_description_issues);
                //             // $(".modal_judul_issues_detail_status").html(get_status_issues_html);

                //             // $('#layanan_id').select2({data: [{id: '', text: ''}]});

                //             // $("#subject_id").empty().append(data.data);

                //         },
                //         error: function(data) {
                //             // console.log('Error:', data);
                //             //$('#modalPenghargaan').modal('show');
                //         }
                //     });

                // }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#formTambahIssues').serialize(),
                    url: "{{url('api/getListDataAssetSimastiDenganTiketSismatiByTiketIssuesHelpdesk')}}" + '/' + tiket_issues_detail,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        // console.log('ini asset dari simasti');
                        // console.log(data);

                        $('#subject_nama_detail').val(data.data);
                        $('#jumlah_data_simasti').html(data.jumlah_data_sudah_selesai + ' / ' + (data.jumlah_data_sudah_selesai + data.jumlah_data_belum_selesai));

                        if (data.jumlah_data_sudah_selesai == data.jumlah_data_sudah_selesai + data.jumlah_data_belum_selesai) {
                            // $("#status_done").css("display", "none");
                            $('#status_done').show();
                            // if(status_issues == 6){
                            //     $("#status_open").hide();
                            //     // $("#status_progress").hide();
                            //     $("#status_on_hold").hide();
                            //     $("#status_done").hide();
                            //     $("#status_closed").hide();
                            // }else{
                            //     $("#status_open").show();
                            //     $("#status_progress").show();
                            //     $("#status_on_hold").show();
                            //     $("#status_done").show();
                            //     $("#status_closed").show();
                            // }
                        } else {
                            // $("#status_done").css("display", "block");
                            $('#status_done').hide();
                        }


                    },
                    error: function(data) {
                        // console.log('Error:', data);
                        //$('#modalPenghargaan').modal('show');
                    }
                });


                // console.log(subject_gabungan);


            } else {
                var nama_subject_final = nama_subject;

                $('#subject_nama_detail').val(nama_subject_final);
                $('#jumlah_data_simasti').html('');
                $('#status_done').show();
                // if(status_issues == 6){
                //     $("#status_open").hide();
                //     // $("#status_progress").hide();
                //     $("#status_on_hold").hide();
                //     $("#status_done").hide();
                //     $("#status_closed").hide();
                // }else{
                //     $("#status_open").show();
                //     $("#status_progress").show();
                //     $("#status_on_hold").show();
                //     $("#status_done").show();
                //     $("#status_closed").show();
                // }
            }

            $(".modal_judul_issues_detail").html('Detail Issues ' + '( ' + tiket_issues_detail + ' )');


            $('#username_sap_issues_detail').val(username_sap_issues);
            // $('#nama_pegawai_detail').val(nama_pegawai);
            $('#created_by_detail').val(created_by);
            $('#telp_issues_detail').val(telp_issues);
            $('#kategori_nama_detail').val(nama_kategori);
            $('#layanan_nama_detail').val(nama_layanan);
            // $('#subject_nama_detail').val(nama_subject);
            $('#priority_nama_detail').val(nama_priority);
            $('#perkiraan_selesai_y_m_d_detail').val(tanggal_batas_issues);
            $('#no_wa_detail').val(no_wa);
            $('#security_incident_detail').val(security_incident);
            $('#major_incident_detail').val(major_incident);

            // $('#tanggal_batas_issues_detail').val(tanggal_batas_issues);

            $(".append_div_file_detail").html(issues_link_file_array);

            // console.log(tiket_issues_detail);

            $("#description_issues_detail").html('');

            // description_issues_detail

            // var moment = require('moment-business-days');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getDescriptionIssues')}}" + '/' + tiket_issues_detail,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    // console.log(data.description_issues);
                    var get_description_issues = data.description_issues;
                    var get_status_issues_html = data.status_issues_html;

                    $("#description_issues_detail").html(get_description_issues);
                    $(".modal_judul_issues_detail_status").html(get_status_issues_html);

                    // $('#layanan_id').select2({data: [{id: '', text: ''}]});

                    // $("#subject_id").empty().append(data.data);

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });


            // // console.log(myEditor);

            // var coba = $('#description_issues').html('');
            // $("#description_issues_detail").html('');


            // quill_description_issues_detail.root.innerHTML = "<div class='r'>Some text</div>";

            $('#tb_komentar').DataTable().destroy();

            var tb_komentar = $('#tb_komentar').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollX: true,
                scrollY: "280px",
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
                    url: "{{ url('issues/getListDataKomentar') }}" + "/" + tiket_issues_detail,
                    type: 'GET',
                },
                columns: [{
                        data: 'photo',
                        name: 'photo',
                        className: 'text-center',
                        width: "20%",
                    },
                    // {
                    //     data: 'nama_pegawai',
                    //     name: 'nama_pegawai',
                    //     className: 'text-center',
                    //     width: "20%",
                    // },
                    {
                    data: 'komentar',
                    name: 'komentar',
                    className: 'text-center',
                    width: "80%",
                    render: function(data, type, row) {
                        // Combine comment and formatted date with adjusted margin-top
                        var formattedDate = row.created_at ?
                            '<small style="color: #6c757d; font-size: 0.85em; display: block; margin-top: -2px; text-align: right;">' + row.created_at + '</small>'
                            : '';
                        return data + formattedDate;
                    },
                },
                ],
                drawCallback: function(settings) {
                    // alert('DataTables has redrawn the table');
                    // alert(settings);
                    var api = this.api();
                    var api_lenght = api.rows({
                        page: 'current'
                    }).data().length;
                    // // console.log( api.rows( {page:'current'} ).data().length );
                    // // console.log(settings);
                    for (var i = 0; i < api_lenght; i++) {
                        var quill_komentar_list_ckeditor = new Quill(".komentar_list_ckeditor" + i, {
                            theme: "snow",
                            modules: {
                                "toolbar": false
                            },
                            disabled: true,
                        });

                        $('#komentar_list_ckeditor' + i).on('keydown', function() {
                            // alert('key up');
                            return false;
                        });
                    }

                },
                error: function(xhr, error, code) {
                    // // console.log(xhr, code);
                    $('#tb_komentar').DataTable().ajax.reload(null, false);
                }
            })



            // console.log('tb_detail_status coba');

            $('#tb_detail_status').DataTable().destroy();

            var tb_detail_status = $('#tb_detail_status').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                scrollX: false,
                scrollY: "130px",
                sDom: 'lrtip', // untuk hidden search box di datatable
                autoWidth: false,
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
                    url: "{{ url('issues/getListDataRiwayatStatusIssues') }}" + "/" + tiket_issues_detail,
                    type: 'GET',
                },
                columns: [{
                        data: 'no',
                        name: 'no',
                        className: 'text-center',
                        // width: "5%",
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
                        // width: "20%",
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        className: 'text-center',
                        // width: "20%",
                    },
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
                    // console.log(' anti rewel coba');

                    var api = this.api();
                    var api_lenght = api.rows({
                        page: 'current'
                    }).data().length;
                    // // console.log( api.rows( {page:'current'} ).data().length );
                    // // console.log(settings);
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
                    // // console.log(xhr, code);
                    $('#tb_detail_status').DataTable().ajax.reload(null, false);
                }
            })

            // console.log('coba');
            notifikasi_firebase.endAt().limitToLast(1).on('child_added', function(snapshot) {
                // console.log('cba1' + snapshot.val().tiket_issues);
                // console.log('cba2' + tiket_issues_detail);
                if (snapshot.val().tiket_issues == tiket_issues_detail) {
                    // console.log('ini itu');
                    if (!$.fn.DataTable.isDataTable('#tb_komentar')) {
                        // $('#example').dataTable();
                    } else {
                        $('#tb_komentar').DataTable().ajax.reload(null, false);
                    }

                } else {
                    // console.log('kocak');
                }
                // if (snapshot.val().tiket_issues == tiket_issues_detail) {
                // $('#tb_komentar').DataTable().ajax.reload(null, false);
                // }
            });

        });

        $('.formKirimKomentarIssues').submit(function(event) {
            // // console.log('coba');
            var komentar_issues_detail = $('#komentar_issues_detail').html();

            var formData = new FormData(this);
            formData.append('komentar_issues_detail', komentar_issues_detail);
            formData.append('tiket_issues_detail', tiket_issues_detail);

            // // console.log(formData);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // contentType: 'multipart/form-data',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                url: "{{url('issues/kirimKomentar')}}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    // console.log(data.kode);
                    if (data.kode == 201) {
                        toastr.clear();
                        toastr.success(data.success);

                        $('#tb_issues').DataTable().ajax.reload(null, false);
                        $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                        $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                        $('#tb_detail_status').DataTable().ajax.reload(null, false);

                        $('#tb_komentar').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.clear();
                        toastr.error(data.success);
                    }

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });


        });


        function isCanvasEmpty(canvasInput) {
            const blank = document.createElement('canvas');

            blank.width = canvasInput.width;
            blank.height = canvasInput.height;

            console.log(blank.toDataURL());
            console.log(canvasInput.toDataURL());

            return canvasInput.toDataURL() === blank.toDataURL();
        }

        let canvas;
        let canvas_2;
        let signaturePad;
        let signaturePad_2;
        var status_change

        $(document).on('click', '.status_change', function() {
            status_change = $(this).attr("data-status_change");
            // console.log(status_change);
            var status_id = 0;
            var popover_status;
            var input;

            if (status_change == 'status_open') {
                status_id = 1;
                popover_status = "";
                input = 'textarea';
                $('.swal2-confirm').prop('disabled', false);
            } else if (status_change == 'status_progress') {
                status_id = 2;
                popover_status = "";
                input = 'textarea';
                $('.swal2-confirm').prop('disabled', false);
            } else if (status_change == 'status_done') {
                status_id = 3;
                // popover_status = "";
                popover_status = "";
                input = 'textarea';
                $('.swal2-confirm').prop('disabled', false);
            } else if (status_change == 'status_closed') {
                status_id = 4;
                console.log(m_kategori_id);
                if ("{{Session::get('user_app')['role']}}" == "R003") {
                    var display_tandatangan_admin = "style='display:none'";
                }else{
                    var display_tandatangan_admin = "";
                }
                if(m_kategori_id == "K11" || m_kategori_id == "K03" || m_kategori_id == "K17"){
                    if(m_subject_id == "S017" || m_layanan_id != "L060"){
                        popover_status =
                        '<form name="formSuratPerjanjianIssues" id="formSuratPerjanjianIssues">' +
                        // '<iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="{{url("issues/surat_perjanjian_issues")}}/' + tiket_issues_detail + '" style="width: 100%;" height="340px"></iframe>' +
                        // '<iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="{{ asset("pdf/web/viewer.html?file=". urlencode(url("issues/surat_perjanjian_issues"))) }}/' + tiket_issues_detail + '" style="width: 100%;" height="340px"></iframe>' +
                        '<iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="{{ asset("public/pdf/web/viewer.html?file=" . urlencode(url("issues/surat_perjanjian_issues_bukan_inventaris_ti"))) }}/' + tiket_issues_detail + '" style="width: 100%;" height="420px"></iframe>' +
                        // '<iframe id="iframeMemo" src="{{ asset("public/pdf/web/viewer.html?file=". urlencode(url("issues/surat_perjanjian_issues/' + 'HLP-22-000032' + '"))) }}" frameborder="0" height="1000px" width="100%"></iframe>' +
                        // '<object data="{{url("issues/surat_perjanjian_issues")}}/' + tiket_issues_detail + '" type="application/pdf">' +
                        // '<div>' +
                        // '<embed src="{{url("issues/surat_perjanjian_issues")}}/' + tiket_issues_detail + '" style="width: 100%;" height="450px"></embed>' +
                        // '</div>' +
                        // '</object>' +
                        '</form>' +
                        '<div class="row align-items-start">' +
                        '<div class="col-8 mb-2 mt-2" style="text-align:left">' +
                        '<b>Klik checkbox terlebih dahulu sebelum anda ingin merubah status isu menjadi closed</b>' +
                        '</div>' +
                        '<div class="col-4 mb-2 mt-2">' +
                        '<div class="form-check"> ' +
                        '<input class="form-check-input check_term_closed_bukan_inventaris" type="checkbox" value="" id="check_term_closed_bukan_inventaris" name="check_term_closed_bukan_inventaris">' +
                        // '<label class="form-check-label" for="flexCheckDefault"> ' +
                        // 'Klik checkbox jika anda ingin merubah status isu menjadi closed '
                        // '</label> ' +
                        '</div>'+
                        '</div>' +
                        '</div>'
                        ;
                        input = '';
                    }else{
                        popover_status = '<form name="formSuratPerjanjianIssues" id="formSuratPerjanjianIssues">' +
                        // '<iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="{{url("issues/surat_perjanjian_issues")}}/' + tiket_issues_detail + '" style="width: 100%;" height="340px"></iframe>' +
                        // '<iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="{{ asset("pdf/web/viewer.html?file=". urlencode(url("issues/surat_perjanjian_issues"))) }}/' + tiket_issues_detail + '" style="width: 100%;" height="340px"></iframe>' +
                        '<iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="{{ asset("public/pdf/web/viewer.html?file=" . urlencode(url("issues/surat_perjanjian_issues"))) }}/' + tiket_issues_detail + '" style="width: 100%;" height="340px"></iframe>' +
                        // '<iframe id="iframeMemo" src="{{ asset("public/pdf/web/viewer.html?file=". urlencode(url("issues/surat_perjanjian_issues/' + 'HLP-22-000032' + '"))) }}" frameborder="0" height="1000px" width="100%"></iframe>' +
                        // '<object data="{{url("issues/surat_perjanjian_issues")}}/' + tiket_issues_detail + '" type="application/pdf">' +
                        // '<div>' +
                        // '<embed src="{{url("issues/surat_perjanjian_issues")}}/' + tiket_issues_detail + '" style="width: 100%;" height="450px"></embed>' +
                        // '</div>' +
                        // '</object>' +

                        // '<table style="width:100%">' +
                        // '<tr>' +
                        // '<td>' +
                        '<div class="row" style="width:100%; height:100%">' +
                        '<div class="col-xl-6">' +
                        '<div id="sig-canvas_1" class="sig-canvas_1">' +
                        '<div class="sig-canvas_1--body">' +
                        '<canvas style="border: 2px solid black;" id="canvas_1" name="canvas_1" width="260px"></canvas>' +
                        '</div>' +
                        '<br/>' +
                        '<div class="sig-canvas_1--footer">' +
                        '<div class="description">Tanda tangan (Requester)</div>' +
                        '<br/>' +
                        '<div class="sig-canvas_1--actions">' +
                        '<div class="d-grid gap-3 col-6 mx-auto">' +
                        '<input type="text" max-height="100%" max-height="100%" name="masukan_tanda_tangan_1_atas_nama" id="masukan_tanda_tangan_1_atas_nama" class="form-control w-80" placeholder="Atas Nama (Requester)">' +
                        '</div>' +
                        '<div>' +
                        '<button type="button" id="masukan_tanda_tangan_1" name="masukan_tanda_tangan_1" class="btn btn-md btn-primary mt-1 mb-1">Masukan TTD Requester</button>' +
                        '&nbsp;&nbsp;' +
                        '<button type="button" class="btn btn-md btn-primary mt-1 mb-1 clear" data-action="clear">Bersihkan</button>' +
                        '&nbsp;&nbsp;' +
                        '<button type="button" class="btn btn-md btn-primary mt-1 mb-1" data-action="undo">Undo</button>' +
                        '</div>' +
                        // '<div>' +
                        // '<select data-action="download">' +
                        // '<option>Simpan Gambar: </option>' +
                        // '<option value="png">- PNG</option>' +
                        // '<option value="jpg">- JPG</option>' +
                        // '<option value="svg">- SVG</option>' +
                        // '</select>' +
                        // '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-xl-6"' + display_tandatangan_admin + '>' +
                        '<div id="sig-canvas_2" class="sig-canvas_2">' +
                        '<div class="sig-canvas_2--body">' +
                        '<canvas style="border: 2px solid black;" id="canvas_2" name="canvas_2" width="260px"></canvas>' +
                        '</div>' +
                        '<br/>' +
                        '<div class="sig-canvas_2--footer">' +
                        '<div class="description">Tanda Tangan (Staff IT)</div>' +
                        '<br/>' +
                        '<div class="sig-canvas_2--actions">' +
                        '<div class="d-grid gap-3 col-6 mx-auto">' +
                        '<input type="text" max-height="100%" max-height="100%" name="masukan_tanda_tangan_2_atas_nama" id="masukan_tanda_tangan_2_atas_nama" class="form-control w-80" placeholder="Atas Nama (Staff IT)">' +
                        '</div>' +
                        '<div>' +
                        '<button type="button" id="masukan_tanda_tangan_2" name="masukan_tanda_tangan_2" class="btn btn-md btn-primary mt-1 mb-1">Masukan TTD Staf TI</button>' +
                        '&nbsp;&nbsp;' +
                        '<button type="button" class="btn btn-md btn-primary mt-1 mb-1 clear" data-action="clear">Bersihkan</button>' +
                        '&nbsp;&nbsp;' +
                        '<button type="button" class="btn btn-md btn-primary mt-1 mb-1" data-action="undo">Undo</button>' +
                        '</div>' +
                        // '<div>' +
                        // '<select data-action="download">' +
                        // '<option>Simpan Gambar: </option>' +
                        // '<option value="png">- PNG</option>' +
                        // '<option value="jpg">- JPG</option>' +
                        // '<option value="svg">- SVG</option>' +
                        // '</select>' +
                        // '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        // '</td>' +
                        // '</tr>' +
                        // '</table>' +

                        '</form>';
                        input = '';
                    }

                }else{
                    popover_status =
                    '<form name="formSuratPerjanjianIssues" id="formSuratPerjanjianIssues">' +
                    // '<iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="{{url("issues/surat_perjanjian_issues")}}/' + tiket_issues_detail + '" style="width: 100%;" height="340px"></iframe>' +
                    // '<iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="{{ asset("pdf/web/viewer.html?file=". urlencode(url("issues/surat_perjanjian_issues"))) }}/' + tiket_issues_detail + '" style="width: 100%;" height="340px"></iframe>' +
                    '<iframe id="iframe_surat_perjanjian" name="iframe_surat_perjanjian" src="{{ asset("public/pdf/web/viewer.html?file=" . urlencode(url("issues/surat_perjanjian_issues_bukan_inventaris_ti"))) }}/' + tiket_issues_detail + '" style="width: 100%;" height="420px"></iframe>' +
                    // '<iframe id="iframeMemo" src="{{ asset("public/pdf/web/viewer.html?file=". urlencode(url("issues/surat_perjanjian_issues/' + 'HLP-22-000032' + '"))) }}" frameborder="0" height="1000px" width="100%"></iframe>' +
                    // '<object data="{{url("issues/surat_perjanjian_issues")}}/' + tiket_issues_detail + '" type="application/pdf">' +
                    // '<div>' +
                    // '<embed src="{{url("issues/surat_perjanjian_issues")}}/' + tiket_issues_detail + '" style="width: 100%;" height="450px"></embed>' +
                    // '</div>' +
                    // '</object>' +
                    '</form>' +
                    '<div class="row align-items-start">' +
                    '<div class="col-8 mb-2 mt-2" style="text-align:left">' +
                    '<b>Klik checkbox terlebih dahulu sebelum anda ingin merubah status isu menjadi closed</b>' +
                    '</div>' +
                    '<div class="col-4 mb-2 mt-2">' +
                    '<div class="form-check"> ' +
                    '<input class="form-check-input check_term_closed_bukan_inventaris" type="checkbox" value="" id="check_term_closed_bukan_inventaris" name="check_term_closed_bukan_inventaris">' +
                    // '<label class="form-check-label" for="flexCheckDefault"> ' +
                    // 'Klik checkbox jika anda ingin merubah status isu menjadi closed '
                    // '</label> ' +
                    '</div>'+
                    '</div>' +
                    '</div>'
                    ;
                    input = '';
                }

            } else if (status_change == 'status_close') {
                status_id = 5;
                popover_status = "";
                input = 'textarea';
            } else if (status_change == 'status_on_hold') {
                status_id = 6;
                popover_status = "";
                input = 'textarea';
            }

            // console.log(status);



            Swal.fire({
                title: 'Catatan Isu',
                input: input,
                html: true,
                html: popover_status,
                customClass: 'swal-wide-850',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
            }).then(function(result) {
                // if (result.value) {
                // Swal.fire(result.value)

                if (result.dismiss == 'cancel') {

                    document.getElementById("body_overflow").style.overflow = "hidden";
                    $('.swal2-confirm').prop('disabled', false);
                    $('.check_term_closed_bukan_inventaris').prop('checked', false);

                    var oldcanv = document.getElementById('canvas_1');
                    oldcanv.remove()

                    var oldcanv_2 = document.getElementById('canvas_2');
                    oldcanv_2.remove()

                    // console.log('cancel');
                } else {

                    // console.log('coba 222');



                    var get_catatan_value;
                    // var inputanData = new FormData(this);
                    // formData.append('catatan', get_catatan_value);
                    var formData = new FormData();

                    // var formData = new FormData(this);
                    // formData.append('komentar_issues_detail', komentar_issues_detail);
                    formData.append('tiket_issues_detail', tiket_issues_detail);
                    formData.append('status_id', status_id);

                    // if (status_id == '3') {
                    //     get_catatan_value = $('#catatan_status_done').html().replaceAll('type="text"', 'type="hidden"');
                    //     get_catatan_value = get_catatan_value.replaceAll('class="ql-editor"', 'class="ql-editor catatan_status_keydown_false"');
                    //     get_catatan_value = get_catatan_value.replaceAll('<img', '<img style="width:50%; height:50%;" ');
                    //     // get_catatan_value = $('#catatan_status_done').html();
                    // } else {
                    //     get_catatan_value = result.value;
                    // }

                    get_catatan_value = result.value;

                    formData.append('catatan', get_catatan_value);


                    // var get_catatan_value = result.value;
                    // var array_inputan = [];
                    // array_inputan.push(get_catatan_value);
                    // var inputan = {};
                    // inputan['catatan'] = get_catatan_value;

                    // // console.log(inputan);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        // contentType: 'multipart/form-data',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        url: "{{url('issues/tambahStatus')}}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            // console.log(data.kode);
                            if (data.kode == 201) {
                                toastr.clear();
                                toastr.success(data.success);
                                // document.location = "{{ url('/home/index') }}";
                                $("#modalFormTambahIssues").modal('hide');
                                $('#tb_issues').DataTable().ajax.reload(null, false);
                                $('#tb_issues').DataTable().ajax.reload(null, false);
                                $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                                $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                                $('#tb_detail_status').DataTable().ajax.reload(null, false);
                                $("#perkiraan_selesai_y_m_d_detail").val(data.tanggal_batas_issues);
                                console.log('coba_tanggal_batas_issues' + data.tanggal_batas_issues);
                                // $(".modal_judul_issues_detail_status").html(data.tiket_issues);
                                // $("#komentar_issues_detail").html(' a ');
                                // var oldcanv = document.getElementById('canvas_1');
                                // document.removeChild(oldcanv);

                                // var oldcanv_2 = document.getElementById('canvas_2');
                                // document.removeChild(oldcanv_2);

                                // var searchTimeoutRefreshPage = setTimeout(function() {
                                //     document.location = "{{ url('/home/index') }}";
                                // }, 700);
                            } else {
                                // toastr.clear();
                                // toastr.error(data.success);

                                Swal.fire({
                                    icon: 'info',
                                    title: 'Status Isu',
                                    text: data.success,
                                }).then(function(result) {

                                    if (result.dismiss == 'cancel') {
                                        // console.log('cancel');
                                    } else {
                                        $('#tb_issues').DataTable().ajax.reload(null, false);
                                        $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                                        $('#modalIssuesDetail').modal('hide');
                                    }

                                    // }
                                });

                            }

                        },
                        error: function(data) {
                            // console.log('Error:', data);
                            //$('#modalPenghargaan').modal('show');
                        }
                    });

                    console.log('coba');

                    var oldcanv = document.getElementById('canvas_1');
                    oldcanv.remove()

                    var oldcanv_2 = document.getElementById('canvas_2');
                    oldcanv_2.remove()
                }

                // }
            });

            if (m_kategori_id == "K11" || m_kategori_id == "K03" || m_kategori_id == "K17"){
                if (m_subject_id == "S017" || m_layanan_id != "L060"){

                } else {
                    const wrapper = document.getElementById("sig-canvas_1");
                    canvas = document.getElementById("canvas_1");
                    signaturePad = new SignaturePad(canvas, {
                        // backgroundColor: 'rgb(255, 255, 255)'
                    });

                    const dataURLToBlob = (dataURL) => {
                        const parts = dataURL.split(';base64,');
                        const contentType = parts[0].split(":")[1];
                        const raw = window.atob(parts[1]);
                        const rawLength = raw.length;
                        const uInt8Array = new Uint8Array(rawLength);

                        for (let i = 0; i < rawLength; ++i)
                            uInt8Array[i] = raw.charCodeAt(i);

                        return new Blob([uInt8Array], {
                            type: contentType
                        });
                    }

                    const clearButton = wrapper.querySelector("[data-action=clear]");
                    clearButton.addEventListener("click", () => {
                        signaturePad.clear();
                    });

                    const undoButton = wrapper.querySelector("[data-action=undo]");
                    undoButton.addEventListener("click", () => {
                        var data = signaturePad.toData();

                        if (data) {
                            data.pop();
                            signaturePad.fromData(data);
                        }
                    });

                    const wrapper_2 = document.getElementById("sig-canvas_2");
                    canvas_2 = document.getElementById("canvas_2");
                    signaturePad_2 = new SignaturePad(canvas_2, {
                        // backgroundColor: 'rgb(255, 255, 255)'
                    });

                    const dataURLToBlob_2 = (dataURL_2) => {
                        const parts_2 = dataURL_2.split(';base64,');
                        const contentType_2 = parts_2[0].split(":")[1];
                        const raw_2 = window.atob(parts_2[1]);
                        const rawLength_2 = raw_2.length;
                        const uInt8Array_2 = new Uint8Array(rawLength_2);

                        for (let i = 0; j < rawLength_2; ++j)
                            uInt8Array_2[j] = raw_2.charCodeAt(j);

                        return new Blob([uInt8Array_2], {
                            type: contentType
                        });
                    }

                    const clearButton_2 = wrapper_2.querySelector("[data-action=clear]");
                    clearButton_2.addEventListener("click", () => {
                        signaturePad_2.clear();
                    });

                    const undoButton_2 = wrapper_2.querySelector("[data-action=undo]");
                    undoButton_2.addEventListener("click", () => {
                        var data_2 = signaturePad_2.toData();

                        if (data_2) {
                            data_2.pop();
                            signaturePad_2.fromData(data_2);
                        }
                    });

                    $(document).on('click', '#masukan_tanda_tangan_1_hapus', function() {
                        clearCanvas();
                        $('#masukan_tanda_tangan_1_atas_nama').val('');
                    });

                    $(document).on('click', '#masukan_tanda_tangan_2_hapus', function() {
                        clearCanvas_2();
                        $('#masukan_tanda_tangan_2_atas_nama').val('');
                    });
                }


            }else{

            }


            var quill_catatan_status_done = new Quill("#catatan_status_done", {
                theme: "snow",
                modules: {
                    toolbar: [
                        [{
                            font: []
                        }, {
                            size: []
                        }],
                        ["bold", "italic", "underline", "strike"],
                        [{
                            color: []
                        }, {
                            background: []
                        }],
                        [{
                            script: "super"
                        }, {
                            script: "sub"
                        }],
                        [{
                            header: [!1, 1, 2, 3, 4, 5, 6]
                        }, "blockquote", "code-block"],
                        [{
                            list: "ordered"
                        }, {
                            list: "bullet"
                        }, {
                            indent: "-1"
                        }, {
                            indent: "+1"
                        }],
                        ["direction", {
                            align: []
                        }],
                        ["link", "image", "video"],
                        ["clean"]
                    ]
                }
            });



            // $(document).on('change', '#check_term_closed_bukan_inventaris', function() {
            //    console.log(this.checked);
            // });

            // $('#check_term_closed_bukan_inventaris').change(function () {
            //     console.log(this.checked);
            // });

            // $(document).on('click', '#check_term_closed_bukan_inventaris', function() {
            //     clearCanvas_2();
            //     $('#masukan_tanda_tangan_2_atas_nama').val('');
            // });
            console.log(m_kategori_id);
            console.log(status_change);
            if(m_kategori_id == "K11" || m_kategori_id == "K03" || m_kategori_id == "K17"){
                // $('.swal2-confirm').prop('disabled', false);
                // console.log('1');
                if (m_subject_id == "S017" || m_layanan_id != "L060"){
                    if(status_change == 'status_closed'){
                        $('.swal2-confirm').prop('disabled', true);
                        console.log('2');
                    }else{
                        $('.swal2-confirm').prop('disabled', false);
                        console.log('3');
                    }
                } else {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        // data: $('#formTambahIssues').serialize(),
                        url: "{{url('issues/getTandaTanganSuratPerjanjianIssues')}}" + '/' + tiket_issues_detail,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {

                            // console.log('getTandaTanganSuratPerjanjianIssues');
                            // console.log(data);
                            if(data.get_tandatangan_issues.tanda_tangan != null){
                                console.log('123');
                                $('.swal2-confirm').prop('disabled', false);
                            }else{
                                console.log('456');
                                $('.swal2-confirm').prop('disabled', true);
                            }

                        },
                        error: function(data) {
                            // console.log('Error:', data);
                            //$('#modalPenghargaan').modal('show');
                        }
                    });
                }

            }else{
                if(status_change == 'status_closed'){
                    $('.swal2-confirm').prop('disabled', true);
                    console.log('2');
                }else{
                    $('.swal2-confirm').prop('disabled', false);
                    console.log('3');
                }
            };

            $('.check_term_closed_bukan_inventaris').change(function() {
                if(this.checked) {
                    // console.log('ini check');
                    $('.swal2-confirm').prop('disabled', false);
                }else{
                    // console.log('ini tidak check');
                    $('.swal2-confirm').prop('disabled', true);
                }
            });


        });

        function loadIframe(iframeName, url) {
            var $iframe = $('#' + iframeName);
            if ($iframe.length) {
                $iframe.attr('src', url);
                return false;
            }
            return true;
        }


        $(document).on('click', '#masukan_tanda_tangan_1', function() {
            // var formDataSuratPerjanjian = new FormData(this);
            // // console.log('masukan_tanda_tangan');
            // console.log('ini klik masukan_tanda_tangan_1');
            // var dataUrl = canvas.toDataURL();
            if (isCanvasEmpty(canvas)){
                // alert('Empty!');
                var dataUrl = "";
            }else{
                // alert('Not Empty!!');
                var dataUrl = canvas.toDataURL();
            }

            // var dataUrl = canvas.toDataURL();
            var masukan_tanda_tangan_1_atas_nama = $('#masukan_tanda_tangan_1_atas_nama').val();
            // console.log(dataUrl);
            var formSuratPerjanjianIssues =
                // $("#formSuratPerjanjianIssues").serialize() +
                "tanda_tangan=" + encodeURIComponent(dataUrl) +
                "&tiket_issues=" + tiket_issues_detail +
                "&atas_nama=" + masukan_tanda_tangan_1_atas_nama +
                "&tanda_tangan_kategori=" + "1";



            // console.log(formSuratPerjanjianIssues);

            // formDataSuratPerjanjian.append('tanda_tangan', dataUrl);
            // formDataSuratPerjanjian.append('tiket_issues', tiket_issues_detail);
            // sigText.innerHTML = dataUrl;
            // sigImage.setAttribute("src", dataUrl);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // contentType: 'multipart/form-data',
                data: formSuratPerjanjianIssues,
                url: "{{url('issues/update_tanda_tangan_surat_perjanjian_issues')}}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    // console.log(data.kode);
                    if (data.kode == 201) {
                        toastr.clear();
                        toastr.success(data.success);
                        loadIframe('iframe_surat_perjanjian', '{{asset("public/pdf/web/viewer.html?file=" . urlencode(url("issues/surat_perjanjian_issues")))}}/' + tiket_issues_detail);
                        // clearCanvas();
                        signaturePad.clear();
                        $('#masukan_tanda_tangan_1_atas_nama').val('');
                        if (data.tanda_tangan == null || data.tanda_tangan == "") {

                        } else {
                                    // $("#simpan_surat_perjanjian").removeAttr("disabled");
                        }
                        // document.location = "{{ url('/home/index') }}";
                        // $("#modalFormTambahIssues").modal('hide');
                        // $('#tb_issues').DataTable().ajax.reload(null, false);
                        // $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.clear();
                        toastr.error(data.success);
                    }

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        // data: $('#formTambahIssues').serialize(),
                        url: "{{url('issues/getTandaTanganSuratPerjanjianIssues')}}" + '/' + tiket_issues_detail,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {

                            // console.log('getTandaTanganSuratPerjanjianIssues');
                            // console.log(data);
                            if(data.get_tandatangan_issues.tanda_tangan != null){
                                console.log('123');
                                $('.swal2-confirm').prop('disabled', false);
                            }else{
                                console.log('456');
                                $('.swal2-confirm').prop('disabled', true);
                            }

                        },
                        error: function(data) {
                            // console.log('Error:', data);
                            //$('#modalPenghargaan').modal('show');
                        }
                    });

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });

        });

        $(document).on('click', '#masukan_tanda_tangan_2', function() {
            // var formDataSuratPerjanjian = new FormData(this);
            // // console.log('masukan_tanda_tangan');
            // var dataUrl_2 = canvas_2.toDataURL();
            if (isCanvasEmpty(canvas_2)){
                // alert('Empty!');
                var dataUrl_2 = "";
            }else{
                // alert('Not Empty!!');
                var dataUrl_2 = canvas_2.toDataURL();
            }
            var masukan_tanda_tangan_2_atas_nama = $('#masukan_tanda_tangan_2_atas_nama').val();
            // console.log(dataUrl_2);
            // console.log(encodeURIComponent(dataUrl_2));
            var formSuratPerjanjianIssues_2 =
                // $("#formSuratPerjanjianIssues").serialize() +
                "tanda_tangan=" + encodeURIComponent(dataUrl_2) +
                "&tiket_issues=" + tiket_issues_detail +
                "&atas_nama=" + masukan_tanda_tangan_2_atas_nama +
                "&tanda_tangan_kategori=" + "2";
            // console.log(formSuratPerjanjianIssues_2);

            // formDataSuratPerjanjian.append('tanda_tangan', dataUrl);
            // formDataSuratPerjanjian.append('tiket_issues', tiket_issues_detail);
            // sigText.innerHTML = dataUrl;
            // sigImage.setAttribute("src", dataUrl);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // contentType: 'multipart/form-data',
                data: formSuratPerjanjianIssues_2,
                url: "{{url('issues/update_tanda_tangan_surat_perjanjian_issues')}}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    // console.log(data.kode);
                    if (data.kode == 201) {
                        toastr.clear();
                        toastr.success(data.success);
                        loadIframe('iframe_surat_perjanjian', '{{asset("public/pdf/web/viewer.html?file=" . urlencode(url("issues/surat_perjanjian_issues")))}}/' + tiket_issues_detail);
                        // clearCanvas_2();
                        signaturePad_2.clear();
                        $('#masukan_tanda_tangan_2_atas_nama').val('');
                        if (data.tanda_tangan == null || data.tanda_tangan == "") {

                        } else {
                            // $("#simpan_surat_perjanjian").removeAttr("disabled");
                        }
                        // document.location = "{{ url('/home/index') }}";
                        // $("#modalFormTambahIssues").modal('hide');
                        // $('#tb_issues').DataTable().ajax.reload(null, false);
                        // $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.clear();
                        toastr.error(data.success);
                    }

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        // data: $('#formTambahIssues').serialize(),
                        url: "{{url('issues/getTandaTanganSuratPerjanjianIssues')}}" + '/' + tiket_issues_detail,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {

                            // console.log('getTandaTanganSuratPerjanjianIssues');
                            // console.log(data);
                            if(data.get_tandatangan_issues.tanda_tangan != null){
                                console.log('123');
                                $('.swal2-confirm').prop('disabled', false);
                            }else{
                                console.log('456');
                                $('.swal2-confirm').prop('disabled', true);
                            }

                        },
                        error: function(data) {
                            // console.log('Error:', data);
                            //$('#modalPenghargaan').modal('show');
                        }
                    });

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });

        });

        $('#priority_id_update').on("select2:select", function(e) {
            // what you would like to happen
            // // console.log(e);
            // $("#eselon_id_selected_input").val(eselon_id).select2();
            // https://javascript.tutorialink.com/calculate-dates-considering-public-holidays-and-weekends-with-moment-js-and-moment-business-days/

            // var priority_id_update = $("#priority_id_update").val();
            var priority_id_update = e.params.data.id;
            $("#priority_id_update").val(priority_id_update).trigger('change');
            // console.log(priority_id);
            // console.log('qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq');
            // console.log(tanggal_pembuatan_issues);

            var tanggal_pembuatan_issues_tahun = parseInt(tanggal_pembuatan_issues.substring(0, 4));
            var tanggal_pembuatan_issues_bulan = parseInt(tanggal_pembuatan_issues.substring(5, 7));
            var tanggal_pembuatan_issues_tanggal = parseInt(tanggal_pembuatan_issues.substring(8, 10));

            var tanggal_pembuatan_issues_jam = parseInt(tanggal_pembuatan_issues.substring(11, 13));
            var tanggal_pembuatan_issues_menit = parseInt(tanggal_pembuatan_issues.substring(14, 16));
            var tanggal_pembuatan_issues_detik = parseInt(tanggal_pembuatan_issues.substring(17, 19));

            // console.log(tanggal_pembuatan_issues_tahun + ' ' + tanggal_pembuatan_issues_bulan + ' ' + tanggal_pembuatan_issues_tanggal + ' ' + tanggal_pembuatan_issues_jam + ' ' + tanggal_pembuatan_issues_menit + ' ' + tanggal_pembuatan_issues_detik);

            var perkiraan_selesai;
            var perkiraan_selesai_y_m_d;
            var info_perkiraan_selesai_text;
            let start = "";
            let end = "";

            if (priority_id_update == "P001") {
                // console.log(1);

                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours'));

                perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);

                var format = 'hh:mm:ss';

                // var time = moment();
                var time = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    tanggal_pembuatan_issues_jam,
                    tanggal_pembuatan_issues_menit,
                    tanggal_pembuatan_issues_detik,
                    0
                ));
                // console.log('time ========' + time);
                // console.log('time' + moment(time).format("YYYY-MM-DD HH:mm:ss"));
                // var time = moment('18:30:00', format);
                // var jam_berangkat = moment('07:00:00', format);
                var jam_berangkat = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    7,
                    0,
                    0,
                    0
                ));
                // var jam_pulang = moment('16:00:00', format);
                var jam_pulang = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    16,
                    0,
                    0,
                    0
                ));
                // console.log('jam_pulang' + jam_pulang);

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;
                    end = moment(start).businessAdd(4, 'hours');
                    // console.log('end' + moment(end).format("YYYY-MM-DD HH:mm:ss"));

                    if (end > jam_pulang) {
                        // // console.log(end.diff(jam_pulang, "hours"));
                        // // console.log(end.diff(jam_pulang, "seconds"));
                        // console.log('end > jam_pulang');
                        var selisi_end_jam_pulang = end.diff(jam_pulang, "seconds");
                        // console.log('end' + end);
                        // console.log('start' + start);
                        // console.log('selisi_end_jam_pulang' + selisi_end_jam_pulang);
                        end = moment(new Date(
                                new Date().getFullYear(),
                                new Date().getMonth(),
                                new Date().getDate(),
                                7,
                                0,
                                0,
                                0
                            ))
                            .businessAdd(1, 'days')
                            .businessAdd(selisi_end_jam_pulang, 'seconds');

                        // console.log('end 1' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    } else {
                        // console.log('end < jam_pulang');
                        end = end;

                        // console.log('end 2' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    }

                    // // console.log(getSabtuMingguDays(start, end)[1]);

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');
                    end = moment(start).businessAdd(4, 'hours');

                }

                // start = start;
                // // console.log('ini start = ' + start);

                // // console.log('end' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                // // console.log('jam_pulang' + moment(jam_pulang).format("YYYY-MM-DD HH:mm:ss"));


                // // console.log(getSabtuMingguDays(start, end)[0][0]);
                // info_perkiraan_selesai_text = getSabtuMingguDays(start, end)[1];

            } else if (priority_id_update == "P002") {
                // console.log(2);

                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(8, 'hours'));

                perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(4, 'hours');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);

                var format = 'hh:mm:ss';

                // var time = moment();
                var time = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    tanggal_pembuatan_issues_jam,
                    tanggal_pembuatan_issues_menit,
                    tanggal_pembuatan_issues_detik,
                    0
                ));
                // console.log('time ========' + time);
                // console.log('time' + moment(time).format("YYYY-MM-DD HH:mm:ss"));
                // var time = moment('18:30:00', format);
                // var jam_berangkat = moment('07:00:00', format);
                var jam_berangkat = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    7,
                    0,
                    0,
                    0
                ));
                // var jam_pulang = moment('16:00:00', format);
                var jam_pulang = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    16,
                    0,
                    0,
                    0
                ));

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;
                    end = moment(start).businessAdd(8, 'hours');
                    // console.log('end' + moment(end).format("YYYY-MM-DD HH:mm:ss"));

                    if (end > jam_pulang) {
                        // // console.log(end.diff(jam_pulang, "hours"));
                        // // console.log(end.diff(jam_pulang, "seconds"));
                        // console.log('end > jam_pulang');
                        var selisi_end_jam_pulang = end.diff(jam_pulang, "seconds");
                        // console.log('end' + end);
                        // console.log('start' + start);
                        // console.log('selisi_end_jam_pulang' + selisi_end_jam_pulang);
                        end = moment(new Date(
                                new Date().getFullYear(),
                                new Date().getMonth(),
                                new Date().getDate(),
                                7,
                                0,
                                0,
                                0
                            ))
                            .businessAdd(1, 'days')
                            .businessAdd(selisi_end_jam_pulang, 'seconds');

                        // console.log('end 1' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    } else {
                        // console.log('end < jam_pulang');
                        end = end;

                        // console.log('end 2' + moment(end).format("YYYY-MM-DD HH:mm:ss"));
                    }

                    // // console.log(getSabtuMingguDays(start, end)[1]);

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');
                    end = moment(start).businessAdd(8, 'hours');

                }

                // // console.log(getSabtuMingguDays(start, end)[1]);
                // // console.log(getSabtuMingguDays(start, end)[0][0]);
                // info_perkiraan_selesai_text = getSabtuMingguDays(start, end)[1];

            } else if (priority_id_update == "P003") {
                // console.log(3);
                // // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2)._d);
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days'));
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days').format("YYYY-MM-DD HH:mm:ss"));
                // // console.log(moment('2022-07-15T10:00:00Z', 'YYYY-MM-DD HH:mm:ss').addWorkingTime(5, 'hours'));
                // // console.log(moment().format());
                // $('#perkiraan_selesai').val();
                // perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);
                perkiraan_selesai_y_m_d = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days').format("YYYY-MM-DD HH:mm:ss");

                var format = 'hh:mm:ss';

                // var time = moment();
                var time = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    tanggal_pembuatan_issues_jam,
                    tanggal_pembuatan_issues_menit,
                    tanggal_pembuatan_issues_detik,
                    0
                ));
                // console.log('time ========' + time);
                // console.log('time' + moment(time).format("YYYY-MM-DD HH:mm:ss"));
                // var time = moment('18:30:00', format);
                // var jam_berangkat = moment('07:00:00', format);
                var jam_berangkat = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    7,
                    0,
                    0,
                    0
                ));
                // var jam_pulang = moment('16:00:00', format);
                var jam_pulang = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    16,
                    0,
                    0,
                    0
                ));

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');

                    // // console.log(start);
                    // console.log('start' + moment(start).format("YYYY-MM-DD HH:mm:ss"));

                }


                // start = time;
                end = moment(start).businessAdd(2, 'days');

                // console.log(getSabtuMingguDays(start, end)[1]);
                // // console.log(getSabtuMingguDays(start, end)[0][0]);
                // info_perkiraan_selesai_text = getSabtuMingguDays(start, end)[1];

            } else if (priority_id_update == "P004") {
                // console.log(4);
                // // console.log(moment(moment().format(), 'YYYY-MM-DD HH').businessAdd(7));
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7, 'days'));
                // console.log(moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7, 'days').format("YYYY-MM-DD HH:mm:ss"));
                // console.log(moment().isoWeekday());
                // // console.log(moment('2022-07-15T10:00:00Z', 'YYYY-MM-DD HH:mm:ss').addWorkingTime(5, 'hours'));
                // // console.log(moment().format());
                // perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7)._d;
                // perkiraan_selesai = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(7, 'days');
                // perkiraan_selesai = perkiraan_selesai.toString().substr(0, 24);
                perkiraan_selesai_y_m_d = moment(moment().format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(2, 'days').format("YYYY-MM-DD HH:mm:ss");

                var format = 'hh:mm:ss';

                // var time = moment();
                var time = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    tanggal_pembuatan_issues_jam,
                    tanggal_pembuatan_issues_menit,
                    tanggal_pembuatan_issues_detik,
                    0
                ));
                // console.log('time ========' + time);
                // console.log('time' + moment(time).format("YYYY-MM-DD HH:mm:ss"));
                // var time = moment('18:30:00', format);
                // var jam_berangkat = moment('07:00:00', format);
                var jam_berangkat = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    7,
                    0,
                    0,
                    0
                ));
                // var jam_pulang = moment('16:00:00', format);
                var jam_pulang = moment(new Date(
                    tanggal_pembuatan_issues_tahun,
                    tanggal_pembuatan_issues_bulan - 1,
                    tanggal_pembuatan_issues_tanggal,
                    16,
                    0,
                    0,
                    0
                ));

                if (time.isBetween(jam_berangkat, jam_pulang)) {

                    // console.log('is between');
                    // start = moment();
                    start = time;

                } else {

                    // console.log('is not between');
                    // start = moment('07:00:00', format).add(1, 'days');
                    start = moment(new Date(
                        new Date().getFullYear(),
                        new Date().getMonth(),
                        new Date().getDate(),
                        7,
                        0,
                        0,
                        0
                    )).businessAdd(1, 'days');

                    // // console.log(start);
                    // console.log('start' + moment(start).format("YYYY-MM-DD HH:mm:ss"));

                }


                // start = time;
                end = moment(start).businessAdd(7, 'days');

                // console.log(getSabtuMingguDays(start, end)[1]);
                // // console.log(getSabtuMingguDays(start, end)[0][0]);
                // info_perkiraan_selesai_text = getSabtuMingguDays(start, end)[1];

            }

            // console.log('iki lo bro');
            // var tanggal_awal_ymd = moment().format("YYYY-MM-DD HH:mm:ss");
            var tanggal_awal_ymd = moment(start).format("YYYY-MM-DD HH:mm:ss");
            var tanggal_akhir_ymd = moment(end).format("YYYY-MM-DD HH:mm:ss");
            // console.log(tanggal_awal_ymd);
            // console.log(tanggal_akhir_ymd);
            // // console.log(getLiburNasionalPerTahun());
            // // console.log(getLiburNasionalPerTahun().length);

            // for (var p = 0; p < getLiburNasionalPerTahun().length; p++) {

            // }

            // var perkiraan_selesai_y_m_d_final = getLiburNasionalPerTahun(perkiraan_selesai_y_m_d);
            // // console.log('ini tanggal per tahun ' + getLiburNasionalPerTahun(perkiraan_selesai_y_m_d));
            // var perkiraan_selesai_final = "";
            // var perkiraan_selesai_y_m_d_final = "";
            // console.log('ini apalah itu' + perkiraan_selesai_y_m_d);
            var d = new Date();
            var year = d.getFullYear();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getDataLiburNasionalPerTahunBetween')}}" + '/' + tanggal_awal_ymd + '/' + tanggal_akhir_ymd,
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    var libur_between_1 = data.data.length;

                    // console.log('libur_between_1 = ' + libur_between_1);
                    // console.log('sebelum di tambah libur nasional tahap 1 ' + tanggal_akhir_ymd);
                    var sebelum_di_tambah_libur_nasional_tahap_1 = tanggal_akhir_ymd;
                    tanggal_akhir_ymd = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(libur_between_1, 'days').format("YYYY-MM-DD HH:mm:ss");
                    // console.log('sesudah di tambah libur nasional tahap 1 ' + tanggal_akhir_ymd);
                    // var sesudah_di_tambah_libur_nasional_tahap_1 = tanggal_akhir_ymd;
                    var sebelum_di_tambah_libur_nasional_tahap_1_plus_1 = moment(moment(end).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(1, 'days').format("YYYY-MM-DD HH:mm:ss");
                    var sesudah_di_tambah_libur_nasional_tahap_1_kurang_1 = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(-1, 'days').format("YYYY-MM-DD HH:mm:ss");

                    // console.log('sebelum_di_tambah_libur_nasional_tahap_1_plus_1 ' + sebelum_di_tambah_libur_nasional_tahap_1_plus_1);
                    // console.log('sesudah_di_tambah_libur_nasional_tahap_1_kurang_1 ' + sesudah_di_tambah_libur_nasional_tahap_1_kurang_1);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        // data: $('#formTambahIssues').serialize(),
                        url: "{{url('issues/getDataLiburNasionalPerTahunDistinctTanggal')}}" + '/' + year,
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data.data);
                            // // console.log(moment(date1).format(format1));
                            var libur_tanggal_libur_nasional_array = [];
                            // // console.log('perkiraan_selesai_y_m_d_libur_nasional' + perkiraan_selesai_y_m_d_libur_nasional);
                            // console.log('coba' + data.data.length);

                            var hari_libur_next = 0;

                            for (var s = 0; s < 10; s++) {

                                for (var r = 0; r < data.data.length; r++) {
                                    // console.log('tanggal_akhir_ymd ' + tanggal_akhir_ymd);
                                    // console.log('tgl_libur_nasional ' + data.data[r].tgl_libur_nasional);

                                    if (tanggal_akhir_ymd.substr(0, 10) == data.data[r].tgl_libur_nasional) {
                                        // console.log('ini cocok ' + tanggal_akhir_ymd)
                                        // hari_libur_next = hari_libur_next + 1;
                                        // console.log('hari_libur_next ' + hari_libur_next);
                                        // console.log('sebelum di tambah libur nasional tahap 2 ' + tanggal_akhir_ymd);
                                        tanggal_akhir_ymd = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(hari_libur_next + 1, 'days').format("YYYY-MM-DD HH:mm:ss");
                                        // console.log('sesudah di tambah libur nasional tahap 2 ' + tanggal_akhir_ymd);
                                    } else {

                                    }

                                }

                            }

                            // var popover_final = info_perkiraan_selesai_text + '<br> Hari Libur Nasional <br>' + libur_tanggal_libur_nasional_text;
                            var popover_final = "";
                            popover_final += "<div id='calendar'></div>";

                            // $("#perkiraan_selesai").popover({
                            //     title: 'Due Date Info',
                            //     content: popover_final,
                            //     html: true,
                            //     placement: 'left',
                            //     height: 1000,
                            //     width: 6000,
                            //     aspectRatio: 2,
                            //     windowResize: function(arg) {
                            //         alert('The calendar has adjusted to a window resize. Current view: ' + arg.view.type);
                            //     }
                            // }).popover('show');


                            // console.log('cobaan telo ' + tanggal_akhir_ymd);
                            var sebelum_di_tambah_libur_nasional_tahap_2_plus_1 = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(1, 'days').format("YYYY-MM-DD HH:mm:ss");
                            // console.log('sebelum_di_tambah_libur_nasional_tahap_2_plus_1' + sebelum_di_tambah_libur_nasional_tahap_2_plus_1);


                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                // data: $('#formTambahIssues').serialize(),
                                url: "{{url('issues/getDataLiburNasionalPerTahunBetween')}}" + '/' + sebelum_di_tambah_libur_nasional_tahap_1_plus_1.substr(0, 10) + '/' + sesudah_di_tambah_libur_nasional_tahap_1_kurang_1.substr(0, 10),
                                type: "GET",
                                dataType: 'json',
                                success: function(data) {

                                    // console.log('coba coba coba coba');
                                    // // console.log(data.data);
                                    // console.log(data.data.length);
                                    // var libur_between_2 = data.data.length;
                                    // // console.log('libur_between_1 ' + libur_between_1);
                                    // // console.log('libur_between_2 ' + libur_between_2);
                                    // // console.log('between' = data.data.length);
                                    var libur_between_2 = data.data.length;

                                    var calendarEl = document.getElementById('calendar');
                                    var events = [];

                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        // data: $('#formTambahIssues').serialize(),
                                        url: "{{url('issues/getLiburNasional')}}",
                                        type: "GET",
                                        dataType: 'json',
                                        success: function(data) {

                                            // // console.log(data.data.length);

                                            for (var i = 0; i < data.data.length; i++) {
                                                // console.log(data.data[i].nama_libur_nasional);

                                                events.push({
                                                    id: data.data[i].id,
                                                    title: data.data[i].nama_libur_nasional,
                                                    start: data.data[i].tgl_libur_nasional,
                                                    color: 'red'
                                                }, );
                                            }


                                            // var tanggal_akhir_ymdhms = moment(tanggal_akhir_ymd).format("YYYY-MM-DD HH:mm:ss");
                                            tanggal_akhir_ymd = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(libur_between_2, 'days').format("YYYY-MM-DD HH:mm:ss");

                                            // // console.log('tanggal_awal_ymdhms ' + tanggal_awal_ymdhms);
                                            // // console.log('tanggal_akhir_ymdhms ' + tanggal_akhir_ymdhms);



                                            var sesudah_di_tambah_libur_nasional_tahap_2_kurang_1 = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(-1, 'days').format("YYYY-MM-DD HH:mm:ss");
                                            // console.log('sesudah_di_tambah_libur_nasional_tahap_2_kurang_1' + sesudah_di_tambah_libur_nasional_tahap_2_kurang_1);
                                            $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                // data: $('#formTambahIssues').serialize(),
                                                url: "{{url('issues/getDataLiburNasionalPerTahunBetween')}}" + '/' + sebelum_di_tambah_libur_nasional_tahap_2_plus_1.substr(0, 10) + '/' + sesudah_di_tambah_libur_nasional_tahap_2_kurang_1.substr(0, 10),
                                                type: "GET",
                                                dataType: 'json',
                                                success: function(data) {

                                                    var libur_between_2 = data.data.length;

                                                    var tanggal_awal_ymdhms = moment(tanggal_awal_ymd).format("YYYY-MM-DD HH:mm:ss");
                                                    var tanggal_akhir_ymdhms = moment(moment(tanggal_akhir_ymd).format(), 'YYYY-MM-DD HH:mm:ss').businessAdd(libur_between_2, 'days').format("YYYY-MM-DD HH:mm:ss");

                                                    // $('#perkiraan_selesai').val(tanggal_akhir_ymdhms);
                                                    $('#perkiraan_selesai_y_m_d_detail').val(tanggal_akhir_ymdhms);

                                                    // events.push({
                                                    //     title: 'issues',
                                                    //     start: tanggal_awal_ymdhms,
                                                    //     end: tanggal_akhir_ymdhms,
                                                    //     color: 'black'
                                                    // }, );

                                                    // // console.log('ini itu apalah coba');
                                                    // // console.log(events);

                                                    // calendar = new FullCalendar.Calendar(calendarEl, {
                                                    //     initialView: 'dayGridMonth',
                                                    //     // selectable: true,
                                                    //     // dayMaxEventRows: true,
                                                    //     // views: {
                                                    //     //     timeGrid: {
                                                    //     //         dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
                                                    //     //     }
                                                    //     // },
                                                    //     events: events,
                                                    //     eventClick: function(info) {
                                                    //         // console.log(info.event);
                                                    //         // // console.log(info.event._def.publicId);
                                                    //         // // console.log(info.event._def.extendedProps);
                                                    //         // // console.log(info.event._def.extendedProps.data);

                                                    //     }
                                                    // });
                                                    // calendar.render();


                                                },
                                                error: function(data) {
                                                    // console.log('Error:', data);
                                                    //$('#modalPenghargaan').modal('show');
                                                }
                                            })

                                        },
                                        error: function(data) {
                                            // console.log('Error:', data);
                                            //$('#modalPenghargaan').modal('show');
                                        }
                                    })


                                },
                                error: function(data) {
                                    // console.log('Error:', data);
                                    //$('#modalPenghargaan').modal('show');
                                }
                            })

                        },
                        error: function(data) {
                            // console.log('Error:', data);
                            //$('#modalPenghargaan').modal('show');
                        }
                    })

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            })




        });

        $('#button_priority_id_update').on('click', function() {

            // console.log('coba');

            var priority_id_update = $("#priority_id_update").val();
            var perkiraan_selesai_y_m_d_detail = $("#perkiraan_selesai_y_m_d_detail").val();

            var data_postUpdateIssuesForward =
                // $("#formSuratPerjanjianIssues").serialize() +
                "priority_id_update=" + priority_id_update +
                "&perkiraan_selesai_y_m_d_detail=" + perkiraan_selesai_y_m_d_detail +
                "&tiket_issues_detail=" + tiket_issues_detail;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // contentType: 'multipart/form-data',
                data: data_postUpdateIssuesForward,
                url: "{{url('issues/postUpdateIssuesPriority')}}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    // console.log(data.kode);
                    // console.log('data_append_html_priority_batas_mengganti ====== ' + data.append_html_priority_batas_mengganti);
                    if (data.kode == 201) {
                        toastr.clear();
                        toastr.success(data.success);
                        $('#tb_issues').DataTable().ajax.reload(null, false);
                        $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                        $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                        $('#tb_detail_status').DataTable().ajax.reload(null, false);
                        $(".append_html_priority_batas_mengganti").html(data.append_html_priority_batas_mengganti);
                    } else {
                        toastr.clear();
                        toastr.error(data.success);
                        $(".append_html_priority_batas_mengganti").html(data.append_html_priority_batas_mengganti);
                    }

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });

        });

        $('#button_subject_id_update').on('click', function() {

            // console.log('coba');
            var m_kategori_id_edit = $("#kategori_id_edit option:selected").val();
            var m_layanan_id_edit = $("#layanan_id_edit option:selected").val();
            var m_subject_id_edit = $("#subject_id_edit option:selected").val();
            console.log(m_layanan_id_edit + ' ' + m_subject_id_edit);

            var priority_id_update = $("#priority_id_update").val();
            var perkiraan_selesai_y_m_d_detail = $("#perkiraan_selesai_y_m_d_detail").val();

            var data_postUpdateIssuesForward =
                // $("#formSuratPerjanjianIssues").serialize() +
                "m_kategori_id_edit=" + m_kategori_id_edit +
                "&m_layanan_id_edit=" + m_layanan_id_edit +
                "&m_subject_id_edit=" + m_subject_id_edit +
                "&tiket_issues_detail=" + tiket_issues_detail;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // contentType: 'multipart/form-data',
                data: data_postUpdateIssuesForward,
                url: "{{url('issues/postUpdateIssuesLayananDanSubject')}}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    // console.log(data.kode);
                    // console.log('data_append_html_priority_batas_mengganti ====== ' + data.append_html_priority_batas_mengganti);
                    if (data.kode == 201) {
                        toastr.clear();
                        toastr.success(data.success);
                        $('#tb_issues').DataTable().ajax.reload(null, false);
                        $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                        $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                        $('#tb_detail_status').DataTable().ajax.reload(null, false);
                        $('#modalIssuesDetail').modal('hide');
                    } else {
                        toastr.clear();
                        toastr.error(data.success);
                    }

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });

        });

        $('#button_priority_id_refresh_kembali').on('click', function() {

            // $("#priority_id_update").val(priority_id_update);
            // $("#priority_id_update").val(priority_id_update).trigger('change');
            // $("#perkiraan_selesai_y_m_d_detail").val(tanggal_batas_issues);

            $("#priority_id").select2("destroy");

            $("#priority_id").select2({
                theme: "bootstrap-5",
                placeholder: "Pilih Priority",
                dropdownParent: $('#modalFormTambahIssues'),
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getPriorityRefreshKembali')}}" + '/' + tiket_issues_detail,
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    if (data.kode == 201) {
                        // toastr.clear();
                        // toastr.success(data.success);
                        $("#priority_id_update").val(data.data.priority_id).trigger('change');
                        $("#perkiraan_selesai_y_m_d_detail").val(data.data.tanggal_batas_issues);
                    } else {
                        toastr.clear();
                        toastr.error(data.success);
                    }

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            })

        });

        $('#button_subject_id_refresh_kembali').on('click', function() {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getListLayanan')}}" + '/' + m_kategori_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    $("#layanan_id_edit").empty().append(data.data);
                    $("#layanan_id_edit").val(m_layanan_id).trigger('change');

                },
                error: function(data) {

                }
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#formTambahIssues').serialize(),
                url: "{{url('issues/getListSubject')}}" + '/' + m_layanan_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {

                    $("#subject_id_edit").empty().append(data.data);
                    $("#subject_id_edit").val(m_subject_id).trigger('change');

                },
                error: function(data) {
                }
            });

        });

        $(document).on('click', '#tambah_file_issues_modal', function(e) {
            Swal.fire({
                title: 'Upload File Issues',
                input: 'file',
                // html:
                // '<form action="javascript:;" class="form-control formTambahFileIssuesModal" enctype="multipart/form-data">'+
                // '<input id="file_issues_modal" type="file" name="file_issues_modal">'+
                // '</form>',
                customClass: 'swal-wide-50',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
            }).then(function(result) {
                console.log(result);
                if (result.dismiss == 'cancel') {
                } else {

                    var formData = new FormData();
                    var file = $('.swal2-file')[0].files[0];
                    console.log('file coba = ' + file);
                    formData.append("tiket_issues", tiket_issues_detail);
                    formData.append("file_upload", file);

                    var filename = $('#image_file').val();

                    var formTambahFileIssuesModal =
                    // $("#formSuratPerjanjianIssues").serialize() +
                    "file=" + file +
                    "&tiket_issues_detail=" + tiket_issues_detail;

                    console.log(formTambahFileIssuesModal);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        // data: $('#formTambahIssues').serialize(),
                        processData: false,
                        contentType: false,
                        cache: false,
                        enctype: 'multipart/form-data',
                        url: "{{url('issues/tambahFileIssuesModal')}}",
                        type: "POST",
                        data: formData,
                        // dataType: 'json',
                        success: function(data) {

                            // console.log('coba coba coba coba coba coba coba coba');
                            if (data.kode == 201) {
                                toastr.clear();
                                toastr.success(data.success);
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    // data: $('#formTambahIssues').serialize(),
                                    processData: false,
                                    contentType: false,
                                    cache: false,
                                    enctype: 'multipart/form-data',
                                    url: "{{url('issues/getFileIssuesModal')}}" + '?tiket_issues=' + tiket_issues_detail,
                                    type: "POST",
                                    data: formData,
                                    // dataType: 'json',
                                    success: function(data) {

                                        // console.log('coba coba coba coba coba coba coba coba');
                                        if (data.kode == 201) {

                                            $(".append_div_file_detail").html(data.issues_link_array);

                                            $('#tb_issues').DataTable().ajax.reload(null, false);
                                            $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                                            $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                                            $('#tb_detail_status').DataTable().ajax.reload(null, false);
                                        }else{
                                            toastr.clear();
                                            toastr.error(data.success);

                                            $('#tb_issues').DataTable().ajax.reload(null, false);
                                            $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                                            $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                                            $('#tb_detail_status').DataTable().ajax.reload(null, false);
                                        }

                                    },
                                    error: function(data) {
                                        // console.log('Error:', data);
                                        //$('#modalPenghargaan').modal('show');
                                    }
                                })
                            }else{

                            }

                        },
                        error: function(data) {
                            // console.log('Error:', data);
                            //$('#modalPenghargaan').modal('show');
                        }
                    })

                }

            });

        });


            $('#security_incident_detail').change(function() {
                var status = '';

                if ($('#security_incident_detail').prop('checked')) {
                        status = true;
                        }else{
                        status = false;
                    }
                $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: "tiket_issues_detail="+tiket_issues_detail+"&status="+status,
                                url: "{{url('issues/securityincidentupdate')}}",
                                type: "POST",
                                dataType: 'json',
                                success: function(data) {
                                    // console.log(data);
                                    // console.log(data.kode);
                                    if (data.kode == 201) {
                                        toastr.clear();
                                        toastr.success(data.success);
                                        $('#tb_issues').DataTable().ajax.reload(null, false);
                                        $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                                        $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                                        $('#tb_detail_status').DataTable().ajax.reload(null, false);
                                    } else {
                                        toastr.clear();
                                        toastr.success(data.success);
                                    }
                                },
                                error: function(data) {
                                    // console.log('Error:', data);
                                    //$('#modalPenghargaan').modal('show');
                                }
                            });
            })

            $('#major_incident_detail').change(function() {
                var status = '';

                if ($('#major_incident_detail').prop('checked')) {
                        status = true;
                        }else{
                        status = false;
                    }
                $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: "tiket_issues_detail="+tiket_issues_detail+"&status="+status,
                                url: "{{url('issues/majorincidentupdate')}}",
                                type: "POST",
                                dataType: 'json',
                                success: function(data) {
                                    // console.log(data);
                                    // console.log(data.kode);
                                    if (data.kode == 201) {
                                        toastr.clear();
                                        toastr.success(data.success);
                                        $('#tb_issues').DataTable().ajax.reload(null, false);
                                        $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                                        $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                                        $('#tb_detail_status').DataTable().ajax.reload(null, false);
                                    } else {
                                        toastr.clear();
                                        toastr.success(data.success);
                                    }
                                },
                                error: function(data) {
                                    // console.log('Error:', data);
                                    //$('#modalPenghargaan').modal('show');
                                }
                            });
            })


    });
</script>

<script>

    $(document).on('click', '#delete_file_issues_modal', function(e) {
        var issues_file_id = $(this).attr("data-issues_file_id");
        var tiket_issues = $(this).attr("data-tiket_issues");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        // data: $('#formTambahIssues').serialize(),
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            url: "{{url('issues/deleteFileIssuesModal')}}" + '?issues_file_id=' + issues_file_id + '&tiket_issues=' + tiket_issues,
            type: "POST",
            // data: formData,
            // dataType: 'json',
            success: function(data) {
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        // data: $('#formTambahIssues').serialize(),
                        processData: false,
                        contentType: false,
                        cache: false,
                        enctype: 'multipart/form-data',
                        url: "{{url('issues/getFileIssuesModal')}}" + '?tiket_issues=' + tiket_issues,
                        type: "POST",
                        // data: formData,
                        // dataType: 'json',
                        success: function(data) {

                            // console.log('coba coba coba coba coba coba coba coba');
                            if (data.kode == 201) {

                                $(".append_div_file_detail").html(data.issues_link_array);

                                $('#tb_issues').DataTable().ajax.reload(null, false);
                                $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                                $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                                $('#tb_detail_status').DataTable().ajax.reload(null, false);
                            }else{
                                toastr.clear();
                                toastr.error(data.success);

                                $('#tb_issues').DataTable().ajax.reload(null, false);
                                $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                                $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                                $('#tb_detail_status').DataTable().ajax.reload(null, false);
                            }

                        },
                        error: function(data) {


                        }
                    })
                }else{

                }
            },
            error: function(data) {
                // console.log('Error:', data);
                //$('#modalPenghargaan').modal('show');
            }
        })
    });

</script>

<script>



</script>

<script>
    var plus_append_file_no = 1;
    // $("#plus_append_file").click(function() {
    $(document).on('click', '#plus_append_file', function(e) {
        // $('<input type="file" name="pic" accept="image/*" />b<br>').insertBefore(this);
        // // console.log(plus_append_file_no++);
        // $("#append_div").append('<br><input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr"  multiple="multiple">');
        // $(".append_div").append("qwerty");
        plus_append_file_no++

        $("#append_div").append('<div class="row" id="div_delete_append_file_' + plus_append_file_no + '" style="margin-top:10px">' +
            // '<br><br>' +
            '<div class="col-lg-11">' +
            '<div class="mt-4 mt-xl-0">' +
            '<input name="file_issues[]" id="file_issues" type="file" class="form-control file_issues_arr" accept=".doc,.xls,.docx,.xlsx,.pdf,.mp3,.aav,.mp4,.mkv,.jpg,.jpeg,.png,.svg">' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-1">' +
            '<div class="mt-4 mt-xl-0">' +
            '<button type="button" id="delete_append_file_' + plus_append_file_no + '" data-data_append_div="div_delete_append_file_' + plus_append_file_no + '" class="btn btn-danger waves-effect waves-light delete_append_file"><i class="mdi mdi-minus"></i></button>' +
            '</div>' +
            '</div>' +
            '</div>');

        // $(".delete_append_file").click(function() {

        //     // console.log('coba ini append delete');

        // });

        $(".delete_append_file").click(function() {

            // console.log('coba coba');
            data_append_div = $(this).attr("data-data_append_div");
            // console.log(data_append_div);

            // // console.log('coba ini append delete_' + plus_append_file_no);
            $("#" + data_append_div).remove();

        });


    });
</script>

<!-- <script>
    $(document).ready(function() {


    });
</script> -->

<script>
    var enabled_disabled = '';
    var plus_append_subject_simasti_no = 0;
    var plus_append_subject_simasti_no_untuk_disabled_priority = 0;
    $("#plus_append_subject_simasti").click(function() {

        plus_append_subject_simasti_no++;
        plus_append_subject_simasti_no_untuk_disabled_priority++;
        // console.log(plus_append_subject_simasti_no);

        if (plus_append_subject_simasti_no_untuk_disabled_priority >= 3) {
            enabled_disabled = 'disabled';
            // console.log('plus_append_subject_simasti');
            // console.log(enabled_disabled);

            // $('#P001').prop(enabled_disabled, !$('#P001').prop(enabled_disabled));
            // $('#P002').prop(enabled_disabled, !$('#P002').prop(enabled_disabled));
            $('#P001').prop('disabled', true);
            $('#P002').prop('disabled', true);
        } else {
            enabled_disabled = 'enabled';

            // console.log('plus_append_subject_simasti');
            // console.log(enabled_disabled);

            // $('#P001').prop(enabled_disabled, !$('#P001').prop(enabled_disabled));
            // $('#P002').prop(enabled_disabled, !$('#P002').prop(enabled_disabled));
            $('#P001').prop('disabled', false);
            $('#P002').prop('disabled', false);
        }



        $("#append_div_subject_simasti").append(
            '<div class="row" style="margin-top:10px" id="delete_append_div_subject_simasti_' + plus_append_subject_simasti_no + '">' +
            '<div class="col-lg-10">' +
            '<div class="mt-4 mt-xl-0">' +
            '<div class="row">' +
            '<div class="col-lg-7">' +
            '<select name="subject_id_2[]" id="subject_id_2_' + plus_append_subject_simasti_no + '" class="subject_id_2" style="width: 100%">' +
            '<option value=""></option>' +
            '</select>' +
            '</div>' +
            '<div class="col-lg-5">' +
            '<input type="text" name="keluhan[]" id="keluhan_' + plus_append_subject_simasti_no + '" class="form-control" placeholder="Keluhan" style="width: 100%">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-1">' +
            '<div class="mt-4 mt-xl-0">' +
            '<button type="button" id="div_delete_subject_simasti_' + plus_append_subject_simasti_no + '" data-data_append_div_subject_simasti="delete_append_div_subject_simasti_' + plus_append_subject_simasti_no + '" class="btn btn-danger waves-effect waves-light div_delete_subject_simasti"><i class="mdi mdi-minus"></i></button>' +
            '</div>' +
            '</div>' +
            '</div>'
        );

        $("#div_delete_subject_simasti_" + plus_append_subject_simasti_no).click(function() {

            // console.log('coba coba');
            plus_append_subject_simasti_no_untuk_disabled_priority = plus_append_subject_simasti_no_untuk_disabled_priority - 1;
            data_append_div_subject_simasti = $(this).attr("data-data_append_div_subject_simasti");
            // console.log(data_append_div_subject_simasti);

            // // console.log('coba ini append delete_' + plus_append_file_no);

            $("#" + data_append_div_subject_simasti).remove();

            // console.log('coba_coba_coba_coba ' + plus_append_subject_simasti_no);

            if (plus_append_subject_simasti_no_untuk_disabled_priority >= 3) {
                // enabled_disabled = 'disabled';
                // $('#P001').prop('disabled', !$('#P001').prop('disabled'));
                // $('#P002').prop('disabled', !$('#P002').prop('disabled'));
                $('#P001').prop('disabled', true);
                $('#P002').prop('disabled', true);
            } else {
                // enabled_disabled = 'enabled';
                // $('#P001').prop('enabled', !$('#P001').prop('enabled'));
                // $('#P002').prop('enabled', !$('#P002').prop('enabled'));
                $('#P001').prop('disabled', false);
                $('#P002').prop('disabled', false);
            }

            // // console.log('div_delete_subject_simasti');
            // // console.log(plus_append_subject_simasti_no);
            // // console.log(enabled_disabled);



        });


        $("#subject_id_2_" + plus_append_subject_simasti_no).select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Subject Simasti",
            dropdownParent: $('#modalFormTambahIssues'),
            // minimumInputLength: 2,
            // allowClear: true,
            temlateResult: format_2,
            // tags: true,
            // multiple: true,
            allowClear: false,
            templateSelection: formatSelection_2,
            ajax: {
                url: "{{url('api/getListDataAssetSimasti')}}",
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    // Query parameters will be ?search=[term]&type=public
                    // console.log(query);
                    return query;
                },
                cache: true,
                delay: 250,
                processResults: function(data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    // console.log(data);
                    return {
                        results: data.results,
                        pagination: {
                            more: data.results_count
                        },
                    };
                }
            },
            createTag: function(params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true // add additional parameters
                }

                // console.log(term);
            }

        });

        function format_2(repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>"
            );

            $container.find(".select2-result-repository__title").text(repo.text);

            return $container;
        }

        function formatSelection_2(repo) {
            return repo.text;
        }
        // $(".append_div").append("qwerty");
    });
</script>

<script type="text/javascript">
    // $(document).ready(function() {
    // $(".formUploadFileLapiranKenaikanPangkatDetail").click(function() {
    var tiket_issues;
    var status_issues;
    $(document).on('click', '.forward_issues_detail', function(e) {
        // var formIssuesForwardSerialize = $('#formIssuesForward').serialize();
        // // console.log(formIssuesForwardSerialize);
        tiket_issues = $(this).attr("data-tiket_issues");
        status_issues = $(this).attr("data-status_issues");

        $(".modal_judul_issues_detail_forward").html('Forward Tiket ( ' + tiket_issues + ' )');
        // formData.append('tiket_issues', data_tiket_issues);
        // // console.log(formData);
        // console.log(tiket_issues);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // data: $('#formTambahIssues').serialize(),
            url: "{{url('issues/getIssuesForward')}}" + '/' + tiket_issues,
            type: "GET",
            dataType: 'json',
            success: function(data) {
                // // console.log(data.data[0].forward_username);
                // var get_description_issues = data.description_issues;
                // // console.log('coba coba coba coba coba');
                // // console.log(data.data_pegawai_it[0].nik);

                if (data.data_pegawai_it.length == 0) {

                } else {
                    for (var k = 0; k < data.data_pegawai_it.length; k++) {
                        // console.log('coba 1 ' + data.data_pegawai_it[k].nik);
                        $('.' + data.data_pegawai_it[k].nik).prop('checked', false);

                        if ("{{Session::get('user_app')['role']}}" == "R003") {
                            if (status_issues == 1) {
                                if (data.data_pegawai_it[k].nik == "{{Session::get('user_app')['username']}}") {
                                    $('.' + data.data_pegawai_it[k].nik).attr("onclick", "");
                                } else {
                                    // $('.' + data.data_pegawai_it[k].nik).attr("onclick", "return false;");
                                    $('.' + data.data_pegawai_it[k].nik).attr("onclick", "");
                                }
                            } else {
                                // $('.' + data.data_pegawai_it[k].nik).attr("onclick", "return false;");
                                $('.' + data.data_pegawai_it[k].nik).attr("onclick", "");
                            }
                        } else {
                            if (status_issues == 1) {
                                $('.' + data.data_pegawai_it[k].nik).attr("onclick", "");
                            } else {
                                // $('.' + data.data_pegawai_it[k].nik).attr("onclick", "return false;");
                                $('.' + data.data_pegawai_it[k].nik).attr("onclick", "");
                            }
                        }

                    }
                }

                if (data.data_issues_forward.length == 0) {

                } else {
                    // console.log(data.data_issues_forward);
                    // console.log(data.data_issues_forward.length);

                    for (var q = 0; q < data.data_issues_forward.length; q++) {
                        // console.log(q);
                        $('.' + data.data_issues_forward[q].forward_username).prop('checked', true);
                    }

                    for (var z = 0; z < data.data_issues_forward.length; z++) {
                        // console.log(z);
                        // console.log(data.data_issues_forward[z]);
                        // console.log('coba 2 ' + data.data_issues_forward[z].forward_username);
                        $('.' + data.data_issues_forward[z].forward_username).prop('checked', true);
                        // console.log("{{Session::get('user_app')['username']}}");
                        // if (status_issues == 1) {
                        //     if (data.data_pegawai_it[z].nik == "{{Session::get('user_app')['username']}}") {
                        //         $('.' + data.data_pegawai_it[z].nik).attr("onclick", "");
                        //     } else {
                        //         $('.' + data.data_pegawai_it[z].nik).attr("onclick", "return false;");
                        //     }
                        // } else {
                        //     // console.log(data.data_pegawai_it[z].nik);
                        //     $('.' + data.data_pegawai_it[z].nik).attr("onclick", "return false;");
                        // }
                    }
                }


                if (data.data_issues_forward_riwayat.length == 0) {

                    $("#append_riwayat_forward_issues").html('');

                } else {
                    var html_append_riwayat_forward_issues = '';
                    for (var d = 0; d < data.data_issues_forward_riwayat.length; d++) {
                        var icon_class = '';
                        if (data.data_issues_forward_riwayat[d].riwayat.includes('Mengembalikan')) {
                            // Found world
                            icon_class = '<i class="fa fa-share fa-flip-horizontal"></i>';
                        } else if (data.data_issues_forward_riwayat[d].riwayat.includes('Membatalkan')) {
                            icon_class = '<i class="fa fa-times"></i>';
                        } else if (data.data_issues_forward_riwayat[d].riwayat.includes('Meneruskan')) {
                            icon_class = '<i class="fa fa-share"></i>';
                        } else {
                            icon_class = '<i class="fa fa-globe"></i>';
                        }

                        html_append_riwayat_forward_issues +=
                            '<div class="timeline">' +
                            '<div class="timeline-icon">' + icon_class + '</div>' +
                            '<span class="year">' + data.data_issues_forward_riwayat[d].created_at + '</span>' +
                            '<div class="timeline-content">' +
                            '<h5 class="title">' + data.data_issues_forward_riwayat[d].v_users_all_nama + '</h5>' +
                            '<p class="description">' +
                            data.data_issues_forward_riwayat[d].riwayat +
                            '</p>' +
                            '</div>' +
                            '</div>';
                    }

                    // console.log(html_append_riwayat_forward_issues);

                    $("#append_riwayat_forward_issues").html(html_append_riwayat_forward_issues);

                }


                console.log(data.data_issues.tiket_cares_pi);
                if(data.data_issues.tiket_cares_pi == null || data.data_issues.tiket_cares_pi == ''){
                    $('.tiket_cares_display').hide();
                    $('.tiket_cares_chekbox').prop('checked', false);
                    $("#tiket_cares").val('');
                }else{
                    $('.tiket_cares_display').show();
                    $('.tiket_cares_chekbox').prop('checked', true);
                    $("#tiket_cares").val(data.data_issues.tiket_cares_pi);
                }


                // $("#description_issues_detail").html(get_description_issues);

                // $('#layanan_id').select2({data: [{id: '', text: ''}]});

                // $("#subject_id").empty().append(data.data);

            },
            error: function(data) {
                // console.log('Error:', data);
                //$('#modalPenghargaan').modal('show');
            }
        });


    });
    // });

    $('#formIssuesForward').submit(function(event) {

        if ($('.tiket_cares_chekbox').prop('checked')) {
            var tiket_cares = $('#tiket_cares').val();
            $(".tiket_cares_chekbox").val(tiket_cares);
        }else{
            var tiket_cares = '';
        }

        event.preventDefault();

        var formData = new FormData(this);

        formData.append('tiket_cares', tiket_cares);

        formData.append('tiket_issues_detail', tiket_issues);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // contentType: 'multipart/form-data',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            url: "{{url('issues/postUpdateIssuesForward')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/issues/index') }}";
                    $("#modalIssuesForward").modal('hide');
                    // window.location.reload();
                    // $('#tb_issues').DataTable().ajax.reload(null, false);
                    // $("#komentar_issues_detail").html(' a ');
                    $('#tb_issues').DataTable().ajax.reload(null, false);
                    $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                    $('#tb_issues_forward').DataTable().ajax.reload(null, false);
                } else {
                    toastr.clear();
                    toastr.error(data.success);
                }

            },
            error: function(data) {
                // console.log('Error:', data);
                //$('#modalPenghargaan').modal('show');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('.tiket_cares_chekbox').change(function() {
            if ($('.tiket_cares_chekbox').prop('checked')) {
                $('.tiket_cares_display').show();
            }else{
                $('.tiket_cares_display').hide();
                // $("#tiket_cares").val('');
            }
        });

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '.download_qr_code_class', function() {
            var qrcode_description = $(this).attr("data-qrcode_description");
            var tiket_issues = $(this).attr("data-tiket_issues");
            console.log(qrcode_description);

            qrcode_description_html_swall =
            '<div class="swal2-actions">' +
            '<table>' +
            '<tr>' +
            '<td>' +
            '<img style="width:150px; height:150px;" src="data:image/png;base64,' + qrcode_description + '" />' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>' +
            '<a href="data:image/png;base64,' + qrcode_description + '" download="' + tiket_issues + '.png" target="_blank" style="width: 100%;" type="button" class="btn btn-sm mt-1 btn-primary waves-effect waves-light"><i class="bx bx-download"></i> Download </a>'
            '</td>' +
            '</tr>' +
            '<table>' +
            '</div>';

            Swal.fire({
                title: 'Download QrCode',
                html: qrcode_description_html_swall,
                customClass: 'swal-wide-50',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                showConfirmButton: false
            });
        })

    });
</script>

@endsection
