$(document).ready( function(){
    /**
     * Нажатие на ссылку рубрикатора
     */
    $('#news_menu a').click( function(){
        rubricId = $(this).parent().find('input[type=hidden]').val();

        $.getJSON('/news/ajax-get-news/?rubricId='+rubricId)
            .success( function( response ){
                if(response.error){
                    alert(response.error);
                } else {
                    $('#news_list').text('');
                    for (i = 0; i < response.data.length; ++i){
                        $('#news_list').append('<h3>'+response.data[i].title+'</h3>')
                        $('#news_list').append('<p>'+response.data[i].text+'</p>')
                    }
                }
            })
            .error( function( response ) { 
                alert('Ошибка! Не удалось подгрузить новости');
            });
        return false;
    });
});