@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Kategori</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">Manage Kategori</li>
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
                                                                <button type="button" class="btn btn-primary waves-effect waves-light addButton" data-bs-toggle="modal" data-bs-target="#modalFormTambahKategori">Tambah Kategori</button>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table" id="tb_kategori" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="width: 10%;">No</th>
                                                                <th class="text-center" style="width: 45%;">Nama</th>
                                                                <th class="text-center" style="width: 45%;">Aksi</th>
                                                            </tr>
                                                            <tr class="search" id="search">
                                                                <th></th>
                                                                <th>
                                                                    <input type="text" class="form-control" onkeyup="search()" name="nama_kategori" placeholder="Cari..." id="nama_kategori" style="width: 100%;">
                                                                </th>
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
                <h5 class="modal-title">Tambah Kategori</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="formTambahKategori" id="formTambahKategori">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
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
                <h5 class="modal-title">Edit Kategori</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="FormEditRole" id="FormEditRole">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" id="kategori_id_edit" name="kategori_id_edit" required>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_kategori_edit" name="nama_kategori_edit" required>
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

<script type="text/javascript">
    $(document).ready(function() {
        var tb_kategori = $('#tb_kategori').DataTable({
            responsive: {
                details: true
            },
            processing: true,
            serverSide: true,
            searching: false, // Menonaktifkan pencarian default
            sDom: 'lrtip', // Menghilangkan kotak pencarian default
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('kategori/getDataKategori') }}",
                type: 'GET',
                data: function(d) {
                    d.nama_kategori = $('#nama_kategori').val(); // Mengirimkan data pencarian
                },
                error: function(xhr, error, thrown) {
                    console.log('Ajax Error:', error); // Menampilkan kesalahan Ajax di konsol
                }
            },
            columns: [{
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
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-center'
                }
            ],
            initComplete: function(settings, json) {
                $('#search').html(
                    '<form id="formsearch"><th></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="nama_kategori" placeholder="Cari..." id="nama_kategori"></th>' +
                    '<th></th></form>'
                );
            },
        });
    });
</script>

<script>
    function search() {
        var nama_kategori = "";

        nama_kategori = $('#nama_kategori').val();
        // console.log(role);

        url = '?nama_kategori=' + nama_kategori;
        // console.log(url);
        $('#tb_kategori').DataTable().ajax.url("{{ url('kategori/getDataKategoriBy') }}" +
            url).load();
    };
</script>

<script>
    $(document).on('click', '#tambah', function() {
        // console.log('tambah');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#formTambahKategori').serialize(),
            url: "{{url('kategori/tambah')}}",
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
                    $('#tb_kategori').DataTable().ajax.reload(null, false);
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
        $("#flag_edit").select2({
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
            var kategori_id = $(this).attr("data-kategori_id");
            var nama_kategori = $(this).attr("data-nama_kategori");

            $("#kategori_id_edit").val(kategori_id);
            $("#nama_kategori_edit").val(nama_kategori);

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
            url: "{{url('kategori/update')}}",
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
                    $('#tb_kategori').DataTable().ajax.reload(null, false);
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
        var kategori_id = $(this).attr("data-kategori_id");
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
                    url: "{{url('kategori/delete')}}" + '/' + kategori_id,
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
                            $('#tb_kategori').DataTable().ajax.reload(null, false);
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
        var kategori_id = $(this).attr("data-kategori_id");

        console.log(this.checked);
        var value = this.checked;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {status_aktif:value, kategori_id:kategori_id},
            url: "{{url('kategori/updateStatusKategoriAktif')}}",
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
                    $('#tb_kategori').DataTable().ajax.reload(null, false);
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