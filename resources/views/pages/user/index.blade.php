@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Manage User</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">Manage User</li>
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
                                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormTambahUser">Tambah User</button> -->
                                                                <button type="button" class="btn btn-primary waves-effect waves-light addButton addButton" data-bs-toggle="modal" data-bs-target="#modalFormTambahUser">Tambah User</button>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table stripe" id="tb_user" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                <th>Username</th>
                                                                <th>role</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                            <tr class="search" id="search">
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
                                </div><!-- .card-preview -->
                            </div> <!-- nk-block -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- .card-preview -->


<div class="modal fade" id="modalFormTambahUser">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="formTambahUser" id="formTambahUser" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="tambahnama" name="nama" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="tambahusername" minlength="6" name="username" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="form-control-wrap">
                            <input type="password" class="form-control" id="tambahpassword" minlength="6" name="password" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <div class="form-control-wrap">
                            <select class="form-control" data-trigger name="role" id="tambahrole" placeholder="This is a search placeholder" required autocomplete="new-password">
                                <option selected disabled>Pilih Role</option>
                                @foreach($m_role as $data)
                                <option value="{{$data->id}}">{{$data->nama_role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="tambahunit">
                        <label class="form-label">Unit</label>
                        <div class="form-control-wrap">
                            <select class="form-control" data-trigger name="unitid" id="tambahunitid" placeholder="This is a search placeholder" required autocomplete="new-password">
                                <option selected disabled>Pilih Unit</option>
                                @foreach($v_units as $data)
                                <option value="{{$data->unitid}}">{{$data->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <button type="button" id="tambah" name="tambah" class="btn btn-md btn-primary">Simpan</button>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormEditUser">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="FormEditUser" id="FormEditUser">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_edit" name="nama" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Username</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="username_edit" minlength="6" readonly name="username" required autocomplete="new-password" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Password</label>
                        <div class="form-control-wrap">
                            <input type="password" class="form-control" id="password_edit" minlength="6" name="password" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <div class="form-control-wrap">
                            <select class="form-control" data-trigger name="role" id="role_edit" placeholder="This is a search placeholder" required autocomplete="new-password">
                                <option disabled>Pilih Role</option>
                                @foreach($m_role as $data)
                                <option value="{{$data->id}}">{{$data->nama_role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="unit_edit">
                        <label class="form-label">Unit</label>
                        <div class="form-control-wrap">
                            <select class="form-control" data-trigger name="unitid" id="unitid_edit" placeholder="This is a search placeholder" required autocomplete="new-password">
                                <option disabled>Pilih Unit</option>
                                @foreach($v_units as $data)
                                <option value="{{$data->unitid}}">{{$data->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <button type="submit" id="update" namme="update" class="btn btn-md btn-primary">Simpan</button>
                </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {
        var tb_user = $('#tb_user').DataTable({
            destroy: true,
            processing: true,
            searching: true,
            autoWidth: false,
            serverSide: true,
            initComplete: function(settings, json) {
                $('#search').html(
                    '<form id="formsearch"><th></th>'+
                    '<th><input type="text" class="form-control" onkeyup="search()"  name="nama" placeholder="Cari nama user.." id="name"></th>'+
                    '<th><input type="text" class="form-control" onkeyup="search()" name="username" placeholder="Cari username..." id="username"></th>'+
                    '<th><div class="form-control-wrap">'+
                        '<select class="form-control" data-trigger name="role" id="role" onchange="search()" placeholder="Cari role...">'+
                            '<option disabled>Pilih Role</option>'+
                            '@foreach($m_role as $data)'+
                            '<option value="{{$data->id}}">{{$data->nama_role}}</option>'+
                            '@endforeach'+
                            '</select>'+
                        '</div>'+
                    '</th><th></th></form>'
                );
                $("#role").select2({
                    theme: "bootstrap-5",
                    placeholder: "Pilih Role",
                    width: "100%"
                });
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
                url: "{{ url('user/getDataUser') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-start'
                },
                {
                    data: 'nama',
                    name: 'nama',
                    className: 'text-start'
                },
                {
                    data: 'username',
                    name: 'username',
                    className: 'text-start'
                },
                {
                    data: 'role',
                    name: 'role',
                    className: 'text-start'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-start'
                },

            ]
        });
    });
</script>
<script>
    function search() {
            var nama = "";
            var username = "";
            var role = "";

            nama = $('#name').val();
            username = $('#username').val();
            role = $('#role').val();
            // console.log(role);

            url = '?nama=' + nama + '&username=' + username + '&role=' + role ;
            // console.log(url);
            $('#tb_user').DataTable().ajax.url("{{ url('user/getDataUserBy') }}" +
                url).load();
        };
</script>
<script>
    $(document).ready(function(){
        $("#tambahrole").select2({
        theme: "bootstrap-5",
        dropdownParent: $('#modalFormTambahUser'),
        placeholder: "Pilih Role",
        width: "100%"
        });
        $("#tambahunitid").select2({
        theme: "bootstrap-5",
        dropdownParent: $('#modalFormTambahUser'),
        placeholder: "Pilih Unit",
        width: "100%"
        });
    });
</script>
<script>
    $(document).on('change', '#tambahrole', function(){
        var selected = $('#tambahrole').select2('data');
        value = selected[0].id;
        // console.log(value);
        if(value == "R001" || value == "R002"  || value == "R005"){
            $('#tambahunitid').removeAttr("required");
            $('#tambahunitid').prop("disabled", true);
            $('#tambahunit').css("display", 'none');
        }else{
            $('#tambahunitid').prop("required", true);
            $('#tambahunitid').prop("disabled", false);
            $('#tambahunit').removeAttr("style");
        }
    });
</script>
<script>
    $(document).on('change', '#role_edit', function(){
        var selected = $('#role_edit').select2('data');
        value = selected[0].id;
        // console.log(value);
        if(value == "R001" || value == "R002"  || value == "R005" ){
            $('#unitid_edit').removeAttr("required");
            $('#unitid_edit').prop("disabled", true);
            $('#unit_edit').css("display", 'none');
        }else{
            $('#unitid_edit').prop("required", true);
            $('#unitid_edit').prop("disabled", false);
            $('#unit_edit').removeAttr("style");
        }
    });
</script>
<script>
    $(document).on('click', '#tambah', function() {
        // console.log('tambah');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#formTambahUser').serialize(),
            url: "{{url('user/tambah')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.success(data.success);
                    $("#modalFormTambahUser").modal('hide');
                    $('#tb_user').DataTable().ajax.reload(null, false);
                } else {
                    toastr.success(data.success);
                }
            },
            error: function(data) {
                if (data.responseJSON.errors.hasOwnProperty('nama')) {
                    toastr.error(data.responseJSON.errors.nama[0]);
                }
                if (data.responseJSON.errors.hasOwnProperty('username')) {
                    toastr.error(data.responseJSON.errors.username[0]);
                }
                if (data.responseJSON.errors.hasOwnProperty('password')) {
                    toastr.error(data.responseJSON.errors.password[0]);
                }
                if (data.responseJSON.errors.hasOwnProperty('role')) {
                    toastr.error(data.responseJSON.errors.role[0]);
                }
                if (data.responseJSON.errors.hasOwnProperty('unitid')) {
                    toastr.error(data.responseJSON.errors.unitid[0]);
                }
            }
        });
    });
</script>

<script>
    $(document).on('click', '.edit', function() {
        var users_id = $(this).attr("data-users_id");
        var nama = $(this).attr("data-nama");
        var username = $(this).attr("data-username");
        var password = $(this).attr("data-password");
        var role = $(this).attr("data-role");
        var unit = $(this).attr("data-unit");
        $("#users_id_edit").val(users_id);
        $("#nama_edit").val(nama);
        $("#username_edit").val(username);
    
        $("#role_edit").select2({
        theme: "bootstrap-5",
        dropdownParent: $('#modalFormEditUser'),
        placeholder: "Pilih Role",
        width: "100%"
        });

        $("#unitid_edit").select2({
        theme: "bootstrap-5",
        dropdownParent: $('#modalFormEditUser'),
        placeholder: "Pilih Unit",
        width: "100%"
        });
        // // console.log(role);
        $('#role_edit').val(role).trigger('change');
      
        if(unit != null){
            $('#unitid_edit').val(unit).trigger('change');
            $('#unitid_edit').removeAttr("required");
            $('#unitid_edit').prop("disabled", true);
            $('#unit_edit').css("display", 'none');
        }else{
            $('#unitid_edit').removeAttr("required");
            $('#unitid_edit').prop("disabled", true);
            $('#unit_edit').css("display", 'none');
        }
    });
</script>

<script>
    $(document).on('click', '#update', function() {
        // console.log('update');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#FormEditUser').serialize(),
            url: "{{url('user/update')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.success(data.success);
                    $("#modalFormEditUser").modal('hide');
                    $('#tb_user').DataTable().ajax.reload(null, false);
                } else {
                    toastr.success(data.success);
                }
                $('#password_edit').val('');
            },
            error: function(data) {
                // console.log(data);
                if (data.responseJSON.errors.hasOwnProperty('nama')) {
                    toastr.error(data.responseJSON.errors.nama[0]);
                }
                if (data.responseJSON.errors.hasOwnProperty('username')) {
                    toastr.error(data.responseJSON.errors.username[0]);
                }
                if (data.responseJSON.errors.hasOwnProperty('password')) {
                    toastr.error(data.responseJSON.errors.password[0]);
                }
                if (data.responseJSON.errors.hasOwnProperty('role')) {
                    toastr.error(data.responseJSON.errors.role[0]);
                }
                if (data.responseJSON.errors.hasOwnProperty('unitid')) {
                    toastr.error(data.responseJSON.errors.unitid[0]);
                }
            }
        });
    });
</script>


<script>
    $(document).on('click', '#delete', function() {
        // console.log('delete');
        var users_id = $(this).attr("data-id");
        // console.log(users_id);

        // $('.eg-swal-av2').on("click", function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                // console.log(users_id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('user/delete')}}" + '/' + users_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if (data.kode == 201) {
                            toastr.success(data.success);
                            $('#tb_user').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.success(data.success);
                        }
                    },
                    error: function(data) {
                        // console.log('Error:', data);
                    }
                });
            }
        });
    });
</script>


@endsection