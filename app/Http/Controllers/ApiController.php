<?php namespace App\Http\Controllers;

use App\Http\Requests;
use DB;
use App\Feed;
use App\News;
use App\UserPrefs;
use Illuminate\Http\Request;
use Image;


//define the path of the log file
\Log::useDailyFiles(storage_path() . '/api_logs/api.log');

class ApiController extends Controller
{


    /**
     * return main feed menu category.
     * method respond to get request.
     *
     * @param  string $language user feed desired language.
     * @param  string $country feeds country.
     *
     * @return response json.
     */

    public function menu($language, $country)
    {

        $countries_array = [];
        $topics_array = [];

        //define the path of all countries images
        $country_image_path = '/images/countries/';

        //define the path of all topics images
        $topics_image_path = '/images/topics_icons/';

        //check if the given country exist in the database
        if (Feed::where('country', $country)->count() == 0) {
            \Log::error('Country not found', ['url' => \Request::url(), 'country' => $country], PHP_EOL);


            return response()->json([]);
        }
        $arab_countries = config('khabar.Arab');
        //check if the country given in the related countries defined in  config/khabar.php
        if (!in_array($country, $arab_countries)) {

            return response()->json(['message' => -1]);
        }
        //return all countries  which contain feeds
        $countries_have_feeds = Feed::CountriesHaveFeeds($arab_countries);

        //Set the given country in the url at the  beginning of the menu
        $index = array_search($country, $countries_have_feeds);
        $temp = $countries_have_feeds[0];
        $countries_have_feeds[0] = $country;
        $countries_have_feeds[$index] = $temp;

        //loop in the countries  to create the given structure
        foreach ($countries_have_feeds as $country_element) {
            array_push($countries_array, [
                'title' => $country_element,
                'image' => $country_image_path . $country_element . '.png',
                'type' => 'country'
            ]);
        }


        //select  application main topics  Sport,Economy,Cars,Health,Misc,Women,Technology
        
        $topics = Feed::where('language', $language)->where('category',"!=" ,'')->distinct()->lists('category');
     
        

        //loop in the category to create the given structures
        foreach ($topics as $topic) {
            
            array_push($topics_array, [
                'title' => $topic,
                'image' => $topics_image_path . $topic . '.png',
                'type' => 'category'
            ]);
        }

        //take the given country and international in array
        $first_two_countries = array_slice($countries_array, 0, 2);

        //save other countries in array
        $related_countries = array_slice($countries_array, 2);


        //merge topics with international and the given country
        $first_merge = array_merge($first_two_countries, $topics_array);

        //create the menu structure
        $menu_structure = array_merge($first_merge, $related_countries);

        //add the user resources
        $my_resources = ['title' => 'My feeds', 'image' => '/images/topics_icons/notebook.png', 'type' => 'My feeds'];

        //add the user resources to the menu structure
        $menu_structure = array_merge([$my_resources], $menu_structure);
        $data = [
            'menu' => $menu_structure
        ];


        //report the log file that the menu is called
        \Log::info('Menu Link:  Menu has been Called', ['url' => \Request::url()], PHP_EOL);

        return response()->json($data, 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    }


    /**
     * return all feeds related to specific country grouped by type [News papers , TV channels, Electronic sources , news agencies , etc..]
     * method respond to get request
     * @param  string $language user feed desired language.
     * @param  string $country feeds country.
     * @return response json
     */
    public function CountryCategories($language, $country)
    {
        // get all types of the application
        $type_list = Feed::distinct()->where('country', $country)->where('language', $language)->lists('type');

        //initialise array contain all types
        $result = [array_reverse($type_list)];


        //loop in all types to get all feeds related to each type
        //example ["News papers",{
        //'title' :"صحيفة  اليوم السابع",
        //'subtitle' :"",
        //'logo' :"images/youmsabea.png"
        //}]


        foreach (array_reverse($type_list) as $type) {
$feeds = Feed::all();
foreach ($feeds as $feed) {
				# code...
				$feed->logo="images/webservice/logos/".$feed->id.".jpg";
                                $feed->header="images/webservice/headers/".$feed->id.".jpg";
                                $feed->status=1;
$feed->offset=2;

                                if($feed->country== "")
                                {
                                   $feed->country="international";

                                }
				$feed->save();
			}

            $feeds = Feed::distinct()->where('country', $country)->where('type', $type)->select('id','title', 'subtitle', 'logo', 'country','header', 'language')->get();
                               

            array_push($result, [$type => $feeds]);
        }


        //report to the log file
        \Log::info('Menu Link: feeds of the given country has been called', ['url' => \Request::url(), 'country' => $country], PHP_EOL);

        return response()->json($result, 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }



       public function MagazineFeeds ($language,$magazine,$state=null,$id=null)
       {
    
            $count_news =config('khabar.news_limit'); 
            $id_list = Feed::distinct()->select('id')->where('tags','LIKE', '%'.$magazine.'%')->get();
            $cur_ids = array();
            foreach ($id_list as $idlist) {
              $cur_ids[] = $idlist->id;

             }
             

      
        //News::WhereIn('feed_id', $cur_ids)->where('lock', 1)->count();
             switch ($state) {
                 case null:
                     # code...
                    $news = News::WhereIn('feed_id', $cur_ids)->where('lock', 1)->with(['feed' => function ($query) {
                                    $query->select('id','title', 'subtitle', 'logo', 'country','header', 'language');
                            
                      }])->orderBy('date', 'desc')->take($count_news)->get();

                     break;
                 case 'recent':
                    $date = DB::table('news')->select('date')->where('id', $id)->first()->date;
                    $news = News::WhereIn('feed_id', $cur_ids)->where('date','>',$date)->where('lock', 1)->with(['feed' => function ($query) {
                                    $query->select('id','title', 'subtitle', 'logo', 'country','header', 'language');
                            
                      }])->orderBy('date', 'desc')->take($count_news)->get();
                    # code...

                    break;
                 case 'more':
                            $date = DB::table('news')->select('date')->where('id', $id)->first()->date;
                    $news = News::WhereIn('feed_id', $cur_ids)->where('date','<',$date)->where('lock', 1)->with(['feed' => function ($query) {
                                    $query->select('id','title', 'subtitle', 'logo', 'country','header', 'language');
                            
                      }])->orderBy('date', 'desc')->take($count_news)->get();
                     break;
                 default:
                     return response()->json(['message' => -1]);
                     break;
             }
         
            return response()->json(['count' => count($news), 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);       

       }



    /**
     * return feeds related to given topic
     * method respond to get request
     *
     * @param  string $language user feed desired language.
     * @param string $topic topic on the feed like sport , health ... etc
     * @return response json
     */

       public function TopicFeeds($language,$topic)
    {


        //get all types related to the given country and topic and return as array
        $found_type=Feed::where('category',$topic)->where('language',$language)->distinct()->lists('type');
        //return response of empty array in case no result
        //if(count($found_type) == 0) {return response()->json([]);}

        //create array with all types
        $result=[$found_type];
        //loop in each type to get all feeds related to this topic


        foreach (array_reverse($found_type) as $type) {

            $feeds=Feed::distinct()->where('category',$topic)->where('type',$type)->select('id','title', 'subtitle', 'logo', 'country','header', 'language')->get();
            array_push($result,[$type =>$feeds]);
        }

            //report to the log file
        \Log::info('Menu link :feeds of the given  topic has been called', ['url' => \Request::url(),'category' =>$topic],PHP_EOL);

        return response()->json($result,200, ['Content-type'=> 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

    }
    /**
     *  return feeds related to given topic in all international feeds
     *  method respond to get request
     * @param  string $language user feed desired language.
     * @param string $topic topic if the feed like sport , health , cars , ..etc
     * @return response json
     */

    public function InternationalTopics($language, $topic)
    {
        //find types related to this topic and international
        $found_type = Feed::where('category', $topic)->where('language', $language)->distinct()->lists('type');
//        if (count($found_type) == 0) {
//            return response()->json([]);
//        }
        $result = [$found_type];

        foreach (array_reverse($found_type) as $type) {
            $feeds = Feed::distinct()->where('category', $topic)->where('type', $type)->select('title', 'subtitle', 'logo', 'country', 'language')->get();
            array_push($result, [$type => $feeds]);
        }


        \Log::info('Menu Link :International feeds  of this topic has been called', ['url' => \Request::url(), 'category' => $topic], PHP_EOL);

        return response()->json($result, 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


    }


    /**
     * Save user preferences if email exist , if not create a new user and save it
     * method respond to post request
     *
     * @param user email from post request
     * @param prefs represent user preferences
     * example {"email":"ahmed@gmail.com","prefs":[{"title":"الوطن المصريه","subtitle":"null","logo":"amn","type":"newspapers"},{"title":"بوابه أخبار اليوم","subtitle":"null","logo":"amn","type":"newspapers"}]}
     * @return response json with 1 if success or -1 if fail
     */


    public function AddUserPreferences(Request $request)
    {
        //read content from post request body
        $content = $request->getContent();

        try {
            $data = json_decode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $email = $data['email'];
            $user_preferences = $data['prefs'];


        } catch (\Exception $e) {

            \Log::error('Saving user preferences: Exception in Post body request', ['url' => \Request::url(), 'Exception' => $e->getMessage(), 'user_email' => $email], PHP_EOL);

            return response()->json([-1]);

        }

        //check if the email of user found in  the database
        $user = UserPrefs::where('email', $email)->first();
        if (count($user) == 1) {
            $titles_array = [];
            try {

                //push all titles in array
                foreach ($user_preferences as $feed) {
                    array_push($titles_array, $feed['title']);

                }

            } catch (\Exception $e) {


                \Log::error('Updating user preferences:Exception in user updating preferences', ['url' => \Request::url(), 'Exception' => $e->getMessage(), 'email' => $email], PHP_EOL);

                return response()->json([-1]);

            }


            //save user preferences in the database from the post request
            $user->user_prefs = json_encode($user_preferences, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            //get all feeds id realted  to the titles
            $feeds_id = Feed::whereIn('title', $titles_array)->lists('id');

            //save the feeds id in the database
            $user->user_prefs_ids = json_encode($feeds_id);
            $user->previous_update = $user->updated_at;
            $saved = $user->save();
            $message = $saved ? ['message' => 1] : ['message' => -1];
            \Log::info('updating user preferences: user preferences updated', ['url' => \Request::url(), 'user_email' => $email], PHP_EOL);
            return response()->json($message);


        } else {

            //if user not found create new user
            $user = new UserPrefs;

            //
            $user->email = $email;
            $user->user_prefs = json_encode($user_preferences, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $titles_array = [];

            try {
                foreach ($user_preferences as $feed) {
                    array_push($titles_array, $feed['title']);

                }

            } catch (\Exception $e) {
                \Log::error('Saving user preferences: Exception in user Saving preferences', ['url' => \Request::url(), 'Exception' => $e->getMessage(), 'email' => $email], PHP_EOL);

                return response()->json([-1]);
            }

            $feeds_id = Feed::whereIn('title', $titles_array)->lists('id');
            $user->user_prefs_ids = json_encode($feeds_id);
            $saved = $user->save();
            $message = $saved ? ['message' => 1] : ['message' => -1];
            \Log::info('Saving user  preferences:user preferences Saved', ['url' => \Request::url(), 'user_email' => $email], PHP_EOL);
            return response()->json($message);
        }


        return response()->json(['message' => -1]);

    }

    /**
     * get user preferences if email exist
     * method respond to POST request
     *
     * @param user email from post request
     * @return response json with 1 if sucess or -1 if fail and user prefernces
     */


    public function GetUserPreferences(Request $request)
    {
        $content = $request->getContent();

        try {
            $data = json_decode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $email = $data['email'];


        } catch (\Exception $e) {


            \Log::error('Getting user preferences: Exception in getting user preferences', ['url' => \Request::url(), 'Exception' => $e->getMessage()], PHP_EOL);
            return response()->json([-1]);

        }

        $user = UserPrefs::where('email', $email)->first();
        if (count($user) == 1) {
            \Log::info('Getting user preferences: User preferences Has been found', ['url' => \Request::url(), 'email' => $email], PHP_EOL);


            return response()->json(json_decode($user->user_prefs), 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        \Log::error('Getting user preferences: No user found related to the given email', ['url' => \Request::url(), 'email' => $email], PHP_EOL);

        return response()->json([]);
    }


    /**
     * return all news related to user
     * method respond to POST request
     *
     *
     * @param Request of email and user preferences
     * @return response json
     */

    public function UserNews(Request $request)
    {
        //find_user
        $content = $request->getContent();
        try {
            $data = json_decode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $email = $data['email'];

            //check if limit  sent in the post body ot take it from the configuration file
            if (isset($data['limit'])) {
                $limit = $data['limit'];
            } else {
                $limit = config('khabar.news_limit');
            }
        } catch (\Exception $e) {

            \Log::error('Last News:Exception to find user news', ['url' => \Request::url(), 'exception' => $e->getMessage()], PHP_EOL);

            return response()->json(-1);
        }


        //check if the user saved or not
        $user = UserPrefs::where('email', $email)->first();
        if (count($user) == 0) {

            \Log::error('Last News: No user found related to this email', ['url' => \Request::url(), 'email' => $email], PHP_EOL);


            return response()->json(['message' => -1]);
        } else {
            //get user preferences as a json and decode it
            $list_of_IDS = json_decode($user->user_prefs_ids);
            $count_news = News::WhereIn('feed_id', $list_of_IDS)->where('lock', 1)->count();


            //an optional key sent to return number of news only
            if (isset($data['option'])) {
                return response()->json(['count' => $count_news]);
            }

            //get all news order by date
            $news = News::WhereIn('feed_id', $list_of_IDS)->where('lock', 1)->with(['feed' => function ($query) {
                $query->select('id', 'title', 'logo');

            }])->orderBy('date', 'desc')->take($limit)->get();

            \Log::info('Last News: User news has been returned ', ['url' => \Request::url(), 'email' => $email], PHP_EOL);

            return response()->json(['count' => $count_news, 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        }

        return response()->json(['meessage' => -1]);
    }


    /**
     * return list of recent user news.
     * method respond to POST request
     *
     * @param Request of email and last id of the news
     * @return response json
     */


    public function UserRecentNews(Request $request)
    {
        $content = $request->getContent();
        try {
            $data = json_decode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $email = $data['email'];
            $id = $data['id'];
            if (isset($data['limit'])) {
                $limit = $data['limit'];
            } else {
                $limit = config('khabar.news_limit');
            }
        } catch (\Exception $e) {

            \Log::error('Recent Last News: Exception found ', ['url' => \Request::url(), 'Exception' => $e->getMessage()], PHP_EOL);

            return response()->json([-1]);
        }
        $user = UserPrefs::where('email', $email)->first();
        if (count($user) == 0) {
            \Log::error('Recent Last News: No user found related to this email ', ['url' => \Request::url(), 'Email' => $email], PHP_EOL);

            return response()->json(['message' => -1]);
        } else {
            //get user prefs as a json and decode it
            $list_of_IDS = json_decode($user->user_prefs_ids);
            $count_news = News::WhereIn('feed_id', $list_of_IDS)->where('id', '>', $id)->where('lock', 1)->count();
            if (isset($data['option'])) {
                return response()->json(['count' => $count_news]);
            }
            $date = DB::table('news')->select('date')->where('id', $id)->first()->date;

            $news = News::WhereIn('feed_id', $list_of_IDS)->where('date', '>', $date)->where('lock', 1)->with(['feed' => function ($query) {
                $query->select('id', 'title', 'logo');

            }])->orderBy('date', 'desc')->take($limit)->get();

            \Log::info('Recent Last News : Recent News of the user has been loaded ', ['url' => \Request::url(), 'Email' => $email], PHP_EOL);

            return response()->json(['count' => $count_news, 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


        }
        return response()->json(['meessage' => -1]);

    }


    /**
     *load more if user news
     * method respond to POST request
     *
     * @param Request of email and the oldest news id
     * @return response json
     */

    public function UserMoreNews(Request $request)
    {
        $content = $request->getContent();
        try {
            $data = json_decode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $email = $data['email'];
            $id = $data['id'];
            if (isset($data['limit'])) {
                $limit = $data['limit'];
            } else {
                $limit = config('khabar.news_limit');
            }
        } catch (\Exception $e) {

            \Log::error('More Last News :Exception ', ['url' => \Request::url(), 'Exception' => $e->getMessage()], PHP_EOL);

            return response()->json([-1]);
        }

        $user = UserPrefs::where('email', $email)->first();
        if (count($user) == 0) {
            \Log::error('More Last News : No user found related to this email ', ['url' => \Request::url(), 'Email' => $email], PHP_EOL);

            return response()->json(['message' => -1]);
        } else {
            //get user prefs as a json and decode it
            $list_of_IDS = json_decode($user->user_prefs_ids);
            $count_news = News::WhereIn('feed_id', $list_of_IDS)->where('id', '<', $id)->where('lock', 1)->count();
            if (isset($data['option'])) {
                return response()->json(['count' => $count_news]);
            }

            //echo $user->user_prefs;
            $date = DB::table('news')->select('date')->where('id', $id)->first()->date;
            //print_r($date);
            $news = News::where('date', '<', $date)->WhereIn('feed_id', $list_of_IDS)->where('lock', 1)->with(['feed' => function ($query) {
                $query->select('id', 'title', 'logo');

            }])->orderBy('date', 'desc')->take($limit)->get();

            \Log::info('More Last News : More News of the user has been loaded ', ['url' => \Request::url(), 'Email' => $email], PHP_EOL);

            return response()->json(['count' => $count_news, 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }


        return response()->json(['meessage' => -1]);

    }


    public function RecentNews(Request $request)
    {
        $content = $request->getContent();
        try {
            $data = json_decode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $email = $data['email'];
            $id = $data['id'];


        } catch (\Exception $e) {
            return response()->json(-1);

        }
        $user = UserPrefs::where('email', $email)->first();
        if (count($user) == 0) {
            return response()->json(['message' => -1]);
        } else {
            //get user prefs as a json and decode it
            $list_of_IDS = json_decode($user->user_prefs_ids);
            $date = DB::table('news')->select('date')->where('id', $id)->first()->date;

            $count_news = News::WhereIn('feed_id', $list_of_IDS)->where('date', '>', $date)->count();
            return response()->json(['count' => $count_news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


        }
        return response()->json(['meessage' => -1]);

    }


    /**
     * return list user favourite news
     * method respond to POST request
     *
     * @param Request of array of ID of news
     * @return response json
     */

    public function UserBookMark(Request $request)
    {
        $content = $request->getContent();
        try {
            $data = json_decode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $newsids = $data['newsids'];
            $News_IDS = json_decode($newsids);


        } catch (\Exception $e) {

            \Log::error('User Bookmark: User bookmark exception ', ['url' => \Request::url(), 'Exception' => $e->getMessage()], PHP_EOL);

            return response()->json([]);

        }
        if (empty($News_IDS)) {
            \Log::error('User Bookmark: No list of news id has been sent ', ['url' => \Request::url()], PHP_EOL);

            return response()->json();
        }
        $found_news = News::WhereIn('id', $News_IDS)->with(['feed' => function ($query) {
            $query->select('id', 'title', 'logo');

        }])->get();
        if (count($found_news) == 0) {
            \Log::error('User Bookmark: No news found the bookmark ', ['url' => \Request::url()], PHP_EOL);

            return response()->json([]);
        } else {

            \Log::info('User Bookmark: User bookmark has been loaded ', ['url' => \Request::url()], PHP_EOL);

            return response()->json(['count' => count($found_news), 'results' => $found_news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        }
    }


    /**
     *  return list of news
     * method respond to GET request
     *
     * @param null $language of the feed
     * @param null $country define the source country of the feed
     * @param null $title define the title of the feed you want to search in
     * @param null $state define if you want 'recent' or 'more' news
     * @param null $id define the id of the news
     * @param null $limit limit the news
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function GetNews($language = null, $country = null, $title = null, $state = null, $id = null, $limit = null)
    {

        // return all news related to this languages only
        if (isset($language) && is_null($country) && is_null($title)) {
            $feeds = Feed::where('language', $language)->lists('id');
            if (count($feeds) == 0) {
                return response()->json([]);
            }
            $count_news = News::whereIN('feed_id', $feeds)->where('lock', 1)->count();
            $news = News::whereIN('feed_id', $feeds)->where('lock', 1)->with(['feed' => function ($query) {
                $query->select('id', 'title', 'logo');

            }])->orderBy('date', 'desc')->take(config('khabar.news_limit'))->get();
            return response()->json(['count' => $count_news, 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        }

        // return all news related to this languages and country

        if (isset($language) && isset($country) && is_null($title)) {
            $feeds = Feed::where('country', $country)->where('language', $language)->lists('id');
            if (count($feeds) == 0) {
                return response()->json([]);
            }
            $count_news = News::whereIN('feed_id', $feeds)->where('lock', 1)->count();
            $news = News::whereIN('feed_id', $feeds)->where('lock', 1)->with(['feed' => function ($query) {
                $query->select('id', 'title', 'logo');

            }])->orderBy('date', 'desc')->take(config('khabar.news_limit'))->get();


            return response()->json(['count' => $count_news, 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


        }

        // return all news related to this languages , country and all feeds with the given title


        if (isset($language) && isset($country) && isset($title) && is_null($state)) {
            $feeds = Feed::where('country', $country)->where('language', $language)->where('title', $title)->lists('id');
            if (count($feeds) == 0) {
                \Log::error('Feed News: The given feed can\'t be found in the given country ', ['url' => urldecode(\Request::url()), 'feed_title' => $title, 'country' => $country], PHP_EOL);

                return response()->json([]);
            }
            $count_news = News::whereIN('feed_id', $feeds)->where('lock', 1)->count();
            $news = News::whereIN('feed_id', $feeds)->where('lock', 1)->with(['feed' => function ($query) {
                $query->select('id', 'title', 'logo');

            }])->orderBy('date', 'desc')->take(config('khabar.news_limit'))->get();

            \Log::info('Feed News: News of the the given feed has been found', ['url' => urldecode(\Request::url()), 'feed_title' => $title], PHP_EOL);


            return response()->json(['count' => $count_news, 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


        }

        //if 'recent'  or 'more' is given after the title
        if (isset($language) && isset($country) && isset($title) && isset($state)) {

            $feeds = Feed::where('country', $country)->where('language', $language)->where('title', $title)->lists('id');
            $count_news = News::whereIn('feed_id', $feeds)->count();
            switch ($state) {
                case 'recent':
                    $sign = '>';
                    break;
                case 'more':
                    $sign = '<';
                    break;
                case 'count':
                    return response()->json(['count' => $count_news]);
                default:
                    return response()->json(['message' => -1]);
                    break;
            }

            //get the date  of the give id if the news
            $date = DB::table('news')->select('date')->where('id', $id)->first()->date;

            if (isset($id) && is_null($limit)) {
                //get all news before or after the date given
                $count_news = News::whereIN('feed_id', $feeds)->where('lock', 1)->where('date', $sign, $date)->count();
                $news = News::whereIN('feed_id', $feeds)->where('lock', 1)->where('date', $sign, $date)->with(['feed' => function ($query) {
                    $query->select('id', 'title', 'logo');

                }])->orderBy('date', 'desc')->take(config('khabar.news_limit'))->get();


                \Log::info('Feed News:More news loaded to this feed', ['url' => urldecode(\Request::url()), 'feed_title' => $title], PHP_EOL);
                return response()->json(['count' => $count_news, 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
            if (isset($id) && isset($limit)) {
                $count_news = News::whereIN('feed_id', $feeds)->where('lock', 1)->where('date', $sign, $date)->count();
                $news = News::whereIN('feed_id', $feeds)->where('lock', 1)->where('date', $sign, $date)->with(['feed' => function ($query) {
                    $query->select('id', 'title', 'logo');

                }])->orderBy('date', 'desc')->take($limit)->get();


                //$final=['data' => $result];

                \Log::info('Feed News:More news loaded to this feed', ['url' => urldecode(\Request::url()), 'feed_title' => $title], PHP_EOL);

                return response()->json(['count' => $count_news, 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            }


        }
        \Log::error('Feed News:Error in feeds', ['url' => urldecode(\Request::url()), 'feed_title' => $title], PHP_EOL);


        return response()->json([-1]);


    }


    /**
     * Search in all news related to a specific country and language
     * method respond to POST request
     * @param json body of country and language and keyword to search in news
     * return list of news
     */

    public function FullSearch($language, $country, Request $request, $state = null)
    {
        $content = $request->getContent();


        return $this->Search('full', $content, $language, $country, $state);
    }


    /**
     * @param Request $request
     * @param null $state
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function UserSearch(Request $request, $state = null)
    {

        $content = $request->getContent();


        return $this->Search('user', $content, null, null, $state);
    }


    /**
     * @param Request $request
     * @param null $state
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function NewsByFeed(Request $request, $state = null)
    {


        $content = $request->getContent();
        return $this->Search('feed', $content, null, null, $state);


    }


    /**
     * search in all news
     *
     * @param $type to define the type of search .'full' to search in all news , 'user' to search in user news only , 'feed' to search in feed news only
     * @param $content define the content of post body request like "keyword" , "email" , "limit"
     * @param null $language language of feeds in which you want search in
     * @param null $country
     * @param null $state
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function Search($type, $content, $language = null, $country = null, $state = null)
    {
        //get content from the request

        try {
            $data = json_decode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            if (!isset($data['keyword'])) {
                return response()->json([]);
            } else {
                //add % in space between keywords
                //remove all "Hamazat and EL tanween" from arabic characters
                $keyword = str_replace(" ", "%", $this->CleanText($data['keyword']));
            }
            if (isset($data['limit'])) {
                $limit = $data['limit'];
            } else {
                $limit = config('khabar.news_limit');
            }

        } catch (\Exception $e) {


            \Log::error('Search: Exception in Search ', ['url' => \Request::url(), 'Exception' => $e->getMessage()], PHP_EOL);

            return response()->json([-1]);
        }


        switch ($type) {
            case 'full':
                //full search in the news system
                $user_countries = config('khabar.Arab');
                if (!in_array($country, $user_countries)) {
                    return response()->json([]);
                }

                $feeds_ids = Feed::whereIN('country', $user_countries)->where('language', $language)->lists('id');
                $count_news = News::whereIN('feed_id', $feeds_ids)->where('lock', 1)->where('search_column', 'like', '%' . $keyword . '%');
                $news = News::whereIN('feed_id', $feeds_ids)->where('lock', 1)->where('search_column', 'like', '%' . $keyword . '%');

                \Log::info('Search: Full search operation worked successfully ', ['url' => \Request::url(), 'keyword' => $keyword, 'count_news' => $count_news->count()], PHP_EOL);


                break;
            case 'user':

                //search in user feeds
                $email = $data['email'];

                $user = UserPrefs::where('email', $email)->first();
                if (count($user) == 0) {
                    return response()->json([]);
                }
                $user_prefernces = $user->user_prefs_ids;
                $feeds_ids = json_decode($user_prefernces);
                $count_news = News::whereIN('feed_id', $feeds_ids)->where('lock', 1)->where('search_column', 'like', '%' . $keyword . '%');


                $news = News::whereIN('feed_id', $feeds_ids)->where('lock', 1)->where('search_column', 'like', '%' . $keyword . '%');

                \Log::info('Search: search operation  in user feeds worked successfully ', ['url' => \Request::url(), 'keyword' => $keyword, 'count_news' => $count_news->count()], PHP_EOL);


                break;
            case 'feed':
                //search in a specific feed
                $title = $data['title'];
                $feeds_ids = Feed::where('title', $title)->lists('id');
                $count_news = News::whereIN('feed_id', $feeds_ids)->where('lock', 1)->where('search_column', 'like', '%' . $keyword . '%');
                $news = News::whereIN('feed_id', $feeds_ids)->where('lock', 1)->where('search_column', 'like', '%' . $keyword . '%');

                break;


            default:
                return response()->json(['message' => -1]);
                break;
        }

        switch ($state) {

            case null:
                $count_news = $count_news->count();

                // print_r($count_news);
                $news = $news->with(['feed' => function ($query) {
                    $query->select('id', 'title', 'logo');

                }])->orderBy('date', 'desc')->take($limit)->get();


                break;
            case 'recent':
                $date = DB::table('news')->select('date')->where('id', $data['id'])->first()->date;

                $count_news = $count_news->where('date', '>', $date)->count();

                $news = $news->where('date', '>', $date)->with(['feed' => function ($query) {
                    $query->select('id', 'title', 'logo');

                }])->orderBy('date', 'desc')->take($limit)->get();

                break;
            case 'more':
                $date = DB::table('news')->select('date')->where('id', $data['id'])->first()->date;

                $count_news = $count_news->where('date', '<', $date)->count();
                print_r($count_news);

                $news = $news->where('date', '<', $date)->with(['feed' => function ($query) {
                    $query->select('id', 'title', 'logo');

                }])->orderBy('date', 'desc')->take($limit)->get();


                break;
            default:
                return response()->json([]);
                break;
        }

        if (isset($data['option'])) {
            return response()->json(['count' => $count_news]);
        }

        return response()->json(['count' => $count_news, 'results' => $news], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    }

    /**
     * search for all feeds title like a title given
     * Method responde to POST request
     *example {"title":"rasd"} expected to get all feeds with rasd keyword
     * @param $request
     * @return mixed
     */

    public function SearchAllFeeds(Request $request)
    {
        $content = $request->getContent();
        try {
            $data = json_decode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $feeds_title=Feed::where('title', 'like', '%' . $data['keyword'] . '%')->select('id','title','subtitle','logo','country','language')->get();
            return response()->json(['count' =>count($feeds_title), 'results' =>$feeds_title], 200, ['Content-type' => 'application/json; charset=utf-8'])->setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {

            // \Log::error('Recent Last News: Exception found ', ['url' => \Request::url(), 'Exception' => $e->getMessage()], PHP_EOL);

            return response()->json([-1]);
        }

    }


    /**
     * clean el hamazat and el tanween from text
     *
     * @param $text
     * @return mixed
     */
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
