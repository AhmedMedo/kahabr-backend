<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use View;
use App\News;
use App\Feed;

class FrontPageController extends Controller
{

    public function __construct()
    {
        $menu_tree = [];
        $type = DB::table('feeds')->distinct()->lists('type');

        foreach ($type as $type_element) {
            # code...
            $feeds = DB::table('feeds')->distinct()->where('type', $type_element)->select('title')->get();
            //array_merge($menu_tree,[$type_element=>$feeds]);
            $menu_tree[$type_element] = $feeds;
        }
        $tags=DB::table('feeds')->distinct()->lists('tags');
        $tags=array_filter($tags);
        $tags=implode(',',$tags);
        $tags=str_replace('(','',$tags);
        $tags=explode(')',$tags);
        $tags=array_unique(array_filter(str_replace(',','',$tags)));

        $languages = DB::table('feeds')->distinct()->lists('language');
        $countries = DB::table('feeds')->distinct()->lists('country');
        view::share('menu_tree', $menu_tree);
        View::share('tags', $tags);
        View::share('languages', $languages);
        View::share('countries', $countries);

    }

    /**
     * Show recent news ordered by date in the front page
     *
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index()
    {
        //
        $news = News::orderBy('date', 'desc')->take(20)->get();
        $title = 'Last News';
        return view('newview.home', compact('news', 'title'));

    }


    /**
     * get search result
     * method respond to get request
     * @param Request $request
     * @return View
     */
    public function SearchResult(Request $request)
    {


        $sql = DB::table('feeds');

        //take all requests from form after submision except page and keyword
        $all_requests = $request->except('keyword', 'page');

        if ($request->has('keyword')) {
            $keyword = $this->CleanText(str_replace(' ', '%', $request->keyword));

            if (count($all_requests) == 0) { //if the request only has keyword
                $news = News::Where('search_column', 'like', '%' . $keyword . '%')->orderBy('date', 'desc')->paginate(20);


            } else {

                //loop in all requests as key => column_name and value => value
                foreach ($all_requests as $key => $value) {
                    if($key == 'tags')
                    {
                        $sql=$sql->where($key,'like', '%' . $value . '%');

                    }else{

                        $sql = $sql->where($key, $value);

                    }
                }
                $feeds_id = $sql->lists('id');
                $news = News::whereIn('feed_id', $feeds_id)->Where('search_column', 'like', '%' . $keyword . '%')->orderBy('date', 'desc')->paginate(20);
            }

        } else {
            foreach ($all_requests as $key => $value) {
                if($key == 'tags')
                {
                    $sql=$sql->where($key,'like', '%' . $value . '%');

                }else{

                    $sql = $sql->where($key, $value);
                }
            }
            $feeds_id = $sql->lists('id');
            $news = News::whereIn('feed_id', $feeds_id)->orderBy('date', 'desc')->paginate(20);


        }

        if (count($news) == 0) {
            return view('newview.empty');

        }
        $news->setPath('');


        return view('newview.result', compact('news'));
    }


    /**
     * load more news in the home page
     *
     * @param $id
     * @return View
     */
    public function LoadMore($id)
    {
        $date = DB::table('news')->select('date')->where('id', $id)->first()->date;
        $news = News::where('date', '<', $date)->orderBy('date', 'desc')->take(20)->get();
        return view('newview.more', compact('news'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    private function CleanText($text)
    {

        $arr = ['أ' => 'ا',
            'إ' => 'ا',
            'آ' => 'ا',
            "ة" => 'ه',
            "ّ" => '',
            "َّ" => '',
            "ُّ" => '',
            "ٌّ" => '',
            "ًّ" => '',
            "ِّ" => '',
            "ٍّ" => '',
            "ْ" => '',
            "َ" => '',
            "ً" => '',
            "ُ" => '',
            "ِ" => '',
            "ٍ" => '',
            "ٰ" => '',
            "ٌ" => '',
            "ۖ" => '',
            "ۗ" => '',
            "ـ" => ''
        ];
        foreach ($arr as $key => $val) {

            $cleaned_text = str_replace($key, $val, $text);
            $text = $cleaned_text;
        }
        return $cleaned_text;
    }


}
