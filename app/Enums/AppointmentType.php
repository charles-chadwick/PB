<?php

namespace App\Enums;

use App\Enums\Traits\EnumToArray;

enum AppointmentType: string {
	use EnumToArray;

	case HomeVisit   = "Home Visit";
	case OfficeVisit = "Office Visit";
	case VideoVisit  = "Video Visit";
	case PhoneVisit  = "Phone Visit";
}
