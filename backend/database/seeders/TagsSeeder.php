<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tagsOptions = [
            1 => 'Administration',
            2 => 'Meetings',
            3 => 'Paperwork',
            4 => 'Planning',
            5 => 'Budget',
            6 => 'Admissions',
            7 => 'Enrolment',
            8 => 'Interviews',
            9 => 'Application',
            10 => 'Open House',
            11 => 'Communications',
            12 => 'News Letters',
            13 => 'Social Media',
            14 => 'Website',
            15 => 'IT',
            16 => 'Techanical Support',
            17 => 'Software',
            18 => 'Hardware',
            19 => 'Networking',
            20 => 'Counselling',
            21 => 'Events',
            22 => 'Activities',
            23 => 'Acedemic',
            24 => 'Maintenance',
            25 => 'Repairs',
            26 => 'Security',
            27 => 'Transportation',
            28 => 'Bus Schedules',
            29 => 'Routes',
            30 => 'Driver',
            31 => 'Assignments',
            32 => 'Canteen',
            33 => 'Menu',
            34 => 'Orders',
            35 => 'Inventory',
            36 => 'Health and Safety',
            37 => 'Finance',
            38 => 'Accounts',
            39 => 'Uniforms',
            40 => 'Housekeeping',
            41 => 'Medical'
        ];

        foreach($tagsOptions as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
