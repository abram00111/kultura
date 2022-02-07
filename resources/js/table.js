let nubmer_table = 0;
//Настройки плагина
const settings = Object.fromEntries([
    ['search', true], //поиск
    ['sorting', true], //сортировка
]);


//Ищем таблицы с классом abr-table
$('.abr-table').each(function(){
    nubmer_table++;
    //добавляем класс к таблице (это необходимо, если таблиц будет несколько, то именно этот по этому классу будем обращаться)
    $(this).addClass('table'+nubmer_table);

    //Если в настройках включена функция поиска, и таблица НЕ содержит класс "abr-off-search"
    if(settings.search ===true && !$(this).hasClass('abr-off-search')){
        //Добавляем поле фильтра по таблице
        $(this).before('<div class="abr-search"><label for="search'+nubmer_table+'">Поиск </label> <input type="search" id="table'+nubmer_table+'"></div>')
    }
})

// __________СОРТИРОВКА ТАБЛИЦЫ start____________
if(settings.sorting ===true) {
    $('.abr-table thead tr *').click(function () {
        //Если в таблице нет класса отключающего сортировку
        if($(this).parents('table').hasClass('abr-off-sorting'))return;

        $(this).parents('table').find('.sort').remove();
        let table = $(this).parents('table').eq(0)
        let rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
        this.asc = !this.asc

        if (!this.asc) {
            rows = rows.reverse();
            $(this).append('<i style="" class="sort">↓</i>')
        } else {
            $(this).append('<i style="" class="sort">↑</i>')
        }
        for (let i = 0; i < rows.length; i++) {
            table.append(rows[i])
        }
    })

    function comparer(index) {
        return function (a, b) {
            let valA = getCellValue(a, index), valB = getCellValue(b, index)
            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
        }
    }

    function getCellValue(row, index) {
        return $(row).children('td').eq(index).text()
    }
}
// __________СОРТИРОВКА ТАБЛИЦЫ end____________



// __________ПОИСК ПО ТАБЛИЦЕ start____________
$("input[type='search']").on('input',function () {
    let value = this.value.toLowerCase().trim();
    let count_td = 0;
    let table = $(this).attr('id');

    //Получим ID input search, Который совпадает с классом фильтруемой таблицы и переберем ее построчно и по ячейкам
    $('.'+table+" tr").each(function (index) {
        if (!index) return;
        $(this).find("td").each(function () {
            let id = $(this).text().toLowerCase().trim();
            let not_found = (id.indexOf(value) == -1);
            $(this).closest('tr').toggle(!not_found);
            //если в ячейке есть совпадение до добавим в переменную count_td + 1
            if(not_found == false){count_td++}
            return not_found;
        });
    });

    //Если нет ни одной строки удовлетворяющей условию то выведем информацию
    if(count_td == 0){
        $("."+table+" thead").append(
            '<tr>' +
                '<td class="no-tr" colspan="'+$('.'+table).find("tr:last td").length+'">Совпадающих записей не найдено</td>' +
            '</tr>'
        )
    }else{
        $('.'+table).find('.no-tr').remove()
    }
});
// __________ПОИСК ПО ТАБЛИЦЕ end____________



//__________ПАГИНАЦИЯ start____________
function getPagination(table) {
    var lastPage = 1;

    $('#maxRows')
        .on('change', function(evt) {
            //$('.paginationprev').html('');						// reset pagination

            lastPage = 1;
            $('.pagination')
                .find('li')
                .slice(1, -1)
                .remove();
            var trnum = 0; // reset tr counter
            var maxRows = parseInt($(this).val()); // get Max Rows from select option

            if (maxRows == 5000) {
                $('.pagination').hide();
            } else {
                $('.pagination').show();
            }

            var totalRows = $(table + ' tbody tr').length; // numbers of rows
            $(table + ' tr:gt(0)').each(function() {
                // each TR in  table and not the header
                trnum++; // Start Counter
                if (trnum > maxRows) {
                    // if tr number gt maxRows

                    $(this).hide(); // fade it out
                }
                if (trnum <= maxRows) {
                    $(this).show();
                } // else fade in Important in case if it ..
            }); //  was fade out to fade it in
            if (totalRows > maxRows) {
                // if tr total rows gt max rows option
                var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
                //	numbers of pages
                for (var i = 1; i <= pagenum; ) {
                    // for each page append pagination li
                    $('.pagination #prev')
                        .before(
                            '<li data-page="' +
                            i +
                            '">\
                                              <span>' +
                            i++ +
                            '<span class="sr-only">(current)</span></span>\
                                            </li>'
                        )
                        .show();
                } // end for i
            } // end if row count > max rows
            $('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
            $('.pagination li').on('click', function(evt) {
                // on click each page
                evt.stopImmediatePropagation();
                evt.preventDefault();
                var pageNum = $(this).attr('data-page'); // get it's number

                var maxRows = parseInt($('#maxRows').val()); // get Max Rows from select option

                if (pageNum == 'prev') {
                    if (lastPage == 1) {
                        return;
                    }
                    pageNum = --lastPage;
                }
                if (pageNum == 'next') {
                    if (lastPage == $('.pagination li').length - 2) {
                        return;
                    }
                    pageNum = ++lastPage;
                }

                lastPage = pageNum;
                var trIndex = 0; // reset tr counter
                $('.pagination li').removeClass('active'); // remove active class from all li
                $('.pagination [data-page="' + lastPage + '"]').addClass('active'); // add active class to the clicked
                // $(this).addClass('active');					// add active class to the clicked
                limitPagging();
                $(table + ' tr:gt(0)').each(function() {
                    // each tr in table not the header
                    trIndex++; // tr index counter
                    // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
                    if (
                        trIndex > maxRows * pageNum ||
                        trIndex <= maxRows * pageNum - maxRows
                    ) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    } //else fade in
                }); // end of for each tr in table
            }); // end of on click pagination list
            limitPagging();
        })
        .val(5)
        .change();

    // end of on select change

    // END OF PAGINATION
}

function limitPagging(){
    // alert($('.pagination li').length)

    if($('.pagination li').length > 7 ){
        if( $('.pagination li.active').attr('data-page') <= 3 ){
            $('.pagination li:gt(5)').hide();
            $('.pagination li:lt(5)').show();
            $('.pagination [data-page="next"]').show();
        }if ($('.pagination li.active').attr('data-page') > 3){
            $('.pagination li:gt(0)').hide();
            $('.pagination [data-page="next"]').show();
            for( let i = ( parseInt($('.pagination li.active').attr('data-page'))  -2 )  ; i <= ( parseInt($('.pagination li.active').attr('data-page'))  + 2 ) ; i++ ){
                $('.pagination [data-page="'+i+'"]').show();

            }

        }
    }
}
//__________ПАГИНАЦИЯ end____________

