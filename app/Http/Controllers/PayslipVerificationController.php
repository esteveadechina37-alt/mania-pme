<?php

namespace App\Http\Controllers;

use App\Models\Payslip;

class PayslipVerificationController extends Controller
{
    public function show($hash)
    {
        $payslip = Payslip::where('verification_hash', $hash)
                    ->with('employee.user', 'company')
                    ->firstOrFail();

        return view('payslips.verify', compact('payslip'));
    }
}