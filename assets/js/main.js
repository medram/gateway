window.onload = function (){
	delateBtn();
	resendEmail();
	applyFilter();
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

function resendEmail()
{
	// ajax.php?a=sendEmail&cu=<?php echo $customer->id ?>&incoice=<?php echo $invoice->id
	let table = document.querySelector('table.resendEmail');
	if (table != null)
	{
		let customerID = table.getAttribute('data-customer');
		
		table.addEventListener('click', function (e){
			e.preventDefault();
			let invoiceID = e.target.getAttribute('data-invoice');
			let lastValue = e.target.value;

			if (e.target.nodeName == "BUTTON" && e.target.classList.contains('send'))
			{
				// send Ajax request to the server to resend email to customer.
				$.ajax({
					type: 'GET',
					url: 'ajax.php?a=resendEmail&cu='+customerID+'&invoice='+invoiceID,
					dataType: 'json',
					beforeSend: function (){
						lastValue = e.target.innerHTML;
						e.target.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Resending product to this customer...';
					},
					success: function (result, status, xhr){
						if (xhr.status == 200)
						{
							//result = JSON.parse(result);
							alert(result.message);
						}
						else
						{
							alert('Oops, Something went wrong\nError '+xhr.status+": "+xhr.statusText);
						}
					},
					error: function (xhr, status, statusText){
						alert('Oops, Something went wrong\nError '+xhr.status+": "+xhr.statusText);
					},
					complete: function (){
						e.target.innerHTML = lastValue;
					},
				});
			}
		});
	}
}

// filter statistic using time.
function applyFilter()
{
	let select = document.querySelector('select[name=filter-time]');
	let currentValue = window.location.search.slice(1).split('=')[1];

	select.value = currentValue || 'all';

	select.addEventListener('change', function (){
		currentValue = select.value;
		window.location = window.location.origin + window.location.pathname + "?time="+select.value;
	});
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