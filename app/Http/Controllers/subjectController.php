<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class subjectController extends Controller
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
        $data['judul'] = "Manage Subject";
        $data['m_kategori'] = DB::table('m_kategori')
            ->select(DB::raw("m_kategori.*"))
            ->get();

        $data['m_layanan'] = DB::table('m_layanan')
            ->select(DB::raw("m_layanan.*"))
            ->get();

        return view('pages.subject.index', $data);
    }

    public function getDataSubject(Request $request)
    {

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

        if (validateSessionToken($get_session_token)) {
            $tb_m_subject = DB::table('m_subject')
                ->select(DB::raw("m_subject.*, 
                m_layanan.id as m_layanan_id, m_layanan.nama_layanan, m_layanan.jam_layanan, m_layanan.deskripsi_layanan,
                m_kategori.id as m_kategori_id, m_kategori.nama_kategori"))
                ->leftjoin('m_layanan', 'm_layanan.id', '=', 'm_subject.m_layanan_id')
                ->leftjoin('m_kategori', 'm_kategori.id', '=', 'm_subject.m_kategori_id');

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_m_subject->count();


            $m_subject = $tb_m_subject
                ->limit($limit)
                ->offset($offset)
                ->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_subject) > 0) {

                foreach ($m_subject as $value) {
                    // dd($value['nama']);

                    if($value->status_aktif == true){
                        $status_checked = "checked";
                    }else{
                        $status_checked = "";
                    }

                    $datas[] = array(

                        'no' => $no++,
                        'nama_kategori' => $value->nama_kategori,
                        'nama_layanan' => $value->nama_layanan,
                        'jam_layanan' => $value->jam_layanan,
                        'deskripsi_layanan' => $value->deskripsi_layanan,
                        'nama_subject' => $value->nama_subject,
                        'kategori_subject' => $value->kategori_subject,
                        'template_subject' => $value->template_subject,
                        'response_time_sla_subject' => $value->response_time_sla_subject,
                        'resolution_time_sla_subject' => $value->resolution_time_sla_subject,
                        'aksi' =>
                        '<table>' .
                        '<tr>' .
                        '<td>' .
                        '<div class="form-switch">
                            <input class="form-check-input" ' . $status_checked . ' data-subject_id="' . $value->id . '" type="checkbox" role="switch" id="status_aktif" name="status_aktif" style="width:55px; height:30px; margin-bottom:8px; margin-right:8px;">
                        </div>'.
                        '</td>' .
                        '<td>' .
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modalFormEditSubject"

                        data-kategori_id="' . $value->m_kategori_id . '" 

                        data-layanan_id="' . $value->m_layanan_id . '" 
                        data-nama_layanan="' . $value->nama_layanan . '"                        
                        data-jam_layanan="' . $value->jam_layanan . '" 
                        data-deskripsi_layanan="' . $value->deskripsi_layanan . '" 

                        data-subject_id="' . $value->id . '"
                        data-nama_subject="' . $value->nama_subject . '"
                        data-kategori_subject="' . $value->kategori_subject . '"
                        data-template_subject="' . $value->template_subject . '"
                        data-response_time_sla_subject="' . $value->response_time_sla_subject . '"
                        data-resolution_time_sla_subject="' . $value->resolution_time_sla_subject . '"
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit </button> &nbsp;'.
                        // '<button type="button" name="delete" id="delete" data-subject_id="' . $value->id . '" class="me-1 mb-1 btn btn-danger btn-xs" href=' . '' . '><i class="mdi mdi-trash-can"></i> Hapus </button>'
                        '</td>' .
                        '</tr>' .
                        '</table>'
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

    public function tambah(Request $request)
    {
        // dd('coba');
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $kategori_id = $request->kategori_id;
        $layanan_id = $request->layanan_id;
        $nama_subject = $request->nama_subject;
        $kategori_subject = $request->kategori_subject;
        $template_subject = $request->template_subject;
        $response_time_sla_subject = $request->response_time_sla_subject;
        $resolution_time_sla_subject = $request->resolution_time_sla_subject;

        if (validateSessionToken($get_session_token)) {
            $tb_m_subject = DB::table('m_subject')
                ->select(DB::raw("m_subject.*"))
                ->get();

            $tb_m_subject_count = count($tb_m_subject);

            // return response()->json($tb_m_subject_count);

            if ($tb_m_subject_count == 0) {
                $tambah_subject = DB::table('m_subject')
                    ->insert([
                        'id' => 'S001',
                        'm_kategori_id' => $kategori_id,
                        'm_layanan_id' => $layanan_id,
                        'nama_subject' => $nama_subject,
                        'kategori_subject' => $kategori_subject,
                        'template_subject' => $template_subject,
                        'response_time_sla_subject' => $response_time_sla_subject,
                        'resolution_time_sla_subject' => $resolution_time_sla_subject,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            } else {

                $tb_m_subject_get_id_terakhir = DB::table('m_subject')
                    ->select(DB::raw("m_subject.*"))
                    ->orderby('m_subject.id', 'DESC')
                    // ->limit(1)
                    ->get()
                    ->first();

                // return response()->json($tb_m_subject_get_id_terakhir->id);

                $tambah_subject = DB::table('m_subject')
                    ->insert([
                        'id' => next_value($tb_m_subject_get_id_terakhir->id),
                        'm_kategori_id' => $kategori_id,
                        'm_layanan_id' => $layanan_id,
                        'nama_subject' => $nama_subject,
                        'kategori_subject' => $kategori_subject,
                        'template_subject' => $template_subject,
                        'response_time_sla_subject' => $response_time_sla_subject,
                        'resolution_time_sla_subject' => $resolution_time_sla_subject,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            }

            return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function update(Request $request)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $subject_id_edit = $request->subject_id_edit;
        $kategori_id_edit = $request->kategori_id_edit;
        $layanan_id_edit = $request->layanan_id_edit;
        $nama_subject_edit = $request->nama_subject_edit;
        $kategori_subject_edit = $request->kategori_subject_edit;
        $template_subject_edit = $request->template_subject_edit;
        $response_time_sla_subject_edit = $request->response_time_sla_subject_edit;
        $resolution_time_sla_subject_edit = $request->resolution_time_sla_subject_edit;

        if (validateSessionToken($get_session_token)) {
            // $layanan_id_edit = $request->layanan_id_edit;
            // $nama_layanan_edit = $request->nama_layanan_edit;

            $update_m_subject = DB::table('m_subject')
                ->where('m_subject.id', '=', $subject_id_edit)
                ->update([
                    // 'm_kategori_id' => $kategori_id_edit,
                    // 'm_layanan_id' => $layanan_id_edit,
                    'nama_subject' => $nama_subject_edit,
                    'kategori_subject' => $kategori_subject_edit,
                    'template_subject' => $template_subject_edit,
                    'response_time_sla_subject' => $response_time_sla_subject_edit,
                    'resolution_time_sla_subject' => $resolution_time_sla_subject_edit,
                    'updated_at' => Carbon::now()
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

            $delete_m_subject = DB::table('m_subject')
                ->where('m_subject.id', '=', $id)
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
                ->get();

            $html_option = "";

            foreach ($get_m_layanan as $data) {
                $html_option .= '<option value="' . $data->id . '">' . $data->nama_layanan . '</option>';
            }

            return response()->json(['data' => $html_option]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function getDataSubjectBy(Request $request)
    {
        $nama_kategori = $request->nama_kategori;
        $nama_layanan = $request->nama_layanan;
        $jam_layanan = $request->jam_layanan;
        $deskripsi_layanan = $request->deskripsi_layanan;
        $nama_subject = $request->nama_subject;
        $kategori_subject = $request->kategori_subject;
        $template_subject = $request->template_subject;
        $response_time_sla_subject = $request->response_time_sla_subject;
        $resolution_time_sla_subject = $request->resolution_time_sla_subject;

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {
            $query = DB::table('m_subject')
                ->select(DB::raw("m_subject.*, 
                m_layanan.id as m_layanan_id, m_layanan.nama_layanan, m_layanan.jam_layanan, m_layanan.deskripsi_layanan,
                m_kategori.id as m_kategori_id, m_kategori.nama_kategori"))
                ->leftJoin('m_layanan', 'm_layanan.id', '=', 'm_subject.m_layanan_id')
                ->leftJoin('m_kategori', 'm_kategori.id', '=', 'm_subject.m_kategori_id')
                ->Where(function ($query) use (
                    $nama_kategori,
                    $nama_layanan,
                    $jam_layanan,
                    $deskripsi_layanan,
                    $nama_subject,
                    $kategori_subject,
                    $template_subject,
                    $response_time_sla_subject,
                    $resolution_time_sla_subject
                ) {
                    is_null($nama_kategori) || $nama_kategori == '' ?: $query->where('m_kategori.nama_kategori', 'ilike', '%' . $nama_kategori . '%');
                    is_null($nama_layanan) || $nama_layanan == '' ?: $query->where('m_layanan.nama_layanan', 'ilike', '%' . $nama_layanan . '%');
                    is_null($jam_layanan) || $jam_layanan == '' ?: $query->where('m_layanan.jam_layanan', 'ilike', '%' . $jam_layanan . '%');
                    is_null($deskripsi_layanan) || $deskripsi_layanan == '' ?: $query->where('m_layanan.deskripsi_layanan', 'ilike', '%' . $deskripsi_layanan . '%');
                    is_null($nama_subject) || $nama_subject == '' ?: $query->where('m_subject.nama_subject', 'ilike', '%' . $nama_subject . '%');
                    is_null($kategori_subject) || $kategori_subject == '' ?: $query->where('m_subject.kategori_subject', 'ilike', '%' . $kategori_subject . '%');
                    is_null($template_subject) || $template_subject == '' ?: $query->where('m_subject.template_subject', 'ilike', '%' . $template_subject . '%');
                    is_null($response_time_sla_subject) || $response_time_sla_subject == '' ?: $query->where('m_subject.response_time_sla_subject', 'ilike', '%' . $response_time_sla_subject . '%');
                    is_null($resolution_time_sla_subject) || $resolution_time_sla_subject == '' ?: $query->where('m_subject.resolution_time_sla_subject', 'ilike', '%' . $resolution_time_sla_subject . '%');
                });

            $total_data = $query->count();
            $m_subject = $query
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];
            $no = $offset + 1;

            if (count($m_subject) > 0) {
                foreach ($m_subject as $value) {

                    if($value->status_aktif == true){
                        $status_checked = "checked";
                    }else{
                        $status_checked = "";
                    }
                    
                    $datas[] = array(
                        'no' => $no++,
                        'nama_kategori' => $value->nama_kategori,
                        'nama_layanan' => $value->nama_layanan,
                        'jam_layanan' => $value->jam_layanan,
                        'deskripsi_layanan' => $value->deskripsi_layanan,
                        'nama_subject' => $value->nama_subject,
                        'kategori_subject' => $value->kategori_subject,
                        'template_subject' => $value->template_subject,
                        'response_time_sla_subject' => $value->response_time_sla_subject,
                        'resolution_time_sla_subject' => $value->resolution_time_sla_subject,
                        'aksi' =>
                        '<table>' .
                        '<tr>' .
                        '<td>' .
                        '<div class="form-switch">
                            <input class="form-check-input" ' . $status_checked . ' data-subject_id="' . $value->id . '" type="checkbox" role="switch" id="status_aktif" name="status_aktif" style="width:55px; height:30px; margin-bottom:8px; margin-right:8px;">
                        </div>'.
                        '</td>' .
                        '<td>' .
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modalFormEditSubject"

                        data-kategori_id="' . $value->m_kategori_id . '" 

                        data-layanan_id="' . $value->m_layanan_id . '" 
                        data-nama_layanan="' . $value->nama_layanan . '"                        
                        data-jam_layanan="' . $value->jam_layanan . '" 
                        data-deskripsi_layanan="' . $value->deskripsi_layanan . '" 

                        data-subject_id="' . $value->id . '"
                        data-nama_subject="' . $value->nama_subject . '"
                        data-kategori_subject="' . $value->kategori_subject . '"
                        data-template_subject="' . $value->template_subject . '"
                        data-response_time_sla_subject="' . $value->response_time_sla_subject . '"
                        data-resolution_time_sla_subject="' . $value->resolution_time_sla_subject . '"
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit </button> &nbsp;'.
                        // '<button type="button" name="delete" id="delete" data-subject_id="' . $value->id . '" class="me-1 mb-1 btn btn-danger btn-xs"><i class="mdi mdi-trash-can"></i> Hapus </button>'
                        '</td>' .
                        '</tr>' .
                        '</table>'
                    );
                }
            } else {
                $datas = array();
            }

            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        }
    }

    public function updateStatusSubjectAktif(Request $request)
    {
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        // dd($request->all());

        $subject_id = $request->subject_id;
        $status_aktif = $request->status_aktif;

        if (validateSessionToken($get_session_token)) {

            $update_m_subject = DB::table('m_subject')
                ->where('m_subject.id', '=', $subject_id)
                ->update([
                    'status_aktif' => $status_aktif,
                ]);

            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }
}
