<?php

namespace App\Enums;

enum UserRole: string
{
	case SuperAdmin = 'Super Admin';
	case Staff = 'Staff';
	case Doctor = 'Doctor';
	case Nurse = 'Nurse';
    case Patient = 'Patient';
}