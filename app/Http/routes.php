<?php

use App\News;
use App\Feed;

DEFINE('DS', DIRECTORY_SEPARATOR);


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*  routes for  add feeds*/

Route::get('/', 'FrontPageController@index');
Route::get('/insta','NewsController@instalogin');
Route::get('/insta/callback','NewsController@instacallback');
Route::get('/result', 'FrontPageController@SearchResult');
Route::get('/more/{id}', ['as' => 'more', 'uses' => 'FrontPageController@LoadMore']);

/*This rout used by Ahmed Alaa just from some testing*/
Route::get('/test', 'NewsController@test');


/********************** Old front end links *************************/

/*
Route::get('/','HomeController@index');
Route::get('/news/{id}',['as'=>'newsinfo','uses'=>'HomeController@NewsInfo']);
Route::post('/result','HomeController@result');
Route::get('/feednews/{title}',['as' => 'feednews' ,'uses' =>'HomeController@FeedNews']);

Route::group(['prefix' => 'ajax'], function()
{
   //ajax post links used in the old front page

   Route::post('more','HomeController@LoadMore');
   Route::post('result','HomeController@result');
   Route::post('moreresult','HomeController@moreResult');
   Route::post('feednews','HomeController@FeedNews');
   Route::post('morefeednews','HomeController@MoreFeedNews');
   Route::post('morefeeds','HomeController@MoreFeeds');
   Route::post('feedlist','HomeController@feedlist');
   Route::post('newsbycountry','HomeController@NewsByCountry');



});

*/
/********************End old front end links  *******************************/


/****************** Dashboard links ***********************/

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
Route::get('feeds','AdminController@ShowFeeds');
    //Route::get('/newfeed',['as' => 'newfeed','uses' =>'AdminController@create']);
    Route::post('/newfeed', 'AdminController@store');
    Route::get('/editfeed/{id}', ['as' => 'edit', 'uses' => 'AdminController@edit']);
    Route::post('/feed/{id}', 'AdminController@update');
    Route::resource('/delete', 'AdminController',
        ['only' => ['destroy']]);
    /*News Routes*/
    Route::resource('/news', 'NewsController');
    /**/
    Route::get('/newadmin', 'AdminController@newAdmin');
    Route::post('/newadmin', 'AdminController@postAdmin');

    //Dashboard Links
    Route::post('/feedparse', 'NewsController@FeedParse');
    Route::post('/checkWebsite', 'AdminController@CheckWebsite');
    Route::post('/checkRss', 'AdminController@RssLink');
    Route::post('/checkTwitter', 'AdminController@TwitterLink');
    Route::post('/checkFB', 'AdminController@FBLink');
    Route::post('/checkYouTube', 'AdminController@YouTubeLink');
    Route::post('/checkInstagram', 'AdminController@InstagramLink');



    Route::get('/adminmembers', 'AdminController@AdminMembers');
    Route::get('/adminmembers/edit/{id}', ['as' => 'updatemember', 'uses' => 'AdminController@EditMember']);
    Route::post('/adminmembers/update/{id}', 'AdminController@UpdateMember');
    Route::get('/adminmembers/delete/{id}', ['as' => 'deletemember', 'uses' => 'AdminController@DeleteMember']);


    Route::post('/savefile','AdminController@SaveFile');

    Route::controller('finalfeeds', 'DatatablesController', [
        'anyData' => 'feeds.data',
        'getIndex' => 'finalfeeds',
    ]);
});
/******************End Dashboard links ***********************/


/************************* Mobile API Routes   *****************************/
Route::group(['prefix' => 'api'], function () {

    // menu links
    Route::get('menu/{language}/{country}', 'ApiController@menu');
    Route::get('menu/{language}/{country}/categories', 'ApiController@CountryCategories');
    Route::get('menu/{lanuguage}/international/{topic}', 'ApiController@InternationalTopics');
    Route::get('menu/{language}/topic/{topic}', 'ApiController@TopicFeeds');
    Route::get('news/{language}/magazine/{topic}/{state?}/{id?}', 'ApiController@MagazineFeeds');

    //navigate feed news
    Route::get('news/{language?}/{country?}/{title?}/{state?}/{id?}/{limit?}', 'ApiController@GetNews');


   //save user preferences
    Route::post('prefs/add', 'ApiController@AddUserPreferences');

    //get user preferences
    Route::post('prefs/get', 'ApiController@GetUserPreferences');

    //user news
    Route::post('usernews', 'ApiController@UserNews');
    Route::post('usernews/recent', 'ApiController@UserRecentNews');
    Route::post('usernews/more', 'ApiController@UserMoreNews');

    //user bookmarks
    Route::post('getnews', 'ApiController@UserBookMark');
    Route::post('recentnews', 'ApiController@RecentNews');


    /*Search API links*/
    //full search
    Route::post('news/{language}/{country}/fullsearch/{state?}', 'ApiController@FullSearch');

    //user search
    Route::post('news/usersearch/{state?}', 'ApiController@UserSearch');

    //feed Search
    Route::post('news/feedsearch/{state?}', 'ApiController@NewsByFeed');
    //feeds title
    Route::post('feeds','ApiController@SearchAllFeeds');
});


/************************* End Mobile API Routes   *****************************/


Route::get('auth/edit', 'AdminController@viewEdit');
Route::post('auth/edit', 'AdminController@PostEdit');
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

