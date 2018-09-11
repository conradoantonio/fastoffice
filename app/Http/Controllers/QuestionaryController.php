<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Audit;
use App\Models\Question;
use App\Models\AuditDetail;
use App\Models\QuestionCategory;

class QuestionaryController extends Controller
{
    /**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {
    	$questions = Question::where('status', 1)->get();

    	if ($req->ajax()) {
            return view('questionary.table', ['questions' => $questions]);
        }
        return view('questionary.index', ['questions' => $questions]);
    }

    /**
     * Show the form for creating/editing a resource about a question.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($id = 0)
    {
        $question = null;
        $categories = QuestionCategory::all();
        if ($id) {
            $question = Question::where('status', 1)->where('id', $id)->first();
        }
        return view('questionary.form', ['question' => $question, 'categories' => $categories]);
    }

    /**
     * Save the contract data.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $req)
    {
    	$row = New Question;

    	$row->question = $req->question;
    	$row->category_id = $req->category_id;

    	$row->save();

        return response(['msg' => 'Pregunta guardada correctamente', 'status' => 'success', 'url' => url('questionario/auditoria')]);
    }

    /**
     * Updates the contract data.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
    	$row = Question::find($req->id);

    	if (!$row) { return response(['msg' => 'Pregunta no encontrada', 'status' => 'error']); }

    	$row->question = $req->question;
    	$row->category_id = $req->category_id;

    	$row->save();

        return response(['msg' => 'Pregunta actualizada correctamente', 'status' => 'success', 'url' => url('questionario/auditoria')]);
    }

    /**
     * Change the status of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_status(Request $req)
    {
    	$row = Question::find($req->id);

    	if (!$row) { return response(['msg' => 'Pregunta no encontrada', 'status' => 'error']); }

    	$row->status = 0;

    	$row->save();

        return response(['msg' => 'Pregunta eliminada correctamente', 'status' => 'success', 'url' => url('questionario/auditoria')]);
    }
}
