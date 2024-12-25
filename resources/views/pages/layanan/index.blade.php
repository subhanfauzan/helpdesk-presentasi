@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Layanan</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">Manage Layanan</li>
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
                                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormTambahKategori">Tambah Kategori</button> -->
                                                                <button type="button" class="btn btn-primary waves-effect waves-light addButton" data-bs-toggle="modal" data-bs-target="#modalFormTambahKategori">Tambah Layanan</button>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table" id="tb_layanan" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Kategori</th>
                                                                <th>Nama Layanan</th>
                                                                <th>Jam Layanan</th>
                                                                <th>Deskripsi Layanan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                            <tr class="search" id="search">
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
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

<div class="modal fade" id="modalFormTambahKategori">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Layanan</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="formTambahLayanan" id="formTambahLayanan">
                    {{ csrf_field() }}
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
                        <label class="form-label" for="full-name">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Jam Layanan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="jam_layanan" name="jam_layanan" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Deskripsi Layanan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="deskripsi_layanan" name="deskripsi_layanan" required>
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

<div class="modal fade" id="modalFormEditKategori">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Layanan</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="FormEditRole" id="FormEditRole">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" id="layanan_id_edit" name="layanan_id_edit" required>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Pilih Kategori</label>
                        <div class="form-control-wrap">
                            <select disabled name="kategori_id_edit" id="kategori_id_edit">
                                <option value=""></option>
                                @foreach($m_kategori as $data)
                                <option value="{{$data->id}}">{{$data->nama_kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_layanan_edit" name="nama_layanan_edit" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Jam Layanan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="jam_layanan_edit" name="jam_layanan_edit" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Deskripsi Layanan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="deskripsi_layanan_edit" name="deskripsi_layanan_edit" required>
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

<script type="text/javascript">
    $(document).ready(function() {
        var tb_layanan = $('#tb_layanan').DataTable({
            destroy: true,
            processing: true,
            searching: true,
            autoWidth: false,
            serverSide: true,
            initComplete: function(settings, json) {
                $('#search').html(
                    '<form id="formsearch"><th></th>'+
                    '<th><input type="text" class="form-control" onkeyup="search()" name="nama_kategori" placeholder="Cari..." id="nama_kategori"></th>'+
                    '<th><input type="text" class="form-control" onkeyup="search()" name="nama_layanan" placeholder="Cari..." id="nama_layanan"></th>'+
                    '<th><input type="text" class="form-control" onkeyup="search()" name="jam_layanan" placeholder="Cari..." id="jam_layanan"></th>'+
                    '<th><input type="text" class="form-control" onkeyup="search()" name="deskripsi_layanan" placeholder="Cari..." id="deskripsi_layanan"></th>'+
                    '<th></th></form>'
                );
            },
            scrollCollapse: true,
            fixedColumns: {
                heightMatch: 'none'
            },
            sDom: 'lrtip',
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('layanan/getDataLayanan') }}",
                type: 'GET',
            },
            columns: [
                {
                    data: 'no',
                    name: 'no',
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
                    data: 'jam_layanan',
                    name: 'jam_layanan',
                    className: 'text-center'
                },
                {
                    data: 'deskripsi_layanan',
                    name: 'deskripsi_layanan',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-start'
                }
            ]
        });
    });
</script>

<script>
    function search() {
        var nama_kategori = "";
        var nama_layanan = "";
        var jam_layanan = "";
        var deskripsi_layanan = "";

        nama_kategori = $('#nama_kategori').val();
        nama_layanan = $('#nama_layanan').val();
        jam_layanan = $('#jam_layanan').val();
        deskripsi_layanan = $('#deskripsi_layanan').val();

        url = '?nama_kategori=' + nama_kategori + '&nama_layanan=' + nama_layanan + '&jam_layanan=' + jam_layanan + '&deskripsi_layanan=' + deskripsi_layanan;

        $('#tb_layanan').DataTable().ajax.url("{{ url('layanan/getDataLayananBy') }}" + url).load();
    }
</script>

<script>
    $(document).on('click', '#tambah', function() {
        // console.log('coba');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#formTambahLayanan').serialize(),
            url: "{{url('layanan/tambah')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalFormTambahKategori").modal('hide');
                    $('#tb_layanan').DataTable().ajax.reload(null, false);
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
        $("#kategori_id_edit").select2({
            theme: 'bootstrap-5',
            placeholder: "Pilih Flag"
        });
    });
</script>

<script>
    $(document).ready(function() {
        // $("#edit").click(function() {
        $(document).on('click', '#edit', function() {
            // console.log('coba');
            var layanan_id_edit = $(this).attr("data-layanan_id");
            var nama_layanan_edit = $(this).attr("data-nama_layanan");
            var kategori_id_edit = $(this).attr("data-kategori_id");
            var jam_layanan_edit = $(this).attr("data-jam_layanan");
            var deskripsi_layanan_edit = $(this).attr("data-deskripsi_layanan");

            $("#layanan_id_edit").val(layanan_id_edit);
            $("#nama_layanan_edit").val(nama_layanan_edit);
            $("#kategori_id_edit").val(kategori_id_edit).trigger('change');
            $("#jam_layanan_edit").val(jam_layanan_edit);
            $("#deskripsi_layanan_edit").val(deskripsi_layanan_edit);

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
            url: "{{url('layanan/update')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalFormEditKategori").modal('hide');
                    $('#tb_layanan').DataTable().ajax.reload(null, false);
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
        var layanan_id = $(this).attr("data-layanan_id");
        // console.log(layanan_id);

        // $('.eg-swal-av2').on("click", function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                // console.log(layanan_id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#FormEditUser').serialize(),
                    url: "{{url('layanan/delete')}}" + '/' + layanan_id,
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
                            $('#tb_layanan').DataTable().ajax.reload(null, false);
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
    $(document).on('click', '#status_aktif', function() {
        // console.log('delete');
        var layanan_id = $(this).attr("data-layanan_id");

        console.log(this.checked);
        var value = this.checked;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {status_aktif:value, layanan_id:layanan_id},
            url: "{{url('layanan/updateStatusLayananAktif')}}",
            type: "POST",
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
                    $('#tb_layanan').DataTable().ajax.reload(null, false);
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

    });
</script>


@endsection