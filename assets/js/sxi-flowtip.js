
$(function() {
initializeToolTips();
})
function initializeToolTips() {
$('input[type=text],input[type=password], select').each(function(e) { 
if($(this).nextAll('span.sidetip').text() != '') {
var offset = 20;
if($(this).hasClass("datepicker")){
offset=90; 
$(this).tooltip({
tip: 'span.sidetip',
effect: 'slide',
bounce: 'true',
direction: 'right',
predelay: 0,
delay: 0,
slideOffset: offset,
opacity: 0.9,
slideInSpeed: 400,
slideOutSpeed: 200,
position: 'center right'
});
}else{
var str = $(this).nextAll('span.sidetip').text();
$(this).attr('title', str);
$(this).tooltip({
cancelDefault: true,
effect: 'slide',
bounce: 'true',
direction: 'right',
predelay: 0,
delay: 0,
slideOffset: offset,
slideInSpeed: 400,
slideOutSpeed: 200,
position: 'center right',
tipClass: 'sidetip'
});
}
}});
}
function initializeToolTips2() {
$('input[type=text],input[type=password], select').each(function(e) { 
if($(this).nextAll('span.sidetip2').text() != '') {
var offset = 20;
if($(this).hasClass("datepicker")){
offset=90; 
$(this).tooltip({
tip: 'span.sidetip2',
effect: 'slide',
bounce: 'true',
direction: 'right',
predelay: 0,
delay: 0,
slideOffset: offset,
opacity: 0.9,
slideInSpeed: 400,
slideOutSpeed: 200,
position: 'center right'
});
}else{
var str = $(this).nextAll('span.sidetip2').text();

$(this).tooltip({
cancelDefault: true,
effect: 'slide',
bounce: 'true',
direction: 'right',
predelay: 0,
delay: 0,
slideOffset: offset,
slideInSpeed: 400,
slideOutSpeed: 200,
position: 'center right',
tipClass: 'sidetip'
});
}
}});
}
function hideSideTips2() {
$('p span.sidetip2').hide();
$('td span.sidetip2').hide();
}
