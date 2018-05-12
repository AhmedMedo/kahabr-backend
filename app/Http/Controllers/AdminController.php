<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Feed;
use App\News;
use Validator;
use DB;
use Hash;
use Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Registrar;
use App\User;
use App\UserPrefs;
use App\Http\Controllers\Controller;
use Excel;
use Image;
use App\FeedService\FeedService;
use Session;


class AdminController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('IfPassWdChanged');
    }

    /**
     * Display a listing of the resource and all statistics of news and feeds
     *
     * @return Response
     */
    public function index()
    {

        // $feeds=Feed::orderBy('id','ASC')->get();
        // $type=DB::table('feeds')->distinct()->lists('type');
        // $topics=DB::table('feeds')->distinct()->lists('topics');
        // $languages=lang();
        // $countries=countries();
        $number_of_feeds = Feed::count();
        $number_of_news = News::count();
        $number_of_mobile_users = UserPrefs::count();


        return view('admin.dashboard', compact(

            'number_of_feeds', 'number_of_news', 'number_of_mobile_users'
        ));

    }




    public function ShowFeeds()
    {
    	//$feeds=Feed::all;
    	//$feeds->setPath('');

    	$type=DB::table('feeds')->distinct()->lists('type');
        $tags=DB::table('feeds')->distinct()->lists('tags');
        $tags=array_filter($tags);
        $tags=implode(',',$tags);
        $tags=str_replace('(','',$tags);
        $tags=explode(')',$tags);
        $tags=array_unique(array_filter(str_replace(',','',$tags)));
        $tag_array=[];
        foreach ($tags as $tag)
        {
            $tag_array[$tag]=$tag;
        }
        $languages=config('khabar.languages');
    	$countries=config('khabar.all_countries');


    	return view('admin.feeds',compact('feeds','languages','type','tag_array','countries'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return view('admin.newfeed');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {


        //store all feeds
//        $v = Validator::make($request->all(), [
//            'link' => 'unique:feeds',
//        ]);
//
//        if ($v->fails()) {
//            return redirect()->back()->withErrors($v->errors());
//        }

//        $url = $request->input('link');
//        $file_headers = @get_headers($url);
//        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
//          \Session::flash('error', 'wrong Feed Link .');
//        return redirect()->back()->withErrors($v->errors());
//        }
            
        if ($request->hasFile('logo') ) {
            $logo = $request->file('logo');
            $last_id=Feed::all()->last()->id+1;
            $name = $last_id.'.png';
            // $icon->move('icons',$name);
            $image = Image::make($logo);
            $image->resize(80, 80);
            $logo_path = 'images/webservice/logos/' . $name;
            $image->save($logo_path);


        } else {

            $logo_path = 'images/khabar.png';
        }

            if ($request->hasFile('header') ) {
                $header = $request->file('header');
                $last_id=Feed::all()->last()->id+1;
                $name = $last_id.'.png';
                // $icon->move('icons',$name);
                $image = Image::make($header);
                $image->resize(80, 80);
                $header_path = 'images/webservice/headers/' . $name;
                $image->save($header_path);


            } else {

                $header_path = 'images/khabar.png';
            }

        //check new topic and type
        $type = $request->has('newtype') ? $request->newtype : $request->type;
        if($request->has('tag_list'))
        {
            $tag_list=$request->input('tag_list');
//            $tags=implode(',',$request->input('tag_list'));
            $tags='';
            foreach($tag_list as $tag){
                $tags=$tags.'('.$tag.')';
            }

        }else{
            $tags=null;
        }


            Feed::create([
                'title' => trim($request->title),
                'subtitle' => !empty($request->subtitle) ? $request->subtitle : null,
                'country' => $request->country,
                'language' => $request->lang,
                'type' => strtolower(str_replace(' ','',$type)),
                'tags' => strtolower($tags),
                'website' => trim($request->website),
                'twitter' => trim($request->twitter),
                'rss' => trim($request->rss),
                'facebook' => trim($request->facebook),
                'youtube' => trim($request->youtube),
                'instagram' => trim($request->instagram),
                'offset' => $request->offset,
                'protocol' => 'rss',
                'status' => $request->status,
                'logo' => $logo_path,
                'header' =>$header_path
            ]);




        \Session::flash('message', 'Feed successfully added.');
        return redirect()->back();
         





    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //find the feed and go to the edit page
        $feed = Feed::findOrFail($id);
        $type = DB::table('feeds')->distinct()->lists('type');
        $tags=DB::table('feeds')->distinct()->lists('tags');
        $tags=array_filter($tags);
        $tags=implode(',',$tags);
        $tags=str_replace('(','',$tags);
        $tags=explode(')',$tags);
        $tags=array_unique(array_filter(str_replace(',','',$tags)));
        $tag_array=[];
        foreach ($tags as $tag)
        {
            $tag_array[$tag]=$tag;
        }
        $languages = config('khabar.languages');
        $countries = config('khabar.all_countries');
        return view('admin.editfeed', compact('feed', 'type', 'tag_array', 'languages', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
        $feed = Feed::findOrFail($id);


        if ($request->hasFile('logo') ) {
            $logo = $request->file('logo');
            $name = Feed::all()->last()->id.'.png';
            // $icon->move('icons',$name);
            $image = Image::make($logo);
            $image->resize(80, 80);
            $logo_path = 'images/webservice/logos/' . $name;
            $image->save($logo_path);


        } else {

            $logo_path = $feed->logo;
        }

        if ($request->hasFile('header') ) {
            $header = $request->file('header');
            $name = Feed::all()->last()->id.'.png';
            // $icon->move('icons',$name);
            $image = Image::make($header);
            $image->resize(80, 80);
            $header_path = 'images/webservice/headers/' . $name;
            $image->save($header_path);


        } else {

            $header_path = $feed->header;
        }

        if($request->has('tag_list'))
        {
            $tag_list=$request->input('tag_list');
//            $tags=implode(',',$request->input('tag_list'));
            $tags='';
            foreach($tag_list as $tag){
                $tags=$tags.'('.$tag.')';
            }
        }else{
            $tags=null;
        }
        //check new topic and type
        $type = $request->has('newtype') ? $request->newtype : $request->type;

        //update news to lock 0 if satatus is draft
        if ($request->status == 0) {
            $feed->news()->update(array('lock' => 0));
        } else {

            $feed->news()->update(array('lock' => 1));

        }

        $feed->update([
            'title' => trim($request->title),
            'subtitle' => !empty($request->subtitle) ? $request->subtitle : null,
            'country' => $request->country,
            'language' => $request->lang,
            'type' => strtolower(str_replace(' ','',$type)),
            'tags' => strtolower($tags),
            'website' => trim($request->website),
            'twitter' => trim($request->twitter),
            'facebook' => trim($request->facebook),
            'youtube' => trim($request->youtube),
            'instagram' => trim($request->instagram),
            'offset' => $request->offset,
            'status' => $request->status,
            'logo' => $logo_path,
            'header' => $header_path

        ]);
        \Session::flash('message', 'Feed successfully updated.');
        return redirect('/admin/feeds');

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
        $feed = Feed::findOrFail($id);
        $feed->delete();
        \Session::flash('deletemessage', 'Feed successfully deleted.');
        return redirect()->back();
    }


    /* functions for admin control*/


    /*
        view edit page for the user
    */
    public function viewEdit()
    {
        return view('auth.edit');
    }

    public function PostEdit(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|',
            'email' => 'required|email',
            'password' => 'min:6|same:password_confirmation'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        Auth::user()->name = $request->name;
        Auth::user()->email = $request->email;
        Auth::user()->password = Hash::make($request->password);
        Auth::user()->save();
        Auth::logout();
        Session::remove('updated');
        return redirect('/');
    }

    /*Create new admin by the super admin*/

    public function newAdmin()
    {
        return view('admin.newadmin');
    }

    public function postAdmin(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'unique:users',
            'email' => 'unique:users'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        \Session::flash('message', 'New admin successfully added.');

        return redirect('/admin/adminmembers');
    }


    public function AdminMembers()
    {
        $users = User::where('role', '!=', 'superadmin')->get();
        //$users=User::all();

        return view('admin.adminmembers', compact('users'));
    }
    
    
    
    public function ajax_get_admin_list(Request $request)
    {
        $admin = User::all();
        return view('admin.membersList')
                ->with('admin', $admin);
    }
    

    public function DeleteMember($id)
    {
          DB::delete('delete from users where id = ?', [$id]);
        \Session::flash('deletemessage', 'Member successfully deleted.');

        return redirect()->back();
        
//        $all = $request->all();
//        $id= $request->input('id');
//        $user = User::find($id);
//        $user->delete();
//        Session::flash('message','Admin deleted successfully.');
//        
//        $result =[
//            'msg' => 'Admin deleted successfully.'
//        ];
//        
//        return $result;
        
//        $user = User::findOrFail($id);
//        $result = $user->delete();
////        if($result)
//            return $user;
//            ),200);
//        return \Response::json(array(
//            'success' => false,
//            'msg' => 'Membor cann\'tbe deleted.'
//
//        ),402);


       // return response()->json(["id" => "1212"]);
    }


    public function EditMember($id)
    {
        $user = User::find($id);
        return view('admin.updatemember', compact('user'));
    }

    public function UpdateMember(Request $request, $id)
    {

        $user = User::find($id);
        if ($request->has('name')) {

        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->has('role')) {
            $user->role = $request->role;
        }

        $user->save();
        \Session::flash('message', 'Member successfully updated');
        return redirect('/admin/adminmembers');
    }

/*Check every source*/
    public function FBLink()
    {
        $link = $_POST['link'];
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            return response('false');
        }
        $count = Feed::where('facebook', $link)->count();
        return response($count);
    }
    public function RSSLink()
    {
        $link = $_POST['link'];
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            return response('false');
        }


        $count = Feed::where('rss', $link)->count();
        return response($count);
    }
    public function TwitterLink()
    {
        $link = $_POST['link'];
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            return response('false');
        }
        $count = Feed::where('twitter', $link)->count();
        return response($count);
    }
    public function InstagramLink()
    {
        $link = $_POST['link'];
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            return response('false');
        }
        $count = Feed::where('instagram', $link)->count();
        return response($count);
    }
    public function YouTubeLink()
    {
        $link = $_POST['link'];
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            return response('false');
        }
        $count = Feed::where('youtube', $link)->count();
        return response($count);
    }
    public function CheckWebsite()
    {
        $link = $_POST['link'];
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            return response('false');
        }
        $count = Feed::where('website', $link)->count();

        return response($count);
    }


    public  function SaveFile(Request $request)
    {
        //save all CSV file to DB
        $path = $request->file('file')->getRealPath();
        $data = Excel::load($path, function($reader) {
        })->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $key => $value)
            {

//            try{
//                if (isset($value->logo) ) {
//                    $logo = $value->logo;
//                    $last_id=Feed::all()->last()->id+1;
//                    $name = $last_id.'.png';
//                    // $icon->move('icons',$name);
//                    $image = Image::make($logo);
//                    $image->resize(80, 80);
//                    $logo_path = 'images/webservice/logos/' . $name;
//                    $image->save($logo_path);
//
//
//                } else {
//
//                    $logo_path = 'images/khabar.png';
//                }
//
//            }catch (\Exception $e)
//            {
//
//                $logo_path = 'images/khabar.png';
//
//
//            }
//
//
//
//        try{
//            if (isset($value->header) ) {
//                $header = $value->header;
//                $last_id=Feed::all()->last()->id+1;
//                $name = $last_id.'.png';
//                // $icon->move('icons',$name);
//                $image = Image::make($header);
//                $image->resize(80, 80);
//                $header_path = 'images/webservice/headers/' . $name;
//                $image->save($header_path);
//
//
//            } else {
//
//                $header_path = 'images/khabar.png';
//            }
//
//        }catch (\Exception $e)
//        {
//
//            $header_path = 'images/khabar.png';
//
//        }


                Feed::create([
                    'title' => $value->title,
                    'subtitle' => $value->subtitle,
                    'country' => $value->country,
                    'language' => $value->language,
                    'type' => $value->type,
                    'tags' => $value->tags,
                    'website' => $value->website,
                    'twitter' => $value->twitter,
                    'rss' => $value->rss,
                    'facebook' => $value->facebook,
                    'youtube' =>$value->youtube,
                    'instagram' => $value->instagram,
                    'offset' => $value->offset,
                    'protocol' => 'rss',
                    'status' => $value->status,
                    'logo' => 'images/khabar.png',
                    'header' =>$header_path
                ]);


            }

            \Session::flash('message', 'CSV file uploaded.');
            return redirect()->back();


        }else{
            \Session::flash('message', 'No Data found.');
            return redirect()->back();

        }


        }


}
