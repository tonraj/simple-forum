<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\QuestionsModel;
use App\Models\CategoryModel;
use App\Models\ReplyModel;
use App\Models\ReplyReply;
use Illuminate\Support\Facades\Http;

class QuestionController extends Controller
{

    function category_result(Request $request, $id){


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
        

        $build = QuestionsModel::where("category_id", $id)->whereHas('category', function($q) use($id) {
            $q->where('id', $id);
        });

        if($query != null){
            $build = $build->where('subject', 'like', '%' . $query . '%');
        }

        if($order == "latest_question"){
            $build = $build->orderBy('id','DESC');
        }

        if($order == "latest_activity"){
            $build = $build->orderBy('updated_at','DESC');
        }

        $question = $build->paginate(1);

        $category = CategoryModel::find($id);


        return view('index', ["categories" => $cat_array, "questions" => $question, 'category' => $category]);
    }

    function view_question(Request $request, $id){

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

        $question = QuestionsModel::find($id);

        if($request->method() == "POST"){
            
            if(array_key_exists('submit_comment', $request->post())){
                $form = $this->validate($request, [
                    'comment' => 'required|max:255',
                    'name' => 'required|max:255',
                ]);
    
                ReplyModel::create([
                    "content" => $form['comment'],
                    "status" => "Pending",
                    "name" => $form['name'],
                    "discussion_id" => $id,
                ]);

                $replies = ReplyModel::where('discussion_id', $id)->orderBy('id', "DESC")->paginate(5);

                return view('view_question', ["categories" => $cat_array, "question" => $question, "replies" => $replies ])->withSuccess("Comment posted.");
    
            }

            if(array_key_exists('reply', $request->post())){
                
                $form = $this->validate($request, [
                    'comment_id' => 'required|exists:reply,id',
                    'comment' => 'required|max:255',
                    'name' => 'required|max:255',
                ]);
    
                ReplyReply::create([
                    "content" => $form['comment'],
                    "status" => "Pending",
                    "name" =>  $form['name'],
                    "reply_id" => $form['comment_id'],
                ]);
                
                $replies = ReplyModel::where('discussion_id', $id)->orderBy('id', "DESC")->paginate(5);

                return view('view_question', ["categories" => $cat_array, "question" => $question, "replies" => $replies ])->withSuccess("Reply posted.");
                
            }

        }


        $replies = ReplyModel::where('discussion_id', $id)->orderBy('id', "DESC")->paginate(5);
    

        return view('view_question', ["categories" => $cat_array, "question" => $question, "replies" => $replies]);


    }


    function ask_question(Request $request){

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


        if($request->method() == "POST"){
            
            
            $form = $this->validate($request, [
                'name' => 'required|max:255',
                'category' => 'required|exists:categories,id',
                'question' => 'required',
                'g-recaptcha-response' => 'required',
            ]);


            $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => '6LdwXBQgAAAAACUAYEbc5Hbl3_-YdFI4PRHm4Z9Q',
                'response' => $form['g-recaptcha-response'],
            ]);

            if($response->ok() && $response->json()['success'] == true){
                QuestionsModel::create([
                    "name" => $form['name'],
                    "category_id" => $form['category'],
                    "content" => $form['question'],
                    "status" => "Pending",
                ]);
    
                return view('askquestion', ["categories" => $cat_array])->withSuccess("Question posted.");
            }else{
                return view('askquestion', ["categories" => $cat_array])->with('custom_error', "Invalid Captcha");
            }

        }

        
        return view('askquestion', ["categories" => $cat_array]);
    }
}
