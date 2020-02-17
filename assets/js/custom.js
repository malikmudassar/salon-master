$(document).ready(function() {
    getAppointments();
    //Customer Search Button Cancel Post Script....
    $("#customersearchform").submit(function(event) {
        // cancels the form submission
        event.preventDefault();
        submitForm();
    });

    $("#namesearchform").submit(function(event) {
        // cancels the form submission
        event.preventDefault();
        submitForm();
    });

    $("#cellsearchform").submit(function(event) {
        // cancels the form submission
        event.preventDefault();
        submitForm();
    });

    $("#emailsearchform").submit(function(event) {
        // cancels the form submission
        event.preventDefault();
        submitForm();
    });

    ///Customer Search Script....
    $("#btnsearchcustomer").on('click', function() {

        $.ajax({
            type: 'POST',
            url: 'customer_controller/search',
            data: $("#customersearchform").serialize(),
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {

                fillcustomerform(data);

            }
        });

    });

    $("#btnsearchname").on('click', function() {

        $.ajax({
            type: 'POST',
            url: 'customer_controller/searchname',
            data: $("#namesearchform").serialize(),
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {

                fillcustomerform(data);

            }
        });

    });

    $("#btnsearchcell").on('click', function() {

        $.ajax({
            type: 'POST',
            url: 'customer_controller/searchcell',
            data: $("#cellsearchform").serialize(),
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {

                fillcustomerform(data);

            }
        });

    });
    $("#btnsearchemail").on('click', function() {

        $.ajax({
            type: 'POST',
            url: 'customer_controller/searchemail',
            data: $("#emailsearchform").serialize(),
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                fillcustomerform(data);
            }
        });

    });

   
    
    function fillcustomerform(data) {
        var mhtml='';
        if (data.length > 1) {
            for (x = 0; x < data.length; x++) {
                mhtml+='<a href="javascript:void(0)" onclick="getbyid('+ data[x]['id_customers'] +');">';
                mhtml+='<div class="inbox-item">';
                mhtml+='<div class="inbox-item-img"><img src="http://localhost/projects/salons/assets/images/users/' + data[x]['customer_image'] + '" class="img-circle" alt=""></div>';
                mhtml+='<p class="inbox-item-author">'+ data[x]['customer_name'] +'</p>';
                mhtml+='<p class="inbox-item-text">'+ data[x]['customer_cell']  +'</p>';
                mhtml+='<p class="inbox-item-date">'+ data[x]['customer_email']  +'</p>';
                mhtml+='</div>';
                mhtml+='</a>';
            }
            $("#customer_list").html(mhtml);
            $("#multiplesearch").slideDown()
        } else {

            $("#txt-customer-name").val(data[0]['customer_name']);
            $("#txt-customer-cell").val(data[0]['customer_cell']);
            $("#txt-customer-email").val(data[0]['customer_email']);
            $("#txt-customer-address").text(data[0]['customer_address']);
            $("#img-customer").attr('src', 'http://localhost/projects/salons/assets/images/users/' + data[0]['customer_image']);
        }
    }


    function getAppointments() {

        $.ajax({
            type: 'POST',
            url: 'appointment_controller/appointments',
            data: '',
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
               
                var mhtml = '';
                if (data.length == 0) {
                    mhtml = '<li class="list-group-item"> <a href="#" class="user-list-item"><div class="icon bg-warning"><i class="zmdi zmdi-account"></i></div><div class="user-desc"><span class="name">No Appointments</span><span class="desc">for the day</span><span class="time">0:00</span></div></a></li>';
                } else {
                    for (x = 0; x < data.length; x++) {

                        mhtml += '<li class="list-group-item"><a href="#" class="user-list-item">';
                        mhtml += '<div class="icon bg-pink"><i class="zmdi zmdi-account"></i></div>';
                        mhtml += '</div><div class="user-desc"><span class="name">' + data[x]['customer_name'] + '</span>';
                        mhtml += '<span class="desc">' + data[x]['appointment_remarks'] + '</span>';
                        mhtml += '<span class="time">' + data[x]['appointment_date_time'] + '</span></div></a></li>';
                       
                    }
                }
                $("#mAppointments").html(mhtml);
            }
        });
    }
});
