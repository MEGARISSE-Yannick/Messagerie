<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Notifications\MessageReceived;
use App\User;
use App\Repository\ConversationRepository;
use Carbon\Carbon;
use Illuminate\Auth\AuthManager;

class ConversationsController extends Controller
{
    public function __construct(ConversationRepository $conversationRepository, AuthManager $auth)
    {
        $this->r = $conversationRepository;
        $this->auth = $auth;
    }

    public function index()
    {
        return view('conversations/index', [
            'users' => $this->r->getConvertations($this->auth->user()->id),
            'unread' => $this->r->unreadCount($this->auth->user()->id)
        ]);
    }

    public function show(User $user){
            $me = $this->auth->user();
            $messages = $this->r->getMessagesFor($me->id, $user->id)->paginate(3);
            $unread = $this->r->unreadCount($me->   id);
            if (isset($unread[$user->id])) {
                    $this->r->readAllfrom($user->id,$me->id);
                    unset($unread[$user->id]);
            }
                return view('conversations.show',[
                    'users' => $this->r->getConvertations($me->id),
                    'user' => $user,
                    'messages' => $messages,
                    'unread' => $unread
                ]);
            
            
        }
    

    public function store(User $user, StoreMessageRequest $request){
        $message = $this->r->createMessage(
            $request->get('content'),
            $this->auth->user()->id,
            $user->id
        );
        $user->notify(new MessageReceived($message));
        return redirect(route('conversations.show', ['id' => $user->id]));
    }


    public function readAllFrom($from,$to){
        $this->message->where('from_id',$from)->where('to_id',$to)->update(['readt_at'=> Carbon::now()]);
    }
}
