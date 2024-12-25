@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Mapping Menu</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">Mapping Menu</li>
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
                                                                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalformTambahDesa">Tambah Desa</button> -->
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <table class="table" id="tb_mapping_menu" style="width: 100%">
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

<div class="modal fade" id="modalFormEditMapppingRole">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mapping Menu
                </h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" name="FormEditMapppingRole" id="FormEditMapppingRole">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" id="m_role_id" name="m_role_id">
                    @foreach($m_menu as $datas1)


                    <!-- <div class="row">
                        <div class="col-md-5">
                            <div>
                                <h5 class="font-size-14 mb-1"><i class="mdi mdi-arrow-right text-primary me-1"></i>
                                    Form Checkboxes
                                </h5>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="formCheck1">
                                    <label class="form-check-label" for="formCheck1">
                                        Form Checkbox
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">

                        <span class="preview-title overline-title">{{$datas1->nama_menu}}</span>

                        @foreach($m_sub_menu as $datas2)
                        @php
                        if($datas2->m_menu_id == $datas1->id){
                        @endphp

                        <div class="custom-control custom-checkbox" style="margin: 5px">
                            <input type="checkbox" class="custom-control-input {{$datas2->id}}" id="{{$datas2->id}}" value="{{$datas2->id}}" name="sub_menu_id[]">
                            <label class="custom-control-label" for="{{$datas2->id}}">{{$datas2->nama_sub_menu}}</label>
                        </div>

                        <!-- <input type="checkbox" checked class="custom-control-input {{$datas2->id}}" id="coba" value="coba" name="coba"> -->

                        @php
                        }
                        @endphp
                        @endforeach

                    </div>
                    @endforeach

                    <!-- <input type="checkbox" checked class="custom-control-input" id="coba" value="coba" name="coba"> -->
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

        var tb_mapping_menu = $('#tb_mapping_menu').DataTable({
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
                url: "{{ url('mapping_menu/getDataRoleMappingMenu') }}",
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
                    className: 'text-start'
                },

            ]
        })
        // };
    });
</script>

<script>
    $(document).ready(function() {
        // $("#edit").click(function() {
        $(document).on('click', '#edit', function() {

            var role_id = $(this).attr("data-role_id");




            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#FormEditMapppingRole').serialize(),
                url: "{{url('mapping_menu/getDataMappingMenu')}}" + '/' + role_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    // // console.log(data);
                    // // console.log(data.datax);
                    // // console.log(data.datax.m_mapping_menu);
                    // // console.log(data.datax.m_mapping_menu.length);
                    // $('.6').prop('checked', true);
                    if (data.datax.m_mapping_menu.length == 0) {
                        // console.log('kosong');
                        // $('input:checkbox').removeAttr('checked');
                        // $('#FormEditMapppingRole')[0].reset();

                        // // console.log(role_id);
                        // // console.log('coba');
                        for (i = 0; i < data.datax.m_sub_menu.length; i++) {
                            $('.' + data.datax.m_sub_menu[i].id).removeAttr('checked');
                        }

                        $("#m_role_id").val(role_id);
                    } else {
                        // console.log('isi');
                        // $('input:checkbox').attr('checked','checked');
                        // $('input:checkbox').removeAttr('checked');
                        // $('#FormEditMapppingRole')[0].reset();

                        var i;

                        // for (i = 0; i < data.datax.m_sub_menu.length; i++) {
                        //     // data.datax.m_sub_menu[i].id
                        //     for (j = 0; j < data.datax.m_mapping_menu.length; j++) {
                        //         if (data.datax.m_sub_menu[i].id == data.datax.m_mapping_menu[j].m_sub_menu_id) {
                        //             // console.log(data.datax.m_sub_menu[i].id);
                        //             // $('.myCheckbox').prop('checked', true);
                        //             // $('.'+data.datax.m_mapping_menu[i].m_sub_menu_id).prop('checked', true);
                        //             $('.' + data.datax.m_sub_menu[i].id).attr('checked', 'checked');
                        //         } else {
                        //             $('.' + data.datax.m_sub_menu[i].id).removeAttr('checked');
                        //         }

                        //     }
                        // }
                        for (i = 0; i < data.datax.m_sub_menu.length; i++) {
                            $('.' + data.datax.m_sub_menu[i].id).removeAttr('checked');
                        }


                        for (j = 0; j < data.datax.m_mapping_menu.length; j++) {
                            // console.log(data.datax.m_mapping_menu[j].m_sub_menu_id);
                            // $('.myCheckbox').prop('checked', true);
                            $('.' + data.datax.m_mapping_menu[j].m_sub_menu_id).prop('checked', true);
                            // $('.' + data.datax.m_mapping_menu[j].m_sub_menu_id).attr('checked', 'checked');
                        }

                        // // console.log(role_id);
                        // // console.log('coba');
                        $("#m_role_id").val(role_id);
                    }

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
    $(document).on('click', '#update', function() {
        // console.log('update');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#FormEditMapppingRole').serialize(),
            url: "{{url('mapping_menu/update')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);
                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    // $("#modalFormEditMapppingRole").modal('hide');
                    // $('#tb_mapping_menu').DataTable().ajax.reload();
                    location.reload();
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


@endsection