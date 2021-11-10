async function getTags() {
    try {
        const response = await axios.post('api/tag/test');
        console.log(response);
    } catch (error) {
        console.error(error);
    }
}

async function deleteTag(tagId){
    try {
        $("#tagBtn_"+tagId).attr('disabled', true);
        const response = await axios.delete('/Tag/'+tagId);
        if( response.status == 200 ) {
            $("#tagBtn_"+tagId).remove();
        }
        console.log(response);
    }catch (e) {
        console.log(e);
    }
}

async function addTag( ) {
    try {
        if($("#addTag").val() == '') return ;
        $(this).attr('disabled', true);
        const response = await axios.post('/Tag', {
            'name': $("#addTag").val()
        });

        if(response.status == 209) {
            $("#tagBtn_"+response.data['id']).addClass('btn-danger').removeClass('btn-primary');
            setTimeout(function(){
                $("#tagBtn_"+response.data['id']).addClass('btn-primary').removeClass('btn-danger');
            }, 3000);

        }
        else if( response.status == 201 ) {
            let data = response.data;
            let tag_name = data['name'];
            let tag_id = data['id'];
            let _html = `
                <button type="button" class="btn btn-primary mt-1 tagBtn" id="tagBtn_${tag_id}">
                    ${tag_name} <span class="badge badge-light">0</span>
                    <span class="badge badge-light delete_tag" id="delete_tag${tag_id}" data-tagId="${tag_id}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                        </svg>
                    </span>
                </button>
            `;
            $("#tag-container").append( _html );
            $("#delete_tag"+tag_id).click(function () {
                deleteTag( $(this).attr('data-tagId'));
            })
            console.log(data);
        }
    }catch (error) {
        console.log(error);
    }
    $("#addTag").removeAttr('disabled');
    $("#addTag").val('');
}


async function updateTag( tagId, newVal ) {

    const response = await axios.put('/Tag/'+tagId, {
        'name': newVal
    });
    console.log(response);
    if( response.status == 200 ) {
        if( response.data == "OK") {
        }
        else if (response.data == "Not Found") {
            $("#tagBtn_"+tagId+ " .tag_title" ).text( $("#tagBtn_"+tagId+ " .tag_title" ).attr("old2"));
        }
        $("#tagBtn_"+tagId ).addClass('btn-primary').removeClass('btn-warning');
        $("#tagBtn_"+tagId+ " .tag_title" ).removeAttr("old").removeAttr("old2");
    }
}

$(document).ready(function () {
    $("#addTag").keyup(function (e) {
        if( $(this).is(":focus") && (e.keyCode == 13) ) {
            addTag();
        }
    })

    $(".delete_tag").click(function () {
        deleteTag( $(this).attr('data-tagId'));
    })

    $("#searchTag").keyup(function (){
        let search = $(this).val().trim();
        if(search == '') {
            $(".tagBtn").removeClass('d-none');
        }
        else {
            $(".tagBtn").addClass('d-none');
            let tmp = $(".tagBtn .tag_title");
            for (let i=0; i<tmp.length; i++) {
                if( $(tmp[i]).text().toLowerCase().includes( search.toLowerCase() ) )
                    $(tmp[i]).closest('.tagBtn').removeClass('d-none');
            }
        }
    });

    $('.tag_title').bind('click', function() {
        if(! $("#tagBtn_"+$(this).attr('data-tagId') ).hasClass('btn-warning') ) {
            $(this).attr("old", $(this).text());
            $(this).attr('contentEditable', true);
        }
    }).blur( function() {
        $(this).text($(this).attr("old"));
        $(this).attr('contentEditable', false);
    });
    // $('.tag_title').keyup(function (e) {
    //     if( $(this).is(":focus") && (e.keyCode == 13) ) {
    //         alert('save');
    //     }
    // });
    $('.tag_title').keydown(function (e) {
        if( $(this).is(":focus") && (e.keyCode == 13) ) {
            $(this).attr('old2', $(this).attr("old") );
            $(this).attr('old', $(this).text() );
            updateTag( $(this).attr('data-tagId'), $(this).text() );
            $("#tagBtn_"+$(this).attr('data-tagId') ).addClass('btn-warning').removeClass('btn-primary');
            $(this).attr('contentEditable', false);
            return false;
        }
    });
});

