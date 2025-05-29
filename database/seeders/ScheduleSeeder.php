<?php
/*  database/seeders/ScheduleSeeder.php  */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        /* ---------------------------------------------------------
         | 1)  Define 15 staff members with department + default role
         * ---------------------------------------------------------*/
        $staff = [
            ['Maria Santos',     'Obstetrician', 'OB'],
            ['Ana Cruz',         'Head Nurse',   'OB'],
            ['Juan Reyes',       'Resident MD',  'OB'],      // 1 of 2 male
            ['Lara Gutierrez',   'Nurse',        'OB'],
            ['Cielo Dela Peña',  'Midwife',      'OB'],

            ['Grace Flores',     'Pediatrician', 'Pediatrics'],
            ['Daniel Ramirez',   'Nurse',        'Pediatrics'], // 2 of 2 male
            ['Fiona Uy',         'Nurse',        'Pediatrics'],
            ['Rhea Gonzales',    'Resident MD',  'Pediatrics'],
            ['Jasmine Lim',      'Nurse',        'Pediatrics'],

            ['Patricia Tan',     'Radiologist',  'Radiology'],
            ['Kimberly Ong',     'Technician',   'Radiology'],
            ['Carla Mendoza',    'Technician',   'Radiology'],
            ['Monica Valdez',    'Resident MD',  'Radiology'],
            ['Elisa Robles',     'Clerk',        'Radiology'],
        ];

        /* ---------------------------------------------------------
         | 2)  For each person create a “weekly” schedule that:
         |     • starts this coming Monday
         |     • includes Mon-Fri 08:00-17:00 (8.5 h with 30 min break)
         * ---------------------------------------------------------*/
        $monday = Carbon::now()->next(Carbon::MONDAY)->startOfDay(); // first Monday

        foreach ($staff as $row) {
            [$name, $role, $dept] = $row;

            DB::table('schedules')->insert([
                'staff_name'   => $name,
                'role'         => $role,
                'department'   => $dept,

                /* one-off “date” column – we store the Monday of the week */
                'date'         => $monday->toDateString(),

                /* weekly options */
                'start_day'    => 'Monday',
                'shift_length' => 8.5,   // default hrs

                // ---------- shift times ----------
                'shift_start_monday'    => '08:00',
                'shift_end_monday'      => '17:00',
                'include_monday'        => true,

                'shift_start_tuesday'   => '08:00',
                'shift_end_tuesday'     => '17:00',
                'include_tuesday'       => true,

                'shift_start_wednesday' => '08:00',
                'shift_end_wednesday'   => '17:00',
                'include_wednesday'     => true,

                'shift_start_thursday'  => '08:00',
                'shift_end_thursday'    => '17:00',
                'include_thursday'      => true,

                'shift_start_friday'    => '08:00',
                'shift_end_friday'      => '17:00',
                'include_friday'        => true,

                // no weekend duties for this seed
                'shift_start_saturday'  => null,
                'shift_end_saturday'    => null,
                'include_saturday'      => false,

                'shift_start_sunday'    => null,
                'shift_end_sunday'      => null,
                'include_sunday'        => false,

                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }
    }
}
