<?php

namespace App\Http\Controllers\Notification;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notification;
use Auth;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    //Cambiar estado a leido
    public function readNotification($id){
        $not = Notification::where('id', $id)->get()->first();

        $not->is_read = 1;
        $not->save();

        return response()->json(['success' => true]);
    }

    //Mostrar la notificaciones(Todas)
    public function getNotifications(){
        $usuario = Session::get('user')->id;

        $notifications = Notification::where('user_id', $usuario)->get();

        foreach ($notifications as $key =>$notification){
            $date =$notification['sent_at'];
            $notifications[$key]['sent_at'] = $date->addDays(-1);
        }

        return $notifications;
    }

    //Obtener el numero de notificaciones no leidas
    public function getUnread(){
        $usuario = Session::get('user')->id;
        return count(Notification::where('is_read', 0)->where('user_id', $usuario)->get());
    }
}
