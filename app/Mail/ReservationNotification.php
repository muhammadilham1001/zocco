<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationNotification extends Mailable
{
    use Queueable, SerializesModels;

public $reservation;
public $role;

public function __construct($reservation, $role = 'user')
{
    $this->reservation = $reservation;
    $this->role = $role;
}
    public function build()
    {
        return $this->subject('Konfirmasi Reservasi Baru - Zocco Coffee')
                    ->view('emails.reservation_notification');
    }
}