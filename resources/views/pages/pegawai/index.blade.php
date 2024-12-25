@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Pegawai</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">Pegawai</li>
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
                                                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalformTambahRole">Tambah Role</button> -->
                                                                <!-- <button type="button" name="perbarui_pegawai" id="perbarui_pegawai" class="btn btn-info btn-xs">Perbarui Pegawai</button> -->
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table" id="tb_pegawai" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>NIK</th>
                                                                <th>Nama</th>
                                                                <th>Email</th>
                                                                <th>Foto</th>
                                                                <th>Grade</th>
                                                                <th>Gradename</th>
                                                                <th>UnitID</th>
                                                                <th>UnitName</th>
                                                                <th>SuperiorNIK</th>
                                                                <th>SuperiorName</th>
                                                                <th>Role</th>
                                                                <th>Created_at</th>
                                                            </tr>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>NIK</th>
                                                                <th>Nama</th>
                                                                <th>Email</th>
                                                                <th>Foto</th>
                                                                <th>Grade</th>
                                                                <th>Gradename</th>
                                                                <th>UnitID</th>
                                                                <th>UnitName</th>
                                                                <th>SuperiorNIK</th>
                                                                <th>SuperiorName</th>
                                                                <th>Role</th>
                                                                <th>Created_at</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <!-- <tfoot>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>nik</th>
                                                                <th>nama</th>
                                                                <th>email</th>
                                                                <th>foto</th>
                                                                <th>grade</th>
                                                                <th>gradename</th>
                                                                <th>unitid</th>
                                                                <th>unitname</th>
                                                                <th>superiornik</th>
                                                                <th>superiorname</th>
                                                                <th>role</th>
                                                                <th>created_at</th>
                                                            </tr>
                                                        </tfoot> -->
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


@endsection

@section('script')


<script type="text/javascript">
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {
        // NioApp.DataTable.init = function() {
        // NioApp.DataTable('#tb_user', {
        // var new_row = $("<tr class='search-header'/>");
        // $('#tb_pegawai thead th').each(function(i) {
        //     var title = $(this).text();
        //     var new_th = $('<th style="' + $(this).attr('style') + '" />');
        //     $(new_th).append('<input type="text" placeholder="' + title + '" data-index="' + i + '"/>');
        //     $(new_row).append(new_th);
        // });
        // $('#tb_pegawai thead').prepend(new_row);

        // $('#tb_pegawai thead tr').clone(true).appendTo('#tb_pegawai thead');
        var no_kolom = 0;
        var searchTimeout;
        var kolom_search_gabung = '';
        var kolom_title = '';
        var value_kolom = '';
        var person = {
            NIK:"", 
            Nama:"", 
            Email:"", 
            Grade:"", 
            Gradename:"", 
            UnitID:"", 
            UnitName:"", 
            SuperiorNIK:"", 
            SuperiorName:""
        };
        $('#tb_pegawai thead tr:eq(1) th').each(function(i) {

            
            // // console.log(no_kolom);

            if (no_kolom == 0 || no_kolom == 4 || no_kolom == 11 || no_kolom == 12) {
                $(this).html('');
            } else {
                var title = $(this).text();
                $(this).html('<input type="text" style="width:100%" placeholder="Cari.." />');
            }

            $('input', this).on('keyup change', function() {
                person[title] = this.value;
                kolom_search_gabung = '&NIK=' + person.NIK+'&Nama=' + person.Nama+'&Email=' + person.Email+'&Grade=' + person.Grade+'&Gradename=' + person.Gradename+'&UnitID=' + person.UnitID+'&UnitName=' + person.UnitName+'&SuperiorNIK=' + person.SuperiorNIK+'&SuperiorName=' + person.SuperiorName;
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    $('#tb_pegawai').DataTable().ajax.url("{{ url('pegawai/getDataPegawai') }}" + '?a=a' + kolom_search_gabung).load();
                }, 700);
                
            });

            // kolom_gabung = '';

            // // console.log('coba = ' + kolom_gabung);
            no_kolom++;

        });

        // $('#tb_pegawai thead tr').clone(true).appendTo('#tb_pegawai thead');
        // $('#tb_pegawai thead tr:eq(1) th').each(function(i) {
        //     var title = $(this).text();
        //     $(this).html('<input type="text" placeholder="Search ' + title + '" />');

        //     $('input', this).on('keyup change', function() {
        //         if (table.column(i).search() !== this.value) {
        //             table
        //                 .column(i)
        //                 .search(this.value)
        //                 .draw();
        //         }
        //     });
        // });


        var tb_user = $('#tb_pegawai').DataTable({
            // responsive: {
            //     details: true
            // },
            scrollCollapse: true,
            scrollY: true,
            scrollX: true,
            processing: true,
            serverSide: true,
            searching: true,
            // responsive: {
            //     details: true
            // },
            // responsive: true,
            sDom: 'lrtip', // untuk hidden search box di datatable
            // language: {
            // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
            // },
            // fixedHeader: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#page-topbar').height()
            },
            // fixedColumns: true,
            orderCellsTop: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('pegawai/getDataPegawai') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'nik',
                    name: 'nik',
                    className: 'text-center'
                },
                {
                    data: 'nama',
                    name: 'nama',
                    className: 'text-center'
                },
                {
                    data: 'email',
                    name: 'email',
                    className: 'text-center'
                },
                {
                    data: 'foto',
                    name: 'foto',
                    className: 'text-center'
                },
                {
                    data: 'grade',
                    name: 'grade',
                    className: 'text-center'
                },
                {
                    data: 'gradename',
                    name: 'gradename',
                    className: 'text-center'
                },
                {
                    data: 'unitid',
                    name: 'unitid',
                    className: 'text-center'
                },
                {
                    data: 'unitname',
                    name: 'unitname',
                    className: 'text-center'
                },
                {
                    data: 'superiornik',
                    name: 'superiornik',
                    className: 'text-center'
                },
                {
                    data: 'superiorname',
                    name: 'superiorname',
                    className: 'text-center'
                },
                {
                    data: 'role',
                    name: 'role',
                    className: 'text-center'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    className: 'text-center'
                },

            ],
            // initComplete: function() {
            //     var api = this.api();

            //     // For each column
            //     api
            //         .columns()
            //         .eq(0)
            //         .each(function(colIdx) {
            //             // Set the header cell to contain the input element
            //             var cell = $('.filters th').eq(
            //                 $(api.column(colIdx).header()).index()
            //             );
            //             var title = $(cell).text();
            //             $(cell).html('<input type="text" placeholder="' + title + '" />');

            //             // On every keypress in this input
            //             $(
            //                     'input',
            //                     $('.filters th').eq($(api.column(colIdx).header()).index())
            //                 )
            //                 .off('keyup change')
            //                 .on('change', function(e) {
            //                     // Get the search value
            //                     $(this).attr('title', $(this).val());
            //                     var regexr = '({search})'; //$(this).parents('th').find('select').val();

            //                     var cursorPosition = this.selectionStart;
            //                     // Search the column for that value
            //                     api
            //                         .column(colIdx)
            //                         .search(
            //                             this.value != '' ?
            //                             regexr.replace('{search}', '(((' + this.value + ')))') :
            //                             '',
            //                             this.value != '',
            //                             this.value == ''
            //                         )
            //                         .draw();
            //                 })
            //                 .on('keyup', function(e) {
            //                     e.stopPropagation();

            //                     $(this).trigger('change');
            //                     $(this)
            //                         .focus()[0]
            //                         .setSelectionRange(cursorPosition, cursorPosition);
            //                 });
            //         });
            // },
        })



        // $(tb_user.table().container()).on('keyup', 'thead input', function() {
        //     tb_user
        //         .column($(this).data('index'))
        //         .search(this.value)
        //         .draw();
        // });
        // };
    });
</script>

<script>
    $(document).on('click', '#perbarui_pegawai', function() {
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
                            $('#tb_pegawai').DataTable().ajax.reload(null, false);
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