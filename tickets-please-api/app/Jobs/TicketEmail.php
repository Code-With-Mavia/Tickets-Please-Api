<?php

namespace App\Jobs;
use App\Models\User;
use App\Models\Tickets;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TicketEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public  $userId;
    public  $ticketId;

    public function __construct( $userId,  $ticketId)
    {
        $this->userId = $userId;
        $this->ticketId = $ticketId;
    }

    public function handle(): void
    {
        $user = User::find($this->userId);
        $ticket = Tickets::find($this->ticketId);

        if (! $user || ! $ticket) {
            Log::warning('TicketEmail: Missing user or ticket.', [
                'user_id' => $this->userId,
                'ticket_id' => $this->ticketId
            ]);
            return;
        }

        Log::info('Ticket email sent to user.', [
            'email' => $user->email,
            'ticket_title' => $ticket->title,
            'ticket_status' => $ticket->status,
        ]);
    }
}
