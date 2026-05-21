<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Récupère (ou crée) la fiche employé de l'utilisateur connecté.
     */
    private function getEmployee(): Employee
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)
                    ->withTrashed()
                    ->first();

        if ($employee) {
            if ($employee->trashed()) {
                $employee->restore();
            }
            $employee->update([
                'status'    => $employee->status ?: 'active',
                'hire_date' => $employee->hire_date ?: now(),
            ]);
            return $employee;
        }

        return Employee::create([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'status'     => 'active',
            'hire_date'  => now(),
        ]);
    }

    /**
     * Page de pointage (employé/stagiaire).
     */
    public function index()
    {
        $employee = $this->getEmployee();
        $today = now()->toDateString();

        // Vérifier si un pointage existe déjà aujourd'hui
        $attendance = Attendance::where('employee_id', $employee->id)
                        ->where('date', $today)
                        ->first();

        return view('attendances.index', compact('attendance'));
    }

    /**
     * Pointer l'arrivée.
     */
    public function checkIn(Request $request)
    {
        $employee = $this->getEmployee();
        $company = $employee->company;
        $today = now()->toDateString();
        $now = now()->toTimeString();

        // Vérification de la géolocalisation si l'entreprise a défini une zone
        if ($company->latitude && $company->longitude) {
            $request->validate([
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $distance = $this->haversine(
                $company->latitude, $company->longitude,
                $request->latitude, $request->longitude
            );

            if ($distance > $company->geofence_radius) {
                return back()->with('error', 'Vous êtes trop loin du lieu de travail pour pointer.');
            }
        }

        // ... reste de la logique existante (vérification doublon, création pointage)
        // Vérifier si déjà pointé aujourd'hui
        $attendance = Attendance::where('employee_id', $employee->id)
                        ->where('date', $today)
                        ->first();

        if ($attendance) {
            return back()->with('error', 'Vous avez déjà pointé votre arrivée aujourd\'hui.');
        }

        // Créer le pointage
        $status = 'present';
        // Heure limite d'arrivée : 08:30
        if (now()->toTimeString() > '08:30:00') {
            $status = 'late';
        }
        Attendance::create([
            'employee_id' => $employee->id,
            'company_id'  => $employee->company_id,
            'date'        => $today,
            'check_in'    => $now,
            'status'      => $status,
        ]);
        // Attendance::create([
        //     'employee_id' => $employee->id,
        //     'company_id'  => $employee->company_id,
        //     'date'        => $today,
        //     'check_in'    => $now,
        //     'status'      => 'present',
        // ]);

        return back()->with('success', 'Arrivée pointée avec succès à ' . date('H:i'));
    }

    // public function checkIn()
    // {
    //     $employee = $this->getEmployee();
    //     $today = now()->toDateString();
    //     $now = now()->toTimeString();

    //     // Vérifier si déjà pointé aujourd'hui
    //     $attendance = Attendance::where('employee_id', $employee->id)
    //                     ->where('date', $today)
    //                     ->first();

    //     if ($attendance) {
    //         return back()->with('error', 'Vous avez déjà pointé votre arrivée aujourd\'hui.');
    //     }

    //     // Créer le pointage
    //     Attendance::create([
    //         'employee_id' => $employee->id,
    //         'company_id'  => $employee->company_id,
    //         'date'        => $today,
    //         'check_in'    => $now,
    //         'status'      => 'present',
    //     ]);

    //     return back()->with('success', 'Arrivée pointée avec succès à ' . date('H:i'));
    // }

    /**
     * Pointer le départ.
     */
    public function checkOut(Request $request)
    {
        $employee = $this->getEmployee();
        $company = $employee->company;
        $today = now()->toDateString();
        $now = now()->toTimeString();

        // Vérification de la géolocalisation si l'entreprise a défini une zone
        if ($company->latitude && $company->longitude) {
            $request->validate([
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $distance = $this->haversine(
                $company->latitude, $company->longitude,
                $request->latitude, $request->longitude
            );

            if ($distance > $company->geofence_radius) {
                return back()->with('error', 'Vous êtes trop loin du lieu de travail pour pointer votre départ.');
            }
        }

        // Vérifier si un pointage d'arrivée existe aujourd'hui
        $attendance = Attendance::where('employee_id', $employee->id)
                        ->where('date', $today)
                        ->first();

        if (!$attendance) {
            return back()->with('error', 'Vous n\'avez pas pointé votre arrivée aujourd\'hui.');
        }

        if ($attendance->check_out) {
            return back()->with('error', 'Vous avez déjà pointé votre départ aujourd\'hui.');
        }

        $attendance->update(['check_out' => $now]);

        return back()->with('success', 'Départ pointé avec succès à ' . date('H:i'));
    }
    // public function checkOut()
    // {
    //     $employee = $this->getEmployee();
    //     $today = now()->toDateString();
    //     $now = now()->toTimeString();

    //     $attendance = Attendance::where('employee_id', $employee->id)
    //                     ->where('date', $today)
    //                     ->first();

    //     if (!$attendance) {
    //         return back()->with('error', 'Vous n\'avez pas pointé votre arrivée aujourd\'hui.');
    //     }

    //     if ($attendance->check_out) {
    //         return back()->with('error', 'Vous avez déjà pointé votre départ aujourd\'hui.');
    //     }

    //     $attendance->update(['check_out' => $now]);

    //     return back()->with('success', 'Départ pointé avec succès à ' . date('H:i'));
    // }

    /**
     * Historique personnel (employé/stagiaire).
     */
    public function history()
    {
        $employee = $this->getEmployee();
        $attendances = Attendance::where('employee_id', $employee->id)
                        ->latest('date')
                        ->paginate(15);

        return view('attendances.history', compact('attendances'));
    }

    /**
     * Liste des présences pour le manager (son département) ou l'admin (toute l'entreprise).
     */
    public function list(Request $request)
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $date = $request->date ?: now()->toDateString(); // date sélectionnée ou aujourd'hui

        if ($user->hasRole('admin')) {
            $attendances = Attendance::where('company_id', $companyId)
                            ->where('date', $date)
                            ->with('employee.user')
                            ->paginate(15);
        } elseif ($user->hasRole('manager')) {
            $department = \App\Models\Department::where('manager_id', $user->id)->first();
            if ($department) {
                $employeeIds = $department->employees()->pluck('id');
                $attendances = Attendance::whereIn('employee_id', $employeeIds)
                                ->where('date', $date)
                                ->with('employee.user')
                                ->paginate(15);
            } else {
                $attendances = collect([]);
            }
        } else {
            abort(403);
        }

        return view('attendances.list', compact('attendances', 'date'));
    }
    // public function list()
    // {
    //     $user = Auth::user();
    //     $companyId = $user->company_id;

    //     if ($user->hasRole('admin')) {
    //         $attendances = Attendance::where('company_id', $companyId)
    //                         ->where('date', now()->toDateString())
    //                         ->with('employee.user')
    //                         ->paginate(15);
    //     } elseif ($user->hasRole('manager')) {
    //         $department = \App\Models\Department::where('manager_id', $user->id)->first();
    //         if ($department) {
    //             $employeeIds = $department->employees()->pluck('id');
    //             $attendances = Attendance::whereIn('employee_id', $employeeIds)
    //                             ->where('date', now()->toDateString())
    //                             ->with('employee.user')
    //                             ->paginate(15);
    //         } else {
    //             $attendances = collect([]);
    //         }
    //     } else {
    //         abort(403);
    //     }

    //     return view('attendances.list', compact('attendances'));
    // }

    /**
 * Calcule la distance (en mètres) entre deux points GPS (formule de Haversine).
 */
    private function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // rayon de la Terre en mètres

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

        /**
     * Récapitulatif hebdomadaire pour l'employé connecté.
     */
    public function weekly()
    {
        $employee = $this->getEmployee();
        $startOfWeek = now()->startOfWeek(); // lundi
        $endOfWeek = now()->endOfWeek();     // dimanche

        $attendances = Attendance::where('employee_id', $employee->id)
                        ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
                        ->orderBy('date')
                        ->get();

        $totalLate = $attendances->where('status', 'late')->count();
        $totalPresent = $attendances->where('status', 'present')->count();

        return view('attendances.weekly', compact('attendances', 'startOfWeek', 'endOfWeek', 'totalLate', 'totalPresent'));
    }

        public function exportPdf()
    {
        $employee = $this->getEmployee();
        $attendances = Attendance::where('employee_id', $employee->id)
                        ->orderBy('date', 'desc')
                        ->get();

        $pdf = \PDF::loadView('attendances.pdf', compact('attendances', 'employee'));
        return $pdf->download('pointages-'.$employee->user->name.'.pdf');
    }

    //  la méthode d’export PDF pour la liste des présences (admin/manager)
    public function exportListPdf(Request $request)
    {
        $user = Auth::user();
        $companyId = $user->company_id;
        $date = $request->date ?: now()->toDateString();

        if ($user->hasRole('admin')) {
            $attendances = Attendance::where('company_id', $companyId)
                            ->where('date', $date)
                            ->with('employee.user')
                            ->get();
        } elseif ($user->hasRole('manager')) {
            $department = \App\Models\Department::where('manager_id', $user->id)->first();
            if ($department) {
                $employeeIds = $department->employees()->pluck('id');
                $attendances = Attendance::whereIn('employee_id', $employeeIds)
                                ->where('date', $date)
                                ->with('employee.user')
                                ->get();
            } else {
                $attendances = collect([]);
            }
        } else {
            abort(403);
        }

        $pdf = \PDF::loadView('attendances.list-pdf', compact('attendances', 'date'));
        return $pdf->download('presences-' . $date . '.pdf');
    }
}