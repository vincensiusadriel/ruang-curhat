<?php

namespace App\Http\Controllers;

use App\Events\newMessage;
use App\Friend;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;

class ContactsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function get(){
        //get all users except the authenticated one
        //$contacts = User::where('id','!=',auth()->id())->get();
        $first = Auth::user()->friends()->where('accepted',true)->get();
        $second = Auth::user()->friendsBis()->where('accepted',true)->get();
        $contacts = $second->merge($first);


        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to',auth()->id())
            ->where('read',false)
            ->groupBy('from')
            ->get();

        $contacts = $contacts->map(function ($contact) use ($unreadIds){
           $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
           $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

           return $contact;
        });

        return response()->json($contacts);
    }

    public function getMessagesFor($id){
        //$messages = Message::where('from', $id)->orWhere('to', $id)->get();
        Message::where('from', $id)->where('to',auth()->id())->update(['read' => true]);

        $messages = Message::where(function ($q) use ($id){
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id){
            $q->where('to', auth()->id());
            $q->where('from', $id);
        })->get();
        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $message = Message::create([
           'from' => auth()->id(),
            'to' => $request->contact_id,
            'text' => $request->text
        ]);

        broadcast(new newMessage($message));

        return response()->json($message);
    }

    public function getProfile($id){
        $user = User::find($id);

        if(auth()->user()->id != $id){
            return redirect('/profile/'.$id);
        }

        return view('updateProfile')->with('profile',$user);
    }


    public function updateProfile(Request $request){
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required'],
            'profile_image' => 'image|nullable|max:1999',
        ]);


        Artisan::call('cache:clear');
        $fileNameToStore = auth()->user()->profile_image;

        if($request->hasFile('profile_image')){
            //Get just extension
            if (File::exists('storage/avatar/'. $fileNameToStore) && $fileNameToStore != 'default.jpg')
            {

                File::delete('storage/avatar/'. $fileNameToStore);

            }
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = auth()->user()->id.'_'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('profile_image')->storeAs('public/avatar',$fileNameToStore);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->status = $request->status;
        $user->profile_image =  $fileNameToStore;
        $user->save();

        return redirect('/profile/'.\auth()->id())->with('success','Profile updated');


    }

    public function addFriend(){

    }




}
