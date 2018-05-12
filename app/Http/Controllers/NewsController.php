<?php namespace App\Http\Controllers;
use Mbarwick83\Instagram\Instagram;

use App\FeedService\FaceBook;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Feed;
use App\News;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use DB;
use GuzzleHttp\Client;
use App\BackupService\BackupService;
use App\FeedService\FeedService;
use Carbon\Carbon;
use Cache;
use View;
use Hash;
use App\User;

class NewsController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //show news of a feed
        $feed = Feed::find($id);
        $all_news = $feed->news()->orderBy('date', 'desc')->paginate(10);
        $all_news->setPath('');
        $feed_title = $feed->title;
        return view('admin.news', compact('all_news', 'feed_title'));
    }

    public function destroy($id)
    {
        //
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->back();
    }


    /**
     * get last news  of a a specific feed determined by id
     * method respond to  AJAX request
     * @param  int $id of feed to be parsed and get last news
     * @return Response
     */

    public function FeedParse()
    {
        $id = $_POST['id'];
        $single_feed_parse = new FeedService();
        $count = $single_feed_parse->SingleFeedParse($id);
        return response($count);
    }
    
    
   public function test()
   {
        $s=new FeedService();
       $s->GetLastNews();



     //   //  $feed=Feed::find(8);
     //   // if($feed->HasTwitterLink())
     //   // {
     //   //  echo "has";
     //   // }
     //   // else{
     //   //  echo "no";
     //   // }

        // $fb = App('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');

        // $fb->setDefaultAccessToken(env('FACEBOOK_APP_TOKEN'));
        // try {

        //     $page_title='CNBCArabia/posts?limit='.config('khabar.facebook_limit');
        //     $response = $fb->get($page_title);
        // } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        //     return 0;

        // }


        // $PostsNode = $response->getGraphEdge();

        // // try{

        // // }catch(\Exception $e)
        // // {
        // //     continue;
        // // }
        // foreach ($PostsNode as $node) {
        //     # code...
        //     //echo $node['message'].'</br>';
        //     //print_r($node);
        //    // $title = isset($node['message']) ? $node['message'] : $node['story'];
        //      if(isset($node['message']))
        //      {
        //         $title=$node['message'];
        //         echo $title.'</br>';

        //      }
        //      if(isset($node['story']))
        //      {
        //         $title=$node['story'].'</br>';
        //         echo $title;

        //      }
        //      else{
        //         $title=null;
        //      }
        //     //echo var_dump($node['created_time']).'<br>';
        //     // $time = $node['created_time'];
        //     // $date= $time->format('Y-m-d H:i:s');
        //     // $date=Carbon::createFromFormat('Y-m-d H:i:s', $date);
        //     // $date=$date->subHours($feed->offset);

        //     // //extract image
        //     // $id = $node['id'];
        //     // try {
        //     //     $post_response = $fb->get($id . '?fields=full_picture,link');
        //     // } catch (\Facebook\Exceptions\FacebookSDKException $e) {


        //     // }

        //     // $data = $post_response->getGraphNode();
        //     // if (isset($data['full_picture'])) {
        //     //     $img= $data['full_picture'] ;
        //     // } else {
        //     //     $img = null;

        //     // }
        //     // if(isset($data['link']))
        //     // {
        //     //     $link=$data['link'];
        //     // }else{
        //     //     $link='https://www.facebook.com/'.$id;
        //     // }


        //     // if($title != $last_title)
        //     // {
        //     //     array_push($page_news,[
        //     //         'title' =>$title,
        //     //         'date' => $date,
        //     //         'link' =>$link,
        //     //         'image' =>$img

        //     //     ]);

        //     // }else{
        //     //     break;
        //     // }



        // }
  

    }
    public function instalogin(Instagram $instagram)
    {
        return $instagram->getLoginUrl();
        // or Instagram::getLoginUrl();
    }

// Get access token on callback, once user has authorized via above method
    public function instacallback(Request $request, Instagram $instagram)
    {
        $response = $instagram->getAccessToken($request->code);
        // or $response = Instagram::getAccessToken($request->code);

        if (isset($response['code']) == 400)
        {
            throw new \Exception($response['error_message'], 400);
        }

        return $response['access_token'];
    }
    



}