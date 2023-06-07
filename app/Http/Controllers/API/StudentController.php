<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       try {
            $students = Student::all();

            return StudentResource::collection($students);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching students.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        try {
            $student = Student::create($request->validated());

            return response()->json([
                'message' => 'Student created successfully.',
                'data' => new StudentResource($student)
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {

            return response()->json(['message' => 'An error occurred while creating the student.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        try {

            return new StudentResource($student);

        } catch (\Exception $e) {

            return response()->json(['message' => 'An error occurred while fetching the student.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        try {

            $student->update($request->validated());

            return response()->json([
                'message' => 'Student updated successfully.',
                'data' => new StudentResource($student)
            ]);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        try {

            $student->delete();

            return response()->json([
                'message' => 'Student deleted successfully.',
            ]);

        } catch (\Exception $e) {

            return response()->json(['message' => 'An error occurred while deleting the student.'], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}
