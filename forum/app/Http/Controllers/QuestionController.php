<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\QuestionsModel;
use App\Models\CategoryModel;
use App\Models\ReplyModel;
use App\Models\ReplyReply;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class QuestionController extends Controller
{

    function category_result(Request $request, $id){


        $get_all_categories = CategoryModel::all();

        $query = $request->query('q');
        $order = $request->query('order_by');
        

        $build = QuestionsModel::where("category_id", $id)->whereHas('category', function($q) use($id) {
            $q->where('id', $id);
        });

        if($query != null){
            $build = $build->where('content', 'like', '%' . $query . '%');
        }

        if($order == "latest_question"){
            $build = $build->orderBy('id','DESC');
        }

        if($order == "latest_activity"){
            $build = $build->orderBy('updated_at','DESC');
        }

        $question = $build->paginate(20);

        $category = CategoryModel::find($id);


        return view('index', ["categories" => $get_all_categories, "questions" => $question, 'category' => $category]);
    }

    function view_question(Request $request, $id, $slug){

        $get_all_categories = CategoryModel::all();
        
        $question = QuestionsModel::where("id", $id)->where('slug', $slug)->firstOrFail();

        if($request->method() == "POST"){
            
            if(array_key_exists('submit_comment', $request->post())){
                $form = $this->validate($request, [
                    'comment' => 'required|max:255',
                    'name' => 'required|max:255',
                ],[   
                    'comment.required'    => 'Please write your answer.',
                    'name.required' => 'Please enter your name.',
                ]);
    
                ReplyModel::create([
                    "content" => $form['comment'],
                    "status" => "Pending",
                    "name" => $form['name'],
                    "discussion_id" => $id,
                ]);

                $replies = ReplyModel::where('discussion_id', $id)->orderBy('id', "DESC")->paginate(5);

                $question->updated_at = Carbon::now();
                $question->save();
                

                return view('view_question', ["categories" => $get_all_categories, "question" => $question, "replies" => $replies ])->withSuccess("Your Answer has been posted.");
    
            }

            if(array_key_exists('reply', $request->post())){
                
                $form = $this->validate($request, [
                    'comment_id' => 'required|exists:reply,id',
                    'comment' => 'required|max:255',
                    'name' => 'required|max:255',
                ],[   
                    'comment_id.required'    => 'Comment id is invalid.',
                    'comment_id.exists'      => 'Replying comment does not exist.',
                    'comment.required' => 'Please write your reply.',
                    'name.required' => 'Please enter your name.',
                ]);
    
                ReplyReply::create([
                    "content" => $form['comment'],
                    "status" => "Pending",
                    "name" =>  $form['name'],
                    "reply_id" => $form['comment_id'],
                ]);
                
                $replies = ReplyModel::where('discussion_id', $id)->orderBy('id', "DESC")->paginate(5);

                $question->updated_at = Carbon::now();
                $question->save();

                return view('view_question', ["categories" => $get_all_categories, "question" => $question, "replies" => $replies ])->withSuccess("Your reply has been posted.");
                
            }

        }


        $replies = ReplyModel::where('discussion_id', $id)->orderBy('id', "DESC")->paginate(5);
    

        return view('view_question', ["categories" => $get_all_categories, "question" => $question, "replies" => $replies]);


    }


    function ask_question(Request $request){

        $get_all_categories = CategoryModel::all();
      

        if($request->method() == "POST"){
            
            
            $form = $this->validate($request, [
                'name' => 'required|max:75',
                'category' => 'required|exists:categories,id',
                'question' => 'required',
                'g-recaptcha-response' => 'required',
            ],
            [   
                'name.required'    => 'Please enter your Name',
                'category.required' => 'Please select the question category.',
                'category.exists' => 'Please select a valid question category.',
                'g-recaptcha-response.required' => 'Please solve the captcha.',
            ]
        );


            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => '6LdwXBQgAAAAACUAYEbc5Hbl3_-YdFI4PRHm4Z9Q',
                'response' => $form['g-recaptcha-response'],
            ]);

            if($response->ok() && $response->json()['success'] == true){
                QuestionsModel::create([
                    "name" => $form['name'],
                    "category_id" => $form['category'],
                    "content" => $form['question'],
                    "status" => "Pending",
                    "slug" => Str::slug($form['question'], '-')
                ]);
    
                return view('askquestion', ["categories" => $get_all_categories])->withSuccess("Your question is saved and awaiting for approval.");
            }else{
                return view('askquestion', ["categories" => $get_all_categories])->with('custom_error', "Invalid Captcha!");
            }

        }

        return view('askquestion', ["categories" => $get_all_categories]);
    }
}
