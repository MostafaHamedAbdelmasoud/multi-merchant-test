<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 12/11/20
 * Time: 12:57 م
 */

namespace App\Services\Auth;


use App\Models\User\User;
use App\Repositories\AppRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationApiService extends AppRepository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function confirm(Request $request)
    {
        $user = Auth::user();
        if ($user->verified_code == $request->code) {
            $user->update([
                'verified_code' => null,
                'email_verified_at' => Carbon::now(),
            ]);
            return true;
        }
        return false;
    }

    public function resendCode($phone, $verified_code = null)
    {
        $user = $this->findByColumn('phone', $phone);
        if (!$user->email_verified_at) {
            return $user->update([
                'verified_code' => $verified_code,
            ]);
        }
        return false;
    }

    public function updatePhone($phone, $verified_code = 0)
    {
        $customerAuthService = new CustomerApiAuthService;
        $membership_id = $customerAuthService->getlowestMembershipOrder();

        $user = Auth::user();


//        if ($user->phone == null) {
//            return false;
//        }
        $user->update([
            'phone' => $phone,
            'membership_id' => $membership_id,
            'verified_code' => $verified_code,
            'email_verified_at' => null,
        ]);
        return true;
    }
}
