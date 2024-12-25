@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Komplain</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Komplain</a></li>
                            <li class="breadcrumb-item active"></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <!-- <div class="card"> -->
                                        <!-- <div class="card-body"> -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mt-4 mt-xl-0">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">
                                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormTambahSubject">Tambah Komplain</button> -->
                                                                <button type="button" class="btn btn-primary waves-effect waves-light addButton" data-bs-toggle="modal" data-bs-target="#modalFormTambahkomplain">Tambah Komplain</button>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table" id="tb_komplain" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kategori</th>
                                                                <th>Deskripsi</th>
                                                                <th>Komplain file</th>
                                                                <th>Nama Pegawai</th>
                                                                <th>Created At</th>
                                                                <th style="width: 10%">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div><!-- .card-preview -->
                                        </div> <!-- nk-block -->
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

<div class="modal fade" id="modalFormTambahkomplain">
    <div class="modal-dialog modal-lg modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Komplain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:;" class="form-validate is-alter formTambahkomplain" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label" for="kategori">Pilih Komplain</label>
                        <div class="form-control-wrap">
                            <select name="kategori" id="kategori" class="form-control">
                                <option value="" disabled selected>Pilih Komplain</option>
                                <option value="sikap">Sikap</option>
                                <option value="kenyamanan">Kenyamanan</option>
                                <option value="kesopanan">Kesopanan</option>
                                <option value="disiplin">Disiplin</option>
                                <option value="kualitas">Kualitas</option>
                                <option value="keamanan">Keamanan</option>
                                <option value="tidak-ada">Lainya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3 pt-2">
                        <label class="form-label" for="file_komplain">Attachment File:</label>
                        <small style="font-size: 8pt; display:block; margin-top:-10px; margin-bottom:2px;">
                            File yang didukung: doc, xls, docx, xlsx, pdf, mp3, aav, mp4, mkv, jpg, jpeg, png, svg, zip
                        </small>
                        <div id="append_div">
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="mt-4 mt-xl-0">
                                        <input name="file_komplain[]" id="file_komplain" type="file" class="form-control file_komplain_arr" 
                                               accept=".doc,.xls,.docx,.xlsx,.pdf,.mp3,.aav,.mp4,.mkv,.jpg,.jpeg,.png,.svg,.zip">
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="mt-4 mt-xl-0">
                                        <button type="button" name="plus_append_file" id="plus_append_file" class="btn btn-primary waves-effect waves-light">
                                            <i class="mdi mdi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" id="tambah" name="tambah" class="btn btn-md btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormEditKomplain">
    <div class="modal-dialog modal-lg modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Komplain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:;" class="form-validate is-alter FormEditKomplain" enctype="multipart/form-data">
                <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" id="komplain_id_edit" name="komplain_id_edit" required>
                        <div class="form-group">
                            <label class="form-label" for="full-name">Pilih Kategori</label>
                            <div class="form-control-wrap">
                                <select name="kategori_edit" id="kategori_edit" class="form-control">
                                    <option value="" disabled selected>Pilih Komplain</option>
                                    <option value="sikap">Sikap</option>
                                    <option value="kenyamanan">Kenyamanan</option>
                                    <option value="kesopanan">Kesopanan</option>
                                    <option value="disiplin">Disiplin</option>
                                    <option value="kualitas">Kualitas</option>
                                    <option value="keamanan">Keamanan</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group pt-2">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi_komplain_edit" name="deskripsi_komplain_edit" rows="3"></textarea>
                        </div>
                        <div class="form-group pt-2">
                            <div class="flex">
                                <label for="nama-file" class="fs-5">Attachment File :</label>
                                <!-- <button type="button" name="plus_append_file_edit" id="plus_append_file_edit" class="btn btn-primary waves-effect waves-light ms-2">
                                <i class="mdi mdi-plus"></i>
                                </button> -->
                            </div>
                            <div id="append_div_edit">
                                <div class="row">
                                    <div class="col-lg-11">
                                        <div class="mt-4 mt-xl-0">
                                            <input name="file_komplain_edit[]" id="file_komplain_edit" type="file" class="form-control file_komplain_arr" 
                                                accept=".doc,.xls,.docx,.xlsx,.pdf,.mp3,.aav,.mp4,.mkv,.jpg,.jpeg,.png,.svg,.zip">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="mt-4 mt-xl-0">
                                            <button type="button" name="plus_append_file_edit" id="plus_append_file_edit" class="btn btn-primary waves-effect waves-light">
                                                <i class="mdi mdi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group">
                            <table class="table" id="tb_komplain_file" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Nama File</th>
                                            <th style="width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <button type="submit" id="update" namme="update" class="btn btn-md btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')

<script type="text/javascript">
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {
        // NioApp.DataTable.init = function() {
        // NioApp.DataTable('#tb_user', {

        var tb_user = $('#tb_komplain').DataTable({
            responsive: {
                details: true
            },
            processing: true,
            serverSide: true,
            searching: true,
            sDom: 'lrtip', // untuk hidden search box di datatable
            // language: {
            // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
            // },
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('komplain/getDataKomplain') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'kategori',
                    name: 'kategori',
                    className: 'text-center'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi',
                    className: 'text-center'
                },
                {
                    data: 'komplain_file',
                    name: 'komplain_file',
                    className: 'text-center'
                },
                {
                    data: 'pegawai_nama',
                    name: 'pegawai_nama',
                    className: 'text-center'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-start'
                },

            ]
        })
        // };
    });
</script>

<script>
    var plus_append_file_no = 1;
    // $("#plus_append_file").click(function() {
    $(document).on('click', '#plus_append_file', function(e) {
        // $('<input type="file" name="pic" accept="image/*" />b<br>').insertBefore(this);
        // // console.log(plus_append_file_no++);
        // $("#append_div").append('<br><input name="file_komplain[]" id="file_komplain" type="file" class="form-control file_komplain_arr"  multiple="multiple">');
        // $(".append_div").append("qwerty");
        plus_append_file_no++

        $("#append_div").append('<div class="row" id="div_delete_append_file_' + plus_append_file_no + '" style="margin-top:10px">' +
            // '<br><br>' +
            '<div class="col-lg-11">' +
            '<div class="mt-4 mt-xl-0">' +
            '<input name="file_komplain[]" id="file_komplain" type="file" class="form-control file_komplain_arr" accept=".doc,.xls,.docx,.xlsx,.pdf,.mp3,.aav,.mp4,.mkv,.jpg,.jpeg,.png,.svg">' +
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

<script>
    var plus_append_file_no = 1;
    // $("#plus_append_file").click(function() {
    $(document).on('click', '#plus_append_file_edit', function(e) {
        // $('<input type="file" name="pic" accept="image/*" />b<br>').insertBefore(this);
        // // console.log(plus_append_file_no++);
        // $("#append_div").append('<br><input name="file_komplain[]" id="file_komplain" type="file" class="form-control file_komplain_arr"  multiple="multiple">');
        // $(".append_div").append("qwerty");
        plus_append_file_no++

        $("#append_div_edit").append('<div class="row" id="div_delete_append_file_' + plus_append_file_no + '" style="margin-top:10px">' +
            // '<br><br>' +
            '<div class="col-lg-11">' +
            '<div class="mt-4 mt-xl-0">' +
            '<input name="file_komplain_edit[]" id="file_komplain_edit" type="file" class="form-control file_komplain_arr" accept=".doc,.xls,.docx,.xlsx,.pdf,.mp3,.aav,.mp4,.mkv,.jpg,.jpeg,.png,.svg">' +
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

<script>
    $(document).ready(function(){
        $('.formTambahkomplain').submit(function(event) {
                
            var formData = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData:false,
                cache: false,
                contentType: false, 
                url: "{{url('komplain/tambah')}}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    // console.log(data.kode);
                    if (data.kode == 201) {
                        toastr.clear();
                        toastr.success(data.success);
                        // document.location = "{{ url('/home/index') }}";
                        $("#modalFormTambahkomplain").modal('hide');
                        $('#tb_komplain').DataTable().ajax.reload(null, false);
                        // $('#tb_kategori').DataTable().ajax.reload(null, false);
                        $("#kategori").val("").trigger('change');
                        $("#deskripsi").val("").trigger('change');

                        $("#append_div").html(
                            '<div class="row">'+
                                '<div class="col-lg-11">'+
                                    '<div class="mt-4 mt-xl-0">'+
                                        '<input name="file_komplain[]" id="file_komplain" type="file" class="form-control" accept=".doc,.xls,.docx,.xlsx,.pdf,.mp3,.aav,.mp4,.mkv,.jpg,.jpeg,.png,.svg" >'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-1">'+
                                    '<div class="mt-4 mt-xl-0">'+
                                        '<button type="button" name="plus_append_file" id="plus_append_file" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus"></i></button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'
                        );

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
    });
</script>

<script>
    $(document).on('click', '#delete', function() {
        // console.log('delete');
        var komplain_id = $(this).attr("data-komplain_id");
        // console.log(komplain_id);

        // $('.eg-swal-av2').on("click", function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                // console.log(komplain_id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#FormEditUser').serialize(),
                    url: "{{url('komplain/delete')}}" + '/' + komplain_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        // console.log(data.kode);
                        if (data.kode == 201) {
                            toastr.clear();
                            toastr.success(data.success);
                            // document.location = "{{ url('/home/index') }}";
                            // $("#modalFormEditUser").modal('hide');
                            // Swal.fire('Deleted!', 'Berhasil Di Delete.', 'success');
                            $('#tb_komplain').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.clear();
                            toastr.error(data.success);
                            // Swal.fire('Deleted!', 'Gagal Di Delete.', 'error');
                        }
                    },
                    error: function(data) {
                        // console.log('Error:', data);
                        //$('#modalPenghargaan').modal('show');
                    }
                });

            }
        });
        // });


    });
</script>

<script>
    var data_komplain_file_id_array = []; 
    $(document).ready(function() {
        $(document).on('click', '#edit', function() {
            var komplain_id_edit = $(this).attr("data-id");
            var kategori_edit = $(this).attr("data-kategori");
            var deskripsi_komplain_edit = $(this).attr("data-deskripsi");
            var file_names_edit = $(this).attr("data-file_names");

            console.log("File Names Raw: " + file_names_edit);

            $("#komplain_id_edit").val(komplain_id_edit);
            $("#kategori_edit").val(kategori_edit);
            $("#deskripsi_komplain_edit").val(deskripsi_komplain_edit);

            $('#tb_komplain_file').DataTable().destroy();

            var tb_komplain_file = $('#tb_komplain_file').DataTable({
                responsive: {
                    details: true
                },
                processing: true,
                serverSide: true,
                searching: true,
                sDom: 'lrtip', // untuk hidden search box di datatable
                autoWidth: 'false',
                bPaginate: false,
                bInfo: false,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('komplain/getDataKomplainFile') }}"+ '/' + komplain_id_edit,
                    type: 'GET',
                },
                columns: [{
                        data: 'nama_file',
                        name: 'nama_file',
                        className: 'text-center'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        className: 'text-start'
                    },

                ]
            })
            
            $(document).on('click', '.delete_komplain_file', function() {
                var data_komplain_id = $(this).attr("data-komplain_id");

                data_komplain_file_id_array.push(data_komplain_id);

                console.log('data_komplain_id = ' + data_komplain_file_id_array);

                $('#tb_komplain_file').DataTable().destroy();

                // $('#tb_komplain_file').DataTable().ajax.url("?data_parsing="+data_komplain_file_id_array).load();

                var tb_komplain_file = $('#tb_komplain_file').DataTable({
                    responsive: {
                        details: true
                    },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    sDom: 'lrtip', // untuk hidden search box di datatable
                    // language: {
                    // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
                    // },
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ url('komplain/getDataKomplainFile') }}"+ '/' + komplain_id_edit,
                        type: 'GET',
                        data: {data_parsing: data_komplain_file_id_array}
                    },
                    columns: [{
                            data: 'nama_file',
                            name: 'nama_file',
                            className: 'text-center'
                        },
                        {
                            data: 'aksi',
                            name: 'aksi',
                            className: 'text-start'
                        },

                    ]
                })
            });
        });

    });
</script>


<script>
    $(document).ready(function(){

        $('.FormEditKomplain').submit(function(event) {
        
            var formData = new FormData(this);
            formData.append('data_komplain_file_id_array_delete', data_komplain_file_id_array);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                url: "{{url('komplain/update')}}",
                processData:false,
                cache: false,
                contentType: false, 
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    // console.log(data.kode);
                    if (data.kode == 201) {
                        toastr.clear();
                        toastr.success(data.success);
                        // document.location = "{{ url('/home/index') }}";
                        $("#modalFormEditKomplain").modal('hide');
                        $('#tb_komplain').DataTable().ajax.reload(null, false);

                        $("#append_div_edit").html(
                            '<div class="row">'+
                                '<div class="col-lg-11">'+
                                    '<div class="mt-4 mt-xl-0">'+
                                        '<input name="file_komplain_edit[]" id="file_komplain_edit" type="file" class="form-control" accept=".doc,.xls,.docx,.xlsx,.pdf,.mp3,.aav,.mp4,.mkv,.jpg,.jpeg,.png,.svg" >'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-1">'+
                                    '<div class="mt-4 mt-xl-0">'+
                                        '<button type="button" name="plus_append_file_edit" id="plus_append_file_edit" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus"></i></button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'
                        );

                        data_komplain_file_id_array = [];

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
        });

    });
</script>

<script>

    $(document).on('click', '.btn-close', function() {
        data_komplain_file_id_array = [];
    });

</script>
@endsection