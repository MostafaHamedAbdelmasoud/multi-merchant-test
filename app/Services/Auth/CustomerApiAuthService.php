<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/11/20
 * Time: 01:54 م
 */

namespace App\Services\Auth;


use App\Models\User\PasswordReset;
use App\Repositories\AppRepository;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerApiAuthService extends AppRepository
{
    use AuthMethods;

    private $passwordReset;

    public function __construct()
    {
        parent::__construct(new User());
        $this->passwordReset = new AppRepository(new PasswordReset());
    }

    public function register(Request $request, $verified_code)
    {
        $request->merge([
            'type' => $request->ype,
            'verified_code' => $verified_code
        ]);
        $user = $this->model->create(
            array_merge($request->only(
                'name', 'phone', 'password', 'type', 'email',
                'image'
            ), [
                'verified_code' => $verified_code,
                'password' => $request->password,
            ]));

        unset($user['verified_code']);
        $user['token'] = $user->createToken('Customer Token')->accessToken;
        return $user;
    }


    public function forgetPassword(Request $request, $verified_code = 0)
    {
        $this->passwordReset->model->updateOrCreate([
            'email' => $request->email
        ], [
            'token' => $verified_code
        ]);
        return $request->email;
    }

    public function resetPassword(Request $request)
    {
//        $this->passwordReset->setConditions([[
//            'token', $request->code
//        ]]);
        $reset = $this->passwordReset->findByColumn(
            'email', $request->email
        );
        if ($reset) {
            $this->model->where('email', $request->email)
                ->where('type', 2)
                ->first()
                ->update([
                    'password' => $request->password,
                    'verified_code' => null,
                    'email_verified_at' => Carbon::now(),
                ]);
            return $reset->delete();
        }
        return false;
    }

    public function checkCode(Request $request)
    {
        $exists = $this->passwordReset->model->where(
            'email', $request->email
        )
            ->where('token', $request->code)
            ->exists();
        return $exists;
    }

}
