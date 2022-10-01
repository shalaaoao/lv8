<?php

namespace App\Http\Controllers;

use App\Model\StarLog;
use App\Services\Notices\Star;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StarController extends Controller
{
    public function lists(Request $request)
    {
        $page  = $request->get('page', 1);
        $limit = $request->get('limit', 20);

        $data       = StarLog::query()->orderByDesc('id')->forPage($page, $limit)->get();
        $sum_num    = StarLog::sumStar();
        $usable_num = StarLog::usableStar();

        return \view('star.star-list', ['data' => $data, 'sum_num' => $sum_num, 'usable_num' => $usable_num]);
    }

    public function add(Request $request)
    {
        $star_type = (int)$request->get('star_type');
        if ($star_type == StarLog::STAR_TYPE_DEFINE) {
            $star_num  = (int)$request->get('star_num');
            $star_desc = (string)$request->get('star_desc');
        } else {
            $star_num = StarLog::STAR_TYPE_NUM[$star_type] ?? 0;
            $star_desc = StarLog::STAR_TYPE_TEXT[$star_type] ?? '';
        }

        if (!$star_type) {
            Session::put('star_alert', '你没选啊大哥');
            return back();
        }

        if (!in_array($star_type, array_keys(StarLog::STAR_TYPE_TEXT))) {
            Session::put('star_alert', 'star_type错误');
            return back();
        }

        if (!$star_num) {
            Session::put('star_alert', '0个✨，不加了');
            return back('', ['alert' => '你妹啊']);
        }

        Star::addStarWithNotice($star_num, $star_type, $star_desc);

        return redirect('/star/lists');
    }

    public function addPage(Request $request)
    {
        return view('star.star-add', ['star_types' => StarLog::STAR_TYPE_TEXT]);
    }
}
