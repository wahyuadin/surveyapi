<?php

namespace App\Http\Controllers;

use App\Models\question;
use App\Models\response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Survey;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function PostSurvey(Request $request) {
        try {
            $this->validate($request, [
                'title'         => 'required',
                'description'   => 'required'
            ]);
            $query = Survey::create($request->all());
            if ($query) {
                return response()->json(Survey::showByid($query->id), 201);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => true, 'message' => $e->validator->errors()->all()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function GetSurvey() {
        return response()->json(Survey::getAll(), 200);
    }

    public function GetSurveyId($survey_id) {
        return response()->json(Survey::showById($survey_id), 200);
    }

    public function PostSurveiResponses(Request $request, $id) {
        try {
            $this->validate($request, [
                'user_id' => 'required|integer|min:1',
                'answers' => 'required|array',
                'answers.*.question_id' => 'required|integer|min:1',
                'answers.*.answer' => 'required',
            ]);

            $response = new response();
            $response->survey_id    = $id;
            $response->question_id  = $request->answers[0]['question_id'];
            $response->answers = $request->answers[0]['answer'];
            $response->user_id = $request->user_id;
            if ($response->save()) {
                return response()->json([
                    'survey_id' => $id,
                    'user_id'   => $request->user_id,
                    'answers'   => [
                        'question_id'   => $request->answers[0]['question_id'],
                        'answer'        => $request->answers[0]['answer']
                    ],
                    'created_at' => $response->created_at->toIso8601String(),
                    'updated_at' => $response->updated_at->toIso8601String(),
                ]);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => true, 'message' => $e->validator->errors()->all()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function GetSurveiResponses($id) {
        return response()->json(response::showById($id));
    }

    public function PostQuestion(Request $request, $id) {
        try {
            $this->validate($request, [
                'question'  => 'required',
                'type'      => 'required',
                'options'    => 'required|array',
            ]);
            $data = $request->all();
            $data['survey_id']  = $id;

            $query = question::create($data);
            if ($query) {
                return response()->json($query);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => true, 'message' => $e->validator->errors()->all()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
