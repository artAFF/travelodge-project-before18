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

    function DeleteIssue($id)
    {
        Travelodge::where('id', $id)->delete();


        return redirect('/reports/reportIssue');
    }

    function DeleteItem($type, $modelType, $id)
    {
        $model = $this->getModelFromType($type, $modelType);
        $model::where('id', $id)->delete();
        return redirect("/{$type}");
    }

    private function getModelFromType($type, $modelType)
    {
        switch ($type) {
            case 'tlcmn':
                return "App\\Models\\Tlcmn_{$modelType}";
            case 'ehcm':
                return "App\\Models\\Ehcm_{$modelType}";
            case 'uncm':
                return "App\\Models\\Uncm_{$modelType}";
            default:
                throw new \Exception("Invalid type");
        }
    }
    /*     function Tlcmn_DeleteGuest($id)
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
