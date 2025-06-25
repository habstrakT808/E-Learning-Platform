<?php

namespace App\Notifications;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $discussion;
    protected $reply;

    /**
     * Create a new notification instance.
     */
    public function __construct(Discussion $discussion, DiscussionReply $reply)
    {
        $this->discussion = $discussion;
        $this->reply = $reply;
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
        $url = route('discussions.show', $this->discussion->slug) . '#reply-' . $this->reply->id;

        return (new MailMessage)
            ->subject('Balasan Baru pada Diskusi: ' . $this->discussion->title)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line($this->reply->user->name . ' telah membalas diskusi Anda.')
            ->line('Diskusi: ' . $this->discussion->title)
            ->line('Balasan: ' . substr(strip_tags($this->reply->content), 0, 100) . (strlen($this->reply->content) > 100 ? '...' : ''))
            ->action('Lihat Balasan', $url)
            ->line('Terima kasih telah menggunakan platform kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'discussion_id' => $this->discussion->id,
            'discussion_title' => $this->discussion->title,
            'discussion_slug' => $this->discussion->slug,
            'reply_id' => $this->reply->id,
            'user_id' => $this->reply->user_id,
            'user_name' => $this->reply->user->name,
            'message' => $this->reply->user->name . ' telah membalas diskusi Anda: ' . $this->discussion->title,
        ];
    }
}
