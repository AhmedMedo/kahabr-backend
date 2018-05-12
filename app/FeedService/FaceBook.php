<?php namespace App\FeedService;
/**
 * Created by PhpStorm.
 * User: medo
 * Date: 26-Sep-16
 * Time: 1:30 PM
 */
use App\Feed;
use App\News;
use Carbon\Carbon;



class FaceBook
{





    public  function Start($feed){
        $news=$this->GetFaceBookPosts($feed);
        $this->SaveNews($news,$feed);
        return count($news);


    }



    public function GetFaceBookPosts($feed)
    {
        $page_news=[];
        $last_title=$this->GetLastTitle($feed);
        $fb = App('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');

        $fb->setDefaultAccessToken(env('FACEBOOK_APP_TOKEN'));
        try {

            $page_title=str_replace('https://www.facebook.com/','',$feed->facebook).'/posts?limit='.config('khabar.facebook_limit');
            $response = $fb->get($page_title);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return 0;

        }


        $PostsNode = $response->getGraphEdge();

        
            foreach ($PostsNode as $node) {
            # code...
           // $title = isset($node['message']) ? $node['message'] : $node['story'];
            $title=null;
            if(isset($node['message']))
             {
                $title=$node['message'];

             }
             if(isset($node['story']))
             {
                $title=$node['story'].'</br>';

             }
             // if(!isset($node['message']) || !isset($node['story'])){
             //    $title=null;
             // }
            $time = $node['created_time'];
            $date= $time->format('Y-m-d H:i:s');
            $date=Carbon::createFromFormat('Y-m-d H:i:s', $date);
            $date=$date->subHours($feed->offset);

            //extract image
            $id = $node['id'];
            try {
                $post_response = $fb->get($id . '?fields=full_picture,link');
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {


            }

            $data = $post_response->getGraphNode();
            if (isset($data['full_picture'])) {
                $img= $data['full_picture'] ;
            } else {
                $img = null;

            }
            if(isset($data['link']))
            {
                $link=$data['link'];
            }else{
                $link='https://www.facebook.com/'.$id;
            }


            if($title != $last_title)
            {
                array_push($page_news,[
                    'title' =>$title,
                    'date' => $date,
                    'link' =>$link,
                    'image' =>$img

                ]);

            }else{
                continue;
            }

        }

      
        return array_reverse($page_news);
    }




    public  function  SaveNews($page_news,$feed)
    {
        try {
            foreach ($page_news as $news)
            {

                $clear_title=preg_replace('/#(?=[\w-]+)/','',preg_replace('/(?:#[\w-]+\s*)+$/', '',$news['title']));
                $title=preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i','',$clear_title);
                $title=preg_replace('/\b(http?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i','',$title);




                $saved_news=new News([
                    'title'       =>$title,
                    'search_column'=>$news['title'],
                    'link'        =>$news['link'],
                    'imglink'     =>$news['image'],
                    'date'        =>$news['date'],
                    'lock'        =>1
                ]);


                try{
                    $feed->news()->save($saved_news);
                }catch(\ErrorException $e)

                {

                }

            }
                
        } catch (\Exception $e) {
            
        }
        
    }

    


    private function GetLastTitle($feed)
    {
        try{
            return $feed->news->last()->title;

        }catch (\Exception $e)
        {
            return null;
        }

    }


}