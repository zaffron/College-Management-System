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
                result = "<table class='table' id='studentTable'><thead class='thead-dark'><tr><th>Reg. No.</th><th>Full Name</th><th>Email</th><th>Course</th><th>Full details</th></tr></thead><tbody>";
                bottom = "</tbody></table>";
                if(data === "" || data === NaN || data.length === 0){
                    result += "<tr class='text-center'><td colspan='5'>No Result Found</td></tr>";
                }else{

                    for(i=0;i<data.length;i++){
                        result += "<tr class='item" + data[i].id + "'><td>" + data[i].regno + "</td><td>"+ data[i].name + "</td><td>" + data[i].email + "</td><td>" + data[i].courseName +"</td><td><button class='btn btn-sm btn-info show-modal' data-toggle='modal' data-target='#showModal' data-id='" + data[i].id + "' data-name='" + data[i].name + "' data-regno='" + data[i].regno + "' data-course='" + data[i].course + "' data-email='" + data[i].email + "' data-contact='" + data[i].contact + "' data-dob='" + data[i].dob + "' data-gender='" + data[i].gender + "' data-address='" + data[i].address + "' data-p_email='" + data[i].p_email+ "' data-p_contact='" + data[i].p_contact+ "' ><span class=\'fa fa-eye\'></span> Full Details</button></tr>";
                    }
                    result += bottom;

                }

                $('#studentTable').html(result);
            }
        });
    });
});

$(document).ready(function(){
    $('.search-box-graduated').on("keyup input",function(){
        /*Get input value on change*/
        var inputVal = $(this).val();
        $.ajax({
            url: '/search/graduated',
            method: 'POST',
            data:{
                '_token': $('input[name=_token]').val(),
                'query': inputVal,
            },
            success: function(data){
                var result = new String();
                console.log(data);
                result = "<table class='table' id='studentTable'><thead class='thead-dark'><tr><th>Reg. No.</th><th>Full Name</th><th>Email</th><th>Course</th><th>Full details</th></tr></thead><tbody>";
                bottom = "</tbody></table>";
                if(data === "" || data === NaN || data.length === 0){
                    result += "<tr class='text-center'><td colspan='5'>No Result Found</td></tr>";
                }else{

                    for(i=0;i<data.length;i++){
                        result += "<tr class='item" + data[i].id + "'><td>" + data[i].regno + "</td><td>"+ data[i].name + "</td><td>" + data[i].email + "</td><td>" + data[i].courseName +"</td><td><button class='btn btn-sm btn-info show-modal' data-toggle='modal' data-target='#showModal' data-id='" + data[i].id + "' data-name='" + data[i].name + "' data-regno='" + data[i].regno + "' data-course='" + data[i].course + "' data-email='" + data[i].email + "' data-contact='" + data[i].contact + "' data-dob='" + data[i].dob + "' data-gender='" + data[i].gender + "' data-address='" + data[i].address + "' data-p_email='" + data[i].p_email+ "' data-p_contact='" + data[i].p_contact+ "' ><span class=\'fa fa-eye\'></span> Full Details</button></tr>";
                    }
                    result += bottom;

                }

                $('#studentTable').html(result);
            }
        });
    });
});