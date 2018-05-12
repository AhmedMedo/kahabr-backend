<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Feed;
use App\News;
use Illuminate\Http\Request;
use Auth;
use DB;

class DatatablesController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    }
	 public function getIndex()
    {
        // $feeds=Feed::orderBy('id','ASC')->paginate(20);
        // $feeds->setPath('');

    

        $type=DB::table('feeds')->distinct()->lists('type');
        $topics=DB::table('feeds')->distinct()->lists('topics');
        $languages=config('khabar.languages');
        $countries=config('khabar.all_countries');
        return view('admin.feeds',compact('languages','type','topics','countries'));

}
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        //  $count=count(Datatables::of(Feed::query())->make(true));
        // var_dump(Datatables::of(Feed::query())->make(true));
        $feeds=Feed::select(['id','logo','title','subtitle']);
         return Datatables::of($feeds)
         ->addColumn('feednews',function($feed){
            return '<a href="'.route('admin.news.show',$feed->id).'">'.'<strong> show feed news </strong></a>';
         })
         ->addColumn('edit', function ($feed) {
                return '<a href="editfeed/'.$feed->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->addColumn('delete', function ($feed) {
                return '<form method="POST"'." action=".route('admin.delete.destroy',$feed->id).'>'.'<input name="_method" type="hidden" value="DELETE">'.'<button type="submit" class="btn btn-danger btn-rounded">'.'<span class="glyphicon glyphicon-remove"></span>
                    </button>'.'</form>';
                })
             ->addColumn('parse','<button class="btn btn-xs btn-danger" id="parse_{{$id}}">'.'Parse now'.'</button>')

             ->editColumn('id', '{{$id}}')
            ->make(true);
        //return Datatables::of(Feed::query())->make(true);
    }

}
