<?php

namespace App\Http\Controllers;

use App\Models\GuestRoom;
use App\Models\NetSpeed;
use App\Models\ServerRoom;
use App\Models\SwitchRoom;
use App\Models\Tlcmn_guest;
use App\Models\Tlcmn_net;
use App\Models\Tlcmn_server;
use App\Models\Tlcmn_switch;
use Illuminate\Http\Request;
use App\Models\Travelodge;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Switch_;

class DeleteController extends Controller
{
    /*     public function __construct()
    {
        $this->middleware('auth');
    } */

    /*     function DeleteIssue($id)

    {
        Travelodge::where('id', $id)->delete();
        return redirect('/reports/reportIssue');
    }

    function Tlcmn_DeleteGuest($id)
    {
        Tlcmn_guest::where('id', $id)->delete();
        return redirect('/guest/reportGuest');
    }

    function Tlcmn_DeleteSwitch($id)
    {
        Tlcmn_switch::where('id', $id)->delete();
        return redirect('/switchs/reportSwitch');
    }

    function Tlcmn_DeleteServer($id)
    {
        Tlcmn_server::where('id', $id)->delete();
        return redirect('/server/reportServer');
    }

    function Tlcmn_DeleteNetSpeed($id)
    {
        Tlcmn_net::where('id', $id)->delete();
        return redirect('/netspeed/reportNet');
    } */
}
