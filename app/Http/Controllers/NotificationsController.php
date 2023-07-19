<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('notifications.index',[
    		'unreadNotifications'=> auth()->user()->unreadNotifications,
    		'readNotifications'=> auth()->user()->readNotifications
    	]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $body ="Solic";
        $this->validate($request,[

            'recipient_id'=> 'required|exists:users,id',
        ]);
        //validacion
        $message= Message::create([
            'sender_id'=> auth()->id(),
            'recipient_id'=> $request->recipient_id,
            'body'=>$body,

        ]);

        $array=[
        'link'=>route('message.show',$message->id),
        'text'=>"Has recibido una Muestra de".$message->sender->name
        ];
        
        $recipient = User::where('area', 'Contabilidad')->orWhere('area', 'Administracion')->get();
        
        foreach ($recipient as $key => $value) {
            # code...
        }
        $recipient->notify(new Messaget($array));
        
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$message=Message::findOrFail($id);
    	//return view('messages.show',compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function read($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $notification->delete();
    	return redirect()->back()->with('flash','Notificacion marcada como leida');
    }
    public function deleteall()
    {
        $notifications = auth()->user()->unreadnotifications()->delete();
    	return redirect()->back()->with('flash','Notificacion marcada como leida');
    }
    public function redirect($url, $id)
    {
        return redirect()->route($url,$id)->with('success','El formulario se envio correctamente');
    }
}
