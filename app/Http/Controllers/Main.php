<?php

namespace App\Http\Controllers;

use App\Models\Task;
use DateTime;
use Illuminate\Http\Request;

class Main extends Controller
{
    public function home(){

        // get available tasks
        // $tasks = Task::all();
        $tasks = Task::where('visible',1)
                ->orderBy('created_at', 'desc')
                ->get();
        // $tasks = Task::where('visible',1)->get();
        return view('home', ['tasks'=>$tasks]);
    }

    // **************************************************
    public function list_invisibles(){
        // get available tasks
        // $tasks = Task::all();
        $tasks = Task::where('visible',0)
                ->orderBy('created_at', 'desc')
                ->get();
        // $tasks = Task::where('visible',1)->get();
        return view('home', ['tasks'=>$tasks]);
    }

    // **************************************************
    public function new_task(){

        // display new task form
        return view('new_task_frm');
    }

    public function new_task_submit(Request $request){
        // em php puro
        // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //     $new_task = $_POST['text_new_task'];
        //     echo $new_task;
        // }

        // laravel
        // nesse caso não preciso usar isMethod pois o verbo http da rota é post
        // if(!$request->isMethod('post')){
        //     die('URL errada!');
        // }

        // echo '<pre>';
        // print_r($request->input());
        // die();
        // if($request->isMethod('post')){
            $new_task = $request->input('text_new_task', 'SE NÃO ENCONTRAR O INPUT');
        // }

        $task = new Task();
        $task->task = $new_task;
        // $task->visible = 0;
        $task->save();

        return redirect()->route('home');

    }

    // **************************************************
    public function task_done($id){
        $task = Task::find($id);
        $task->done = new DateTime();
        $task->save();
        return redirect()->route('home');
    }

    // **************************************************
    public function task_undone($id){
        $task = Task::find($id);
        $task->done = null;
        $task->save();
        return redirect()->route('home');
    }

    // **************************************************
    public function edit_task($id){
        $task = Task::find($id);
        return view('edit_task_frm', ['task'=>$task]);
    }

    // **************************************************
    public function edit_task_submit(Request $request){
        $id_task = $request->input('id_task');
        $edit_task = $request->input('text_edit_task', 'Campo inexistente!');

        $task = Task::find($id_task);
        $task->task = $edit_task;
        $task->save();

        return redirect()->route('home');

    }

    // **************************************************
    public function task_invisible($id){

        $task = Task::find($id);
        $task->visible = 0;
        $task->save();

        return redirect()->route('home');
    }
    // **************************************************
    public function task_visible($id){

        $task = Task::find($id);
        $task->visible = 1;
        $task->save();

        return redirect()->route('home');
    }
}
