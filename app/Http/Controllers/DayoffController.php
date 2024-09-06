<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\LeaveDate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DayoffController extends Controller
{
    //  public function index()
    public function index()
    {
        return view('dayoff.index');
    }


    public function create()
    {

        return view('dayoff.create');
    }

    public function destroy($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->delete();

        return redirect()->route('dayoff.index')->with('success', 'Request deleted successfully');
    }
    public function view($id)
    {
        $leaveRequest = LeaveRequest::with('user')->findOrFail($id);
        return view('dayoff.show', compact('leaveRequest'));
    }

    public function approve(Request $request, $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        // Kiểm tra hành động của người dùng
        if ($request->input('action') == 'approve') {
            $leaveRequest->is_confirm = 1; // Đã phê duyệt
        } elseif ($request->input('action') == 'reject') {
            $leaveRequest->is_confirm = 2; // Đã từ chối
        }

        // Lưu cập nhật vào DB
        $leaveRequest->save();

        // Điều hướng hoặc trả về kết quả cho người dùng
        return redirect()->back()->with('success', 'Trạng thái đã được cập nhật thành công.');
    }

    public function store(Request $request)
    {

        if (Auth::check()) {
            $userId = Auth::id(); // Lấy user ID
        } else {
            return redirect()->back()->withErrors('Bạn phải đăng nhập để gửi yêu cầu nghỉ phép.');
        }
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'loai_nghi_phep' => 'required|integer', // Loại nghỉ phép (int)
            'content' => 'required|string', // Nội dung
            'leave_dates' => 'required|string' // Chuỗi ngày nghỉ đã chọn
        ]);

        // Tạo yêu cầu nghỉ phép
        $leaveRequest = LeaveRequest::create([
            'user_id' => $userId, // ID người dùng đang đăng nhập
            'leave_type' => $validatedData['loai_nghi_phep'], // Loại nghỉ phép
            'content' => $validatedData['content'], // Nội dung
            'is_confirm' => 0,
        ]);

        // Chuyển chuỗi ngày thành mảng
        $leaveDates = explode(',', $validatedData['leave_dates']);

        // Lưu các ngày nghỉ vào bảng leave_dates
        foreach ($leaveDates as $date) {
            LeaveDate::create([
                'leave_request_id' => $leaveRequest->id,
                'leave_date' => $date
            ]);
        }

        return redirect()->back()->with('success', 'Yêu cầu nghỉ phép đã được gửi thành công.');
    }



    public function getData(Request $request)
    {
        // Lấy dữ liệu từ bảng leave_requests
        $leaveRequest = LeaveRequest::with('user')->select('leave_requests.*');

        return DataTables::eloquent($leaveRequest)
            ->addIndexColumn()

            ->addColumn('user_id', function (LeaveRequest $leaveRequest) {
                return  $leaveRequest->user->name;
            })
            // Cột trạng thái xác nhận
            ->addColumn('status_label', function (LeaveRequest $leaveRequest) {
                return '<span class="badge ' . ($leaveRequest->is_confirm ? 'bg-success' : 'bg-danger') . '">' . ($leaveRequest->is_confirm ? 'Đã xác nhận' : 'Chưa xác nhận') . '</span>';
            })

            // Cột nội dung
            ->addColumn('content', function (LeaveRequest $leaveRequest) {
                return $leaveRequest->content; // Loại bỏ các thẻ HTML từ content
            })

            // Cột loại nghỉ phép
            ->addColumn('leave_type_label', function (LeaveRequest $leaveRequest) {
                return $leaveRequest->leave_type == 1 ? 'Nghỉ phép' : 'Làm việc online';
            })

            // Cột hành động
            ->addColumn('actions', function (LeaveRequest $leaveRequest) {
                return view('partials.dayoff_actions', compact('leaveRequest'))->render();
            })

            // Khai báo các cột có chứa HTML
            ->rawColumns(['status_label', 'actions', 'content'])

            // Xuất ra DataTable
            ->make(true);
    }
}
