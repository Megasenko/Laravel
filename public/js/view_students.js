
$('input#SelectAll').click(function () {
    $(':checkbox ').prop('checked', true);
})

$('input#Сlear').click(function () {
    $(':checkbox ').prop('checked', false);
})

$('button#exportCourse').click(function () {
    $("#form").attr("action", "exportCourse");
})