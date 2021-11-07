

function _(element)
{
    return document.getElementById(element);
}



upload = false;
file_name = null;
file_id = makeid();

_('drag_drop').ondragover = function(event)
{
    this.style.borderColor = '#333';
    return false;

}

_('drag_drop').ondragleave = function(event)
{
    this.style.borderColor = '#ccc';
    return false;
}


_('drag_drop').ondrop = function(event)
{

    event.preventDefault();

    var form_data  = new FormData();

    var image_number = 1;

    var error = '';

    var drop_files = event.dataTransfer.files;


    // for(var count = 0; count < drop_files.length; count++)
    // {
        if (drop_files.length == 1) {
            
            if (drop_files[0].size > 10737418240 ) {
                error += '<div class="alert alert-danger"> Selected File must be less than 10GB.</div>';
            }
            else
            {
                form_data.append("images[]", drop_files[0]);
                file_name = drop_files[0].name;


            }
        }
        else
        {
            error += '<div class="alert alert-danger"> Drag Only One File At A Time.</div>';
        }

        // if(!['image/jpeg', 'image/png', 'video/mp4'].includes(drop_files[count].type))
        // {
        //     error += '<div class="alert alert-danger"><b>'+image_number+'</b> Selected File must be .jpg or .png Only.</div>';
        // }

        // image_number++;
  //}

    if(error != '')
    {
        _('uploaded_image').innerHTML = error;
        _('drag_drop').style.borderColor = '#ccc';
    }
    else
    {
        _('progress_bar').style.display = 'block';

        var ajax_request = new XMLHttpRequest();
        document.getElementById("card").hidden = true;

        ajax_request.open("post", "/static/php/upload.php?id="+ file_id);

        file_id_name = file_id + "." + file_name.split('.').pop();
        ajax_request.upload.addEventListener('progress', function(event){

            var percent_completed = Math.round((event.loaded / event.total) * 100);
if(percent_completed == 100){
    upload = true;
}
            _('progress_bar_process').style.width = percent_completed + '%';

            _('progress_bar_process').innerHTML = percent_completed + '% completed';

        });

        ajax_request.addEventListener('load', function(event){

        
            upload = true;
            if($submitonfinished == true){
                submit_new_media()
            }
            _('uploaded_image').innerHTML = '<div class="alert alert-success">Files Uploaded Successfully</div>';

            

            _('drag_drop').style.borderColor = '#ccc';


        });

        ajax_request.send(form_data);
    }
}


