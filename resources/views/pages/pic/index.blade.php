@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">PIC</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">Manage PIC</li>
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
                                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormTambahPic">Tambah Kategori</button> -->
                                                                <button type="button" class="btn btn-primary waves-effect waves-light addButton" data-bs-toggle="modal" data-bs-target="#modalFormTambahPic">Tambah PIC</button>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table" id="tb_pic" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Username</th>
                                                                <th>Nama</th>
                                                                <th>Nama Kategori</th>
                                                                <th>Nama Layanan</th>
                                                                <th>Aksi</th>
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

<div class="modal fade" id="modalFormTambahPic">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah PIC</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="formTambahKategori" id="formTambahKategori">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label" for="full-name">Username</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Pilih Kategori</label>
                        <div class="form-control-wrap">
                            <select name="kategori_id" id="kategori_id">
                                <option value=""></option>
                                @foreach($m_kategori as $data)
                                <option value="{{$data->id}}">{{$data->nama_kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Pilih Layanan</label>
                        <div class="form-control-wrap">
                            <select name="layanan_id" id="layanan_id">
                                <option value=""></option>
                                <!-- @foreach($m_layanan as $data)
                                <option value="{{$data->id}}">{{$data->nama_layanan}}</option>
                                @endforeach -->
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <!-- <span class="sub-text">Modal Footer Text</span> -->
                <button type="button" id="tambah" namme="tambah" class="btn btn-md btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormEditPic">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit PIC</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="FormEditRole" id="FormEditRole">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" id="pic_id_edit" name="pic_id_edit" required>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Username</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="username_edit" name="username_edit" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Pilih Kategori</label>
                        <div class="form-control-wrap">
                            <select name="kategori_id_edit" id="kategori_id_edit">
                                <option value=""></option>
                                @foreach($m_kategori as $data)
                                <option value="{{$data->id}}">{{$data->nama_kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Pilih Layanan</label>
                        <div class="form-control-wrap">
                            <select name="layanan_id_edit" id="layanan_id_edit">
                                <option value=""></option>
                                <!-- @foreach($m_layanan as $data)
                                <option value="{{$data->id}}">{{$data->nama_layanan}}</option>
                                @endforeach -->
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <!-- <span class="sub-text">Modal Footer Text</span> -->
                <button type="button" id="update" namme="update" class="btn btn-md btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $("#kategori_id").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Kategori"
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#kategori_id_edit").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Kategori"
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#layanan_id").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Layanan"
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#layanan_id_edit").select2({
            theme: "bootstrap-5",
            // placeholder: "Pilih Layanan"
        });
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

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{url('pic/getListLayanan')}}" + '/' + kategori_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    // console.log(data.data);

                    // $('#layanan_id').select2({data: [{id: '', text: ''}]});

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

        $('#kategori_id_edit').on("select2:select", function(e) {
            // what you would like to happen
            // // console.log(e);
            // $("#eselon_id_selected_input").val(eselon_id).select2();
            var kategori_id = $("#kategori_id_edit option:selected").val();
            // // console.log(value);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{url('pic/getListLayanan')}}" + '/' + kategori_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    // console.log(data.data);

                    // $('#layanan_id').select2({data: [{id: '', text: ''}]});

                    $("#layanan_id_edit").empty().append(data.data);

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });

        });
    });
</script>

<script type="text/javascript">
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {
        // NioApp.DataTable.init = function() {
        // NioApp.DataTable('#tb_user', {

        var tb_user = $('#tb_pic').DataTable({
            responsive: {
                details: true
            },
            processing: true,
            serverSide: true,
            searching: true,
            responsive: {
                details: true
            },
            sDom: 'lrtip', // untuk hidden search box di datatable
            // language: {
            // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
            // },
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('pic/getDataPIC') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'username',
                    name: 'username',
                    className: 'text-center'
                },
                {
                    data: 'v_users_all_nama',
                    name: 'v_users_all_nama',
                    className: 'text-center'
                },
                {
                    data: 'nama_kategori',
                    name: 'nama_kategori',
                    className: 'text-center'
                },
                {
                    data: 'nama_layanan',
                    name: 'nama_layanan',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-center'
                },

            ]
        })
        // };
    });
</script>

<script>
    $(document).on('click', '#tambah', function() {
        // console.log('tambah');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#formTambahKategori').serialize(),
            url: "{{url('pic/tambah')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalFormTambahPic").modal('hide');
                    $('#tb_pic').DataTable().ajax.reload(null, false);
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
        // $("#edit").click(function() {
        $(document).on('click', '#edit', function() {
            // console.log('coba');
            var pic_id_edit = $(this).attr("data-pic_id");
            var username_edit = $(this).attr("data-username");
            var kategori_id_edit = $(this).attr("data-m_kategori_id");
            var layanan_id_edit = $(this).attr("data-layanan_id");

            // console.log(pic_id_edit);
            // console.log(username_edit);
            // console.log(kategori_id_edit);
            // console.log(layanan_id_edit);


            $("#kategori_id_edit").val(kategori_id_edit).trigger('change');
            
            // $("#layanan_id_edit").val(layanan_id).trigger('change');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formTambahPeiodePosyandu').serialize(),
                url: "{{url('pic/getListLayanan')}}" + '/' + kategori_id_edit,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    // console.log(data.data);

                    // $('#layanan_id').select2({data: [{id: '', text: ''}]});

                    $("#layanan_id_edit").empty().append(data.data);
                    $("#layanan_id_edit").val(layanan_id_edit).trigger('change');

                },
                error: function(data) {
                    // console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });

            // $("#layanan_id_edit").val(layanan_id_edit).trigger('change');

            $("#pic_id_edit").val(pic_id_edit);
            $("#username_edit").val(username_edit);

        });
    });
</script>

<script>
    $(document).on('click', '#update', function() {
        // console.log('update');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#FormEditRole').serialize(),
            url: "{{url('pic/update')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalFormEditPic").modal('hide');
                    $('#tb_pic').DataTable().ajax.reload(null, false);
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
</script>


<script>
    $(document).on('click', '#delete', function() {
        // console.log('delete');
        var pic_id = $(this).attr("data-pic_id");
        // console.log(kategori_id);

        // $('.eg-swal-av2').on("click", function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                // console.log(kategori_id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#FormEditUser').serialize(),
                    url: "{{url('pic/delete')}}" + '/' + pic_id,
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
                            $('#tb_pic').DataTable().ajax.reload(null, false);
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


@endsection