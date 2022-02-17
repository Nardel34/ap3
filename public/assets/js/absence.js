function absence(e) {

    if (e !== "") {
        $('.loadingBar').css('display', 'block');
        $.ajax({
            type: 'POST',
            url: '/log/type/professeur/absence',
            data: 'event=' + e,

            success: (data) => {
                $('.loadingBar').css('display', 'none');
                $('#card' + e).remove();
            }
        })
    }
};