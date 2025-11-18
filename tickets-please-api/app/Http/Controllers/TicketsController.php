<?php

namespace App\Http\Controllers;
use App\Http\Requests\ApiCreateTicketRequest;
use App\Http\Requests\ApiUpdateTicketRequest;
use App\Http\Resources\TicketsResource;
use App\Models\Tickets;

use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Ticket;

class TicketsController extends Controller
{
    use ApiResponses;
    // show all tickets
    public function index()
    {
        $ticket = TicketsResource::collection(Tickets::latest()->paginate(500));
        return $ticket;
    }

    //create tickets
    public function createTicket(ApiCreateTicketRequest $request)
    {
        $ticket = Tickets::create($request->validated());
        return $this->ok(new TicketsResource($ticket), "Ticket created successfully");
    }

    //update tickets
    public function updateTicket(ApiUpdateTicketRequest $request, $id)
    {
        $ticket = Tickets::find($id);
        if(!$ticket)
        {
            return $this->error("Ticket not found");
        }
        $ticket->update($request->validated());
        return $this->ok(new TicketsResource($ticket),"Ticket updated successfully");
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
    public function getUserTickets($id)
    {
        $tickets = Tickets::where('user_id', $id)->select('id','user_id','title','description','status','created_at','updated_at')->get();

        return $this->ok(TicketsResource::collection($tickets),'Tickets fetched');
    }


    // get tickets count
    public function getUserTicketsCount($id)
    {
        $count = Tickets::where('user_id', $id)->count();
        return $this->ok($count, 'Tickets count fetched');
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
