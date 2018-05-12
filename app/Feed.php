<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\News;

class Feed extends Model {

	//
		//protected $hidden=['created_at','updated_at','checked','protocol','success_counter','failure_counter'];
		protected $table = 'feeds';
		//protected $fillable = ['title', 'subtitle', 'country','language','type','topics','link','offset','protocol','status','img','success_counter','failure_counter','checked'];
		protected $fillable = ['id','processed', 'title', 'subtitle', 'country', 'category', 'subcategory', 'type', 'tags', 'website', 'header', 'logo', 'twitter', 'facebook', 'instagram', 'youtube', 'rss', 'language','created_at','updated_at','checked','protocol','facebookpage_status'];

    /*Many to Many relation*/

    public function news()
    {
        return $this->hasMany('App\News');
    }


        public function setCountryAttribute($value)
	   	 {
	        $this->attributes['country'] = strtolower($value);
	   	 }

	   	 public function setLanguageAttribute($value)
	   	 {
	        $this->attributes['language'] = strtolower($value);
	   	 }
		
	   	 public function getStatusAttribute($value)
	   	 {
	   	 	return $value == 1 ? 'published' : 'Draft';
	   	 }
		public static function CountriesHaveFeeds($countries_array){
		$filterd_countries=[];
		foreach ($countries_array as $country) {
			if(static::where('country',$country)->count() != 0)
			{
				array_push($filterd_countries, $country);
			}
			
		}
			return $filterd_countries;
	}
	

		public static function ResetTheService()
		{
			$feed= new Feed;
			if(Feed::count() == Feed::where('checked',1)->get()->count())
			{
				$feed->update(array('checked' =>0));
			}
			

		}



		public  function HasRssLink()
		{
			if(empty($this->rss) || is_null($this->rss))
			{
				return false;
			}
			return true;

		}


		public function HasFaceBookLink()
		{
			if(empty($this->facebook) || is_null($this->facebook))
			{
				return false;
			}
			return true;

		}

		public function HasTwitterLink()
		{
			if(empty($this->twitter) || is_null($this->twitter))
			{
				return false;
			}
			return true;


		}

/* Methods to reset the database*/

		public static function zero()
		{
			$feeds=Feed::all();
			foreach ($feeds as $feed) {
				# code...
				$feed->success_counter=0;
				$feed->failure_counter=0;
				$feed->checked=0;
				$feed->save();
			}
		}

		public static function zeroNews()
		{
			News::truncate();

		}

			public static function zeroCheck()
		{
			$feed= new Feed;
			
			$feed->update(array('checked' =>0));
			

		}

		
		
	

	/*End Methods*/





	


}
