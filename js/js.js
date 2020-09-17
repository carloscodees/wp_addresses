
const elementA = document.getElementById('addres-2');
const check = document.getElementById('check_direction');


if (check !== null) {

    const showAddress = () => {

        if (check.checked) {
            elementA.style.display = 'none';
            jQuery.ajax({
    			url: ditemcode_vars.ajaxurl,
    			type: 'post',
    			data: {
    				action: 'temcode_ajax_submit',
    			},
    			beforeSend: function(){
                jQuery('address').css('opacity','.5');
                jQuery('#addres-2 address').css('display', 'none');
    			// jQuery('#addres-2 address').addClass('loading');
    		},

    			success:function(data){
                    console.log(data)
                    jQuery('address').css('opacity','1');
                    check.checked = true
                    jQuery('#addres-2 address').html(data);
                    jQuery('#addres-2 address').css('display', 'block');
    			}
    		})
        } else {
            elementA.style.display = 'block';
            check.checked = false;
            //      console.log('none');
        }

    }
    showAddress();
    check.addEventListener("click", showAddress);
}
