@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Rekap Data Issues</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">Rekap Data</li>
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
                                    <div class="col-md-12" id="data-filter">
                                        <form action="#" class="form-validate is-alter" name="formTanggalIssue"
                                            id="formTanggalIssue">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <div class=" row mt-2 mt-xl-0">
                                                        <div class="form-group col-md-3">
                                                            <label class="form-label" for="tanggalawal">Tanggal
                                                                Awal</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="tanggalawal"
                                                                    name="tanggalawal" value="{{ date('Y-m-d') }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label class="form-label" for="tanggalakhir">Tanggal
                                                                Akhir</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control"
                                                                    id="tanggalakhir" name="tanggalakhir"
                                                                    value="{{ date('Y-m-d') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="form-label">Status</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-control" name="status_issue"
                                                                    id="status_issue" required>
                                                                    <option value="semua">Semua</option>
                                                                    <option value="openprogress">Open/Progress</option>
                                                                    <option value="onhold">On Hold</option>
                                                                    <option value="doneclosed">Done/Closed</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-1">
                                                    <div class="mt-2 row mt-xl-0">
                                                        <div class="form-group col-md-6">
                                                            <label class="form-label" for="unitkerja">Unit Kerja</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-control" name="unitkerja"
                                                                    id="unitkerja" required>
                                                                    <option value="semua">Semua</option>
                                                                    @foreach ($units as $unit)
                                                                    <option value="{{ $unit->unitid }}">
                                                                        {{ $unit->nama }} - ({{ $unit->unitid }})
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="form-label">Layanan</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-control" name="layanan" id="layanan"
                                                                    required>
                                                                    <option value="semua">Semua</option>
                                                                    @foreach ($m_layanan as $data)
                                                                    <option value="{{ $data->id }}">
                                                                        {{ $data->nama_layanan }}({{ $data->kategori }})
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mt-2 mt-xl-0">
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light my-2"
                                                        style="width:100%" data-bs-toggle="modal" data-bs-target="#pdf"
                                                        onclick="changeURL()">Ekspor PDF</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mt-2 mt-xl-0">
                                                    <button style="width:100%" id="preview"
                                                        class="btn btn-md btn-primary my-2"> Preview</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mt-2 mt-xl-0">
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light my-2"
                                                        style="width:100%" data-bs-toggle="modal"
                                                        data-bs-target="#excel" onclick="changeURL()">Ekspor
                                                        Excel</button>
                                                </div>
                                            </div>
                                            <a href="#" style="display: none;" id="temppdf"></a>
                                            <a href="#" style="display: none;" id="tempexcel"></a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 preview" style="overflow-x: auto;">
                                        <table id="tb_preview" class="table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No. </th>
                                                    <th>ID Tiket Nama Layanan</th>
                                                    <th>Nama Subjek</th>
                                                    <th>User Entry</th>
                                                    {{-- <th width="6%">Nama Peminta</th> --}}
                                                    <th>Requester</th>
                                                    <th>Tanggal Lapor - Tanggal Batas</th>
                                                    <th>Prioritas</th>
                                                    <th>SLA (Hari Kerja)</th>
                                                    <th>Realisasi SLA</th>
                                                    <th>Status Issue</th>
                                                    <th>Ekskalasi PI</th>
                                                    <th>Catatan Issue Helpdesk</th>
                                                    <th>Deskripsi/Permintaan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
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
<div class="modal fade" id="pdf">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ekspor ke PDF</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="formToPDF" id="formToPDF">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama Tim Helpdesk</label>
                        <div class="form-control-wrap">
                            <select onchange="showUnduhButton()" class="form-control tim" name="timpdf" id="timpdf">
                                <option value=""></option>
                                @foreach ($helpdesk as $pegawai)
                                <option value="{{ $pegawai->pegawai }}">
                                    {{ $pegawai->pegawai }}
                                </option>
                                @endforeach
                                <option value="Yus Rizal"> Yus Rizal
                                </option>
                                <option value="Devianti Maya"> Devianti Maya
                                </option>
                            </select>
                        </div><label class="form-label" for="full-name">Nama Koordinator Tim Helpdesk</label>
                        <div class="form-control-wrap">
                            <select onchange="showUnduhButton()" class="form-control koortim" name="koortimpdf"
                                id="koortimpdf">
                                <option value=""></option>
                                @foreach ($helpdesk as $pegawai)
                                <option value="{{ $pegawai->pegawai }}">
                                    {{ $pegawai->pegawai }}
                                </option>
                                @endforeach
                                <option value="Yus Rizal"> Yus Rizal
                                </option>
                                <option value="Devianti Maya"> Devianti Maya
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <!-- <span class="sub-text">Modal Footer Text</span> -->
                <a href="contoh_export_pdf" style="display: none; width:100%" target="_blank"
                    class="btn unduh btn-md btn-primary my-2" id="cpdf">
                    Unduh</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="excel">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ekspor ke Excel</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" name="formToExcel" id="formToExcel">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label" for="full-name">Nama Tim Helpdesk</label>
                        <div class="form-control-wrap">
                            <select onchange="showUnduhButton()" class="form-control tim" name="timxlsx" id="timxlsx">
                                <option value=""></option>
                                @foreach ($helpdesk as $pegawai)
                                <option value="{{ $pegawai->pegawai }}">
                                    {{ $pegawai->pegawai }}
                                </option>
                                @endforeach
                                <option value="Yus Rizal"> Yus Rizal
                                </option>
                                <option value="Devianti Maya"> Devianti Maya
                                </option>
                            </select>
                        </div><label class="form-label" for="full-name">Nama Koordinator Tim Helpdesk</label>
                        <div class="form-control-wrap">
                            <select onchange="showUnduhButton()" class="form-control koortim" name="koortimxlsx"
                                id="koortimxlsx">
                                <option value=""></option>
                                @foreach ($helpdesk as $pegawai)
                                <option value="{{ $pegawai->pegawai }}">
                                    {{ $pegawai->pegawai }}
                                </option>
                                @endforeach
                                <option value="Yus Rizal"> Yus Rizal
                                </option>
                                <option value="Devianti Maya"> Devianti Maya
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <a href="contoh_export_excel" style="display: none; width:100%" target="_blank" id="cexcel"
                    class="btn unduh btn-md btn-primary my-2">Unduh</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $("#layanan").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#data-filter'),
            placeholder: "Pilih Layanan",
            width: "100%"
        });
        $("#unitkerja").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#data-filter'),
            placeholder: "Pilih Unit Kerja",
            width: "100%"
        });
        $("#status_issue").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#data-filter'),
            placeholder: "Pilih Status",
            width: "100%"
        });
        $("#timpdf").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#pdf'),
            placeholder: "Pilih Nama Tim Helpdesk",
            width: "100%"
        });
        $("#koortimpdf").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#pdf'),
            placeholder: "Pilih Nama Koordinator Tim Helpdesk",
            width: "100%"
        });
        $("#timxlsx").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#excel'),
            placeholder: "Pilih Nama Tim Helpdesk",
            width: "100%"
        });
        $("#koortimxlsx").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#excel'),
            placeholder: "Pilih Nama Koordinator Tim Helpdesk",
            width: "100%"
        });
        $("#tanggalakhir").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            language: 'id-ID',
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
    //ganti value url saat value form berubah
    function changeURL() {
        //stage
        var awal = document.getElementById('tanggalawal').value;
        var akhir = document.getElementById('tanggalakhir').value;
        var status = document.getElementById('status_issue').value;
        var layanan = document.getElementById('layanan').value;
        var unitkerja = document.getElementById('unitkerja').value;
        var data = "tanggalawal=" + awal + "&tanggalakhir=" + akhir + "&status_issue=" + status + "&layanan=" +
            layanan + "&unitkerja=" + unitkerja;
        var xlsx = document.getElementById('tempexcel');
        var pdf = document.getElementById('temppdf');
        xlsx.href = "export_excel?" + data;
        pdf.href = "export_pdf?" + data;
        //full
        var timpdf = document.getElementById('timpdf').value;
        var koortimpdf = document.getElementById('koortimpdf').value;
        var timxlsx = document.getElementById('timxlsx').value;
        var koortimxlsx = document.getElementById('koortimxlsx').value;
        var datapdf = "&tim=" + timpdf + "&koor=" + koortimpdf;
        var dataxlsx = "&tim=" + timxlsx + "&koor=" + koortimxlsx;
        var txlsx = document.getElementById('tempexcel');
        var tpdf = document.getElementById('temppdf');
        var xlsx = document.getElementById('cexcel');
        var pdf = document.getElementById('cpdf');
        xlsx.href = txlsx.href + dataxlsx;
        pdf.href = tpdf.href + datapdf;
    }

</script>
<script>
    //ganti value url saat value form di modal berubah
    function showUnduhButton() {
        var timpdf = document.getElementById('timpdf').value;
        var koortimpdf = document.getElementById('koortimpdf').value;
        var timxlsx = document.getElementById('timxlsx').value;
        var koortimxlsx = document.getElementById('koortimxlsx').value;
        if (timpdf != "" && koortimpdf != "") {
            changeURL();
            document.getElementById("cpdf").style.display = "";
        }
        if (timxlsx != "" && koortimxlsx != "") {
            changeURL();
            document.getElementById("cexcel").style.display = "";
        }
    }

</script>
<script>
    $(document).on('click', '.unduh', function modalhide() {
        $("#excel").modal('hide');
        $("#pdf").modal('hide');
    });

</script>
<script>
    $(document).on('click', '#preview', function () {
        var tb_preview = $('#tb_preview').DataTable({
            // responsive: true,
            destroy: true,
            processing: true,
            // ordering: false,
            autoWidth: false,
            serverSide: true,
            initComplete: function (settings, json) {
                $("#tb_preview").wrap(
                    "<div id='ax7' style='overflow-x:auto; width:100%; position:relative;'></div>");
                $('#tb_preview_wrapper').append('<div class="wrapper1" id="wrapper1" style="overflow-x: scroll;"><div class="div1" style="height: 1px;"></div></div>');
                const node = document.getElementById("wrapper1");
                const list = document.getElementById("tb_preview_wrapper");
                list.insertBefore(node, list.children[2]);
                $('.div1').css('width', $('#tb_preview').width());
                $(function(){
                    $("#wrapper1").scroll(function(){
                        $("#ax7")
                            .scrollLeft($("#wrapper1").scrollLeft());
                    });
                    $("#ax7").scroll(function(){
                        $("#wrapper1")
                            .scrollLeft($("#ax7").scrollLeft());
                    });
                });
            },
            // searching: true,
            // scrollX: true,
            // scrollCollapse: true,
            // fixedColumns: {
            //     heightMatch: 'none'
            // },
            sDom: 'lrtip', // untuk hidden search box di datatable
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('rekap_data_issues/getDataIssues') }}",
                data: {
                    "tanggalawal": document.getElementById('tanggalawal').value,
                    "tanggalakhir": document.getElementById('tanggalakhir').value,
                    "status_issue": document.getElementById('status_issue').value,
                    "layanan": document.getElementById('layanan').value,
                    "unitkerja": document.getElementById('unitkerja').value
                },
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                },
                {
                    data: 'tiket_nama_layanan',
                    name: 'tiket_nama_layanan',
                },
                {
                    data: 'nama_subjek',
                    name: 'nama_subjek',
                },
                {
                    data: 'user_entry',
                    name: 'user_entry',
                },
                // {
                //     data: 'nama_peminta',
                //     name: 'nama_peminta',
                //     
                // },
                {
                    data: 'requester',
                    name: 'requester',
                },
                {
                    data: 'tanggal_lapor',
                    name: 'tanggal_lapor',
                },
                {
                    data: 'prioritas',
                    name: 'prioritas',
                },
                {
                    data: 'sla',
                    name: 'sla',
                },
                {
                    data: 'realisasi_sla',
                    name: 'realisasi_sla',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'ekskalasi_pi',
                    name: 'ekskalasi_pi',
                },
                {
                    data: 'note',
                    name: 'note',
                },
                {
                    data: 'deskripsi_permintaan',
                    name: 'deskripsi_permintaan',
                    className: 'deskripsi-rekap',
                },
            ]
        })
    });

</script>
@endsection
