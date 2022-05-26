<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionsModel;
use App\Models\CategoryModel;


class HomeController extends Controller
{
    function suggestion(Request $request){

        $all_questions = QuestionsModel::where(
            [['status' , "=", "Approved"],
            ['title',  "like", "%".  $request->subject ."%"]]
        )->get();
        
        return response()->json($all_questions);
    }

    function sitemap(Request $request){

        $all_questions = QuestionsModel::where(
            'status' , "Approved"
        )->get();

        return response()->view('sitemap ', [
            "questions" => $all_questions
        ])->header('Content-Type', 'application/xml');
    }
    
    function index(Request $request){

        $get_all_categories = CategoryModel::all();
        $cat_array = array();

        foreach($get_all_categories as $item){
            if($item->parent_id == null){
                if(!array_key_exists($item->name, $cat_array)){
                    $cat_array[$item->name] = array();
                }
            }else{
                $parent = CategoryModel::where('parent_id', $item->parent_id)->first();

                if(!array_key_exists($parent->main_category->name, $cat_array)){
                    $cat_array[$parent->main_category->name] = array();
                }

                array_push($cat_array[$parent->main_category->name], array($item->id, $item->slug, $item->name));
            }
        }
        

        $query = $request->query('q');
        $order = $request->query('order_by');

        if($query != null){
            $build = QuestionsModel::where('subject', 'like', $query);
        }else{
            $build = new QuestionsModel();
        }

        if($order == "latest_question"){
            $build = $build->orderBy('id','DESC');
        }

        if($order == "latest_activity"){
            $build = $build->orderBy('updated_at','DESC');
        }

        $question = $build->paginate(20);

        return view('index', ["categories" => $cat_array, "questions" => $question]);
    }
}
