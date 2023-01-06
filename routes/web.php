<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    // return view('auth/login');
});
Route::post('downloadExcel/{type}', ['uses' => 'ReportController@downloadExcel', 'as' => 'download']);
Route::get('pivot', ['uses' => 'ReportController@pivot', 'as' => 'pivot']);
Route::get('map', ['uses' => 'MapController@map', 'as' => 'map']);
Route::get('map/index', ['uses' => 'MapController@index', 'as' => 'map.index']);

// Route::post('equipment_table/table_update', ['uses' => 'EquipmentController@table_update', 'as' => 'equipment_table.table_update']);

Route::post('equipment_table/table_update', ['uses' => 'EquipmentController@table_update', 'as' => 'equipment_table.table_update']);
Route::get('equipment_table/makes', ['uses' => 'EquipmentController@makes', 'as' => 'equipment_table.makes']);
Route::get('equipment_table/emodels', ['uses' => 'EquipmentController@emodels', 'as' => 'equipment_table.emodels']);
Route::get('equipment_table/years', ['uses' => 'EquipmentController@years', 'as' => 'equipment_table.years']);

Route::post('fuel_groups/ajax_update', ['uses' => 'FuelGroupController@ajax_update', 'as' => 'fuel_groups.ajax_update']);
Route::post('fuel_groups/update_station_assignment', ['uses' => 'FuelGroupController@update_station_assignment', 'as' => 'fuel_groups.update_station_assignment']);
Route::post('fuel_groups/update_user_assignment', ['uses' => 'FuelGroupController@update_user_assignment', 'as' => 'fuel_groups.update_user_assignment']);
Route::post('fuel_groups/update_equipment_assignment', ['uses' => 'FuelGroupController@update_equipment_assignment', 'as' => 'fuel_groups.update_equipment_assignment']);
Route::post('fuel_groups/ajax_destroy', ['uses' => 'FuelGroupController@ajax_destroy', 'as' => 'fuel_groups.ajax_destroy']);
Route::post('register/store_user', ['uses' => 'Auth\RegisterController@store_user', 'as' => 'register.store_user']);
Route::post('groups/store', ['uses' => 'GroupsController@store', 'as' => 'groups.store']);
Route::post('equipment_types/store', ['uses' => 'EquipmentTypeController@store', 'as' => 'equipment_types.store']);
Route::get('contacts/autocomplete', ['uses' => 'ContactController@autocomplete', 'as' => 'contacts.autocomplete']);
Route::get('workorders/current_intervals', ['uses' => 'WorkorderController@current_intervals', 'as' => 'workorders.current_intervals']);
Route::get('users/validate_pin', ['uses' => 'UserController@validate_pin', 'as' => 'users.validate_pin']);
Route::get('equipment/validate_unit_number', ['uses' => 'EquipmentController@validate_unit_number', 'as' => 'equipment.validate_unit_number']);
Route::get('makes/index_from_type', ['uses' => 'MakeController@index_from_type', 'as' => 'makes.index_from_type']);
Route::get('models/index_from_make', ['uses' => 'EmodelController@index_from_make', 'as' => 'models.index_from_make']);
Route::get('years/index_from_model', ['uses' => 'YearController@index_from_model', 'as' => 'years.index_from_model']);
Route::resource('contacts', 'ContactController');
Route::get('equipment/interval/{id}',[
    'as' => 'equipment.interval',
    'uses' => 'EquipmentController@intervals'
]);
// Route::get('equipment/parts/{id}',[
//     'as' => 'equipment.parts',
//     'uses' => 'EquipmentController@parts'
// ]);


Route::post('company/change_company', ['uses' => 'CompanyController@change_company', 'as' => 'company.change_company']);

Route::get('company/autocomplete', ['uses' => 'CompanyController@autocomplete', 'as' => 'company.autocomplete']);
Route::get('users/autocomplete', ['uses' => 'UserController@autocomplete', 'as' => 'users.autocomplete']);
Route::get('equipment/autocomplete', ['uses' => 'EquipmentController@autocomplete', 'as' => 'equipment.autocomplete']);

Route::get('workorders/status_view', ['uses' => 'WorkorderController@status_view', 'as' => 'workorders.status_view']);
Route::get('workorders/interval_view', ['uses' => 'WorkorderController@interval_view', 'as' => 'workorders.interval_view']);
Route::get('workorders/current_intervals', ['uses' => 'WorkorderController@intervals_legend', 'as' => 'workorders.current_intervals']);



Route::get('workorders/intervals', ['uses' => 'WorkorderController@intervals', 'as' => 'workorders.intervals']);
Route::get('workorders/parts', ['uses' => 'WorkorderController@parts', 'as' => 'workorders.parts']);
Route::get('workorders/currentMeter', ['uses' => 'WorkorderController@currentMeter', 'as' => 'workorders.currentMeter']);
Route::get('workorders/intervalnotes', ['uses' => 'WorkorderController@intervalnotes', 'as' => 'workorders.intervalnotes']);
Route::post('workorders/ajax_store', ['uses' => 'WorkorderController@ajax_store', 'as' => 'workorders.ajax_store']);
Route::post('workorders/reset_interval', ['uses' => 'WorkorderController@reset_interval', 'as' => 'workorders.reset_interval']);
Route::post('workorders/update_meter', ['uses' => 'WorkorderController@update_meter', 'as' => 'workorders.update_meter']);
Route::post('workorders/add_photo_to_workorder', ['uses' => 'WorkorderController@add_photo_to_workorder', 'as' => 'workorders.add_photo_to_workorder']);
Route::post('workorders/add_labor_fields', ['uses' => 'WorkorderController@add_labor_fields', 'as' => 'workorders.add_labor_fields']);
Route::get('workorders/equipment_history', ['uses' => 'WorkorderController@equipment_history', 'as' => 'workorders.equipment_history']);
Route::get('workorders/tags',
['uses' => 'WorkorderController@tags',
'as' => 'workorders.tags']);


Route::post('register/order_trial', ['uses' => 'Auth\RegisterController@order_trial', 'as' => 'register.order_trial']);
Route::post('register/order_subscription', ['uses' => 'Auth\RegisterController@order_subscription', 'as' => 'register.order_subscription']);
Route::post('reports/intervals_all', ['uses' => 'ReportController@intervals_all', 'as' => 'reports.intervals_all']);
Route::post('reports/adjusted_intervals', ['uses' => 'ReportController@adjusted_intervals', 'as' => 'reports.adjusted_intervals']);
Route::post('reports/equipment_assignment', ['uses' => 'ReportController@equipment_assignment', 'as' => 'reports.equipment_assignment']);
Route::post('reports/equipment_assignment_by_user', ['uses' => 'ReportController@equipment_assignment_by_user', 'as' => 'reports.equipment_assignment_by_user']);
Route::post('reports/fuel_report', ['uses' => 'ReportController@fuel_report', 'as' => 'reports.fuel_report']);
Route::post('reports/fuel_group_users', ['uses' => 'ReportController@fuel_group_users', 'as' => 'reports.fuel_group_users']);
Route::post('reports/users', ['uses' => 'ReportController@users', 'as' => 'reports.users']);
Route::post('reports/equipment', ['uses' => 'ReportController@equipment', 'as' => 'reports.equipment']);
Route::post('reports/equipment_all', ['uses' => 'ReportController@equipment_all', 'as' => 'reports.equipment_all']);
Route::post('reports/fuel_group_equipment', ['uses' => 'ReportController@fuel_group_equipment', 'as' => 'reports.fuel_group_equipment']);
Route::post('reports/workorders_by_equipment', ['uses' => 'ReportController@workorders_by_equipment', 'as' => 'reports.workorders_by_equipment']);
Route::post('reports/workorders_by_user', ['uses' => 'ReportController@workorders_by_user', 'as' => 'reports.workorders_by_user']);
Route::post('reports/workorders_labor_by_user', ['uses' => 'ReportController@workorders_labor_by_user', 'as' => 'reports.workorders_labor_by_user']);

Route::get('intervals/add_default_interval', ['uses' => 'IntervalController@add_default_interval', 'as' => 'intervals.add_default_interval']);
Route::get('socket/validate_equipment', ['uses' => 'SocketController@validate_equipment', 'as' => 'socket.validate_equipment']);
Route::get('socket/validate_session', ['uses' => 'SocketController@validate_session', 'as' => 'socket.validate_session']);
Route::get('socket/complete_session', ['uses' => 'SocketController@complete_session', 'as' => 'socket.complete_session']);


Route::get('send', ['uses' => 'MailController@daily_maintenance_report']);

Route::get('admin/permissions', ['uses' => 'AdminController@permissions', 'as' => 'admin.permissions']);
Route::get('equipment/{id}/parts', ['uses' => 'EquipmentController@parts', 'as' => 'equipment.parts']);
Route::post('equipment/assign_equipment_parts', ['uses' => 'EquipmentController@assign_equipment_parts', 'as' => 'equipment.parts.assign_equipment']);


Route::get('equipment/table', ['uses' => 'EquipmentController@table', 'as' => 'equipment.table']);
Route::get('equipment/{id}/intervals', ['uses' => 'EquipmentController@intervals', 'as' => 'equipment.intervals']);
Route::get('equipment/{id}/intervals_create', ['uses' => 'EquipmentController@intervals_create', 'as' => 'equipment.intervals.create']);
Route::get('equipment/{id}/intervals_edit', ['uses' => 'EquipmentController@intervals_edit', 'as' => 'equipment.intervals.edit']);
Route::post('intervals/intervals_update', ['uses' => 'IntervalController@intervals_update', 'as' => 'intervals.intervals_update']);
Route::post('equipment/intervals_store', ['uses' => 'EquipmentController@intervals_store', 'as' => 'equipment.intervals.intervals_store']);
Route::get('equipment/{id}/history', ['uses' => 'EquipmentController@history', 'as' => 'equipment.history']);

Route::resource('mechanic_dashboard', 'MechanicDashboardController');
Route::resource('equipment', 'EquipmentController');
Route::resource('tags', 'TagController');
Route::resource('intervals', 'IntervalController');
Route::resource('parts', 'PartController');
Route::resource('users', 'UserController');
Route::resource('equipmenttypes', 'EquipmentTypeController');
Route::resource('makes', 'MakeController');
Route::resource('models', 'EmodelController');
Route::resource('years', 'YearController');
Route::resource('workorders', 'WorkorderController');
Route::resource('admin','AdminController');
Route::resource('admintypes','AdminTypesController');
Route::resource('adminparts','AdminPartsController');
Route::resource('adminintervals','AdminIntervalsController');
Route::resource('stations','StationController');
Route::resource('reports','ReportController');
Route::resource('company','CompanyController');
Route::resource('fuel_groups','FuelGroupController');
Route::resource('shop','ShopController');
Route::resource('company_profile','CompanyProfileController');

Route::post('years/assign_parts', ['uses' => 'YearController@assign_parts', 'as' => 'years.assign_parts']);
Route::post('parts/assign_years', ['uses' => 'PartController@assign_years', 'as' => 'parts.assign_years']);
Route::post('parts/assign_intervals', ['uses' => 'PartController@assign_intervals', 'as' => 'parts.assign_intervals']);


// Route::resource('models', 'ModelController');
// Route::resource('trims', 'TrimController');
Auth::routes();

// Route::get('stmirror', ['uses' => 'StationController@mirror', 'as' => 'stations.mirror']);
Route::get('/stmirror', 'StationController@mirror');
Route::get('/home', 'HomeController@index');
// Route::get('/md', 'MechanicDashboardController@index');
