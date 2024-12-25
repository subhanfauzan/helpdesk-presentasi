<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class notifikasiController extends Controller
{
    public function index()
    {
        $data['judul'] = "Notifikasi";
        return view('pages.notifikasi.index', $data);
    }

    public function getNotifikasi(Request $request)
    {

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $username = $get_session['username'];
        if (validateSessionToken($get_session_token)) {
            $tab = $request->tab;
            $tb_notifikasi = DB::table('mapping_notifikasi')
                ->join('notifikasi', 'mapping_notifikasi.id_notif', '=', 'notifikasi.id')
                ->select(DB::raw('notifikasi.*, mapping_notifikasi.id as aidi'))
                ->where('mapping_notifikasi.id_penerima', '=', $username);

            if ($tab == "sudah") {
                $tb_notifikasi = $tb_notifikasi->where('mapping_notifikasi.status', '=', 1);
                // $to = "toSD()";
                // $teks = "<i class='bx bx-info-square'></i>";
                // $btn = "btn-secondary";
            }
            if ($tab == "belum") {
                $tb_notifikasi = $tb_notifikasi->where('mapping_notifikasi.status', '=', 0);
                // $to = "toSD()";
                // $teks = "<i class='bx bx-check'></i>";
                // $btn = "btn-success";
            }
            $total_data = $tb_notifikasi->count();
            $notifikasi = $tb_notifikasi
                ->limit($limit)
                ->offset($offset)
                ->orderBy('mapping_notifikasi.id', 'desc')
                ->get();
            $datas = [];
            $url = url('issues/getPutSessionTiketIssuesSearch');
            $no = $offset + 1;
            if (count($notifikasi) > 0) {
                foreach ($notifikasi as $value) {
                    $datas[] = array(
                        'no' => $no++,
                        'notifikasi' => '<a class="text-dark notif" href="'.$url.'?id_notif='. $value->aidi .'&tiket_issues='. $value->tiket_issue .'" >'.$value->notifikasi.'</a>',
                        'tanggal' => $value->created_at,
                        // 'aksi' => '<button class="btn '.$btn.'" data-notif="'.$value->id.'" onclick="'.$to.'">'.$teks.'</button>'
                    );
                }
            } else {
                $datas = array();
            }

            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function clickIcon()
    {
        $get_session_users_id = Session::get('user_app')['users_id'];
        $get_session_token = Session::get('user_app')['token'];
        $username = Session::get('user_app')['username'];

        if (validateSessionToken($get_session_token)) {

            // $notifs = DB::table('mapping_notifikasi')
            //     ->select(DB::raw('mapping_notifikasi.id_notif'))
            //     ->where('mapping_notifikasi.id_penerima', '=', $username)
            //     ->where('mapping_notifikasi.status', '=', 0)
            //     ->limit(5)
            //     ->orderBy('mapping_notifikasi.id', 'desc')
            //     ->get();
            // // dd($notifs);
            // foreach ($notifs as $notif) {
            //     DB::table('mapping_notifikasi')
            //     ->where('mapping_notifikasi.id_penerima', '=', $username)
            //     ->where('mapping_notifikasi.id_notif', '=', $notif->id_notif)
            //     ->update([
            //         'status' => 1
            //     ]);
            // }
            $next = DB::table('mapping_notifikasi')
                ->join('notifikasi', 'mapping_notifikasi.id_notif', '=', 'notifikasi.id')
                ->select(DB::raw('mapping_notifikasi.id, notifikasi.notifikasi as notif, notifikasi.created_at as tanggal'))
                ->where('mapping_notifikasi.id_penerima', '=', $username)
                ->where('mapping_notifikasi.status', '=', 0)
                ->limit(5)
                ->orderBy('mapping_notifikasi.id', 'desc')
                ->get();
        }
        return response()->json(['next' => $next, 'success' => 'Done Updated!', 'kode' => 201]);
    }

    public function changeRead($id)
    {
        $get_session_users_id = Session::get('user_app')['users_id'];
        $get_session_token = Session::get('user_app')['token'];
        $username = Session::get('user_app')['username'];
        if (validateSessionToken($get_session_token)) {
            DB::table('mapping_notifikasi')
                ->where('mapping_notifikasi.id_penerima', '=', $username)
                ->where('mapping_notifikasi.id', '=', $id)
                ->update([
                    'status' => 1
                ]);
        }
        return response()->json(['success' => 'Done Updated!', 'kode' => 201]);
    }

    public function changeReadAt(Request $request){
        $get_session_users_id = Session::get('user_app')['users_id'];
        $get_session_token = Session::get('user_app')['token'];
        $username = Session::get('user_app')['username'];
        if (validateSessionToken($get_session_token)) {
            $validated = $request->validate([
                'tanggalawal' => 'required',
                'tanggalakhir' => 'required'
            ]); 
            if($validated){
                $ids = DB::table('notifikasi')
                ->select(DB::raw('notifikasi.id as id'))
                ->where('notifikasi.created_at', '>=', $validated['tanggalawal']." 00:00:00")
                ->where('notifikasi.created_at', '<=', $validated['tanggalakhir']." 23:59:59")
                ->get();
                
                $array = array();
                foreach($ids as $id){
                    $array[]= $id->id;
                }

                DB::table('mapping_notifikasi')
                    ->where('mapping_notifikasi.id_penerima', '=', $username)
                    ->whereIn('mapping_notifikasi.id_notif', $array)
                    ->update([
                        'status' => 1
                    ]);

                return response()->json(['success' => 'Done Updated!', 'kode' => 201]);
            }
            return response()->json(['Error' => 'Eror Input!', 'kode' => 501]);
        }else{
            return response()->json(['Error' => 'Silakan Login Dahulu!', 'kode' => 404]);
        }
        
    }

    public function createNotifikasi($status, $tiket)
    {
        // $username = Session::get('user_app')['username'];
        // $nama = Session::get('user_app')['nama'];

        $username = is_null(Session::get('user_app')) ? 'admin_super' : Session::get('user_app')['username'];
        $nama = is_null(Session::get('user_app')) ? 'admin_super' : Session::get('user_app')['nama'];
        
        $issues_data = DB::table('issues')
            ->select(DB::raw('issues.*, v_users_all.nama as v_users_all_nama'))
            ->where('issues.tiket_issues', '=', $tiket)
            ->leftjoin('v_users_all', 'v_users_all.username', '=', 'issues.username_sap_issues')
            ->get()
            ->first();

        $requester = DB::table('issues')
            ->where('issues.tiket_issues', '=', $tiket)
            ->get()
            ->first()
            ->username_sap_issues;
        $admins = DB::table('users')
            ->select(DB::raw('users.username'))
            ->where('users.role', '=', 'R001')
            ->orWhere('users.role', '=', 'R005')
            ->get();
        switch ($status) {
            case 1:
                $text = $nama . " Mengajukan Issues " . $tiket;
                $text1 = $nama . " Mengajukan Issues " . $tiket . ' atas nama ' . $issues_data->v_users_all_nama;
                break;
            case 2:
                $text = "Status issues " . $tiket . " diubah menjadi <span class='badge bg-info'>Progres</span></h1> oleh " . $nama;
                $text1 = "Status issues " . $tiket . " diubah menjadi Progres oleh " . $nama;
                break;
            case 3:
                $text = "Status issues " . $tiket . " diubah menjadi <span class='badge bg-success'>Done</span></h1> oleh "  . $nama;
                $text1 = "Status issues " . $tiket . " diubah menjadi Done oleh "  . $nama;
                break;
            case 4:
                $text = "Status issues " . $tiket . " diubah menjadi <span class='badge bg-primary'>Close</span></h1> oleh "  . $nama;
                $text1 = "Status issues " . $tiket . " diubah menjadi Close oleh "  . $nama;
                break;
            case 6:
                // dd('ini 6');
                $text = "Status issues " . $tiket . " diubah menjadi <span class='badge bg-danger'>On Hold</span></h1> oleh "  . $nama;
                $text1 = "Status issues " . $tiket . " diubah menjadi On Hold oleh "  . $nama;
                break;
            default:
                $text = "Default";
                $text1 = "Default";
        }
        $id = DB::table('notifikasi')
            ->insertGetId([
                'notifikasi' => $text,
                'created_by' => $username,
                'created_at' => Carbon::now(),
                'tiket_issue' => $tiket
            ]);

        if ($requester != $username) {
            DB::table('mapping_notifikasi')
                ->insert([
                    'id_notif' => $id,
                    'id_penerima' => $requester,
                    'status' => 0
                ]);
        }

        foreach ($admins as $admin) {
            if ($admin->username != $username) {
                DB::table('mapping_notifikasi')
                    ->insert([
                        'id_notif' => $id,
                        'id_penerima' => $admin->username,
                        'status' => 0
                    ]);
            }
        }

        // sendWA(6282132343949, 'coba', null);
        // dd(strlen($issues_data->no_whatsapp));
        if($issues_data->no_whatsapp == null || 
        $issues_data->no_whatsapp == "" || 
        strlen($issues_data->no_whatsapp) <= 10){
            // dd('tidak terkirim');
        }else{

            if($status == 3){

                $pesan_wa = "Tiket Helpdesk dengan No Tiket $tiket Telah Diubah Menjadi DONE oleh Admin Helpdesk, Mohon untuk cek kembali pada Aplikasi Helpdesk, Terimakasih." . "\n\n" . "*NB : Anda tidak perlu membalas pesan ini, karena pesan ini pesan otomatis.*";
                sendWA($issues_data->no_whatsapp, $pesan_wa, null);

                DB::table('riwayat_pesan_whatsapp')
                    ->insert([
                        'tiket_issues' => $issues_data->tiket_issues,
                        'no_whatsapp' => $issues_data->no_whatsapp,
                        'pesan' => $pesan_wa,
                        'created_at' => Carbon::now()
                    ]);
            }else{

            }
            
        }

        // return response()->json(['success' => 'Done Updated!', 'kode' => 201]);
    }

    public function getNotifByTgl(Request $request){
        $tanggal = $request->tgl;
        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $username = $get_session['username'];
        if (validateSessionToken($get_session_token)) {
            $tab = $request->tab;
            $tb_notifikasi = DB::table('mapping_notifikasi')
                ->join('notifikasi', 'mapping_notifikasi.id_notif', '=', 'notifikasi.id')
                ->select(DB::raw('notifikasi.*, mapping_notifikasi.id as aidi'))
                ->where('notifikasi.created_at', 'like', '%'.$tanggal.'%')
                ->where('mapping_notifikasi.id_penerima', '=', $username);

            if ($tab == "sudah") {
                $tb_notifikasi = $tb_notifikasi->where('mapping_notifikasi.status', '=', 1);
                // $to = "toSD()";
                // $teks = "<i class='bx bx-info-square'></i>";
                // $btn = "btn-secondary";
            }
            if ($tab == "belum") {
                $tb_notifikasi = $tb_notifikasi->where('mapping_notifikasi.status', '=', 0);
                // $to = "toSD()";
                // $teks = "<i class='bx bx-check'></i>";
                // $btn = "btn-success";
            }
            $total_data = $tb_notifikasi->count();
            $notifikasi = $tb_notifikasi
                ->limit($limit)
                ->offset($offset)
                ->orderBy('mapping_notifikasi.id', 'desc')
                ->get();
            $datas = [];
            $url = url('issues/getPutSessionTiketIssuesSearch');
            $no = $offset + 1;
            if (count($notifikasi) > 0) {
                foreach ($notifikasi as $value) {
                    $datas[] = array(
                        'no' => $no++,
                        'notifikasi' => '<a class="text-dark notif" href="'.$url.'?id_notif='. $value->aidi .'&tiket_issues='. $value->tiket_issue .'" >'.$value->notifikasi.'</a>',
                        'tanggal' => $value->created_at,
                        // 'aksi' => '<button class="btn '.$btn.'" data-notif="'.$value->id.'" onclick="'.$to.'">'.$teks.'</button>'
                    );
                }
            } else {
                $datas = array();
            }

            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }
}
