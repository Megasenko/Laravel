<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;


use App\Models\StudentAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $students = Student::with('course')->get();
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

        $students = Student::with('course', 'address')->whereIn('id', $filterStudentId)->get();
        $filename = "students.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, [
            'Firstname',
            'Surname',
            'Email',
            'Nationality',
            'University',
            'Course',
            'House No',
            'Post code',
            'City',
        ]);

        foreach ($students as $student) {
            fputcsv($handle, [
                $student['firstname'],
                $student['surname'],
                $student['email'],
                $student['nationality'],
                $student['course']['university'],
                $student['course']['course_name'],
                $student['address']['houseNo'],
                $student['address']['postcode'],
                $student['address']['city'],
            ]);
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

        $courses = DB::table('student')
            ->join('course', 'student.course_id', '=', 'course.id')
            ->select('course.course_name', DB::raw('count(student.id) as total_student'))
            ->groupBy('student.course_id')
            ->get();

        $filename = "course.csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, [
            'Course',
            'Students',
        ]);

        foreach ($courses as $course) {
            fputcsv($handle, [
                $course['course_name'],
                $course['total_student']
            ]);
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'course.csv', $headers);

    }
}
