<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Gate;
use App\UserImage;
use DB;

class UserController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request) {
    if (Gate::denies('USERS'))
      return deny();
    $data = $this->setFormData('users', 'users', '\App\User', $request, 'List of Users', 'between', FALSE);
    if (auth()->user()->id > 1) {
      $data['users'] = $data['users']->where('id', '>', 1);
    }
    $data['users'] = $data['users']->get();

    return view('users.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    // return view('users.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    if (Gate::denies('MODIFY-USERS'))
      return deny();
    $this->validate($request, [
      'name' => 'required|max:255',
      'role_id' => 'required|integer|min:0',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:6|confirmed',
    ]);
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);
    $user->roles()->sync($request->role_id);
    return redirect('users');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    if (Gate::denies('MODIFY-USERS'))
      return deny();
    $user1 = \App\User::findOrFail($id);
    $user1->role_id = $user1->roles[0]->id;
    return view('users.edit', compact('user1'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    if (Gate::denies('MODIFY-USERS'))
      return deny();
    $data = $request->all();
    $user = \App\User::findOrFail($id);
    $user->name = $data['name'];
    $user->email = $data['email'];
    if (strlen($data['password']) > 0)
      $user->password = bcrypt($data['password']);
    $user->save();
    $user->roles()->sync([$request->role_id]);
    return redirect('users');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    //
  }

  public function chngPassword() {
    return view('users.updt_password');
  }

  public function updatePassword(Request $request) {
    $rules = [];
    $user = $request->user();
    if (!auth()->attempt(['email' => $user->email, 'password' => $request->old_password])) {
      flash()->error('Wrong old password. Authentication failed');
      return redirect()->back();
    }
    $this->validate($request, $rules + [
      'password' => 'required|min:6|confirmed',
    ]);

    $user->password = bcrypt($request['password']);
    $user->update();
    flash()->success('Password updated successfully.');
    return redirect()->back();
  }

  public function getupload(Request $request){
      return view('users.upload');
  }

  public function addUserupload(Request $request){
    $file = $request->file('image');
    $this->validate($request,[
      'image' => 'required|file|mimes:jpeg,bmp,png,jpg|max:' . config('college.max_photo_upload_size')
    ]);
    if($file){
      $user_image =  UserImage::firstOrNew(['user_id'=>auth()->user()->id]);
      $user_image->extension = $file->getClientOriginalExtension();
      $user_image->file_name = $file->getClientOriginalName();
      $user_image->mime_type = $file->getMimeType();
      DB::beginTransaction();
          $user_image->save();
          $file->move(storage_path('app/user-images/'), $user_image->id .'.'.$user_image->extension);
      DB::commit();
    }
    return redirect()->back();
    
  }

  public function showUserImage($id){
    $file = UserImage::findOrFail($id);
    if ($file) {
        $file_path = storage_path() . "/app/user-images/" .$id .'.'. $file->extension;
        return response()->file($file_path);
    }
  }

}
