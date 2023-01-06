<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;
// require 'vendor/autoload.php';
use Plivo\RestClient;
use App\Company;
use App\Equipment;
use App\User;

class MailController extends Controller
{

    private function oled(){
      // $equipments = Company::findOrFail(1)->equipment()->get();
      // foreach ($equipments as $equipment) {
      //   $equipment = $equipment->get_and_caluculate_intervals();
      //   $equipment = $this->calculate_intervals($equipment, $equipment->intervals);
      //   // echo "$equipment->name === okay:$equipment->okay upcoming:$equipment->upcoming current:$equipment->current overdue:$equipment->overdue<br>";
      // }
    }

    public function daily_maintenance_report(){

      $users = Company::findOrFail(1)->assigned_equipment_users()->get();
      $client = new RestClient(env('PLIVO_AUTH_ID', false), env('PLIVO_AUTH_TOKEN', false));
      foreach ($users as $user) {
        // echo "<br>$user->first_name<br>";
        $equipments = User::findOrFail($user->id)->equipment()->where('daily','=', 1)->get();
        $send_message_flag=0;
        foreach ($equipments as $equipment) {
          // echo "$equipment->name<br>";
          $equipment = $equipment->get_and_caluculate_intervals();
          if($equipment->upcoming || $equipment->current || $equipment->overdue){
            $send_message_flag=1;
          }
        }
        if($send_message_flag){
          $message = view('emails.test',compact('equipments'))->render();
          // echo $message;
          $cell_numbers = ['+1'.$user->cell_number];
          $message_created = $client->messages->create(
              '+13852136960',
              $cell_numbers,
              $message
          );
        }
      }
      return true;
    }

    public function send2(){
      // die();
      Mail::send(new SendMail());
    }
}
