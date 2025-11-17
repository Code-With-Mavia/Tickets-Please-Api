<?php

namespace App\Http\Controllers;
use App\Http\Requests\ApiCreateTicketRequest;
use App\Models\Tickets;
use App\Traits\ApiResponses;
class TicketsController extends Controller
{
    use ApiResponses;
    public function index()
    {
        $ticket = Tickets::latest()->paginate(100);
        return $ticket;
    }

    public function createTicket(ApiCreateTicketRequest $request)
    {
        $ticket = Tickets::create($request->validated());
        return $this->ok($ticket, "Ticket created successfully");
    }

    public function deleteTicket($id)
    {
        $ticket = Tickets::find($id);
        if(!$ticket)
        {
            return $this->error("Ticket not found",404);
        }
        $deletedTicket = $ticket->delete();
        return $this->ok('Ticket deleted successfully',$deletedTicket);

    }

}
