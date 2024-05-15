<?php

namespace App\Livewire;
use App\Events\MessageSendEvent;
use App\Models\User;
use App\Models\Message;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

    class ChatComponent extends Component
{
    public $user;
    public $sender_id;
    public $receiver_id;
    public $message = '';
    public $messages = [];
    public function render()
    {
        $messages = [];
        return view('livewire.chat-component', ['messages' => $messages]);
    }
    public function mount($user_id)
    {
        $this->sender_id = auth()->user()->id;
        $this->receiver_id = $user_id;

        $messages = Message::where(function($query){
        $query->where('sender_id' , $this->sender_id)->where('receiver_id' , $this->receiver_id);  
        })->orWhere(function($query)
        {$query->where('sender_id' , $this->receiver_id)->where('receiver_id' , $this->sender_id);
        })->with('sender:id,name','receiver:id,name')->get();
       
       $this->user = User::whereId($user_id)->first();
       foreach($messages as $message)
       {
        $this->appendChatMessage($message);
       }
    }
     
    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenMessage($event)
    {
      $chatMessage = Message::whereId($event['message']['id'])->with('sender:id,name','receiver:id,name')->first();
      $this->appendChatMessage($chatMessage);
    }
    public function appendChatMessage($message)
    {
        $this->messages[] =
        [
            'id' => $message->id,
            'message' => $message->message,
            'sender' => $message->sender->name,
            'reciever' => $message->receiver->name,
        ];
    }
    public function sendMessage()
    {
        $sender = auth()->user();
        $recipient = User::findOrFail($this->receiver_id);
       
        // Check if the sender is blocked by the recipient
        if ($recipient->blockedUsers()->where('blocked_user_id', $sender->id)->exists()) {
            // Save the message as undelivered
            $chatMessage = new Message();
            $chatMessage->sender_id = $this->sender_id;
            $chatMessage->receiver_id = $this->receiver_id;
            $chatMessage->message = $this->message;
            $chatMessage->delivered = false; // Mark as undelivered
            $chatMessage->save();
    
            return response()->json(['message' => 'Message sent but will not be delivered because the recipient has blocked you'], 200);
        }
        // Check if the recipient is blocked by the sender
        if ($sender->blockedUsers()->where('blocked_user_id', $recipient->id)->exists()) {
            return response()->json(['message' => 'Recipient is blocked by the sender'], 400);
        }
    
        // If neither the sender nor recipient is blocked, proceed with sending the message
        $chatMessage = new Message();
        $chatMessage->sender_id = $this->sender_id;
        $chatMessage->receiver_id = $this->receiver_id;
        $chatMessage->message = $this->message;
        $chatMessage->delivered = true; // Mark as delivered
        $chatMessage->save();
    
        $this->appendChatMessage($chatMessage);
        broadcast(new MessageSendEvent($chatMessage))->toOthers();
    
        $this->message = "";
    }
    
}