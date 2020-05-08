function CheckForm(){

	var checked=false;
    var elements = document.getElementsByName("selectItem[]");
    
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			checked = true;
		}
    }
    
	if (!checked) {
		alert('Please check at least 1 checkbox!');
    }
    else{

        checked = confirm('Are you sure?');

    }
    return checked;
    
}

function CheckConfirm(){

	var checked=false;
    
    checked = confirm('Are you sure?');

    return checked;
    
}

function CheckOnly1(){

    var checked = false;
    var elements = document.getElementsByName("selectItem[]");
    var count = 0;
    for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {

            count++;
            
		}
    }

    if (count < 1) {

		alert('Please check 1 checkbox!');
    }
    else if(count > 1) {

        alert('Please check only 1 checkbox!');

    }
    else{

        checked = confirm('Are you sure?');

    }

    return checked;

}