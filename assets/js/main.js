window.onload = function (){
	delateBtn();
};

function delateBtn()
{
	let btns = document.getElementsByClassName('action-delete');
	for(let i = 0; i < btns.length; ++i)
	{
	    btns[i].addEventListener('click', function (e){
	        e.preventDefault();
	        if (confirm("Are you sure you want to delete this ?"))
	        {
	            console.log('yes');
	            window.location = this.href;
	        }
	    });
	}
}

/*function perPage()
{
	let select = document.querySelector('select#perPage');
	let value = 0;
	let url = window.location;
	select.addEventListener('change', function (){
		value = parseInt(select.value);
		if (url.toString().endsWith('php'))
			url = url + '?perPage=' + value;
		else
			url = url + '&perPage=' + value;
		window.location.href = url;
	});
}*/