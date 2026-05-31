<?php

namespace App\Http\Controllers;

use App\Models\Document;

class DocumentVerificationController extends Controller
{
    public function show($hash)
    {
        $document = Document::where('verification_hash', $hash)
                    ->with('employee.user', 'company')
                    ->firstOrFail();

        return view('documents.verify', compact('document'));
    }
}