@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Repositori</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Repositori</a></li>
                                <li class="breadcrumb-item active">Repositori</li>
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
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                                        data-bs-toggle="modal" data-bs-target="#modalTambahFile">Tambah
                                                        File</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <div class="mt-4 mt-xl-0">
                                                        <ul class="nav nav-pills nav-justified" role="tablist">
                                                            <li class="nav-item waves-effect waves-light">
                                                                <a class="nav-link active" onclick="refreshMyFiles()"
                                                                    data-bs-toggle="tab" href="#my_file" role="tab">
                                                                    <span class="d-block d-sm-none"><i
                                                                            class="far fa-user"></i></span>
                                                                    <span class="d-none d-sm-block">My Files</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item waves-effect waves-light">
                                                                <a class="nav-link" onclick="refreshAllFiles()"
                                                                    data-bs-toggle="tab" href="#all_file" role="tab">
                                                                    <span class="d-block d-sm-none"><i
                                                                            class="fas fa-home"></i></span>
                                                                    <span class="d-none d-sm-block">All Files</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <br>
                                                        <div class="tab-content">
                                                            <div class="tab-pane" id="all_file" role="tabpanel">
                                                                <table class="table" id="tb_all_file" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:5%">No</th>
                                                                            <th style="width:21% !important">Nama File</th>
                                                                            <th style="width:10%">Uploader</th>
                                                                            <th style="width:20%">Deskripsi</th>
                                                                            <th style="width:10%">Kategori</th>
                                                                            <th style="width:10%">Ekstensi</th>
                                                                            <th style="width:19%">Tanggal Upload</th>
                                                                            <th style="width:5%">Aksi</th>
                                                                        </tr>
                                                                        <tr class="search" id="search_all">
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
                                                                </p>
                                                            </div>
                                                            <div class="tab-pane active" id="my_file" role="tabpanel">
                                                                <table class="table" id="tb_my_file" style="width: 100%;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:5%">No</th>
                                                                            <th style="width:21% !important">Nama File</th>
                                                                            <th style="width:10%">Uploader</th>
                                                                            <th style="width:20%">Deskripsi</th>
                                                                            <th style="width:10%">Kategori</th>
                                                                            <th style="width:10%">Ekstensi</th>
                                                                            <th style="width:19%">Tanggal Upload</th>
                                                                            <th style="width:5%">Aksi</th>
                                                                        </tr>
                                                                        <tr class="search" id="search_my">
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
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 card">
                                                    <div class="mt-4 mt-xl-0">
                                                        <div class="card-title">
                                                            <p class="text-center">Batch Download</p>
                                                        </div>
                                                        <form id="batch">
                                                            {{ csrf_field() }}
                                                            <div id="cart"
                                                                style="overflow-y: auto; max-height:100vh; white-space: nowrap;">
                                                            </div>
                                                            <div class="card-body text-center">
                                                                <a href="{{ url('repositori/zipdownload') }}"
                                                                    onclick="clearCart()" id="zipdownload"
                                                                    class="btn btn-primary" target="_blank" style="pointer-events: none">Download
                                                                    ZIP</a>
                                                            </div>
                                                        </form>
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
    </div>
    <div class="modal fade" id="modalTambahFile" style="font-size: 14pt">
        <form action="javascript:;" class="form-validate is-alter" id="formTambahFile" enctype="multipart/form-data">
            <div class="modal-dialog modal-dialog-top modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label class="form-label" for="formrow-firstname-input">Attachment File:</label>
                                                <small style="font-size: 8pt; display:block; margin-top:-10px; margin-bottom:2px;">File yang didukung: doc,xls,docx,xlsx,pdf,jpg,jpeg,png,svg</small>
                                                <div class="row" id="append_div">
                                                    <div class="col-md-4">
                                                        <div class="mt-1">
                                                            <input name="file_repositori[]" id="file_repositori" type="file" class="form-control" accept=".doc,.xls,.docx,.xlsx,.pdf,.jpg,.jpeg,.png,.svg" placeholder="Enter First Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="mt-1">
                                                            <input type="text" name="deskripsi_file[]" class="form-control" placeholder="Deskripsi file">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mt-1">
                                                            <select name="kategori_file[]" id="kategori_file" class="form-control kategori">
                                                                <option value="1">Kategori 1</option>
                                                                <option value="2">Kategori 2</option>
                                                                <option value="3">Kategori 3</option>
                                                                <option value="4">Kategori 4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 text-center">
                                                        <div class="mt-1">
                                                            <button type="button" name="plus_append_file"
                                                                id="plus_append_file"
                                                                class="btn btn-primary waves-effect waves-light"><i
                                                                    class="mdi mdi-plus"></i>
                                                            </button>
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
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        function refreshRow() {
            const id = document.getElementById('batch');
            var formDataCart = new FormData(id);
            var array = formDataCart.getAll('id[]');
            // // console.log(array);
            for (i = 0; i < array.length; i++) {
                array[i] = array[i].split(' ').join('_');
                // // console.log(array[i]);
                var my = document.getElementById("my_" + array[i]);
                var all = document.getElementById("all_" + array[i]);
                // // console.log(my);
                // // console.log(all);
                if (my != null) {
                    my.classList.add("highlight");
                }
                if (all != null) {
                    all.classList.add("highlight");
                }
            }
        }

        function tabelAll() {
            var nama = "";
            var ekstensi = "";
            var uploader = "";
            var tanggal = "";
            var deskripsi = "";
            var kategori = "";

            nama = $('#all_name').val();
            ekstensi = $('#all_ext').val();
            uploader = $('#all_uploader').val();
            tanggal = $('#all_tanggal').val();
            deskripsi = $('#all_deskripsi').val();
            kategori = $('#all_kategori').val();

            url = '&nama=' + nama + '&ekstensi=' + ekstensi + '&uploader=' + uploader + '&tanggal=' + tanggal+ '&deskripsi=' + deskripsi+ '&kategori=' + kategori;
            // console.log(url);
            $('#tb_all_file').DataTable().ajax.url("{{ url('repositori/getFileBy') }}" + '?tb=all' +
                url).load();
        };

        function tabelMy() {
            var nama = "";
            var ekstensi = "";
            var uploader = "";
            var tanggal = "";
            var deskripsi = "";
            var kategori = "";

            nama = $('#my_name').val();
            ekstensi = $('#my_ext').val();
            uploader = $('#my_uploader').val();
            tanggal = $('#my_tanggal').val();
            deskripsi = $('#my_deskripsi').val();
            kategori = $('#my_kategori').val();
            
            url = '&nama=' + nama + '&ekstensi=' + ekstensi + '&uploader=' + uploader + '&tanggal=' + tanggal+ '&deskripsi=' + deskripsi+ '&kategori=' + kategori;
            // console.log(url);
            $('#tb_my_file').DataTable().ajax.url("{{ url('repositori/getFileBy') }}" + '?tb=my' +
                url).load();
        };

        $(document).ready(function() {
            var tb_all_file = $('#tb_all_file').DataTable({
                destroy: true,
                processing: true,
                searching: true,
                autoWidth: false,
                serverSide: true,
                initComplete: function(settings, json) {
                    $("#tb_all_file").wrap(
                        "<div style='overflow-x:auto; width:100%; position:relative;'></div>");
                    $('#search_all').html(
                        '<form id="formAll"><th></th><th><input type="text" class="all form-control" onkeyup="tabelAll()"  name="nama" placeholder="Cari nama file.." id="all_name"></th><th><input type="text" class="all form-control" onkeyup="tabelAll()"  name="uploader" placeholder="uploader.."id="all_uploader"></th><th><input type="text" class="all form-control" onkeyup="tabelAll()"  name="deskripsi" placeholder="deskripsi.." id="all_deskripsi"></th><th><input type="text" class="all form-control" onkeyup="tabelAll()"  name="kategori" placeholder="kategori file.." id="all_kategori"></th><th><input type="text" class="all form-control" onkeyup="tabelAll()"  name="ekstensi" placeholder="ekstensi.."id="all_ext"></th><th><input type="text" class="all form-control" onkeyup="tabelAll()"  name="tanggal" placeholder="tanggal.."id="all_tanggal"></th><th></th></form>'
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
                    url: "{{ url('repositori/getDataAllFiles') }}",
                    data: {
                        "tab": "semua"
                    },
                    type: 'GET',
                },
                columns: [
                    {
                        title: 'No',
                        width: '5%',
                        data: 'no',
                        name: 'no',
                    },
                    {
                        title: 'Nama File',
                        width: '21%',
                        data: 'nama_file',
                        name: 'nama_file',
                    },
                    {
                        title: 'Uploader',
                        width: '10%',
                        data: 'uploader',
                        name: 'uploader',
                    },
                    {
                        title: 'Deskripsi',
                        width: '20%',
                        data: 'deskripsi',
                        name: 'deskripsi',
                    },
                    {
                        title: 'Kategori',
                        width: '10%',
                        data: 'kategori',
                        name: 'kategori',
                    },
                    {
                        title: 'Ekstensi',
                        width: '10%',
                        data: 'format_file',
                        name: 'format_file',
                    },
                    {
                        title: 'Tanggal Upload',
                        width: '19%',
                        data: 'tanggal_upload',
                        name: 'tanggal_upload',
                    },
                    {
                        title: 'Aksi',
                        width: '5%',
                        data: 'aksi',
                        name: 'aksi',
                    },
                ],
            });
            var tb_my_file = $('#tb_my_file').DataTable({
                destroy: true,
                processing: true,
                searching: true,
                autoWidth: false,
                serverSide: true,
                initComplete: function(settings, json) {
                    $("#tb_my_file").wrap(
                        "<div style='overflow-x:auto; width:100%; position:relative;'></div>");
                    $('#search_my').html(
                        '<form id="formMy"><th></th><th><input type="text" class="my form-control" onkeyup="tabelMy()"  name="nama" placeholder="Cari nama file.." id="my_name"></th><th><input type="text" class="my form-control" onkeyup="tabelMy()"  name="uploader" placeholder="uploader.."id="my_uploader"></th><th><input type="text" class="my form-control" onkeyup="tabelMy()"  name="deskripsi" placeholder="deskripsi.." id="my_deskripsi"></th><th><input type="text" class="my form-control" onkeyup="tabelMy()"  name="kategori" placeholder="kategori file.." id="my_kategori"></th><th><input type="text" class="my form-control" onkeyup="tabelMy()"  name="ekstensi" placeholder="ekstensi.."id="my_ext"></th><th><input type="text" class="my form-control" onkeyup="tabelMy()"  name="tanggal" placeholder="tanggal.."id="my_tanggal"></th><th></th></form>'
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
                    url: "{{ url('repositori/getDataAllFiles') }}",
                    data: {
                        "tab": "pribadi"
                    },
                    type: 'GET',
                },
                columns: [
                    {
                        title: 'No',
                        width: '5%',
                        data: 'no',
                        name: 'no',
                    },
                    {
                        title: 'Nama File',
                        width: '21%',
                        data: 'nama_file',
                        name: 'nama_file',
                    },
                    {
                        title: 'Uploader',
                        width: '10%',
                        data: 'uploader',
                        name: 'uploader',
                    },
                    {
                        title: 'Deskripsi',
                        width: '20%',
                        data: 'deskripsi',
                        name: 'deskripsi',
                    },
                    {
                        title: 'Kategori',
                        width: '10%',
                        data: 'kategori',
                        name: 'kategori',
                    },
                    {
                        title: 'Ekstensi',
                        width: '10%',
                        data: 'format_file',
                        name: 'format_file',
                    },
                    {
                        title: 'Tanggal Upload',
                        width: '19%',
                        data: 'tanggal_upload',
                        name: 'tanggal_upload',
                    },
                    {
                        title: 'Aksi',
                        width: '5%',
                        data: 'aksi',
                        name: 'aksi',
                    },
                ],
            });
            tb_all_file.on('draw', function() {
                refreshRow();
            });
            tb_my_file.on('draw', function() {
                refreshRow();
            });
            $(".kategori").select2({
                theme: "bootstrap-5",
                placeholder: "Pilih Kategori",
                width: "100%"
            });
        });
    </script>
    <script>
        var index = 0;
        var checked = [];

        function addToCart(id) {
            $('#zipdownload').css('pointer-events', 'auto');
            var element = document.getElementById('item_' + id);
            // // console.log(element);
            // // console.log(id);
            if (element == null) {
                var id_ = "'" + id + "'";

                var zip = document.getElementById('zipdownload');

                if (id.length > 27) {
                    var text = id.substr(13, 7) + '..' + id.substr(-7, 7);
                } else {
                    var text = id.substr(13);
                }

                $("#cart").append(
                    '<div id="item_' + id +
                    '" class="alert alert-info staged_item" role="alert"><p style="font-size:12px;">' + text +
                    '<button onclick="removeFromCart(' +
                    id_ + ')" style="float: right"class="btn-close my-1"></button>' +
                    '</p><input type="hidden" name="id[]" value="row_' + id + '"></div>'
                );

                if (zip.href == "{{ url('repositori/zipdownload') }}") {
                    zip.href = zip.href + "?arr[]=" + encodeURIComponent(id);
                    // console.log("encoded: " + zip.href);
                } else {
                    zip.href = zip.href + "&arr[]=" + encodeURIComponent(id);
                    // console.log("encoded2: " + zip.href);
                }

                checked[index++] = "row_" + id.split(' ').join('_');
                // console.log(checked);
                for (i = 0; i < checked.length; i++) {
                    // console.log(checked[i]);
                    var my = document.getElementById("my_" + checked[i]);
                    var all = document.getElementById("all_" + checked[i]);
                    // // console.log("tambah");
                    // // console.log(all);
                    if (my != null) {
                        my.classList.add("highlight");
                    }
                    if (all != null) {
                        all.classList.add("highlight");
                    }
                }
            }
        }

        function clearCart() {
            const cart = document.getElementById("cart");
            while (cart.hasChildNodes()) {
                cart.removeChild(cart.firstChild);
            }

            setTimeout(function() {
                var zip = document.getElementById('zipdownload');
                zip.href = "{{ url('repositori/zipdownload') }}";
            }, 500);

            $('tr').removeClass('highlight')
            checked.length = 0;
            index=0;

            $('#zipdownload').css('pointer-events', 'none');
        }

        function removeFromCart(item) {
            var cancel = document.getElementById("item_" + item);
            cancel.remove();
            var zip = document.getElementById('zipdownload');
            let link = decodeURIComponent(zip.href);
            var result = link.replace("&arr[]=" + item, "");
            var result = result.replace("arr[]=" + item + "&", "");
            var result = result.replace("arr[]=" + item, "");
            zip.href = result;

            var item_all = "all_row_" + item.split(' ').join('_');
            var row_all = document.getElementById(item_all)
            var item_my = "my_row_" + item.split(' ').join('_');
            var row_my = document.getElementById(item_my)
            if (row_my != null) {
                row_my.classList.remove("highlight");
            }
            if (row_all != null) {
                row_all.classList.remove("highlight");
            }
            var temp = checked;
            // console.log(temp.length);
            checked.length = 0;
            for (i = 0; i < temp.length; i++) {
                if (temp[i] != "row_" + item.split(' ').join('_')) {
                    // console.log("index ke: "+i);
                    // console.log(temp[i]);
                    if (checked.length == 0) {
                        checked[0] = temp[i];
                    } else {
                        checked[checked.length - 1] = temp[i];
                    }
                }
            }
            var staged_items = $('.staged_item').length;
            // console.log(staged_items);
            if(staged_items == 0){
                $('#zipdownload').css('pointer-events', 'none');
            }
            index--;
            // console.log(index);
        }
    </script>
    <script>
        function refreshMyFiles() {
            $('#tb_my_file').DataTable().ajax.reload(null, false);
        }

        function refreshAllFiles() {
            $('#tb_all_file').DataTable().ajax.reload(null, false);
        }
    </script>
    <script>
        var input = 0;
        $("#plus_append_file").click(function() {
            $("#append_div").append(
                '<div class="col-xl-4 next_'+input+'" id="file_repositori_'+input+'">'
                    +'<div class="mt-3">'
                        +'<input name="file_repositori[]" id="file_repositori_'+input+'" type="file" class="form-control" accept=".doc,.xls,.docx,.xlsx,.pdf,.jpg,.jpeg,.png,.svg" placeholder="Enter First Name">'
                    +'</div>'
                +'</div>'
                +'<div class="col-xl-5 next_'+input+'">'
                    +'<div class="mt-3">'
                        +'<input type="text" name="deskripsi_file[]" class="form-control" placeholder="Deskripsi file">'
                    +'</div>'
                +'</div>'
                +'<div class="col-xl-2 next_'+input+'">'
                    +'<div class="mt-3">'
                        +'<select name="kategori_file[]" id="kategori_file_'+input+'" class="form-control kategori">'
                            +'<option value="1">Kategori 1</option>'
                            +'<option value="2">Kategori 2</option>'
                            +'<option value="3">Kategori 3</option>'
                            +'<option value="4">Kategori 4</option>'
                        +'</select>'
                    +'</div>'
                +'</div>'
                +'<div class="col-xl-1 text-center next_'+input+'">'
                    +'<div class="mt-3">'
                        +'<button type="button" name="plus_append_file" id="plus_append_file_'+input+'" class="btn btn-danger" onclick="removeInput(' +input++ + ')"> <i class = "mdi mdi-close"></i></button>'
                    +'</div>'
                +'</div>'
            );
            $(".kategori").select2({
                theme: "bootstrap-5",
                placeholder: "Pilih Kategori",
                width: "100%"
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
        function removeInput(e) {
            $(".next_"+e).remove();
        }
    </script>
    <script type="text/javascript">
        $('#formTambahFile').submit(function() {
            var formData = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                url: "{{ url('repositori/tambah') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if (data.kode == 201) {
                        toastr.clear();
                        toastr.success(data.success);
                        $("#modalTambahFile").modal('hide');
                        $('#tb_all_file').DataTable().ajax.reload(null, false);
                        $('#tb_my_file').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.clear();
                        toastr.error(data.success);
                    }
                },
                error: function(data) {
                    // console.log('Error:', data);
                }
            });
        });
    </script>
    <script>
        function deletefile(filepath) {
            // console.log(filepath);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                processData: false,
                contentType: false,
                url: "{{ url('repositori/delete') }}" + "/" + filepath,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {
                        toastr.clear();
                        toastr.success(datas.success);
                        var a = document.getElementById('konfirmasi' + filepath);
                        // console.log(a);
                        a.remove();
                        var cancel = document.getElementById("item_" + filepath);
                        if (cancel != null) {
                            cancel.remove();
                        }
                        $('#tb_all_file').DataTable().ajax.reload(null, false);
                        $('#tb_my_file').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.clear();
                        toastr.error(data.success);
                    }
                },
                error: function(datas) {
                    // console.log(datas);
                    // console.log('Error:', datas);
                }
            });
        }
    </script>
    <script>
        function deleteclick(t, f) {
            var m1 = $(makeModal(t, f));
            m1.modal('show');
        };

        function makeModal(text, filepath) {
            var filepath_ = filepath.replace("'", "")
            var filepath = "'" + filepath + "'";
            return '<div class="modal" tabindex="-1" id="konfirmasi' + filepath_ +
                '"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Konfirmasi Hapus</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><p>Apakah anda ingin menghapus ' +
                text +
                '?</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="button" onclick="deletefile(' +
                filepath + ')" class="btn btn-danger" data-bs-dismiss="modal">Hapus</button></div></div></div></div>';
        }
    </script>
@endsection
