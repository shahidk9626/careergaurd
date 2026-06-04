<?php

namespace App\Http\Controllers;

use App\Models\CallbackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallbackRequestController extends Controller
{
    /**
     * Store a callback request from the customer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'concern' => 'required|string',
            'flag' => 'required|string|in:direct,purchased,enquiry',
            'purchased_plan_id' => 'nullable|exists:purchased_plans,id',
            'claim_id' => 'nullable|exists:claims,id',
        ]);

        CallbackRequest::create([
            'user_id' => Auth::id(),
            'purchased_plan_id' => $request->purchased_plan_id ?: null,
            'claim_id' => $request->claim_id ?: null,
            'flag' => $request->flag,
            'concern' => $request->concern,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your callback request has been submitted successfully.'
        ]);
    }

    /**
     * Display a listing of callback requests in the admin panel.
     */
    public function adminIndex()
    {
        if (!hasPermission('request-callback.view')) {
            abort(403, 'Unauthorized action.');
        }

        $requests = CallbackRequest::with(['user', 'purchasedPlan', 'claim'])->latest()->get();

        return view('admin.request-callback.index', compact('requests'));
    }

    /**
     * Update the status of a callback request.
     */
    public function updateStatus(Request $request)
    {
        if (!hasPermission('request-callback.status')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $request->validate([
            'request_id' => 'required|exists:callback_requests,id',
            'status' => 'required|string|in:pending,contacted,resolved,closed',
            'description' => 'nullable|string',
        ]);

        $callbackRequest = CallbackRequest::findOrFail($request->request_id);
        $callbackRequest->status = $request->status;
        $callbackRequest->description = $request->description;
        $callbackRequest->save();

        return response()->json([
            'success' => 'Callback status updated successfully!'
        ]);
    }

    /**
     * Delete a callback request.
     */
    public function destroy($id)
    {
        if (!hasPermission('request-callback.delete')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $callbackRequest = CallbackRequest::findOrFail($id);
        $callbackRequest->delete();

        return response()->json([
            'success' => 'Callback request deleted successfully.'
        ]);
    }

    /**
     * Bulk delete callback requests.
     */
    public function bulkDestroy(Request $request)
    {
        if (!hasPermission('request-callback.delete')) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:callback_requests,id',
        ]);

        CallbackRequest::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => 'Selected callback requests deleted successfully.'
        ]);
    }

    /**
     * Export callback requests to Excel.
     */
    public function export(Request $request)
    {
        if (!hasPermission('request-callback.export')) {
            abort(403, 'Unauthorized action.');
        }

        $query = CallbackRequest::with(['user', 'purchasedPlan', 'claim'])->latest();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('whatsapp_number', 'like', "%{$search}%");
                })
                ->orWhere('flag', 'like', "%{$search}%")
                ->orWhere('concern', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhereDate('created_at', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $requests = $query->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Headers
        $headers = [
            'A1' => 'ID',
            'B1' => 'Customer Name',
            'C1' => 'Email',
            'D1' => 'Phone',
            'E1' => 'Flag',
            'F1' => 'Concern',
            'G1' => 'Status',
            'H1' => 'Created Date'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Apply styling to headers
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF7E22CE'], // Purple matching primary theme
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Populate Data
        $rowNumber = 2;
        foreach ($requests as $req) {
            $phone = $req->user->phone ?: ($req->user->whatsapp_number ?: 'N/A');
            
            $sheet->setCellValue('A' . $rowNumber, $req->id);
            $sheet->setCellValue('B' . $rowNumber, $req->user->name);
            $sheet->setCellValue('C' . $rowNumber, $req->user->email);
            $sheet->setCellValue('D' . $rowNumber, $phone);
            $sheet->setCellValue('E' . $rowNumber, ucfirst($req->flag));
            $sheet->setCellValue('F' . $rowNumber, $req->concern);
            $sheet->setCellValue('G' . $rowNumber, ucfirst($req->status));
            $sheet->setCellValue('H' . $rowNumber, $req->created_at->format('Y-m-d H:i:s'));

            $rowNumber++;
        }

        // Auto-fit columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = 'Callback_Requests_' . date('Y-m-d') . '.xlsx';

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
}
