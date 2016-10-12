/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */


function getSmsCountByLenght(lenght) {
	if (lenght == 0) {
		return 0;
	} 
	if (lenght <=70) {
		return 1;
	}
	if (lenght <=134) {
		return 2;
	}
	if (lenght <=201) {
		return 3;
	}
	if (lenght <=255) {
		return 4;
	}
	return 0;
}

function confirmDelete() {
    if (confirm('Are you sure you want to delete this send ?')) {
        return true;
    } else {
        return false;
    }
}

$(document).ready(function (){
    
    if ($('#datetimepicker').length) {
        minTime = new Date();
        minTime.setHours(minTime.getHours()+1);
        minTime.setMinutes(minTime.getMinutes()+5);
        jQuery('#datetimepicker').datetimepicker({
            format:'Y-m-d H:i',
            step: 5,
            minDate:'-1970/01/01',
            defaultTime: minTime.getTime()
        });
    }
    
    if ($('.numberCheck').length) {
        $(".numberCheck").change(function () {
            var result;
            var checkbox = $(this);
            var Data = { num: $(this).attr('id'), status: checkbox.is(':checked')};
            $.ajax({
    		type: "POST",
                dataType: "json",
                async: true,
		url: "/service/phones/change",
		data: Data,
		success: function(data, status) {
                    if (data['error'].valueOf() == 0) {
                        checkbox.prop("checked", data['status'].valueOf());
                    } else {
                        checkbox.prop("checked", data['status'].valueOf());
                        alert(data['errorValue'].valueOf());
                    }
                }
            });
            return false;
        });
    }
    
    if ($('.baseSelect').length) {
        if ($(".baseSelect").val()) {
            $(".newBase").css("display", "none");
        }

        $('.baseSelect').change(function () {
            if ($(this).val()) {
                $(".newBase").slideUp(300);
            } else {
                $(".newBase").slideDown(300);
            }
        });
    }
    
    if ($('.msgarea').length) {
        $('.msgarea').keyup(function () {
            $('.symbols').html($(this).val().length);
            $('.smss').html(getSmsCountByLenght($(this).val().length));
        });
    }
    
    $('.symbols').html($('.msgarea').val().length);
    $('.smss').html(getSmsCountByLenght($('.msgarea').val().length));
});

function togglemMenu() {
    if ($(".mob-nav").is(":hidden")) {
	$(".mob-nav").slideDown(300);
    } else {
	$(".mob-nav").slideUp(300);
    }
}
