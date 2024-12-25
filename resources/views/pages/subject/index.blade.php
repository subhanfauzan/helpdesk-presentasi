@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Subject</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">Manage Subject</li>
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
                                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormTambahSubject">Tambah Subject</button> -->
                                                                <button type="button" class="btn btn-primary waves-effect waves-light addButton" data-bs-toggle="modal" data-bs-target="#modalFormTambahSubject">Tambah Subject</button>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table" id="tb_subject" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Kategori</th>
                                                                <th>Nama Layanan</th>
                                                                <th>Jam Layanan</th>
                                                                <th>Deskripsi layanan</th>
                                                                <th>Nama Subject</th>
                                                                <th>Kategori Subject</th>
                                                                <th>Template Subject</th>
                                                                <th>Response Time SLA Subject</th>
                                                                <th>Resolution Time SLA Subject</th>
                                                                <th style="width: 10%">Aksi</th>
                                                            </tr>
                                                            <tr class="search" id="search">
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
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

<div class="modal fade" id="modalFormTambahSubject">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Subject</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="formTambahSubject" id="formTambahSubject">
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
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_subject" name="nama_subject" required>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="form-label" for="kategori_subject">Kategori Subject</label>
                    <div class="form-control-wrap">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="kategori_subject" name="kategori_subject" value="INC" required>
                            <label class="form-check-label" for="kategori_subject">INC</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="kategori_subject" name="kategori_subject" value="REQ" required>
                            <label class="form-check-label" for="kategori_subject">REQ</label>
                        </div>
                    </div>
                </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Template Subject</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="template_subject" name="template_subject" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Response Time SLA</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="response_time_sla_subject" name="response_time_sla_subject" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Resolution Time SLA</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="resolution_time_sla_subject" name="resolution_time_sla_subject" required>
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

<div class="modal fade" id="modalFormEditSubject">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subject</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="FormEditRole" id="FormEditRole">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" id="subject_id_edit" name="subject_id_edit" required>
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
                        <label class="form-label" for="full-name">Pilih Layanan</label>
                        <div class="form-control-wrap">
                            <select disabled name="layanan_id_edit" id="layanan_id_edit">
                                <option value=""></option>
                                <!-- @foreach($m_layanan as $data)
                                <option value="{{$data->id}}">{{$data->nama_layanan}}</option>
                                @endforeach -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_subject_edit" name="nama_subject_edit" required>
                        </div>
                    </div>
                    <label class="form-label" for="kategori_subject">Kategori Subject</label>
                    <div class="form-control-wrap">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="kategori_subject_edit_inc" name="kategori_subject_edit" value="INC" >
                            <label class="form-check-label" for="kategori_subject_edit">INC</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="kategori_subject_edit_req" name="kategori_subject_edit" value="REQ" >
                            <label class="form-check-label" for="kategori_subject_edit">REQ</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Template Subject</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="template_subject_edit" name="template_subject_edit" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Response Time SLA</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="response_time_sla_subject_edit" name="response_time_sla_subject_edit" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Resolution Time SLA</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="resolution_time_sla_subject_edit" name="resolution_time_sla_subject_edit" required>
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

    $(document).ready(function() {
        $("#layanan_id").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Layanan"
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
                data: $('#formTambahPeiodePosyandu').serialize(),
                url: "{{url('subject/getListLayanan')}}" + '/' + kategori_id,
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

<script type="text/javascript">
    $(document).ready(function() {
        var tb_user = $('#tb_subject').DataTable({
            destroy: true,
            processing: true,
            searching: true,
            autoWidth: false,
            serverSide: true,
            initComplete: function(settings, json) {
                $('#search').html(
                    '<form id="formsearch"><th></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="nama_kategori" placeholder="Cari..." id="nama_kategori"></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="nama_layanan" placeholder="Cari..." id="nama_layanan"></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="jam_layanan" placeholder="Cari..." id="jam_layanan"></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="deskripsi_layanan" placeholder="Cari..." id="deskripsi_layanan"></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="nama_subject" placeholder="Cari..." id="nama_subject"></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="kategori_subject" placeholder="Cari..." id="kategori_subject"></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="template_subject" placeholder="Cari..." id="template_subject"></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="response_time_sla_subject" placeholder="Cari..." id="response_time_sla_subject"></th>' +
                    '<th><input type="text" class="form-control" onkeyup="search()" name="resolution_time_sla_subject" placeholder="Cari..." id="resolution_time_sla_subject"></th>' +
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
                url: "{{ url('subject/getDataSubject') }}",
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
                    data: 'nama_subject',
                    name: 'nama_subject',
                    className: 'text-center'
                },
                {
                    data: 'kategori_subject',
                    name: 'kategori_subject',
                    className: 'text-center'
                },
                {
                    data: 'template_subject',
                    name: 'template_subject',
                    className: 'text-center'
                },
                {
                    data: 'response_time_sla_subject',
                    name: 'response_time_sla_subject',
                    className: 'text-center'
                },
                {
                    data: 'resolution_time_sla_subject',
                    name: 'resolution_time_sla_subject',
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
        var nama_kategori = $('#nama_kategori').val();
        var nama_layanan = $('#nama_layanan').val();
        var jam_layanan = $('#jam_layanan').val();
        var deskripsi_layanan = $('#deskripsi_layanan').val();
        var nama_subject = $('#nama_subject').val();
        var kategori_subject = $('#kategori_subject').val();
        var template_subject = $('#template_subject').val();
        var response_time_sla_subject = $('#response_time_sla_subject').val();
        var resolution_time_sla_subject = $('#resolution_time_sla_subject').val();

        var url = '?nama_kategori=' + nama_kategori +
                  '&nama_layanan=' + nama_layanan +
                  '&jam_layanan=' + jam_layanan +
                  '&deskripsi_layanan=' + deskripsi_layanan +
                  '&nama_subject=' + nama_subject +
                  '&kategori_subject=' + kategori_subject +
                  '&template_subject=' + template_subject +
                  '&response_time_sla_subject=' + response_time_sla_subject +
                  '&resolution_time_sla_subject=' + resolution_time_sla_subject;

        $('#tb_subject').DataTable().ajax.url("{{ url('subject/getDataSubjectBy') }}" + url).load();
    }
</script>


<script>
    $(document).on('click', '#tambah', function() {
        // console.log('coba1');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#formTambahSubject').serialize(),
            url: "{{url('subject/tambah')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalFormTambahSubject").modal('hide');
                    $('#tb_subject').DataTable().ajax.reload(null, false);
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

    $(document).ready(function() {
        $("#layanan_id_edit").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Layanan"
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
                data: $('#formTambahPeiodePosyandu').serialize(),
                url: "{{url('subject/getListLayanan')}}" + '/' + kategori_id,
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

<script>
    $(document).ready(function() {
        // $("#edit").click(function() {
        $(document).on('click', '#edit', function() {
            // console.log('coba');

            var kategori_id_edit = $(this).attr("data-kategori_id");
            var layanan_id_edit = $(this).attr("data-layanan_id");
            var subject_id_edit = $(this).attr("data-subject_id");
            var nama_subject_edit = $(this).attr("data-nama_subject");
            var kategori_subject_edit = $(this).attr("data-kategori_subject");
            var template_subject_edit = $(this).attr("data-template_subject");
            var response_time_sla_subject_edit = $(this).attr("data-response_time_sla_subject");
            var resolution_time_sla_subject_edit = $(this).attr("data-resolution_time_sla_subject");

            $("#kategori_id_edit").val(kategori_id_edit).trigger('change');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#formTambahPeiodePosyandu').serialize(),
                url: "{{url('subject/getListLayanan')}}" + '/' + kategori_id_edit,
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

        if (kategori_subject_edit == 'REQ') {
            $("#kategori_subject_edit_req").prop("checked", true);
            $("#kategori_subject_edit_inc").prop("checked", false);
        }else if (kategori_subject_edit == 'INC') {
            $("#kategori_subject_edit_inc").prop("checked", true);
            $("#kategori_subject_edit_req").prop("checked", false);
        }else{
            $("#kategori_subject_edit_inc").prop("checked", false);
            $("#kategori_subject_edit_req").prop("checked", false);
        }

            $("#subject_id_edit").val(subject_id_edit);
            $("#nama_subject_edit").val(nama_subject_edit);
            $("#kategori_subject_edit").val(kategori_subject_edit);
            $("#template_subject_edit").val(template_subject_edit);
            $("#response_time_sla_subject_edit").val(response_time_sla_subject_edit);
            $("#resolution_time_sla_subject_edit").val(resolution_time_sla_subject_edit);



        });
    });
</script>

<script>
    $(document).on('click', '#update', function() {
        // console.log('update');
        // var coba = $("input[type='radio'][name='kategori_subject_edit']:checked").val();
        // console.log(coba);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#FormEditRole').serialize(),
            url: "{{url('subject/update')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalFormEditSubject").modal('hide');
                    $('#tb_subject').DataTable().ajax.reload(null, false);
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
        var subject_id = $(this).attr("data-subject_id");
        // console.log(subject_id);

        // $('.eg-swal-av2').on("click", function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                // console.log(subject_id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // data: $('#FormEditUser').serialize(),
                    url: "{{url('subject/delete')}}" + '/' + subject_id,
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
                            $('#tb_subject').DataTable().ajax.reload(null, false);
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
        var subject_id = $(this).attr("data-subject_id");

        console.log(this.checked);
        var value = this.checked;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {status_aktif:value, subject_id:subject_id},
            url: "{{url('subject/updateStatusSubjectAktif')}}",
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
                    $('#tb_subject').DataTable().ajax.reload(null, false);
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