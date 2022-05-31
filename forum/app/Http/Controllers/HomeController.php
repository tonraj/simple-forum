<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionsModel;
use App\Models\CategoryModel;


class HomeController extends Controller
{
    function suggestion(Request $request){

        $all_questions = QuestionsModel::where(
            [
                ['status' , "=", "Approved"],
                ['content',  "like", "%".  $request->subject ."%"]
            ]
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
        
        $query = $request->query('q');
        $order = $request->query('order_by');

        if($query != null){
            $build = QuestionsModel::where('content', 'like',  '%' . $query . '%' )->where("status", "Approved");
        }else{
            $build = QuestionsModel::where("status", "Approved");
        }

        if($order == "latest_question"){
            $build = $build->orderBy('id','DESC');
        }

        if($order == "latest_activity" || $order == null || $order == ""){
            $build = $build->orderBy('updated_at','DESC');
        }

        $question = $build->paginate(20);

        return view('index', ["categories" => $get_all_categories, "questions" => $question]);
    }
}
