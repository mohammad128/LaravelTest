
$(document).ready( function () {
    async function getAllTags() {
        const response = await axios.get('/Tag/all');
        console.log(response);
        let whitelist = [];
        if( response.status == 200 ) {
            for (let i=0; i<response.data.length; i++)
                whitelist[i] = response.data[i]['name']
        }
        var input1 = document.querySelector('input[name=tags]'),
        tagify1 = new Tagify(input1, {
            whitelist : whitelist,
            blacklist : ["fuck", "shit",'احمق']
        });

    }

    getAllTags();
})
