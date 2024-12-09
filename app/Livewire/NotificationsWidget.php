<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class NotificationsWidget extends Component
{
    public $notifications;
    public $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Notification::latest()
            ->take(5)
            ->get();
        $this->unreadCount = Notification::where('is_read', false)->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notifications-widget');
    }
}