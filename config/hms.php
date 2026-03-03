<?php

return [
    'appointment_slot_minutes' => 15,
    'role_permissions' => [
        'owner' => ['users.create','users.view','users.update','users.status','patients.create','patients.view','patients.update','departments.manage','doctors.manage','doctors.view','appointments.create','appointments.view','appointments.update'],
        'admin' => ['users.create','users.view','users.update','users.status','patients.create','patients.view','patients.update','departments.manage','doctors.manage','doctors.view','appointments.create','appointments.view','appointments.update'],
        'doctor' => ['patients.view','doctors.view','appointments.view'],
        'nurse' => ['appointments.view'],
        'reception' => ['patients.create','patients.view','patients.update','appointments.create','appointments.view','appointments.update','doctors.view'],
        'accountant' => [],
    ],
];
