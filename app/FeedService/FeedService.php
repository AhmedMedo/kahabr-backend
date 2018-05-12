<?php namespace App\FeedService;

use App\News;
use App\Feed;
use Carbon\Carbon; //datetime class
use App\FeedService\FaceBook;

use GuzzleHttp\Client;// to get news from Al Arabia
set_time_limit(0);

ini_set('memory_limit','128M');
\Log::useDailyFiles(storage_path().'/feedservice/service.log');

class FeedService {





    /**
     * parse only one feed
     * @param id of the feed
     * @return number of news
     */

    public  function  SingleFeedParse($id)
    {
        $feed=Feed::find($id);
            $count=0;
         if($feed->HasFaceBookLink())
            {
                $fb=new FaceBook();
                $count_FB_News=$fb->Start($feed);
                $count=$count_FB_News;

            }
        else{
            if($feed->HasTwitterLink())
            {
                $count_tw_news=$this->ValidateXMLParsing($feed,"tw");
                $count=$count+$count_tw_news;
            }else{
                if($feed->HasRssLink())
                {
                    $count_RSS_news=$this->ValidateXMLParsing($feed,"rss");
                    $count=$count+$count_RSS_news;

                }



            }


        }



           return $count;

    }


    /**
     * Get news from feeds in the service
     * @return response
     */
    public   function GetLastNews()
    {

        $feeds=Feed::where('checked',0)->take($this->CalculateTheLimit())->get();

        \Log::info('Limit', ['limit' => $this->CalculateTheLimit()],PHP_EOL);
        foreach ($feeds as $feed) {
            //add check flag to the check column
            $feed->checked=1;
            $feed->save();

        if($feed->HasFaceBookLink())
            {
                $fb=new FaceBook();
                $fb->Start($feed);

            }
        else{
            if($feed->HasTwitterLink())
            {
                $this->ValidateXMLParsing($feed,"tw");
            }else{
                if($feed->HasRssLink())
                {
                    $this->ValidateXMLParsing($feed,"rss");

                }

            }


        }



            \Log::info('The feed has been parsed', ['feed_title' => $feed->title],PHP_EOL);


        }



        //reset the checked column to start loop again
        $this->ResetTheService();

    }


    /**
     * get news from xml file and save it then print count of news
     *
     * @param $feed
     * @return int|string
     */
    public function ValidateXMLParsing($feed,$source)
    {
        $parsedFeed=$this->ReadContentFromXML($feed,$source);

        if(is_null($parsedFeed) || empty($parsedFeed->channel->item))
        {
                if($source=="tw"){$link=$feed->twitter;}
                if($source=="rss"){$link=$feed->rss;}
            \Log::info('This feed contain empty data in the xml file', ['feed_title' => $feed->title,'link' =>urldecode($link)],PHP_EOL);
        }
        else{
            //get all news from the xml link of the feed
            $news=$this->GetNewsFromParsing($parsedFeed,$feed,$source);


            if(count($news) > 0)
            {
                // this means that there are news found after parsing
                //add this news to the database of the feed
                $this->saveNews($news,$feed,$parsedFeed,$source);

                return count($news);

            }else{
                $count='0';
                return $count;
            }

        }

    }

    /**
     * get the content of the feed link XML and return it as JSON
     *
     * @return mixed
     */
    public function ReadContentFromXML($feed,$source)
    {
        try{
            libxml_use_internal_errors(true);

            //check if the feed link is alarabiya  as it has a special way in parsing
            switch ($source) {
                case 'tw':
                    $link='https://twitrss.me/twitter_user_to_rss/?user='.str_replace('https://twitter.com/','',$feed->twitter);
                    break;
                case 'rss':
                    $link=$feed->rss;
                    break;

                default:
                    # code...
                    break;
            }
            // if($source="tw")
            // {
            //     $link=$feed->twitter;
            // }
            // if($source ="rss"){
            //     $link=$feed->rss;
            // }
            if(strpos($link, 'www.alarabiya.net') !== false){

                $content=$this->alarabia_parse($feed->link);

            }else{

                //get content from the xml link
                $get_file_data=file_get_contents(trim($link));

                //set all headers to utf-8
                $content=str_replace('utf-16','utf-8',$get_file_data);

            }


            //get json body of the news
           $xml=@simplexml_load_string($content);

            return $xml ? $xml:null;

        }

        catch (\Exception $e)
        {
            return null;
        }

    }


    /**
     * get the last title on the news saved related to the given feed to compare it with all upcoming news
     *
     * @param $feed
     * @return null
     */
    private function GetLastTitle($feed)
    {
       try{
           return $feed->news->last()->title;

       }catch (\Exception $e)
       {
           return null;
       }

    }


    /**
     * get last news from the xml and save in in array
     *
     *@param ParsedFeed
     *
     *@return array of news
     */

    private function GetNewsFromParsing($ParsedFeed,$feed)
    {
        $news = array();
        //$title_array = $this->FeedNewsTitleAsArray($feed);
        $last_title=$this->GetLastTitle($feed);
        foreach ($ParsedFeed->channel->item as $item) {

            if(strcmp($item->title, $last_title))
            {
                array_push($news, $item);

            }else{
                break;
            }

        }
      return array_reverse($news);
    }

    private function saveNews($news,$feed,$parsedFeed,$source)
    {
        // $news -> array of objects of news
        for($i=0 ; $i<count($news) ; $i++)
        {

            $item=$news[$i];
            try{
                $image = $this->ExtractImageFromItem($item, $parsedFeed);

            }catch (\Exception $e)
            {
                $image=null;

            }

            // title and link
            $itembody=$this->GetItemContents($item,$feed,$source);
            //final check
                //$date=$this->ExtractDate($item,$feed);

            try {
                $date=$this->ExtractDate($item,$feed);

            } catch (\Exception $e) {


                $date=Carbon::now();

            }

            $saved_news=new News([
                'title'       =>$itembody['title'],
                'description' =>$itembody['description'],
                'search_column'=>$itembody['title'].' '.$itembody['description'],
                'link' 		  =>trim($itembody['link']),
                'imglink'     =>$image,
                'date'        =>$date,
                'lock'        =>1
            ]);

                //$feed->news()->save($saved_news);

            try{
                $feed->news()->save($saved_news);
                //$saved_news->save();

            }catch(\Exception $e)

            {
                continue;
            }

        }
    }

    /**
     * Extract image from the item body
     *
     *@param $item represent the item body of each news in the xml
     * @param $parsedFeed represent the main body of the xml
     *
     *@return
     */
    private function ExtractImageFromItem($item,$parsedFeed)
    {
        if(isset($item->image))
        {

            if( preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $item->image, $image_url))
            {

                return  $image_url[1];
            }
            else if (filter_var($item->image, FILTER_VALIDATE_URL) === FALSE){
                return $parsedFeed->channel->link.'/'.$item->image;
            }else{
                return $item->image;
            }
        }
        if($item->enclosure)
        {
            $attr=$item->enclosure->attributes();
            if( preg_match('/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i', $attr['url']) ) {

                return  $attr['url'];
            }
        }

        if($item->xpath('media:thumbnail[1]'))
        {
            $image = $item->xpath('media:thumbnail[1]');
            return $image[0]['url'];
        }
        if($item->xpath('media:content[1]'))
        {
            $image = $item->xpath('media:content[1]');
            return $image[0]['url'];
        }

        if( preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $item->description, $image_url))
        {

            return  $image_url[1];
        }


        return null;

    }

    /**
     *  Extract title , description and link from the item body in xml
     *
     *@param $item   represent the  item body of the news given
     *@param $source represent the type of the feed , "rss" , "facebook" , "twitter"
     *
     *
     *@return
     */
    private function GetItemContents($item,$feed,$source)
    {
        if($source == "rss")
        {
            return ['title' => $item->title,'description' =>$item->description,'link'=>$item->link];
        }
        if($source == "tw")
        {
            //remove #
            $clear_title=preg_replace('/#(?=[\w-]+)/','',preg_replace('/(?:#[\w-]+\s*)+$/', '', $item->title));
            $pattern ='@((http?://)?([-\\w]+\\.[-\\w\\.]+)+\\w(:\\d+)?(/([-\\w/_\\.]*(\\?\\S+)?)?)*)@';
            if(preg_match($pattern, $clear_title,$matchs))
            {
                $link= $matchs[0];

            }else{
                $link='';
            }

            $title=str_replace($link,'',$clear_title);

            $title=preg_replace("/pic.twitter.com\/[^\s]+/","",$title);
            $title=preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i','',$title);
            $title=preg_replace('/\b(http?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i','',$title);
            $title=str_replace('https://','',$title);


            return ['title' => $title , 'description' =>$title , 'link' =>$link];


        }




    }

    /**
     * get last news from the xml and save in in array
     *
     *@param ParsedFeed
     *
     *@return
     */

    private function ArabicDateToEnglishStructure($date)
    {
        $date_array=explode(" ",$date);
        $ArabicDay_to_english=[
            'الجمعة' =>'Fri',
            'السبت'  =>'Sat',
            'الأحد'  =>'Sun',
            'الإثنين' =>'Mon',
            'الثلاثاء'=> 'Tue',
            'الأربعاء'=>'Wed',
            'الخميس'=>'Thu'

        ];
        $ArabicMonth_to_english=[
            "يناير"  =>"Jan" ,
            "فبراير" =>"Feb",
            "مارس"   => "Mar",
            "أبريل"  =>  "Apr",
            "مايو"   =>  "May",
            "يونيو"  =>  "Jun" ,
            "يونيه"  =>	  "Jun",
            "يوليه" => "Jul",
            "يوليو"  =>  "Jul" ,
            "أغسطس"  =>  "Aug" ,
            "سبتمبر" =>  "Sep" ,
            "أكتوبر" =>  "Oct" ,
            "نوفمبر" =>  "Nov" ,
            "ديسمبر" =>  "Dec"
        ];
        $mode=[
            'ص' =>'AM',
            'م' =>'PM'
        ];

        $english_date  =$ArabicDay_to_english[str_replace('،','',$date_array[0])];
        $english_date .=', '.$date_array[1].' '.$ArabicMonth_to_english[$date_array[2]].' ';
        $english_date .=$date_array[3].' '.$date_array[4].' '.$mode[$date_array[5]];

        return $english_date;



    }



    private function alarabia_parse($link)
    {

        $client = new \GuzzleHttp\Client(['cookies' => true,'verify' => false]);
        //$client->setDefaultOption('verify', false);
        $res = $client->request('GET', $link);

        $firstResponse = $res->getBody();

// Search for following string
// setCookie('YPF8827340282Jdskjhfiw_928937459182JAX666', '49.49.242.64', 10);
        $pattern = '/[^setCookie\(\')](.*?),/';

        preg_match_all($pattern, $firstResponse, $matches);

// You may have to adjust this
        $cookie = $matches[1][4]; // YPF8827340282Jdskjhfiw_928937459182JAX666
        $ip = $matches[1][5]; // 49.49.242.64

        $cookieName = explode("'", $cookie)[1];
        $cookieValue = explode("'", $ip)[1];

// Set cookie value, Cookie: $cookieName=$cookieValue

        $res = $client->request('GET', $link, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 ' .
                    '(KHTML, like Gecko) Chrome/53.0.2785.89 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,' .
                    'image/webp,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, sdch',
                'Cookie' => ["$cookieName=$cookieValue"],
                'Referer' => 'http://www.alarabiya.net/.mrss/ar.xml',
                'Upgrade-Insecure-Requests' => 1,
                'Connection' => 'keep-alive',
            ],
            // 'debug' => false, // Set to true for debugging
        ]);

        return $res->getBody();


    }


    private  function ExtractDate($item,$feed)
    {
        if(isset($item->pubdate))
        {

            $date=$item-pubdate;

        }


        else if(isset($item->pubDate))
        {
            //check if date is arabic

                $date=$item->pubDate;


        }
        else
        {

            return Carbon::now();
        }

        if($this->is_arabic_date($date))
        {
           // transform it to english format
                $english_date=$this->ArabicDateToEnglishStructure($item->pubDate);
                $parsed_date=Carbon::parse($english_date);
                $carbon_date=Carbon::createFromFormat('Y-m-d H:i:s', $parsed_date);
                //return $carbon_date->subHours($feed->offset);
            return $this->DateConstraint($carbon_date->subHours($feed->offset));



        }
        else if($this->is_english_date($date))
        {
            $parsed_date=Carbon::parse($date);
            $carbon_date=Carbon::createFromFormat('Y-m-d H:i:s', $parsed_date);
            //return $carbon_date->subHours($feed->offset);

            return $this->DateConstraint($carbon_date->subHours($feed->offset));

        }
        else
        {
            $carbon_date=Carbon::createFromFormat('Y-m-d H:i:s', $date);
            //return $carbon_date->subHours($feed->offset);
            return $this->DateConstraint($carbon_date->subHours($feed->offset));
        }


    }

    public function ResetTheService()
    {
        $feed= new Feed;
        if(Feed::count() == Feed::where('checked',1)->get()->count())
        {
            $feed->update(array('checked' =>0));
            \Log::info('=========================Service will iterate Again ==================================='.PHP_EOL);



        }

    }

    private function is_arabic_date($date)
    {
        return (preg_match('/[أ-ي]/ui', $date));
    }
    private function is_english_date($date)
    {
        return (preg_match('/[a-z]/ui', $date));
    }

    private  function CalculateTheLimit(){

        $number_of_feeds=Feed::count();
        $delimiter=config('khabar.Number_of_service_calls_per_day')/config('khabar.Number_of_trials');
        $limit=ceil($number_of_feeds/$delimiter);
        return $limit;
    }


    /**
     * check if the incoming datetime is greater than the time now
     * @param $date
     * @return static
     */
    private  function DateConstraint($date)
    {
        return ($date > Carbon::now()) ? Carbon::now() : $date;
    }





}


