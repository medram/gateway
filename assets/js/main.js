window.onload = function (){
	delateBtn();
	resendEmail();
	applyFilter();
	editSettings();
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

	if (select !== null)
	{	
		select.value = currentValue || 'all';

		select.addEventListener('change', function (){
			currentValue = select.value;
			window.location = window.location.origin + window.location.pathname + "?time="+select.value;
		});
	}
}

function editSettings()
{
	let modalBody = $(".modal-body");
	let content = $(".modal-body > content");
	let loading = $(".modal-body #loading");
	let title = $(".modal #settingName");
	let form = $(".modal-body form#settingForm");
	let message = $(".modal #modalMsg");

	$(".settings-table").on('click', function (e){
		if (e.target.tagName === 'BUTTON')
		{
			let id = e.target.getAttribute('id');

			$.ajax({
				url: './ajax.php?a=editSetting&r='+Math.random(),
				type: 'POST',
				data: 'id=' + id,
				beforeSend: function (xhr){
					loading.show();
					content.hide();
				},
				success: function (result, status, xhr){
					//console.log(result);
					loading.hide();
					content.show();
					if(!result.error && result.data)
					{
						title.text(result.data.name);
						form.append("<textarea rows='5' name='setting-name' id='settingValue' class='form-control' >" + result.data.value.toString() + "</textarea>");
					}
				},
				error: function (xhr, status, error){
					alert(status + ': ' + error);
				},
			});
		}
	});

	$('#editSetting').on('hidden.bs.modal', function (e) {
		title.text('');
		form.text('');
		message.text('');
	});

	$('#saveSetting').on('click', function(){
		let $this = $(this);
		//console.log(form.find("textarea").val(), title.text());
		
		$.ajax({
			url: './ajax.php?a=saveSetting&r='+Math.random(),
			type: 'POST',
			data: 'id=' + title.text() + '&value=' + form.find("textarea").val(),
			beforeSend: function (xhr){
				loading.show();
				$this.text("Saving...");
			},
			success: function (result, status, xhr){
				console.log(result);
				loading.hide();
				$this.text("Save changes");
				
				if(!result.error && result.saved)
				{
					message.html("<span class='text-success'>Saved successfully.</span>");
				}
				else
				{
					message.html("<span class='text-danger'>Something went wrong!.</span>");
				}
			},
			error: function (xhr, status, error){
				alert(status + ': ' + error);
			},
		});
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