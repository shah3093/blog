<?php

namespace App\Notifications;

use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class SendVerifyMail extends Notification implements ShouldQueue {
    use Queueable;
    public $visitor;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Visitor $visitor) {
        $this->visitor = $visitor;
    }
    
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }
    
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        try {
            $code = md5($this->visitor->email).md5($this->visitor->created_at);
            $url = route('visitors.verifyVisitor', [
                'visitorid' => $this->visitor->id,
                'code'      => $code
            ]);
            
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->greeting('Hello! '.$this->visitor->name)
                ->line('Please click the button below to verify your email address.'
                )->action('Verify Email Address', $url)
                ->line('If you did not create an account, no further action is required.');
        } catch(\Exception $exception) {
            Log::info($exception->getMessage());
        }
        
    }
    
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable) {
        return [//
        ];
    }
}
