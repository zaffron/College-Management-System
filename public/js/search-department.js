$(document).ready(function(){
    $('.search-box').on("keyup input",function(){
        /*Get input value on change*/
        var inputVal = $(this).val();
        $.ajax({
            url: 'search',
            method: 'POST',
            data:{
                '_token': $('input[name=_token]').val(),
                'query': inputVal,
            },
            success: function(data){
                var result = new String();
                result = "<table class='table' id='deptTable'><thead class='thead-dark'><tr><th>#</th><th>Department Name</th><th>Description</th><th>Teacher\'s Count</th><th>Operation</th></tr></thead><tbody>";
                bottom = "</tbody></table>";
                if(data === "" || data === NaN || data.length === 0){
                    console.log('entered');
                    result += "<tr class='text-center'><td colspan='4'>No Result Found</td></tr>";
                }else{

                    for(i=0;i<data.length;i++){
                        result += "<tr class='item" + data[i].id + "'><td>" + data[i].id + "</td><td>" + data[i].name + "</td><td>"+ data[i].description + "</td><td>" + data[i].teachers_count + "</td><td><button class='edit-modal btn btn-info btn-sm' data-id='" + data[i].id + "' data-name='" + data[i].name + "' data-description='" + data[i].description + "' ><span class=\'fa fa-edit\'></span></button> <button class=\'delete-modal btn btn-danger btn-sm\' data-id=\'" + data[i].id + "\' data-name=\'" + data[i].name + "\' ><span class=\'fa fa-trash\'></span></button></td></tr>";
                    }
                    result += bottom;

                }

                $('#deptTable').html(result);
            }
        });
    });
});