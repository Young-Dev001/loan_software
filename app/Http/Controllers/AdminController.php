<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
class AdminController extends Controller
{
    // Public function AdminDashboard(){
    //     return view('admin.index');
    //  }
  
     Public function ProfileView(){
      $id = Auth::user()->id;
      $adminData = Admin::find($id);
      return view('admin.profile.index',compact('adminData'));
   }
  
     public function StoreProfile(Request $request)
      {
          $id = Auth::user()->id;
          $data = Admin::find($id);
          $originalData = $data->toArray(); // Store the original data for comparison later
  
          $data->name = $request->name;
          $data->email = $request->email;
          $data->phone = $request->phone;
          $data->address = $request->address;
  
          if ($request->file('photo')) {
              $file = $request->file('photo');
              @unlink(public_path('upload/admin_images/' . $data->photo));
              $filename = date('YmdHi') . $file->getClientOriginalName();
              $file->move(public_path('upload/admin_images'), $filename);
              $data->photo = $filename; // update image field
          }
  
          $data->save();
  
          // Check if any changes were made by comparing the original data with the new data
          if ($this->isDataChanged($originalData, $data->toArray())) {
              // Data has changed, update the timestamp and add a message
              $data->updated_at = now();
              $data->save();
  
              $notification = [
                  'message' => 'Admin Profile Updated Successfully',
                  'alert-type' => 'success'
              ];
          } else {
              $notification = [
                  'message' => 'No changes were made to the profile',
                  'alert-type' => 'warning'
              ];
          }
  
          return redirect()->route('admin.profile.view')->with($notification);
      }
  
      // Helper function to check if data has changed
      private function isDataChanged($originalData, $newData)
      {
          foreach ($originalData as $key => $value) {
              if ($value !== $newData[$key]) {
                  return true;
              }
          }
          return false;
      }
  
      public function ChangePassword(){
        $id = Auth::user()->id;
        $adminData = Admin::find($id);
        return view('admin.profile.change_password',compact('adminData'));
  
    }// End Method
  
  
    public function UpdatePassword(Request $request){
      $validateData = $request->validate([
          'oldpassword' => 'required',
          'newpassword' => 'required|min:4',
          'confirm-password' => 'required|same:newpassword',
  
      ]);
  
      $hashedPassword = Auth::user()->password;
      if (Hash::check($request->oldpassword,$hashedPassword )) {
          $users = Admin::find(Auth::id());
          $users->password = bcrypt($request->newpassword);
          $users->save();
          $notification = [
              'message' => 'Password Changed Successfully',
              'alert-type' => 'success'
          ];
         } else {
          $notification = [
              'message' => 'Old Password Does not Match',
              'alert-type' => 'error'
          ];
         }
          return redirect()->back()->with($notification);
          
      }// End Method
  
  }
     
  
  
