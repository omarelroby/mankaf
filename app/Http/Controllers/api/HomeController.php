<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\CountryResource;
use App\Http\Resources\UserResource;
use App\Models\Country;
use App\Models\User;
use App\Traits\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use response;


    public function countries()
    {
        $countries = Country::all();
        return $this->success(CountryResource::collection($countries));

    }

    public function user_register(Request $request)
    {
        $oValidatorRules =
            [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'phone' => 'required',
                'password' => 'required',
                'country_id' => 'required|exists:countries,id',
            ];
        $validator = Validator::make($request->all(), $oValidatorRules);
        if ($validator->fails()) {
            return $this->error($validator->messages());
        }
        $data = $request->all();
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $code =rand ( 10000 , 99999 );
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'country_id' => $data['country_id'],
            'confirmation_code' => $code,
        ]);
        return $this->successMessage(__('messages.success'));
    }

    public function user_verify(Request $request)
    {
        $oValidatorRules =
            [
                'verification_code' => 'required',
                 'phone' => 'required',
            ];
        $validator = Validator::make($request->all(), $oValidatorRules);
        if ($validator->fails()) {
            return $this->error($validator->messages());
        }
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->confirmation_code == $request->verification_code) {
                $user->update([
                    'verify' => 1,
                    'confirmation_code' => null,
                ]);
                return $this->successMessage(__('messages.activation'));
            } else {
                return $this->error(__('messages.error-active'));
            }


        } else
        {
            return $this->error(__('messages.check'));
        }
    }

    public function user_login(Request $request)
    {
        $oValidatorRules =
            [
                'email' => 'required',
                'password' => 'required',
            ];
        $validator = Validator::make($request->all(), $oValidatorRules);
        if ($validator->fails()) {
            return $this->error($validator->messages());
        }
        $user = User::where('email', $request->email)->first();
        if ($user)
        {
            if ($user->verify == 1)
            {
                if (Hash::check($request->password, $user->password)) {
                    $data =
                        [
                            'user' => new UserResource($user),
                            'token' => $user->createToken($user->name)->accessToken,
                        ];
                    return $this->success($data);
                }
                else
                {
                    return $this->error(__('messages.password-wrong'));
                }
            }
            else
            {
                return $this->error(__('messages.email-not-active'));
            }
        }
        else
        {
            return $this->error(__('messages.error-email'));
        }

    }
    public function forget_password(Request $request)
    {
        $oValidatorRules =
            [
                'phone' => 'required',
             ];
        $validator = Validator::make($request->all(), $oValidatorRules);
        if ($validator->fails()) {
            return $this->error($validator->messages());
        }
        $user=User::where('phone',$request->phone)->first();
        if($user)
        {
             $code =rand ( 10000 , 99999 );
             $user->update(['confirmation_code'=>$code]);
             return $this->success(__('messages.send-code'));
        }
        else
        {
            return $this->error(__('messages.check'));
        }
    }
    public function reset_password(Request $request)
    {
        $oValidatorRules =
            [
                'phone' => 'required',
                'code' => 'required',
                'newPassword' => 'required',
            ];
        $validator = Validator::make($request->all(), $oValidatorRules);
        if ($validator->fails())
        {
            return $this->error($validator->messages());
        }
        $user=User::where('phone',$request->phone)->first();
        if ($user)
        {
            if ($user->confirmation_code==$request->code)
            {
                $user->update([
                    'password'=>bcrypt($request->newPassword),
                    'confirmation_code'=>null,
                    'verify'=>1
                ]);
                return $this->error(__('messages.changed-password'));
            }
            else
            {
                return $this->error(__('messages.error-active'));
            }
        }
        else
        {
            return $this->error(__('messages.check'));

        }
    }
}
