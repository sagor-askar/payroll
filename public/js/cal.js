$(document).ready(function () {
         
       $.ajaxSetup({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
          $('#calendar').fullCalendar({
            events: function(start, end, timezone, callback) {
               $.ajax({
                  url: '/admin',
                  dataType: 'json',
                   success: function(data) {
                   
                        if(data.leaves){
                            var events = [];
                        
                            for (var i=0; i<data.leaves.length; i++){
                                events.push({
                                    title: data.leaves[i]['employee']['first_name'],
                                    start: data.leaves[i]['start_date'].split("-").reverse().join("-"),
                                    end: data.leaves[i]['end_date'].split("-").reverse().join("-"),
                                });
                            }
        
                            //adding the callback
                            callback(events);
                        }
                         
                        
                    }
               });
           }
       });
        
  });
    

