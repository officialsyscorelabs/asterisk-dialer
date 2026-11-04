const url = 'process.php'
const form = document.querySelector('form')
document.getElementById("file_upload_status").innerHTML = '';
document.getElementById("pbar").style.width = '0%';
document.getElementById("pbar").innerHTML = '0%';


form.addEventListener('submit', (e) => {
  e.preventDefault()

  const files = document.querySelector('[type=file]').files
  const formData = new FormData()

  for (let i = 0; i < files.length; i++) {
    let file = files[i]

    formData.append('files[]', file)
    document.getElementById("file_upload_status").innerHTML = 'Upload in Progress';
    document.getElementById("pbar").style.width = '25%';
    document.getElementById("pbar").innerHTML = '25%';


  }

  fetch(url, {
    method: 'POST',
    body: formData,
  }).then((response) => {
    console.log(response)
    if(response.statusText == 'OK'){
    	document.getElementById("file_upload_status").innerHTML = 'File upload complete';
	document.getElementById("pbar").style.width = '100%';
	document.getElementById("pbar").innerHTML = 'complete';

	}
    else{
    	document.getElementById("file_upload_status").innerHTML = 'File upload error, Check File';
	document.getElementById("pbar").style.width = '10%';
        document.getElementById("pbar").innerHTML = 'error';
	}

  })
})