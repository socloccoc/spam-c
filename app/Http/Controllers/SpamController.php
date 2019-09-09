<?php

namespace App\Http\Controllers;

use App\CrontabSetting;
use Illuminate\Http\Request;

class SpamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $setting = CrontabSetting::where('id', 1)->first();
        return view('key.create', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cookie'       => 'required',
            'time_once'    => 'required',
            'card_number'  => 'required',
            'time_request' => 'required',
        ], []);
        $data = $request->except(['_method', '_token']);
        $data['status'] = isset($request->status) ? 1 : 0;
        try {
            $setting = CrontabSetting::where('id', $id)->limit(1)->update($data);
            if ($setting) {
                return redirect('/spam')->with('message', 'Thiết lập thành công !');
            }
            return redirect('/spam')->with('error_message', 'Thiết lập thất bại !');
        } catch (\Exception $ex) {
            return redirect('/spam')->with('error_message', $ex->getMessage());
        }
    }
}
