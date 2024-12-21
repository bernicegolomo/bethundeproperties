<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;
    private $info;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        
        if(!isset($this->info['platform'])){
            return (new MailMessage)
            ->subject('BETHUNDE PROPERTIES | PROFILE REGISTRATION')
                    ->greeting("Hello ".$this->info['name'])
                    ->line('Your profile has been created successfully.')
                    ->line('Use the link below to verify your account.')
                    ->line('Email: '.$this->info['email'])
                    ->line('Password: '.$this->info['password'])
                    ->action('Verification link', url('/verify?email='.$this->info['email'].'&token='.$this->info['token']));
        }else{
            return (new MailMessage)
            ->subject('BETHUNDE PROPERTIES | PROFILE REGISTRATION')
                    ->greeting("Hello ".$this->info['name'])
                    ->line('Your profile has been created successfully.')
                    ->line('Use the token below to verify your account.')
                    ->line('Email: '.$this->info['email'])
                    ->line('Password: '.$this->info['password'])
                    ->line('token: '.$this->info['token']);
        }
                    
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
