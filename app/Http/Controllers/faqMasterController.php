<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Str;
use Illuminate\Support\Carbon;

class faqMasterController extends Controller
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
        $data['judul'] = "Manage Kategori";
        $data['m_faq'] = DB::table('m_faq')
            ->select(DB::raw("m_faq.*"))
            ->get();

        $data['m_flag'] = DB::table('m_flag')
            ->select(DB::raw("m_flag.*"))
            ->get();

        return view('pages.faq_master.index', $data);
    }

    public function getDataFaq(Request $request)
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
            $tb_m_faq = DB::table('m_faq')
                ->select(DB::raw("m_faq.*"));

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_m_faq->count();


            $m_faq = $tb_m_faq
                ->limit($limit)
                ->offset($offset)
                ->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_faq) > 0) {

                foreach ($m_faq as $value) {
                    // dd($value['nama']);

                    $datas[] = array(

                        'no' => $no++,
                        'nama_faq' => $value->nama_faq,
                        'aksi' =>
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditFaq"
                        data-kategori_id="' . $value->id . '" 
                        data-nama_faq="' . $value->nama_faq . '" 
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit </button>' .
                            '<button type="button" name="delete" id="delete" data-m_faq_id="' . $value->id . '" class="btn btn-danger btn-xs mb-1 me-1" href=' . '' . '><i class="mdi mdi-trash-can"></i> Hapus </button>' .
                            '<a type="button" name="detail_faq" id="detail_faq" data-m_faq_id="' . $value->id . '" class="btn btn-warning btn-xs mb-1 me-1" href=' . "indexDetail/$value->id" . '><i class="mdi mdi-eye"></i> Detail Faq </a>'
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
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_users_id = $get_session['users_id'];

        $nama_faq = $request->nama_faq;
        $no = $request->no;
        $uuid = Str::uuid();

        $tambah_m_faq = DB::table('m_faq')
            ->insert([
                'id' => $uuid,
                'nama_faq' => $nama_faq,
                'no' => $no,
                'created_at' => Carbon::now(),
                'created_by' => $get_session_users_id
            ]);
        return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
    }

    public function delete(Request $request, $id)
    {
        // dd($id);
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $delete_m_faq = DB::table('m_faq')
                ->where('m_faq.id', '=', $id)
                ->delete();

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function indexDetail($faq_id)
    {
        $data['judul'] = "Manage Kategori";
        $data['m_faq'] = DB::table('m_faq')
            ->select(DB::raw("m_faq.*"))
            ->where('m_faq.id', '=', $faq_id)
            ->get()
            ->first();

        // dd($faq_id);

        $data['m_flag'] = DB::table('m_flag')
            ->select(DB::raw("m_flag.*"))
            ->get();

        return view('pages.faq_master_detail.index', $data);
    }

    public function getDataFaqDetail(Request $request)
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

        $m_faq_id = $request->m_faq_id;

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {
            $tb_m_faq_detail = DB::table('m_faq_detail')
                ->select(DB::raw("m_faq_detail.*"))
                ->where('m_faq_detail.m_faq_id', '=', $m_faq_id);

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_m_faq_detail->count();


            $m_faq = $tb_m_faq_detail
                ->limit($limit)
                ->offset($offset)
                ->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_faq) > 0) {

                foreach ($m_faq as $value) {
                    // dd($value['nama']);

                    $datas[] = array(

                        'no' => $no++,
                        'nama_faq_detail' => $value->nama_faq_detail,
                        'deskripsi_faq_detail' => $value->deskripsi_faq_detail,
                        'deskripsi_faq_detail_quill' =>
                        '<div name="deskripsi_faq_detail_quill_datatable" id="deskripsi_faq_detail_quill_datatable" class="deskripsi_faq_detail_quill_datatable" style="height: 350px;">' .
                            $value->deskripsi_faq_detail .
                            '</div>',
                        'aksi' =>
                        // '<button type="button" name="edit" id="edit" 
                        // class="btn btn-primary waves-effect waves-light mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditFaq"
                        // data-kategori_id="' . $value->id . '" 
                        // data-nama_faq_detail="' . $value->nama_faq_detail . '" 
                        // > <i class="mdi mdi-square-edit-outline"></i> Edit </button>' .
                            '<button type="button" name="delete" id="delete" data-m_faq_detail_id="' . $value->id . '" class="btn btn-danger btn-xs mb-1 me-1" href=' . '' . '><i class="mdi mdi-trash-can"></i> Hapus </button>'
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

    public function tambahDetail(Request $request)
    {
        // dd($request->all());
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_users_id = $get_session['users_id'];

        $nama_faq_detail = $request->nama_faq_detail;
        $deskripsi_faq_detail = $request->deskripsi_faq_detail;
        $id_faq = $request->id_faq;
        $no = $request->no;
        $uuid = Str::uuid();

        $tambah_m_faq_detail = DB::table('m_faq_detail')
            ->insert([
                'id' => $uuid,
                'nama_faq_detail' => $nama_faq_detail,
                'deskripsi_faq_detail' => $deskripsi_faq_detail,
                'no' => $no,
                'created_at' => Carbon::now(),
                'created_by' => $get_session_users_id,
                'm_faq_id' => $id_faq,
            ]);
        return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
    }

    public function deleteDetail(Request $request, $id)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $delete_m_faq_detail = DB::table('m_faq_detail')
                ->where('m_faq_detail.id', '=', $id)
                ->delete();

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }
}
