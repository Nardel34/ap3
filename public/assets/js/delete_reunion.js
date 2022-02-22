function deleteReunion(e) {

    if (e !== "") {
        $('.loadingBar').css('display', 'block');
        $.ajax({
            type: 'POST',
            url: '/log/type/professeur/del_reunion',
            data: 'reunion=' + e,

            success: (data) => {
                $('.loadingBar').css('display', 'none');
                $('#card' + e).remove();
            }
        })
    }
};