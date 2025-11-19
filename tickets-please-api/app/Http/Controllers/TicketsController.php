<?php

namespace App\Http\Controllers;
use App\Http\Requests\ApiCreateTicketRequest;
use App\Http\Requests\ApiUpdateTicketRequest;
use App\Http\Resources\TicketsResource;
use App\Models\Tickets;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Cache;

class TicketsController extends Controller
{
    use ApiResponses;
    // show all tickets
    public function index()
    {
        $cacheKey = 'tickets_with_users_page';
        $ticket = Cache::remember($cacheKey, 60, function () {
            return TicketsResource::collection(Tickets::with('user')->paginate(50));

        });
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
        $cacheKey = "ticket_{$id}_user_stats";
        $tickets = Cache::remember($cacheKey, 60, function () use ($id) {
        return Tickets::with('user')->where('user_id', $id)->get();
        });
        return $this->ok(TicketsResource::collection($tickets),'Tickets fetched');
    }
    public function getSingleTicketInfo($id)
    {
        $tickets = Tickets::find( $id );
        if(!$tickets)
        {
            return $this->error('Ticket not found',404);
        }
        return $this->ok(new TicketsResource($tickets),'Ticket Found');
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
        $cacheKey = 'tickets_stats_cache';
        $stats = Cache::remember($cacheKey, 60, function ()  {
          return Tickets::select('status')
        ->selectRaw('COUNT(*) as total')
        ->groupBy('status')
        ->get();});
        return $this->ok($stats, "Overall ticket stats fetched");
    }

}

?>
