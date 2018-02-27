/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// require('./bootstrap');
// window.Vue = require('vue');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// const app = new Vue({
//     el: '#app'
// });
try {
  window.$ = window.jQuery = require('jquery');
  // require('bootstrap-sass');
} catch (e) {}
require('./admin-lte/bootstrap.min.js');
// require('./admin-lte/jquery.slimscroll.min.js');
/* Load app's javascript libraries */
require('select2');
const flatpickr = require('flatpickr');
require('input-clear-icon');
require('admin-lte/dist/js/adminlte.min.js');
/**
 * @param  {input element}
 * @return {[file handle]}
 */
 var readURL = function(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#avatar-preview').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
var restoreTab = function(tab) {
    // Restore active tab on page refresh (Bootstrap)
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
      localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
      $('#' + tab + ' a[href="' + activeTab + '"]').tab('show');
    }  
  }
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    /* Initialize Crypto-JS */
    const Base64 = require('crypto-js/enc-base64');
    const Hex = require('crypto-js/enc-hex');
    const AES = require('crypto-js/aes');
    const Uft8 = require('crypto-js/enc-utf8');
    const Lib = require('crypto-js/lib-typedarrays');
    const salt = 'i8ZGKfgqIeFVjPvnZrAMUWQdBIIVyUOr';
/**
* AES JSON formatter for CryptoJS
*
* @author BrainFooLong (bfldev.com)
* @link https://github.com/brainfoolong/cryptojs-aes-php
*/
const CryptoJSAesJson = {
  stringify: function (cipherParams) {
    var j = {ct: cipherParams.ciphertext.toString(Base64)};
    if (cipherParams.iv) j.iv = cipherParams.iv.toString();
    if (cipherParams.salt) j.s = cipherParams.salt.toString();
    return JSON.stringify(j);
  },
  parse: function (jsonStr) {
    var j = JSON.parse(jsonStr);
    var cipherParams = Lib.CipherParams.create({ciphertext: Base64.parse(j.ct)});
    if (j.iv) cipherParams.iv = Hex.parse(j.iv);
    if (j.s) cipherParams.salt = Hex.parse(j.s);
    return cipherParams;
  }
}
/**
* Encrypt a string with Crypto-JS
* @return String
*/
window.jsencrypt = function (e) {
  return AES.encrypt(JSON.stringify(e), salt, {format: CryptoJSAesJson}).toString();
}
/**
* Decrypt an encrypted string with Crypto-JS
* @return String
*/
window.jsdecrypt = function (e) {
  return JSON.parse(AES.decrypt(e, salt, {format: CryptoJSAesJson}).toString(Utf8));
}
/* Encrypt password field(s) on submit */
if ($('#encryptableform')) {
  $('#encryptableform').submit(function() {
    if (this.password.value) {
     this.password.value = jsencrypt(this.password.value);  
   }
   if (this.password_confirmation.value) {
     this.password_confirmation.value = jsencrypt(this.password_confirmation.value);
   }   
   if (this.old_password.value) {
     this.old_password.value = jsencrypt(this.old_password.value);  
   }
 });
}
// Focus the first element that has an error.
$(':input.error:first').focus();
// Automatically center on screen the input element on focus
// $(':input:not(select)').focus(function () {
  $('input:text,textarea').focus(function () {  
   var center = $(window).outerHeight() / 2;
   var top = $(this).offset().top;
   if (top > center) {
     $('html, body').animate({ scrollTop: top - center }, 'fast');            
   }
 });
// register Focusable jQuery extension
jQuery.extend(jQuery.expr[':'], {
  focusable: function (el, index, selector) {
    return $(el).is('a, button, :input, [tabindex]');
  }
});
// Disable form submit on pressing Enter key
$('.data-form').on('keypress', 'input,select', function (e) {
  if (e.which == 13) {
    e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(document.activeElement) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
      }
    });
$('.sidebar-menu').tree();
$('#logout').click(function(event) {
  event.preventDefault();
  $('#logout-form').submit();
});
$('#avatar').click(function() {
  $('#avatar-modal').modal("toggle");
});
$('#change-password').click(function() {
  $('#changepassword-modal').modal("toggle");
});
$('#avatar-input').change(function() {
  readURL(this);
});
  // Automatically dismiss alerts after several seconds
  $("#divAlertSuccess").delay(4000).fadeOut(600);
  $('.select2').select2({
    // width: 'element'
    // adaptContainerCssClass,
    // adaptDropdownCssClass
  });
  $('.datepickr').flatpickr({
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d",
    defaultDate: null
    // wrap: true
  });
  $('.timepickr').flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: "h:i K",
    minuteIncrement: 1,
    defaultDate: null
    // enableSeconds: true
    // wrap: true
  });
  $('#task').change(function(){
    var office = $('#label_from_to_office');
    var by = $('#label_by');
    if (this.value === 'I') {
      office.html('From');
      by.html('Received by<sup>*</sup>');
    }
    if (this.value === 'O') {
      office.html('To');
      by.html('Released to<sup>*</sup>');
    }
  });
  var inputAction = $('#action');
  if (inputAction.val() == '(Pending)') {
    $('#divAction').css('background', 'yellow');
    inputAction.focus();
  }
  $('#btnShowModal').click(function() {
    $('#modalConfirm').modal("show");
  });
  restoreTab('documents-tab');
  restoreTab('profile-tab');
});
