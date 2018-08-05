<?php

namespace App\Http\Controllers;

use App\Models\Students;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function __construct()
    {

    }

    public function welcome()
    {
        return view('hello');
    }

    /**
     * View all students found in the database
     */
    public function viewStudents()
    {
        $students = Students::with('course')->get();
        return view('view_students', compact('students'));
    }

    /**
     * Exports all student data to a CSV file
     */
    public function exportStudentsToCSV(Request $request)
    {
        $allCheckedStudents = $request->get('studentId');

        foreach ($allCheckedStudents as $studId) {
            $filterStudentId[] = (int)$studId;
        }

        $students = Students::with('course')->whereIn('id', $filterStudentId)->get();
        $filename = "students.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, [
            'Firstname',
            'Surname',
            'Email',
            'University',
            'Course'
        ]);

        foreach ($students as $student) {
            fputcsv($handle, [$student['firstname'], $student['surname'], $student['email'],
                $student['course']['university'], $student['course']['course_name']]);
        }

        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'students.csv', $headers);


    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exportCourseAttendenceToCSV()
    {

    }
}
