<?php namespace App\Http\Controllers;

use App\Feed;
use App\News;
use App\UserPrefs;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use View;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */


    public function __construct()
    {
        $feeds_title = DB::table('finalfeeds')->distinct()->select('title')->where('country', 'eg')->where('language', 'ar')->get();
        $type = DB::table('finalfeeds')->distinct()->lists('type');
        $topics = DB::table('finalfeeds')->distinct()->lists('category');
        $languages = DB::table('finalfeeds')->distinct()->lists('language');
        $countries = DB::table('finalfeeds')->distinct()->lists('country');
        //$countries=array_splice($countries,1);
        // $menu_tree=[];
        // foreach ($type as $type_element) {
        // 	# code...
        // 	$feeds=DB::table('finalfeeds')->distinct()->where('type',$type_element)->select('title')->get();
        // 		//array_merge($menu_tree,[$type_element=>$feeds]);
        // 		$menu_tree[$type_element]=$feeds;
        // }
        //view::share('menu_tree',$menu_tree);
        View::share('feeds_title', $feeds_title);
        View::share('type', $type);
        View::share('countries', $countries);
        View::share('category', $topics);
        View::share('languages', $languages);
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index()
    {
        $feeds_id = Feed::where('country', 'eg')->where('language', 'ar')->lists('id');
        $news = News::whereIn('feed_id', $feeds_id)->where('lock', 1)->orderBy('date', 'desc')->take(20)->get();
        return view('homepage', compact('news'));
    }

    public function LoadMore()
    {

        $country = $_POST['country'];
        $language = $_POST['language'];
        $feeds_id = Feed::where('country', $country)->where('language', $language)->lists('id');

        $news = News::where('lock', 1)->whereIn('feed_id', $feeds_id)->orderBy('date', 'desc')->skip($_POST['skip'])->take(20)->get();

        if (count($news) == 0) {
            return view('emptynews');
        }
        return view('more', compact('news'));
    }


    public function FeedNews()
    {

        $title = $_POST['selected_feed'];


        $feeds_id = Feed::where('title', $title)->lists('id');

        if (!array_key_exists('search_text', $_POST)) {

            $news = News::where('lock', 1)->whereIn('feed_id', $feeds_id)->orderBy('date', 'desc')->take(20)->get();


        } else {
            $news = News::where('lock', 1)->whereIn('feed_id', $feeds_id)->where('title', 'like', '%' . $_POST['search_text'] . '%')->orderBy('date', 'desc')->take(20)->get();


        }

        if (count($news) == 0) {
            return view('emptynews');
        }

        return view('feednews', compact('news', 'title'));

    }


    public function MoreFeedNews()
    {

        $title = $_POST['title'];
        $feeds_id = Feed::where('title', $title)->lists('id');

        if (!array_key_exists('search_text', $_POST)) {

            $news = News::where('lock', 1)->whereIn('feed_id', $feeds_id)->orderBy('date', 'desc')->skip($_POST['skip'])->take(20)->get();
            //print_r($news);

        } else {
            $news = News::where('lock', 1)->whereIn('feed_id', $feeds_id)->where('title', 'like', '%' . $_POST['search_text'] . '%')->orderBy('date', 'desc')->skip($_POST['skip'])->take(20)->get();
        }


        if (count($news) == 0) {
            return response([]);
        }


        return view('more', compact('news', 'title'));

    }


    public function result(Request $request)
    {

        $search_text = $_POST['search_text'];
        $country = $_POST['country'];
        $language = $_POST['language'];

        $feeds_id = Feed::where('country', $country)->where('language', $language)->lists('id');
        $count = News::whereIn('feed_id', $feeds_id)->where('title', 'like', '%' . $search_text . '%')->count();
        $news = News::whereIn('feed_id', $feeds_id)->where('title', 'like', '%' . $search_text . '%')->orderBy('date', 'desc')->take(20)->get();

        if ($count == 0) {
            return view('emptynews');
        }

        return view('resultnews', compact('news', 'search_text'));


    }

    public function moreResult()
    {
        $key = $_POST['search_text'];
        $country = $_POST['country'];
        $language = $_POST['language'];
        $feeds_id = Feed::where('country', $country)->where('language', $language)->lists('id');
        $news = News::whereIn('feed_id', $feeds_id)->where('title', 'like', '%' . $key . '%')->skip($_POST['skip'])->take(20)->get();
        if (count($news) == 0) {
            return response([]);
        }
        return view('moreresult', compact('news', 'key'));


    }

    public function feedlist()
    {
        $country = $_POST['country'];
        $language = $_POST['language'];
        $feeds_titles = DB::table('feeds')->distinct()->select('title')->where('country', $country)->where('language', $language)->get();
        return view('feedlist', compact('feeds_titles'));
    }


    public function NewsByCountry()
    {
        $country = $_POST['country'];
        $language = $_POST['language'];
        $search_text = $_POST['search_text'];


        $feeds_id = Feed::where('country', $country)->where('language', $language)->lists('id');
        if (array_key_exists('search_text', $_POST)) {

            $news = News::whereIn('feed_id', $feeds_id)->where('title', 'like', '%' . $search_text . '%')->orderBy('date', 'desc')->take(20)->get();


        } else {

            $news = News::whereIn('feed_id', $feeds_id)->orderBy('date', 'desc')->take(20)->get();
        }
        if (count($news) == 0) {
            return view('emptynews');
        }

        return view('newsbycountry', compact('news'));
    }


}
