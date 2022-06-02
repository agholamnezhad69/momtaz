<?php

namespace ali\Ticket\Repositories;

use ali\Ticket\Models\Ticket;


class TicketRepo
{

    private $query;

    public function __construct()
    {
        $this->query = Ticket::query();
    }

    public function store($title)
    {
        return Ticket::query()->create([
            "title" => $title,
            "user_id" => auth()->id()
        ]);
    }

    public function paginateAll($userId = null)
    {
        $query = Ticket::query();
        if ($userId)
            $query->where('user_id', $userId);

        return $query->latest()->paginate();
    }


    public function findOrFailWithReplies($ticketId)
    {

        return Ticket::query()->with('ticketReplies')->findOrFail($ticketId);


    }

    public function setStatus($ticketId, $status)
    {
        return Ticket::query()->where('id', $ticketId)->update([
            "status" => $status
        ]);

    }

    public function joinUsers()
    {
        $this->query
            ->join("users", "tickets.user_id", "users.id")
            ->select("tickets.*", "users.id", "users.name", "users.email");

        return $this;
    }

    public function searchEmail($email)
    {
        if (!is_null($email))
            $this->query->where("email", "like", "%" . $email . "%");


        return $this;


    }

    public function searchName($name)
    {
        if (!is_null($name))
            $this->query
                ->where('name', "like", "%" . $name . "%");

        return $this;


    }

    public function searchTitle($title)
    {
        if (!is_null($title))
            $this->query
                ->where("title", "like", "%" . $title . "%");

        return $this;

    }

    public function searchDate($date)
    {

        if (!is_null($date))
            $this->query
                ->whereDate("tickets.created_at", "=", getDateFromJalaliToCarbon(convertPersianNumberToEnglish($date)));
        return $this;
    }

    public function searchStatus($status)
    {

        if (!is_null($status))
            $this->query
                ->where("tickets.status", "=", $status);
        return $this;
    }

    public function paginate()
    {

        return $this->query->paginate();
    }


}
