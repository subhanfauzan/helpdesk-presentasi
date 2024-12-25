<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class faqController extends Controller
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
        $data['judul'] = "Master Faq";

        return view('pages.faq.index', $data);
    }

    public function getDataFaqDatatable(Request $request)
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
                        'nama_faq' =>
                        '<li class="nav-item">
                                <a class="nav-link navi active" id="menu" data-bs-toggle="pill" href="#about-helpdesk" aria-expanded="true" role="tab">
                                    <span class="fw-bold">' . $value->nama_faq . '</span>
                                </a>
                        </li>',
                        'aksi' =>
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditFaq"
                        data-kategori_id="' . $value->id . '" 
                        data-nama_faq="' . $value->nama_faq . '" 
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit </button>' .
                            '<button type="button" name="delete" id="delete" data-kategori_id="' . $value->id . '" class="btn btn-danger btn-xs mb-1 me-1" href=' . '' . '><i class="mdi mdi-trash-can"></i> Hapus </button>' .
                            '<a type="button" name="detail_faq" id="detail_faq" data-kategori_id="' . $value->id . '" class="btn btn-warning btn-xs mb-1 me-1" href=' . "indexDetail/$value->id" . '><i class="mdi mdi-eye"></i> Detail Faq </a>'
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

    public function getDataFaqDetailDatatable(Request $request)
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
            $tb_m_faq_detail = DB::table('m_faq_detail')
                ->select(DB::raw("m_faq_detail.*"))
                // ->where('m_faq_detail.m_faq_id', '=', $faq_id)
            ;

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
                        'aksi' =>
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditFaq"
                        data-kategori_id="' . $value->id . '" 
                        data-nama_faq_detail="' . $value->nama_faq_detail . '" 
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit </button>' .
                            '<button type="button" name="delete" id="delete" data-kategori_id="' . $value->id . '" class="btn btn-danger btn-xs mb-1 me-1" href=' . '' . '><i class="mdi mdi-trash-can"></i> Hapus </button>'
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

    public function getDataFaq()
    {
        $tb_m_faq = DB::table('m_faq')
            ->select(DB::raw("m_faq.*"))
            ->get();

        return response()->json(['data' => $tb_m_faq, 'kode' => 201]);
    }

    public function getDataFaqDetail()
    {
        $tb_m_faq = DB::table('m_faq')
            ->select(DB::raw("m_faq.*"))
            ->get();

        $m_faq_detail = DB::table('m_faq_detail')
            ->select(DB::raw("m_faq_detail.*"))
            ->get();

        return response()->json(['data_m_faq_detail' => $m_faq_detail, 'data_m_faq' => $tb_m_faq, 'kode' => 201]);
    }
}
