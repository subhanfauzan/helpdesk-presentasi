<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class mappingMenuController extends Controller
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
        // dd('coba');
        $data['judul'] = "Mapping Menu";
        $data['m_sub_menu'] = DB::table('m_sub_menu')
            ->select(DB::raw("m_sub_menu.*"))
            ->get();

        $data['m_menu'] = DB::table('m_menu')
            ->select(DB::raw("m_menu.*"))
            ->get();

        return view('pages.mapping_menu.index', $data);
    }

    public function getDataRoleMappingMenu(Request $request)
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
            $tb_m_mapping_menu = DB::table('m_role')
                ->select(DB::raw("m_role.*"));

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_m_mapping_menu->count();


            $m_role = $tb_m_mapping_menu
                ->limit($limit)
                ->offset($offset)
                ->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_role) > 0) {

                foreach ($m_role as $value) {
                    // dd($value['nama']);

                    $datas[] = array(

                        'no' => $no++,
                        'nama_role' => $value->nama_role,
                        'aksi' =>
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalFormEditMapppingRole"
                    data-nama_role="' . $value->nama_role . '" 
                    data-role_id="' . $value->id . '"><i class="mdi mdi-square-edit-outline"></i> Edit Menu </button> &nbsp;'
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

    public function getDataMappingMenu(Request $request, $role_id)
    {
        $data['m_mapping_menu'] = DB::table('m_mapping_menu')
            ->select(DB::raw("m_mapping_menu.*"))
            ->where('m_mapping_menu.m_role_id', '=', $role_id)
            ->get();

        $data['m_sub_menu'] = DB::table('m_sub_menu')
            ->select(DB::raw("m_sub_menu.*"))
            ->get();
        // return response()->json($data);
        return response()->json(['datax' => $data]);
    }

    public function update(Request $request)
    {

        $m_role_id = $request->m_role_id;

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $delete_m_mapping_menu = DB::table('m_mapping_menu')
                ->where('m_mapping_menu.m_role_id', '=', $m_role_id)
                ->delete();

            if (count($request->sub_menu_id) == 0) {
                return response()->json(['success' => 'Data Tidak Diupdate', 'kode' => 201]);
            } else {
                for ($i = 0; $i < count($request->sub_menu_id); $i++) {
                    $tambah_m_mapping_menu = DB::table('m_mapping_menu')
                        ->insert([
                            'm_role_id' => $m_role_id,
                            'm_sub_menu_id' => $request->sub_menu_id[$i],
                            'created_at' => Carbon::now()
                        ]);
                }
                return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
            }
        }
    }
}
