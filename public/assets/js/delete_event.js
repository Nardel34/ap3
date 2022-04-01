function deleteEvent(e) {

    if (e !== "") {
        $('.loadingBar').css('display', 'block');
        $.ajax({
            type: 'GET',
            url: '/log/type/professeur/del_event',
            data: 'event=' + e,

            success: (data) => {
                $('.loadingBar').css('display', 'none');
                $('#card' + e).remove();
            }
        })
    }
};