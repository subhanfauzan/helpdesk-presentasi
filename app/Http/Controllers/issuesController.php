<?php

namespace App\Http\Controllers;

use DB;
use PDF;
// use Illuminate\Support\Facades\Session;
use URL;
use File;
use Session;
use Response;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use GuzzleHttp\Exception\BadResponseException;
use Guzzle\Http\Exception\ClientErrorResponseException;

class issuesController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            if(in_array(get_nama_current_path_root_group(), get_sub_menu())){
                return $next($request);
            }else{
                return response()->view('tidak_ditemukan.pages_404');
            }
        });
    }

    public function index()
    {
        // $id = request('id') != '' ? request('id') : '';
        $tiket = request('tiket') != '' ? request('tiket') : '';
        // dd(Session::get('user_app'));
        // dd(next_value_tiket("HLP-K10L041S001-00001"));
        $judul = "Issues";
        $user_app = Session::get('user_app');
        // dd($data);
        // dd($user_app['role']);

        $m_priority = DB::table('m_priority')
            ->select(DB::raw("m_priority.*"))
            ->orderBy('m_priority.id', 'DESC')
            ->get();

        $m_kategori = DB::table('m_kategori')
            ->select(DB::raw("m_kategori.*"))
            // ->whereNotIn('m_kategori.id', ["K08","K09"])
            ->where('m_kategori.status_aktif', true)
            ->get();

        $m_layanan = DB::table('m_layanan')
            ->select(DB::raw("m_layanan.*"))
            ->get();

        $data_pegawai = DB::table('pegawai')
            ->select(DB::raw("pegawai.*"))
            ->where('pegawai.unitid', '=', 'PBD200')
            ->get();

        $data_pegawai_semua = DB::table('pegawai')
            ->select(DB::raw("pegawai.*"))
            ->get();

        $array_pegawai = [];

        foreach ($data_pegawai as $data) {
            $array_pegawai[] = array(
                'pegawai_nik' => $data->nik,
                'pegawai_nama' => $data->nama,
            );
        }

        // $result = (array) $array_pegawai;

        // dd($result);

        // $data['array_pegawai'] = $array_pegawai;
        // dd($data);

        // dd($array_pegawai[0]['pegawai_nik']);
        // $myarray = array_collapse($array_pegawai); 

        return view('pages.issues.index', compact('user_app', 'm_priority', 'm_kategori', 'm_layanan'), ['array_pegawai' => $array_pegawai, 'array_pegawai_semua' => $data_pegawai_semua, 'judul' => $judul,  'tiket' => $tiket]);
    }

    
    public function getDataIssues(Request $request)
    {

        // dd('coba');
        // dd($request->all());

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];
        $searchs = $request["search.value"];
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'searchs' => $searchs,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_role = $get_session['role'];
        $get_session_nik = $get_session['nik'];
        $get_session_unitId = $get_session['unitId'];
        $get_session_username = $get_session['username'];

        // $get_m_pic_layanan_id = array();
        // foreach ($get_m_pic as $data) {
        //     $get_m_pic_layanan_id = array($data->layanan_id);
        // }

        // dd($get_m_pic_layanan_id);

        $Tiket_Issues_Search = is_null($request->tiket_issues_search) ? '' : $request->tiket_issues_search;
        $Nama_Pegawai_Search = is_null($request->nama_pegawai_search) ? '' : $request->nama_pegawai_search;
        $Created_By_Search = is_null($request->created_by_search) ? '' : $request->created_by_search;
        $layanan_search = is_null($request->layanan_search) ? '' : $request->layanan_search;
        $subject_search = is_null($request->subject_search) ? '' : $request->subject_search;
        $priority_search = is_null($request->priority_search) ? '' : $request->priority_search;
        $tanggal_pembuatan_search = is_null($request->tanggal_pembuatan_search) ? '' : $request->tanggal_pembuatan_search;
        $tanggal_batas_search = is_null($request->tanggal_batas_search) ? '' : $request->tanggal_batas_search;
        $status_search = is_null($request->status) ? '' : $request->status;
        $keterangan_search = is_null($request->keterangan_search) ? '' : $request->keterangan_search;
        $security_incident_search = is_null($request->security_incident_search) ? '' : $request->security_incident_search;
        $major_incident_search = is_null($request->major_incident_search) ? '' : $request->major_incident_search;

        $tiket_issues_duplikat_search = is_null($request->tiket_issues_duplikat) ? '' : $request->tiket_issues_duplikat;
        // dd($request->all());
        // dd($tiket_issues_duplikat_search);

        if (validateSessionToken($get_session_token)) {
            $tb_issues = DB::table('v_issues')
                ->select(DB::raw("v_issues.*,
                m_kategori.nama_kategori, m_kategori.id as m_kategori_id,
                m_layanan.nama_layanan, m_layanan.id as m_layanan_id,
                m_subject.nama_subject, m_subject.id as m_subject_id,
                m_priority.nama_priority,
                v_users_all.nama as nama_v_users_all"))
                ->leftjoin('m_kategori', 'm_kategori.id', 'v_issues.kategori_id')
                ->leftjoin('m_layanan', 'm_layanan.id', 'v_issues.layanan_id')
                ->leftjoin('m_subject', 'm_subject.id', 'v_issues.subject_id')
                ->leftjoin('m_priority', 'm_priority.id', 'v_issues.priority_id')
                ->leftjoin('v_users_all', 'v_users_all.username', 'v_issues.username_sap_issues')
                ->orderBy('v_issues.created_at', "DESC")
                // ->orWhere('v_issues.tiket_issues', 'ilike', '%' . $Tiket_Issues_Search . '%')
                // ->orWhere('pegawai.nama', 'ilike', '%' . $Nama_Pegawai_Search . '%')
                // ->orWhere('v_issues.created_by', 'ilike', '%' . $Created_By_Search . '%')
                // ->orWhere('m_layanan.nama_layanan', 'ilike', '%' . $layanan_search . '%')
                // ->orWhere('m_subject.nama_subject', 'ilike', '%' . $subject_search . '%')
                // ->orWhere('m_priority.nama_priority', 'ilike', '%' . $priority_search . '%')
                // ->orWhere('v_issues.tanggal_pembuatan_issues', 'ilike', '%' . $tanggal_pembuatan_search . '%')
                // ->orWhere('v_issues.tanggal_batas_issues', 'ilike', '%' . $tanggal_batas_search . '%');
                // ->orWhere('v_issues.tiket_issues', 'ilike', '%' . $status_search . '%')
                ->Where(function ($query) use (
                    $Tiket_Issues_Search,
                    $Nama_Pegawai_Search,
                    $Created_By_Search,
                    $layanan_search,
                    $subject_search,
                    $priority_search,
                    $tanggal_pembuatan_search,
                    $tanggal_batas_search,
                    $tiket_issues_duplikat_search,
                    $status_search,
                    $keterangan_search,
                    $security_incident_search,
                    $major_incident_search
                ) {
                    // $query
                    //     ->where('v_issues.tiket_issues', 'ilike', '%' . $Tiket_Issues_Search . '%')
                    //     ->where('v_issues.tiket_issues_duplikat', 'ilike', '%' . $tiket_issues_duplikat_search . '%')
                    //     ->where('v_users_all.nama', 'ilike', '%' . $Nama_Pegawai_Search . '%')
                    //     ->where('v_issues.created_by', 'ilike', '%' . $Created_By_Search . '%')
                    //     ->where('m_layanan.nama_layanan', 'ilike', '%' . $layanan_search . '%')
                    //     ->where('m_subject.nama_subject', 'ilike', '%' . $subject_search . '%')
                    //     ->where('m_priority.nama_priority', 'ilike', '%' . $priority_search . '%')
                    //     ->where('v_issues.tanggal_pembuatan_issues', 'ilike', '%' . $tanggal_pembuatan_search . '%')
                    //     ->where('v_issues.tanggal_batas_issues', 'ilike', '%' . $tanggal_batas_search . '%')
                    //     ->where('v_issues.status', 'ilike', '%' . $status_search . '%');
                    is_null($Tiket_Issues_Search) || $Tiket_Issues_Search == '' ?: $query->where('v_issues.tiket_issues', 'ilike', '%' . $Tiket_Issues_Search . '%');
                    is_null($Nama_Pegawai_Search) || $Nama_Pegawai_Search == '' ?: $query->where('v_users_all.nama', 'ilike', '%' . $Nama_Pegawai_Search . '%');
                    is_null($Created_By_Search) || $Created_By_Search == '' ?: $query->where('v_issues.created_by', 'ilike', '%' . $Created_By_Search . '%');
                    is_null($layanan_search) || $layanan_search == '' ?: $query->where('m_layanan.nama_layanan', 'ilike', '%' . $layanan_search . '%');
                    is_null($subject_search) || $subject_search == '' ?: $query->where('m_subject.nama_subject', 'ilike', '%' . $subject_search . '%');
                    is_null($priority_search) || $priority_search == '' ?: $query->where('m_priority.nama_priority', 'ilike', '%' . $priority_search . '%');
                    is_null($tanggal_pembuatan_search) || $tanggal_pembuatan_search == '' ?: $query->where('v_issues.tanggal_pembuatan_issues', 'ilike', '%' . $tanggal_pembuatan_search . '%');
                    is_null($tanggal_batas_search) || $tanggal_batas_search == '' ?: $query->where('v_issues.tanggal_batas_issues', 'ilike', '%' . $tanggal_batas_search . '%');
                    is_null($tiket_issues_duplikat_search) || $tiket_issues_duplikat_search == '' ?: $query->where('v_issues.tiket_issues_duplikat', 'ilike', '%' . $tiket_issues_duplikat_search . '%');
                    is_null($status_search) || $status_search == '' ?: $query->where('v_issues.status', 'ilike', '%' . $status_search . '%');
                    is_null($keterangan_search) || $keterangan_search == '' ?: $query->where('v_issues.tiket_cares_pi', 'ilike', '%' . $keterangan_search . '%');
                    is_null($security_incident_search) || $security_incident_search == '' || $security_incident_search == 'false' ?: $query->where('v_issues.security_incident', 'ilike', '%' . $security_incident_search . '%');
                    is_null($major_incident_search) || $major_incident_search == '' || $major_incident_search == 'false' ?: $query->where('v_issues.major_incident', 'ilike', '%' . $major_incident_search . '%');
                })->Where(function ($query) use (
                    $get_session_role,
                    $get_session_nik
                ) {

                    if ($get_session_role == "R003") {
                        // dd('coba');
                        $query->where('v_issues.username_sap_issues', '=', $get_session_nik);
                    } else if ($get_session_role == "R005") {
                        $query->whereIn('v_issues.kategori_id', ['K03', 'K17']);
                    } else {
                    }
                });

            $tb_issues->Where('v_issues.layanan_id', '!=', NULL);

            // $get_m_pic_layanan_id = array();


            // $get_m_pic = DB::table('m_pic')
            //     ->select(DB::raw("m_pic.layanan_id"))
            //     ->where('m_pic.username', '=', $get_session_username)
            //     ->get();

            // if (count($get_m_pic) == 0) {
            // } else {
            //     foreach ($get_m_pic as $data) {
            //         $tb_issues->orWhere('v_issues.layanan_id', '=', $data->layanan_id);
            //     }
            // }

            // if ($get_session_role == "R003") {

            //     $total_data = $tb_issues
            //         ->where('v_users_all.username', '=', $get_session_nik)
            //         ->count();

            //     $m_issues = $tb_issues
            //         ->where('v_users_all.username', '=', $get_session_nik)
            //         ->limit($limit)
            //         ->offset($offset)
            //         ->get();

            //     // $total_data = $tb_issues->count();
            // } else if ($get_session_role == "R005") {

            //     $total_data = $tb_issues
            //         ->where('v_issues.kategori_id', '=', 'K03')
            //         ->count();

            //     $m_issues = $tb_issues
            //         ->where('v_issues.kategori_id', '=', 'K03')
            //         ->limit($limit)
            //         ->offset($offset)
            //         ->get();

            //     // $total_data = $tb_issues->count();
            // }else {

            //     $total_data = $tb_issues->count();

            //     $m_issues = $tb_issues
            //         ->limit($limit)
            //         ->offset($offset)
            //         ->get();

            //     // $total_data = $tb_issues->count();
            // }

            $total_data = $tb_issues->count();

            $m_issues = $tb_issues
                ->limit($limit)
                ->offset($offset)
                ->get();

            $button_forward_issues_display_none = "";

            if ($get_session_role == "R005" || $get_session_unitId != "PBD200") {
                $button_forward_issues_display_none = "style='display:none'";
            } else {
                $button_forward_issues_display_none = "";
            }

            if ($get_session_role != "R001") {
                $button_forward_issues_display_none = "style='display:none'";
            } else {
                $button_forward_issues_display_none = "";
            }



            $datas = [];

            $no = $offset + 1;

            if (count($m_issues) > 0) {

                foreach ($m_issues as $value) {
                    $get_issues_file = DB::table('issues_file')
                        ->select(DB::raw("issues_file.*"))
                        ->where('issues_file.issues_tiket', '=', $value->tiket_issues)
                        ->get();

                    $issues_link_array = '';

                    foreach ($get_issues_file as $value_2) {
                        // $issues_link_array = "";
                        // $issues_link_array .= '<a href="' . url() . 'v_issues/' . $value_2->file_name . '">' . url() . '/v_issues/' . $value_2->file_name . '</a> <br>';
                        if ($get_session_role == 'R001') {
                            $issues_link_array .=
                                '<div class="row">' .
                                '<div class="col-md-10">' .
                                '<a href="download_file/' . $value_2->file_name . '" target="_blank">' . $value_2->file_name . '</a>' .
                                '</div>' .
                                '<div class="col-md-2 text-right">' .
                                '<button type="button" data-issues_file_id="' . $value_2->id . '" data-tiket_issues="' . $value->tiket_issues . '" id="delete_file_issues_modal" name="delete_file_issues_modal" class="btn btn-md btn-danger m-1 delete_file_issues_modal float-right"><i class="mdi mdi-close"></i></button>' .
                                '</div>' .
                                '</div>' .
                                '<br>';
                        } else {
                            $issues_link_array .=
                                '<div class="row">' .
                                '<div class="col-md-10">' .
                                '<a href="download_file/' . $value_2->file_name . '" target="_blank">' . $value_2->file_name . '</a>' .
                                '</div>' .
                                '</div>' .
                                '<br>';
                        }

                        // $issues_link_array .= '<button onclick="JavaScript:window.location.href=\''. public_path() . '/file_issues/' . $value_2->file_name .'\';"> Download Image</button><br />';
                        // $issues_link_array .= '<button onclick="JavaScript:window.location.href=\''. public_path() . '/file_issues/' . $value_2->file_name .'\';"> Download Image</button><br />';
                        // $issues_link_array .= '<button type="submit" onclick="window.open("' . $value_2->file_name . '")">Download!</button>';
                    }

                    $get_issues_forward = DB::table('issues_forward')
                        ->select(DB::raw("issues_forward.*"))
                        ->where('issues_forward.tiket_issues', '=', $value->tiket_issues)
                        ->get();

                    $get_issues_forward_count = count($get_issues_forward);

                    $forward_info = '';
                    if ($get_issues_forward_count == 0) {
                        $forward_info = '';
                    } else {
                        $forward_info = '<h5><span class="badge rounded-pill bg-dark">Forwarded</span></h5>';
                    }

                    // dd($issues_link_array);

                    $qrcode = base64_encode(QrCode::format('png')
                        ->merge(public_path('image/Petro_logo.png'), 0.3, true)
                        ->size(400)->errorCorrection("H")
                        ->margin(1)
                        ->generate($value->tiket_issues_duplikat));

                    // dd($qrcode);

                    $tiket_cares_pi = $value->tiket_cares_pi != null ? 'Tiket PI : ' . $value->tiket_cares_pi . '<br>' : '';
                    $security_incident = $value->security_incident == 'true' ? 'Security Incident' . '<br>' : '';
                    $major_incident = $value->major_incident == 'true' ? 'Major Incident' . '<br>' : '';
                    $keterangan_issue = "<div style='font-size:12px;'>" . $tiket_cares_pi . $security_incident . $major_incident . "</div>";

                    $datas[] = array(

                        'no' => $no++,
                        'tiket_issues' => $value->tiket_issues,
                        'tiket_issues_duplikat' => $value->tiket_issues_duplikat,
                        'tiket_issues_tiket_issues_duplikat' => $value->tiket_issues . ' / ' . $value->tiket_issues_duplikat,
                        'tiket_issues_qrcode' => $qrcode,
                        'username_sap_issues' => $value->username_sap_issues,
                        'nama_pegawai' => $value->nama_v_users_all . '<br> ( ' . $value->username_sap_issues . ' )',
                        'created_by' => $value->created_by,
                        'telp_issues' => $value->telp_issues,
                        'nama_kategori' => $value->nama_kategori,
                        'nama_layanan' => $value->nama_layanan,
                        'nama_subject' => $value->nama_subject,
                        'nama_priority' => $value->nama_priority,
                        // 'description_issues' => $value->description_issues,
                        // 'description_issues' =>
                        // '<button type="button" name="description_detail" id="description_detail" 
                        // class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalDescriptionIssues"
                        // data-description_issues=\'' . $value->description_issues . '\' 
                        // ><i class="mdi mdi-eye-outline"></i></button>',
                        'description_issues' =>
                        '<button type="button" name="description_detail" id="description_detail" 
                        class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalIssuesDetail"
                        data-issues_id=\'' . $value->tiket_issues . '\' 
                        data-issues_id="' . $value->id . '"
                        data-username_sap_issues="' . $value->username_sap_issues . '" 
                        data-nama_pegawai="' . $value->nama_v_users_all . '" 
                        data-created_by="' . $value->created_by . '" 
                        data-telp_issues="' . $value->telp_issues . '" 
                        data-nama_kategori="' . $value->nama_kategori . '" 
                        data-nama_layanan="' . $value->nama_layanan . '" 
                        data-nama_priority="' . $value->nama_priority . '"
                        ><i class="mdi mdi-eye-outline"></i></button>',
                        // 'file_issues' => $value->file_issues,
                        'file_issues' => $issues_link_array,
                        'tanggal_pembuatan_issues' => $value->tanggal_pembuatan_issues,
                        'tanggal_batas_issues' => $value->tanggal_batas_issues,
                        'status' => status_issues_id_ke_text($value->status) . '<br>' . $forward_info,
                        'keterangan' => $keterangan_issue,
                        'aksi' =>
                        // '<button type="button" name="delete" id="delete" data-issues_id="' . $value->id . '" class="btn btn-danger btn-xs" href=' . '' . '><i class="mdi mdi-trash-can"></i> </button>' . '<br>' . '<br>' .
                        '<button type="button" name="description_detail" id="description_detail" 
                            class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalIssuesDetail"
                            data-tiket_issues=\'' . $value->tiket_issues . '\' 
                            data-issues_id="' . $value->id . '"
                            data-username_sap_issues="' . $value->username_sap_issues . '" 
                            data-nama_pegawai="' . $value->nama_v_users_all . '" 
                            data-created_by="' . $value->created_by . '" 
                            data-telp_issues="' . $value->telp_issues . '" 
                            data-nama_kategori="' . $value->nama_kategori . '" 
                            data-nama_layanan="' . $value->nama_layanan . '" 
                            data-nama_subject="' . $value->nama_subject . '" 
                            data-m_kategori_id="' . $value->m_kategori_id . '" 
                            data-m_layanan_id="' . $value->m_layanan_id . '" 
                            data-m_subject_id="' . $value->m_subject_id . '" 
                            data-nama_priority="' . $value->nama_priority . '"
                            data-priority_id="' . $value->priority_id . '"
                            data-tanggal_pembuatan_issues="' . $value->tanggal_pembuatan_issues . '"
                            data-status_issues="' . $value->status . '"
                            data-tiket_simasti="' . $value->tiket_simasti . '" 
                            data-tanggal_batas_issues="' . $value->tanggal_batas_issues . '"
                            data-no_wa="' . $value->no_whatsapp . '"
                            data-qrcode="' . $qrcode . '" 
                            data-security_incident="' . $value->security_incident . '"
                            data-major_incident="' . $value->major_incident . '"
                            data-append_html_priority_batas_mengganti="' . ' ( kesempatan mengganti ' . $value->batas_update_priority . ' x )' . '"
                            data-issues_link_array=\'' . $issues_link_array . '\'
                            data-issues_status_html=\'' . status_issues_id_ke_text(get_status_terakhir_per_issues_id($value->tiket_issues)) . '\'
                            ><i class="mdi mdi-eye-outline"></i></button>' . '<br>' . '<br>' .
                            '<button ' . $button_forward_issues_display_none . ' type="button" name="forward_issues_detail" id="forward_issues_detail" 
                            class="btn btn-success btn-xs forward_issues_detail" data-bs-toggle="modal" data-bs-target="#modalIssuesForward"
                            data-issues_id="' . $value->id . '" 
                            data-status_issues="' . $value->status . '" 
                            data-tiket_issues=\'' . $value->tiket_issues . '\'
                            ><i class="mdi mdi-file-send"></i> </button>' . '<br>' . '<br>'
                    );
                }
            } else {
                $datas = array();
            }

            // dd($datas);
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function getDataIssuesUnitKerja(Request $request)
    {

        // dd($request->all());

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];
        $searchs = $request["search.value"];
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'searchs' => $searchs,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_role = $get_session['role'];
        $get_session_nik = $get_session['nik'];
        $get_session_unitId = $get_session['unitId'];

        $Tiket_Issues_Search = is_null($request->tiket_issues_2_search) ? '' : $request->tiket_issues_2_search;
        $Nama_Pegawai_Search = is_null($request->nama_pegawai_2_search) ? '' : $request->nama_pegawai_2_search;
        $Created_By_Search = is_null($request->created_by_2_search) ? '' : $request->created_by_2_search;
        $layanan_search = is_null($request->layanan_2_search) ? '' : $request->layanan_2_search;
        $subject_search = is_null($request->subject_2_search) ? '' : $request->subject_2_search;
        $priority_search = is_null($request->priority_2_search) ? '' : $request->priority_2_search;
        $tanggal_pembuatan_search = is_null($request->tanggal_pembuatan_2_search) ? '' : $request->tanggal_pembuatan_2_search;
        $tanggal_batas_search = is_null($request->tanggal_batas_2_search) ? '' : $request->tanggal_batas_2_search;
        $status_search = is_null($request->status_search_2) ? '' : $request->status_search_2;

        $tiket_issues_duplikat_search = is_null($request->tiket_issues_duplikat_2) ? '' : $request->tiket_issues_duplikat_2;

        // dd($request->all());
        // dd($tanggal_pembuatan_search);

        if (validateSessionToken($get_session_token)) {
            $tb_issues = DB::table('v_issues')
                ->select(DB::raw("v_issues.*,
                m_kategori.nama_kategori, m_kategori.id as m_kategori_id,
                m_layanan.nama_layanan, m_layanan.id as m_layanan_id,
                m_subject.nama_subject, m_subject.id as m_subject_id,
                m_priority.nama_priority,
                v_users_all.nama as nama_v_users_all"))
                ->leftjoin('m_kategori', 'm_kategori.id', 'v_issues.kategori_id')
                ->leftjoin('m_layanan', 'm_layanan.id', 'v_issues.layanan_id')
                ->leftjoin('m_subject', 'm_subject.id', 'v_issues.subject_id')
                ->leftjoin('m_priority', 'm_priority.id', 'v_issues.priority_id')
                ->leftjoin('v_users_all', 'v_users_all.username', 'v_issues.username_sap_issues')
                ->orderBy('v_issues.created_at', "DESC")
                // ->where('v_issues.unitid', '=', $get_session_unitId)
                // ->orWhere('v_issues.tiket_issues', 'ilike', '%' . $Tiket_Issues_Search . '%')
                // ->orWhere('pegawai.nama', 'ilike', '%' . $Nama_Pegawai_Search . '%')
                // ->orWhere('v_issues.created_by', 'ilike', '%' . $Created_By_Search . '%')
                // ->orWhere('m_layanan.nama_layanan', 'ilike', '%' . $layanan_search . '%')
                // ->orWhere('m_subject.nama_subject', 'ilike', '%' . $subject_search . '%')
                // ->orWhere('m_priority.nama_priority', 'ilike', '%' . $priority_search . '%')
                // ->orWhere('v_issues.tanggal_pembuatan_issues', 'ilike', '%' . $tanggal_pembuatan_search . '%')
                // ->orWhere('v_issues.tanggal_batas_issues', 'ilike', '%' . $tanggal_batas_search . '%');
                // ->orWhere('v_issues.tiket_issues', 'ilike', '%' . $status_search . '%')
                ->Where(function ($query) use (
                    $Tiket_Issues_Search,
                    $Nama_Pegawai_Search,
                    $Created_By_Search,
                    $layanan_search,
                    $subject_search,
                    $priority_search,
                    $tanggal_pembuatan_search,
                    $tanggal_batas_search,
                    $tiket_issues_duplikat_search,
                    $status_search
                ) {
                    // $query
                    //     ->where('v_issues.tiket_issues', 'ilike', '%' . $Tiket_Issues_Search . '%')
                    //     ->where('v_issues.tiket_issues_duplikat', 'ilike', '%' . $tiket_issues_duplikat_search . '%')
                    //     ->where('v_users_all.nama', 'ilike', '%' . $Nama_Pegawai_Search . '%')
                    //     ->where('v_issues.created_by', 'ilike', '%' . $Created_By_Search . '%')
                    //     ->where('m_layanan.nama_layanan', 'ilike', '%' . $layanan_search . '%')
                    //     ->where('m_subject.nama_subject', 'ilike', '%' . $subject_search . '%')
                    //     ->where('m_priority.nama_priority', 'ilike', '%' . $priority_search . '%')
                    //     ->where('v_issues.tanggal_pembuatan_issues', 'ilike', '%' . $tanggal_pembuatan_search . '%')
                    //     ->where('v_issues.tanggal_batas_issues', 'ilike', '%' . $tanggal_batas_search . '%')
                    //     ->where('v_issues.status', 'ilike', '%' . $status_search . '%');
                    is_null($Tiket_Issues_Search) ?: $query->where('v_issues.tiket_issues', 'ilike', '%' . $Tiket_Issues_Search . '%');
                    is_null($Nama_Pegawai_Search) ?: $query->where('v_users_all.nama', 'ilike', '%' . $Nama_Pegawai_Search . '%');
                    is_null($Created_By_Search) ?: $query->where('v_issues.created_by', 'ilike', '%' . $Created_By_Search . '%');
                    is_null($layanan_search) ?: $query->where('m_layanan.nama_layanan', 'ilike', '%' . $layanan_search . '%');
                    is_null($subject_search) ?: $query->where('m_subject.nama_subject', 'ilike', '%' . $subject_search . '%');
                    is_null($priority_search) ?: $query->where('m_priority.nama_priority', 'ilike', '%' . $priority_search . '%');
                    is_null($tanggal_pembuatan_search) ?: $query->where('v_issues.tanggal_pembuatan_issues', 'ilike', '%' . $tanggal_pembuatan_search . '%');
                    is_null($tanggal_batas_search) ?: $query->where('v_issues.tanggal_batas_issues', 'ilike', '%' . $tanggal_batas_search . '%');
                    is_null($tiket_issues_duplikat_search) ?: $query->where('v_issues.tiket_issues_duplikat', 'ilike', '%' . $tiket_issues_duplikat_search . '%');
                    is_null($status_search) ?: $query->where('v_issues.status', 'ilike', '%' . $status_search . '%');
                });

            $tb_issues->where('v_issues.unitid', '=', $get_session_unitId);

            // $datax['total_data'] = $tb_users->first();

            // $total_data = $tb_issues->count();

            if ($get_session_role == "R003") {

                $total_data = $tb_issues
                    ->where('v_issues.unitid', '=', $get_session_unitId)
                    ->count();

                $m_issues = $tb_issues
                    ->limit($limit)
                    ->offset($offset)

                    ->get();
                // dd($m_issues);
            } else {

                $total_data = $tb_issues->count();

                $m_issues = $tb_issues
                    ->limit($limit)
                    ->offset($offset)
                    ->get();
            }

            $datas = [];

            $no = $offset + 1;



            if (count($m_issues) > 0) {

                foreach ($m_issues as $value) {
                    // dd($value['nama']);
                    // dd($value->description_issues);
                    // dd(status_issues_id_ke_text(get_status_terakhir_per_issues_id($value->tiket_issues)));

                    $get_issues_file = DB::table('issues_file')
                        ->select(DB::raw("issues_file.*"))
                        ->where('issues_file.issues_tiket', '=', $value->tiket_issues)
                        ->get();

                    $issues_link_array = '';

                    foreach ($get_issues_file as $value_2) {
                        // $issues_link_array = "";
                        // $issues_link_array .= '<a href="' . url() . 'v_issues/' . $value_2->file_name . '">' . url() . '/v_issues/' . $value_2->file_name . '</a> <br>';
                        if ($get_session_role == 'R001') {
                            $issues_link_array .=
                                '<div class="row">' .
                                '<div class="col-md-10">' .
                                '<a href="download_file/' . $value_2->file_name . '" target="_blank">' . $value_2->file_name . '</a>' .
                                '</div>' .
                                '<div class="col-md-2 text-right">' .
                                '<button type="button" data-issues_file_id="' . $value_2->id . '" data-tiket_issues="' . $value->tiket_issues . '" id="delete_file_issues_modal" name="delete_file_issues_modal" class="btn btn-md btn-danger m-1 delete_file_issues_modal float-right"><i class="mdi mdi-close"></i></button>' .
                                '</div>' .
                                '</div>' .
                                '<br>';
                        } else {
                            $issues_link_array .=
                                '<div class="row">' .
                                '<div class="col-md-10">' .
                                '<a href="download_file/' . $value_2->file_name . '" target="_blank">' . $value_2->file_name . '</a>' .
                                '</div>' .
                                '</div>' .
                                '<br>';
                        }
                        // $issues_link_array .= '<button onclick="JavaScript:window.location.href=\''. public_path() . '/file_issues/' . $value_2->file_name .'\';"> Download Image</button><br />';
                        // $issues_link_array .= '<button onclick="JavaScript:window.location.href=\''. public_path() . '/file_issues/' . $value_2->file_name .'\';"> Download Image</button><br />';
                        // $issues_link_array .= '<button type="submit" onclick="window.open("' . $value_2->file_name . '")">Download!</button>';
                    }

                    // dd($issues_link_array);

                    $qrcode = base64_encode(QrCode::format('png')
                        ->merge(public_path('image/Petro_logo.png'), 0.3, true)
                        ->size(150)->errorCorrection("H")
                        ->generate($value->tiket_issues_duplikat));

                    // dd($qrcode);

                    $datas[] = array(

                        'no' => $no++,
                        'tiket_issues' => $value->tiket_issues,
                        'tiket_issues_duplikat' => $value->tiket_issues_duplikat,
                        'tiket_issues_tiket_issues_duplikat' => $value->tiket_issues . ' / ' . $value->tiket_issues_duplikat,
                        'username_sap_issues' => $value->username_sap_issues,
                        'tiket_issues_qrcode' => $qrcode,
                        'nama_pegawai' => $value->nama_v_users_all . '<br> ( ' . $value->username_sap_issues . ' )',
                        'created_by' => $value->created_by,
                        'telp_issues' => $value->telp_issues,
                        'nama_kategori' => $value->nama_kategori,
                        'nama_layanan' => $value->nama_layanan,
                        'nama_subject' => $value->nama_subject,
                        'nama_priority' => $value->nama_priority,
                        // 'description_issues' => $value->description_issues,
                        // 'description_issues' =>
                        // '<button type="button" name="description_detail" id="description_detail" 
                        // class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalDescriptionIssues"
                        // data-description_issues=\'' . $value->description_issues . '\' 
                        // ><i class="mdi mdi-eye-outline"></i></button>',
                        'description_issues' =>
                        '<button type="button" name="description_detail" id="description_detail" 
                        class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalIssuesDetail"
                        data-issues_id=\'' . $value->tiket_issues . '\' 
                        data-issues_id="' . $value->id . '"
                        data-username_sap_issues="' . $value->username_sap_issues . '" 
                        data-nama_pegawai="' . $value->nama_v_users_all . '" 
                        data-created_by="' . $value->created_by . '" 
                        data-telp_issues="' . $value->telp_issues . '" 
                        data-nama_kategori="' . $value->nama_kategori . '" 
                        data-nama_layanan="' . $value->nama_layanan . '" 
                        data-nama_priority="' . $value->nama_priority . '"
                        data-no_wa="' . $value->no_whatsapp . '"
                        data-security_incident="' . $value->security_incident . '"
                        data-major_incident="' . $value->major_incident . '"
                        ><i class="mdi mdi-eye-outline"></i></button>',
                        // 'file_issues' => $value->file_issues,
                        'file_issues' => $issues_link_array,
                        'tanggal_pembuatan_issues' => $value->tanggal_pembuatan_issues,
                        'tanggal_batas_issues' => $value->tanggal_batas_issues,
                        'status' => status_issues_id_ke_text(get_status_terakhir_per_issues_id($value->tiket_issues)),
                        'aksi' =>
                        // '<button type="button" name="delete" id="delete" data-issues_id="' . $value->id . '" class="btn btn-danger btn-xs" href=' . '' . '><i class="mdi mdi-trash-can"></i> </button>' . '<br>' . '<br>' .
                        '<button type="button" name="description_detail" id="description_detail" 
                            class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalIssuesDetail"
                            data-tiket_issues=\'' . $value->tiket_issues . '\' 
                            data-issues_id="' . $value->id . '"
                            data-username_sap_issues="' . $value->username_sap_issues . '" 
                            data-nama_pegawai="' . $value->nama_v_users_all . '" 
                            data-created_by="' . $value->created_by . '" 
                            data-telp_issues="' . $value->telp_issues . '" 
                            data-nama_kategori="' . $value->nama_kategori . '" 
                            data-nama_layanan="' . $value->nama_layanan . '" 
                            data-nama_subject="' . $value->nama_subject . '" 
                            data-m_kategori_id="' . $value->m_kategori_id . '" 
                            data-m_layanan_id="' . $value->m_layanan_id . '" 
                            data-m_subject_id="' . $value->m_subject_id . '" 
                            data-nama_priority="' . $value->nama_priority . '"
                            data-tanggal_pembuatan_issues="' . $value->tanggal_pembuatan_issues . '"
                            data-tanggal_batas_issues="' . $value->tanggal_batas_issues . '"
                            data-tiket_simasti="' . $value->tiket_simasti . '"
                            data-no_wa="' . $value->no_whatsapp . '"
                            data-security_incident="' . $value->security_incident . '"
                            data-major_incident="' . $value->major_incident . '"
                            data-issues_link_array=\'' . $issues_link_array . '\'
                            data-issues_status_html=\'' . status_issues_id_ke_text(get_status_terakhir_per_issues_id($value->tiket_issues)) . '\'
                            ><i class="mdi mdi-eye-outline"></i></button>'
                    );
                }
            } else {
                $datas = array();
            }

            // dd($datas);
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function getDataIssuesForward(Request $request)
    {

        // dd($request->all());

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];
        $searchs = $request["search.value"];
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'searchs' => $searchs,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_role = $get_session['role'];
        $get_session_nik = $get_session['nik'];
        $get_session_unitId = $get_session['unitId'];
        $get_session_username = $get_session['username'];

        $Tiket_Issues_Search = is_null($request->tiket_issues_3_search) ? '' : $request->tiket_issues_3_search;
        $Nama_Pegawai_Search = is_null($request->nama_pegawai_3_search) ? '' : $request->nama_pegawai_3_search;
        $Created_By_Search = is_null($request->created_by_3_search) ? '' : $request->created_by_3_search;
        $layanan_search = is_null($request->layanan_3_search) ? '' : $request->layanan_3_search;
        $subject_search = is_null($request->subject_3_search) ? '' : $request->subject_3_search;
        $priority_search = is_null($request->priority_3_search) ? '' : $request->priority_3_search;
        $tanggal_pembuatan_search = is_null($request->tanggal_pembuatan_3_search) ? '' : $request->tanggal_pembuatan_3_search;
        $tanggal_batas_search = is_null($request->tanggal_batas_3_search) ? '' : $request->tanggal_batas_3_search;
        $status_search = is_null($request->status_3_search) ? '' : $request->status_3_search;

        $tiket_issues_duplikat_search = is_null($request->tiket_issues_duplikat_3) ? '' : $request->tiket_issues_duplikat_3;

        $keterangan_search = is_null($request->keterangan_3_search) ? '' : $request->keterangan_3_search;
        $security_incident_search = is_null($request->security_incident_3_search) ? '' : $request->security_incident_3_search;
        $major_incident_search = is_null($request->major_incident_3_search) ? '' : $request->major_incident_3_search;

        // dd($request);

        if (validateSessionToken($get_session_token)) {
            $tb_issues_forward = DB::table('issues_forward')
                ->select(DB::raw("v_issues.*,
                m_kategori.nama_kategori, m_kategori.id as m_kategori_id,
                m_layanan.nama_layanan, m_layanan.id as m_layanan_id,
                m_subject.nama_subject, m_subject.id as m_subject_id,
                m_priority.nama_priority,
                v_users_all.nama as nama_v_users_all"))
                ->leftjoin('v_issues', 'v_issues.tiket_issues', 'issues_forward.tiket_issues')
                ->leftjoin('m_kategori', 'm_kategori.id', 'v_issues.kategori_id')
                ->leftjoin('m_layanan', 'm_layanan.id', 'v_issues.layanan_id')
                ->leftjoin('m_subject', 'm_subject.id', 'v_issues.subject_id')
                ->leftjoin('m_priority', 'm_priority.id', 'v_issues.priority_id')
                ->leftjoin('v_users_all', 'v_users_all.username', 'v_issues.username_sap_issues')
                ->orderBy('v_issues.created_at', "DESC")
                ->where('issues_forward.forward_username', '=', $get_session_username)
                ->Where(function ($query) use (
                    $Tiket_Issues_Search,
                    $Nama_Pegawai_Search,
                    $Created_By_Search,
                    $layanan_search,
                    $subject_search,
                    $priority_search,
                    $tanggal_pembuatan_search,
                    $tanggal_batas_search,
                    $tiket_issues_duplikat_search,
                    $status_search,
                    $keterangan_search,
                    $security_incident_search,
                    $major_incident_search
                ) {
                    // $query
                    //     ->where('v_issues.tiket_issues', 'ilike', '%' . $Tiket_Issues_Search . '%')
                    //     ->where('v_users_all.nama', 'ilike', '%' . $Nama_Pegawai_Search . '%')
                    //     ->where('v_issues.created_by', 'ilike', '%' . $Created_By_Search . '%')
                    //     ->where('m_layanan.nama_layanan', 'ilike', '%' . $layanan_search . '%')
                    //     ->where('m_subject.nama_subject', 'ilike', '%' . $subject_search . '%')
                    //     ->where('m_priority.nama_priority', 'ilike', '%' . $priority_search . '%')
                    //     ->where('v_issues.tanggal_pembuatan_issues', 'ilike', '%' . $tanggal_pembuatan_search . '%')
                    //     ->where('v_issues.tanggal_batas_issues', 'ilike', '%' . $tanggal_batas_search . '%')
                    //     ->where('v_issues.tiket_issues_duplikat', 'ilike', '%' . $tiket_issues_duplikat_search . '%')
                    //     ->where('v_issues.status', 'ilike', '%' . $status_search . '%');
                    is_null($Tiket_Issues_Search) ?: $query->where('v_issues.tiket_issues', 'ilike', '%' . $Tiket_Issues_Search . '%');
                    is_null($Nama_Pegawai_Search) ?: $query->where('v_users_all.nama', 'ilike', '%' . $Nama_Pegawai_Search . '%');
                    is_null($Created_By_Search) ?: $query->where('v_issues.created_by', 'ilike', '%' . $Created_By_Search . '%');
                    is_null($layanan_search) ?: $query->where('m_layanan.nama_layanan', 'ilike', '%' . $layanan_search . '%');
                    is_null($subject_search) ?: $query->where('m_subject.nama_subject', 'ilike', '%' . $subject_search . '%');
                    is_null($priority_search) ?: $query->where('m_priority.nama_priority', 'ilike', '%' . $priority_search . '%');
                    is_null($tanggal_pembuatan_search) ?: $query->where('v_issues.tanggal_pembuatan_issues', 'ilike', '%' . $tanggal_pembuatan_search . '%');
                    is_null($tanggal_batas_search) ?: $query->where('v_issues.tanggal_batas_issues', 'ilike', '%' . $tanggal_batas_search . '%');
                    is_null($tiket_issues_duplikat_search) ?: $query->where('v_issues.tiket_issues_duplikat', 'ilike', '%' . $tiket_issues_duplikat_search . '%');
                    is_null($status_search) ?: $query->where('v_issues.status', 'ilike', '%' . $status_search . '%');
                    is_null($keterangan_search) || $keterangan_search == '' ?: $query->where('v_issues.tiket_cares_pi', 'ilike', '%' . $keterangan_search . '%');
                    is_null($security_incident_search) || $security_incident_search == '' || $security_incident_search == 'false' ?: $query->where('v_issues.security_incident', 'ilike', '%' . $security_incident_search . '%');
                    is_null($major_incident_search) || $major_incident_search == '' || $major_incident_search == 'false' ?: $query->where('v_issues.major_incident', 'ilike', '%' . $major_incident_search . '%');
                });

            // dd($security_incident_search);
            // dd($tb_issues_forward->get()->count());


            // $datax['total_data'] = $tb_users->first();

            // $tb_issues->where('v_issues.layanan_id', '!=', NULL);

            // $get_m_pic_layanan_id = array();

            // $get_issues_forward = DB::table('issues_forward')
            //     ->select(DB::raw("issues_forward.tiket_issues"))
            //     ->where('issues_forward.forward_username', '=', $get_session_username)
            //     ->get();

            // if (count($get_issues_forward) == 0) {
            // } else {
            //     foreach ($get_issues_forward as $data) {
            //         $tb_issues->Where('v_issues.username_sap_issues', '=', $data->forward_username);
            //     }
            // }
            // $tb_issues = $tb_issues->where(function ($query) use ($get_session_username) {

            //     $get_issues_forward = DB::table('issues_forward')
            //         ->select(DB::raw("issues_forward.tiket_issues"))
            //         ->where('issues_forward.forward_username', '=', $get_session_username)
            //         ->get();

            //     if (count($get_issues_forward) == 0) {
            //     } else {
            //         foreach ($get_issues_forward as $data) {
            //             $query->Where('v_issues.username_sap_issues', '=', $data->tiket_issues);
            //         }
            //     }
            //     // $query->where('activated', '=', $activated);
            // });
            // dd($tb_issues->toSql());

            // $total_data = 0;
            $total_data = $tb_issues_forward->get()->count();
            $m_issues_forward = $tb_issues_forward
                ->limit($limit)
                ->offset($offset)
                ->get();

            // if ($get_session_role == "R003") {
            //     $m_issues_forward = $tb_issues_forward
            //         ->limit($limit)
            //         ->offset($offset)
            //         ->get();



            //     // dd($m_issues_forward);
            // } else {
            //     $m_issues_forward = $tb_issues_forward
            //         ->limit($limit)
            //         ->offset($offset)
            //         ->get();
            // }





            $datas = [];

            $no = $offset + 1;



            if (count($m_issues_forward) > 0) {

                foreach ($m_issues_forward as $value) {
                    // dd($value['nama']);
                    // dd($value->description_issues);
                    // dd(status_issues_id_ke_text(get_status_terakhir_per_issues_id($value->tiket_issues)));

                    $get_issues_file = DB::table('issues_file')
                        ->select(DB::raw("issues_file.*"))
                        ->where('issues_file.issues_tiket', '=', $value->tiket_issues)
                        ->get();

                    $issues_link_array = '';

                    foreach ($get_issues_file as $value_2) {
                        // $issues_link_array = "";
                        // $issues_link_array .= '<a href="' . url() . 'v_issues/' . $value_2->file_name . '">' . url() . '/v_issues/' . $value_2->file_name . '</a> <br>';
                        if ($get_session_role == 'R001') {
                            $issues_link_array .=
                                '<div class="row">' .
                                '<div class="col-md-10">' .
                                '<a href="download_file/' . $value_2->file_name . '" target="_blank">' . $value_2->file_name . '</a>' .
                                '</div>' .
                                '<div class="col-md-2 text-right">' .
                                '<button type="button" data-issues_file_id="' . $value_2->id . '" data-tiket_issues="' . $value->tiket_issues . '" id="delete_file_issues_modal" name="delete_file_issues_modal" class="btn btn-md btn-danger m-1 delete_file_issues_modal float-right"><i class="mdi mdi-close"></i></button>' .
                                '</div>' .
                                '</div>' .
                                '<br>';
                        } else {
                            $issues_link_array .=
                                '<div class="row">' .
                                '<div class="col-md-10">' .
                                '<a href="download_file/' . $value_2->file_name . '" target="_blank">' . $value_2->file_name . '</a>' .
                                '</div>' .
                                '</div>' .
                                '<br>';
                        }
                        // $issues_link_array .= '<button onclick="JavaScript:window.location.href=\''. public_path() . '/file_issues/' . $value_2->file_name .'\';"> Download Image</button><br />';
                        // $issues_link_array .= '<button onclick="JavaScript:window.location.href=\''. public_path() . '/file_issues/' . $value_2->file_name .'\';"> Download Image</button><br />';
                        // $issues_link_array .= '<button type="submit" onclick="window.open("' . $value_2->file_name . '")">Download!</button>';
                    }

                    // dd($issues_link_array);

                    $get_issues_forward = DB::table('issues_forward')
                        ->select(DB::raw("issues_forward.*"))
                        ->where('issues_forward.tiket_issues', '=', $value->tiket_issues)
                        ->get();

                    $get_issues_forward_count = count($get_issues_forward);

                    $forward_info = '';
                    if ($get_issues_forward_count == 0) {
                        $forward_info = '';
                    } else {
                        $forward_info = '<h5><span class="badge rounded-pill bg-dark">Forwarded</span></h5>';
                    }

                    $qrcode = base64_encode(QrCode::format('png')
                        ->merge(public_path('image/Petro_logo.png'), 0.3, true)
                        ->size(150)->errorCorrection("H")
                        ->generate($value->tiket_issues_duplikat));

                    // dd($qrcode);
                    $tiket_cares_pi = $value->tiket_cares_pi != null ? 'Tiket PI : ' . $value->tiket_cares_pi . '<br>' : '';
                    $security_incident = $value->security_incident == 'true' ? 'Security Incident' . '<br>' : '';
                    $major_incident = $value->major_incident == 'true' ? 'Major Incident' . '<br>' : '';
                    $keterangan_issue = "<div style='font-size:12px;'>" . $tiket_cares_pi . $security_incident . $major_incident . "</div>";

                    $button_forward_issues_display_none = "";

                    if ($get_session_role == "R005" || $get_session_unitId != "PBD200") {
                        $button_forward_issues_display_none = "style='display:none'";
                    } else {
                        $button_forward_issues_display_none = "";
                    }

                    if ($get_session_role != "R001") {
                        $button_forward_issues_display_none = "style='display:none'";
                    } else {
                        $button_forward_issues_display_none = "";
                    }
                    
                    $datas[] = array(

                        'no' => $no++,
                        'tiket_issues' => $value->tiket_issues,
                        'tiket_issues_duplikat' => $value->tiket_issues_duplikat,
                        'tiket_issues_tiket_issues_duplikat' => $value->tiket_issues . ' / ' . $value->tiket_issues_duplikat,
                        'tiket_issues_qrcode' => $qrcode,
                        'username_sap_issues' => $value->username_sap_issues,
                        'nama_pegawai' => $value->nama_v_users_all . '<br> ( ' . $value->username_sap_issues . ' )',
                        'created_by' => $value->created_by,
                        'telp_issues' => $value->telp_issues,
                        'nama_kategori' => $value->nama_kategori,
                        'nama_layanan' => $value->nama_layanan,
                        'nama_subject' => $value->nama_subject,
                        'nama_priority' => $value->nama_priority,
                        // 'description_issues' => $value->description_issues,
                        // 'description_issues' =>
                        // '<button type="button" name="description_detail" id="description_detail" 
                        // class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalDescriptionIssues"
                        // data-description_issues=\'' . $value->description_issues . '\' 
                        // ><i class="mdi mdi-eye-outline"></i></button>',
                        'description_issues' =>
                        '<button type="button" name="description_detail" id="description_detail" 
                        class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalIssuesDetail"
                        data-issues_id=\'' . $value->tiket_issues . '\' 
                        data-issues_id="' . $value->id . '"
                        data-username_sap_issues="' . $value->username_sap_issues . '" 
                        data-nama_pegawai="' . $value->nama_v_users_all . '" 
                        data-created_by="' . $value->created_by . '" 
                        data-telp_issues="' . $value->telp_issues . '" 
                        data-nama_kategori="' . $value->nama_kategori . '" 
                        data-nama_layanan="' . $value->nama_layanan . '" 
                        data-nama_priority="' . $value->nama_priority . '"
                        ><i class="mdi mdi-eye-outline"></i></button>',
                        // 'file_issues' => $value->file_issues,
                        'file_issues' => $issues_link_array,
                        'tanggal_pembuatan_issues' => $value->tanggal_pembuatan_issues,
                        'tanggal_batas_issues' => $value->tanggal_batas_issues,
                        'status' => status_issues_id_ke_text($value->status) . '<br>' . $forward_info,
                        'keterangan' => $keterangan_issue,
                        'aksi' =>
                        // '<button type="button" name="delete" id="delete" data-issues_id="' . $value->id . '" class="btn btn-danger btn-xs" href=' . '' . '><i class="mdi mdi-trash-can"></i> </button>' . '<br>' . '<br>' .
                        '<button type="button" name="description_detail" id="description_detail" 
                            class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalIssuesDetail"
                            data-tiket_issues=\'' . $value->tiket_issues . '\' 
                            data-issues_id="' . $value->id . '"
                            data-username_sap_issues="' . $value->username_sap_issues . '" 
                            data-nama_pegawai="' . $value->nama_v_users_all . '" 
                            data-created_by="' . $value->created_by . '" 
                            data-telp_issues="' . $value->telp_issues . '" 
                            data-nama_kategori="' . $value->nama_kategori . '" 
                            data-nama_layanan="' . $value->nama_layanan . '" 
                            data-nama_subject="' . $value->nama_subject . '" 
                            data-m_kategori_id="' . $value->m_kategori_id . '" 
                            data-m_layanan_id="' . $value->m_layanan_id . '" 
                            data-m_subject_id="' . $value->m_subject_id . '" 
                            data-nama_priority="' . $value->nama_priority . '"
                            data-priority_id="' . $value->priority_id . '"
                            data-tanggal_pembuatan_issues="' . $value->tanggal_pembuatan_issues . '"
                            data-status_issues="' . $value->status . '"
                            data-tiket_simasti="' . $value->tiket_simasti . '" 
                            data-tanggal_batas_issues="' . $value->tanggal_batas_issues . '"
                            data-no_wa="' . $value->no_whatsapp . '"
                            data-qrcode="' . $qrcode . '" 
                            data-security_incident="' . $value->security_incident . '"
                            data-major_incident="' . $value->major_incident . '"
                            data-append_html_priority_batas_mengganti="' . ' ( kesempatan mengganti ' . $value->batas_update_priority . ' x )' . '"
                            data-issues_link_array=\'' . $issues_link_array . '\'
                            data-issues_status_html=\'' . status_issues_id_ke_text(get_status_terakhir_per_issues_id($value->tiket_issues)) . '\'
                            ><i class="mdi mdi-eye-outline"></i></button>' . '<br>' . '<br>' .
                            '<button ' . $button_forward_issues_display_none . ' type="button" name="forward_issues_detail" id="forward_issues_detail" 
                            class="btn btn-success btn-xs forward_issues_detail" data-bs-toggle="modal" data-bs-target="#modalIssuesForward"
                            data-issues_id="' . $value->id . '" 
                            data-status_issues="' . $value->status . '" 
                            data-tiket_issues=\'' . $value->tiket_issues . '\'
                            ><i class="mdi mdi-file-send"></i> </button>' . '<br>' . '<br>'
                    );
                }
            } else {
                $datas = array();
            }

            // dd($datas);
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }


    public function getDescriptionIssues(Request $request, $tiket_issues)
    {
        // dd('coba');
        $tb_issues = DB::table('v_issues')
            ->select(DB::raw("v_issues.*"))
            ->where('v_issues.tiket_issues', '=', $tiket_issues)
            ->get()
            ->first();

        $status_issues_html = status_issues_id_ke_text(get_status_terakhir_per_issues_id($tiket_issues));
        // strip_tags($input, '<br>');
        $arr = array('script');
        return response()->json(['description_issues' => str_replace($arr, "skrip", $tb_issues->description_issues), 'status_issues_html' => $status_issues_html]);
        // return response()->json(['description_issues' => strip_tags($tb_issues->description_issues, ['p', 'a', 'br', 'b','i','span','sup','ol','ul','li','div','blockquote','img','h1','h2','h3','h4','h5','h6','pre']), 'status_issues_html' => $status_issues_html]);

    }

    public function tambah(Request $request)
    {

        // dd($request->all());





        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_nik = $get_session['nik'];
        $get_session_role = $get_session['role'];
        $get_session_username = $get_session['username'];
        $get_session_unitId = $get_session['unitId'];

        if ($get_session_role == "R003") {
            $username_sap_issues = $get_session_nik;
        } else {
            $username_sap_issues = $request->username_sap_issues;
        }
        $telp_issues = strip_tags($request->telp_issues);
        $no_wa = strip_tags($request->no_wa);
        $security = strip_tags($request->security);
        $kategori_id = strip_tags($request->kategori_id);
        $layanan_id = strip_tags($request->layanan_id);
        $subject_id = strip_tags($request->subject_id);
        $subject_id_2 = $request->subject_id_2;
        $major = strip_tags($request->major);
        $security = strip_tags($request->security);
        // $no_wa = $request->no_wa;
        $priority_id = strip_tags($request->priority_id);
        $description_issues = $request->description_issues;
        // dd($description_issues);
        $description_issues = strip_tags($description_issues, '<div><b><i><u><a><img><strong><em><iframe><br><p>');
        // dd($description_issues);
        $description_issues = str_replace(['<script>', '</script>', '(', ')', 'alert', 'document.', 'Document.', 'onerror', 'Onerror'], ['&lt;script&gt;', '&lt;/script&gt;', '&lpar;', '&rpar;', '', '', '', '', ''], $description_issues);
        $file_issues = $request->file('file_issues');
        $file_issues_jumlah = is_null($file_issues) ? 0 : count($file_issues);
        $tanggal_pembuatan_issues = strip_tags($request->tanggal_pembuatan_issues);
        $tanggal_batas_issues = strip_tags($request->tanggal_batas_issues);
        // if (count(array_unique($subject_id_2)) < count($subject_id_2)) {
        //     // Array has duplicates
        //     dd('ada duplicate');
        // } else {
        //     // Array does not have duplicates
        //     dd('tidak ada duplicate');
        // }

        $required_semua_form = "";

        $accepted = array('doc', 'xls', 'docx', 'xlsx', 'pdf', 'mp3', 'aav', 'mp4', 'mkv', 'jpg', 'jpeg', 'png', 'svg', 'zip');
        // $texts = array('<script>','</script>','<?','>','{{','}}','<?php');
        for ($i = 0; $i < $file_issues_jumlah; $i++) {
            $name = $file_issues[$i]->getClientOriginalName();
            $ext = $file_issues[$i]->extension();
            if (in_array(strtolower($ext), $accepted)) {
            } else {
                return response()->json(['success' => 'Attachment file tidak dapat diupload', 'kode' => 401]);
            }
        }
        // $str = '<p>Hello <b>World!<b></p><!-- Comment --><a href="#top">Top</a>';

        // Stripping all HTML tags except <p> and <a>
        // dd(strip_tags($description_issues,'<div><b><i><u><a><img><strong><em><iframe>'));
        // dd(htmlentities($str));
        // dd(strip_tags(htmlentities($str)));
        // dd(strip_tags($str));
        // print_r(strip_tags($str, ["<p>", "<a>"]));
        // dd($description_issues);
        // dd(strip_tags($description_issues, ["iframe"]));
        // dd(strip_tags($description_issues, ["<b>", "<i>", "<u>", "<a>", "<img>", "<strong>", "<em>", "<iframe>"]));
        // $description_issues = strip_tags($description_issues, ["<b>", "<i>", "<u>", "<a>", "<img>", "<strong>", "<em>", "<iframe>"]);

        // foreach($texts as $text){
        //     if(stripos(strtolower($description_issues), $text) == true){
        //         return response()->json(['success' => 'Tidak dapat menambah isu, periksa kembali form input', 'kode' => 401]);
        //     }
        // }
        if (is_numeric($telp_issues) && strlen($telp_issues) <= 15) {
        } else {
            return response()->json(['success' => 'Tidak dapat menambah isu, no hp melebihi 15 karakter atau nomor hp bukan nomor', 'kode' => 401]);
        }

        if (is_numeric($no_wa) && strlen($no_wa) <= 15) {
            if (substr($no_wa, 0, 2) == 62) {
            } else {
                return response()->json(['success' => 'Tidak dapat menambah isu, no whatsapp harus menggunakan angka 62', 'kode' => 401]);
            }
        } else {
            return response()->json(['success' => 'Tidak dapat menambah isu, no whatsapp melebihi 15 karakter atau nomor whatsapp bukan nomor atau nomor whatsapp kosong', 'kode' => 401]);
        }

        // $tanggal_pembuatan_issues_timestamp = strtotime($tanggal_pembuatan_issues);
        // $tanggal_pembuatan_issues_timestamp_y_m_d = date("Y-m-d", $tanggal_pembuatan_issues_timestamp);
        // dd(validateDate($tanggal_pembuatan_issues_timestamp_y_m_d));
        // if (validateDate($tanggal_pembuatan_issues_timestamp_y_m_d)) {
        //     // dd('bisa');
        // } else {
        //     return response()->json(['success' => 'Tidak dapat menambah isu, tanggal tidak sesuai format', 'kode' => 401]);
        // }

        // if (menghitungCharacterExcludeTagHTML($description_issues) <= 500) {
        // } else {
        //     return response()->json(['success' => 'Tidak dapat menambah isu, descripsion isu tidak boleh lebih dari 500 karakter', 'kode' => 401]);
        // }
        if (isRealDate($tanggal_batas_issues)) {
            // date is ok
            if (isRealDate($tanggal_pembuatan_issues)) {
                // date is ok
            } else {
                // date is not ok
                return response()->json(['success' => 'Tidak dapat menambah isu, tanggal pembuatan issue tidak sesuai format', 'kode' => 401]);
            }
        } else {
            // date is not ok
            return response()->json(['success' => 'Tidak dapat menambah isu, tanggal batas issue tidak sesuai format', 'kode' => 401]);
        }
        if (menghitungCharacterExcludeTagHTML($description_issues) <= 1000) {
        } else {
            return response()->json(['success' => 'Tidak dapat menambah isu, descripsion isu tidak boleh lebih dari 1000 karakter', 'kode' => 401]);
        }

        if ($layanan_id == 'L042') {
            if ($username_sap_issues == null || $username_sap_issues == "") {
                $required_semua_form = "anda belum memasukan username sap issues";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($telp_issues == null || $telp_issues == "") {
                $required_semua_form = "anda belum memasukan telp issues";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($kategori_id == null || $kategori_id == "") {
                $required_semua_form = "anda belum memasukan kategori";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($layanan_id == null || $layanan_id == "") {
                $required_semua_form = "anda belum memasukan layanan";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($subject_id_2 == null || $subject_id_2 == "") {
                $required_semua_form = "anda belum memasukan no asset simasti";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($priority_id == null || $priority_id == "") {
                $required_semua_form = "anda belum memasukan priority";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if (count(array_unique($subject_id_2)) < count($subject_id_2)) {
                $required_semua_form = "anda memasukan no asset simasti yang sama (no asset simasti tidak boleh sama)";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else {
                $required_semua_form = "";
            }
        } else {
            if ($username_sap_issues == null || $username_sap_issues == "") {
                $required_semua_form = "anda belum memasukan username sap issues";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($telp_issues == null || $telp_issues == "") {
                $required_semua_form = "anda belum memasukan telp issues";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($kategori_id == null || $kategori_id == "") {
                $required_semua_form = "anda belum memasukan kategori";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($layanan_id == null || $layanan_id == "") {
                $required_semua_form = "anda belum memasukan layanan";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($subject_id == null || $subject_id == "") {
                $required_semua_form = "anda belum memasukan subject";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else if ($priority_id == null || $priority_id == "") {
                $required_semua_form = "anda belum memasukan priority";
                return response()->json(['success' => $required_semua_form, 'kode' => 401]);
            } else {
                $required_semua_form = "";
            }
        }



        // dd($required_semua_form);

        // dd(next_value_tiket());
        // dd($file_issues);
        // dd("$description_issues");
        $subject_final = '';
        // $subject_id_2_explode_ambil_id_nomor_asset_simasti = '';

        if ($layanan_id == 'L042') { //harus one to one

            $m_subject_ambil_id = DB::table('m_subject') //harus one to one
                ->select(DB::raw("m_subject.id"))
                ->where('m_subject.m_layanan_id', '=', $layanan_id)
                ->get()
                ->first();

            $subject_final = $m_subject_ambil_id->id;
            // dd($subject_final);
        } else {
            $subject_final = $subject_id;
            // $subject_id_2_explode_ambil_id_nomor_asset_simasti = '';
        }

        // dd($request->all());

        if (validateSessionToken($get_session_token)) {

            $get_unitid_pegawai = DB::table('v_users_all')
                ->where('v_users_all.username', '=', $username_sap_issues)
                ->get()
                ->first()
                ->unitid;

            $tambah_issues_id = DB::table('issues')
                ->insertGetId([
                    // 'id' => 'K001',
                    'username_sap_issues' => $username_sap_issues,
                    'telp_issues' => $telp_issues,
                    'kategori_id' => $kategori_id,
                    'layanan_id' => $layanan_id,
                    'subject_id' => $subject_final,
                    'priority_id' => $priority_id,
                    'description_issues' => $description_issues,
                    'no_whatsapp' => $no_wa,
                    'major_incident' => $major,
                    'security_incident' => $security,
                    'created_by' => $get_session_username,
                    'tanggal_pembuatan_issues' => $tanggal_pembuatan_issues,
                    'tanggal_batas_issues' => $tanggal_batas_issues,
                    // 'status' => 1,
                    'tiket_issues' => next_value_tiket(),
                    'created_at' => Carbon::now(),
                    'unitid' => $get_unitid_pegawai,
                    // 'asset_simasti_id' => $subject_id_2_explode_ambil_id_nomor_asset_simasti,
                    'tiket_issues_duplikat' => next_value_tiket() . '-' . substr(str_shuffle(str_repeat($x = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(2 / strlen($x)))), 1, 2),

                ]);

            $get_tiket_issues = DB::table('issues')
                ->where('issues.id', '=', $tambah_issues_id)
                ->get()
                ->first()
                ->tiket_issues;

            $tambah_issues_status = DB::table('issues_status')
                ->insert([
                    'tiket_issues' => $get_tiket_issues,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'created_by' => $get_session_username,
                ]);
            app('App\Http\Controllers\notifikasiController')->createNotifikasi(1, $get_tiket_issues);
            for ($i = 0; $i < $file_issues_jumlah; $i++) {

                $filename_dengan_extension = $file_issues[$i]->getClientOriginalName();
                $filename_tanpa_extension = pathinfo($filename_dengan_extension, PATHINFO_FILENAME);

                // dd(pathinfo($filename, PATHINFO_FILENAME));

                // dd($filename);

                $filepath = $get_tiket_issues . '_' . $filename_tanpa_extension . '_' . rand(1000, 9999) . '.' . $file_issues[$i]->getClientOriginalExtension();

                //file pada folder file_lampiran_usulan_kenaikan_pangkat di delete terlebih dahulu
                $file_delete = public_path() . '/file_issues/' . $filepath;
                File::delete($file_delete);

                //setelah file di folder file_lampiran_usulan_kenaikan_pangkat sudah di delete baru dimasukan file yang baru
                $destinationPath = public_path() . '/file_issues/';
                $file_issues[$i]->move($destinationPath, $filepath);

                // dd($filepath);

                $tambah_issues_file = DB::table('issues_file')
                    ->insert([
                        'issues_tiket' => $get_tiket_issues,
                        'file_name' => $filepath,
                        'file_extension' => $file_issues[$i]->getClientOriginalExtension(),
                        'created_at' => Carbon::now()
                    ]);
            }

            // dd('coba');

            // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);

            // $data['no']    =   $request->subject_id_2;
            // $data['keluhan'] =   $request->keluhan;
            // $data['nik']      =   $request->username_sap_issues;
            // $data['no_tlp']      =   $request->telp_issues;
            // $data['ticket']      =   $request->get_tiket_issues;

            // $token      = headerToken();

            // dd($token);


            // $url        = "http://simastipg.petrokimia-gresik.com/api/data_issue";
            // $response   = $client->post($url, ['form_params' => $data]);
            // dd($response);

            // // $response   = $client->post($url, ['headers' => $token, 'form_params' => $data]);
            // $cek_duplikasi = \GuzzleHttp\json_decode($response->getBody(), true);

            // dd($request->keluhan);

            // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
            // $myBody = array(
            //     // "no" => $request->subject_id_2,
            //     // "keluhan" => $request->keluhan,
            //     // "nik" => $request->username_sap_issues,
            //     // "no_tlp" => $request->telp_issues,
            //     // "ticket" => $request->get_tiket_issues,
            // );
            // $url = "http://simastipg.petrokimia-gresik.com/api/data_issue";
            // $request = $client->post($url, ['form_params' => $myBody]);

            // dd($request);
            // return \GuzzleHttp\json_decode($request->getBody(), true);

            // dd('coba');

            // dd($request->telp_issues);

            if ($layanan_id == "L042") {

                try {
                    $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
                    $myBody = array(
                        "no" => $subject_id_2,
                        "keluhan" => $request->keluhan,
                        "nik" => $request->username_sap_issues,
                        "no_tlp" => $request->telp_issues,
                        "ticket" => $get_tiket_issues,
                    );
                    // $url = "http://simastipg.petrokimia-gresik.com/api/data_issue_dev";
                    $url = api_simasti() . "api/data_issue_dev";
                    $request = $client->post($url, ['form_params' => $myBody]);
                    // dd($request);
                    // return \GuzzleHttp\json_decode($request->getBody(), true);
                    $response = \GuzzleHttp\json_decode($request->getBody(), true);

                    if ($response['code']) {
                        $tambah_issues_status = DB::table('issues_status')
                            ->insert([
                                'tiket_issues' => $get_tiket_issues,
                                'status' => 2,
                                'created_at' => Carbon::now(),
                                'created_by' => 'admin_super',
                            ]);
                        $response_id_perbaikan = $response['id_perbaikan'];
                        $response_id_perbaikan_implode = implode("~", $response_id_perbaikan);
                        // dd($response_id_perbaikan_implode);
                        $update_m_kategori = DB::table('issues')
                            ->where('issues.tiket_issues', '=', $get_tiket_issues)
                            ->update([
                                'tiket_simasti' => $response_id_perbaikan_implode,
                            ]);
                    } else {
                        dd('coba');
                    }
                } catch (\Exception $e) {
                    // dd('error iki bro');
                    $delete_issues = DB::table('issues')
                        ->where('issues.tiket_issues', '=', $get_tiket_issues)
                        ->delete();

                    $delete_issues_file = DB::table('issues_file')
                        ->where('issues_file.issues_tiket', '=', $get_tiket_issues)
                        ->delete();

                    $delete_issues_forward = DB::table('issues_forward')
                        ->where('issues_forward.tiket_issues', '=', $get_tiket_issues)
                        ->delete();

                    $delete_issues_forward_riwayat = DB::table('issues_forward_riwayat')
                        ->where('issues_forward_riwayat.tiket_issues', '=', $get_tiket_issues)
                        ->delete();

                    $delete_issues_komentar = DB::table('issues_komentar')
                        ->where('issues_komentar.tiket_issues', '=', $get_tiket_issues)
                        ->delete();

                    $delete_issues_status = DB::table('issues_status')
                        ->where('issues_status.tiket_issues', '=', $get_tiket_issues)
                        ->delete();

                    return response()->json(['success' => 'aplikasi SIMASTI tidak bisa di jangkau', 'kode' => 401]);
                }

                // dd($response['code']);

            } else {
            }

            // if($layanan_id == ){




            // }




            return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function update(Request $request)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $kategori_id_edit = $request->kategori_id_edit;
        $nama_kategori_edit = $request->nama_kategori_edit;

        if (validateSessionToken($get_session_token)) {
            $kategori_id_edit = $request->kategori_id_edit;
            $nama_kategori_edit = $request->nama_kategori_edit;

            $update_m_kategori = DB::table('m_kategori')
                ->where('m_kategori.id', '=', $kategori_id_edit)
                ->update([
                    'nama_kategori' => $nama_kategori_edit,
                ]);


            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function delete(Request $request, $id)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $delete_m_kategori = DB::table('m_kategori')
                ->where('m_kategori.id', '=', $id)
                ->delete();

            $delete_m_layanan = DB::table('m_layanan')
                ->where('m_layanan.m_kategori_id', '=', $id)
                ->delete();

            $delete_m_subject = DB::table('m_subject')
                ->where('m_subject.m_kategori_id', '=', $id)
                ->delete();

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }


    public function getListLayanan(Request $request, $m_kategori_id)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $get_m_layanan = DB::table('m_layanan')
                ->where('m_layanan.m_kategori_id', '=', $m_kategori_id)
                ->where('m_layanan.status_aktif', true)
                ->get();

            $html_option = "";
            $html_option .= '<option value="' . '' . '">' . '' . '</option>';
            foreach ($get_m_layanan as $data) {
                $html_option .= '<option value="' . $data->id . '">' . $data->nama_layanan . '</option>';
            }

            return response()->json(['data' => $html_option]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }


    public function getListSubject(Request $request, $layanan_id)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $get_m_layanan = DB::table('m_subject')
                ->where('m_subject.m_layanan_id', '=', $layanan_id)
                ->whereNotIn('m_subject.id', ["S003","S015","S022","S023","S029","S034","S039","S049","S050","S051","S051","S051"])
                ->where('m_subject.status_aktif', true)
                ->get();

            $html_option = "";

            foreach ($get_m_layanan as $data) {
                $html_option .= '<option value="' . $data->id . '">' . $data->nama_subject . '</option>';
            }

            return response()->json(['data' => $html_option]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function download_file($file_name_dengan_extension)
    {
        $file = public_path() . "/file_issues/$file_name_dengan_extension";

        // // dd($file);

        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        // return Response::download($file, $file_name_dengan_extension, $headers);
        return response()->download($file);
    }

    public function getListDataKomentar(Request $request, $tiket_issues)
    {

        // dd('coba');

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];
        $searchs = $request["search.value"];
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'searchs' => $searchs,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_role = $get_session['role'];
        $get_session_nik = $get_session['nik'];
        $get_session_unitId = $get_session['unitId'];

        if (validateSessionToken($get_session_token)) {
            $tb_issues_komentar = DB::table('issues_komentar')
                ->select(DB::raw("issues_komentar.*,
                v_users_all.nama as nama_user,
                v_users_all.role as role_user,
                m_role.flag as m_role_flag"))
                ->leftjoin('v_users_all', 'v_users_all.username', 'issues_komentar.pegawai_nik')
                ->leftjoin('m_role', 'm_role.id', 'v_users_all.role')
                ->where('issues_komentar.tiket_issues', '=', $tiket_issues)
                ->orderBy('issues_komentar.created_at', 'DESC');

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_issues_komentar->count();


            $m_komentar = $tb_issues_komentar
                ->limit($limit)
                ->offset($offset)
                ->get();


            $datas = [];

            $no = $offset + 1;

            // $photo = "";
            $no_ckeditor = 0;

            if (count($m_komentar) > 0) {
                foreach ($m_komentar as $value) {
                    // dd($no_ckeditor++);
                    $photo = "";
                    if ($value->role_user == "R003") {
                        // dd($value->pegawai_nik);
                        $get_link_photo_pegawai = DB::table('pegawai')
                            ->select(DB::raw("pegawai.foto as pegawai_foto"))
                            ->where('pegawai.nik', '=', $value->pegawai_nik)
                            ->get()
                            ->first()
                            ->pegawai_foto;
                        $photo = '<div class="avatar">
                                <img class="avatar-title rounded-circle header-profile-user" src="' . $get_link_photo_pegawai . '" alt="Header Avatar">
                                </div>';
                    } else {

                        $photo = '<div class="avatar">
                                <span class="avatar-title bg-soft-primary text-primary font-size-16 rounded-circle">
                                ' . $value->m_role_flag . '
                                </span>
                                </div>';
                    }

                    

                    $datas[] = array(
                        'nama_pegawai' => $value->nama_user,
                        'komentar' => '<div name="komentar_list_ckeditor' . $no_ckeditor . '" id="komentar_list_ckeditor' . $no_ckeditor . '" class="komentar_list_ckeditor' . $no_ckeditor . '" style="max-width:100%; margin-bottom: 0;">' . $value->komentar . '</div>' .
                        '<small style="display: block; text-align: right; color: #6c757d; font-size: 0.60em; margin-top: 1px;">' . 
                        ($value->created_at ? Carbon::parse($value->created_at)->format('d-m-Y H:i') : 'Tanggal tidak tersedia') . 
                        '</small>',
                        'photo' => $photo,
                    );

                    $no_ckeditor++;
                }
            } else {
                $datas = array();
            }

            // dd($datas);
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function getPegawaiSemuaSelect2(Request $request)
    {

        $search = $request->search;

        $page = $request->page;
        $resultCount = 10;

        $offset = ($page - 1) * $resultCount;

        $tb_v_users_all = DB::table('v_users_all')
            ->select(DB::raw("v_users_all.username, v_users_all.nama, v_unit_kerja.nama as v_unit_kerja_nama"))
            ->leftjoin('v_unit_kerja', 'v_unit_kerja.unitid', '=', 'v_users_all.unitid')
            ->where(function ($query) use ($search) {
                $query
                    ->orwhere('v_users_all.nama', 'ilike', '%' . $search . '%')
                    ->orwhere('v_users_all.username', 'ilike', '%' . $search . '%')
                    ->orwhere('v_unit_kerja.nama', 'ilike', '%' . $search . '%');
            })
            ->skip($offset)
            ->take($resultCount)
            ->get();

        $tb_v_users_all_count = count(DB::table('v_users_all')
            ->select(DB::raw("v_users_all.username, v_users_all.nama, v_unit_kerja.nama as v_unit_kerja_nama"))
            ->leftjoin('v_unit_kerja', 'v_unit_kerja.unitid', '=', 'v_users_all.unitid')
            // ->where('v_users_all.nama', 'ilike', '%' . $search . '%')
            ->where(function ($query) use ($search) {
                $query
                    ->orwhere('v_users_all.nama', 'ilike', '%' . $search . '%')
                    ->orwhere('v_users_all.username', 'ilike', '%' . $search . '%')
                    ->orwhere('v_unit_kerja.nama', 'ilike', '%' . $search . '%');
            })
            ->get());

        $endCount = $offset + $resultCount;
        $morePages = $tb_v_users_all_count > $endCount;

        // $html_option = "";
        // $html_option .= '<option value="' . '' . '">' . '' . '</option>';
        // foreach ($tb_v_users_all as $data) {
        //     $html_option .= '<option value="' . $data->username . '">' . $data->nama . '</option>';
        // }

        // return response()->json(['data' => $html_option]);

        $data_array = [];
        foreach ($tb_v_users_all as $data) {
            $data_array[] = array(

                'id' => $data->username,
                'text' => $data->nama . ' ( ' . $data->username . ' ) ' . ' ( ' . $data->v_unit_kerja_nama . ' ) '

            );
        }

        $results = array(
            "results" => $data_array,
            "results_count" => $morePages,
            // "pagination" => array(
            //     "more" => $morePages
            // ),
        );

        return response()->json($results);

        // return response()->json($tb_v_users_all);
    }

    public function kirimKomentar(Request $request)
    {

        // dd($request->all());
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_role = $get_session['role'];
        $get_session_nik = $get_session['nik'];
        $get_session_unitId = $get_session['unitId'];
        $get_session_username = $get_session['username'];

        $tiket_issues = $request->all()['tiket_issues_detail'];
        $komentar = strip_tags($request->all()['komentar_issues_detail'], '<div><b><i><u><a><img><strong><em><iframe>');
        if (menghitungCharacterExcludeTagHTML($komentar) <= 500) {
        } else {
            return response()->json(['success' => 'Tidak dapat menambah komentar, komentar tidak boleh lebih dari 500 karakter', 'kode' => 401]);
        }
        $tambah_issues_komentar = DB::table('issues_komentar')
            ->insert([
                'tiket_issues' => $tiket_issues,
                'komentar' => $komentar,
                'pegawai_nik' => $get_session_username,
                'created_at' => Carbon::now(),

            ]);

        tambah_issues_log($tiket_issues, $get_session_username . ' menambahkan komentar issues');

        return response()->json(['success' => 'Data Berhasil Dikirim', 'kode' => 201]);
    }

    public function tambahStatus(Request $request)
    {

        // dd($request->all());
        // dd($tiket_issues_detail);
        // dd($status_id . ' ' . $catatan);

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_role = $get_session['role'];
        $get_session_nik = $get_session['nik'];
        $get_session_unitId = $get_session['unitId'];
        $get_session_username = $get_session['username'];

        $tiket_issues_detail = $request->all()['tiket_issues_detail'];
        $status_id = $request->all()['status_id'];
        $catatan = strip_tags($request->all()['catatan']);

        // if ($status_id == 3) {
        //     if ($get_session_role == "R001" || $get_session_role == "R005") {
        //     } else {
        //         if ($get_session_role == "R003"){
        //             if($get_session_unitId == "PBD200"){

        //             }else{
        //                 return response()->json([
        //                     'success' => 'role anda tidak bisa melakukan update status issues menjadi done',
        //                     'kode' => 401,
        //                 ]);
        //             }
        //         }else{

        //         }
        //     }
        // }

        if (menghitungCharacterExcludeTagHTML($catatan) <= 500) {
        } else {
            return response()->json(['success' => 'Tidak dapat menambah isu, catatan tidak boleh lebih dari 500 karakter', 'kode' => 401]);
        }

        // dd($tiket_issues_detail);

        $get_status_terakhir_per_issues_id = get_status_terakhir_per_issues_id($tiket_issues_detail);

        // dd($get_status_terakhir_per_issues_id);

        if ($get_session_role == "R001") {

        }else if($get_session_role == "R002"){

        }else if($get_session_role == "R003"){
            if($get_session_unitId == 'PBD200'){

            }else{
                if($status_id == '1' || $status_id == '2'|| $status_id == '3' || $status_id == '6'){
                    return response()->json([
                        'success' => 'Anda tidak mempunyai akses ini',
                        'kode' => 401,
                    ]);
                }else{
    
                }
            }
            
        }else if($get_session_role == "R004"){

        }else if($get_session_role == "R005"){
            if($status_id == '6'){
                return response()->json([
                    'success' => 'Anda tidak mempunyai akses ini',
                    'kode' => 401,
                ]);
            }else{

            }
        }

        if ($get_status_terakhir_per_issues_id == $status_id) {
            return response()->json([
                'success' => 'Data Sudah Diupdate menjadi ' . status_issues_id_ke_text2(get_status_terakhir_per_issues_id($tiket_issues_detail)) .
                    ' oleh ' . get_status_created_by_terakhir_per_tiket_issues($tiket_issues_detail),
                'kode' => 401,
            ]);
        } else {

            if ($status_id == 4) {

                $get_issue_status_terakhir = DB::table('v_issues')
                    ->select(DB::raw('v_issues.*'))
                    ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                    ->orderBy('id', 'desc')
                    ->get()
                    ->first();

                if ($get_issue_status_terakhir->status == 6) {
                    return response()->json([
                        'success' => 'Isu harus dijadikan ' . status_issues_id_ke_text2(2) .
                            ' terlebih dahulu sebelum diupdate menjadi ' . status_issues_id_ke_text2($status_id),
                        'kode' => 401,
                    ]);
                }

                $query = DB::table('issues_status')
                    ->select(DB::raw('created_at'))
                    ->where('tiket_issues', '=', $tiket_issues_detail)
                    ->where('status', '=', 3)
                    ->orderBy('id', 'desc')
                    ->limit(1)
                    ->get();

                if (count($query) > 0) {
                    $tambah_issues_komentar = DB::table('issues_status')
                        ->insert([
                            'tiket_issues' => $tiket_issues_detail,
                            'status' => $status_id,
                            'catatan' => $catatan,
                            'created_at' => Carbon::now(),
                            'created_by' => $get_session_username,
                        ]);
                    app('App\Http\Controllers\notifikasiController')->createNotifikasi($status_id, $tiket_issues_detail);

                    $get_issue_setelah_tambah_issues = DB::table('v_issues')
                        ->select(DB::raw('v_issues.*'))
                        ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                        ->get()
                        ->first();

                    return response()->json([
                        'success' => 'Data Berhasil Dikirim',
                        'kode' => 201,
                        'tanggal_batas_issues' => $get_issue_setelah_tambah_issues->tanggal_batas_issues,
                        'tiket_issues' => status_issues_id_ke_text(get_status_terakhir_per_issues_id($tiket_issues_detail))
                    ]);
                } else {
                    // $tambah_issues_komentar = DB::table('issues_status')
                    //     ->insert([
                    //         'tiket_issues' => $tiket_issues_detail,
                    //         'status' => 3,
                    //         'catatan' => '',
                    //         'created_at' => Carbon::now(),
                    //         'created_by' => $get_session_username,
                    //     ]);

                    // $tambah_issues_komentar = DB::table('issues_status')
                    //     ->insert([
                    //         'tiket_issues' => $tiket_issues_detail,
                    //         'status' => $status_id,
                    //         'catatan' => $catatan,
                    //         'created_at' => Carbon::now(),
                    //         'created_by' => $get_session_username,
                    //     ]);

                    // return response()->json([
                    //     'success' => 'Data Berhasil Dikirim',
                    //     'kode' => 201,
                    //     'tiket_issues' => status_issues_id_ke_text(get_status_terakhir_per_issues_id($tiket_issues_detail))
                    // ]);

                    return response()->json([
                        'success' => 'Tiket Issue ( ' . $tiket_issues_detail . ' ) Harus di Done Terlebih Dahulu Oleh Admin',
                        'kode' => 401,
                        'tiket_issues' => status_issues_id_ke_text(get_status_terakhir_per_issues_id($tiket_issues_detail))
                    ]);
                }
            } else if ($status_id == 6) {

                $get_issue_status_terakhir = DB::table('v_issues')
                    ->select(DB::raw('v_issues.*'))
                    ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                    ->orderBy('id', 'desc')
                    ->get()
                    ->first();

                if ($get_issue_status_terakhir->status == 6) {
                    return response()->json([
                        'success' => 'Isu harus dijadikan ' . status_issues_id_ke_text2(2) .
                            ' terlebih dahulu sebelum diupdate menjadi ' . status_issues_id_ke_text2($status_id),
                        'kode' => 401,
                    ]);
                }

                $tambah_issues_komentar = DB::table('issues_status')
                    ->insert([
                        'tiket_issues' => $tiket_issues_detail,
                        'status' => $status_id,
                        'catatan' => $catatan,
                        'tanggal_onhold_start' => Carbon::now(),
                        // 'tanggal_onhold_end' => NULL,
                        'created_at' => Carbon::now(),
                        'created_by' => $get_session_username,
                    ]);

                $get_issue_setelah_tambah_issues = DB::table('v_issues')
                    ->select(DB::raw('v_issues.*'))
                    ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                    ->get()
                    ->first();

                app('App\Http\Controllers\notifikasiController')->createNotifikasi($status_id, $tiket_issues_detail);
                return response()->json([
                    'success' => 'Data Berhasil Dikirim',
                    'kode' => 201,
                    'tanggal_batas_issues' => $get_issue_setelah_tambah_issues->tanggal_batas_issues,
                    'tiket_issues' => status_issues_id_ke_text(get_status_terakhir_per_issues_id($tiket_issues_detail))
                ]);
            } else if ($status_id == 2) {


                $get_issue_status_terakhir = DB::table('v_issues')
                    ->select(DB::raw('v_issues.*'))
                    ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                    ->orderBy('id', 'desc')
                    ->get()
                    ->first();

                // dd($get_issue_status_terakhir);

                if ($get_issue_status_terakhir->status == 6) {
                    $issues_status_terakhir = DB::table('issues_status')
                        ->select(DB::raw('issues_status.*'))
                        ->where('issues_status.tiket_issues', '=', $tiket_issues_detail)
                        ->orderBy('issues_status.id', 'DESC')
                        ->take(1)
                        ->get()
                        ->first();
                    // dd($issues_status_terakhir);
                    DB::table('issues_status')
                        ->where('issues_status.id', '=', $issues_status_terakhir->id)
                        ->update([
                            'tanggal_onhold_end' => Carbon::now()
                        ]);

                    $issues_status_terakhir_setelah_progress = DB::table('issues_status')
                        ->select(DB::raw('issues_status.*'))
                        ->where('issues_status.tiket_issues', '=', $tiket_issues_detail)
                        ->orderBy('issues_status.id', 'DESC')
                        ->take(1)
                        ->get()
                        ->first();

                    $tambah_issues = DB::table('issues_status')
                        ->insert([
                            'tiket_issues' => $tiket_issues_detail,
                            'status' => $status_id,
                            'catatan' => $catatan,
                            // 'tanggal_onhold_end' => NULL,
                            'created_at' => Carbon::now(),
                            'created_by' => $get_session_username,
                        ]);

                    $get_issue_setelah_tambah_issues = DB::table('v_issues')
                        ->select(DB::raw('v_issues.*'))
                        ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                        ->get()
                        ->first();

                    // dd(onHoldTimer(
                    //     $issues_status_terakhir_setelah_progress->tanggal_onhold_start, 
                    //     $issues_status_terakhir_setelah_progress->tanggal_onhold_end, 
                    //     $get_issue_setelah_tambah_issues->tanggal_batas_issues));

                    DB::table('issues')
                        ->where('issues.tiket_issues', '=', $tiket_issues_detail)
                        ->update([
                            'tanggal_batas_issues' => onHoldTimer(
                                $issues_status_terakhir_setelah_progress->tanggal_onhold_start,
                                $issues_status_terakhir_setelah_progress->tanggal_onhold_end,
                                $get_issue_setelah_tambah_issues->tanggal_batas_issues
                            )
                        ]);

                    $get_issue_setelah_tambah_issues_2 = DB::table('v_issues')
                        ->select(DB::raw('v_issues.*'))
                        ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                        ->get()
                        ->first();

                    app('App\Http\Controllers\notifikasiController')->createNotifikasi($status_id, $tiket_issues_detail);
                    return response()->json([
                        'success' => 'Data Berhasil Dikirim',
                        'kode' => 201,
                        'tanggal_batas_issues' => $get_issue_setelah_tambah_issues_2->tanggal_batas_issues,
                        'tiket_issues' => status_issues_id_ke_text(get_status_terakhir_per_issues_id($tiket_issues_detail))
                    ]);
                } else {
                    $tambah_issues_komentar = DB::table('issues_status')
                        ->insert([
                            'tiket_issues' => $tiket_issues_detail,
                            'status' => $status_id,
                            'catatan' => $catatan,
                            // 'tanggal_onhold_end' => NULL,
                            'created_at' => Carbon::now(),
                            'created_by' => $get_session_username,
                        ]);

                    $get_issue_setelah_tambah_issues = DB::table('v_issues')
                        ->select(DB::raw('v_issues.*'))
                        ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                        ->get()
                        ->first();

                    app('App\Http\Controllers\notifikasiController')->createNotifikasi($status_id, $tiket_issues_detail);
                    return response()->json([
                        'success' => 'Data Berhasil Dikirim',
                        'kode' => 201,
                        'tanggal_batas_issues' => $get_issue_setelah_tambah_issues->tanggal_batas_issues,
                        'tiket_issues' => status_issues_id_ke_text(get_status_terakhir_per_issues_id($tiket_issues_detail))
                    ]);
                }
            } else {

                $get_issue_status_terakhir = DB::table('v_issues')
                    ->select(DB::raw('v_issues.*'))
                    ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                    ->orderBy('id', 'desc')
                    ->get()
                    ->first();

                if ($get_issue_status_terakhir->status == 6) {
                    return response()->json([
                        'success' => 'Isu harus dijadikan ' . status_issues_id_ke_text2(2) .
                            ' terlebih dahulu sebelum diupdate menjadi ' . status_issues_id_ke_text2($status_id),
                        'kode' => 401,
                    ]);
                }

                $tambah_issues_komentar = DB::table('issues_status')
                    ->insert([
                        'tiket_issues' => $tiket_issues_detail,
                        'status' => $status_id,
                        'catatan' => $catatan,
                        'created_at' => Carbon::now(),
                        'created_by' => $get_session_username,
                    ]);
                if ($status_id == 3) {
                    $issue = DB::table('issues')
                        ->select(DB::raw('issues.*'))
                        ->where('issues.tiket_issues', '=', $tiket_issues_detail)
                        ->get()
                        ->first();
                    $done = Carbon::now();
                    DB::table('issues')
                        ->where('issues.tiket_issues', '=', $tiket_issues_detail)
                        ->update([
                            'sla' => hitungSLA($issue->tanggal_pembuatan_issues, $issue->tanggal_batas_issues, $done, $status_id, $tiket_issues_detail)
                        ]);
                    //update kolom SLA
                }
                app('App\Http\Controllers\notifikasiController')->createNotifikasi($status_id, $tiket_issues_detail);

                $get_issue_setelah_tambah_issues = DB::table('v_issues')
                    ->select(DB::raw('v_issues.*'))
                    ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                    ->get()
                    ->first();

                return response()->json([
                    'success' => 'Data Berhasil Dikirim',
                    'kode' => 201,
                    'tanggal_batas_issues' => $get_issue_setelah_tambah_issues->tanggal_batas_issues,
                    'tiket_issues' => status_issues_id_ke_text(get_status_terakhir_per_issues_id($tiket_issues_detail))
                ]);
            }
        }
    }

    public function getDataLiburNasionalPerTahun(Request $request, $tahun)
    {
        // dd('coba');
        $m_libur_nasional = DB::table('m_libur_nasional')
            ->select(DB::raw("m_libur_nasional.*"))
            ->whereRaw("substr(m_libur_nasional.tgl_libur_nasional,1,4)::integer = $tahun")
            ->get();

        return response()->json(['data' => $m_libur_nasional]);
    }

    public function getDataLiburNasionalPerTahunDistinctTanggal(Request $request, $tahun)
    {
        // dd('coba');
        $m_libur_nasional = DB::table('m_libur_nasional')
            ->select(DB::raw("m_libur_nasional.tgl_libur_nasional"))
            ->whereRaw("substr(m_libur_nasional.tgl_libur_nasional,1,4)::integer = $tahun")
            ->distinct()
            ->get();

        return response()->json(['data' => $m_libur_nasional]);
    }

    public function getDataLiburNasionalPerTahunBetween(Request $request, $tanggal_awal, $tanggal_akhir)
    {
        // dd('coba');
        $m_libur_nasional = DB::table('m_libur_nasional')
            ->select(DB::raw("DISTINCT m_libur_nasional.tgl_libur_nasional"))
            ->whereBetween("m_libur_nasional.tgl_libur_nasional", [substr($tanggal_awal, 0, 10), substr($tanggal_akhir, 0, 10) . " 23:59:59"])
            ->get();

        return response()->json(['data' => $m_libur_nasional]);
    }

    public function getListDataRiwayatStatusIssues(Request $request, $tiket_issues)
    {

        // dd('coba');

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];
        $searchs = $request["search.value"];
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'searchs' => $searchs,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_role = $get_session['role'];
        $get_session_nik = $get_session['nik'];
        $get_session_unitId = $get_session['unitId'];

        if (validateSessionToken($get_session_token)) {
            $tb_issues_status = DB::select(DB::raw("select tb_1.* 
                from( select issues_status.tiket_issues,
                issues_status.status,
                issues_status.catatan,
                v_users_all.nama as nama_user,
                issues_status.created_at
                from issues_status
                left join v_users_all on v_users_all.username = issues_status.created_by
                UNION
                select issues_log.tiket_issues,
                '',
                issues_log.catatan,
                v_users_all.nama as nama_user,
                issues_log.created_at
                from issues_log
                left join v_users_all on v_users_all.username = issues_log.created_by ) as tb_1
                where tb_1.tiket_issues is not null
                and tb_1.tiket_issues = '$tiket_issues'
                ORDER BY created_at DESC
            "));

            // dd($tb_issues_status->get());

            // $total_data = $tb_issues_status->count();

            $m_status = $tb_issues_status;

            $datas = [];

            $no = $offset + 1;

            // $photo = "";
            $no_ckeditor = 0;

            if (count($m_status) > 0) {
                foreach ($m_status as $value) {
                    // dd($no_ckeditor++);
                    $datas[] = array(
                        'no' => '<div style="border: 0px; font-size:10px;">' . $no++ . '</div>',
                        'status' => status_issues_id_ke_text($value->status),
                        // 'catatan' => $value->catatan,
                        'catatan' => '<div style="border: 0px; font-size:10px; max-width:100%;" name="catatan_status_list_ckeditor' . $no_ckeditor . '" id="catatan_status_list_ckeditor' . $no_ckeditor . '" class="catatan_status_list_ckeditor' . $no_ckeditor . '" style="max-width:100%" >' . $value->catatan . '</div>',
                        'created_by' => '<div style="border: 0px; font-size:10px;">' . $value->nama_user . '</div>',
                        'created_at' => '<div style="border: 0px; font-size:10px;">' . $value->created_at . '</div>'
                    );

                    $no_ckeditor++;
                }
            } else {
                $datas = array();
            }

            // dd($datas);
            // $recordsTotal = is_null($total_data) ? 0 : $total_data;
            // $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "draw"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function getIssuesForward($tiket_issues)
    {
        // dd('coba');
        $issues_forward = DB::table('issues_forward')
            ->select(DB::raw("issues_forward.*"))
            ->where("issues_forward.tiket_issues", "=", $tiket_issues)
            ->get();
        // dd($issues_forward);

        $issues_forward_riwayat = DB::table('issues_forward_riwayat')
            ->select(DB::raw("issues_forward_riwayat.*, v_users_all.nama as v_users_all_nama"))
            ->where("issues_forward_riwayat.tiket_issues", "=", $tiket_issues)
            ->join('v_users_all', 'v_users_all.username', '=', 'issues_forward_riwayat.created_by')
            ->orderBy('issues_forward_riwayat.created_at', 'DESC')
            ->get();

        $data_pegawai_it = DB::table('pegawai')
            ->select(DB::raw("pegawai.*"))
            ->where('pegawai.unitid', '=', 'PBD200')
            ->get();

        $data_issues = DB::table('issues')
            ->select(DB::raw("issues.*"))
            ->where('issues.tiket_issues', '=', $tiket_issues)
            ->get()
            ->first();

        return response()->json([
            'data_issues_forward' => $issues_forward, 
            'data_issues_forward_riwayat' => $issues_forward_riwayat, 
            'data_pegawai_it' => $data_pegawai_it,
            'data_issues' => $data_issues
        ]);
    }

    public function postUpdateIssuesForward(Request $request)
    {
        // dd($request->all());
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_role = $get_session['role'];
        $get_session_nik = $get_session['nik'];
        $get_session_unitId = $get_session['unitId'];
        $get_session_username = $get_session['username'];
        $get_session_nama = $get_session['nama'];

        $pegawai_it_nik_count = is_null($request->pegawai_it_nik) ? 0 : count($request->pegawai_it_nik);
        // dd($pegawai_it_nik_count);
        // dd($request->pegawai_it_nik);
        // dd($get_session_role);
        // dd($pegawai_it_nik_count);
        if ($pegawai_it_nik_count == 0) {
            // dd('coba 1');

            if ($get_session_role == "R001") {

                $data_pegawai_it_sebelum_di_reset = DB::table('issues_forward')
                    ->select(DB::raw("issues_forward.*,v_users_all.nama as v_users_all_nama"))
                    ->join('v_users_all', 'v_users_all.username', '=', 'issues_forward.forward_username')
                    ->where('issues_forward.tiket_issues', '=', $request->tiket_issues_detail)
                    ->get();

                foreach ($data_pegawai_it_sebelum_di_reset as $data) {
                    $tambah_issues_forward = DB::table('issues_forward_riwayat')
                        ->insert([
                            'tiket_issues' => $request->tiket_issues_detail,
                            'riwayat' => "Admin Membatalkan Isu Ke " . $data->v_users_all_nama . " ( " . $data->forward_username . " ) ",
                            'created_by' => $get_session_username,
                            'created_at' => Carbon::now()
                        ]);
                }

                $delete_issues_forward = DB::table('issues_forward')
                    ->where('issues_forward.tiket_issues', '=', $request->tiket_issues_detail)
                    ->delete();

                if($request->tiket_cares != null){
                    $riwayat = "Admin Meneruskan Isu Ke Cares PI dengan nomor Cares PI " . $request->tiket_cares;
                    $update_nomor_cares_pi = DB::table('issues')
                        ->where('issues.tiket_issues', '=', $request->tiket_issues_detail)
                        ->update([
                            'tiket_cares_pi' => $request->tiket_cares,
                    ]);
                    $tambah_issues_forward = DB::table('issues_forward_riwayat')
                        ->insert([
                            'tiket_issues' => $request->tiket_issues_detail,
                            'riwayat' => $riwayat,
                            'created_by' => $get_session_username,
                            'created_at' => Carbon::now()
                        ]);
                }else{
                    $riwayat = "Admin Membatalkan Isu Cares PI";
                    $update_nomor_cares_pi = DB::table('issues')
                        ->where('issues.tiket_issues', '=', $request->tiket_issues_detail)
                        ->update([
                            'tiket_cares_pi' => $request->tiket_cares,
                    ]);
                    $tambah_issues_forward = DB::table('issues_forward_riwayat')
                        ->insert([
                            'tiket_issues' => $request->tiket_issues_detail,
                            'riwayat' => $riwayat,
                            'created_by' => $get_session_username,
                            'created_at' => Carbon::now()
                        ]);
                }

                

                return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
            } else if ($get_session_role == "R003") {

                $delete_issues_forward = DB::table('issues_forward')
                    ->where('issues_forward.tiket_issues', '=', $request->tiket_issues_detail)
                    ->delete();

                $tambah_issues_forward = DB::table('issues_forward_riwayat')
                    ->insert([
                        'tiket_issues' => $request->tiket_issues_detail,
                        'riwayat' => "Pegawai " . $get_session_nama . " ( " . $get_session_username . " ) " . "Mengembalikan Isu Ke Admin",
                        'created_by' => $get_session_username,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
            } else {
                // dd('coba');
            }
        } else {
            if ($get_session_role == "R001") {

                // dd('coba');
                // dd($pegawai_it_nik_count);
                // dd('coba 2');
                // dd($request->all());

                for ($i = 0; $i < $pegawai_it_nik_count; $i++) {

                    $data_pegawai_it_berdasarkan_nik = DB::table('pegawai')
                        ->select(DB::raw("pegawai.*"))
                        ->where('pegawai.nik', '=', $request->pegawai_it_nik[$i])
                        ->get();

                    if(count($data_pegawai_it_berdasarkan_nik) > 0){
                        $riwayat = "Admin Meneruskan Isu Ke " . $data_pegawai_it_berdasarkan_nik->first()->nama . " ( " . $request->pegawai_it_nik[$i] . " ) ";
                    
                        $cek_pegawai_di_tb_issues_forward = DB::table('issues_forward')
                        ->select(DB::raw("issues_forward.*"))
                        ->where('issues_forward.tiket_issues', '=', $request->tiket_issues_detail)
                        ->where('issues_forward.forward_username', '=', $request->pegawai_it_nik[$i])
                        ->get();

                        // dd($cek_pegawai_di_tb_issues_forward);

                        if (count($cek_pegawai_di_tb_issues_forward) > 0) {
                            
                        } else {
                            $tambah_issues_forward = DB::table('issues_forward_riwayat')
                            ->insert([
                                'tiket_issues' => $request->tiket_issues_detail,
                                'riwayat' => $riwayat,
                                'created_by' => $get_session_username,
                                'created_at' => Carbon::now()
                            ]);
                        }

                    }else{
                        
                    }
                    
                }

                $data_pegawai_it_sebelum_di_reset = DB::table('issues_forward')
                    ->select(DB::raw("issues_forward.*,v_users_all.nama as v_users_all_nama"))
                    ->join('v_users_all', 'v_users_all.username', '=', 'issues_forward.forward_username')
                    ->where('issues_forward.tiket_issues', '=', $request->tiket_issues_detail)
                    ->whereNotIn('issues_forward.forward_username', $request->pegawai_it_nik)
                    ->get();

                // dd($data_pegawai_it_sebelum_di_reset);

                foreach ($data_pegawai_it_sebelum_di_reset as $data) {
                    $tambah_issues_forward = DB::table('issues_forward_riwayat')
                        ->insert([
                            'tiket_issues' => $request->tiket_issues_detail,
                            'riwayat' => "Admin Membatalkan Isu Ke " . $data->v_users_all_nama . " ( " . $data->forward_username . " ) ",
                            'created_by' => $get_session_username,
                            'created_at' => Carbon::now()
                        ]);
                }

                $delete_issues_forward = DB::table('issues_forward')
                    ->where('issues_forward.tiket_issues', '=', $request->tiket_issues_detail)
                    ->delete();

                for ($j = 0; $j < $pegawai_it_nik_count; $j++) {

                    $tambah_issues_forward = DB::table('issues_forward')
                        ->insert([
                            'tiket_issues' => $request->tiket_issues_detail,
                            'forward_username' => $request->pegawai_it_nik[$j],
                            'created_at' => Carbon::now()
                        ]);
                }

                if($request->tiket_cares != null){
                    $riwayat = "Admin Meneruskan Isu Ke Cares PI dengan nomor Cares PI " . $request->tiket_cares;
                    $update_nomor_cares_pi = DB::table('issues')
                        ->where('issues.tiket_issues', '=', $request->tiket_issues_detail)
                        ->update([
                            'tiket_cares_pi' => $request->tiket_cares,
                    ]);
                    $tambah_issues_forward = DB::table('issues_forward_riwayat')
                        ->insert([
                            'tiket_issues' => $request->tiket_issues_detail,
                            'riwayat' => $riwayat,
                            'created_by' => $get_session_username,
                            'created_at' => Carbon::now()
                        ]);
                }else{
                    $riwayat = "Admin Membatalkan Isu Cares PI";
                    $update_nomor_cares_pi = DB::table('issues')
                        ->where('issues.tiket_issues', '=', $request->tiket_issues_detail)
                        ->update([
                            'tiket_cares_pi' => $request->tiket_cares,
                    ]);
                    $tambah_issues_forward = DB::table('issues_forward_riwayat')
                        ->insert([
                            'tiket_issues' => $request->tiket_issues_detail,
                            'riwayat' => $riwayat,
                            'created_by' => $get_session_username,
                            'created_at' => Carbon::now()
                        ]);
                }

            } else if ($get_session_role == "R003") {

                // dd('coba 3');

                $delete_issues_forward = DB::table('issues_forward')
                    ->where('issues_forward.tiket_issues', '=', $request->tiket_issues_detail)
                    ->delete();

                for ($i = 0; $i < $pegawai_it_nik_count; $i++) {
                    $tambah_issues_forward = DB::table('issues_forward')
                        ->insert([
                            'tiket_issues' => $request->tiket_issues_detail,
                            'forward_username' => $request->pegawai_it_nik[$i],
                            'created_at' => Carbon::now()
                        ]);

                    $data_pegawai_it_berdasarkan_nik = DB::table('pegawai')
                        ->select(DB::raw("pegawai.*"))
                        ->where('pegawai.nik', '=', $request->pegawai_it_nik[$i])
                        ->get();
                }

                $cek_pegawai_di_tb_issues_forward = DB::table('issues_forward')
                    ->select(DB::raw("issues_forward.*"))
                    ->where('issues_forward.tiket_issues', '=', $request->tiket_issues_detail)
                    ->where('issues_forward.forward_username', '=', $get_session_username)
                    ->get();

                if (count($cek_pegawai_di_tb_issues_forward) > 0) {
                } else {
                    $tambah_issues_forward = DB::table('issues_forward_riwayat')
                        ->insert([
                            'tiket_issues' => $request->tiket_issues_detail,
                            'riwayat' => "Pegawai " . $get_session_nama . " ( " . $get_session_username . " ) " . "Mengembalikan Isu Ke Admin",
                            'created_by' => $get_session_username,
                            'created_at' => Carbon::now()
                        ]);
                }
            } else {
                dd('kok iso nek kene');
            }

            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        }
    }

    public function surat_perjanjian_issues(Request $request, $tiket_issues)
    {
        // dd(public_path("image/ttd_contoh.png"));
        $get_session_users_id = Session::get('user_app')['users_id'];
        $get_session_token = Session::get('user_app')['token'];
        $get_session_nama = Session::get('user_app')['nama'];
        $get_session_username = Session::get('user_app')['username'];

        $get_issues = db::table('v_issues')
            ->select(DB::raw('v_issues.*, v_users_all.nama as v_users_all_nama, v_users_all.username as v_users_all_username'))
            ->where('v_issues.tiket_issues', '=', $tiket_issues)
            ->leftjoin('v_users_all', 'v_users_all.username', '=', 'v_issues.username_sap_issues')
            ->get()
            ->first();
        // $pdf_data = [];

        $pdf_data['tiket_issues'] = $tiket_issues;
        $pdf_data['username'] = $get_issues->v_users_all_username;;
        $pdf_data['nama'] = $get_issues->v_users_all_nama;
        $pdf_data['tanda_tangan'] = $get_issues->tanda_tangan;
        $pdf_data['tanda_tangan_2'] = $get_issues->tanda_tangan_2;
        $pdf_data['tanda_tangan_atas_nama'] = $get_issues->tanda_tangan_atas_nama;
        $pdf_data['tanda_tangan_2_atas_nama'] = $get_issues->tanda_tangan_2_atas_nama;

        // dd('coba');

        $options = array("format" => "A4", "defaultFont" => "arial");
        $pdf = PDF::loadView('pages.issues.surat_perjanjian_issues', $pdf_data, [], $options);
        $pdf->stream('usulan_kenaikan_pangkat_download.pdf');
    }

    public function surat_perjanjian_issues_bukan_inventaris_ti(Request $request, $tiket_issues)
    {
        // dd(public_path("image/ttd_contoh.png"));
        $get_session_users_id = Session::get('user_app')['users_id'];
        $get_session_token = Session::get('user_app')['token'];
        $get_session_nama = Session::get('user_app')['nama'];
        $get_session_username = Session::get('user_app')['username'];

        $get_issues = db::table('v_issues')
            ->select(DB::raw('v_issues.*, v_users_all.nama as v_users_all_nama, v_users_all.username as v_users_all_username'))
            ->where('v_issues.tiket_issues', '=', $tiket_issues)
            ->leftjoin('v_users_all', 'v_users_all.username', '=', 'v_issues.username_sap_issues')
            ->get()
            ->first();
        // $pdf_data = [];

        $pdf_data['tiket_issues'] = $tiket_issues;
        $pdf_data['username'] = $get_issues->v_users_all_username;;
        $pdf_data['nama'] = $get_issues->v_users_all_nama;
        $pdf_data['tanda_tangan'] = $get_issues->tanda_tangan;
        $pdf_data['tanda_tangan_2'] = $get_issues->tanda_tangan_2;
        $pdf_data['tanda_tangan_atas_nama'] = $get_issues->tanda_tangan_atas_nama;
        $pdf_data['tanda_tangan_2_atas_nama'] = $get_issues->tanda_tangan_2_atas_nama;

        // dd('coba');

        $options = array("format" => "A4", "defaultFont" => "arial");
        $pdf = PDF::loadView('pages.issues.surat_perjanjian_issues_bukan_inventaris_ti', $pdf_data, [], $options);
        $pdf->stream('usulan_kenaikan_pangkat_download.pdf');
    }

    public function update_tanda_tangan_surat_perjanjian_issues(Request $request)
    {
        // dd(public_path("image/ttd_contoh.png"));
        // dd($request->all());
        // dd($request->tiket_issues);
        $get_session_users_id = Session::get('user_app')['users_id'];
        $get_session_token = Session::get('user_app')['token'];

        if (validateSessionToken($get_session_token)) {

            $tanda_tangan = $request->tanda_tangan;
            $atas_nama = $request->atas_nama;

            if ($request->tanda_tangan_kategori == 1) {
                // dd('ini 1');
                $update_issues = DB::table('issues')
                    ->where('issues.tiket_issues', '=', $request->tiket_issues)
                    ->update([
                        'tanda_tangan' => $tanda_tangan,
                        'tanda_tangan_atas_nama' => $atas_nama
                    ]);
            } else if ($request->tanda_tangan_kategori == 2) {
                // dd($request->all());
                $update_issues = DB::table('issues')
                    ->where('issues.tiket_issues', '=', $request->tiket_issues)
                    ->update([
                        'tanda_tangan_2' => $tanda_tangan,
                        'tanda_tangan_2_atas_nama' => $atas_nama,
                    ]);
            }

            // dd($get_session_users_id);
            // dd($request->tiket_issues);



            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function get_tanda_tangan_surat_perjanjian_issues($tiket_issues)
    {
        // dd(public_path("image/ttd_contoh.png"));
        // dd($request->all());
        // dd($request->tiket_issues);
        $get_session_users_id = Session::get('user_app')['users_id'];
        $get_session_token = Session::get('user_app')['token'];

        if (validateSessionToken($get_session_token)) {

            $get_tandatangan_issues = db::table('v_issues')
                ->select(DB::raw('v_issues.tanda_tangan, v_issues.tanda_tangan_2'))
                ->where('v_issues.tiket_issues', '=', $tiket_issues)
                ->get()
                ->first();

            return response()->json(['success' => 'Data Berhasil Didapat', 'kode' => 201, 'get_tandatangan_issues' => $get_tandatangan_issues]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function postUpdateIssuesPriority(Request $request)
    {
        // dd(public_path("image/ttd_contoh.png"));
        // dd($request->all());
        // dd($request->tiket_issues);
        $get_session_users_id = Session::get('user_app')['users_id'];
        $get_session_token = Session::get('user_app')['token'];
        $get_session_username = Session::get('user_app')['username'];

        if (validateSessionToken($get_session_token)) {

            $priority_id_update = $request->priority_id_update;
            $perkiraan_selesai_y_m_d_detail = $request->perkiraan_selesai_y_m_d_detail;
            $tiket_issues_detail = $request->tiket_issues_detail;

            $get_issues = db::table('v_issues')
                ->select(DB::raw('v_issues.*'))
                ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
                ->get()
                ->first();

            $tanggal_sekarang = date('Y-m-d H:i:s');
            $tanggal_pembuatan_issues = $get_issues->tanggal_pembuatan_issues;
            $tanggal_jam_batas_update_pririy = date_create("$get_issues->tanggal_pembuatan_issues");
            date_add($tanggal_jam_batas_update_pririy, date_interval_create_from_date_string("1 hour"));
            
            $tanggal_jam_batas_update_pririy_final = date_format($tanggal_jam_batas_update_pririy, "Y-m-d H:i:s");
            
            if ($get_issues->batas_update_priority == 0 || $get_issues->batas_update_priority == "" || $get_issues->batas_update_priority == null) {
                return response()->json(['success' => 'Kesempatan Anda Mengganti Priority Sudah Habis', 'kode' => 401, 'append_html_priority_batas_mengganti' => ' ( kesempatan mengganti ' . '0' . ' x )']);
            } else {

                $update_issues = DB::table('issues')
                    ->where('issues.tiket_issues', '=', $tiket_issues_detail)
                    ->update([
                        'priority_id' => $priority_id_update,
                        'tanggal_batas_issues' => $perkiraan_selesai_y_m_d_detail,
                        'batas_update_priority' => $get_issues->batas_update_priority - 1
                    ]);

                tambah_issues_log($tiket_issues_detail, 
                $get_session_username . ' mengganti priority menjadi ' . get_nama_priority($priority_id_update));

                return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201, 'append_html_priority_batas_mengganti' => ' ( kesempatan mengganti ' . '0' . ' x )']);
            }

        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function postUpdateIssuesLayananDanSubject(Request $request)
    {
        $get_session_token = Session::get('user_app')['token'];
        $get_session_username = Session::get('user_app')['username'];

        if (validateSessionToken($get_session_token)) {

            $m_kategori_id_edit = $request->m_kategori_id_edit;
            $m_layanan_id_edit = $request->m_layanan_id_edit;
            $m_subject_id_edit = $request->m_subject_id_edit;
            $tiket_issues_detail = $request->tiket_issues_detail;

            $update_issues = DB::table('issues')
                ->where('issues.tiket_issues', '=', $tiket_issues_detail)
                ->update([
                    'kategori_id' => $m_kategori_id_edit,
                    'layanan_id' => $m_layanan_id_edit,
                    'subject_id' => $m_subject_id_edit,
                ]);

            tambah_issues_log($tiket_issues_detail, 
            $get_session_username . ' mengganti kategori / layanan / subject');

            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);

        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function getPutSessionTiketIssuesSearch(Request $request)
    {

        $get_session_username = Session::get('user_app')['username'];
        $get_session_token = Session::get('user_app')['token'];

        $id_notif = $request->id_notif != '' ? $request->id_notif : '';
        $tiket_issues = $request->tiket_issues != '' ? $request->tiket_issues : '';

        // dd($id_mapping_notif);

        // $tiket_issues = $request->tiket_issues;
        Session::put('tiket_issues_search', $tiket_issues);

        $update_mapping_notifikasi = DB::table('mapping_notifikasi')
            ->where('mapping_notifikasi.id', '=', $id_notif)
            ->where('mapping_notifikasi.id_penerima', '=', $get_session_username)
            ->update([
                'status' => 1
            ]);

        // $get_tiket_issues_search_seesion = Session::get('tiket_issues_search');
        // dd(url()->current());
        // dd($get_tiket_issues_search_seesion);
        // dd(Request::url());
        // return \Redirect::to(url());
        // URL::to('/issues/index');
        // echo url('/issues/index');
        return Redirect::to(url('/issues/index'));
    }

    public function getPriorityRefreshKembali($tiket_issues_detail)
    {

        $get_session_username = Session::get('user_app')['username'];
        $get_session_token = Session::get('user_app')['token'];

        $data_issues = db::table('v_issues')
            ->select(DB::raw('v_issues.*'))
            ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
            ->get()
            ->first();

        return response()->json(['success' => '', 'kode' => 201, 'data' => $data_issues]);
    }

    public function getLayananDanSubjectfreshKembali($tiket_issues_detail)
    {

        $get_session_username = Session::get('user_app')['username'];
        $get_session_token = Session::get('user_app')['token'];

        $data_issues = db::table('v_issues')
            ->select(DB::raw('v_issues.*'))
            ->where('v_issues.tiket_issues', '=', $tiket_issues_detail)
            ->get()
            ->first();

        return response()->json(['success' => '', 'kode' => 201, 'data' => $data_issues]);
    }

    public function download_qr_code_issues($tiket_issues)
    {

        $data_issues = db::table('v_issues')
            ->select(DB::raw('v_issues.tiket_issues_duplikat'))
            ->where('v_issues.tiket_issues', '=', $tiket_issues)
            ->get()
            ->first();

        $qrcode = base64_encode(QrCode::format('png')
            ->merge(public_path('image/Petro_logo.png'), 0.7, true)
            ->backgroundColor(255, 55, 0)
            ->margin(3)
            ->size(150)->errorCorrection("H")
            ->generate($data_issues->tiket_issues_duplikat));

        $file = "data:image/png;base64," . $qrcode;

        // dd($file);

        // $headers = array(
        //     'Content-Type: application/png',
        // );

        // return Response::download($file, "$tiket_issues.png", $headers);
        // dd(file_get_contents($file));
        $path       = public_path('temp_qr');
        $contents   = base64_decode($qrcode);
        // dd($path);

        //store file temporarily
        file_put_contents($path, $contents);

        //download file and delete it
        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function tambahFileIssuesModal(Request $request)
    {
        // dd($request->all());
        $get_session = Session::get('user_app');
        $get_session_username = $get_session['username'];

        $get_tiket_issues = $request->tiket_issues;
        $get_file_upload = $request->file_upload;
        $filename_dengan_extension = $get_file_upload->getClientOriginalName();
        $filename_tanpa_extension = pathinfo($filename_dengan_extension, PATHINFO_FILENAME);

        $filepath = $get_tiket_issues . '_' . $filename_tanpa_extension . '_' . rand(1000, 9999) . '.' . $get_file_upload->getClientOriginalExtension();

        //file pada folder file_lampiran_usulan_kenaikan_pangkat di delete terlebih dahulu
        $file_delete = public_path() . '/file_issues/' . $filepath;
        File::delete($file_delete);

        //setelah file di folder file_lampiran_usulan_kenaikan_pangkat sudah di delete baru dimasukan file yang baru
        $destinationPath = public_path() . '/file_issues/';
        $get_file_upload->move($destinationPath, $filepath);

        tambah_issues_log($get_tiket_issues, $get_session_username . ' menambahkan file ' . $filepath);

        $tambah_issues_file = DB::table('issues_file')
            ->insert([
                'issues_tiket' => $get_tiket_issues,
                'file_name' => $filepath,
                'file_extension' => $get_file_upload->getClientOriginalExtension(),
                'created_at' => Carbon::now()
            ]);

        return response()->json(['success' => 'Anda Berhasil Menambahkan File Issues', 'kode' => 201]);
    }

    public function getFileIssuesModal(Request $request)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_role = $get_session['role'];
        $get_session_nik = $get_session['nik'];
        $get_session_unitId = $get_session['unitId'];
        $get_session_username = $get_session['username'];

        $get_issues_file = DB::table('issues_file')
            ->select(DB::raw("issues_file.*"))
            ->where('issues_file.issues_tiket', '=', $request->tiket_issues)
            ->get();

        $issues_link_array = '';

        foreach ($get_issues_file as $value_2) {

            if ($get_session_role == 'R001') {
                $issues_link_array .=
                    '<div class="row">' .
                    '<div class="col-md-10">' .
                    '<a href="download_file/' . $value_2->file_name . '" target="_blank">' . $value_2->file_name . '</a>' .
                    '</div>' .
                    '<div class="col-md-2 text-right">' .
                    '<button type="button" data-issues_file_id="' . $value_2->id . '" data-tiket_issues="' . $value_2->issues_tiket . '" id="delete_file_issues_modal" name="delete_file_issues_modal" class="btn btn-md btn-danger m-1 delete_file_issues_modal float-right"><i class="mdi mdi-close"></i></button>' .
                    '</div>' .
                    '</div>' .
                    '<br>';
            } else {
                $issues_link_array .=
                    '<div class="row">' .
                    '<div class="col-md-10">' .
                    '<a href="download_file/' . $value_2->file_name . '" target="_blank">' . $value_2->file_name . '</a>' .
                    '</div>' .
                    '</div>' .
                    '<br>';
            }
        }

        return response()->json(['success' => 'Anda Berhasil Menambahkan File Issues', 'kode' => 201, 'issues_link_array' => $issues_link_array]);
    }

    public function deleteFileIssuesModal(Request $request)
    {
        $get_session = Session::get('user_app');
        $get_session_username = $get_session['username'];

        $issues_file_id = $request->issues_file_id;

        $get_issues_file = DB::table('issues_file')
            ->select(DB::raw("issues_file.*"))
            ->where('issues_file.id', '=', $issues_file_id)
            ->get();

        tambah_issues_log($get_issues_file->first()->issues_tiket, 
        $get_session_username . ' menghapus file ' . $get_issues_file->first()->file_name);

        $delete_issues = DB::table('issues_file')
            ->where('issues_file.id', '=', $issues_file_id)
            ->delete();

        return response()->json(['success' => 'Anda Berhasil Menghapus File Issues', 'kode' => 201]);
    }

    public function securityincidentupdate(Request $request){
        $get_session = Session::get('user_app');
        $get_session_username = $get_session['username'];

        $tiketisu = $request->tiket_issues_detail;
        $status = $request->status;

        $update_incident_issue = DB::table('issues')
            ->where('tiket_issues', '=', $tiketisu)
            ->update([
                'security_incident' => $status
            ]);

        if($status == 'true'){
            tambah_issues_log($tiketisu, 
            $get_session_username . ' menambah kategori Security Incident');
        }else{
            tambah_issues_log($tiketisu, 
            $get_session_username . ' menghapus kategori Security Incident');
        }

        return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
    }

    public function majorincidentupdate(Request $request){
        $get_session = Session::get('user_app');
        $get_session_username = $get_session['username'];

        $tiketisu = $request->tiket_issues_detail;
        $status = $request->status;

        $update_incident_issue = DB::table('issues')
            ->where('tiket_issues', '=', $tiketisu)
            ->update([
                'major_incident' => $status
            ]);

        if($status == 'true'){
            tambah_issues_log($tiketisu, 
            $get_session_username . ' menambah kategori Major Incident');
        }else{
            tambah_issues_log($tiketisu, 
            $get_session_username . ' menghapus kategori Major Incident');
        }

        return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
    }

    public function getLiburNasional()
    {
        $m_libur_nasional = DB::table('m_libur_nasional')
            ->select(DB::raw("m_libur_nasional.*"))
            ->get();

        return response()->json(['kode' => 201, 'success' => 'Data Berhasil Dikirim', 'data' => $m_libur_nasional]);
    }
}
