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
                                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalformTambahFaqDetail">tambah Faq</button> -->
                                                                <button type="button" class="btn btn-primary waves-effect waves-light addButton" data-bs-toggle="modal" data-bs-target="#modalformTambahFaqDetail">Tambah Faq Detail</button>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table" id="tb_faq_detail" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                <th>Deskripsi</th>
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

<div class="modal fade" id="modalformTambahFaqDetail">
    <div class="modal-dialog modal-dialog-top modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Faq Detail</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="formTambahFaqDetail" id="formTambahFaqDetail">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$m_faq->id}}" class="form-control" id="id_faq" name="id_faq">
                    <div class="form-group mb-1">
                        <label class="form-label" for="full-name">Nomor</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="no" name="no" required>
                        </div>
                    </div>
                    <div class="form-group mb-1">
                        <label class="form-label" for="full-name">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="nama_faq_detail" name="nama_faq_detail" required>
                        </div>
                    </div>
                    <div class="form-group mb-1">
                        <label class="form-label" for="full-name">Deskripsi</label>
                        <div class="form-control-wrap">
                            <!-- <input type="text" class="form-control" id="deskripsi_faq_detail" name="deskripsi_faq_detail" required> -->
                            <div name="deskripsi_faq_detail" id="deskripsi_faq_detail" class="deskripsi_faq_detail" style="height: 491px;">

                            </div>
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
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {
        // NioApp.DataTable.init = function() {
        // NioApp.DataTable('#tb_user', {

        var tb_user = $('#tb_faq_detail').DataTable({
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
                url: "{{ url('faq_master/getDataFaqDetail') }}" + '?m_faq_id=' + "{{$m_faq->id}}",
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'nama_faq_detail',
                    name: 'nama_faq_detail',
                    className: 'text-center'
                },
                {
                    data: 'deskripsi_faq_detail_quill',
                    name: 'deskripsi_faq_detail_quill',
                    className: 'text-center'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    className: 'text-start'
                },

            ],
            drawCallback: function(settings) {
                // var api = this.api();

                // // Output the data for the visible rows to the browser's console
                // // console.log(api.rows({
                //     page: 'current'
                // }).data());

                // $(".tiket_issues_search").val(tiket);
                // $('#tb_issues').DataTable().ajax.reload(null, false);
                var deskripsi_faq_detail_quill_datatable = new Quill(".deskripsi_faq_detail_quill_datatable", {
                    theme: "snow",
                    modules: {
                        "toolbar": false
                    },
                    disabled: true,
                });

                $('.deskripsi_faq_detail_quill_datatable').on('keydown', function() {
                    // alert('key up');
                    return false;
                });
            }
        })
        // };
    });
</script>

<script>
    $(document).on('click', '#tambah', function() {
        // console.log('tambah');
        var formData = new FormData();
        var deskripsi_faq_detail = $('#deskripsi_faq_detail').html().replaceAll('type="text"', 'type="hidden"');
        var id_faq = $('#id_faq').val();
        var no = $('#no').val();
        var nama_faq_detail = $('#nama_faq_detail').val();
        formData.append('deskripsi_faq_detail', deskripsi_faq_detail);
        formData.append('id_faq', id_faq);
        formData.append('no', no);
        formData.append('nama_faq_detail', nama_faq_detail);

        console.log(formData);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            url: "{{url('faq_master/tambahDetail')}}",
            type: "POST",
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalformTambahFaqDetail").modal('hide');
                    $('#tb_faq_detail').DataTable().ajax.reload(null, false);
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
                    $('#tb_faq_detail').DataTable().ajax.reload(null, false);
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
        var m_faq_detail_id = $(this).attr("data-m_faq_detail_id");
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
                    url: "{{url('faq_master/deleteDetail')}}" + '/' + m_faq_detail_id,
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
                            $('#tb_faq_detail').DataTable().ajax.reload(null, false);
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
    var quill_deskripsi_faq_detail;
    $(document).ready(function() {

        quill_deskripsi_faq_detail = new Quill("#deskripsi_faq_detail", {
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
        // $('#deskripsi_faq_detail').on('keyup', function() {
        $(document).on('keyup', '#deskripsi_faq_detail', function(e) {
            // console.log('coba');
            // alert('key up');
            // return false;
            // var get_deskripsi_faq_detail = $('#deskripsi_faq_detail').html();
            // // const sanitizer = new Sanitizer();
            // var get_deskripsi_faq_detail_split = get_deskripsi_faq_detail.replace(/<font[^>]*>/g,'<p>').replace(/<\/font>/g,'</p>');
            editor_content = quill_deskripsi_faq_detail.root.innerHTML
            editor_content = editor_content.replace(/\s/g, '');
            // editor_content = editor_content.replace('<br>', '');
            // editor_content = editor_content.replace('<p>', '');
            // editor_content = editor_content.replace('</p>', '');
            editor_content = editor_content.replace(/<[^>]*>?/gm, '')
            // console.log(editor_content.length);
            $("#deskripsi_faq_detail_lenght").html(editor_content.length);
            if (editor_content.length <= 1000) {
                $("#deskripsi_faq_detail_lenght").css("background-color", "#00FF00");
            } else {
                $("#deskripsi_faq_detail_lenght").css("background-color", "#FF0000");
            }

        });

    });
</script>


@endsection