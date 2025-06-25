<?php

namespace App\Notifications;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MentionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $mentionable;
    protected $mentioner;
    protected $discussion;

    /**
     * Create a new notification instance.
     */
    public function __construct($mentionable, $mentioner, Discussion $discussion)
    {
        $this->mentionable = $mentionable; // Discussion or DiscussionReply
        $this->mentioner = $mentioner; // User who mentioned
        $this->discussion = $discussion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('discussions.show', $this->discussion->slug);
        
        if ($this->mentionable instanceof DiscussionReply) {
            $url .= '#reply-' . $this->mentionable->id;
            $context = 'balasan pada diskusi';
        } else {
            $context = 'diskusi';
        }

        return (new MailMessage)
            ->subject('Anda Disebutkan dalam Diskusi')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line($this->mentioner->name . ' telah menyebutkan Anda dalam ' . $context . '.')
            ->line('Diskusi: ' . $this->discussion->title)
            ->action('Lihat Diskusi', $url)
            ->line('Terima kasih telah menggunakan platform kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $data = [
            'discussion_id' => $this->discussion->id,
            'discussion_title' => $this->discussion->title,
            'discussion_slug' => $this->discussion->slug,
            'mentioner_id' => $this->mentioner->id,
            'mentioner_name' => $this->mentioner->name,
        ];

        if ($this->mentionable instanceof DiscussionReply) {
            $data['reply_id'] = $this->mentionable->id;
            $data['message'] = $this->mentioner->name . ' menyebutkan Anda dalam balasan pada diskusi: ' . $this->discussion->title;
        } else {
            $data['message'] = $this->mentioner->name . ' menyebutkan Anda dalam diskusi: ' . $this->discussion->title;
        }

        return $data;
    }
}
