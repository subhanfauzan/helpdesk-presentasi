@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Notifikasi</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-4 mt-xl-0">
                                <ul class="nav nav-pills nav-justified" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active"
                                            data-bs-toggle="tab" href="#belum_dibaca" role="tab" onclick="refreshBL()">
                                            <span class="d-block d-sm-none"><i
                                                    class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Belum dibaca</span>
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link"
                                            data-bs-toggle="tab" href="#sudah_dibaca" role="tab" onclick="refreshSD()">
                                            <span class="d-block d-sm-none"><i
                                                    class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Sudah dibaca</span>
                                        </a>
                                    </li>
                                </ul>
                                <br>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="belum_dibaca" role="tabpanel">
                                        <table class="table" id="tb_belum_dibaca" style="width: 100%;">
                                            <button type="button" class="btn btn-primary" style="float: right" data-bs-toggle="modal" data-bs-target="#modalTandaiNotif">
                                                Tandai sebagai dibaca
                                            </button>
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">No</th>
                                                    <th style="width:70%">Notifikasi</th>
                                                    <th style="width:25%">Tanggal</th>
                                                    {{-- <th style="width:7%">Dibaca</th> --}}
                                                </tr>
                                                <tr class="search" id="search_belum">
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    {{-- <th></th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="sudah_dibaca" role="tabpanel">
                                        <table class="table" id="tb_sudah_dibaca" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">No</th>
                                                    <th style="width:70%">Notifikasi</th>
                                                    <th style="width:25%">Tanggal</th>
                                                    {{-- <th style="width:7%">Dibaca</th> --}}
                                                </tr>
                                                <tr class="search" id="search_sudah">
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    {{-- <th></th> --}}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTandaiNotif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Tandai Notifikasi sebagai telah dibaca</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-validate is-alter" name="marked" id="marked">
            <div class="modal-body">
                <p>Semua notifikasi sejak tanggal awal hingga akhir akan dianggap sebagai telah dibaca.</p>
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-label" for="full-name">Tanggal Awal</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="tanggalawal"
                            name="tanggalawal" value="{{ date('Y-m-d') }}"
                            required>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="full-name">Tanggal Akhir</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="tanggalakhir"
                                name="tanggalakhir" value="{{ date('Y-m-d') }}"
                                required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="konfirformtandai" data-bs-dismiss="modal" class="btn btn-danger">Konfirmasi</button>
                </div>
            </form>
          </div>
        </div>
      </div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $("#tanggalakhir").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                language: 'id-ID',
                locale: 'id',
                orientation: 'left bottom',
                todayHighlight: true
            });
            $("#tanggalakhir").datepicker()
                .on('changeDate', function (e) {
                    var endDate = document.getElementById('tanggalakhir').value;
                    // var Date = new Date(endDate);
                    $('#tanggalawal').datepicker('setEndDate', endDate);
                });
            $("#tanggalawal").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                language: 'id',
                locale: 'id',
                orientation: 'left bottom',
                todayHighlight: true
            });
            $("#tanggalawal").datepicker()
                .on('changeDate', function (e) {
                    var startDate = document.getElementById('tanggalawal').value;
                    // var selectedDate = new Date(startDate);
                    $('#tanggalakhir').datepicker('setStartDate', startDate);
                });
        });
    </script>
    <script>
        function refreshSD() {
            $('#tb_sudah_dibaca').DataTable().ajax.reload(null, false);
        }

        function refreshBL() {
            $('#tb_belum_dibaca').DataTable().ajax.reload(null, false);
        }
    </script>
    <script>
        $(document).ready(function() {
            var tb_belum_dibaca = $('#tb_belum_dibaca').DataTable({
                destroy: true,
                processing: true,
                searching: true,
                autoWidth: false,
                serverSide: true,
                initComplete: function(settings, json) {
                    $("#tb_belum_dibaca").wrap(
                        "<div style='overflow-x:auto; width:100%; position:relative;'></div>");
                    $('#search_belum').html(
                        '<form id="formAll"><th></th><th></th><th><input type="text" class="form-control"  name="tanggal" placeholder="Cari Tanggal.." id="bl_created_at"></th></form>'
                    );
                    $("#bl_created_at").datepicker('destroy');
                    $("#bl_created_at").datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        language: 'id-ID',
                        orientation: 'left bottom',
                        todayHighlight: true,
                        clearBtn: true
                    }).on('change', function(){
                        var tgl = $(this).val();
                        url = '&tgl='+tgl;
                        // console.log(url);
                        $('#tb_belum_dibaca').DataTable().ajax.url("{{ url('notifikasi/customserch') }}" + '?tab=belum' +
                                url).load();
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
                    url: "{{ url('notifikasi/getNotifikasi') }}",
                    data: {
                        "tab": "belum"
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
                        title: 'Notifikasi',
                        width: '70%',
                        data: 'notifikasi',
                        name: 'notifikasi',
                    },
                    {
                        title: 'Tanggal',
                        width: '25%',
                        data: 'tanggal',
                        name: 'tanggal',
                    },
                    // {
                    //     title: 'Dibaca',
                    //     width: '7%',
                    //     data: 'aksi',
                    //     name: 'aksi',
                    // },
                ],
            });
            var tb_sudah_dibaca = $('#tb_sudah_dibaca').DataTable({
                destroy: true,
                processing: true,
                searching: true,
                autoWidth: false,
                serverSide: true,
                initComplete: function(settings, json) {
                    $("#tb_sudah_dibaca").wrap(
                        "<div style='overflow-x:auto; width:100%; position:relative;'></div>");
                    $('#search_sudah').html(
                        '<form id="formMy"><th></th><th></th><th><input type="text" class="form-control"  name="tanggal" placeholder="Cari Tanggal.." id="sd_created_at"></th></form>'
                    );
                    $("#sd_created_at").datepicker('destroy');
                    $("#sd_created_at").datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        language: 'id-ID',
                        orientation: 'left bottom',
                        todayHighlight: true,
                        clearBtn: true
                    }).on('change', function(){
                        var tgl = $(this).val();
                        url = '&tgl='+tgl;
                        // console.log(url);
                        $('#tb_sudah_dibaca').DataTable().ajax.url("{{ url('notifikasi/customserch') }}" + '?tab=sudah' +
                                url).load();
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
                    url: "{{ url('notifikasi/getNotifikasi') }}",
                    data: {
                        "tab": "sudah"
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
                        title: 'Notifikasi',
                        width: '70%',
                        data: 'notifikasi',
                        name: 'notifikasi',
                    },
                    {
                        title: 'Tanggal',
                        width: '25%',
                        data: 'tanggal',
                        name: 'tanggal',
                    },
                    // {
                    //     title: 'Dibaca',
                    //     width: '7%',
                    //     data: 'aksi',
                    //     name: 'aksi',
                    // },
                ],
            });
        });
    </script>
    <script>
        $('#konfirformtandai').on('click', function(){
            Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Saya yakin!',
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: $('#marked').serialize(),
                        url: "{{url('notifikasi/readAt')}}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            $('#tb_belum_dibaca').DataTable().ajax.reload(null, false);
                        },
                        error: function(data) {
                            // console.log('Error:', data);
                        }
                    })   
                }
            });     
        });
    </script>
@endsection
