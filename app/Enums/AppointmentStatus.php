<?php

namespace App\Enums;

enum AppointmentStatus: string {
	case Confirmed   = 'Confirmed';
	case Pending     = 'Pending';
	case Cancelled   = 'Cancelled';
	case Rescheduled = 'Rescheduled';
}
