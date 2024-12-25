@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">

                    <section id="faq-tabs">
                        <!-- vertical tab pill -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="faq-navigation d-flex justify-content-between flex-column mb-2 mb-md-0">
                                    <!-- pill tabs navigation -->
                                    <ul class="nav nav-pills nav-left flex-column tablist_faq" role="tablist">

                                    </ul>

                                    <img src="{{asset('public/image/faq-illustrations.svg')}}" class="img-fluid d-none d-md-block" alt="demand img" />
                                </div>
                            </div>

                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <!-- pill tabs tab content -->
                                <div class="tab-content tab_content_faq_detail">
                                    <!-- menu panel -->

                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- <section class="faq-contact">
                        <div class="row pt-75" style="margin-top: -50px">
                            <div class="col-sm-6">
                                <div class="card text-center faq-contact-card shadow-none py-1">
                                    <div class="accordion-body">
                                        {{-- <div class="avatar avatar-tag bg-light-primary mb-2 mx-auto">
                                            <i data-feather="phone-call" class="font-medium-3"></i>
                                        </div> --}}
                                        <h4><a class="text-decoration-none text-dark" href="https://wa.me/62817776022" target="_blank"><i class='bx bxl-whatsapp'></i> + (62) 817 776022</a></h4>
                                        <span class="text-body">We are always happy to help!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card text-center faq-contact-card shadow-none py-1">
                                    <div class="accordion-body">
                                        {{-- <div class="avatar avatar-tag bg-light-primary mb-2 mx-auto">
                                            <i data-feather="mail" class="font-medium-3"></i>
                                        </div> --}}
                                        <h4><i class='bx bx-phone-call'></i> Ext 8888/2136</h4>
                                        <span class="text-body">Best way to get answer faster!</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section> -->
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

        var tb_user = $('#tb_faq').DataTable({
            responsive: {
                details: true
            },
            processing: true,
            serverSide: true,
            searching: true,
            responsive: {
                details: true
            },
            paging: false,
            info: false,
            sDom: 'lrtip', // untuk hidden search box di datatable
            // language: {
            // 	processing: "Sedang diproses...<img src='{{ asset('public/assets/images/load.gif') }}'>"
            // },
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('faq/getDataFaqDatatable') }}",
                type: 'GET',
            },
            columns: [{
                data: 'nama_faq',
                name: 'nama_faq',
                className: 'text-center'
            }, ]
        })
        // };
    });
</script>

<script>
    $(document).ready(function() {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // data: $('#formTambahIssues').serialize(),
            url: "{{url('faq/getDataFaq')}}",
            type: "GET",
            dataType: 'json',
            success: function(data) {

                console.log(data.data.length);
                var nama_faq = '';

                for (var i = 0; i < data.data.length; i++) {
                    if (i == 0) {
                        nama_faq += '<li class="nav-item">' +
                            '<a class="nav-link navi active" id="delivery" data-bs-toggle="pill" href="#id_' + data.data[i].id + '" aria-expanded="false" role="tab">' +
                            '<i class="mdi mdi-menu"></i>' +
                            '<span class="fw-bold">' + ' ' + data.data[i].nama_faq + '</span>' +
                            '</a>' +
                            '</li>'
                    } else {
                        nama_faq += '<li class="nav-item">' +
                            '<a class="nav-link navi" id="delivery" data-bs-toggle="pill" href="#id_' + data.data[i].id + '" aria-expanded="false" role="tab">' +
                            '<i class="mdi mdi-menu"></i>' +
                            '<span class="fw-bold">' + ' ' + data.data[i].nama_faq + '</span>' +
                            '</a>' +
                            '</li>'
                    }


                }

                $(".tablist_faq").html(
                    nama_faq
                );

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

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // data: $('#formTambahIssues').serialize(),
            url: "{{url('faq/getDataFaqDetail')}}",
            type: "GET",
            dataType: 'json',
            success: function(data) {

                // console.log(data.data.length);
                var nama_faq_detail = '';
                for (var j = 0; j < data.data_m_faq.length; j++) {
                    if (j == 0) {
                        nama_faq_detail +=
                            '<div role="tabpanel" class="tab-pane active" id="id_' + data.data_m_faq[j].id + '" aria-labelledby="menu" aria-expanded="true">' +
                            '<div class="d-flex align-items-center" style="margin-top: -7px; margin-left: -5px">' +
                            // '<i class="mdi mdi-help-box mdi-48px"></i>' +
                            // '<div style="margin-left: -40px; margin-top: -30px">' +
                            // '<h4 style="margin-bottom: -1px;">About Helpdesk</h4>' +
                            // '<span>Helpdesk</span>' +
                            // '</div>' +
                            '</div>';
                    } else {
                        nama_faq_detail +=
                            '<div role="tabpanel" class="tab-pane" id="id_' + data.data_m_faq[j].id + '" aria-labelledby="menu" aria-expanded="true">' +
                            '<div class="d-flex align-items-center" style="margin-top: -7px; margin-left: -5px">' +
                            // '<i class="mdi mdi-help-box mdi-48px"></i>' +
                            // '<div style="margin-left: -40px; margin-top: -30px">' +
                            // '<h4 style="margin-bottom: -1px;">About Helpdesk</h4>' +
                            // '<span>Helpdesk</span>' +
                            // '</div>' +
                            '</div>';
                    }

                    for (var i = 0; i < data.data_m_faq_detail.length; i++) {

                        if (data.data_m_faq_detail[i].m_faq_id == data.data_m_faq[j].id) {

                            if (i == 0) {
                                nama_faq_detail +=

                                    '<div class="accordion accordion-margin mt-2" id="id_' + data.data_m_faq_detail[i].id + '-qna">' +
                                    '<div class="card accordion-item">' +
                                    '<h2 class="accordion-header" id="about_' + data.data_m_faq_detail[i].id + '">' +
                                    '<button class="accordion-button" data-bs-toggle="collapse" role="button" data-bs-target="#id_' + data.data_m_faq_detail[i].id + '-two" aria-expanded="true" aria-controls="about-helpdesk-two">' +
                                    data.data_m_faq_detail[i].nama_faq_detail +
                                    '</button>' +
                                    '</h2>' +
                                    '<div id="id_' + data.data_m_faq_detail[i].id + '-two" class="collapse" aria-labelledby="about_' + data.data_m_faq_detail[i].id + '" data-bs-parent="#id_' + data.data_m_faq_detail[i].id + '-qna">' +
                                    '<div class="accordion-body">' +
                                    '<div name="quill_detail" id="quill_detail" class="quill_detail" style="height: 372px; max-height: 372px;">' +
                                    data.data_m_faq_detail[i].deskripsi_faq_detail +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>'
                            } else {
                                nama_faq_detail +=
                                    '<div class="accordion accordion-margin mt-2" id="id_' + data.data_m_faq_detail[i].id + '-qna">' +
                                    '<div class="card accordion-item">' +
                                    '<h2 class="accordion-header" id="about_' + data.data_m_faq_detail[i].id + '">' +
                                    '<button class="accordion-button" data-bs-toggle="collapse" role="button" data-bs-target="#id_' + data.data_m_faq_detail[i].id + '-two" aria-expanded="true" aria-controls="about-helpdesk-two">' +
                                    data.data_m_faq_detail[i].nama_faq_detail +
                                    '</button>' +
                                    '</h2>' +
                                    '<div id="id_' + data.data_m_faq_detail[i].id + '-two" class="collapse" aria-labelledby="about_' + data.data_m_faq_detail[i].id + '" data-bs-parent="#id_' + data.data_m_faq_detail[i].id + '-qna">' +
                                    '<div class="accordion-body">' +
                                    '<div name="quill_detail" id="quill_detail" class="quill_detail" style="height: 372px; max-height: 372px;">' +
                                    data.data_m_faq_detail[i].deskripsi_faq_detail +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>'
                            }

                        } else {

                        }




                    }

                    nama_faq_detail += '</div>';

                }



                $(".tab_content_faq_detail").html(
                    nama_faq_detail
                );

                var quill_description_issues_detail = new Quill(".quill_detail", {
                    theme: "snow",
                    modules: {
                        "toolbar": false
                    },
                    disabled: true,
                });

                $('.quill_detail').on('keydown', function() {
                    // alert('key up');
                    return false;
                });

            },
            error: function(data) {
                // console.log('Error:', data);
                //$('#modalPenghargaan').modal('show');
            }
        });

    });
</script>

@endsection