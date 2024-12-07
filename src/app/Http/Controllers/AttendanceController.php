<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class AttendanceController extends Controller
{
     // 勤怠データ一覧の表示
    public function index()
    {
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user->id)->where('date', $date)->first();

        // ボタンの状態を決定するロジック
        $buttonStates = [
            'start_work' => !$attendance, // 勤務開始ボタンは出勤記録がない場合に押せる
            'end_work' => $attendance && $attendance->start_work && !$attendance->end_work, // 勤務終了ボタンは勤務開始済みで終了していない場合
            'start_rest' => $attendance && $attendance->start_work && !$attendance->end_work && !$attendance->rests()->whereNull('end_rest')->exists(), // 休憩開始ボタンは休憩中でない場合
            'end_rest' => $attendance && $attendance->rests()->whereNull('end_rest')->exists(), // 休憩終了ボタンは休憩中の場合
        ];

        return view('index', [
            'attendance' => $attendance,
            'buttonStates' => $buttonStates,
        ]);
    }

    // 勤務開始
    public function startWork(Request $request)
    {
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');

        if (Attendance::where('user_id', $user->id)->where('date', $date)->exists()) {
            return redirect('/')->with('error', '勤務開始済みです');
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => $date,
            'start_work' => Carbon::now(),
        ]);

        return redirect('/')->with('message', '勤務開始を記録しました');
    }

    // 勤務終了
    public function endWork(Request $request)
    {
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user->id)->where('date', $date)->first();

        if (!$attendance || !$attendance->start_work) {
            return redirect('/')->with('error', '勤務開始を記録してください');
        }

        if ($attendance->end_work) {
            return redirect('/')->with('error', '既に勤務終了済みです');
        }

        $attendance->update(['end_work' => Carbon::now()]);

        return redirect('/')->with('message', '勤務終了を記録しました');
    }

    // 休憩開始
    public function startRest(Request $request)
    {
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user->id)->where('date', $date)->first();

        if (!$attendance || !$attendance->start_work || $attendance->end_work) {
            return redirect('/')->with('error', '勤務中でないため休憩開始できません');
        }

        if ($attendance->rests()->whereNull('end_rest')->exists()) {
            return redirect('/')->with('error', '既に休憩中です');
        }

        Rest::create([
            'attendance_id' => $attendance->id,
            'start_rest' => Carbon::now(),
        ]);

        return redirect('/')->with('message', '休憩開始を記録しました');
    }

    // 休憩終了
    public function endRest(Request $request)
    {
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        $attendance = Attendance::where('user_id', $user->id)->where('date', $date)->first();

        if (!$attendance || !$attendance->rests()->whereNull('end_rest')->exists()) {
            return redirect('/')->with('error', '休憩中ではありません');
        }

        $rest = $attendance->rests()->whereNull('end_rest')->first();
        $rest->update(['end_rest' => Carbon::now()]);

        return redirect('/')->with('message', '休憩終了を記録しました');
    }
    public function attendance(Request $request)
    {
        // 日付の取得またはデフォルト設定
        $displayDate = $request->input('displayDate')
            ? Carbon::parse($request->input('displayDate'))
            : Carbon::today();

        // ボタン操作による日付変更
        if ($request->input('dateChange') === 'prev') {
            $displayDate = $displayDate->subDay();
        } elseif ($request->input('dateChange') === 'next') {
            $displayDate = $displayDate->addDay();
        }

        // ユーザー情報の取得
        $users = User::with(['attendances' => function ($query) use ($displayDate) {
            $query->where('date', $displayDate->format('Y-m-d'));
        }, 'attendances.rests'])->paginate(5);

        foreach ($users as $user) {
            // リレーションを通じてデータを取得
            $attendance = $user->attendances()->where('date', $displayDate->format('Y-m-d'))->first();

            if ($attendance) {
                $user->start = $attendance->start_work ?? 'N/A'; // start_workに変更
                $user->end = $attendance->end_work ?? 'N/A'; // end_workに変更

                $totalRestSeconds = $attendance->rests->isEmpty()
                    ? 0
                    : $attendance->rests->sum(function ($rest) {
                        $start = Carbon::parse($rest->start_rest);
                        $end = $rest->end_rest ? Carbon::parse($rest->end_rest) : Carbon::now();
                        return $start->diffInSeconds($end);
                    });

                $user->total_rest = gmdate('H:i:s', $totalRestSeconds);

                if ($attendance->start_work && $attendance->end_work) {
                    $start = Carbon::parse($attendance->start_work);
                    $end = Carbon::parse($attendance->end_work);
                    $totalWorkSeconds = $start->diffInSeconds($end) - $totalRestSeconds;
                    $user->total_work = gmdate('H:i:s', max($totalWorkSeconds, 0));
                } else {
                    $user->total_work = 'N/A';
                }
            } else {
                $user->start = $user->end = $user->total_rest = $user->total_work = 'N/A';
            }
        }

        // ビューへのデータ渡し
        return view('attendance_date', compact('users', 'displayDate'));
    }

}