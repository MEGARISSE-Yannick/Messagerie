<?php

namespace App\Repository;
use App\User;
use App\Message;
use Carbon\Carbon;

class ConversationRepository
{

      private $user;
      private $message;
      private $unread;

      public function __construct(User $user, Message $message)
      {
            $this->user = $user;
            $this->message = $message;
      }

      public function getConvertations($userId) {
            $conversations   = $this->user->newQuery()
                  ->select('name', 'id')
                  ->where('id', '!=', $userId)
                  ->get();
            $unread = $this->unreadCount($userId);
                  foreach ($conversations as $conversation ) {
                        if (isset($unread[$conversation->id])) {
                              $conversation->unread = $unread[$conversation->id];
                        }else{
                              $conversation->unread = 0;
                        }
                  }
                  return $conversations;
      }
      public function createMessage($content, $from, $to)
      {
            return $this->message->newQuery()->create([
                  'content' => $content,
                  'from_id' => $from,
                  'to_id' => $to,
                  'created_at' => Carbon::now()
            ]);
      }

      public function getMessagesFor($from, $to)
      {
            return $this->message->newQuery()
                  ->whereRaw("((from_id =$from AND to_id = $to ) OR (from_id = $to AND to_id = $from ))")
                  ->orderBy('created_at'  , 'DESC')
                  ->with([
                        'from' => function($query){
                              $query->select('name','id');
                        }
                  ]);

      }


      /**
       * recupere le nomrbre de message
       *puis affiche un petit badge avec le nbr de message non lu 
       */
 
      public function unreadCount( $userId){
            
            return $this->message->newQuery()
                  ->where('to_id', $userId)
                  ->groupBy('from_id')
                  ->selectRaw('from_id, COUNT(id) as count') 
                  ->whereRaw('read_at IS NULL')
                  ->get()
                  ->pluck('count','from_id');
      }

         /**
       * marque tous les message
       *en deja lu 
       */
 
      public function readAllfrom( $from, $to){
            
            return $this->message->where('from_id',$from)->where('to_id',$to)->update(['read_at'=> Carbon::now()]);
                 
      }

      

}
