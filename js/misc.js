$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});

$(document).ready(function () {
	var url = window.location;
	$('ul.nav a[href="' + url + '"]').parent().addClass('active');
	$('ul.nav a').filter(function () {
		return this.href == url;
	}).parent().addClass('active').parent().parent().addClass('active');
});

$('img').click(function(){
	$('.selected').removeClass('selected');
	$(this).addClass('selected');
});

// toggle masked texts with readable texts
function ToggleMaskedText(a_TextFieldID)
{
  var m_DisplayedText = document.getElementById('Display' + a_TextFieldID).innerHTML;
  var m_MaskedText = document.getElementById('Masked' + a_TextFieldID).innerHTML;
  var m_ReadableText = document.getElementById('Readable' + a_TextFieldID).innerHTML;
  if (m_DisplayedText == m_MaskedText) {
    document.getElementById('Display' + a_TextFieldID).innerHTML = document.getElementById('Readable' + a_TextFieldID).innerHTML;
    document.getElementById('Button' + a_TextFieldID).textContent = 'Hide';
  } else {
    document.getElementById('Display' + a_TextFieldID).innerHTML = document.getElementById('Masked' + a_TextFieldID).innerHTML;
    document.getElementById('Button' + a_TextFieldID).textContent = 'Show';

  }
}

  $(document).ready(function(){
    $('.carousel').carousel({
      interval: 4000
    })
  });
