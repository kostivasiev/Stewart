<?php

// function listGroups($userId)
// {
//     return DB::table('groups')
//             ->select('groups.*', DB::raw('count(contacts.id) as total'))
//             ->join('contacts', 'contacts.group_id', '=', 'groups.id')
//             ->where('contacts.user_id', $userId)
//             ->groupBy('contacts.group_id')
//             ->get();
// }

// function listEquipmentGroups($userId)
// {
//     return DB::table('equipment_groups')
//             ->select('equipment_groups.*', DB::raw('count(equipment.id) as total'))
//             ->join('equipment', 'equipment.equipment_groups_id', '=', 'equipment_groups.id')
//             // ->where('equipment.user_id', $userId)
//             ->groupBy('equipment.equipment_groups_id')
//             ->get();
// }

function listEquipmentGroups($userId)
{
  Auth::user();
    return Auth::user()->company()->first()->equipment_types()->orderBy('name')->get();
}

function listFuelGroups($userId)
{
    return DB::table('fuel_groups')
            ->select('fuel_groups.*', DB::raw('count(users.id) as total'))
            ->join('users', 'users.fuel_group_id', '=', 'fuel_groups.id')
            ->where('users.id', $userId)
            ->groupBy('users.fuel_group_id')
            ->get();
}
