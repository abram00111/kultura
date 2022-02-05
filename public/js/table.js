/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/table.js ***!
  \*******************************/
var nubmer_table = 0; //Настройки плагина

var settings = Object.fromEntries([['search', true], //поиск
['sorting', true] //сортировка
]); //Ищем таблицы с классом abr-table

$('.abr-table').each(function () {
  nubmer_table++; //добавляем класс к таблице (это необходимо, если таблиц будет несколько, то именно этот по этому классу будем обращаться)

  $(this).addClass('table' + nubmer_table); //Если в настройках включена функция поиска

  if (settings.search === true) {
    //Добавляем поле фильтра по таблице
    $(this).before('<div class="abr-search"><label for="search' + nubmer_table + '">Поиск </label> <input type="text" id="search' + nubmer_table + '"></div>');
  }
}); // __________СОРТИРОВКА ТАБЛИЦЫ start____________

$('.abr-table thead tr *').click(function () {
  $(this).parent().children().index($(this)); //По какому столбцу был клик

  var table = $(this).parents('table').eq(0);
  var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
  this.asc = !this.asc;

  if (!this.asc) {
    rows = rows.reverse();
  }

  for (var i = 0; i < rows.length; i++) {
    table.append(rows[i]);
  }
});

function comparer(index) {
  return function (a, b) {
    var valA = getCellValue(a, index),
        valB = getCellValue(b, index);
    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
  };
}

function getCellValue(row, index) {
  return $(row).children('td').eq(index).text();
} // __________СОРТИРОВКА ТАБЛИЦЫ end____________
/******/ })()
;