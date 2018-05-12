<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class News extends Model {


	//protected $hidden=['lock','updated_at','feed_id'];
	protected $table = 'news';
	protected $fillable = ['title', 'link', 'imglink','description','search_column','date','lock'];
	protected $dates = ['created_at', 'updated_at', 'date'];


	public function feed()
	{
		return $this->belongsTo('App\Feed');
		
	}
    public function getDates()
    {
        return ['date'];
    }
    public function getFullDataAttribute()
    {
        return $this->title.' '.$this->description;
    }


	 public function getDescriptionAttribute($value)
    {
        return trim(strip_tags($value));
    }
    public function setDescriptionAttribute($value)
    {

        $this->attributes['description'] = trim(strip_tags($value));
    }
    public function setTitleAttribute($value)
    {
        $title=preg_replace('@((https?://)?([-\\w]+\\.[-\\w\\.]+)+\\w(:\\d+)?(/([-\\w/_\\.]*(\\?\\S+)?)?)*)@','',trim(strip_tags($value)));

        $this->attributes['title'] = preg_replace('/#(?=[\w-]+)/','',preg_replace('/(?:#[\w-]+\s*)+$/', '',$title));
    }
    public function setSearchColumnAttribute($value)
    {

        $this->attributes['search_column']=$this->clean_text($value);
    }
    public function getLinkAttribute($value)
    {
        return urldecode($value);
    }

    public  function  getDateAttribute($value){
        $date=new Carbon($value);

        return $this->arabic_date_format($date);
    }
    public function getTitleAttribute($value)
    {
    	return preg_replace('/\\\\/', '', $value);
    }

    public function arabic_date_format($timestamp)
    {
        $periods = array(
            "second"  => "ثانية",
            "seconds" => "ثواني",
            "minute"  => "دقيقة",
            "minutes" => "دقائق",
            "hour"    => "ساعة",
            "hours"   => "ساعات",
            "day"     => "يوم",
            "days"    => "أيام",
            "month"   => "شهر",
            "months"  => "شهور",
        );

        $difference = Carbon::now()->diffInSeconds($timestamp);

        $plural = array(3,4,5,6,7,8,9,10);

        $readable_date = "منذ ";

        if ($difference < 60) // less than a minute
        {
            $readable_date .= $difference . " ";
            if (in_array($difference, $plural)) {
                $readable_date .= $periods["seconds"];
            } else {
                $readable_date .= $periods["second"];
            }
        }
        elseif ($difference < (60*60)) // less than an hour
        {
            $diff = (int) ($difference / 60);
            $readable_date .= $diff . " ";
            if (in_array($diff, $plural)) {
                $readable_date .= $periods["minutes"];
            } else {
                $readable_date .= $periods["minute"];
            }
        }
        elseif ($difference < (24*60*60)) // less than a day
        {
            $diff = (int) ($difference / (60*60));
            $readable_date .= $diff . " ";
            if (in_array($diff, $plural)) {
                $readable_date .= $periods["hours"];
            } else {
                $readable_date .= $periods["hour"];
            }
        }
        elseif ($difference < (30*24*60*60)) // less than a month
        {
            $diff = (int) ($difference / (24*60*60));
            $readable_date .= $diff . " ";
            if (in_array($diff, $plural)) {
                $readable_date .= $periods["days"];
            } else {
                $readable_date .= $periods["day"];
            }
        }
        elseif ($difference < (365*24*60*60)) // less than a year
        {
            $diff = (int) ($difference / (30*24*60*60));
            $readable_date .= $diff . " ";

            if (in_array($diff, $plural)) {
                $readable_date .= $periods["months"];
            } else {
                $readable_date .= $periods["month"];
            }
        }
        else
        {
            $readable_date = $timestamp->toDateTimeString();
        }

       // $result="\"$readable_date\"";
        return $readable_date;
    }




private  function clean_text($content)
{
    $arr=['أ'=>'ا',
        'إ'=>'ا',
        'آ'=>'ا',
        "ة"=>'ه',
        "ّ"=>'',
        "َّ"=>'',
        "ُّ"=>'',
        "ٌّ"=>'',
        "ًّ"=>'',
        "ِّ"=>'',
        "ٍّ"=>'',
        "ْ"=>'',
        "َ"=>'',
        "ً"=>'',
        "ُ"=>'',
        "ِ"=>'',
        "ٍ"=>'',
        "ٰ"=>'',
        "ٌ"=>'',
        "ۖ"=>'',
        "ۗ"=>'',
        "ـ"=>''

    ];
    foreach($arr as $key => $val)
    {

        $cleaned_text=str_replace($key,$val,$content);
        $content=$cleaned_text;
    }

    return $cleaned_text;
}

 
 	public function check_news_link()
 	{
 		   $headers = @get_headers($this->imglink);
		   $headers = (is_array($headers)) ? implode( "\n ", $headers) : $headers;

		   return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);

	}
	

}
