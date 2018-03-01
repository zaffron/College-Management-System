$(document).ready(function(){
    $('.search-box').on("keyup input",function(){
        /*Get input value on change*/
        var inputVal = $(this).val();
        $.ajax({
            url: 'search/student',
            method: 'POST',
            data:{
                '_token': $('input[name=_token]').val(),
                'query': inputVal,
            },
            success: function(data){
                var result = new String();
                console.log(data);
                result = "<table class='table' id='studentTable'><thead class='thead-dark'><tr><th>#</th><th>Reg. No.</th><th>Student Name</th><th>Course</th><th>Operation</th></tr></thead><tbody>";
                bottom = "</tbody></table>";
                if(data === "" || data === NaN || data.length === 0){
                    result += "<tr class='text-center'><td colspan='5'>No Result Found</td></tr>";
                }else{

                    for(i=0;i<data.length;i++){
                        result += "<tr class='item" + data[i].id + "'><td>" + data[i].id + "</td><td>" + data[i].regno + "</td><td>"+ data[i].name + "</td><td>" + data[i].courseName +"</td><td><button class='show-modal btn btn-success btn-sm' data-regno='" + data[i].regno + "' data-id='" + data[i].id + "' data-name='" + data[i].name + "' data-course='" + data[i].course + "' data-email='" + data[i].email + "' data-contact='" + data[i].contact + "' data-dob='" + data[i].dob + "' data-gender='" + data[i].gender + "' data-proctor='" + data[i].proctor + "' ><span class=\'fa fa-eye\'></span></button> <button class='edit-modal btn btn-info btn-sm' data-id='" + data[i].id + "' data-name='" + data[i].name + "' data-regno='" + data[i].regno + "' data-course='" + data[i].course + "' data-email='" + data[i].email + "' data-contact='" + data[i].contact + "' data-dob='" + data[i].dob + "' data-gender='" + data[i].gender + "' data-proctor='" + data[i].proctor + "' ><span class=\'fa fa-edit\'></span></button> <button class=\'delete-modal btn btn-danger btn-sm\' data-id='" + data[i].id + "' data-name='" + data[i].name + "' data-course='" + data.department + "' ><span class=\'fa fa-trash\'></span></button></td></tr>";
                    }
                    result += bottom;

                }

                $('#studentTable').html(result);
            }
        });
    });
});