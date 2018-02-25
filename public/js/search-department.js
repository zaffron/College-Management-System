$(document).ready(function(){
    $('.search-box').on("keyup input",function(){
        /*Get input value on change*/
        var inputVal = $(this).val();
        $.ajax({
            url: 'search/department',
            method: 'POST',
            data:{
                '_token': $('input[name=_token]').val(),
                'query': inputVal,
            },
            success: function(data){
                var result = new String();
                result = "<table class='table' id='deptTable'><thead class='thead-dark'><tr><th>#</th><th>Department Name</th><th>Description</th><th>Teachers</th><th>Students</th><th>Status</th><th>Operation</th></tr></thead><tbody>";
                bottom = "</tbody></table>";
                if(data === "" || data === NaN || data.length === 0){
                    console.log('entered');
                    result += "<tr class='text-center'><td colspan='4'>No Result Found</td></tr>";
                }else{

                    for(i=0;i<data.length;i++){
                        result += "<tr class='item" + data[i].id + "'><td>" + data[i].id + "</td><td>" + data[i].name + "</td><td>"+ data[i].description + "</td><td>" + data[i].teachers_count + "</td><td>" + data[i].students_count + "</td><td>";
                        (data[i].active)? result+='<span class="text-success">Active</span>':result+='<span class="text-danger">Inactive</span>';
                        result += "</td><td><button class='show-modal btn btn-success btn-sm' data-id='" + data[i].id + "' data-name='" + data[i].name + "' data-description='" + data[i].description + "' ><span class='fa fa-eye'></span></button> <button class='edit-modal btn btn-info btn-sm' data-id='" + data[i].id + "' data-name='" + data[i].name + "' data-description='" + data[i].description + "' ><span class=\'fa fa-edit\'></span></button> ";
                        (data[i].active)? result+="<button class='delete-modal btn btn-danger btn-sm' data-id='" + data[i].id + "' data-name='" + data[i].name + "' ><span class='fa fa-trash'></span></button></td></tr>" : result+="<button class='active-modal btn btn-warning btn-sm' data-id='" + data[i].id + "' data-name='" + data[i].name + "' ><span class='fa fa-check'></span></button></td></tr>";
                    }
                    console.log(result);
                    result += bottom;

                }

                $('#deptTable').html(result);
            }
        });
    });
});