<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    private function getEmployee(): Employee
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->withTrashed()->first();
        if ($employee) {
            if ($employee->trashed()) { $employee->restore(); }
            $employee->update(['status' => $employee->status ?: 'active', 'hire_date' => $employee->hire_date ?: now()]);
            return $employee;
        }
        return Employee::create([
            'user_id' => $user->id, 'company_id' => $user->company_id,
            'status' => 'active', 'hire_date' => now(),
        ]);
    }

    public function index()
    {
        $employee = $this->getEmployee();
        $documents = Document::where('employee_id', $employee->id)
                      ->orderBy('created_at', 'desc')
                      ->paginate(12);

        return view('employee.documents.index', compact('documents'));
    }

    public function download(Document $document)
    {
        $employee = $this->getEmployee();
        if ($document->employee_id !== $employee->id) {
            abort(403);
        }
        if (!\Storage::exists($document->file_path)) {
            return back()->with('error', 'Fichier introuvable.');
        }
        return \Storage::download($document->file_path);
    }
}