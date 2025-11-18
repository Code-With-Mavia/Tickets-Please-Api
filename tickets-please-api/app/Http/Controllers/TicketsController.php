<?php

namespace App\Http\Controllers;
use App\Http\Requests\ApiCreateTicketRequest;
use App\Http\Requests\ApiUpdateTicketRequest;
use App\Models\Tickets;

use App\Traits\ApiResponses;
class TicketsController extends Controller
{
    use ApiResponses;
    public function index()
    {
        $ticket = Tickets::select("id","user_id","title","description","status")->paginate(2500);
        return $ticket;
    }

    public function createTicket(ApiCreateTicketRequest $request)
    {
        $ticket = Tickets::create($request->validated());
        return $this->ok($ticket, "Ticket created successfully");
    }

    public function updateTicket(ApiUpdateTicketRequest $request, $id)
    {
        $ticket = Tickets::find($id);
        if(!$ticket)
        {
            return $this->error("Ticket not found");
        }
        $ticket->update($request->validated());
        return $this->ok($ticket,"Ticket updated successfully");
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

    //filter tickets via user id how many tickets he has
    public function getticketsbyUser($id)
    {
        $tickets = Tickets::select('id','user_id','title','description','status')->where('user_id', $id);
        return $this->ok("Tickets = ".$tickets->count(),'Tickets fetched');

    }

    //Tickets stats according to their status counts like S,A,B,C
    public function ticketStats()
    {
        $stats = Tickets::select('status')
        ->selectRaw('COUNT(*) as total')
        ->groupBy('status')
        ->get();

        return $this->ok($stats, "Overall ticket stats fetched");
    }


}
