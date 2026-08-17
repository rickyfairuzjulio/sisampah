<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    /**
     * Display Audit Logs & Violation Reports.
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('actor');

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('reason', 'like', "%{$search}%")
                  ->orWhere('entity_type', 'like', "%{$search}%");
            });
        }

        $auditLogs = $query->latest()->paginate(20)->withQueryString();

        // Flagged transactions (e.g. weight > 100kg or total > 1,000,000)
        $suspiciousTransactions = Transaction::with(['user', 'trashCategory', 'bankSampah'])
            ->where('berat_kg', '>', 100)
            ->orWhere('total_rp', '>', 1000000)
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'total_audit_logs' => AuditLog::count(),
            'suspicious_transactions' => $suspiciousTransactions->count(),
            'total_actions_today' => AuditLog::whereDate('created_at', today())->count(),
        ];

        return view('admin.pelanggaran.index', compact('auditLogs', 'suspiciousTransactions', 'stats'));
    }
}
