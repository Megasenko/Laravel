<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to the task</title>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link href='/css/view_students.css' rel='stylesheet' type='text/css'>
</head>

<body>

<form id="form" method="POST" class="validateform" action="/export">
    {{ csrf_field() }}

    <div class="header">
        <div>
            <img src="/images/logo_sm.jpg" alt="Logo" title="logo">
        </div>
        <div style='margin: 10px;  text-align: left'>
            <input type="button" id="SelectAll" value="Select All"/>
            <input type="button" id="Сlear" value="Сlear All"/>
            <button type="submit">Export</button>
        </div>
    </div>
    <div style='margin: 10px; text-align: center;'>
        <table class="student-table">
            <tr>
                <th></th>
                <th>Forename</th>
                <th>Surname</th>
                <th>Email</th>
                <th>University</th>
                <th>Course</th>
            </tr>

            @if(  count($students) > 0 )
                @foreach($students as $student)
                    <tr>
                        <td><input type="checkbox" id="checkbox" name="studentId[]" value="{{$student['id']}}"></td>
                        <td style=' text-align: left;'>{{$student['firstname']}}</td>
                        <td style=' text-align: left;'>{{$student['surname']}}</td>
                        <td style=' text-align: left;'>{{$student['email']}}</td>
                        <td style=' text-align: left;'>{{$student['course']['university']}}</td>
                        <td style=' text-align: left;'>{{$student['course']['course_name']}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
                </tr>
            @endif
        </table>
    </div>
</form>

</body>

<script src="/js/view_students.js"></script>

</html>

