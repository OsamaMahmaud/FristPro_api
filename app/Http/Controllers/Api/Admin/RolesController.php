<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Requests\RolesRequest;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class RolesController extends Controller
{

    use GeneralTrait;
    public function index()
    {
       return $roles = Role::get(); // use pagination and  add custom pagination on index.blade
        // return view('dashboard.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('dashboard.roles.create');
    }

    public function saveRole(Request $request)
    {

        // try {

        //     $role = $this->process(new Role, $request);
        //     if ($role)
        //         return $this->sendResponse($role->toArray(), 'تم ألاضافة بنجاح');
        //     else
        //     return $this->sendResponse($role->toArray(), ' رساله الخطا ');
        // } catch (\Exception $ex) {
        //     return $ex;
        //     // return message for unhandled exception
        //     return $this->sendResponse($role->toArray(), ' رساله الخطا ');
        // }

         # code...
         $input = $request->all();
         $validator = Validator::make($input, [
             'name'=> 'required',
             'permissions'=>'required|array|min:1',
         ] );

         if ($validator->fails()) {
             $code = $this->returnCodeAccordingToInput($validator);
             return $this->returnValidationError($code, $validator);
         }
         $role = Role::create($input);

         return $this->sendResponse($role->toArray(), 'role created succesfully');
    }

    // public function edit($id)
    // {
    //       $role = Role::findOrFail($id);
    //     return view('dashboard.roles.edit',compact('role'));
    // }

    // public function update($id,RolesRequest $request)
    // {
    //     try {
    //         $role = Role::findOrFail($id);
    //         $role = $this->process($role, $request);
    //         if ($role)
    //             return redirect()->route('admin.roles.index')->with(['success' => 'تم التحديث بنجاح']);
    //         else
    //             return redirect()->route('admin.roles.index')->with(['error' => 'رساله الخطا']);
    //     } catch (\Exception $ex) {
    //         // return message for unhandled exception
    //         return redirect()->route('admin.roles.index')->with(['error' => 'رساله الخطا']);
    //     }


    // }

    public function update(Request $request , Role $role)
        {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name'=> 'required',
                'permissions'=>'required|array|min:1',
            ]);
            if ($validator -> fails()) {
                # code...
                return $this->sendError('error validation', $validator->errors());
            }
            $role->name =  $input['name'];
            $role->permissions =  $input['permissions'];
            $role->save();
            return $this->sendResponse($role->toArray(), 'role  updated succesfully');
        }

    // protected function process(Role $role, Request $r)
    // {
    //     $role->name = $r->name;
    //     $role->permissions = json_encode($r->permissions);
    //     $role->save();
    //     return $role;
    // }


}
