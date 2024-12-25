<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class menuController extends Controller
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
        $data['judul'] = "Menu";
        $data['m_menu'] = DB::table('m_menu')
            ->select(DB::raw("m_menu.*"))
            ->get();

        return view('pages.menu.index', $data);
    }

    public function getDataMenu(Request $request)
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
        // dd($limit);

        // $tb_users = DB::table('users')
        //     ->select(DB::raw("users.*"));
        // $token = headerToken()['api-token'];
        // $client = new Client(['verify' => public_path('ssl/cacert.pem')]);
        // $myBody = array(
        //     "api-token" => $token,
        // );
        // $url = url_api_helpdesk('menu/get');
        // $response = $client->get($url, ['headers' => $myBody, 'query' => $data_arr]);
        // $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
        // $data_users = $response_server['result']['message'];
        // $data_users_count = count($data_users);
        // dd($data_users);
        // dd($response_server);

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $tb_m_menu = DB::table('m_menu')
                ->select(DB::raw("m_menu.*"));

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_m_menu->count();


            $m_menu = $tb_m_menu
                ->limit($limit)
                ->offset($offset)
                ->get();


            // dd($response_server['result']['message']);

            // $tb_users_count = $tb_users->count();
            // $tb_users = $tb_users->limit($limit);
            // $tb_users = $tb_users->offset($offset);
            // $tb_users = $tb_users->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_menu) > 0) {

                foreach ($m_menu as $value) {
                    // dd($value['nama']);

                    $datas[] = array(

                        'no' => $no++,
                        'nama_menu' => $value->nama_menu,
                        'aksi' =>
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalFormEditMenu"
                        data-nama_menu="' . $value->nama_menu . '" 
                        data-icon_menu="'.$value->icon_menu.'"
                        data-menu_id="' . $value->id . '">
                        <i class="bx bxs-edit"></i></i> Edit </button> &nbsp;' .
                            '<button type="button" name="delete" id="delete" data-menu_id="' . $value->id . '" class="btn btn-danger btn-xs" href=' . '' . '><i class="bx bxs-trash-alt"></i> Hapus </button> &nbsp;' .
                            "<a type='button' class='btn btn-warning btn-xs' href='" . url("sub_menu/index/$value->id") . "'><i class='bx bx-menu'></i> Sub Menu</a>"
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

        // $token = headerToken()['api-token'];
        // $data['data'] = $request->all();
        // $data['token'] = $token;
        // $users_id = Session::get('user_app')['users_id'];
        // $request->request->add(['token' => $token, 'token' => $token, 'users_id' => $users_id]);
        // $data = $request->all();

        // dd($data);

        // $client = loadfile();

        // try {
        //     $url = url_api_helpdesk('menu/tambah');
        //     $response = $client->post($url, ['form_params' => $data]);
        //     $response_server = \GuzzleHttp\json_decode($response->getBody(), true);
        //     // dd($response_server);
        //     return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
        // } catch (RequestException $e) {
        //     // return response()->json(['success' => $e, 'kode' => 401]);
        //     dd($e->getMessage());
        //     // return response()->json(['success' => $e, 'kode' => 201]);
        // } catch (\Exception $e) {
        //     dd($e->getMessage());
        //     // return response()->json(['success' => $e, 'kode' => 201]);
        // }

        // dd($response_server);
        // dd();

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $nama_menu = $request->nama_menu;
        $icon_menu = $request->icon_menu;

        if (validateSessionToken($get_session_token)) {

            $tb_m_menu = DB::table('m_menu')
                ->select(DB::raw("m_menu.*"))
                ->get();

            $tb_m_menu_count = count($tb_m_menu);

            if ($tb_m_menu_count == 0) {

                $tambah_menu = DB::table('m_menu')
                    ->insert([
                        'id' => 'M001',
                        'nama_menu' => $nama_menu,
                        'icon_menu' => $icon_menu,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            } else {

                $tb_m_menu_get_id_terakhir = DB::table('m_menu')
                    ->select(DB::raw("m_menu.*"))
                    ->orderby('m_menu.id', 'DESC')
                    // ->limit(1)
                    ->get()
                    ->first();

                $tambah_menu = DB::table('m_menu')
                    ->insert([
                        'id' => next_value($tb_m_menu_get_id_terakhir->id),
                        'nama_menu' => $nama_menu,
                        'icon_menu' => $icon_menu,
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

        $menu_id_edit = $request->menu_id_edit;
        $nama_menu_edit = $request->nama_menu_edit;
        $icon_menu_edit = $request->icon_menu_edit;

        if (validateSessionToken($get_session_token)) {

            $update_m_menu = DB::table('m_menu')
                ->where('m_menu.id', '=', $menu_id_edit)
                ->update([
                    'nama_menu' => $nama_menu_edit,
                    'icon_menu' => $icon_menu_edit,
                ]);

            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function delete(Request $request, $id)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $delete_users = DB::table('m_menu')
                ->where('m_menu.id', '=', $id)
                ->delete();

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }
}
