$('.totalController').on('change click load',function(){
    var subject = $('#totalSubject').val();
    var section = $('#totalSection').val();
    var semester = $('#totalSemester').val();
    var batch = $('#totalBatch').val();

    $.ajax({
        type: 'POST',
        url:  '/report/getTotalData',
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
        	'subject' : subject,
        	'section' : section,
        	'semester' : semester,
        	'batch' : batch,
        },
        success: function(data) {

            if ((data.errors)) {
                setTimeout(function () {
                    toastr.error('No data found!', 'Error Alert', {timeOut: 5000});
                }, 500);

            } else {
                console.log(data);
                toastr.success('Successfully fetched data!', 'Success Alert', {timeOut: 5000});
                var elements = '<table class="table table-bordered"><tr><th>Regno</th><th>Name</th><th>Attendance</th><th>%</th><th>Operation</th></tr>';
                var last_elements = '</table>';
                var property;
                var percentage;
                for(i=0;i<data.length;i++){
                    percentage = Math.round(((data[i].attended/data[i].total_class)*100));
                    if(percentage<75){
                        console.log('hello');
                        property = 'bg-danger';
                    }else{
                        property = '';
                    }
                	elements += '<tr><td>'+ data[i].regno +'</td><td>'+ data[i].name +'</td><td>'+ data[i].attended +'</td><td class="'+ property +'">'  + percentage +'%</td><td><button class="send-report btn btn-danger btn-md" data-percentage="' + percentage +'" data-regno="' + data[i].regno + '">Report Parents</td></tr>';
                }
                elements += last_elements;
                document.getElementById('attendanceTableHolder').innerHTML = elements;
                
                $('button.send-report').on('click',function(){
                var regno = $(this).data("regno");
                var percentage = $(this).data("percentage");
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: '/report/reportParent',
                        headers:{
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'regno': regno,
                            'percentage': percentage,
                        },
                        success: function(data) {

                            if ((data.errors)) {
                                setTimeout(function () {
                                    toastr.error('No data found!', 'Error Alert', {timeOut: 5000});
                                }, 500);

                            } else {
                                toastr.success('Successfully sent report!', 'Success Alert', {timeOut: 5000});
                            }
                        },

                    });
                });

            }
        },
    });
});


$('.changer').on('change blur',function(){
    var subject = $('#singleSubject').val();
    var section = $('#singleSection').val();
    var semester = $('#singleSemester').val();
    var batch = $('#singleBatch').val();
    var regno = $('#singleRegno').val();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url:  '/report/getSingleData',
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'subject' : subject,
            'section' : section,
            'semester' : semester,
            'batch' : batch,
            'regno' : regno,
        },
        success: function(data) {

            if ((data.errors)) {
                setTimeout(function () {
                    toastr.error('No data found!', 'Error Alert', {timeOut: 5000});
                }, 500);

            } else {
                toastr.success('Successfully fetched data!', 'Success Alert', {timeOut: 5000});
                console.log((JSON.stringify(data)));
                var options = {
                    events_source: data,
                    view: 'month',
                    tmpl_path:tmpls_path,
                    tmpl_cache: false,
                    onAfterViewLoad: function(view) {
                        $('.page-header h3 ').text(this.getTitle());
                        $('.btn-group button').removeClass('active');
                        $('button[data-calendar-view="' + view + '"]').addClass('active');
                    },
                };
                var calendar = $('#calendar').calendar(options);
                $('.btn-group button[data-calendar-nav]').each(function() {
                    var $this = $(this);
                    $this.click(function() {
                        calendar.navigate($this.data('calendar-nav'));
                    });
                });
            }
        },
    });
});
