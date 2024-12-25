<head>

    <meta charset="utf-8" />
    <title>Helpdesk | {{ $judul }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('public/image/favicon.ico') }}">

    <!-- choices css -->
    <link href="{{ asset('public/assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- color picker css -->
    <link rel="stylesheet" href="{{ asset('public/assets/libs/%40simonwep/pickr/themes/classic.min.css') }}" />
    <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ asset('public/assets/libs/%40simonwep/pickr/themes/monolith.min.css') }}" />
    <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ asset('public/assets/libs/%40simonwep/pickr/themes/nano.min.css') }}" />
    <!-- 'nano' theme -->

    <link href="{{ asset('public/assets/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />

    <!-- datepicker css -->
    <link rel="stylesheet" href="{{ asset('public/assets/libs/flatpickr/flatpickr.min.css') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('public/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('public/assets/css/timeline.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" id="app-style" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" id="app-style" rel="stylesheet" type="text/css" /> -->
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css">
    </script> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/webui-popover/1.2.18/jquery.webui-popover.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/webui-popover/1.2.18/jquery.webui-popover.min.css" rel="stylesheet" />

    <!-- <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" /> -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.4/main.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.4/main.min.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />
    <link href="https://datatables.net/release-datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js" rel="stylesheet" />
    <link href="https://cdn.datatables.net/fixedcolumns/4.1.0/css/fixedColumns.dataTables.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('public/assets/libs/flatpickr/flatpickr.min.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <style>
        a.notif:hover {
            color: #0000ff !important;
        }
    </style>
    <style>
        button.waves-effect.waves-light.addButton{
            background-color: #006744;
        }

        .dtfh-floatingparent{
            overflow-x: scroll !important;
            overflow-y: hidden !important;
            height: 165px !important;
        }
        #layout-wrapper {
            min-height: 100vh;
            background-color: #98fe981d;
            /* background: linear-gradient(top left, #c3ccd1 0%, #f8f9fa 100%);
            background: linear-gradient(to bottom right, #f8f9fa 0%, #c3ccd1 100%); */
        }

        .footer {
            /* background-color: #74788d; */
            background-color: #006744;
            color: white;
        }
        .dropdown-menu.navi, .nav-item.navi {
            /* background-color: #74788d; */
            background-color: #006744;
            color: white;
        }

        header span, i, p.dropdown-item, #btnLogout>i, .dropdown-menu>a{
            color: white !important;
        }

        .allnotif:hover {
            background-color: #00000016;
        }
        th {
            vertical-align: middle;
        }

        /* #page-topbar{
            background-color: var(--bs-body-bg);!important;
            color: black !important;
        } */
        @media only screen and (min-width: 1400px){
            #logo3 {
                height: 60% !important;
            }
            .logowrapper{
                max-width: 100px !important;
            }
            .logowrapper2{
                max-width: 120px !important;
            }

            .modal-dialog {
            overflow-y: initial !important
            }

            .modal-content {
                max-height: 85vh;
                overflow-y: auto;
            }

            .modal {
                overflow-y: hidden !important;
            }
        }
        @media only screen and (min-width: 1090px)and (max-width: 1400px) {
            #logo3 {
                height: 60% !important;
            }
            .logowrapper{
                max-width: 100px !important;
            }
            .logowrapper2{
                max-width: 120px !important;
            }

            .modal-dialog {
            overflow-y: initial !important
            }

            .modal-content {
                max-height: 85vh;
                overflow-y: auto;
            }

            .modal {
                overflow-y: hidden !important;
            }
        }
        @media only screen and (min-width: 990px)and (max-width: 1090px) {
            #logo3 {
                height: 40% !important;
            }
            .logowrapper{
                max-width: 80px !important;
            }
            .logowrapper2{
                max-width: 100px !important;
            }

            .modal-dialog {
            overflow-y: initial !important
            }

            .modal-content {
                max-height: 85vh;
                overflow-y: auto;
            }

            .modal {
                overflow-y: hidden !important;
            }
        }
        @media only screen and (min-width: 690px)and (max-width: 990px) {
            #logo3 {
                height: 50% !important;
            }
            .logowrapper{
                max-width: 100px !important;
            }
            .logowrapper2{
                max-width: 120px !important;
            }
            
            .modal-dialog {
            overflow-y: initial !important
            }

            .modal-content {
                max-height: 85vh;
                overflow-y: auto;
            }

            .modal {
                overflow-y: hidden !important;
            }
        }

        @media only screen and (min-width: 600px){
            .dropdown-menu.notif{
                min-width : 400px;
            }
        }

        @media only screen and (max-width: 690px) {
            #logo3 {
                height: 50% !important;
            }
            .logowrapper{
                max-width: 100px !important;
            }
            .logowrapper2{
                max-width: 120px !important;
            }

            .modal-dialog {
            overflow-y: initial !important
            }

            .modal-content {
                max-height: 85vh;
                overflow-y: auto;
            }

            .modal {
                overflow-y: hidden !important;
            }
        }

        @media only screen and (max-width: 570px) {
            #logo3 {
                height: 50% !important;
                padding: 5px 20px 5px 20px !important;
            }
            .logowrapper{
                max-width: 80px !important;
            }
            .logowrapper2{
                max-width: 110px !important;
            }

            .modal-dialog {
            overflow-y: initial !important
            }

            .modal-content {
                max-height: 85vh;
                overflow-y: auto;
            }

            .modal {
                overflow-y: hidden !important;
            }
        }

        @media only screen and (max-width: 480px) {
            #logo3 {
                height: 50% !important;
                padding: 5px 10px 5px 10px !important;
            }
            .logowrapper{
                max-width: 80px !important;
            }
            .logowrapper2{
                max-width: 110px !important;
            }

            .modal-dialog {
            overflow-y: initial !important
            }

            .modal-content {
                max-height: 85vh;
                overflow-y: auto;
            }

            .modal {
                overflow-y: hidden !important;
            }

        }

        @media only screen and (max-width: 410px) {
            #logo3 {
                height: 40% !important;
                padding: 5px 20px 5px 20px !important;
            }
            .logowrapper{
                max-width: 60px !important;
            }
            .logowrapper2{
                max-width: 80px !important;
            }

            .modal-dialog {
            overflow-y: initial !important
            }

            .modal-content {
                max-height: 85vh;
                overflow-y: auto;
            }

            .modal {
                overflow-y: hidden !important;
            }
        }

        @media only screen and (max-width: 340px) {
            #logo3 {
                height: 30% !important;
                padding: 5px 20px 5px 20px !important;
            }
            .logowrapper{
                max-width: 40px !important;
            }
            .logowrapper2{
                max-width: 60px !important;
            }

            .modal-dialog {
            overflow-y: initial !important
            }

            .modal-content {
                max-height: 85vh;
                overflow-y: auto;
            }

            .modal {
                overflow-y: hidden !important;
            }
        }

        #logo3{
            background-color: white;
            border-radius: 20px;
            padding: 5px 40px 5px 40px;
        }
    </style>
    <style>
        /* .popover {
            z-index: 1060 !important;
            width: 100% !important;
            max-width: 20% !important;
            height: 40%;
        } */
    </style>

    <style>
        .popover {
            z-index: 1060 !important;
            width: 100% !important;
            max-width: 20% !important;
            height: 3%;
        }
    </style>

    <style>
        .swal2-container {
            z-index: 1000000 !important;
        }
    </style>

    <style>
        .select2-container--open {
            z-index: 9999999
        }
    </style>

    <style>
        .swal-wide-850 {
            width: 80% !important;
            /* height: 80% !important; */
            /* height: 50% !important; */
            /* overflow-y: hidden !important;
            overflow-x: hidden !important; */
            /* max-height: calc(100vh - 200px);
            overflow-y: auto; */
        }
    </style>

    <style>
        .swal-wide-50 {
            width: 50% !important;
            /* height: 80% !important; */
            /* height: 50% !important; */
            /* overflow-y: hidden !important;
            overflow-x: hidden !important; */
            /* max-height: calc(100vh - 200px);
            overflow-y: auto; */
        }
    </style>
    <style>
        .deskripsi-rekap img {
            height: 250px !important;
        }

        #tb_preview th {
            white-space: nowrap;
        }
    </style>

    <style>
        .dtfh-floatingparenthead {
            background-color: white;
            /* font-size: 18px; */
        }
    </style>

    <style>
        a.nav-link.active[data-bs-toggle="tab"] {
            border-bottom: 5px solid;
            border-color: #006744;
            color: #006744;
            background-color: white;
        }
        a.nav-link.active[data-bs-toggle="pill"]{
            /* border-bottom: 5px solid;
            border-color: #006744; */
            color: white;
            background-color: #006744;
        }

        tr.highlight {
            background-color: rgba(57, 128, 192, 0.15) !important;
        }
        .select2-selection__placeholder, .select2-results__option{
            font-size:15px !important;
        }
        .select2-selection__placeholder, .form-control.tanggal-search{
            color: #aeb5cb !important;
        }
        .badge{
            padding-top: 0px !important;
        }
    </style>

    <style>
        /* .modal-dialog {
            overflow-y: initial !important
        }

        .modal-content {
            max-height: 91vh;
            overflow-y: auto;
        }

        .modal {
            overflow-y: hidden !important;
        } */
    </style>

    <style>
        html.swal2-shown,
        body.swal2-shown {
            overflow-y: auto !important;
        }
    </style>

    <style>
        .modal-backdrop.show:nth-of-type(even) {
            z-index: 1051 !important;
        }
    </style>
    <style>
        .page-content{
            margin-top: 40px !important;
        }
    </style>

    <style>
    
        .popover .close{
            float: right;
        }
    
    </style>

    <style>

        /* .select2-selection--single{
            padding-top: 10px !important;
            height: 48px !important;
            width: 148px;
        } */

    </style>

</head>