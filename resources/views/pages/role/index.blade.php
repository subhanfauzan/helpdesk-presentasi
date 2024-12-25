@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Role</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">Role</li>
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
                                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalformTambahRole">Tambah Role</button> -->
                                                                <button type="button" class="btn btn-primary waves-effect waves-light addButton" data-bs-toggle="modal" data-bs-target="#modalformTambahRole">Tambah Role</button>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table" id="tb_role" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
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

<div class="modal fade" id="modalformTambahRole">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Role</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="formTambahRole" id="formTambahRole">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama Role</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_role" name="nama_role" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Pilih Flag</label>
                        <div class="form-control-wrap">
                            <select name="flag" id="flag">
                                <option value="">Pilih Flag</option>
                                @foreach($m_flag as $data)
                                <option value="{{$data->nama_flag}}">{{$data->nama_flag}} ( {{$data->keterangan}} )</option>
                                @endforeach
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

<div class="modal fade" id="modalFormEditRole">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Role</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="FormEditRole" id="FormEditRole">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" id="role_id_edit" name="role_id_edit" required>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama Role</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_role_edit" name="nama_role_edit" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Pilih Flag</label>
                        <div class="form-control-wrap">
                            <select id="flag_edit" name="flag_edit">
                                <option value=""></option>
                                @foreach($m_flag as $data)
                                <option value="{{$data->nama_flag}}">{{$data->nama_flag}} ( {{$data->keterangan}} )</option>
                                @endforeach
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
        $("#flag").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Flag"
        });
    });
</script>

<script type="text/javascript">
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {
        // NioApp.DataTable.init = function() {
        // NioApp.DataTable('#tb_user', {

        var tb_user = $('#tb_role').DataTable({
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
                url: "{{ url('role/getDataRole') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'nama_role',
                    name: 'nama_role',
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
            data: $('#formTambahRole').serialize(),
            url: "{{url('role/tambah')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalformTambahRole").modal('hide');
                    $('#tb_role').DataTable().ajax.reload(null, false);
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
            var role_id = $(this).attr("data-role_id");
            var nama_role = $(this).attr("data-nama_role");
            var flag = $(this).attr("data-flag");
            // console.log(flag);

            $("#role_id_edit").val(role_id);
            $("#nama_role_edit").val(nama_role);
            $("#flag_edit").val(flag).trigger('change');

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
            url: "{{url('role/update')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalFormEditRole").modal('hide');
                    $('#tb_role').DataTable().ajax.reload(null, false);
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
        var role_id = $(this).attr("data-role_id");
        // console.log(role_id);

        // $('.eg-swal-av2').on("click", function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                // console.log(role_id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#FormEditUser').serialize(),
                    url: "{{url('role/delete')}}" + '/' + role_id,
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
                            $('#tb_role').DataTable().ajax.reload(null, false);
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